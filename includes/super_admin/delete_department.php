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
			
			/********** Inserting delete history ******/
			$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:dept_id");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			$dept_title=$result[0][1];
			$dept_code=$result[0][2];
			$dept_status=$result[0][3];
			$t=get_current_time();
			$d=get_current_date();
			$task='Deleted Department Title: '.$dept_title.', Department Code: '.$dept_code.', Department Status: '.$dept_status;
			$stmt = $conn->prepare("insert into nr_delete_history(nr_admin_id,nr_deleteh_task,nr_deleteh_date,nr_deleteh_time,nr_deleteh_status,nr_deleteh_type) values(:admin_id,'$task','$d','$t','Active','Department') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			/***********************/
			
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