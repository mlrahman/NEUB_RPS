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
	if(isset($_REQUEST['dept_id']) && isset($_REQUEST['program_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$program_id=trim($_REQUEST['program_id']);
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		if($program_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(nr_stud_id) as total_students from nr_student where nr_stud_status='Active' ");
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select count(nr_stud_id) as total_students from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_stud_status='Active' ");
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(nr_stud_id) as total_students from nr_student where nr_prog_id=:prog_id and nr_stud_status='Active' ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		else
		{
			$stmt = $conn->prepare("select count(nr_stud_id) as total_students from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			echo $result[0][0];
		}
		else
		{
			echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>