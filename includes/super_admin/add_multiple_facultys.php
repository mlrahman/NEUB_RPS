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
	if(isset($_REQUEST['excel']) && isset($_REQUEST['pass']) && isset($_REQUEST['faculty_dept']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$excel_name='1';
		//file delete server info required to update if needed
		$base_directory = '../../excel_files/uploaded/';
			
		try{
			$excel=trim($_REQUEST['excel']);
			$faculty_dept=trim($_REQUEST['faculty_dept']);
			$pass=trim($_REQUEST['pass']);
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'PE';
				die();
			}
			//checking if prog is add able or not
			$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:faculty_dept and nr_dept_status='Inctive'");
			$stmt->bindParam(':faculty_dept', $prog_dept);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'u2';
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
						$faculty_name=trim($row[0]);
						$faculty_designation=trim($row[1]);
						$faculty_join_date=trim($row[2]);
						if($faculty_join_date=='YYYY-MM-DD') $faculty_join_date='';
						$faculty_resign_date=trim($row[3]);
						if($faculty_resign_date=='YYYY-MM-DD') $faculty_resign_date='';
						$faculty_email=trim($row[4]);
						$faculty_mobile=trim($row[5]);
						$faculty_type=trim($row[6]);
						$faculty_gender=trim($row[7]);
						$faculty_status=trim($row[8]);
						
						
						//check required important fields
						if($faculty_name=="" || $faculty_designation=="" || $faculty_join_date==""  || $faculty_type==""  || $faculty_gender==""  || $faculty_status=="")
							break;

						$logs=$logs.'<li>'.$faculty_name.' - '.$faculty_designation.' - '.$faculty_join_date.' - '.$faculty_type.' - '.$faculty_gender.' - '.$faculty_status.' : ';
						
						if($faculty_join_date!='' && check_date($faculty_join_date)==false)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Join Date)</span>';
						}
						else if($faculty_resign_date!='' && check_date($faculty_resign_date)==false)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Resign Date)</span>';
						}
						else if($faculty_status=='Active' || $faculty_status=='Inactive')
						{
							
							$stmt = $conn->prepare("select * from nr_faculty where ((nr_faculty_email!='' and nr_faculty_email=:faculty_email) or (nr_faculty_name=:faculty_name and nr_faculty_designation=:faculty_designation and nr_faculty_join_date=:faculty_join_date))");
							$stmt->bindParam(':faculty_name', $faculty_name);
							$stmt->bindParam(':faculty_designation', $faculty_designation);
							$stmt->bindParam(':faculty_join_date', $faculty_join_date);
							$stmt->bindParam(':faculty_email', $faculty_email);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)>=1)
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Duplicate)</span>';
							}
							else
							{
								if($faculty_email!='' && email_check($faculty_email)==false)
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (Invalid Email)</span>';
								}
								else
								{
									$stmt = $conn->prepare("insert into nr_faculty (nr_faculty_name, nr_faculty_designation, nr_faculty_email, nr_faculty_cell_no, nr_faculty_join_date, nr_faculty_resign_date, nr_dept_id, nr_faculty_gender, nr_faculty_type, nr_faculty_status,nr_faculty_two_factor) values(:faculty_name, :faculty_designation, :faculty_email, :faculty_mobile, :faculty_join_date, :faculty_resign_date, :faculty_dept, :faculty_gender, :faculty_type, :faculty_status, '1') ");
									$stmt->bindParam(':faculty_name', $faculty_name);
									$stmt->bindParam(':faculty_designation', $faculty_designation);
									$stmt->bindParam(':faculty_email', $faculty_email);
									$stmt->bindParam(':faculty_mobile', $faculty_mobile);
									$stmt->bindParam(':faculty_join_date', $faculty_join_date);
									$stmt->bindParam(':faculty_resign_date', $faculty_resign_date);
									$stmt->bindParam(':faculty_dept', $faculty_dept);
									$stmt->bindParam(':faculty_type', $faculty_type);
									$stmt->bindParam(':faculty_gender', $faculty_gender);
									$stmt->bindParam(':faculty_status', $faculty_status);
									$stmt->execute();
									
									$stmt = $conn->prepare("select a.nr_dept_title,b.nr_faculty_id from nr_department a,nr_faculty b where a.nr_dept_id=:faculty_dept and a.nr_dept_id=b.nr_dept_id and b.nr_faculty_name=:faculty_name and b.nr_faculty_designation=:faculty_designation and b.nr_faculty_join_date=:faculty_join_date ");
									$stmt->bindParam(':faculty_name', $faculty_name);
									$stmt->bindParam(':faculty_designation', $faculty_designation);
									$stmt->bindParam(':faculty_join_date', $faculty_join_date);
									$stmt->bindParam(':faculty_dept', $faculty_dept);
									$stmt->execute();
									$result = $stmt->fetchAll();
									$dept_title=$result[0][0];
									$faculty_id=$result[0][1];
									
									
									if($faculty_email!='')
									{
										//sent email with password reset link
										//Creating forget password link and sending to user
										$ip_server = $_SERVER['SERVER_ADDR']; //root link 
										$token=get_link();
										$link=$ip_server.'/faculty/forget_password.php?token='.$token;
										$d=get_current_date();
										$t=get_current_time();
										$f_name=$faculty_name;
										$main_link=$ip_server.'/faculty';
										
										//clearing previous links and otps
										$stmt = $conn->prepare("delete from nr_faculty_link_token where nr_faculty_id=:f_id");
										$stmt->bindParam(':f_id', $faculty_id);
										$stmt->execute();
										
										//Inserting new OTPs
										$stmt = $conn->prepare("insert into nr_faculty_link_token values(:f_id,'$token','Forget Password','$d','$t','Active') ");
										$stmt->bindParam(':f_id', $faculty_id);
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
								
										//sending password recovery link to user
										$msg="Dear ".$f_name.", Welcome to ".$title." faculty panel. Your email ".$faculty_email." is set for the login access in <a href='".$main_link."' target='_blank'>faculty panel</a> of ".$title.". You can set your password from the following link: <a href='https://".$link."' target='_blank'>".$link."</a><p>&nbsp;</p><b>Note:</b> It is an one time link so be careful during the access, do not reload the page. For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
										$message = '<html><body>';
										$message .= '<h1>Log In Access from - '.$title.'</h1><p>  </p>';
										$message .= '<p><b>Message Details:</b></p>';
										$message .= '<p>'.$msg.'</p></body></html>';
										
										
										sent_mail($faculty_email,$title.' - Log In Access',$message,$title,$contact_email);
										
									}
									
									if($faculty_resign_date=='') $faculty_resign_date='N/A';
									if($faculty_email=='') $faculty_email='N/A';
									if($faculty_mobile=='') $faculty_mobile='N/A';
			
									
									$t=get_current_time();
									$d=get_current_date();
									$task='Added Faculty Name: '.$faculty_name.', Faculty Designation: '.$faculty_designation.', Faculty Gender: '.$faculty_gender.', Faculty Join Date: '.$faculty_join_date.', Faculty Resign Date: '.$faculty_resign_date.', Faculty Department: '.$dept_title.', Faculty Type: '.$faculty_type.', Faculty Email: '.$faculty_email.', Faculty Mobile: '.$faculty_mobile.', Faculty Status: '.$faculty_status;
									$stmt = $conn->prepare("insert into nr_faculty_history(nr_faculty_id,nr_admin_id,nr_facultyh_task,nr_facultyh_date,nr_facultyh_time,nr_facultyh_status) values(:faculty_id,:admin_id,'$task','$d','$t','Active') ");
									$stmt->bindParam(':faculty_id', $faculty_id);
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