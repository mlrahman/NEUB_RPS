<?php
	if(isset($_REQUEST['log_out']))
	{
		ob_start();
		session_start();
		unset($_SESSION['faculty_id']);
		unset($_SESSION['faculty_email']);
		unset($_SESSION['faculty_password']);
		unset($_SESSION['faculty_date']);
		unset($_SESSION['faculty_time']);
		unset($_SESSION['faculty_two_factor_status']);
		unset($_SESSION['faculty_two_factor_check']);
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