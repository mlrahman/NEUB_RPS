<?php

	//checking logged in or not
	
	try{
		if(isset($_SESSION['faculty_id']) && isset($_SESSION['faculty_email']) && isset($_SESSION['faculty_password']) && isset($_SESSION['faculty_time']) && isset($_SESSION['faculty_date']) && isset($_SESSION['faculty_two_factor_status']) && isset($_SESSION['faculty_two_factor_check']))
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
				$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_id=:faculty_id and nr_faculty_email=:faculty_email and nr_faculty_password=:faculty_password and nr_faculty_status='Active' ");
				$stmt->bindParam(':faculty_id', $faculty_id);
				$stmt->bindParam(':faculty_email', $faculty_email);
				$stmt->bindParam(':faculty_password', $faculty_password);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==1){
					//redirecting logged in page
					header("location: f_index.php");
				}
				else{
					unset($_SESSION['faculty_id']);
					unset($_SESSION['faculty_email']);
					unset($_SESSION['faculty_password']);
					unset($_SESSION['faculty_date']);
					unset($_SESSION['faculty_time']);
					unset($_SESSION['faculty_two_factor_status']);
					unset($_SESSION['faculty_two_factor_check']);
					header("location: index.php");
					die();
				}
			}
			else
			{
				unset($_SESSION['faculty_id']);
				unset($_SESSION['faculty_email']);
				unset($_SESSION['faculty_password']);
				unset($_SESSION['faculty_date']);
				unset($_SESSION['faculty_time']);
				unset($_SESSION['faculty_two_factor_status']);
				unset($_SESSION['faculty_two_factor_check']);
				header("location: index.php");
				die();
			}
		}
	}
	catch(Exception $e)
	{
		unset($_SESSION['faculty_id']);
		unset($_SESSION['faculty_email']);
		unset($_SESSION['faculty_password']);
		unset($_SESSION['faculty_date']);
		unset($_SESSION['faculty_time']);
		unset($_SESSION['faculty_two_factor_status']);
		unset($_SESSION['faculty_two_factor_check']);
		header("location: index.php");
		die();
	}
?>