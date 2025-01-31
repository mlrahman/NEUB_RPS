<?php

	//checking logged in or not
	
	try{
		if(isset($_SESSION['admin_id']) && isset($_SESSION['admin_email']) && isset($_SESSION['admin_password']) && isset($_SESSION['admin_time']) && isset($_SESSION['admin_date']) && isset($_SESSION['admin_two_factor_status']) && isset($_SESSION['admin_two_factor_check']) && isset($_SESSION['admin_name']))
		{
			$admin_id=$_SESSION['admin_id'];
			$admin_email=$_SESSION['admin_email'];
			$admin_password=$_SESSION['admin_password'];
			$admin_time=$_SESSION['admin_time'];
			$admin_date=$_SESSION['admin_date'];
			$stmt = $conn->prepare("select * from nr_admin_login_transaction where nr_admin_id=:admin_id and nr_suadlotr_time=:admin_time and nr_suadlotr_date=:admin_date and nr_suadlotr_status='Active' ");
			$stmt->bindParam(':admin_id', $admin_id);
			$stmt->bindParam(':admin_date', $admin_date);
			$stmt->bindParam(':admin_time', $admin_time);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:admin_id and nr_admin_email=:admin_email and nr_admin_password=:admin_password and nr_admin_status='Active' and (nr_admin_type='Admin' or nr_admin_type='Super Admin') ");
				$stmt->bindParam(':admin_id', $admin_id);
				$stmt->bindParam(':admin_email', $admin_email);
				$stmt->bindParam(':admin_password', $admin_password);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==1){
					//redirecting logged in page
					header("location: sa_index.php");
				}
				else{
					unset($_SESSION['admin_id']);
					unset($_SESSION['admin_email']);
					unset($_SESSION['admin_password']);
					unset($_SESSION['admin_date']);
					unset($_SESSION['admin_time']);
					unset($_SESSION['admin_two_factor_status']);
					unset($_SESSION['admin_two_factor_check']);
					unset($_SESSION['admin_name']);
					unset($_SESSION['admin_type']);
					unset($_SESSION['otp_count2']);
					header("location: index.php");
					die();
				}
			}
			else
			{
				unset($_SESSION['admin_id']);
				unset($_SESSION['admin_email']);
				unset($_SESSION['admin_password']);
				unset($_SESSION['admin_date']);
				unset($_SESSION['admin_time']);
				unset($_SESSION['admin_two_factor_status']);
				unset($_SESSION['admin_two_factor_check']);
				unset($_SESSION['admin_name']);
				unset($_SESSION['admin_type']);
				unset($_SESSION['otp_count2']);
				header("location: index.php");
				die();
			}
		}
	}
	catch(Exception $e)
	{
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_email']);
		unset($_SESSION['admin_password']);
		unset($_SESSION['admin_date']);
		unset($_SESSION['admin_time']);
		unset($_SESSION['admin_two_factor_status']);
		unset($_SESSION['admin_two_factor_check']);
		unset($_SESSION['admin_name']);
		unset($_SESSION['admin_type']);
		unset($_SESSION['otp_count2']);
		header("location: index.php");
		die();
	}
?>