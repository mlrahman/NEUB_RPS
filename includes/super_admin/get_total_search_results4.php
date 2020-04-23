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
	if(isset($_REQUEST['filter_status4']) && isset($_REQUEST['prog_id'])  && isset($_REQUEST['dept_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$prog_id=trim($_REQUEST['prog_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status4=trim($_REQUEST['filter_status4']);
		
		$filter='';
		if($filter_status4==1)
			$filter=' and a.nr_course_status="Active" ';
		if($filter_status4==2)
			$filter=' and a.nr_course_status="Inactive" ';
		
		
		if($prog_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(a.nr_course_id) from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_dept_id=c.nr_dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter);
		}
		else if($prog_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select count(a.nr_course_id) from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_dept_id=c.nr_dept_id and c.nr_dept_id=:dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($prog_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(a.nr_course_id) from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_prog_id=:prog_id and b.nr_dept_id=c.nr_dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		else
		{
			$stmt = $conn->prepare("select count(a.nr_course_id) from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_prog_id=:prog_id and b.nr_dept_id=c.nr_dept_id and c.nr_dept_id=:dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter);
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)!=0)
		{
			echo $result[0][0];
		}
		else
			echo '0';
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>