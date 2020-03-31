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
	if(isset($_REQUEST['search_text']) && isset($_REQUEST['program_id2']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id2=trim($_REQUEST['program_id2']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		$order_by='nr_result_id';
		$order='asc';
		$search_text=trim($_REQUEST['search_text']);
		if($program_id2==-1)
		{
			$stmt = $conn->prepare("select count(nr_result_id) from nr_result a,nr_course b where (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_result_status='Active' order by ".$order_by." ".$order);
		}
		else
		{
			$stmt = $conn->prepare("select count(nr_result_id) from nr_result a,nr_course b where (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $program_id2);
		}
		$stmt->bindParam(':f_d_id', $faculty_dept_id);
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			echo $result[0][0];
		}
		else
		{
			echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>