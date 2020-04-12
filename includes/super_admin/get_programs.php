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
	if(isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$dept_id=$_REQUEST['dept_id'];
			if($dept_id==-1)
			{
				$stmt = $conn->prepare("SELECT * FROM nr_program order by nr_prog_id asc");
				
			}
			else
			{
				$stmt = $conn->prepare("SELECT * FROM nr_program where nr_dept_id=:dept_id order by nr_prog_id asc");
				$stmt->bindParam(':dept_id', $dept_id);	
			}
			echo '<option value="-1">All</option>';
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			if(count($stud_result)>0)
			{
				$sz=count($stud_result);
				for($k=0;$k<$sz;$k++)
				{
					$prog_id=$stud_result[$k][0];
					$prog_title=$stud_result[$k][1];
					echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
				}
			}
			
		}
		catch(PDOException $e)
		{
			echo '<option value="-1">All</option>';
			die();
		}
		catch(Exception $e)
		{
			echo '<option value="-1">All</option>';
			die();
		}
		
		
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>