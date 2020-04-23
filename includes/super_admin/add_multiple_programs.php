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
	if(isset($_REQUEST['excel']) && isset($_REQUEST['pass']) && isset($_REQUEST['prog_dept']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$excel_name='1';
		//file delete server info required to update if needed
		$base_directory = '../../excel_files/uploaded/';
			
		try{
			$excel=trim($_REQUEST['excel']);
			$prog_dept=trim($_REQUEST['prog_dept']);
			$pass=trim($_REQUEST['pass']);
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'PE';
				die();
			}
			//checking if prog is add able or not
			$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:prog_dept and nr_dept_status='Inctive'");
			$stmt->bindParam(':prog_dept', $prog_dept);
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
						$prog_title=trim($row[0]);
						$prog_code=trim($row[1]);
						$prog_credit=trim($row[2]);
						$prog_status=trim($row[3]);
						
						//check required important fields
						if($prog_title=="" || $prog_code=="" || $prog_credit==""  || $prog_status=="")
							break;

						$logs=$logs.'<li>'.$prog_title.' - '.$prog_code.' - '.$prog_credit.' - '.$prog_status.' : ';
						
						if($prog_status=='Active' || $prog_status=='Inactive')
						{
							
							//checking if prog is add able or not
							$stmt = $conn->prepare("select * from nr_program where nr_prog_title=:prog_title or nr_prog_code=:prog_code ");
							$stmt->bindParam(':prog_title', $prog_title);
							$stmt->bindParam(':prog_code', $prog_code);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)>=1)
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Duplicate)</span>';
							}
							else
							{
								$stmt = $conn->prepare("insert into nr_program(nr_dept_id,nr_prog_title,nr_prog_code,nr_prog_status) values(:prog_dept,:prog_title,:prog_code,:prog_status) ");
								$stmt->bindParam(':prog_dept', $prog_dept);
								$stmt->bindParam(':prog_title', $prog_title);
								$stmt->bindParam(':prog_code', $prog_code);
								$stmt->bindParam(':prog_status', $prog_status);
								$stmt->execute();
								
								//getting last inserted one
								$stmt = $conn->prepare("select a.nr_prog_id,b.nr_dept_title from nr_program a,nr_department b where a.nr_dept_id=b.nr_dept_id and a.nr_dept_id=:prog_dept and a.nr_prog_title=:prog_title and a.nr_prog_code=:prog_code and a.nr_prog_status=:prog_status limit 1");
								$stmt->bindParam(':prog_title', $prog_title);
								$stmt->bindParam(':prog_code', $prog_code);
								$stmt->bindParam(':prog_dept', $prog_dept);
								$stmt->bindParam(':prog_status', $prog_status);
								$stmt->execute();
								$result = $stmt->fetchAll();
							
								$prog_id=$result[0][0];
								$dept_title=$result[0][1];
			
								$t=get_current_time();
								$d=get_current_date();
								
								
								//insert into prcr
								$stmt = $conn->prepare("insert into nr_program_credit(nr_prog_id,nr_prcr_total,nr_prcr_date,nr_prcr_status) values(:prog_id,:prog_credit,'$d','Active') ");
								$stmt->bindParam(':prog_id', $prog_id);
								$stmt->bindParam(':prog_credit', $prog_credit);
								$stmt->execute();
								
								
								$task='Added program Title: '.$prog_title.', program Code: '.$prog_code.', Program Credit: '.$prog_credit.', Program Department: '.$dept_title.', program Status: '.$prog_status;
								$stmt = $conn->prepare("insert into nr_program_history(nr_prog_id,nr_admin_id,nr_progh_task,nr_progh_date,nr_progh_time,nr_progh_status) values(:prog_id,:admin_id,'$task','$d','$t','Active') ");
								$stmt->bindParam(':prog_id', $prog_id);
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