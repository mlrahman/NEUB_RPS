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
	if(isset($_REQUEST['course_id']) && isset($_REQUEST['course_title']) && isset($_REQUEST['course_code']) && isset($_REQUEST['course_status']) && isset($_REQUEST['course_credit']) && isset($_REQUEST['course_prog']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$course_id=trim($_REQUEST['course_id']);
			$course_title=trim($_REQUEST['course_title']);
			$course_code=trim($_REQUEST['course_code']);
			$course_credit=trim($_REQUEST['course_credit']);
			$course_prog=trim($_REQUEST['course_prog']);
			$course_status=trim($_REQUEST['course_status']);
			
			
			$stmt = $conn->prepare("update nr_course set nr_course_title=:course_title, nr_course_code=:course_code, nr_course_credit=:course_credit, nr_course_status=:course_status, nr_prog_id=:course_prog where nr_course_id=:course_id ");
			$stmt->bindParam(':course_title', $course_title);
			$stmt->bindParam(':course_code', $course_code);
			$stmt->bindParam(':course_credit', $course_credit);
			$stmt->bindParam(':course_prog', $course_prog);
			$stmt->bindParam(':course_status', $course_status);
			$stmt->bindParam(':course_id', $course_id);
			$stmt->execute();
			
			
			$t=get_current_time();
			$d=get_current_date();
			
			
			$stmt = $conn->prepare("select a.nr_prog_title from nr_program a,nr_course c where a.nr_prog_id=c.nr_prog_id and c.nr_course_id=:course_id ");
			$stmt->bindParam(':course_id', $course_id);
			$stmt->execute();
			$prog_title='';
			$result=$stmt->fetchAll();
			if(count($result)!=0)
				$prog_title=$result[0][0];
			
			$task='Edited Course Title: '.$course_title.', Course Code: '.$course_code.', Course Credit: '.$course_credit.', Course Program: '.$prog_title.', Course Status: '.$course_status;
			$stmt = $conn->prepare("insert into nr_course_history(nr_course_id,nr_admin_id,nr_courseh_task,nr_courseh_date,nr_courseh_time,nr_courseh_status) values(:course_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':course_id', $course_id);
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