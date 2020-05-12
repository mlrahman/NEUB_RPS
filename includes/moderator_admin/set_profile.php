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
	if(isset($_REQUEST['password']) && isset($_REQUEST['cell_no']) && isset($_REQUEST['moderator_id']) && $_REQUEST['moderator_id']==$_SESSION['moderator_id'])
	{
		$moderator_password=trim($_REQUEST['password']);
		$moderator_cell_no=trim($_REQUEST['cell_no']);
		
		//faculty info
		$stmt = $conn->prepare("select * from nr_admin where nr_admin_status='Active' and nr_admin_id=:f_id");
		$stmt->bindParam(':f_id', $_SESSION['moderator_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			die();
		}
		
		if($moderator_password=="")
			$moderator_password=$result[0][3];
		else
			$moderator_password=password_encrypt($moderator_password);
		$stmt = $conn->prepare("update nr_admin set nr_admin_password=:f_pass, nr_admin_cell_no=:cell_no where nr_admin_id=:f_id and nr_admin_status='Active' ");
		$stmt->bindParam(':f_pass', $moderator_password);
		$stmt->bindParam(':cell_no', $moderator_cell_no);
		$stmt->bindParam(':f_id', $_SESSION['moderator_id']);
		$stmt->execute();
		echo 'Ok';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>