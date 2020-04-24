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
	if(isset($_REQUEST['excel']) && isset($_REQUEST['pass']) && isset($_REQUEST['course_prog']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$excel_name='1';
		//file delete server info required to update if needed
		$base_directory = '../../excel_files/uploaded/';
			
		try{
			$excel=trim($_REQUEST['excel']);
			$course_prog=trim($_REQUEST['course_prog']);
			$pass=trim($_REQUEST['pass']);
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'PE';
				die();
			}
			//checking if prog is active or not
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=:course_prog and nr_prog_status='Inctive'");
			$stmt->bindParam(':course_prog', $course_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable2';
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
						$course_title=trim($row[0]);
						$course_code=trim($row[1]);
						$course_credit=trim($row[2]);
						$course_status=trim($row[3]);
						
						//check required important fields
						if($course_title=="" || $course_code=="" || $course_credit==""  || $course_status=="")
							break;

						$logs=$logs.'<li>'.$course_title.' - '.$course_code.' - '.$course_credit.' - '.$course_status.' : ';
						
						if($course_status=='Active' || $course_status=='Inactive')
						{
							
							//checking if course is add able or not
							$stmt = $conn->prepare("select * from nr_course where and nr_prog_id=:course_prog and (nr_course_title=:course_title or nr_course_code=:course_code) ");
							$stmt->bindParam(':course_title', $course_title);
							$stmt->bindParam(':course_prog', $course_prog);
							$stmt->bindParam(':course_code', $course_code);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)>=1)
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Duplicate)</span>';
							}
							else
							{
								$stmt = $conn->prepare("insert into nr_course(nr_course_title,nr_course_code,nr_prog_id,nr_course_status,nr_course_credit) values(:course_title,:course_code,:course_prog,:course_status,:course_credit) ");
								$stmt->bindParam(':course_title', $course_title);
								$stmt->bindParam(':course_code', $course_code);
								$stmt->bindParam(':course_prog', $course_prog);
								$stmt->bindParam(':course_status', $course_status);
								$stmt->bindParam(':course_credit', $course_credit);
								$stmt->execute();
								
								//getting last inserted one
								$stmt = $conn->prepare("select a.nr_course_id,b.nr_prog_title from nr_course a,nr_program b where a.nr_prog_id=b.nr_prog_id and a.nr_prog_id=:course_prog and a.nr_course_title=:course_title and a.nr_course_code=:course_code and a.nr_course_status=:course_status and a.nr_course_credit=:course_credit limit 1");
								$stmt->bindParam(':course_title', $course_title);
								$stmt->bindParam(':course_code', $course_code);
								$stmt->bindParam(':course_prog', $course_prog);
								$stmt->bindParam(':course_status', $course_status);
								$stmt->bindParam(':course_credit', $course_credit);
								$stmt->execute();
								$result = $stmt->fetchAll();
							
								$course_id=$result[0][0];
								$prog_title=$result[0][1];
								$t=get_current_time();
								$d=get_current_date();
								
								
								$task='Edited Course Title: '.$course_title.', Course Code: '.$course_code.', Course Credit: '.$course_credit.', Course Program: '.$prog_title.', Course Status: '.$course_status;
								$stmt = $conn->prepare("insert into nr_course_history(nr_course_id,nr_admin_id,nr_courseh_task,nr_courseh_date,nr_courseh_time,nr_courseh_status) values(:course_id,:admin_id,'$task','$d','$t','Active') ");
								$stmt->bindParam(':course_id', $course_id);
								$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
								$stmt->execute();
								
								
								$success++;
								$logs=$logs.' <span class="w3-text-green">Successful</span>';
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