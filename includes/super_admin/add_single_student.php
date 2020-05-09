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
	if(isset($_REQUEST['pass']) && isset($_REQUEST['student_status']) && isset($_REQUEST['student_gender']) && isset($_REQUEST['student_birth_date']) && isset($_REQUEST['student_id']) && isset($_REQUEST['student_name']) && isset($_REQUEST['student_email']) && isset($_REQUEST['student_mobile']) && isset($_REQUEST['student_prog']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$student_id=trim($_REQUEST['student_id']);
			$student_name=trim($_REQUEST['student_name']);
			$student_email=trim($_REQUEST['student_email']);
			$student_mobile=trim($_REQUEST['student_mobile']);
			$student_prog=trim($_REQUEST['student_prog']);
			$student_birth_date=trim($_REQUEST['student_birth_date']);
			$student_gender=trim($_REQUEST['student_gender']);
			$student_status=trim($_REQUEST['student_status']);
			
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			//checking if student is add able or not
			$stmt = $conn->prepare("select * from nr_student where ((nr_stud_id=:student_id) or (nr_stud_email!='' and nr_stud_email=:student_email) or (nr_stud_name=:student_name and nr_stud_dob=:student_birth_date and nr_stud_gender=:student_gender and nr_prog_id=:student_prog))");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':student_email', $student_email);
			$stmt->bindParam(':student_name', $student_name);
			$stmt->bindParam(':student_birth_date', $student_birth_date);
			$stmt->bindParam(':student_gender', $student_gender);
			$stmt->bindParam(':student_prog', $student_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			//checking if prog is active or not
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=:student_prog and nr_prog_status='Inactive' ");
			$stmt->bindParam(':student_prog', $student_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable2';
				die();
			}
			
			
			//getting new program credit id
			$stmt = $conn->prepare("select nr_prcr_id from nr_program_credit where nr_prog_id=:prog_id and nr_prcr_status='Active' and nr_prcr_ex_date='' order by nr_prcr_id desc limit 1");
			$stmt->bindParam(':prog_id', $student_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'Error';
				die();
			}
			$prcr_id=$result[0][0];
			
			
			if($student_email!='' && email_check($student_email)==false)
			{
				echo 'unable3';
				die();
			}
			
			if(strlen($student_id)!=12)
			{
				echo 'unable4';
				die();
			}
			
			if($student_email!='' && $student_status=='Active')
			{
				$stmt = $conn->prepare("select * from nr_student where nr_stud_email=:email limit 1");
				$stmt->bindParam(':email', $student_email);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)>0)
				{
					echo 'unable5';
					die();
				}
				
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
				$msg="Dear ".$f_name.", Welcome to ".$title." student panel service. Your email ".$student_email." is set for the notification and two factor authentication(2FA) service in ".$title.". You will get all the updates and OTPs for 2FA of your Student ID: ".$student_id." from ".$title." using this email. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Email Registered for Notification and 2FA from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($student_email,$title.' - Email Registered for Notification and 2FA',$message,$title,$contact_email);
				
			}
			
			
			
			$stmt = $conn->prepare("insert into nr_student (nr_stud_id, nr_stud_name, nr_stud_dob, nr_stud_email, nr_stud_cell_no, nr_prog_id, nr_prcr_id, nr_stud_gender, nr_stud_status) values(:student_id,:student_name,:student_birth_date,:student_email,:student_mobile,:student_prog,:prcr_id,:student_gender,:student_status) ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':student_name', $student_name);
			$stmt->bindParam(':student_birth_date', $student_birth_date);
			$stmt->bindParam(':student_email', $student_email);
			$stmt->bindParam(':student_mobile', $student_mobile);
			$stmt->bindParam(':student_prog', $student_prog);
			$stmt->bindParam(':prcr_id', $prcr_id);
			$stmt->bindParam(':student_gender', $student_gender);
			$stmt->bindParam(':student_status', $student_status);
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
			$t=get_current_time();
			$d=get_current_date();
			
			$stmt = $conn->prepare("insert into nr_student_info (nr_stud_id, nr_studi_dropout, nr_studi_graduated, nr_studi_cgpa, nr_studi_last_semester, nr_studi_last_year, nr_studi_publish_date, nr_studi_status, nr_studi_drop_semester, nr_studi_drop_year, nr_studi_earned_credit, nr_studi_waived_credit) values (:student_id,:dropout,:graduated,:cgpa,:last_semester,:last_year,'$d','Active',:drop_semester,:drop_year,:earned_credit,:waived_credit) ");
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
			$task='Added Student Name: '.$student_name.', Student DOB: '.$student_birth_date.', Student Gender: '.$student_gender.', Student Email: '.$student_email.', Student Mobile: '.$student_mobile.', Student Program: '.$prog_title.', Student CGPA: '.number_format($cgpa,2).', Earned Credit: '.$earned_credit.', Waived Credit: '.$waived_credit.', Student Status: '.$student_status;
			$stmt = $conn->prepare("insert into nr_student_history(nr_stud_id,nr_admin_id,nr_studh_task,nr_studh_date,nr_studh_time,nr_studh_status) values(:student_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
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