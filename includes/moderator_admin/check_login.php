<?php
	session_start();
	require("../db_connection.php"); 
	if(isset($_REQUEST['login_check']) && isset($_REQUEST['moderator_id']) && trim($_REQUEST['moderator_id'])==$_SESSION['moderator_id'] && isset($_SESSION['moderator_email']) && isset($_SESSION['moderator_password']) && isset($_SESSION['moderator_time']) && isset($_SESSION['moderator_date']) && isset($_SESSION['moderator_two_factor_status']) && isset($_SESSION['moderator_two_factor_check']) && isset($_SESSION['moderator_name']))
	{
		$moderator_id=$_SESSION['moderator_id'];
		$moderator_email=$_SESSION['moderator_email'];
		$moderator_password=$_SESSION['moderator_password'];
		$moderator_time=$_SESSION['moderator_time'];
		$moderator_date=$_SESSION['moderator_date'];
		
		$stmt = $conn->prepare("select * from nr_admin_login_transaction where nr_admin_id=:moderator_id and nr_suadlotr_time=:moderator_time and nr_suadlotr_date=:moderator_date and nr_suadlotr_status='Active' ");
		$stmt->bindParam(':moderator_id', $moderator_id);
		$stmt->bindParam(':moderator_date', $moderator_date);
		$stmt->bindParam(':moderator_time', $moderator_time);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			echo 'Ok';
			die();
		}
		else
		{
			$_SESSION['error']='Session destroyed please login again.';
			unset($_SESSION['moderator_id']);
			unset($_SESSION['moderator_email']);
			unset($_SESSION['moderator_password']);
			unset($_SESSION['moderator_date']);
			unset($_SESSION['moderator_time']);
			unset($_SESSION['moderator_two_factor_status']);
			unset($_SESSION['moderator_two_factor_check']);
			unset($_SESSION['moderator_name']);
			unset($_SESSION['moderator_type']);
			unset($_SESSION['otp_count3']);
			echo 'Error';
			die();
		}
		
	}
	else
	{
		$_SESSION['error']='Session destroyed please login again.';
		unset($_SESSION['moderator_id']);
		unset($_SESSION['moderator_email']);
		unset($_SESSION['moderator_password']);
		unset($_SESSION['moderator_date']);
		unset($_SESSION['moderator_time']);
		unset($_SESSION['moderator_two_factor_status']);
		unset($_SESSION['moderator_two_factor_check']);
		unset($_SESSION['moderator_name']);
		unset($_SESSION['moderator_type']);
		unset($_SESSION['otp_count3']);
		echo 'Error';
		die();
	}
?>