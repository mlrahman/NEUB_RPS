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
	if(isset($_REQUEST['student_old_email']) && isset($_REQUEST['student_old_id']) && isset($_REQUEST['student_status']) && isset($_REQUEST['student_gender']) && isset($_REQUEST['student_birth_date']) && isset($_REQUEST['student_id']) && isset($_REQUEST['student_name']) && isset($_REQUEST['student_dp']) && isset($_REQUEST['student_dp_2']) && isset($_REQUEST['student_email']) && isset($_REQUEST['student_mobile']) && isset($_REQUEST['student_prog']) && isset($_REQUEST['student_old_prog']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$student_id=trim($_REQUEST['student_id']);
			$student_old_id=trim($_REQUEST['student_old_id']);
			$student_name=trim($_REQUEST['student_name']);
			$student_dp=trim($_REQUEST['student_dp']);
			$student_dp_2=trim($_REQUEST['student_dp_2']);
			$student_email=trim($_REQUEST['student_email']);
			$old_email=trim($_REQUEST['student_old_email']);
			$student_mobile=trim($_REQUEST['student_mobile']);
			$student_prog=trim($_REQUEST['student_prog']);
			$student_old_prog=trim($_REQUEST['student_old_prog']);
			$student_birth_date=trim($_REQUEST['student_birth_date']);
			$student_gender=trim($_REQUEST['student_gender']);
			$student_status=trim($_REQUEST['student_status']);
			
			
			//checking if student is add able or not
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id!=:student_id and ((nr_stud_email!='' and nr_stud_email=:student_email) or (nr_stud_name=:student_name and nr_stud_dob=:student_birth_date))");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':student_name', $student_name);
			$stmt->bindParam(':student_birth_date', $student_birth_date);
			$stmt->bindParam(':student_email', $student_email);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			if($student_id!=$student_old_id)
			{
				echo 'unable';
				die();
			}
			
			
			if($student_email!='' && email_check($student_email)==false)
			{
				echo 'unable2';
				die();
			}
			
			//checking if prog is active or not
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=:prog_id and nr_prog_status='Inactive' ");
			$stmt->bindParam(':prog_id', $student_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable3';
				die();
			}
			
			
			$stmt = $conn->prepare("select nr_studi_graduated from nr_student_info where nr_stud_id=:s_id limit 1 ");
			$stmt->bindParam(':s_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll=0;
			if(count($result)!=0)
			{
				$flll=$result[0][0];
			}
			
			//getting old program credit id
			$stmt = $conn->prepare("select nr_prcr_id from nr_student where nr_stud_id=:stud_id order by nr_stud_id desc limit 1");
			$stmt->bindParam(':stud_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'Error';
				die();
			}
			$prcr_id=$result[0][0];
			
			
			if($student_email!='' && $student_email!=$old_email)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_stud_email=:email limit 1");
				$stmt->bindParam(':email', $student_email);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)>0)
				{
					echo 'unable5';
					die();
				}
			}
			
			
			
			
			//check program is changed or not .... and active or not 
			if($student_old_prog!=$student_prog && $flll==1)
			{
				echo 'unable4';
				die();
			}
			else if($student_old_prog!=$student_prog && $flll==0)
			{
				//getting new program credit id
				$stmt = $conn->prepare("select nr_prcr_id from nr_program_credit where nr_prog_id=:prog_id and nr_prcr_status='Active' and nr_prcr_ex_date='' order by nr_prcr_id desc limit 1");
				$stmt->bindParam(':prog_id', $student_prog);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==0)
				{
					echo 'Error';
					die();
				}
				$prcr_id=$result[0][0];

				
				$stmt = $conn->prepare("delete from nr_admin_result_check_transaction where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_faculty_result_check_transaction where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_result_check_transaction where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_transcript_print_reference where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_result_history where nr_result_id in (select nr_result_id from nr_result where nr_stud_id=:stud_id ) ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_result where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_student_waived_credit where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				$stmt = $conn->prepare("delete from nr_student_semester_cgpa where nr_stud_id=:stud_id ");
				$stmt->bindParam(':stud_id', $student_id);
				$stmt->execute();
				
				
			}
			
			if($student_email=='' && $old_email!='')
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
				$f_name=$student_name;
				
				
				//sending password recovery link to user
				$msg="Dear ".$f_name.", Your email ".$old_email." is replaced by the admin. You will not get any update of your Student ID: ".$student_id." from ".$title." using this email anymore. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Email Change Notification from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($old_email,$title.' - Email Change Notification',$message,$title,$contact_email);
					
				
			}
			else if($student_email!='' && $student_email!=$old_email)
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
				$f_name=$student_name;
				
				if($old_email!='')//notify old email
				{
					//sending password recovery link to user
					$msg="Dear ".$f_name.", Your email ".$old_email." is replaced by the admin. You will not get any update or OTPs of your Student ID: ".$student_id." from ".$title." using this email anymore. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
					$message = '<html><body>';
					$message .= '<h1>Email Change Notification from - '.$title.'</h1><p>  </p>';
					$message .= '<p><b>Message Details:</b></p>';
					$message .= '<p>'.$msg.'</p></body></html>';
					
					
					sent_mail($old_email,$title.' - Email Change Notification',$message,$title,$contact_email);
					
				}
				//notify new email
				
				
				//sending password recovery link to user
				$msg="Dear ".$f_name.", Welcome to ".$title." student panel service. Your email ".$student_email." is set for the notification and two factor authentication(2FA) service in ".$title.". You will get all the updates and OTPs for 2FA of your Student ID: ".$student_id." from ".$title." using this email. <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
				$message = '<html><body>';
				$message .= '<h1>Email Registered for Notification and 2FA from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($student_email,$title.' - Email Registered for Notification and 2FA',$message,$title,$contact_email);
				
			}
			
			
			//dealing with photo
			$stmt = $conn->prepare("select a.nr_stud_photo,b.nr_prog_title from nr_student a,nr_program b where a.nr_stud_id=:student_id and a.nr_prog_id=b.nr_prog_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$photo=$result[0][0];
			$prog_title=$result[0][1];
			
			$base_directory = '../../images/student/';
		
			
			$image_name='';
			if($student_dp!="")
			{
				//uploading student photo
				$link=$student_dp_2;
				$file=$_FILES[$link];
				$image_name=photo_upload($file,0,100000,"jpg,gif,png,jpeg,bmp,heic",'../../images/student',$path='');
				if($image_name!="1")
				{
					$image_name_rsz=photo_resize('../../images/student/', $image_name, '' , '../../images/student/', 300, 360); 
					if($image_name_rsz!="done")
					{
						unlink($base_directory.$image_name);
						$image_name='';
					}
				}
				else
				{
					$image_name='';
				}
			}
			
			if($image_name!="" && $photo!="")
			{
				unlink($base_directory.$photo);
			}
			else if($photo!="" && $image_name=="")
			{
				$image_name=$photo;
			}
			
			$stmt = $conn->prepare("update nr_student set nr_stud_name=:student_name, nr_stud_dob=:student_birth_date,nr_stud_email=:student_email,nr_stud_cell_no=:student_mobile,nr_prog_id=:student_prog,nr_prcr_id=:prcr_id,nr_stud_gender=:student_gender,nr_stud_status=:student_status,nr_stud_photo=:student_dp where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':student_name', $student_name);
			$stmt->bindParam(':student_birth_date', $student_birth_date);
			$stmt->bindParam(':student_email', $student_email);
			$stmt->bindParam(':student_mobile', $student_mobile);
			$stmt->bindParam(':student_prog', $student_prog);
			$stmt->bindParam(':prcr_id', $prcr_id);
			$stmt->bindParam(':student_dp', $image_name);
			$stmt->bindParam(':student_gender', $student_gender);
			$stmt->bindParam(':student_status', $student_status);
			$stmt->execute();
			
			$x=get_student_info($student_id,$prcr_id);
			$dropout=$x['dropout'];
			$graduated=$x['graduated'];
			$cgpa=$x['cgpa'];
			$last_semester=$x['last_semester'];
			$last_year=$x['last_year'];
			$drop_semester=$x['drop_semester'];
			$drop_year=$x['drop_year'];
			$earned_credit=$x['earned_credit'];
			$waived_credit=$x['waived_credit'];
			$t=get_current_time();
			$d=get_current_date();
			
			$stmt = $conn->prepare("update nr_student_info set nr_studi_dropout=:dropout, nr_studi_graduated=:graduated, nr_studi_cgpa=:cgpa,nr_studi_last_semester=:last_semester,nr_studi_last_year=:last_year,nr_studi_publish_date='$d',nr_studi_status='Active', nr_studi_drop_semester=:drop_semester,nr_studi_drop_year=:drop_year,nr_studi_earned_credit=:earned_credit,nr_studi_waived_credit=:waived_credit where nr_stud_id=:student_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->bindParam(':dropout', $dropout);
			$stmt->bindParam(':graduated', $graduated);
			$stmt->bindParam(':cgpa', $cgpa);
			$stmt->bindParam(':last_semester', $last_semester);
			$stmt->bindParam(':last_year', $last_year);
			$stmt->bindParam(':drop_semester', $drop_semester);
			$stmt->bindParam(':drop_year', $drop_year);
			$stmt->bindParam(':earned_credit', $earned_credit);
			$stmt->bindParam(':waived_credit', $waived_credit);
			$stmt->execute();
			
			
			$stmt = $conn->prepare("select b.nr_prog_title from nr_student a,nr_program b where a.nr_stud_id=:student_id and a.nr_prog_id=b.nr_prog_id ");
			$stmt->bindParam(':student_id', $student_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$prog_title=$result[0][0];
			
			
			if($student_email=='') $student_email='N/A';
			if($student_mobile=='') $student_mobile='N/A';
			$task='Edited Student Name: '.$student_name.', Student DOB: '.$student_birth_date.', Student Gender: '.$student_gender.', Student Email: '.$student_email.', Student Mobile: '.$student_mobile.', Student Program: '.$prog_title.', Student CGPA: '.number_format($cgpa,2).', Earned Credit: '.$earned_credit.', Waived Credit: '.$waived_credit.', Student Status: '.$student_status;
			$stmt = $conn->prepare("insert into nr_student_history(nr_stud_id,nr_admin_id,nr_studh_task,nr_studh_date,nr_studh_time,nr_studh_status) values(:student_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':student_id', $student_id);
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