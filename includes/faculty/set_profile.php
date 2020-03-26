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
	if(isset($_REQUEST['password']) && isset($_REQUEST['otp']) && isset($_REQUEST['cell_no']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$faculty_password=trim($_REQUEST['password']);
		$faculty_otp=trim($_REQUEST['otp']);
		$faculty_cell_no=trim($_REQUEST['cell_no']);
		
		//faculty info
		$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_status='Active' and nr_faculty_id=:f_id");
		$stmt->bindParam(':f_id', $_SESSION['faculty_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			die();
		}
		
		if($faculty_password=="")
			$faculty_password=$result[0][7];
		else
			$faculty_password=password_encrypt($faculty_password);
		$stmt = $conn->prepare("update nr_faculty set nr_faculty_password=:f_pass, nr_faculty_cell_no=:cell_no, nr_faculty_two_factor=:otp where nr_faculty_id=:f_id and nr_faculty_status='Active' ");
		$stmt->bindParam(':f_pass', $faculty_password);
		$stmt->bindParam(':cell_no', $faculty_cell_no);
		$stmt->bindParam(':otp', $faculty_otp);
		$stmt->bindParam(':f_id', $_SESSION['faculty_id']);
		$stmt->execute();
		echo 'Ok';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>