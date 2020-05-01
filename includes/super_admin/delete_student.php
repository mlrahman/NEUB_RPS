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
	if(isset($_REQUEST['student_id']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$student_id=trim($_REQUEST['student_id']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$stmt = $conn->prepare("select nr_studi_graduated from nr_student_info where nr_stud_id=:s_id limit 1 ");
			$stmt->bindParam(':s_id', $student_id);
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
			
			$stmt = $conn->prepare("select count(nr_stud_id) from nr_result where nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll1=0;
			if(count($result)!=0)
			{
				if($result[0][0]>=1)
				{
					$flll1=1;
					echo 'unable';
					die();
				}
			}
			
			$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll2=0;
			if(count($result)!=0)
			{
				$flll2=1;
				echo 'unable';
				die();
			}
			
			
			//inserting delete history
			$stmt = $conn->prepare("select a.nr_stud_name,a.nr_stud_dob,a.nr_stud_gender,a.nr_stud_email,a.nr_stud_cell_no,a.nr_stud_photo,b.nr_studi_earned_credit,b.nr_studi_waived_credit,b.nr_studi_cgpa,c.nr_prog_title,a.nr_stud_status from nr_student a,nr_student_info b,nr_program c where a.nr_prog_id=c.nr_prog_id and a.nr_stud_id=b.nr_stud_id and a.nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$student_name=$result[0][0];
			$student_dob=$result[0][1];
			$student_gender=$result[0][2];
			$student_email=$result[0][3];
			if($student_email=="") $student_email='N/A';
			$student_mobile=$result[0][4];
			if($student_mobile=="") $student_mobile='N/A';
			$photo=$result[0][5];
			$earned_credit=$result[0][6];
			$waived_credit=$result[0][7];
			$cgpa=number_format($result[0][8],2);
			$prog_title=$result[0][9];
			$student_status=$result[0][10];
			if($photo!="")
			{
				//file delete server info required to update if needed
				$base_directory = '../../images/student/';
				unlink($base_directory.$photo);
			}
			if($student_email!='')
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
				$f_name=$student_name;
				//sending password recovery link to user
				$msg="Dear ".$f_name.", Your Student ID with ".$student_email." is removed by the admin. You can not access your result from ".$title." anymore. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Student ID Removed from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($student_email,$title.' - Student ID Removed Notification',$message,$title,$contact_email);
				
				
			}
			
			
		
			$t=get_current_time();
			$d=get_current_date();
			$task='Deleted Student Name: '.$student_name.', Student DOB: '.$student_dob.', Student Gender: '.$student_gender.', Student Email: '.$student_email.', Student Mobile: '.$student_mobile.', Earned Credit: '.$earned_credit.', Waived Credit: '.$waived_credit.', Student Status: '.$student_status;
			$stmt = $conn->prepare("insert into nr_delete_history(nr_admin_id,nr_deleteh_task,nr_deleteh_date,nr_deleteh_time,nr_deleteh_status,nr_deleteh_type) values(:admin_id,'$task','$d','$t','Active','Student') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			/***********************/
			
			$stmt = $conn->prepare("delete from nr_admin_result_check_transaction where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from nr_faculty_result_check_transaction where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_result_check_transaction where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from nr_transcript_print_reference where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_student_history where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_student_waived_credit where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_student_info where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
	
			$stmt = $conn->prepare("delete from nr_student_semester_cgpa where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from nr_student where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
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
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>