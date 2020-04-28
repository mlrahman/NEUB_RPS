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
	if($_SESSION['admin_type']!='Super Admin'){
		header("location: index.php");
		die();
	}
	if(isset($_REQUEST['filter_type15']) &&  isset($_REQUEST['filter_status15']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status15=trim($_REQUEST['filter_status15']);
		$filter_type15=trim($_REQUEST['filter_type15']);
		
		$filter='';
		if($filter_status15==1)
			$filter=' and nr_admin_status="Active" ';
		if($filter_status15==2)
			$filter=' and nr_admin_status="Inactive" ';
		
		if($filter_type15!=-1)
			$filter=$filter.' and nr_admin_type="'.$filter_type15.'" ';
		
		
		$stmt = $conn->prepare("select count(nr_admin_id) from nr_admin where (nr_admin_name like concat('%',:search_text,'%') or nr_admin_designation like concat('%',:search_text,'%')) ".$filter);
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