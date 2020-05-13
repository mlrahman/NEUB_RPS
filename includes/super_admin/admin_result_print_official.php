<?php
	session_start();
	require("../db_connection.php"); 
	require("../function.php"); 
	try{
		require("logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	if(isset($_REQUEST['student_id']) && isset($_REQUEST['admin_id']) && isset($_SESSION['student_id']) && $_REQUEST['student_id']==password_encrypt($_SESSION['student_id'].get_current_date()) && $_REQUEST['admin_id']==password_encrypt($_SESSION['admin_id'].get_current_date()))
	{
		
		try{
			$s_id=$_SESSION['student_id'];
			$admin_id=$_SESSION['admin_id'];
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id limit 1 ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if(count($result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
			$stmt->execute();
			$result_t = $stmt->fetchAll();
			
			if(count($result_t)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
				die();
			}
			
			$title=$result_t[0][2];
			$caption=$result_t[0][3];
			$address=$result_t[0][4];
			$telephone=$result_t[0][5];
			$email=$result_t[0][6];
			$mobile=$result_t[0][7];
			$web=$result_t[0][8];
			$contact_email=$result_t[0][9];
			$map=$result_t[0][10];
			$logo=$result_t[0][13];
			$video_alt=$result_t[0][14];
			$video=$result_t[0][15];
			
			
			//Check details will insert into transaction
			$vis_ip = getVisIPAddr();
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$vis_ip));
			if($vis_ip=="")$vis_ip="N/A";
			$country=$ipdat->geoplugin_countryName;
			if($country=="")$country="N/A";
			$city=$ipdat->geoplugin_city;
			if($city=="")$city="N/A";
			$lat=$ipdat->geoplugin_latitude;
			if($lat=="")$lat="N/A";
			$lng=$ipdat->geoplugin_longitude;
			if($lng=="")$lng="N/A";
			$timezone=$ipdat->geoplugin_timezone;
			if($timezone=="")$timezone="N/A";
			$date=get_current_date();
			$time=get_current_time();
			$ref=get_reference($s_id);
			
			$at=$_SESSION['admin_type'];
			$stmt = $conn->prepare("insert into nr_transcript_print_reference values(:s_id,'$at',:f_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','$ref','Active') ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':f_id', $admin_id);
			$stmt->execute();
			
			
			$name = $result[0][1];
			$reg_no = $result[0][0];
			$session = get_session($reg_no);
			$gender = $result[0][3];
			$birthdate = $result[0][2];
			$subscription_email = $result[0][4];
			$prog_id = $result[0][7];
			$prcr_id = $result[0][8];
			
			//Search for student program
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=$prog_id");
			$stmt->execute();
			$prog_result = $stmt->fetchAll();
			$degree = $prog_result[0][1];
			if(count($prog_result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
				die();
			}
			
			//Search for student program credit
			$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
			$stmt->execute();
			$prcr_result = $stmt->fetchAll();
			if(count($prcr_result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
				die();
			}
			
			$total_credit=$prcr_result[0][2];
			
			//Fetching student result
			$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc"); 
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			
				
			$cg=array();
			$se_re=array();
			$sz1=count($stud_result);
			for($i = 0; $i < $sz1; $i++) {
				
				$stud_result_id=$stud_result[$i][0];
				$stud_course_id=$stud_result[$i][2];
				$stud_marks=marks_decrypt($s_id,$stud_result[$i][3]);
				$stud_grade=grade_decrypt($s_id,$stud_result[$i][4]);
				$stud_grade_point=grade_point_decrypt($s_id,$stud_result[$i][5]);
				$stud_semester=$stud_result[$i][6];
				$stud_year=$stud_result[$i][7];
				$stud_remarks=$stud_result[$i][8];
				//$stud_status=$stud_result[$i][9];
				$stud_prog_id=$stud_result[$i][10];
				$stud_pub_date=$stud_result[$i][11];
				//echo '--> '.$stud_result_id.' --- '.$stud_marks.' --- '.$stud_grade.' --- '.$stud_grade_point.' --- '.$stud_course_id.'</br>';
				$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
				$stmt->execute();
				$course_result=$stmt->fetchAll();
				$stud_course_code=$course_result[0][1];
				$stud_course_title=$course_result[0][2];
				$stud_course_credit=$course_result[0][3];
				//echo '--> '.$stud_course_code.' --- '.$stud_course_title.' --- '.$stud_course_credit.'</br>';
				$abc=array('course_code'=>$stud_course_code,'course_title'=>$stud_course_title,'course_credit'=>$stud_course_credit,'grade'=>$stud_grade,'marks'=>$stud_marks,'grade_point'=>$stud_grade_point,'semester'=>$stud_semester,'year'=>$stud_year,'remarks'=>$stud_remarks);
				
				//Storing data for showing in tables
								
				if(array_key_exists(($stud_semester.'-'.$stud_year),$se_re))
				{
					$fl=0;
					foreach($se_re as $key=>$kk)
					{
						$sz2=count($se_re[$key]);
						for($j=0;$j<$sz2;$j++)
						{
							if(array_key_exists($j,$se_re[$key]))
							{
								$prev_cc=$se_re[$key][$j]['course_code'];
								//echo 'key: '.$key.' index: '.$j.' Course Code: '.$prev_cc.' Current course code: '.$stud_course_code.'</br>';
								$prev_gp=$se_re[$key][$j]['grade_point'];
								//echo 'key: '.$key.' index: '.$j.' Grade Point: '.$prev_gp.' Current grade point: '.$stud_grade_point.'</br>';
								
								//improve course checking current grade>prev grade
								if($prev_cc==$stud_course_code && $prev_gp!=0.0 && $stud_grade_point>=$prev_gp)
								{
									//echo $prev_cc;
									unset($se_re[$key][$j]);
								}
								else if($prev_cc==$stud_course_code && $prev_gp!=0.0 && $stud_grade_point<$prev_gp)
									$fl=1;
							}
						}
					}
					if($fl==0)
						$se_re[($stud_semester.'-'.$stud_year)][count($se_re[($stud_semester.'-'.$stud_year)])]=$abc;
					
				}
				else
				{
					$fl=0;
					foreach($se_re as $key=>$kk)
					{
						$sz3=count($se_re[$key]);
						for($j=0;$j<$sz3;$j++)
						{
							if(array_key_exists($j,$se_re[$key]))
							{
								$prev_cc=$se_re[$key][$j]['course_code'];
								//echo 'key: '.$key.' index: '.$j.' Course Code: '.$prev_cc.' Current course code: '.$stud_course_code.'</br>';
								$prev_gp=$se_re[$key][$j]['grade_point'];
								//echo 'key: '.$key.' index: '.$j.' Grade Point: '.$prev_gp.' Current grade point: '.$stud_grade_point.'</br>';
								
								//improve course checking current grade>prev grade
								if($prev_cc==$stud_course_code && $prev_gp!=0.0 && $stud_grade_point>=$prev_gp)
								{
									//echo $prev_cc;
									unset($se_re[$key][$j]);
								}
								else if($prev_cc==$stud_course_code && $prev_gp!=0.0 && $stud_grade_point<$prev_gp)
									$fl=1;
							}
							
						}
					}
					if($fl==0)
						$se_re[($stud_semester.'-'.$stud_year)][0]=$abc;
				}
				
				//Calculating cg and credits by checking unique and best result
				if(array_key_exists($stud_course_code,$cg))
				{
					$prev_grade_point=$cg[$stud_course_code]['gpa'];
					if($stud_grade_point>=$prev_grade_point)
						$cg[$stud_course_code]=array('credit'=>$stud_course_credit,'gpa'=>$stud_grade_point);
				}
				else
				{
					if($stud_grade_point>0.0)
						$cg[$stud_course_code]=array('credit'=>$stud_course_credit,'gpa'=>$stud_grade_point);
				}
				
			}
			
			$earned_credit=0.0;
			$earned_gpa=0.0;
			foreach($cg as $cge)
			{
				$earned_credit=$earned_credit+$cge['credit'];
				$earned_gpa=$earned_gpa+($cge['credit']*$cge['gpa']);
			}
			$earned_credit=number_format($earned_credit, 2);
			

					
			//fetching waived course result
			$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id and nr_stwacr_status='Active' "); 
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			$ra_w=array();
			$sz4=count($stud_result);
			for($i = 0; $i < $sz4; $i++) {
				
				$stud_stwacr_id=$stud_result[$i][0];
				$stud_course_id=$stud_result[$i][2];
				$stud_pub_date=$stud_result[$i][3];
				//echo '--> '.$stud_result_id.' --- '.$stud_marks.' --- '.$stud_grade.' --- '.$stud_grade_point.' --- '.$stud_course_id.'</br>';
				$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
				$stmt->execute();
				$course_result=$stmt->fetchAll();
				$stud_course_code=$course_result[0][1];
				$stud_course_title=$course_result[0][2];
				$stud_course_credit=$course_result[0][3];
				
				$abc=array('course_code'=>$stud_course_code,'course_title'=>$stud_course_title,'course_credit'=>$stud_course_credit);
				
				//Storing data for showing in tables
				$ra_w[$i]=$abc;	
			}
			
			$waived_credit=0.0; 
			foreach($ra_w as $cge)
			{
				$waived_credit=$waived_credit+$cge['course_credit'];
			}
			
			$waived_credit=number_format($waived_credit, 2);
			
			
			
			//Calculating cgpa from earned_credit
			if($earned_credit==0)
				$total_cgpa=number_format(0.0,2);
			else
				$total_cgpa=number_format(($earned_gpa/$earned_credit),2);
			
			$degree_status=$total_credit-($earned_credit+$waived_credit);
			if($degree_status==0)
				$degree_status='Completed';
			else
				$degree_status='Not Completed';
			
			
			
			$photo=$result[0][6];
			$info['photo']=$photo;
			
			if($waived_credit==0) $waived_credit='N/A';
				
			
			
			
			/*******************************************/
			$filename = $name." (".$reg_no.")"."_Transcript_".$ref.".xls";

			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");

				
			echo 'Ref: '.$ref."\r\n";	
			echo 'Student Name'."\t".$name."\r\n";
			echo 'Registration No'."\t".$reg_no."\r\n";
			echo 'Session'."\t".$session."\r\n";
			echo 'Gender'."\t".$gender."\r\n";
			echo 'Degree Name'."\t".$degree."\r\n";
			echo 'Credit Required'."\t".$total_credit."\r\n";
			echo 'Credit Earned'."\t".$earned_credit."\r\n";
			echo 'Credit Waived'."\t".$waived_credit."\r\n";
			echo 'CGPA Earned'."\t".$total_cgpa."\r\n";
			echo 'Degree Status'."\t".$degree_status."\r\n";
			echo 'Issue Date'."\t".get_date(get_current_date())."\r\n";
			
			echo "\r\n\r\n";
			
			if(count($se_re)==0)
			{
				echo 'No result available'."\r\n";
			}
			for($i=get_year($s_id);$i<=Date("Y");$i++)
			{			
				if(array_key_exists(('Spring-'.$i),$se_re))
				{
					$t_c=0.0;
					$t_g=0.0;
					$rp_flag=0;
				
					foreach($se_re['Spring-'.$i] as $z)
					{
						$rp_flag=1;
				
						if(number_format($z['grade_point'],2)>0.0)
						{
							$t_c=$t_c+$z['course_credit'];
							$t_g=$t_g+($z['grade_point']*$z['course_credit']);
						}
					}
					if($rp_flag==1)
					{
						echo 'Semester: Spring-'.$i."\t\t\t".'CGPA: ';
						if($t_c==0.0){  echo number_format(0.0,2)."\t"; } 
						else{  echo number_format(($t_g/$t_c),2)."\r\n"; }
						echo 'Course Code'."\t".'Course Title'."\t".'Course Credit'."\t".'Grade'."\t".'Grade Point'."\r\n";					
						foreach($se_re['Spring-'.$i] as $z)
						{
							if(number_format($z['grade_point'],2)>0.0 or (number_format($z['grade_point'],2)==0.0 && $z['grade']=='F'))
							{										
								echo $z['course_code']."\t".$z['course_title']."\t".number_format($z['course_credit'],2)."\t".$z['grade']."\t".number_format($z['grade_point'],2)."\r\n";
							}
						}
						echo "\r\n\r\n";
					
					}
				}
				
				
				if(array_key_exists(('Summer-'.$i),$se_re))
				{
					$t_c=0.0;
					$t_g=0.0;
					$rp_flag=0;
				
					foreach($se_re['Summer-'.$i] as $z)
					{
						$rp_flag=1;
				
						if(number_format($z['grade_point'],2)>0.0)
						{
							$t_c=$t_c+$z['course_credit'];
							$t_g=$t_g+($z['grade_point']*$z['course_credit']);
						}
					}
					if($rp_flag==1)
					{
						echo 'Semester: Summer-'.$i."\t\t\t".'CGPA: ';
						if($t_c==0.0){  echo number_format(0.0,2)."\t"; } 
						else{  echo number_format(($t_g/$t_c),2)."\r\n"; }
						echo 'Course Code'."\t".'Course Title'."\t".'Course Credit'."\t".'Grade'."\t".'Grade Point'."\r\n";					
						foreach($se_re['Summer-'.$i] as $z)
						{
							if(number_format($z['grade_point'],2)>0.0 or (number_format($z['grade_point'],2)==0.0 && $z['grade']=='F'))
							{										
								echo $z['course_code']."\t".$z['course_title']."\t".number_format($z['course_credit'],2)."\t".$z['grade']."\t".number_format($z['grade_point'],2)."\r\n";
							}
						}
						echo "\r\n\r\n";
					
					
					}
				}
				
				if(array_key_exists(('Fall-'.$i),$se_re))
				{
					$t_c=0.0;
					$t_g=0.0;
					$rp_flag=0;
				
					foreach($se_re['Fall-'.$i] as $z)
					{
						$rp_flag=1;
				
						if(number_format($z['grade_point'],2)>0.0)
						{
							$t_c=$t_c+$z['course_credit'];
							$t_g=$t_g+($z['grade_point']*$z['course_credit']);
						}
					}
					if($rp_flag==1)
					{
						echo 'Semester: Fall-'.$i."\t\t\t".'CGPA: ';
						if($t_c==0.0){  echo number_format(0.0,2)."\t"; } 
						else{  echo number_format(($t_g/$t_c),2)."\r\n"; }
						echo 'Course Code'."\t".'Course Title'."\t".'Course Credit'."\t".'Grade'."\t".'Grade Point'."\r\n";					
						foreach($se_re['Fall-'.$i] as $z)
						{
							if(number_format($z['grade_point'],2)>0.0 or (number_format($z['grade_point'],2)==0.0 && $z['grade']=='F'))
							{										
								echo $z['course_code']."\t".$z['course_title']."\t".number_format($z['course_credit'],2)."\t".$z['grade']."\t".number_format($z['grade_point'],2)."\r\n";
							}
						}
						echo "\r\n\r\n";
					
						
					}
				}
			}
				
				//show waived courses there
				if(count($ra_w)>0)
				{
					
					echo 'Waived Courses'."\t\t".'Credit: '.number_format($waived_credit,2)."\r\n";
					echo 'Course Code'."\t".'Course Title'."\t".'Credit'."\r\n";
						
						foreach($ra_w as $cge)
						{
					
							echo $cge['course_code']."\t".$cge['course_title']."\t".number_format($cge['course_credit'],2)."\r\n";
							
					
						}
						
				}
						
			
		}
		catch(Exception $e)
		{
			echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
		}
		
		
		
	}
	else
	{
		
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>