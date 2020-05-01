<?php
	session_start();
	require("../db_connection.php"); 
	require("../function.php"); 
	try{
		require("logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	if(isset($_REQUEST['student_old_id']) && isset($_REQUEST['student_status']) && isset($_REQUEST['student_gender']) && isset($_REQUEST['student_birth_date']) && isset($_REQUEST['student_id']) && isset($_REQUEST['student_name']) && isset($_REQUEST['student_dp']) && isset($_REQUEST['student_email']) && isset($_REQUEST['student_mobile']) && isset($_REQUEST['student_prog']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$student_id=trim($_REQUEST['student_id']);
			$student_old_id=trim($_REQUEST['student_old_id']);
			$student_name=trim($_REQUEST['student_name']);
			$student_dp=trim($_REQUEST['student_dp']);
			$student_email=trim($_REQUEST['student_email']);
			$student_mobile=trim($_REQUEST['student_mobile']);
			$student_prog=trim($_REQUEST['student_prog']);
			$student_birth_date=trim($_REQUEST['student_birth_date']);
			$student_gender=trim($_REQUEST['student_gender']);
			$student_status=trim($_REQUEST['student_status']);
			
			
			//checking if faculty is add able or not
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id!=:student_id and ((nr_stud_email!='' and nr_stud_email=:student_email) or (nr_stud_name=:student_name and nr_stud_dob=:student_birth_date))");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':student_name', $student_name);
			$stmt->bindParam(':student_birth_date', $student_birth_date);
			$stmt->bindParam(':student_email', $student_email);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			if($student_id!=$student_old_id)
			{
				echo 'unable';
				die();
			}
			
			
			if($student_email!='' && email_check($student_email)==false)
			{
				echo 'unable2';
				die();
			}
			
			
			//check program is changed or not .... and active or not 
			
			echo 'Ok';
			
			
		}
		catch(PDOException $e)
		{
			echo 'Error';
			die();
		}
		catch(Exception $e)
		{
			echo 'Error';
			die();
		}

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>