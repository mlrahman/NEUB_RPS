<?php
	if(isset($_GET['s_id']) && isset($_GET['dob']) && isset($_GET['email']))
	{
		$s_id=$_GET['s_id'];
		$dob=$_GET['dob'];
		$email=$_GET['email'];
		ob_start();
		require("../includes/db_connection.php");
		require("../includes/function.php");
		try{
			
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id and nr_stud_dob=:dob and nr_stud_status='Active' limit 1 ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':dob', $dob);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if(count($result)==0)
			{
				echo 'not_done';
				die();
			}
			else if(email_check($email)==false)
			{
				echo 'email_error';
				die();
			}
			else
			{
				$stmt = $conn->prepare("update nr_student set nr_stud_email=:email where nr_stud_id=:s_id and nr_stud_dob=:dob ");
				$stmt->bindParam(':s_id', $s_id);
				$stmt->bindParam(':dob', $dob);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
				
				//sending email 
				$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
				$stmt->execute();
				$result2 = $stmt->fetchAll();
				if(count($result2)==0)
				{
					echo 'System not ready';
					die();
				}
				$title=$result2[0][2];
				$contact_email=$result2[0][9];
				
				$f_name=$result[0][1];
				$student_email=$email;
				
				$msg="Dear ".$f_name.", Welcome to ".$title." student panel service. Your eamil ".$student_email." is set for the notification and two factor authentication(2FA) service in ".$title.". You will get all the updates and OTPs for 2FA of your Student ID: ".$s_id." from ".$title." using this email. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Email Registered for Notification and 2FA from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				sent_mail($student_email,$title.' - Email Registered for Notification and 2FA',$message,$title,$contact_email);
				
				echo 'done';
			}
		}
		catch(Exception $e)
		{
			echo 'not_done';
			die();
		}
		
	}
	else
		header("location: index.php");
?>
		
