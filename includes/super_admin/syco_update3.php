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
	if(isset($_REQUEST['logo']) && isset($_REQUEST['video']) && isset($_REQUEST['title']) && isset($_REQUEST['caption']) && isset($_REQUEST['address']) && isset($_REQUEST['web']) && isset($_REQUEST['email']) && isset($_REQUEST['map_link']) && isset($_REQUEST['telephone']) && isset($_REQUEST['contact_email']) && isset($_REQUEST['mobile']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'] && $_SESSION['admin_type']=='Super Admin')
	{
		$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:admin_id");
		$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$admin_name=$result[0][1];
		$admin_designation=$result[0][7];
		
		/***************************/
		$logo=trim($_REQUEST['logo']);
		$video=trim($_REQUEST['video']);
		/****************************/
		$title=trim($_REQUEST['title']);
		$address=trim($_REQUEST['address']);
		$caption=trim($_REQUEST['caption']);
		$web=trim($_REQUEST['web']);
		$contact_email=trim($_REQUEST['contact_email']);
		$map_link=trim($_REQUEST['map_link']);
		$telephone=trim($_REQUEST['telephone']);
		$email=trim($_REQUEST['email']);
		$mobile=trim($_REQUEST['mobile']);
		
		//file delete server info required to update if needed
		$base_directory = '../../images/system/';
		
		$stmt = $conn->prepare("select * from nr_system_component a, nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_syco_status='Active' order by a.nr_syco_id desc limit 1 ");
		$stmt->execute();
		$result = $stmt->fetchAll();
			
		$return_msg='';	
		
		
			
		if(count($result)==0) //no info available
		{
			
			$fl1=0;
			$fl3=0;
			
			//uploading logo
			$link1=$logo;
			$file1=$_FILES[$link1];
			$logo_name=photo_upload($file1,0,100000,"jpg,gif,png,jpeg,bmp,heic",'../../images/system',$path='');
		
			if($logo_name!="1")
			{
				
				$return_msg=$return_msg.'Ok@';
				$fl1=1;
				
			}
			else
			{
				$logo_name='';
				$return_msg=$return_msg.'Error@';
			}
			
			
			//uploading video
			$link3=$video;
			$file3=$_FILES[$link3];
			$video_name=video_upload($file3,0,1000000,"mp4,ogg,webm",'../../images/system',$path='');
		
			if($video_name!="1")
			{
				$return_msg=$return_msg.'Ok@';
				$fl3=1;
			}
			else
			{
				$video_name='';
				$return_msg=$return_msg.'Error@';
			}
			
			if($fl1==1 && $fl3==1)
			{
				$date=get_current_date();
				$stmt = $conn->prepare("insert into nr_system_component(nr_syco_title, nr_syco_caption, nr_syco_address, nr_syco_tel, nr_syco_email, nr_syco_mobile, nr_syco_web, nr_syco_contact_email, nr_syco_map_link, nr_syco_date, nr_syco_logo, nr_syco_video, nr_admin_id) 
				values(:title,:caption,:address,:telephone,:email,:mobile,:web,:contact_email,:map_link,:date,:logo,:video,:admin_id) ");
				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':caption', $caption);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':web', $web);
				$stmt->bindParam(':telephone', $telephone);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':mobile', $mobile);
				$stmt->bindParam(':contact_email', $contact_email);
				$stmt->bindParam(':map_link', $map_link);
				$stmt->bindParam(':date', $date);
				$stmt->bindParam(':logo', $logo_name);
				$stmt->bindParam(':video', $video_name);
				$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
				$stmt->execute();
			}
			else
			{
				if($fl1==1)
				{
					unlink($base_directory.$logo_name);
				}
				
				if($fl3==1)
				{
					unlink($base_directory.$video);
				}
			}
			$return_msg=$return_msg.get_date($date).'@'.$admin_name.'@'.$admin_designation.'@';
			
		}
		else //available so update
		{
			$fl1=0;
			$fl3=0;
			
			$syco_id=$result[0][0];
			$old_logo=$result[0][13];
			$old_video=$result[0][15];
			
			//uploading logo
			$link1=$logo;
			$file1=$_FILES[$link1];
			$logo_name=photo_upload($file1,0,100000,"jpg,gif,png,jpeg,bmp,heic",'../../images/system',$path='');
		
			if($logo_name!="1")
			{
				
			
				$return_msg=$return_msg.'Ok@';
				$fl1=1;
			
			}
			else
			{
				$logo_name=$old_logo;
				$return_msg=$return_msg.'Error@';
			}
			
			
			
			//uploading video
			$link3=$video;
			$file3=$_FILES[$link3];
			$video_name=video_upload($file3,0,1000000,"mp4,ogg,webm",'../../images/system',$path='');
		
			if($video_name!="1")
			{
				
				$return_msg=$return_msg.'Ok@';
				$fl3=1;
			}
			else
			{
				$video_name=$old_video;
				$return_msg=$return_msg.'Error@';
			}
			
			if($fl1==1 && $fl3==1)
			{
				if($old_logo!="")
				{
					unlink($base_directory.$old_logo);
				}
				
				if($old_video!="")
				{
					unlink($base_directory.$old_video);
				}
				
				$date=get_current_date();
				$stmt = $conn->prepare("update nr_system_component set nr_syco_title=:title, nr_syco_caption=:caption, nr_syco_address=:address, nr_syco_tel=:telephone, nr_syco_email=:email, nr_syco_mobile=:mobile, nr_syco_web=:web, nr_syco_contact_email=:contact_email, nr_syco_map_link=:map_link, nr_syco_date=:date, nr_syco_logo=:logo, nr_syco_video=:video, nr_admin_id=:admin_id where nr_syco_id=1 ");
				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':caption', $caption);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':web', $web);
				$stmt->bindParam(':telephone', $telephone);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':mobile', $mobile);
				$stmt->bindParam(':contact_email', $contact_email);
				$stmt->bindParam(':map_link', $map_link);
				$stmt->bindParam(':date', $date);
				$stmt->bindParam(':logo', $logo_name);
				$stmt->bindParam(':video', $video_name);
				$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
				$stmt->execute();
			}
			else
			{
				if($fl1==1)
				{
					unlink($base_directory.$logo_name);
				}
				
				if($fl3==1)
				{
					unlink($base_directory.$video);
				}
			}
			
			$return_msg=$return_msg.get_date($date).'@'.$admin_name.'@'.$admin_designation.'@';
			
		}
		echo $return_msg;
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>