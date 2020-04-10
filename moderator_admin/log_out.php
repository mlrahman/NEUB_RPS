<?php
	if(isset($_REQUEST['log_out']))
	{
		ob_start();
		session_start();
		require("../includes/db_connection.php"); 
		require("../includes/function.php"); 
		
		$moderator_id=$_SESSION['moderator_id'];
		$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:sa_id");
		$stmt->bindParam(':sa_id', $moderator_id);
		$stmt->execute();
		
		unset($_SESSION['moderator_id']);
		unset($_SESSION['moderator_email']);
		unset($_SESSION['moderator_password']);
		unset($_SESSION['moderator_date']);
		unset($_SESSION['moderator_time']);
		unset($_SESSION['moderator_two_factor_status']);
		unset($_SESSION['moderator_two_factor_check']);
		unset($_SESSION['moderator_type']);
		unset($_SESSION['moderator_name']);
		unset($_SESSION['otp_count3']);
		session_write_close();
		header("location: index.php");
		die();
	}
	else
	{
		header("location: index.php");
		die();
	}
?>