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
	if(isset($_REQUEST['result_id']) && isset($_REQUEST['result_status']) && isset($_REQUEST['result_remarks']) && isset($_REQUEST['result_marks']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$result_id=trim($_REQUEST['result_id']);
			$result_status=trim($_REQUEST['result_status']);
			$result_marks=trim($_REQUEST['result_marks']);
			$result_remarks=trim($_REQUEST['result_remarks']);
			
			
			
			
			if(get_grade($result_marks)=="N/A" || get_grade_point($result_marks)=="N/A") 
			{
				echo 'unable2';
				die();
			}
			
			
			//before update
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
			
			$data1='<p><b>Table1:</b></p><table border="2">
							<tr>
								<td style="padding:1px;"><b>Student ID</b></td>
								<td style="padding:1px;"><b>Student Name</b></td>
								<td style="padding:1px;"><b>Course Code</b></td>
								<td style="padding:1px;"><b>Course Title</b></td>
								<td style="padding:1px;"><b>Semester</b></td>
								<td style="padding:1px;"><b>Grade</b></td>
								<td style="padding:1px;"><b>Grade Point</b></td>
								<td style="padding:1px;"><b>Remarks</b></td>
							</tr>
							<tr>
								<td style="padding:1px;">'.$reg_no.'</td>
								<td style="padding:1px;">'.$name.'</td>
								<td style="padding:1px;">'.$course_code.'</td>
								<td style="padding:1px;">'.$course_title.'</td>
								<td style="padding:1px;">'.$course_semester.'</td>
								<td style="padding:1px;">'.$course_grade.'</td>
								<td style="padding:1px;">'.number_format($course_grade_point,2).'</td>
								<td style="padding:1px;">'.$course_remarks.'</td>
							</tr>
						</table>';
			
			
			$course_marks=marks_encrypt($reg_no,$result_marks);
			$course_grade=grade_encrypt($reg_no,get_grade($result_marks));
			$course_grade_point=grade_point_encrypt($reg_no,get_grade_point($result_marks));
			
			
			$stmt = $conn->prepare("update nr_result set nr_result_grade=:grade,nr_result_marks=:marks,nr_result_grade_point=:grade_point,nr_result_status=:status,nr_result_remarks=:remarks where nr_result_id=:result_id");
			$stmt->bindParam(':grade', $course_grade);
			$stmt->bindParam(':marks', $course_marks);
			$stmt->bindParam(':grade_point', $course_grade_point);
			$stmt->bindParam(':status', $result_status);
			$stmt->bindParam(':remarks', $result_remarks);
			$stmt->bindParam(':result_id', $result_id);
			$stmt->execute();
			
			//after update
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
			$student_status=$result[0][42];
			$prcr_id=$result[0][41];
			
			$data2='<p><b>Table2:</b></p><table border="2">
							<tr>
								<td style="padding:1px;"><b>Student ID</b></td>
								<td style="padding:1px;"><b>Student Name</b></td>
								<td style="padding:1px;"><b>Course Code</b></td>
								<td style="padding:1px;"><b>Course Title</b></td>
								<td style="padding:1px;"><b>Semester</b></td>
								<td style="padding:1px;"><b>Grade</b></td>
								<td style="padding:1px;"><b>Grade Point</b></td>
								<td style="padding:1px;"><b>Remarks</b></td>
							</tr>
							<tr>
								<td style="padding:1px;">'.$reg_no.'</td>
								<td style="padding:1px;">'.$name.'</td>
								<td style="padding:1px;">'.$course_code.'</td>
								<td style="padding:1px;">'.$course_title.'</td>
								<td style="padding:1px;">'.$course_semester.'</td>
								<td style="padding:1px;">'.$course_grade.'</td>
								<td style="padding:1px;">'.number_format($course_grade_point,2).'</td>
								<td style="padding:1px;">'.$course_remarks.'</td>
							</tr>
						</table>';
						
						
			if($student_email!='' && $student_status=='Active' && $result_status=='Active')
			{

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
				$msg="Dear ".$f_name.", Your result with the mentioned details in the table1 has updated with the table2 details by the admin in ".$title.". You can check it from ".$title." student panel. ".$data1.$data2." <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Result Updated in - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($student_email,$title.' - Result Updated Notification',$message,$title,$contact_email);
				


			}				
			
			
			
			$stmt = $conn->prepare("select b.nr_prog_title from nr_student a,nr_program b where a.nr_stud_id=:student_id and a.nr_prog_id=b.nr_prog_id ");
			$stmt->bindParam(':student_id', $reg_no);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$prog_title=$result[0][0];
			
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
			
			
			$task='Updated Result Student ID: '.$reg_no.', Student Name: '.$name.', Program: '.$prog_title.', Course Code: '.$course_code.', Course Title: '.$course_title.', Semester: '.$course_semester.', Marks: '.$course_marks.', Grade: '.$course_grade.', Grade Point: '.number_format($course_grade_point,2).', Remarks: '.$course_remarks.', Course Instructor: '.$course_instructor.', Instructor Designation: '.$course_instructor_designation.', Department of '.$course_instructor_department.', Result Status: '.$result_status;
			$stmt = $conn->prepare("insert into nr_result_history(nr_result_id,nr_admin_id,nr_resulth_task,nr_resulth_date,nr_resulth_time,nr_resulth_status) values(:result_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->bindParam(':result_id', $result_id);
			$stmt->execute();
			
			$cg=get_student_semester_cgpa($reg_no,$s,$y);
			if($cg=='N/A') $cg=0.00;
			$stmt = $conn->prepare("update nr_student_semester_cgpa set nr_studsc_cgpa='$cg', nr_studsc_publish_date='$d' where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
			$stmt->bindParam(':student_id', $reg_no);
			$stmt->bindParam(':sem', $s);
			$stmt->bindParam(':yea', $y);
			$stmt->execute();
					
			
			
			echo 'Ok';
			
			
		}
		catch(PDOException $e)
		{
			echo 'Error';
			die();
		}
		catch(Exception $e)
		{
			echo 'Error';
			die();
		}

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred!!"> Network Error Occurred</i>';
	}
?>