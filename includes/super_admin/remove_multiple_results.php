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
	if(isset($_REQUEST['semester']) && isset($_REQUEST['pass']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['instructor_id']) && isset($_REQUEST['course_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$course_id=trim($_REQUEST['course_id']);
			$instructor_id=trim($_REQUEST['instructor_id']);
			$prog_id=trim($_REQUEST['prog_id']);
			$semester=trim($_REQUEST['semester']);
			$pass=trim($_REQUEST['pass']);
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
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
			
			$stmt = $conn->prepare(" select a.nr_result_id,b.nr_stud_id,b.nr_stud_name,b.nr_stud_email,b.nr_stud_status,b.nr_prcr_id,a.nr_result_grade,a.nr_result_grade_point,a.nr_result_remarks,a.nr_result_status,d.nr_studi_graduated,a.nr_result_marks from nr_result a,nr_student b,nr_student_info d where a.nr_stud_id=b.nr_stud_id and a.nr_stud_id=d.nr_stud_id and a.nr_prog_id=:prog_id and a.nr_result_semester=:sem and a.nr_result_year=:yea and a.nr_course_id=:course_id and a.nr_faculty_id=:instructor_id order by a.nr_stud_id asc ");
			$stmt->bindParam(':course_id', $course_id);
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->bindParam(':instructor_id', $instructor_id);
			$stmt->bindParam(':sem', $sem);
			$stmt->bindParam(':yea', $yea);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$sz=count($result);
			$success=0;
			$failed=0;
			$logs='<ol>';
			if($sz==0)
			{
				echo 'u5';
				die();
			}
			for($i=0;$i<$sz;$i++)
			{
				$result_id=$result[$i][0];
				$student_id=$result[$i][1];
				$student_name=$result[$i][2];
				$student_email=$result[$i][3];
				$student_status=$result[$i][4];
				$prcr_id=$result[$i][5];
				$course_grade=grade_decrypt($student_id,$result[$i][6]);
				$course_marks=marks_decrypt($student_id,$result[$i][11]);
				$course_grade_point=grade_point_decrypt($student_id,$result[$i][7]);
				$course_remarks=$result[$i][8];
				if($course_remarks==''){ $remark='N/A'; }
				else { $remark=$course_remarks; }
				$status=$result[$i][9];
				$flll=$result[$i][10];
				
				
				$logs=$logs.'<li>'.$student_id.' - '.$course_code.' - '.$course_title.' - '.$semester.' - '.$course_grade.' - '.$remark.' - '.$status.' : ';
						
				if($flll==1)
				{
					$failed++;
					$logs=$logs.' <span class="w3-text-red">Failed (Student Graduated)</span>';
				}
				else
				{
					if($student_email!='' && $student_status=='Active' && $status=='Active')
					{
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
										<td style="padding:1px;">'.$student_name.'</td>
										<td style="padding:1px;">'.$course_code.'</td>
										<td style="padding:1px;">'.$course_title.'</td>
										<td style="padding:1px;">'.$semester.'</td>
										<td style="padding:1px;">'.$course_grade.'</td>
										<td style="padding:1px;">'.number_format($course_grade_point,2).'</td>
										<td style="padding:1px;">'.$course_remarks.'</td>
									</tr>
								</table>';
						//sent email with password reset link
						$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
						$stmt->execute();
						$result2 = $stmt->fetchAll();
						if(count($result2)==0)
						{
							echo 'System not ready';
							die();
						}
						$title=$result2[0][2];
						$contact_email=$result2[0][9];//for sending message from contact us form
						$f_name=$student_name;
						//sending password recovery link to user
						$msg="Dear ".$f_name.", Your result with the mentioned details in the table has removed by the admin from ".$title.". You can not access this mentioned result from ".$title." anymore. ".$data." <p>&nbsp;</p>For any query you can contact at: <a href='mailto:".$contact_email."' target='_blank'>".$contact_email."</a>";
						$message = '<html><body>';
						$message .= '<h1>Result Removed from - '.$title.'</h1><p>  </p>';
						$message .= '<p><b>Message Details:</b></p>';
						$message .= '<p>'.$msg.'</p></body></html>';
						
						
						sent_mail($student_email,$title.' - Result Removed Notification',$message,$title,$contact_email);
						
						
					}
					$t=get_current_time();
					$d=get_current_date();
					$task='Deleted Result Student ID: '.$student_id.', Student Name: '.$student_name.', Program: '.$prog_title.', Course Code: '.$course_code.', Course Title: '.$course_title.', Semester: '.$semester.', Marks: '.$course_marks.', Grade: '.$course_grade.', Grade Point: '.number_format($course_grade_point,2).', Remarks: '.$course_remarks.', Course Instructor: '.$course_instructor.', Instructor Designation: '.$course_instructor_designation.', Department of '.$course_instructor_department.', Result Status: '.$status;
					$stmt = $conn->prepare("insert into nr_delete_history(nr_admin_id,nr_deleteh_task,nr_deleteh_date,nr_deleteh_time,nr_deleteh_status,nr_deleteh_type) values(:admin_id,'$task','$d','$t','Active','Result') ");
					$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
					$stmt->execute();
					
					$stmt = $conn->prepare("delete from nr_result_history where nr_result_id=:result_id ");
					$stmt->bindParam(':result_id', $result_id);
					$stmt->execute();
					
					$stmt = $conn->prepare("delete from nr_result where nr_result_id=:result_id ");
					$stmt->bindParam(':result_id', $result_id);
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
					
					$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:student_id and nr_result_semester=:sem and nr_result_year=:yea");
					$stmt->bindParam(':student_id', $student_id);
					$stmt->bindParam(':sem', $sem);
					$stmt->bindParam(':yea', $yea);
					$stmt->execute();
					$result2 = $stmt->fetchAll();
					if(count($result2)==0)
					{
						$stmt = $conn->prepare("delete from nr_student_semester_cgpa where nr_stud_id=:student_id and nr_studsc_semester=:sem and nr_studsc_year=:yea");
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

					$success++;
					$logs=$logs.' <span class="w3-text-green">Successful</span>';
										
					
				}
				$logs=$logs.'</li>';
			}
			$logs=$logs.'</ol>';
					
			echo 'Ok@'.$success.' Successful@'.$failed.' Failed@Total: '.($success+$failed).'@'.$logs.'@';
					
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
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>
