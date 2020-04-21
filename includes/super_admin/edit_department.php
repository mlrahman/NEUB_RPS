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
	if(isset($_REQUEST['dept_id']) && isset($_REQUEST['dept_title']) && isset($_REQUEST['dept_code']) && isset($_REQUEST['dept_status']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$dept_id=trim($_REQUEST['dept_id']);
			$dept_title=trim($_REQUEST['dept_title']);
			$dept_code=trim($_REQUEST['dept_code']);
			$dept_status=trim($_REQUEST['dept_status']);
			
			
			$stmt = $conn->prepare("update nr_department set nr_dept_title=:dept_title, nr_dept_code=:dept_code, nr_dept_status=:dept_status where nr_dept_id=:dept_id ");
			$stmt->bindParam(':dept_title', $dept_title);
			$stmt->bindParam(':dept_code', $dept_code);
			$stmt->bindParam(':dept_status', $dept_status);
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->execute();
			
			
			$t=get_current_time();
			$d=get_current_date();
			$task='Edited Department Title: '.$dept_title.', Department Code: '.$dept_code.', Department Status: '.$dept_status;
			$stmt = $conn->prepare("insert into nr_department_history(nr_dept_id,nr_admin_id,nr_depth_task,nr_depth_date,nr_depth_time,nr_depth_status) values(:dept_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
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