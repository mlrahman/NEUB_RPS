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
	if(isset($_REQUEST['faculty_id']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$faculty_id=trim($_REQUEST['faculty_id']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$fl=0; 
			//checking if faculty is delete able or not
			$stmt = $conn->prepare("select * from nr_result where nr_faculty_id=:faculty_id");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$fl=1;
				echo 'unable';
				die();
			}
			
			/********** Inserting delete history ******/
			$stmt = $conn->prepare("select a.nr_faculty_id,a.nr_faculty_name, a.nr_faculty_designation,a.nr_faculty_join_date,a.nr_faculty_resign_date,a.nr_faculty_type,b.nr_dept_id,b.nr_Dept_title,a.nr_faculty_email,a.nr_faculty_status,a.nr_faculty_gender,a.nr_faculty_photo,a.nr_faculty_cell_no from nr_faculty a,nr_department b where a.nr_dept_id=b.nr_dept_id and nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			$faculty_name=$result[0][1];
			$faculty_designation=$result[0][2];
			$faculty_join_date=$result[0][3];
			$faculty_resign_date=$result[0][4];
			if($faculty_resign_date=="")$faculty_resign_date='N/A';
			$faculty_type=$result[0][5];
			$dept_id=$result[0][6];
			$dept_title=$result[0][7];
			$faculty_email=$result[0][8];
			if($faculty_email=="")$faculty_email='N/A';
			$status=$result[0][9];
			$faculty_gender=$result[0][10];
			$photo=$result[0][11];
			$faculty_mobile=$result[0][12];
			if($faculty_mobile=="")$faculty_mobile='N/A';
			if($photo!="")
			{
				//file delete server info required to update if needed
				$base_directory = '../../images/faculty/';
				unlink($base_directory.$photo);
			}
			
			if($faculty_email!='')
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
				$f_name=$faculty_name;
				//sending password recovery link to user
				$msg="Dear ".$f_name.", Your ID with ".$faculty_email." is removed by the admin. You can not access the faculty panel of ".$title." anymore. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>ID Removed from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($faculty_email,$title.' - ID Removed Notification',$message,$title,$contact_email);
				
				
			}
			
		
			$t=get_current_time();
			$d=get_current_date();
			$task='Deleted Faculty Name: '.$faculty_name.', Faculty Designation: '.$faculty_designation.', Faculty Gender: '.$faculty_gender.', Faculty Join Date: '.$faculty_join_date.', Faculty Resign Date: '.$faculty_resign_date.', Faculty Department: '.$dept_title.', Faculty Type: '.$faculty_type.', Faculty Email: '.$faculty_email.', Faculty Mobile: '.$faculty_mobile.', Faculty Status: '.$status;
			$stmt = $conn->prepare("insert into nr_delete_history(nr_admin_id,nr_deleteh_task,nr_deleteh_date,nr_deleteh_time,nr_deleteh_status,nr_deleteh_type) values(:admin_id,'$task','$d','$t','Active','Faculty') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			/***********************/
			
			
			$stmt = $conn->prepare("delete from nr_faculty_history where nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_faculty_link_token where nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_faculty_result_check_transaction where nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_faculty_login_transaction where nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			
			$stmt = $conn->prepare("delete from nr_transcript_print_reference where nr_trprre_printed_by='Faculty' and nr_trprre_user_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->execute();
			
			
			$stmt = $conn->prepare("delete from nr_faculty where nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
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