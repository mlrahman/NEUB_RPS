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
				echo 'un';
				die();
			}
			$stmt = $conn->prepare("select a.nr_prcr_id,a.nr_prcr_total,b.nr_prog_title from nr_program_credit a,nr_program b where a.nr_prog_id=b.nr_prog_id and a.nr_prog_id=:course_offer_prog and a.nr_prcr_ex_date='' order by a.nr_prcr_id desc limit 1 ");
			$stmt->bindParam(':course_offer_prog', $course_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'u2';
				die();
			}
			$prcr_id=$result[0][0];
			$prog_credit=$result[0][1];
			$prog_title=$result[0][2];
			
			
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
						$course_code=trim($row[0]);
						$course_semester=trim($row[1]);
						$course_type=trim($row[2]);
						$offer_status=trim($row[3]);
						
						//check required important fields
						if($course_code=="" || $course_semester=="" || $course_type==""  || $offer_status=="")
							break;

						$logs=$logs.'<li>'.$course_code.' - '.get_semester_format($course_semester).' - '.$course_type.' - '.$offer_status.' : ';
						
						if($offer_status=='Active' || $offer_status=='Inactive')
						{
							
							//check for course code to course_id
							$stmt = $conn->prepare("select b.nr_course_id from nr_program a,nr_course b where a.nr_prog_id=b.nr_prog_id and b.nr_course_code=:course_code and a.nr_prog_id=:course_prog limit 1");
							$stmt->bindParam(':course_code', $course_code);
							$stmt->bindParam(':course_prog', $course_prog);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)>=1)
							{
								$course_id=$result[0][0];
								
								//duplicate checking
								$stmt = $conn->prepare("select * from nr_drop a,nr_program b where a.nr_prog_id=b.nr_prog_id and b.nr_prog_id=:prog_id and a.nr_course_id=:course_id and a.nr_prcr_id=(select c.nr_prcr_id from nr_program_credit c where c.nr_prog_id=b.nr_prog_id and c.nr_prcr_ex_date='' order by c.nr_prcr_id desc limit 1) ");
								$stmt->bindParam(':prog_id', $course_prog);
								$stmt->bindParam(':course_id', $course_id);
								$stmt->execute();
								$result = $stmt->fetchAll();
								if(count($result)>=1)
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (Duplicate detected)</span>';
							
								}
								else
								{
									
									$stmt = $conn->prepare("insert into nr_drop(nr_prog_id,nr_prcr_id,nr_course_id,nr_drop_remarks,nr_drop_semester,nr_drop_status) values(:course_offer_prog,:prcr_id,:course_offer_course,:course_offer_type,:course_offer_semester,:course_offer_status) ");
									$stmt->bindParam(':prcr_id', $prcr_id);
									$stmt->bindParam(':course_offer_course', $course_id);
									$stmt->bindParam(':course_offer_semester', $course_semester);
									$stmt->bindParam(':course_offer_prog', $course_prog);
									$stmt->bindParam(':course_offer_status', $offer_status);
									$stmt->bindParam(':course_offer_type', $course_type);
									$stmt->execute();
									
									//getting last inserted one
									$stmt = $conn->prepare("select nr_drop_id,b.nr_course_title,b.nr_course_code,b.nr_course_credit from nr_drop, nr_course b where nr_drop.nr_course_id=b.nr_course_id and nr_drop.nr_course_id=:course_offer_course and nr_drop_semester=:course_offer_semester and nr_drop.nr_prog_id=:course_offer_prog and nr_drop_remarks=:course_offer_type and nr_drop_status=:course_offer_status and nr_drop.nr_prcr_id=:prcr_id limit 1");
									$stmt->bindParam(':course_offer_course', $course_id);
									$stmt->bindParam(':course_offer_semester', $course_semester);
									$stmt->bindParam(':course_offer_prog', $course_prog);
									$stmt->bindParam(':course_offer_status', $offer_status);
									$stmt->bindParam(':course_offer_type', $course_type);
									$stmt->bindParam(':prcr_id', $prcr_id);
									$stmt->execute();
									$result = $stmt->fetchAll();
								
									$course_offer_id=$result[0][0];
									$course_title=$result[0][1];
									$course_code=$result[0][2];
									$course_credit=$result[0][3];
									
									
									$t=get_current_time();
									$d=get_current_date();
									$task='Added Course Title: '.$course_title.', Course Code: '.$course_code.', Course Credit: '.number_format($course_credit,2).', Course Type: '.$course_type.', Offer Semester: '.$course_semester.', Offer Program: '.$prog_title.', Program Credit: '.$prog_credit.', Offer Status: '.$offer_status;
									$stmt = $conn->prepare("insert into nr_drop_history(nr_drop_id,nr_admin_id,nr_droph_task,nr_droph_date,nr_droph_time,nr_droph_status) values(:course_offer_id,:admin_id,'$task','$d','$t','Active') ");
									$stmt->bindParam(':course_offer_id', $course_offer_id);
									$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
									$stmt->execute();
									
									$success++;
									$logs=$logs.' <span class="w3-text-green">Successful</span>';
								}								
							}
							else
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Invalid course code)</span>';
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