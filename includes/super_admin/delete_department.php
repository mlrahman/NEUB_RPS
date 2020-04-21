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
	if(isset($_REQUEST['dept_id']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$dept_id=trim($_REQUEST['dept_id']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$fl=0; $fl1=0;
			//checking if dept is delete able or not
			$stmt = $conn->prepare("select * from nr_faculty where nr_dept_id=:dept_id");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl=1;
			}
			
			//checking if dept is delete able or not
			$stmt = $conn->prepare("select * from nr_program where nr_dept_id=:dept_id");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl1=1;
			}
			
			if($fl==1 || $fl1==1)
			{
				echo 'unable';
				die();
			}
			
			$stmt = $conn->prepare("delete from nr_department_history where nr_dept_id=:dept_id ");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->execute();
			
			
			$stmt = $conn->prepare("delete from nr_department where nr_dept_id=:dept_id ");
			$stmt->bindParam(':dept_id', $dept_id);
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