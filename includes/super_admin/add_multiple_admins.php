<?php
	session_start();
	require("../db_connection.php"); 
	require("../function.php"); 
	require("../library/excel_reader/SimpleXLS.php");

	try{
		require("logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	if(isset($_REQUEST['excel']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$excel_name='1';
		//file delete server info required to update if needed
		$base_directory = '../../excel_files/uploaded/';
			
		try{
			$excel=trim($_REQUEST['excel']);
			$pass=trim($_REQUEST['pass']);
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'PE';
				die();
			}
			
			//uploading excel file
			$excel=$excel;
			$file=$_FILES[$excel];
			$excel_name=file_upload($file,0,100000,"xlsx",'../../excel_files/uploaded/',$path='');
			if($excel_name!="1")
			{
				if ( $xlsx = SimpleXLSX::parse('../../excel_files/uploaded/'.$excel_name) ) 
				{
					$c=0;
					$success=0;
					$failed=0;
					$logs='<ol>';
					foreach ( $xlsx->rows() as $r => $row ) {
						$c++;
						if($c==1) continue;
						$admin_name=trim($row[0]);
						$admin_designation=trim($row[1]);
						$admin_join_date=trim($row[2]);
						if($admin_join_date=='YYYY-MM-DD') $admin_join_date='';
						$admin_resign_date=trim($row[3]);
						if($admin_resign_date=='YYYY-MM-DD') $admin_resign_date='';
						$admin_email=trim($row[4]);
						$admin_mobile=trim($row[5]);
						$admin_type=trim($row[6]);
						$admin_gender=trim($row[7]);
						$admin_status=trim($row[8]);
						
						
						//check required important fields
						if($admin_name=="" || $admin_designation=="" || $admin_join_date==""  || $admin_type==""  || $admin_gender==""  || $admin_status=="")
							break;

						$logs=$logs.'<li>'.$admin_name.' - '.$admin_designation.' - '.$admin_join_date.' - '.$admin_type.' - '.$admin_gender.' - '.$admin_status.' : ';
						
						if($admin_join_date!='' && check_date($admin_join_date)==false)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Join Date)</span>';
						}
						else if($admin_resign_date!='' && check_date($admin_resign_date)==false)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Resign Date)</span>';
						}
						else if($admin_status=='Active' || $admin_status=='Inactive')
						{
							
							$stmt = $conn->prepare("select * from nr_admin where ((nr_admin_email!='' and nr_admin_email=:admin_email) or (nr_admin_name=:admin_name and nr_admin_designation=:admin_designation and nr_admin_join_date=:admin_join_date))");
							$stmt->bindParam(':admin_name', $admin_name);
							$stmt->bindParam(':admin_designation', $admin_designation);
							$stmt->bindParam(':admin_join_date', $admin_join_date);
							$stmt->bindParam(':admin_email', $admin_email);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)>=1)
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Duplicate)</span>';
							}
							else
							{
								if($admin_email!='' && email_check($admin_email)==false)
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (Invalid Email)</span>';
								}
								else
								{
									$stmt = $conn->prepare("insert into nr_admin (nr_admin_name, nr_admin_designation, nr_admin_email, nr_admin_cell_no, nr_admin_join_date, nr_admin_resign_date, nr_admin_gender, nr_admin_type, nr_admin_status, nr_admin_two_factor) values(:admin_name, :admin_designation, :admin_email, :admin_mobile, :admin_join_date, :admin_resign_date, :admin_gender, :admin_type, :admin_status, '1') ");
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
								
										$msg="Dear ".$f_name.", Welcome to ".$title." ".strtolower($admin_type)." panel. Your email ".$admin_email." is set for the login access in <a href='".$main_link."' target='_blank'>".strtolower($admin_type)." panel</a> of ".$title.". You can set your password from the following link: <a href='https://".$link."' target='_blank'>".$link."</a><p>&nbsp;</p><b>Note:</b> It is an one time link so be careful during the access, do not reload the page. For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
										$message = '<html><body>';
										$message .= '<h1>Log In Access from - '.$title.'</h1><p>  </p>';
										$message .= '<p><b>Message Details:</b></p>';
										$message .= '<p>'.$msg.'</p></body></html>';
										
										
										sent_mail($admin_email,$title.' - Log In Access',$message,$title,$contact_email);
										
									}
									
									if($admin_resign_date=='') $admin_resign_date='N/A';
									if($admin_email=='') $admin_email='N/A';
									if($admin_mobile=='') $admin_mobile='N/A';
			
									
									$t=get_current_time();
									$d=get_current_date();
									$task='Added Admin Name: '.$admin_name.', Admin Designation: '.$admin_designation.', Admin Gender: '.$admin_gender.', Admin Join Date: '.$admin_join_date.', Admin Resign Date: '.$admin_resign_date.', Admin Type: '.$admin_type.', Admin Email: '.$admin_email.', Admin Mobile: '.$admin_mobile.', Admin Status: '.$admin_status;
									$stmt = $conn->prepare("insert into nr_admin_history(nr_admin_member_id,nr_admin_id,nr_adminh_task,nr_adminh_date,nr_adminh_time,nr_adminh_status) values(:admin_member_id,:admin_id,'$task','$d','$t','Active') ");
									$stmt->bindParam(':admin_member_id', $admin_id);
									$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
									$stmt->execute();
									
									$success++;
									$logs=$logs.' <span class="w3-text-green">Successful</span>';
								}
							}
						}
						else
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Value Exception)</span>';
						}
						$logs=$logs.'</li>';
					}
					unlink($base_directory.$excel_name);
					$logs=$logs.'</ol>';
					
					echo 'Ok@'.$success.' Successful@'.$failed.' Failed@Total: '.($success+$failed).'@'.$logs.'@';
					
				} else {
					
					unlink($base_directory.$excel_name);
					echo 'Error';
					die();
				}
				
			}
			else
			{
				echo 'Error';
				die();
			}
		
		}
		catch(PDOException $e)
		{
			if($excel_name!="1")
			{
				unlink($base_directory.$excel_name);
			}
			echo 'Error';
			die();
		}
		catch(Exception $e)
		{
			if($excel_name!="1")
			{
				unlink($base_directory.$excel_name);
			}
			echo 'Error';
			die();
		}
		
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>