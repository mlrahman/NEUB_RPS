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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id=$_REQUEST['program_id'];
		if($program_id==-1)
		{
			$stmt = $conn->prepare("SELECT count(nr_result_id) FROM nr_result a,nr_course b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id");
		}
		else
		{
			$stmt = $conn->prepare("SELECT count(nr_result_id) FROM nr_result a,nr_course b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_prog_id=:prog_id and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id");
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
		$stmt->execute();
		$stud_result=$stmt->fetchAll();
		if(count($stud_result)>0)
		{
			echo $stud_result[0][0];
		}
		else
			echo '0';
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>