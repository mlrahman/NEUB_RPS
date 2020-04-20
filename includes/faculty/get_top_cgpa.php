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
		$program_id=trim($_REQUEST['program_id']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		if($program_id==-1)
		{
			$stmt = $conn->prepare("select max(b.nr_studi_cgpa) from nr_student a,nr_student_info b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id ");
		}
		else
		{
			$stmt = $conn->prepare("select max(b.nr_studi_cgpa) from nr_student a,nr_student_info b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':f_d_id', $faculty_dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			if($result[0][0]=='')
				echo 'N/A';
			else
				echo number_format($result[0][0],2);
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