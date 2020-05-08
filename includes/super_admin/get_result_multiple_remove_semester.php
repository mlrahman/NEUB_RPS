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
	if(isset($_REQUEST['course_id']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$stmt = $conn->prepare(" select distinct nr_result_semester,nr_result_year from nr_result where nr_prog_id=:prog_id and nr_course_id=:course_id order by nr_result_year asc,nr_result_semester asc ");
			$stmt->bindParam(':prog_id', $_REQUEST['prog_id']);
			$stmt->bindParam(':course_id', $_REQUEST['course_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$sz=count($result);
			echo '<option value="">Select</option>';
			for($i=0;$i<$sz;$i++)
			{
				echo '<option value="'.$result[$i][0].' '.$result[$i][1].'">'.$result[$i][0].' '.$result[$i][1].'</option>';
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