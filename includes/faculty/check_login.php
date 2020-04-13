<?php
	session_start();
	require("../db_connection.php"); 
	if(isset($_REQUEST['login_check']) && isset($_REQUEST['faculty_id']) && trim($_REQUEST['faculty_id'])==$_SESSION['faculty_id'] && isset($_SESSION['faculty_email']) && isset($_SESSION['faculty_password']) && isset($_SESSION['faculty_time']) && isset($_SESSION['faculty_date']) && isset($_SESSION['faculty_two_factor_status']) && isset($_SESSION['faculty_two_factor_check']) && isset($_SESSION['faculty_name']))
	{
		$faculty_id=$_SESSION['faculty_id'];
		$faculty_email=$_SESSION['faculty_email'];
		$faculty_password=$_SESSION['faculty_password'];
		$faculty_time=$_SESSION['faculty_time'];
		$faculty_date=$_SESSION['faculty_date'];
		
		$stmt = $conn->prepare("select * from nr_faculty_login_transaction where nr_faculty_id=:faculty_id and nr_falotr_time=:faculty_time and nr_falotr_date=:faculty_date and nr_falotr_status='Active' ");
		$stmt->bindParam(':faculty_id', $faculty_id);
		$stmt->bindParam(':faculty_date', $faculty_date);
		$stmt->bindParam(':faculty_time', $faculty_time);
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
			unset($_SESSION['faculty_id']);
			unset($_SESSION['faculty_email']);
			unset($_SESSION['faculty_password']);
			unset($_SESSION['faculty_date']);
			unset($_SESSION['faculty_time']);
			unset($_SESSION['faculty_two_factor_status']);
			unset($_SESSION['faculty_two_factor_check']);
			unset($_SESSION['faculty_name']);
			unset($_SESSION['faculty_type']);
			unset($_SESSION['otp_count']);
			echo 'Error';
			die();
		}
		
	}
	else
	{
		$_SESSION['error']='Session destroyed please login again.';
		unset($_SESSION['faculty_id']);
		unset($_SESSION['faculty_email']);
		unset($_SESSION['faculty_password']);
		unset($_SESSION['faculty_date']);
		unset($_SESSION['faculty_time']);
		unset($_SESSION['faculty_two_factor_status']);
		unset($_SESSION['faculty_two_factor_check']);
		unset($_SESSION['faculty_name']);
		unset($_SESSION['faculty_type']);
		unset($_SESSION['otp_count']);
		echo 'Error';
		die();
	}
?>