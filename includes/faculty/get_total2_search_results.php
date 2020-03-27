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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['program_id2']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id2=trim($_REQUEST['program_id2']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		$sort=trim($_REQUEST['sort']);
		if($sort>4)
		{
			
		}
		else
		{
			if($sort==1)
			{
				$order_by='nr_stud_id';
				$order='asc';
			}
			else if($sort==2)
			{
				$order_by='nr_stud_id';
				$order='desc';
			}
			else if($sort==3)
			{
				$order_by='nr_stud_name';
				$order='asc';
			}
			else if($sort==4)
			{
				$order_by='nr_stud_name';
				$order='desc';
			}
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select count(nr_stud_id) as total_students from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id)  and nr_stud_status='Active' order by ".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select count(nr_stud_id) as total_students from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active' order by ".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
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
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>