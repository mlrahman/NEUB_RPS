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
	if(isset($_REQUEST['prog_id']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$prog_id=trim($_REQUEST['prog_id']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$fl=0; $fl2=0; $fl3=0; $fl4=0;
			//checking if prog is delete able or not
			$stmt = $conn->prepare("select * from nr_course where nr_prog_id=:prog_id");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl=1;
			}
			
			//checking if prog is delete able or not
			$stmt = $conn->prepare("select * from nr_drop where nr_prog_id=:prog_id");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl2=1;
			}
			
			//checking if prog is delete able or not
			$stmt = $conn->prepare("select * from nr_result where nr_prog_id=:prog_id");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl3=1;
			}
			
			//checking if prog is delete able or not
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id=:prog_id");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl4=1;
			}
				
			if($fl==1 || $fl2==1 || $fl3==1 || $fl4==1)
			{
				echo 'unable';
				die();
			}
			
			$stmt = $conn->prepare("delete from nr_program_history where nr_prog_id=:prog_id ");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_program_credit where nr_prog_id=:prog_id ");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			
			
			$stmt = $conn->prepare("delete from nr_program where nr_prog_id=:prog_id ");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();

			
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