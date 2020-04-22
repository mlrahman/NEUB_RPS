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
	if(isset($_REQUEST['filter_status3']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status3=trim($_REQUEST['filter_status3']);
		
		$filter='';
		if($filter_status3==1)
			$filter=' and nr_prog_status="Active" ';
		if($filter_status3==2)
			$filter=' and nr_prog_status="Inactive" ';
		if($dept_id==-1)
		{
			$stmt = $conn->prepare("select count(nr_prog_id) from nr_program where (nr_prog_title like concat('%',:search_text,'%') or nr_prog_code like concat('%',:search_text,'%')) ".$filter);
			$stmt->bindParam(':search_text', $search_text);
		}
		else
		{
			$stmt = $conn->prepare("select count(nr_prog_id) from nr_program where (nr_prog_title like concat('%',:search_text,'%') or nr_prog_code like concat('%',:search_text,'%')) and nr_dept_id=:dept_id ".$filter);
			$stmt->bindParam(':search_text', $search_text); 
			$stmt->bindParam(':dept_id', $dept_id); 
		}
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