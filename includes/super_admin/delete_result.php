<?php
	session_start();
	require("../db_connection.php"); 
	require("../function.php"); 
	try{
		require("logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	if(isset($_REQUEST['result_id']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$result_id=trim($_REQUEST['result_id']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$stmt = $conn->prepare("select nr_studi_graduated from nr_student_info where nr_stud_id=(select nr_stud_id from nr_result where nr_result_id=:r_id) limit 1 ");
			$stmt->bindParam(':r_id', $result_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll=0;
			if(count($result)!=0)
			{
				$flll=$result[0][0];
				if($flll==1)
				{
					echo 'unable';
					die();
				}
			}
			
			$stmt = $conn->prepare("select * from nr_result a,nr_course b, nr_faculty c, nr_student d, nr_department e where a.nr_course_id=b.nr_course_id and a.nr_faculty_id=c.nr_faculty_id and a.nr_stud_id=d.nr_stud_id and a.nr_result_id=:r_id and c.nr_dept_id=e.nr_dept_id limit 1 ");
			$stmt->bindParam(':r_id', $result_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'Error';
				die();
			}				
			$photo=$result[0][39];
			$gender=$result[0][36];
			$name=$result[0][34];
			$reg_no=$result[0][33];
			$session=get_session($reg_no);
			$birthdate=$result[0][35];
			$course_code=$result[0][14];
			$course_title=$result[0][15];
			$course_credit=$result[0][16];
			$s=$result[0][6];
			$y=$result[0][7];
			$course_semester=$result[0][6].' '.$result[0][7];
			$course_marks=marks_decrypt($reg_no,$result[0][3]);
			$course_grade=grade_decrypt($reg_no,$result[0][4]);
			$course_grade_point=grade_point_decrypt($reg_no,$result[0][5]);
			$course_remarks=$result[0][8];
			$course_instructor=$result[0][20];
			$course_instructor_designation=$result[0][21];
			$course_instructor_type=$result[0][24];
			$course_instructor_department=$result[0][44];
			$course_publish=get_date($result[0][11]);
			$status=$result[0][9];
			$student_email=$result[0][37];
			$prcr_id=$result[0][41];
			$stmt = $conn->prepare("select b.nr_prog_title from nr_student a,nr_program b where a.nr_stud_id=:student_id and a.nr_prog_id=b.nr_prog_id ");
			$stmt->bindParam(':student_id', $reg_no);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$prog_title=$result[0][0];
			
			if($student_email!='')
			{
				$data='<table border="2">
							<tr>
								<td><b>Student ID</b></td>
								<td><b>Student Name</b></td>
								<td><b>Course Code</b></td>
								<td><b>Course Title</b></td>
								<td><b>Semester</b></td>
								<td><b>Grade</b></td>
								<td><b>Grade Point</b></td>
								<td><b>Remarks</b></td>
							</tr>
							<tr>
								<td>'.$reg_no.'</td>
								<td>'.$name.'</td>
								<td>'.$course_code.'</td>
								<td>'.$course_title.'</td>
								<td>'.$course_semester.'</td>
								<td>'.$course_grade.'</td>
								<td>'.$course_grade_point.'</td>
								<td>'.$course_remarks.'</td>
							</tr>
						</table>';
				//sent email with password reset link
				$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==0)
				{
					echo 'System not ready';
					die();
				}
				$title=$result[0][2];
				$contact_email=$result[0][9];//for sending message from contact us form
				$f_name=$name;
				//sending password recovery link to user
				$msg="Dear ".$f_name.", Your result with the mentioned details in the table has removed by the admin from ".$title.". You can not access this mentioned result from ".$title." anymore. ".$data." <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Result Removed from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($student_email,$title.' - Result Removed Notification',$message,$title,$contact_email);
				
				
			}
			
			
		
			$t=get_current_time();
			$d=get_current_date();
			$task='Deleted Result Student ID: '.$reg_no.', Student Name: '.$name.', Program: '.$prog_title.', Course Code: '.$course_code.', Course Title: '.$course_title.', Semester: '.$course_semester.', Marks: '.$course_marks.', Grade: '.$course_grade.', Grade Point: '.$course_grade_point.', Course Instructor: '.$course_instructor.', Instructor Designation: '.$course_instructor_designation.', Department of '.$course_instructor_department;
			$stmt = $conn->prepare("insert into nr_delete_history(nr_admin_id,nr_deleteh_task,nr_deleteh_date,nr_deleteh_time,nr_deleteh_status,nr_deleteh_type) values(:admin_id,'$task','$d','$t','Active','Result') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			/***********************/
			
			$stmt = $conn->prepare("delete from nr_result_history where nr_result_id=:result_id ");
			$stmt->bindParam(':result_id', $result_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_result where nr_result_id=:result_id ");
			$stmt->bindParam(':result_id', $result_id);
			$stmt->execute();


			$x=get_student_info($reg_no,$prcr_id);
			$dropout=$x['dropout'];
			$graduated=$x['graduated'];
			$cgpa=$x['cgpa'];
			$last_semester=$x['last_semester'];
			$last_year=$x['last_year'];
			$drop_semester=$x['drop_semester'];
			$drop_year=$x['drop_year'];
			$earned_credit=$x['earned_credit'];
			$waived_credit=$x['waived_credit'];
			$t=get_current_time();
			$d=get_current_date();
			
			$stmt = $conn->prepare("update nr_student_info set nr_studi_dropout=:dropout, nr_studi_graduated=:graduated, nr_studi_cgpa=:cgpa,nr_studi_last_semester=:last_semester,nr_studi_last_year=:last_year,nr_studi_publish_date='$d',nr_studi_status='Active', nr_studi_drop_semester=:drop_semester,nr_studi_drop_year=:drop_year,nr_studi_earned_credit=:earned_credit,nr_studi_waived_credit=:waived_credit where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $reg_no);
			$stmt->bindParam(':dropout', $dropout);
			$stmt->bindParam(':graduated', $graduated);
			$stmt->bindParam(':cgpa', $cgpa);
			$stmt->bindParam(':last_semester', $last_semester);
			$stmt->bindParam(':last_year', $last_year);
			$stmt->bindParam(':drop_semester', $drop_semester);
			$stmt->bindParam(':drop_year', $drop_year);
			$stmt->bindParam(':earned_credit', $earned_credit);
			$stmt->bindParam(':waived_credit', $waived_credit);
			$stmt->execute();
			
			$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:student_id and nr_result_semester=:sem and nr_result_year=:yea");
			$stmt->bindParam(':student_id', $reg_no);
			$stmt->bindParam(':sem', $s);
			$stmt->bindParam(':yea', $y);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				$stmt = $conn->prepare("delete from nr_student_semester_cgpa where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
				$stmt->bindParam(':student_id', $reg_no);
				$stmt->bindParam(':sem', $s);
				$stmt->bindParam(':yea', $y);
				$stmt->execute();
			}
			else
			{
			
				$cg=get_student_semester_cgpa($reg_no,$s,$y);
				if($cg=='N/A') $cg=0.00;
				$stmt = $conn->prepare("update nr_student_semester_cgpa set nr_studsc_cgpa='$cg' where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
				$stmt->bindParam(':student_id', $reg_no);
				$stmt->bindParam(':sem', $s);
				$stmt->bindParam(':yea', $y);
				$stmt->execute();
					
			}
			
			echo 'Ok';
			
		}
		catch(PDOException $e)
		{
			echo $e.'Error';
			die();
		}
		catch(Exception $e)
		{
			echo $e.'Error';
			die();
		}
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>