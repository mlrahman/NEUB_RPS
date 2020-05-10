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
	if(isset($_REQUEST['prog_id']) && isset($_REQUEST['student_id']) && isset($_REQUEST['moderator_id']) && $_REQUEST['moderator_id']==$_SESSION['moderator_id'])
	{
		try
		{
			$stmt = $conn->prepare("select nr_stud_name from nr_student where nr_stud_id=:student_id and nr_prog_id=:prog_id limit 1");
			$stmt->bindParam(':student_id', $_REQUEST['student_id']);
			$stmt->bindParam(':prog_id', $_REQUEST['prog_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'Unknown';
				die();
			}
			echo $result[0][0];
		}
		catch(PDOException $e)
		{
			echo 'Unknown';
			die();
		}
		catch(Exception $e)
		{
			echo 'Unknown';
			die();
		}

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred!!"> Network Error Occurred</i>';
	}
?>