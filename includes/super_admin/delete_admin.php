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
	if($_SESSION['admin_type']!='Super Admin'){
		header("location: index.php");
		die();
	}
	if(isset($_REQUEST['admin_member_id']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$admin_member_id=trim($_REQUEST['admin_member_id']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$fl=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_course_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl=1;
				echo 'unable';
				die();
			}
			
			$fl1=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_delete_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl1=1;
				echo 'unable';
				die();
			}
			
			$fl2=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_department_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl2=1;
				echo 'unable';
				die();
			}
			
			$fl3=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_drop_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl3=1;
				echo 'unable';
				die();
			}
			
			$fl4=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_faculty_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl4=1;
				echo 'unable';
				die();
			}
			
			$fl5=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_program_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl5=1;
				echo 'unable';
				die();
			}
			
			$fl6=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_result_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl6=1;
				echo 'unable';
				die();
			}
			
			$fl7=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_student_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl7=1;
				echo 'unable';
				die();
			}
			
			$fl8=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_system_component where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl8=1;
				echo 'unable';
				die();
			}
			
			$fl9=0; 
			//checking if admin is delete able or not
			$stmt = $conn->prepare("select * from nr_admin_history where nr_admin_id=:admin_member_id");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl9=1;
				echo 'unable';
				die();
			}
				
			
			/********** Inserting delete history ******/
			$stmt = $conn->prepare("select a.nr_admin_id,a.nr_admin_name, a.nr_admin_designation,a.nr_admin_join_date,a.nr_admin_resign_date,a.nr_admin_type,a.nr_admin_email,a.nr_admin_status,a.nr_admin_gender,a.nr_admin_photo,a.nr_admin_cell_no from nr_admin a where a.nr_admin_id=:admin_member_id ");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			$admin_name=$result[0][1];
			$admin_designation=$result[0][2];
			$admin_join_date=$result[0][3];
			$admin_resign_date=$result[0][4];
			if($admin_resign_date=="")$admin_resign_date='N/A';
			$admin_type=$result[0][5];
			
			if($admin_type=='Super Admin')
			{
				echo 'unable';
				die();
			}
			
			$admin_email=$result[0][6];
			if($admin_email=="")$admin_email='N/A';
			$status=$result[0][7];
			$admin_gender=$result[0][8];
			$photo=$result[0][9];
			$admin_mobile=$result[0][10];
			if($admin_mobile=="")$admin_mobile='N/A';
			if($photo!="")
			{
				if($admin_type=="Moderator"){ $x='moderator'; } else { $x='admin'; }
				//file delete server info required to update if needed
				$base_directory = '../../images/'.$x.'/';
				unlink($base_directory.$photo);
			}
			
			if($admin_email!='')
			{
				//sent email with password reset link
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
				$f_name=$admin_name;
				//sending password recovery link to user
				$msg="Dear ".$f_name.", Your ID with ".$admin_email." is removed by the super admin. You can not access the ".strtolower($admin_type)." panel of ".$title." anymore. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>ID Removed from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($admin_email,$title.' - ID Removed Notification',$message,$title,$contact_email);
				
				
			}
			
		
			$t=get_current_time();
			$d=get_current_date();
			$task='Deleted Admin Name: '.$admin_name.', Admin Designation: '.$admin_designation.', Admin Gender: '.$admin_gender.', Admin Join Date: '.$admin_join_date.', Admin Resign Date: '.$admin_resign_date.', Admin Type: '.$admin_type.', Admin Email: '.$admin_email.', Admin Mobile: '.$admin_mobile.', Admin Status: '.$status;
			$stmt = $conn->prepare("insert into nr_delete_history(nr_admin_id,nr_deleteh_task,nr_deleteh_date,nr_deleteh_time,nr_deleteh_status,nr_deleteh_type) values(:admin_id,'$task','$d','$t','Active','Admin') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			/***********************/
			
			
		
			$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:admin_member_id ");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_admin_login_transaction where nr_admin_id=:admin_member_id ");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_admin_result_check_transaction where nr_admin_id=:admin_member_id ");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_transcript_print_reference where (nr_trprre_printed_by='Admin' or nr_trprre_printed_by='Moderator' or nr_trprre_printed_by='Super Admin') and nr_trprre_user_id=:admin_member_id ");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_admin where nr_admin_id=:admin_member_id ");
			$stmt->bindParam(':admin_member_id', $admin_member_id);
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