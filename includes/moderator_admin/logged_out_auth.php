<?php

	//checking logged in or not
	try{
		if(isset($_SESSION['moderator_id']) && isset($_SESSION['moderator_email']) && isset($_SESSION['moderator_password']) && isset($_SESSION['moderator_time']) && isset($_SESSION['moderator_date']) && isset($_SESSION['moderator_two_factor_status']) && isset($_SESSION['moderator_two_factor_check']) && isset($_SESSION['moderator_name']))
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
				$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:moderator_id and nr_admin_email=:moderator_email and nr_admin_password=:moderator_password and nr_admin_status='Active' and nr_admin_type='Moderator' ");
				$stmt->bindParam(':moderator_id', $moderator_id);
				$stmt->bindParam(':moderator_email', $moderator_email);
				$stmt->bindParam(':moderator_password', $moderator_password);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==0){
					
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
					header("location: index.php");
					die();
				}
			}
			else
			{
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
				header("location: index.php");
				die();
			}
		}
		else
		{
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
			header("location: index.php");
			die();
		}				
	}
	catch(Exception $e)
	{
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
		header("location: index.php");
		die();
	}
?>