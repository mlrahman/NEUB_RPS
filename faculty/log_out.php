<?php
	if(isset($_REQUEST['log_out']))
	{
		ob_start();
		session_start();
		require("../includes/db_connection.php"); 
		require("../includes/function.php"); 
		
		$faculty_id=$_SESSION['faculty_id'];
		$stmt = $conn->prepare("delete from nr_faculty_link_token where nr_faculty_id=:f_id");
		$stmt->bindParam(':f_id', $faculty_id);
		$stmt->execute();
		
		$status='Inactive';
		$stmt = $conn->prepare("update nr_faculty_login_transaction set nr_falotr_status=:status where nr_faculty_id=:u_id ");
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':u_id', $faculty_id);
		$stmt->execute();
		
		unset($_SESSION['faculty_id']);
		unset($_SESSION['faculty_email']);
		unset($_SESSION['faculty_password']);
		unset($_SESSION['faculty_date']);
		unset($_SESSION['faculty_time']);
		unset($_SESSION['faculty_two_factor_status']);
		unset($_SESSION['faculty_two_factor_check']);
		unset($_SESSION['faculty_dept_id']);
		unset($_SESSION['faculty_name']);
		unset($_SESSION['otp_count']);
		unset($_SESSION['student_id']);
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