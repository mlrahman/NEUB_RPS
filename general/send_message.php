<?php
	
	if(isset($_REQUEST['y_name']) && isset($_REQUEST['y_email']) && isset($_REQUEST['y_message']))
	{
		$name=trim($_REQUEST['y_name']);
		$email=trim($_REQUEST['y_email']);
		$subject='Message From NEUB Result Portal';
		$msg=trim($_REQUEST['y_message']);
		try
		{
			ob_start();
			require("../includes/db_connection.php");
			require("../includes/function.php");
			
			$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
			$stmt->execute();
			$result_t = $stmt->fetchAll();
			
			if(count($result_t)==0)
			{
				echo 'error';
				die();
			}
			
			$title=$result_t[0][2];
			$contact_email=$result_t[0][9];
			
			$to=$contact_email;
			$from=$email;
			
			$message = '<html><body>';
			$message .= '<h1>Contact Us Message From - '.$title.'</h1><p>  </p>';
			$message .= '<p><b>Message Details:</b></p>';
			$message .= '<p>'.$msg.'</p></body></html>';
			
			sent_mail_personal($to,$from,$name,$subject,$message);
			echo 'done';
			
		}
		catch(PDOException $e)
		{
			echo 'error';
			die();
		}
		catch(Exception $e)
		{
			echo 'error';
			die();
		}
		
	}
?>