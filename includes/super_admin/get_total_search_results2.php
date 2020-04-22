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
	if(isset($_REQUEST['filter_status2']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status2=trim($_REQUEST['filter_status2']);
		
		$filter='';
		if($filter_status2==1)
			$filter=' and nr_dept_status="Active" ';
		if($filter_status2==2)
			$filter=' and nr_dept_status="Inactive" ';
		
		$stmt = $conn->prepare("select count(nr_dept_id) from nr_department where (nr_dept_title like concat('%',:search_text,'%') or nr_dept_code like concat('%',:search_text,'%')) ".$filter);
		$stmt->bindParam(':search_text', $search_text); $stmt->execute();
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