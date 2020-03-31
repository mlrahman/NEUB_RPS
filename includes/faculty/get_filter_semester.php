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
	if(isset($_REQUEST['program_id2']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id=$_REQUEST['program_id2'];
		if($program_id==-1)
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc ");
		}
		else
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_prog_id=:prog_id and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
		$stmt->execute();
		$stud_result=$stmt->fetchAll();
		$sz=count($stud_result);
		echo '<option value="-1">All</option>';
		$semester=array();
		for($x=0;$x<$sz;$x++)
		{
			$s=$stud_result[$x][6];
			$y=$stud_result[$x][7];
			$z=$s.'-'.$y;
			$semester[$z]=array('s'=>$s,'y'=>$y);
		}
		foreach($semester as $sem)
		{
			echo '<option value="'.$sem['s'].'-'.$sem['y'].'">'.$sem['s'].'-'.$sem['y'].'</option>';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>