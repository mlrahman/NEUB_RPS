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
	if(isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		//Data transfer format
		echo '86-36-19-67-35-25@20-15-25-10-18-12@2-5-7-12-3-1@';

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>