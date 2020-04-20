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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['moderator_id']) && $_REQUEST['moderator_id']==$_SESSION['moderator_id'])
	{
		$program_id=trim($_REQUEST['program_id']);
		$moderator_id=trim($_REQUEST['moderator_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		if($program_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_student a,nr_student_info b where a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id ");
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_student a,nr_student_info b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id ");
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_student a,nr_student_info b where a.nr_prog_id=:prog_id and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		else
		{
			$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_student a,nr_student_info b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_prog_id=:prog_id and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id ");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			if($result[0][0]=='')
				echo 'N/A';
			else
				echo $result[0][0];
		}
		else
		{
			echo 'N/A';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>