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
	if(isset($_REQUEST['name']) && isset($_REQUEST['designation']) && isset($_REQUEST['email']) && isset($_REQUEST['joining_date']) && isset($_REQUEST['gender']) && isset($_REQUEST['password']) && isset($_REQUEST['cell_no']) && isset($_REQUEST['image']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		//echo 'Ok1';
		
		$admin_password=trim($_REQUEST['password']);
		$admin_cell_no=trim($_REQUEST['cell_no']);
		$admin_image=trim($_REQUEST['image']);
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
		$old_image=$result[0][5];
		$old_email=$result[0][2];
		
		if($old_email!=$email)
		{
			$_SESSION['admin_email']=$email;
		}
		
		if($admin_password=="")
			$admin_password=$result[0][3];
		else
		{
			$admin_password=password_encrypt($admin_password);
			$_SESSION['admin_password']=$admin_password;
		}
		//file delete server info required to update if needed
		$base_directory = '../../images/admin/';
		
		//echo 'Ok2';
		$link=$admin_image;
		$file=$_FILES[$link];
		$image_name=photo_upload($file,0,100000,"jpg,gif,png,jpeg,bmp,heic",'../../images/admin',$path='');
		
		//echo 'Ok3';
		
		if($image_name!="1")
		{
			$mssg=photo_resize('../../images/admin/', $image_name, '' , '../../images/admin/', 300, 360); //width than height
			//echo 'Ok4';
			if($mssg=="done")
			{
				if($old_image!="")
				{
					unlink($base_directory.$old_image);
				}
				$stmt = $conn->prepare("update nr_admin set nr_admin_password=:f_pass, nr_admin_cell_no=:cell_no, nr_admin_photo=:photo, nr_admin_name=:name, nr_admin_designation=:designation, nr_admin_email=:email, nr_admin_join_date=:joining_date, nr_admin_gender=:gender where nr_admin_id=:f_id and nr_admin_status='Active' ");
				$stmt->bindParam(':f_pass', $admin_password);
				$stmt->bindParam(':cell_no', $admin_cell_no);
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':designation', $designation);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':joining_date', $joining_date);
				$stmt->bindParam(':gender', $gender);
				$stmt->bindParam(':photo', $image_name);
				$stmt->bindParam(':f_id', $_SESSION['admin_id']);
				$stmt->execute();
				echo 'Ok';
			}
			else
			{
				unlink($base_directory.$image_name);
				echo 'Error';
			}
		}
		else
		{
			echo 'Error';
		}
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>