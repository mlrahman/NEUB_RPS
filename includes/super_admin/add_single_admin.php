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
	if(isset($_REQUEST['admin_resign_date']) && isset($_REQUEST['admin_join_date']) && isset($_REQUEST['admin_status']) && isset($_REQUEST['admin_gender']) && isset($_REQUEST['admin_type']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_name']) && isset($_REQUEST['admin_designation']) && isset($_REQUEST['admin_email']) && isset($_REQUEST['admin_mobile']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$admin_name=trim($_REQUEST['admin_name']);
			$admin_designation=trim($_REQUEST['admin_designation']);
			$admin_email=trim($_REQUEST['admin_email']);
			$admin_mobile=trim($_REQUEST['admin_mobile']);
			$admin_join_date=trim($_REQUEST['admin_join_date']);
			$admin_resign_date=trim($_REQUEST['admin_resign_date']);
			$admin_type=trim($_REQUEST['admin_type']);
			$admin_gender=trim($_REQUEST['admin_gender']);
			$admin_status=trim($_REQUEST['admin_status']);
			
				
				
			//checking if faculty is add able or not
			$stmt = $conn->prepare("select * from nr_admin where ((nr_admin_email!='' and nr_admin_email=:admin_email) or (nr_admin_name=:admin_name and nr_admin_designation=:admin_designation and nr_admin_join_date=:admin_join_date))");
			$stmt->bindParam(':admin_name', $admin_name);
			$stmt->bindParam(':admin_designation', $admin_designation);
			$stmt->bindParam(':admin_join_date', $admin_join_date);
			$stmt->bindParam(':admin_email', $admin_email);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}	
			
		
			if($admin_email!='' && email_check($admin_email)==false)
			{
				echo 'unable3';
				die();
			}
			
			
			
			
			$stmt = $conn->prepare("insert into nr_admin (nr_admin_name, nr_admin_designation, nr_admin_email, nr_admin_cell_no, nr_admin_join_date, nr_admin_resign_date, nr_admin_gender, nr_admin_type, nr_admin_status) values(:admin_name, :admin_designation, :admin_email, :admin_mobile, :admin_join_date, :admin_resign_date, :admin_gender, :admin_type, :admin_status) ");
			$stmt->bindParam(':admin_name', $admin_name);
			$stmt->bindParam(':admin_designation', $admin_designation);
			$stmt->bindParam(':admin_email', $admin_email);
			$stmt->bindParam(':admin_mobile', $admin_mobile);
			$stmt->bindParam(':admin_join_date', $admin_join_date);
			$stmt->bindParam(':admin_resign_date', $admin_resign_date);
			$stmt->bindParam(':admin_type', $admin_type);
			$stmt->bindParam(':admin_gender', $admin_gender);
			$stmt->bindParam(':admin_status', $admin_status);
			$stmt->execute();
			
			$stmt = $conn->prepare("select nr_admin_id from nr_admin where nr_admin_name=:admin_name and nr_admin_designation=:admin_designation and nr_admin_join_date=:admin_join_date ");
			$stmt->bindParam(':admin_name', $admin_name);
			$stmt->bindParam(':admin_designation', $admin_designation);
			$stmt->bindParam(':admin_join_date', $admin_join_date);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$admin_id=$result[0][0];
			
			
			if($admin_email!='')
			{
				//sent email with password reset link
				//Creating forget password link and sending to user
				$ip_server = $_SERVER['HTTP_HOST']; //root link 
				$token=get_link();
				if($admin_type=='Moderator')
				{
					$x='moderator_admin';
				}
				else
				{
					$x='super_admin';
				}
				$link=$ip_server.'/'.$x.'/forget_password.php?token='.$token;
				$d=get_current_date();
				$t=get_current_time();
				$f_name=$admin_name;
				$main_link=$ip_server.'/'.$x;
				
				//clearing previous links and otps
				$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:f_id");
				$stmt->bindParam(':f_id', $admin_id);
				$stmt->execute();
				
				//Inserting new OTPs
				$stmt = $conn->prepare("insert into nr_admin_link_token values(:f_id,'$token','Forget Password','$d','$t','Active') ");
				$stmt->bindParam(':f_id', $admin_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==0)
				{
					echo 'System not ready';
					die();
				}
				$title=$result[0][2];
				$contact_email=$result[0][9];//for sending message from contact us form
		
				$msg="Dear ".$f_name.", Welcome to ".$title." ".strtolower($admin_type)." panel. Your eamil ".$admin_email." is set for the login access in <a href='".$main_link."' target='_blank'>".strtolower($admin_type)." panel</a> of ".$title.". You can set your password from the following link: <a href='https://".$link."' target='_blank'>".$link."</a><p>&nbsp;</p><b>Note:</b> It is an one time link so be careful during the access, do not reload the page. For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Log In Access from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($admin_email,$title.' - Log In Access',$message,$title,$contact_email);
				
			}
			
			
			
			$t=get_current_time();
			$d=get_current_date();
			$task='Added Admin Name: '.$admin_name.', Admin Designation: '.$admin_designation.', Admin Gender: '.$admin_gender.', Admin Join Date: '.$admin_join_date.', Admin Resign Date: '.$admin_resign_date.', Admin Type: '.$admin_type.', Admin Email: '.$admin_email.', Admin Mobile: '.$admin_mobile.', Admin Status: '.$admin_status;
			$stmt = $conn->prepare("insert into nr_admin_history(nr_admin_member_id,nr_admin_id,nr_adminh_task,nr_adminh_date,nr_adminh_time,nr_adminh_status) values(:admin_member_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':admin_member_id', $admin_id);
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			
			
				
			echo 'Ok';
			
			
		}
		catch(PDOException $e)
		{
			echo 'Error';
			die();
		}
		catch(Exception $e)
		{
			echo 'Error';
			die();
		}

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>