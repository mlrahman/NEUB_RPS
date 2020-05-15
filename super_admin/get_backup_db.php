<?php
	session_start();
	require("../includes/db_connection.php"); 
	require("../includes/function.php"); 
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	if(isset($_SESSION['admin_id']) && isset($_SESSION['admin_type']) && isset($_REQUEST['db_backup']) && $_SESSION['admin_type']=='Super Admin' && $_REQUEST['db_backup']=='yes')
	{
		EXPORT_DATABASE($servername,$username,$password,$database);
		
		
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
		
		
		
		
		$email='mirlutfur.rahman@gmail.com';
		
		$msg="Dear User, A database backup file downloaded from ".$title.". Downloaded By: ".$_SESSION['admin_name']." (".$_SESSION['admin_email']."), Date: ".get_date(get_current_date()).", Time: ".get_current_time();
		$message = '<html><body>';
		$message .= '<h1>DB Backup Notification from - '.$title.'</h1><p>  </p>';
		$message .= '<p><b>Message Details:</b></p>';
		$message .= '<p>'.$msg.'</p></body></html>';
		
		
		sent_mail($email,$title.' - DB Backup Notification',$message,$title,$contact_email);
		
		
		$email='mlrahman@neub.edu.bd';
		
		$msg="Dear User, A database backup file downloaded from ".$title.". Downloaded By: ".$_SESSION['admin_name']." (".$_SESSION['admin_email']."), Date: ".get_date(get_current_date()).", Time: ".get_current_time();
		$message = '<html><body>';
		$message .= '<h1>DB Backup Notification from - '.$title.'</h1><p>  </p>';
		$message .= '<p><b>Message Details:</b></p>';
		$message .= '<p>'.$msg.'</p></body></html>';
		
		
		sent_mail($email,$title.' - DB Backup Notification',$message,$title,$contact_email);
		
		
		$email=$_SESSION['admin_email'];
		
		$msg="Dear User, A database backup file downloaded from ".$title.". Downloaded By: ".$_SESSION['admin_name']." (".$_SESSION['admin_email']."), Date: ".get_date(get_current_date()).", Time: ".get_current_time();
		$message = '<html><body>';
		$message .= '<h1>DB Backup Notification from - '.$title.'</h1><p>  </p>';
		$message .= '<p><b>Message Details:</b></p>';
		$message .= '<p>'.$msg.'</p></body></html>';
		
		
		sent_mail($email,$title.' - DB Backup Notification',$message,$title,$contact_email);
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>