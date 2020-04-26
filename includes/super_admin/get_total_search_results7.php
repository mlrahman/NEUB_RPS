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
	if(isset($_REQUEST['filter_type7']) &&  isset($_REQUEST['filter_status7']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status7=trim($_REQUEST['filter_status7']);
		$filter_type7=trim($_REQUEST['filter_type7']);
		
		$filter='';
		if($filter_status7==1)
			$filter=' and nr_faculty_status="Active" ';
		if($filter_status7==2)
			$filter=' and nr_faculty_status="Inactive" ';
		
		if($filter_type7!=-1)
			$filter=$filter.' and nr_faculty_type="'.$filter_type7.'" ';
		
		if($dept_id==-1)
		{
			$stmt = $conn->prepare("select count(nr_faculty_id) from nr_faculty where (nr_faculty_name like concat('%',:search_text,'%') or nr_faculty_designation like concat('%',:search_text,'%')) ".$filter);
			$stmt->bindParam(':search_text', $search_text);
		}
		else
		{
			$stmt = $conn->prepare("select count(nr_faculty_id) from nr_faculty where nr_dept_id=:dept_id and (nr_faculty_name like concat('%',:search_text,'%') or nr_faculty_designation like concat('%',:search_text,'%')) ".$filter);
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