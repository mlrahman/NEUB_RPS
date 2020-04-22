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
						$dept_title=trim($row[0]);
						$dept_code=trim($row[1]);
						$dept_status=trim($row[2]);
						
						//check required important fields
						if($dept_title=="" || $dept_code==""  || $dept_status=="")
							break;

						$logs=$logs.'<li>'.$dept_title.' - '.$dept_code.' - '.$dept_status.' : ';
						
						if($dept_status=='Active' || $dept_status=='Inactive')
						{
							
							//checking if dept is add able or not
							$stmt = $conn->prepare("select * from nr_department where nr_dept_title=:dept_title or nr_dept_code=:dept_code");
							$stmt->bindParam(':dept_title', $dept_title);
							$stmt->bindParam(':dept_code', $dept_code);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)>=1)
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Duplicate)</span>';
							}
							else
							{
								$stmt = $conn->prepare("insert into nr_department(nr_dept_title,nr_dept_code,nr_dept_status) values(:dept_title,:dept_code,:dept_status) ");
								$stmt->bindParam(':dept_title', $dept_title);
								$stmt->bindParam(':dept_code', $dept_code);
								$stmt->bindParam(':dept_status', $dept_status);
								$stmt->execute();
								
								//getting last inserted one
								$stmt = $conn->prepare("select nr_dept_id from nr_department where nr_dept_title=:dept_title and nr_dept_code=:dept_code and nr_dept_status=:dept_status limit 1");
								$stmt->bindParam(':dept_title', $dept_title);
								$stmt->bindParam(':dept_code', $dept_code);
								$stmt->bindParam(':dept_status', $dept_status);
								$stmt->execute();
								$result = $stmt->fetchAll();
							
								$dept_id=$result[0][0];
								$t=get_current_time();
								$d=get_current_date();
								$task='Added Department Title: '.$dept_title.', Department Code: '.$dept_code.', Department Status: '.$dept_status;
								$stmt = $conn->prepare("insert into nr_department_history(nr_dept_id,nr_admin_id,nr_depth_task,nr_depth_date,nr_depth_time,nr_depth_status) values(:dept_id,:admin_id,'$task','$d','$t','Active') ");
								$stmt->bindParam(':dept_id', $dept_id);
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