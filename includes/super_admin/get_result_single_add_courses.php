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
	if(isset($_REQUEST['prog_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$stmt = $conn->prepare(" select nr_course_id,nr_course_code,nr_course_title from nr_course where nr_prog_id=:prog_id and nr_course_status='Active' ");
			$stmt->bindParam(':prog_id', $_REQUEST['prog_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$sz=count($result);
			echo '<option value="">Select</option>';
			for($i=0;$i<$sz;$i++)
			{
				echo '<option value="'.$result[$i][0].'">'.$result[$i][1].' : '.$result[$i][2].'</option>';
			}
			
		
		}
		catch(PDOException $e)
		{
			echo '<option value="">Select</option>';
			die();
		}
		catch(Exception $e)
		{
			echo '<option value="">Select</option>';
			die();
		}

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred!!"> Network Error Occurred</i>';
	}
?>