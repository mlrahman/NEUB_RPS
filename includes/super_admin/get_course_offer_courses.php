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
	if(isset($_REQUEST['prog_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$prog_id=trim($_REQUEST['prog_id']);
		$stmt = $conn->prepare("select a.nr_course_id,a.nr_course_title,a.nr_course_code from nr_course a, nr_program b,nr_program_credit c where a.nr_prog_id=b.nr_prog_id and c.nr_prog_id=b.nr_prog_id and c.nr_prcr_id=(select d.nr_prcr_id from nr_program_credit d where d.nr_prog_id=a.nr_prog_id and d.nr_prcr_ex_date='' order by d.nr_prcr_id desc limit 1) and a.nr_course_id not in (select e.nr_course_id from nr_course e,nr_drop f where e.nr_course_id=f.nr_course_id and f.nr_prcr_id=c.nr_prcr_id) and a.nr_prog_id=:prog_id ");
		$stmt->bindParam(':prog_id', $prog_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$sz=count($result);
		if($sz!=0)
			echo '<option value="">Select</option>';
		for($i=0;$i<$sz;$i++)
		{
			echo '<option value="'.$result[$i][0].'">'.$result[$i][2].' : '.$result[$i][1].'</option>';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>