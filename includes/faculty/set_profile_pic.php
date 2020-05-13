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
	if(isset($_REQUEST['password']) && isset($_REQUEST['otp']) && isset($_REQUEST['cell_no']) && isset($_REQUEST['image']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		//echo 'Ok1';
		
		$faculty_password=trim($_REQUEST['password']);
		$faculty_otp=trim($_REQUEST['otp']);
		$faculty_cell_no=trim($_REQUEST['cell_no']);
		$faculty_image=trim($_REQUEST['image']);
		
		//faculty info
		$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_status='Active' and nr_faculty_id=:f_id");
		$stmt->bindParam(':f_id', $_SESSION['faculty_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			die();
		}
		$old_image=$result[0][10];
		if($faculty_password=="")
			$faculty_password=$result[0][7];
		else
		{
			$faculty_password=password_encrypt($faculty_password);
			$_SESSION['faculty_password']=$faculty_password;
		}
		//file delete server info required to update if needed
		$base_directory = '../../images/faculty/';
		
		//echo 'Ok2';
		$link=$faculty_image;
		$file=$_FILES[$link];
		$image_name=photo_upload($file,0,100000,"jpg,gif,png,jpeg,bmp,heic",'../../images/faculty',$path='');
		
		//echo 'Ok3';
		
		if($image_name!="1")
		{
			$mssg=photo_resize('../../images/faculty/', $image_name, '' , '../../images/faculty/', 300, 360); //width than height
			//echo 'Ok4';
			if($mssg=="done")
			{
				if($old_image!="")
				{
					unlink($base_directory.$old_image);
				}
				$stmt = $conn->prepare("update nr_faculty set nr_faculty_password=:f_pass, nr_faculty_cell_no=:cell_no, nr_faculty_two_factor=:otp, nr_faculty_photo=:photo where nr_faculty_id=:f_id and nr_faculty_status='Active' ");
				$stmt->bindParam(':f_pass', $faculty_password);
				$stmt->bindParam(':cell_no', $faculty_cell_no);
				$stmt->bindParam(':otp', $faculty_otp);
				$stmt->bindParam(':photo', $image_name);
				$stmt->bindParam(':f_id', $_SESSION['faculty_id']);
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