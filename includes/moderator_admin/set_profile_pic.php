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
	if(isset($_REQUEST['password']) && isset($_REQUEST['cell_no']) && isset($_REQUEST['image']) && isset($_REQUEST['moderator_id']) && $_REQUEST['moderator_id']==$_SESSION['moderator_id'])
	{
		//echo 'Ok1';
		
		$moderator_password=trim($_REQUEST['password']);
		$moderator_cell_no=trim($_REQUEST['cell_no']);
		$moderator_image=trim($_REQUEST['image']);
		
		//faculty info
		$stmt = $conn->prepare("select * from nr_admin where nr_admin_status='Active' and nr_admin_id=:f_id");
		$stmt->bindParam(':f_id', $_SESSION['moderator_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			die();
		}
		$old_image=$result[0][5];
		if($moderator_password=="")
			$moderator_password=$result[0][3];
		else
		{
			$moderator_password=password_encrypt($moderator_password);
			$_SESSION['moderator_password']=$moderator_password;
		}
		//file delete server info required to update if needed
		$base_directory = '../../images/moderator/';
		
		//echo 'Ok2';
		$link=$moderator_image;
		$file=$_FILES[$link];
		$image_name=photo_upload($file,0,100000,"jpg,gif,png,jpeg,bmp,heic",'../../images/moderator',$path='');
		
		//echo 'Ok3';
		
		if($image_name!="1")
		{
			$mssg=photo_resize('../../images/moderator/', $image_name, '' , '../../images/moderator/', 300, 360); //width than height
			//echo 'Ok4';
			if($mssg=="done")
			{
				if($old_image!="")
				{
					unlink($base_directory.$old_image);
				}
				$stmt = $conn->prepare("update nr_admin set nr_admin_password=:f_pass, nr_admin_cell_no=:cell_no, nr_admin_photo=:photo where nr_admin_id=:f_id and nr_admin_status='Active' ");
				$stmt->bindParam(':f_pass', $moderator_password);
				$stmt->bindParam(':cell_no', $moderator_cell_no);
				$stmt->bindParam(':photo', $image_name);
				$stmt->bindParam(':f_id', $_SESSION['moderator_id']);
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