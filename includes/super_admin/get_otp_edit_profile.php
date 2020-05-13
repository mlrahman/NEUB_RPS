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
	if(isset($_RESQUEST['email']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$email=trim($_REQUEST['email']);
			if(email_check($email)==false)
			{
				echo 'Error';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_admin where nr_admin_email=:email ");
			$stmt->bindParm(':email',$email);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'Error';
				die();
			}
				
			
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
			$otp=get_otp();
			//sending password recovery link to user
			$msg="Dear User, It is an auto generated email from ".$title.". This email ".$email."is set for a login access in ".$title.". Please insert the following OTP for confirmation: ".$otp." <p>&nbsp;</p><b>Note:</b> It is one time usable so be careful during the insertion, do not reload the page or insert wrong OTP. For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
			$message = '<html><body>';
			$message .= '<h1>OTP for Email Change in - '.$title.'</h1><p>  </p>';
			$message .= '<p><b>Message Details:</b></p>';
			$message .= '<p>'.$msg.'</p></body></html>';
			
			
			sent_mail($email,$title.' - OTP for Email Change',$message,$title,$contact_email);
				
			
			echo $otp;
			
			
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
		