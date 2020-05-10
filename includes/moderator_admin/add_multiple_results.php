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
	if(isset($_REQUEST['semester']) && isset($_REQUEST['excel']) && isset($_REQUEST['pass']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['instructor_id']) && isset($_REQUEST['course_id']) && isset($_REQUEST['moderator_id']) && $_REQUEST['moderator_id']==$_SESSION['moderator_id'])
	{
		$excel_name='1';
		//file delete server info required to update if needed
		$base_directory = '../../excel_files/uploaded/';
			
		try{
			$excel=trim($_REQUEST['excel']);
			$course_id=trim($_REQUEST['course_id']);
			$instructor_id=trim($_REQUEST['instructor_id']);
			$prog_id=trim($_REQUEST['prog_id']);
			$semester=trim($_REQUEST['semester']);
			$pass=trim($_REQUEST['pass']);
			if(password_encrypt($pass)!=$_SESSION['moderator_password'])
			{
				echo 'PE';
				die();
			}
			$sem='';
			$yea='';
			$sz=strlen($semester);
			$f=0;
			//seperating semester and year
			for($i=0;$i<$sz;$i++)
			{
				if($semester[$i]==' ')
				{
					$f=1;
					continue;
				}
				if($f==0)
					$sem=$sem.$semester[$i];
				else
					$yea=$yea.$semester[$i];
			}
			
			$stmt = $conn->prepare(" select nr_prog_title from nr_program where nr_prog_id=:prog_id and nr_prog_status='Active' ");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$result = $stmt->fetchAll(); //program validity check
			if(count($result)==0)
			{
				echo 'u2';
				die();
			}
			else
			{
				$prog_title=$result[0][0];
			}
			
			$stmt = $conn->prepare(" select nr_course_code,nr_course_title from nr_course where nr_course_id=:course_id and nr_course_status='Active' ");
			$stmt->bindParam(':course_id', $course_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0) //course validity check
			{ 
				echo 'u3';
				die();
			}
			else
			{
				$course_code=$result[0][0];
				$course_title=$result[0][1];
			}
			
			$stmt = $conn->prepare(" select a.nr_faculty_name,a.nr_faculty_designation,b.nr_dept_title from nr_faculty a,nr_department b where a.nr_dept_id=b.nr_dept_id and a.nr_faculty_id=:faculty_id and a.nr_faculty_status='Active' ");
			$stmt->bindParam(':faculty_id', $instructor_id);
			$stmt->execute();
			$result = $stmt->fetchAll(); //faculty validity check
			if(count($result)==0)
			{
				echo 'u4';
				die();
			}
			else
			{
				$course_instructor=$result[0][0];
				$course_instructor_designation=$result[0][1];
				$course_instructor_department=$result[0][2];
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
					$student_batch=array();
					foreach ( $xlsx->rows() as $r => $row ) {
						$c++;
						if($c==1) continue;
						$student_id=trim($row[0]);
						$remarks=trim($row[1]);
						if($remarks=='N/A') $remarks='';
						$status=trim($row[2]);
						$marks=trim($row[3]);
						
						if($student_id=="" || $status=="" || $marks=="" || $marks>100 || $marks<0)
							break;
						
						$logs=$logs.'<li>'.$student_id.' - '.$course_code.' - '.$course_title.' - '.$semester.' - '.$marks.' : ';
						
						if(strlen($student_id)!=12)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Student ID)</span>';
						}
						else if($status=='Active' || $status=='Inactive')
						{
							$stmt = $conn->prepare("select a.nr_stud_id,b.nr_studi_graduated,a.nr_prog_id,a.nr_stud_email,a.nr_stud_status,a.nr_stud_name,a.nr_prcr_id from nr_student a,nr_student_info b where a.nr_stud_id=b.nr_stud_id and a.nr_stud_id=:student_id ");
							$stmt->bindParam(':student_id', $student_id);
							$stmt->execute();
							$result = $stmt->fetchAll();
							$stud_email='';
							$stud_status='';
							$stud_name='';
							if(count($result)==0) //student validity check
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Invalid Student)</span>';
						
							}
							else
							{
								if($result[0][1]==1) //graduation check
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (Student Graduated)</span>';
						
								}
								else if($result[0][2]!=$prog_id) //ambiguty check
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (Ambiguous for Student and Program)</span>';
						
								}
								else
								{
									$stud_email=$result[0][3];
									$stud_status=$result[0][4];
									$stud_name=$result[0][5];
									$prcr_id=$result[0][6];
											
									$stmt = $conn->prepare(" select * from nr_student_waived_credit where nr_course_id=:course_id and nr_stud_id=:student_id ");
									$stmt->bindParam(':course_id', $course_id);
									$stmt->bindParam(':student_id', $student_id);
									$stmt->execute();
									$result = $stmt->fetchAll();
									if(count($result)>=1) //course validity check
									{ 
										$failed++;
										$logs=$logs.' <span class="w3-text-red">Failed (Waived Course)</span>';
						
									}
									else
									{
										$stmt = $conn->prepare(" select * from nr_result where nr_course_id=:course_id and nr_stud_id=:student_id and nr_result_semester=:sem and nr_result_year=:yea ");
										$stmt->bindParam(':course_id', $course_id);
										$stmt->bindParam(':student_id', $student_id);
										$stmt->bindParam(':sem', $sem);
										$stmt->bindParam(':yea', $yea);
										$stmt->execute();
										$result = $stmt->fetchAll();
										
										if(count($result)>=1)
										{
											$failed++;
											$logs=$logs.' <span class="w3-text-red">Failed (Duplicate Detected)</span>';
						
										}
										else
										{
											//all activity 
											
											$course_marks=marks_encrypt($student_id,$marks);
											$course_grade=grade_encrypt($student_id,get_grade($marks));
											$course_grade_point=grade_point_encrypt($student_id,get_grade_point($marks));
											$t=get_current_time();
											$d=get_current_date();
											
											//updating result
											$stmt = $conn->prepare("insert into nr_result (nr_stud_id,nr_course_id,nr_result_grade,nr_result_marks,nr_result_grade_point,nr_result_semester,nr_result_year,nr_result_status,nr_result_remarks,nr_prog_id,nr_result_publish_date,nr_faculty_id) values (:student_id,:course_id,:grade,:marks,:grade_point,:semester,:year,:status,:remarks,:prog_id,'$d',:faculty_id) ");
											$stmt->bindParam(':student_id', $student_id);
											$stmt->bindParam(':course_id', $course_id);
											$stmt->bindParam(':grade', $course_grade);
											$stmt->bindParam(':marks', $course_marks);
											$stmt->bindParam(':grade_point', $course_grade_point);
											$stmt->bindParam(':semester', $sem);
											$stmt->bindParam(':year', $yea);
											$stmt->bindParam(':status', $status);
											$stmt->bindParam(':remarks', $remarks);
											$stmt->bindParam(':prog_id', $prog_id);
											$stmt->bindParam(':faculty_id', $instructor_id);
											$stmt->execute();
											
											//getting last inserted id
											$stmt = $conn->prepare("select nr_result_id from nr_result where nr_stud_id=:student_id and nr_course_id=:course_id and nr_result_grade=:grade and nr_result_marks=:marks and nr_result_grade_point=:grade_point and nr_result_semester=:semester and nr_result_year=:year and nr_result_status=:status and nr_result_remarks=:remarks and nr_prog_id=:prog_id and nr_faculty_id=:faculty_id ");
											$stmt->bindParam(':student_id', $student_id);
											$stmt->bindParam(':course_id', $course_id);
											$stmt->bindParam(':grade', $course_grade);
											$stmt->bindParam(':marks', $course_marks);
											$stmt->bindParam(':grade_point', $course_grade_point);
											$stmt->bindParam(':semester', $sem);
											$stmt->bindParam(':year', $yea);
											$stmt->bindParam(':status', $status);
											$stmt->bindParam(':remarks', $remarks);
											$stmt->bindParam(':prog_id', $prog_id);
											$stmt->bindParam(':faculty_id', $instructor_id);
											$stmt->execute();
											$result = $stmt->fetchAll();
											if(count($result)==0) //student validity check
											{
												echo 'Error';
												die();
											}
											else
											{
												$result_id=$result[0][0];
											}
											
											//updating stud info
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
											
											
											//updating semester cgpa
											$stmt = $conn->prepare("select * from nr_student_semester_cgpa where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
											$stmt->bindParam(':student_id', $student_id);
											$stmt->bindParam(':sem', $sem);
											$stmt->bindParam(':yea', $yea);
											$stmt->execute();
											$result = $stmt->fetchAll();
											if(count($result)==0)
											{
												$cg=get_student_semester_cgpa($student_id,$sem,$yea);
												if($cg=='N/A') $cg=0.00;
												$stmt = $conn->prepare("insert into nr_student_semester_cgpa (nr_studsc_cgpa, nr_studsc_publish_date, nr_stud_id, nr_studsc_semester, nr_studsc_year,nr_studsc_status) values('$cg','$d',:student_id,:sem,:yea,'Active') ");
												$stmt->bindParam(':student_id', $student_id);
												$stmt->bindParam(':sem', $sem);
												$stmt->bindParam(':yea', $yea);
												$stmt->execute();
											
											}
											else
											{
												$cg=get_student_semester_cgpa($student_id,$sem,$yea);
												if($cg=='N/A') $cg=0.00;
												$stmt = $conn->prepare("update nr_student_semester_cgpa set nr_studsc_cgpa='$cg', nr_studsc_publish_date='$d' where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
												$stmt->bindParam(':student_id', $student_id);
												$stmt->bindParam(':sem', $sem);
												$stmt->bindParam(':yea', $yea);
												$stmt->execute();
											}
											
											//updating record history
											
											
											
											$task='Added Result Student ID: '.$student_id.', Student Name: '.$stud_name.', Program: '.$prog_title.', Course Code: '.$course_code.', Course Title: '.$course_title.', Semester: '.$semester.', Marks: '.$marks.', Grade: '.get_grade($marks).', Grade Point: '.number_format(get_grade_point($marks),2).', Remarks: '.$remarks.', Course Instructor: '.$course_instructor.', Instructor Designation: '.$course_instructor_designation.', Department of '.$course_instructor_department.', Result Status: '.$status;
											$stmt = $conn->prepare("insert into nr_result_history(nr_result_id,nr_admin_id,nr_resulth_task,nr_resulth_date,nr_resulth_time,nr_resulth_status) values(:result_id,:moderator_id,'$task','$d','$t','Active') ");
											$stmt->bindParam(':moderator_id', $_SESSION['moderator_id']);
											$stmt->bindParam(':result_id', $result_id);
											$stmt->execute();
											
											
											$data='<table border="2">
															<tr>
																<td style="padding:1px;"><b>Student ID</b></td>
																<td style="padding:1px;"><b>Student Name</b></td>
																<td style="padding:1px;"><b>Course Code</b></td>
																<td style="padding:1px;"><b>Course Title</b></td>
																<td style="padding:1px;"><b>Semester</b></td>
																<td style="padding:1px;"><b>Grade</b></td>
																<td style="padding:1px;"><b>Grade Point</b></td>
																<td style="padding:1px;"><b>Remarks</b></td>
															</tr>
															<tr>
																<td style="padding:1px;">'.$student_id.'</td>
																<td style="padding:1px;">'.$stud_name.'</td>
																<td style="padding:1px;">'.$course_code.'</td>
																<td style="padding:1px;">'.$course_title.'</td>
																<td style="padding:1px;">'.$semester.'</td>
																<td style="padding:1px;">'.get_grade($marks).'</td>
																<td style="padding:1px;">'.number_format(get_grade_point($marks),2).'</td>
																<td style="padding:1px;">'.$remarks.'</td>
															</tr>
														</table>';
											
											
											if($stud_email!='' && $stud_status=='Active' && $status=='Active')
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
												$f_name=$stud_name;
												//sending password recovery link to user
												$msg="Dear ".$f_name.", Your result with the mentioned details in the table has added by the admin in ".$title.". You can check it from ".$title." student panel. ".$data." <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
												$message = '<html><body>';
												$message .= '<h1>Result Added in - '.$title.'</h1><p>  </p>';
												$message .= '<p><b>Message Details:</b></p>';
												$message .= '<p>'.$msg.'</p></body></html>';
												
												
												sent_mail($stud_email,$title.' - Result Added Notification',$message,$title,$contact_email);
												


											}
											
											
											
											//updating other students info of same batch
											$group_student='';
											$sz=strlen($student_id);
											for($i=0;$i<$sz-3;$i++)
												$group_student=$group_student.$student_id[$i];
												
											if(!array_key_exists($group_student,$student_batch))
											{
												$student_batch[$group_student]=array('student_group'=>$group_student);
											}
											
											
											$success++;
											$logs=$logs.' <span class="w3-text-green">Successful</span>';
										
										}
									}
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
					
					
					/*** updating same batch students --**/
					foreach($student_batch as $batch)
					{
						$group_student=$batch['student_group'];
						$stmt=$conn->prepare("select nr_stud_id,nr_prcr_id from nr_student where nr_stud_id like concat(:search_text,'___') order by nr_stud_id asc ");
						$stmt->bindParam(':search_text',$group_student);
						$stmt->execute();
						$result=$stmt->fetchAll();
						$sz=count($result);
						for($i=0;$i<$sz;$i++)
						{
							$s_id=$result[$i][0];
							$p_id=$result[$i][1];
							//updating stud info
							$x=get_student_info($s_id,$p_id);
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
							$stmt->bindParam(':student_id', $s_id);
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
							
						}
						
						
					}
					/******************************************/
					
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
