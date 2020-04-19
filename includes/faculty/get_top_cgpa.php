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
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_stud_status='Active' ");
		}
		else
		{
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':f_d_id', $faculty_dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$y=count($result);
			$max_cgpa=0.0;
			for($index=0;$index<$y;$index++)
			{
				$s_id=$result[$index][0];
				$prcr_id = $result[$index][8];
				$x=get_cgpa($s_id,$prcr_id);
				if($x>$max_cgpa)
					$max_cgpa=$x;	
			}
			$max_cgpa=number_format($max_cgpa,2);
			if($max_cgpa!=0.0)
				echo $max_cgpa;
			else
				echo 'N/A';
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