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
						$student_id=trim($row[0]);
						$course_code=trim($row[1]);
						
						//check required important fields
						if($student_id=="" || $course_code=="")
							break;
						
						$logs=$logs.'<li>'.$student_id.' - '.$course_code.' : ';
						
						
						$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:student_id and nr_stud_status='Active' and nr_prog_id in (select nr_prog_id from nr_course where nr_course_code=:course_code and nr_course_status='Active')");
						$stmt->bindParam(':course_code', $course_code);
						$stmt->bindParam(':student_id', $student_id);
						$stmt->execute();
						$result = $stmt->fetchAll();
						if(strlen($student_id)!=12 || count($result)==0)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Student ID or Course Code)</span>';
						}
						else
						{
							$stmt = $conn->prepare("select * from nr_course where nr_course_code=:course_code and (nr_course_id in(select nr_course_id from nr_result where nr_stud_id=:student_id) or nr_course_id in(select nr_course_id from nr_student_waived_credit where nr_stud_id=:student_id)) ");
							$stmt->bindParam(':student_id', $student_id);
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
								$stmt = $conn->prepare("select nr_studi_graduated from nr_student_info where nr_stud_id=:student_id ");
								$stmt->bindParam(':student_id', $student_id);
								$stmt->execute();
								$result = $stmt->fetchAll();
								if(count($result)>=1)
								{
									if($result[0][0]==1)
									{
										$failed++;
										$logs=$logs.' <span class="w3-text-red">Failed (Student Graduated)</span>';
						
									}
									else
									{
										$stmt = $conn->prepare("select nr_course_id from nr_course where nr_course_code=:course_code and nr_course_status='Active' and nr_prog_id in (select nr_prog_id from nr_student where nr_stud_id=:student_id and nr_stud_status='Active') limit 1");
										$stmt->bindParam(':course_code', $course_code);
										$stmt->bindParam(':student_id', $student_id);
										$stmt->execute();
										$result = $stmt->fetchAll();
										if(count($result)==0)
										{
											$failed++;
											$logs=$logs.' <span class="w3-text-red">Failed (Invalid Student ID or Course Code)</span>';
						
										}
										else
										{
											$course_id=$result[0][0];
											
											
											$stmt = $conn->prepare("select nr_prcr_id,nr_stud_email,nr_stud_cell_no,nr_stud_name,nr_stud_dob,nr_stud_gender,nr_stud_status from nr_student where nr_stud_id=:student_id ");
											$stmt->bindParam(':student_id', $student_id);
											$stmt->execute();
											$result = $stmt->fetchAll();
											$prcr_id = $result[0][0];
											$student_email=$result[0][1];
											$student_mobile=$result[0][2];
											$student_name=$result[0][3];
											$student_birth_date=$result[0][4];
											$student_gender=$result[0][5];
											$student_status=$result[0][6];
											
											$t=get_current_time();
											$d=get_current_date();
											
											$stmt = $conn->prepare("insert into nr_student_waived_credit(nr_stud_id,nr_course_id,nr_stwacr_date,nr_stwacr_status) values(:student_id,:student_waive_course,'$d','Active')");
											$stmt->bindParam(':student_waive_course', $course_id);
											$stmt->bindParam(':student_id', $student_id);
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
											
											
											
											$success++;
											$logs=$logs.' <span class="w3-text-green">Successful</span>';
										}										
										
									}
								}
								else
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (Unknown Error)</span>';
						
									
								}
								
							}

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
						