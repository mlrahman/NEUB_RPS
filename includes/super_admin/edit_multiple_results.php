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
					$email_array=array();
					foreach ( $xlsx->rows() as $r => $row ) {
						$c++;
						if($c==1) continue;
						$student_id=trim($row[0]);
						$course_code=trim($row[1]);
						$sem=trim($row[2]);
						$yea=trim($row[3]);
						$remarks=trim($row[4]);
						$status=trim($row[5]);
						$marks=trim($row[6]);
						
						if($student_id=="" || $status=="" || $marks=="" || $marks>100 || $marks<0 || $course_code=="" || $sem=="" || $yea=="" || $yea=="YYYY")
							break;
						
						$logs=$logs.'<li>'.$student_id.' - '.$course_code.' - '.$sem.' '.$yea.' - '.$marks.' - '.$remarks.' - '.$status.' : ';
						if($remarks=='N/A') $remarks='';
						
						if(strlen($student_id)!=12)
						{
							$failed++;
							$logs=$logs.' <span class="w3-text-red">Failed (Invalid Student ID)</span>';
						}
						else if($status=='Active' || $status=='Inactive')
						{
							$stmt = $conn->prepare("select a.nr_result_id,a.nr_result_marks,a.nr_result_grade,a.nr_result_grade_point,a.nr_result_remarks,a.nr_result_status,b.nr_stud_name,b.nr_stud_email,b.nr_stud_status,a.nr_course_id,c.nr_course_title,b.nr_prcr_id,d.nr_faculty_name,d.nr_faculty_designation,e.nr_dept_title from nr_result a,nr_student b,nr_course c, nr_faculty d,nr_department e where a.nr_faculty_id=d.nr_faculty_id and d.nr_dept_id=e.nr_dept_id and a.nr_stud_id=b.nr_stud_id and c.nr_course_id=a.nr_course_id and a.nr_stud_id=:student_id and a.nr_result_semester=:sem and a.nr_result_year=:yea and a.nr_course_id in (select nr_course_id from nr_course where nr_course_code=:course_code) limit 1 ");
							$stmt->bindParam(':student_id', $student_id);
							$stmt->bindParam(':course_code', $course_code);
							$stmt->bindParam(':sem', $sem);
							$stmt->bindParam(':yea', $yea);
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)==0)
							{
								$failed++;
								$logs=$logs.' <span class="w3-text-red">Failed (Result Not Found)</span>';
							}
							else
							{
								$result_id=$result[0][0];
								$result_marks=$result[0][1];
								$result_grade=$result[0][2];
								$result_grade_point=$result[0][3];
								$result_remarks=$result[0][4];
								$result_status=$result[0][5];
								$student_name=$result[0][6];
								$student_email=$result[0][7];
								$student_status=$result[0][8];
								$course_id=$result[0][9];
								$course_title=$result[0][10];
								$prcr_id=$result[0][11];
								$course_instructor=$result[0][12];
								$course_instructor_designation=$result[0][13];
								$course_instructor_department=$result[0][14];
								
								if(marks_decrypt($student_id,$result_marks)==$marks && $result_status==$status && $result_remarks==$remarks)
								{
									$failed++;
									$logs=$logs.' <span class="w3-text-red">Failed (No Change)</span>';
							
								}
								else
								{
									$course_marks=marks_encrypt($student_id,$marks);
									$course_grade=grade_encrypt($student_id,get_grade($marks));
									$course_grade_point=grade_point_encrypt($student_id,get_grade_point($marks));
									$stmt = $conn->prepare("update nr_result set nr_result_grade=:grade,nr_result_marks=:marks,nr_result_grade_point=:grade_point,nr_result_status=:status,nr_result_remarks=:remarks where nr_result_id=:result_id");
									$stmt->bindParam(':grade', $course_grade);
									$stmt->bindParam(':marks', $course_marks);
									$stmt->bindParam(':grade_point', $course_grade_point);
									$stmt->bindParam(':status', $status);
									$stmt->bindParam(':remarks', $remarks);
									$stmt->bindParam(':result_id', $result_id);
									$stmt->execute();
									
									$stmt = $conn->prepare("select b.nr_prog_title from nr_student a,nr_program b where a.nr_stud_id=:student_id and a.nr_prog_id=b.nr_prog_id ");
									$stmt->bindParam(':student_id', $student_id);
									$stmt->execute();
									$result = $stmt->fetchAll();
									$prog_title=$result[0][0];
									
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
									
									$task='Updated Result Student ID: '.$student_id.', Student Name: '.$student_name.', Program: '.$prog_title.', Course Code: '.$course_code.', Course Title: '.$course_title.', Semester: '.$sem.' '.$yea.', Marks: '.$marks.', Grade: '.get_grade($marks).', Grade Point: '.number_format(get_grade_point($marks),2).', Remarks: '.$remarks.', Course Instructor: '.$course_instructor.', Instructor Designation: '.$course_instructor_designation.', Department of '.$course_instructor_department.', Result Status: '.$status;
									$stmt = $conn->prepare("insert into nr_result_history(nr_result_id,nr_admin_id,nr_resulth_task,nr_resulth_date,nr_resulth_time,nr_resulth_status) values(:result_id,:admin_id,'$task','$d','$t','Active') ");
									$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
									$stmt->bindParam(':result_id', $result_id);
									$stmt->execute();
									
									$cg=get_student_semester_cgpa($student_id,$sem,$yea);
									if($cg=='N/A') $cg=0.00;
									$stmt = $conn->prepare("update nr_student_semester_cgpa set nr_studsc_cgpa='$cg', nr_studsc_publish_date='$d' where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
									$stmt->bindParam(':student_id', $student_id);
									$stmt->bindParam(':sem', $sem);
									$stmt->bindParam(':yea', $yea);
									$stmt->execute();
									
									$success++;
									$logs=$logs.' <span class="w3-text-green">Successful</span>';
											
									//storing for email send
									if(array_key_exists($student_id,$email_array))
									{
										$index=count($email_array[$student_id]);
										$email_array[$student_id][$index]=array('student_id'=>$student_id,'student_name'=>$student_name,'student_email'=>$student_email,'student_status'=>$student_status,'course_code'=>$course_code,'course_title'=>$course_title,'semester'=>($sem.' '.$yea),'new_remarks'=>$remarks,'old_grade'=>grade_decrypt($student_id,$result_grade),'old_grade_point'=>grade_point_decrypt($student_id,$result_grade_point),'old_remrks'=>$result_remarks,'new_grade'=>get_grade($marks),'new_grade_point'=>get_grade_point($marks),'result_status'=>$status);
									}
									else
									{
										$email_array[$student_id][0]=array('student_id'=>$student_id,'student_name'=>$student_name,'student_email'=>$student_email,'student_status'=>$student_status,'course_code'=>$course_code,'course_title'=>$course_title,'semester'=>($sem.' '.$yea),'new_remarks'=>$remarks,'old_grade'=>grade_decrypt($student_id,$result_grade),'old_grade_point'=>grade_point_decrypt($student_id,$result_grade_point),'old_remarks'=>$result_remarks,'new_grade'=>get_grade($marks),'new_grade_point'=>get_grade_point($marks),'result_status'=>$status);
				
									}
								}
								
							}
						}
						
				
					}
					
					
					//sending notification via email
					foreach($email_array as $key=>$kk)
					{
						$sz=count($email_array[$key]);
						$student_id='';
						$student_email='';
						$student_name='';
						$student_status='';
						$data1='<p><b>Table1:</b></p><table border="2">
							<tr>
								<td style="padding:1px;"><b>Student ID</b></td>
								<td style="padding:1px;"><b>Student Name</b></td>
								<td style="padding:1px;"><b>Course Code</b></td>
								<td style="padding:1px;"><b>Course Title</b></td>
								<td style="padding:1px;"><b>Semester</b></td>
								<td style="padding:1px;"><b>Grade</b></td>
								<td style="padding:1px;"><b>Grade Point</b></td>
								<td style="padding:1px;"><b>Remarks</b></td>
							</tr>';
						$data2='<p><b>Table2:</b></p><table border="2">
							<tr>
								<td style="padding:1px;"><b>Student ID</b></td>
								<td style="padding:1px;"><b>Student Name</b></td>
								<td style="padding:1px;"><b>Course Code</b></td>
								<td style="padding:1px;"><b>Course Title</b></td>
								<td style="padding:1px;"><b>Semester</b></td>
								<td style="padding:1px;"><b>Grade</b></td>
								<td style="padding:1px;"><b>Grade Point</b></td>
								<td style="padding:1px;"><b>Remarks</b></td>
							</tr>';
						$fl=0;
						for($j=0;$j<$sz;$j++)
						{
							$student_id=$email_array[$key][$j]['student_id'];
							$student_name=$email_array[$key][$j]['student_name'];
							$student_email=$email_array[$key][$j]['student_email'];
							$student_status=$email_array[$key][$j]['student_status'];
							$course_code=$email_array[$key][$j]['course_code'];
							$course_title=$email_array[$key][$j]['course_title'];
							$semester=$email_array[$key][$j]['semester'];
							
							$old_grade=$email_array[$key][$j]['old_grade'];
							$old_grade_point=$email_array[$key][$j]['old_grade_point'];
							$old_remarks=$email_array[$key][$j]['old_remarks'];
							
							$new_grade=$email_array[$key][$j]['old_grade'];
							$new_grade_point=$email_array[$key][$j]['old_grade_point'];
							$new_remarks=$email_array[$key][$j]['old_remarks'];
							
							$result_status=$email_array[$key][$j]['result_status'];
							
							if($result_status=='Active')
							{
								$fl=1;
								$data1=$data1.'<tr>
									<td style="padding:1px;"><b>'.$student_id.'</b></td>
									<td style="padding:1px;"><b>'.$student_name.'</b></td>
									<td style="padding:1px;"><b>'.$course_code.'</b></td>
									<td style="padding:1px;"><b>'.$course_title.'</b></td>
									<td style="padding:1px;"><b>'.$semester.'</b></td>
									<td style="padding:1px;"><b>'.$old_grade.'</b></td>
									<td style="padding:1px;"><b>'.$old_grade_point.'</b></td>
									<td style="padding:1px;"><b>'.$old_remarks.'</b></td>
								</tr>';
								
								$data2=$data2.'<tr>
									<td style="padding:1px;"><b>'.$student_id.'</b></td>
									<td style="padding:1px;"><b>'.$student_name.'</b></td>
									<td style="padding:1px;"><b>'.$course_code.'</b></td>
									<td style="padding:1px;"><b>'.$course_title.'</b></td>
									<td style="padding:1px;"><b>'.$semester.'</b></td>
									<td style="padding:1px;"><b>'.$new_grade.'</b></td>
									<td style="padding:1px;"><b>'.$new_grade_point.'</b></td>
									<td style="padding:1px;"><b>'.$new_remarks.'</b></td>
								</tr>';
							}
							
						}
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
				
						if($fl==1 && $student_status=='Active' && $student_email!="")
						{
							$f_name=$student_name;
							//sending password recovery link to user
							$msg="Dear ".$f_name.", Your result with the mentioned details in the table1 has updated with the table2 details by the admin in ".$title.". You can check it from ".$title." student panel. ".$data1.$data2." <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
							$message = '<html><body>';
							$message .= '<h1>Result Updated in - '.$title.'</h1><p>  </p>';
							$message .= '<p><b>Message Details:</b></p>';
							$message .= '<p>'.$msg.'</p></body></html>';
							
							
							sent_mail($student_email,$title.' - Result Updated Notification',$message,$title,$contact_email);
							
						}
						
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
