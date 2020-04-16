<?php
	if(isset($_REQUEST['log_out']))
	{
		ob_start();
		session_start();
		require("../includes/db_connection.php"); 
		require("../includes/function.php"); 
		
		$admin_id=$_SESSION['admin_id'];
		$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:sa_id");
		$stmt->bindParam(':sa_id', $admin_id);
		$stmt->execute();
		
		$status='Inactive';
		$stmt = $conn->prepare("update nr_admin_login_transaction set nr_suadlotr_status=:status where nr_admin_id=:u_id ");
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':u_id', $admin_id);
		$stmt->execute();
		
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_email']);
		unset($_SESSION['admin_password']);
		unset($_SESSION['admin_date']);
		unset($_SESSION['admin_time']);
		unset($_SESSION['admin_two_factor_status']);
		unset($_SESSION['admin_two_factor_check']);
		unset($_SESSION['admin_type']);
		unset($_SESSION['admin_name']);
		unset($_SESSION['otp_count2']);
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