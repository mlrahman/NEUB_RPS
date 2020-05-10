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
	if(isset($_REQUEST['student_id']) && isset($_REQUEST['student_waive_course']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$pass=trim($_REQUEST['pass']);
			$student_waive_course=trim($_REQUEST['student_waive_course']);
			$student_id=trim($_REQUEST['student_id']);
				
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_course where nr_course_id=:student_waive_course and (nr_course_status='Inactive' or nr_course_id in (select nr_course_id from nr_result where nr_stud_id=:student_id)) ");
			$stmt->bindParam(':student_waive_course', $student_waive_course);
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_course where nr_course_id=:course_id and nr_course_status='Inactive'");
			$stmt->bindParam(':course_id', $student_waive_course);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_course where nr_course_id=:course_id ");
			$stmt->bindParam(':course_id', $student_waive_course);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'unable';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:student_id and nr_prog_id in (select nr_prog_id from nr_course where nr_course_id=:course_id)");
			$stmt->bindParam(':course_id', $student_waive_course);
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'unable';
				die();
			}
			
			
			$stmt = $conn->prepare("select nr_studi_graduated from nr_student_info where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				if($result[0][0]==1)
				{
					echo 'unable';
					die();
				}
			}
			else
			{
				echo 'Error';
				die();
			}
			
			
			$stmt = $conn->prepare("select nr_prcr_id,nr_stud_email,nr_stud_cell_no,nr_stud_name,nr_stud_dob,nr_stud_gender,nr_stud_status from nr_student where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$prcr_id = $result[0][0];
			$student_email=$result[0][1];
			$student_mobile=$result[0][2];
			$student_name=$result[0][3];
			$student_birth_date=$result[0][4];
			$student_gender=$result[0][5];
			$student_status=$result[0][6];
			
			
			//sending notification to student
			if($student_email!='' && $student_status=='Active')
			{
				
				$stmt = $conn->prepare("select nr_course_code,nr_course_title,nr_course_credit from nr_course where nr_course_id=:course_id ");
				$stmt->bindParam(':course_id', $student_waive_course);
				$stmt->execute();
				$result = $stmt->fetchAll();
				$course_code=$result[0][0];
				$course_title=$result[0][1];
				$course_credit=$result[0][2];
				
				$data='<table border="2">
							<tr>
								<td style="padding:1px;"><b>Student ID</b></td>
								<td style="padding:1px;"><b>Student Name</b></td>
								<td style="padding:1px;"><b>Course Code</b></td>
								<td style="padding:1px;"><b>Course Title</b></td>
								<td style="padding:1px;"><b>Course Credit</b></td>
							</tr>
							<tr>
								<td style="padding:1px;">'.$student_id.'</td>
								<td style="padding:1px;">'.$student_name.'</td>
								<td style="padding:1px;">'.$course_code.'</td>
								<td style="padding:1px;">'.$course_title.'</td>
								<td style="padding:1px;">'.number_format($course_credit,2).'</td>
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
				$f_name=$student_name;
				//sending password recovery link to user
				$msg="Dear ".$f_name.", One waived course is added in your student ID: ".$student_id.". Please check the mentioned details in the table. You can check it from ".$title." student panel. ".$data." <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Waived Course Added in - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($student_email,$title.' - Waived Course Added Notification',$message,$title,$contact_email);
				


			}
			
			$t=get_current_time();
			$d=get_current_date();
			
			$stmt = $conn->prepare("insert into nr_student_waived_credit(nr_stud_id,nr_course_id,nr_stwacr_date,nr_stwacr_status) values(:student_id,:student_waive_course,'$d','Active')");
			$stmt->bindParam(':student_waive_course', $student_waive_course);
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			
			$x=get_student_info($student_id,$prcr_id);
			$dropout=$x['dropout'];
			$graduated=$x['graduated'];
			$cgpa=$x['cgpa'];
			$last_semester=$x['last_semester'];
			$last_year=$x['last_year'];
			$drop_semester=$x['drop_semester'];
			$drop_year=$x['drop_year'];
			$earned_credit=$x['earned_credit'];
			$waived_credit=$x['waived_credit'];
			
			$stmt = $conn->prepare("update nr_student_info set nr_studi_dropout=:dropout, nr_studi_graduated=:graduated, nr_studi_cgpa=:cgpa,nr_studi_last_semester=:last_semester,nr_studi_last_year=:last_year,nr_studi_publish_date='$d',nr_studi_status='Active', nr_studi_drop_semester=:drop_semester,nr_studi_drop_year=:drop_year,nr_studi_earned_credit=:earned_credit,nr_studi_waived_credit=:waived_credit where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
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
			
			
			$stmt = $conn->prepare("select b.nr_prog_title from nr_student a,nr_program b where a.nr_stud_id=:student_id and a.nr_prog_id=b.nr_prog_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$prog_title=$result[0][0];
			
			
			if($student_email=='') $student_email='N/A';
			if($student_mobile=='') $student_mobile='N/A';
			$task='Edited Student Name: '.$student_name.', Student DOB: '.$student_birth_date.', Student Gender: '.$student_gender.', Student Email: '.$student_email.', Student Mobile: '.$student_mobile.', Student Program: '.$prog_title.', Student CGPA: '.number_format($cgpa,2).', Earned Credit: '.$earned_credit.', Waived Credit: '.$waived_credit.', Student Status: '.$student_status;
			$stmt = $conn->prepare("insert into nr_student_history(nr_stud_id,nr_admin_id,nr_studh_task,nr_studh_date,nr_studh_time,nr_studh_status) values(:student_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			echo 'Ok';
		}
		catch(Exception $e)
		{
			echo 'Error';
			die();
		}
	
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>
		