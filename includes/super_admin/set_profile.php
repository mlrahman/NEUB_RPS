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
	if(isset($_REQUEST['name']) && isset($_REQUEST['designation']) && isset($_REQUEST['email']) && isset($_REQUEST['joining_date']) && isset($_REQUEST['gender']) && isset($_REQUEST['password']) && isset($_REQUEST['cell_no']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_password=trim($_REQUEST['password']);
		$admin_cell_no=trim($_REQUEST['cell_no']);
		$name=trim($_REQUEST['name']);
		$designation=trim($_REQUEST['designation']);
		$email=trim($_REQUEST['email']);
		$joining_date=trim($_REQUEST['joining_date']);
		$gender=trim($_REQUEST['gender']);
		
		$stmt = $conn->prepare("select * from nr_admin where nr_admin_status='Active' and nr_admin_id=:f_id");
		$stmt->bindParam(':f_id', $_SESSION['admin_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			die();
		}
		
		if($admin_password=="")
			$admin_password=$result[0][3];
		else
		{
			$admin_password=password_encrypt($admin_password);
			$stmt = $conn->prepare("update nr_admin_login_transaction set nr_suadlotr_status='Inactive' where nr_admin_id=:admin_id ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
		}
		$stmt = $conn->prepare("update nr_admin set nr_admin_password=:f_pass, nr_admin_cell_no=:cell_no, nr_admin_name=:name, nr_admin_designation=:designation, nr_admin_email=:email, nr_admin_join_date=:joining_date, nr_admin_gender=:gender where nr_admin_id=:f_id and nr_admin_status='Active' ");
		$stmt->bindParam(':f_pass', $admin_password);
		$stmt->bindParam(':cell_no', $admin_cell_no);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':designation', $designation);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':joining_date', $joining_date);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':f_id', $_SESSION['admin_id']);
		$stmt->execute();
		echo 'Ok';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>