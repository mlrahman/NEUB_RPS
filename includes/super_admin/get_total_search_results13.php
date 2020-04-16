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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$user_type=trim($_REQUEST['user_type']);
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and b.nr_admin_type!='Super Admin' ";
		}
		$tot=0;
		if($user_type==-1) //All
		{
			$stmt = $conn->prepare("select count(distinct(a.nr_faculty_id)) from nr_faculty_login_transaction a,nr_faculty b where a.nr_faculty_id=b.nr_faculty_id and b.nr_faculty_name like concat('%',:search_text,'%') ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
			
			$stmt = $conn->prepare("select count(distinct(a.nr_admin_id)) from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') ".$filter." ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		
		}
		else if($user_type==1) //Faculty
		{
			$stmt = $conn->prepare("select count(distinct(a.nr_faculty_id)) from nr_faculty_login_transaction a,nr_faculty b where a.nr_faculty_id=b.nr_faculty_id and b.nr_faculty_name like concat('%',:search_text,'%') ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==2) //moderator
		{
			$stmt = $conn->prepare("select count(distinct(a.nr_admin_id)) from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') and b.nr_admin_type='Moderator' ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==3) //admin
		{
			$stmt = $conn->prepare("select count(distinct(a.nr_admin_id)) from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') and b.nr_admin_type='Admin' ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==4 && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$stmt = $conn->prepare("select count(distinct(a.nr_admin_id)) from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') and b.nr_admin_type='Super Admin' ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		echo $tot;
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>