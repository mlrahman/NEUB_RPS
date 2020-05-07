<?php
			
	if(isset($_GET['s_id']) && isset($_GET['dob']))
	{
		try{
			$s_id=$_GET['s_id'];
			$dob=$_GET['dob'];
			ob_start();
			session_start();
			require("../includes/db_connection.php");
			require("../includes/function.php");
			
			
			if(!isset($_SESSION['student_id']) || !isset($_SESSION['dob']))
			{
				unset($_SESSION['student_id']);
				unset($_SESSION['dob']);
				echo '<div id="invalid_msg" style="padding:8px 0px;background:red;text-align:center;width:100%;top:0;left:0;position:fixed;z-index:999999999;display:none;">
						<p id="i_msg" style="color:white;font-family:century schoolbook;font-weight:bold;display: inline;"></p>
					</div>';
				echo "<script>  document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry session destroyed try again.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);	
					  </script> ";
				echo '<script> setTimeout(function(){window.close()},2000); </script>';
			}
			else if(isset($_SESSION['student_id']) && isset($_SESSION['dob']) && (password_encrypt($_SESSION['student_id'].get_current_date())!=$s_id || password_encrypt($_SESSION['dob'].get_current_date())!=$dob))
			{
				unset($_SESSION['student_id']);
				unset($_SESSION['dob']);
				header("location: index.php");
			}
			else
			{
				$s_id=$_SESSION['student_id'];
				$dob=$_SESSION['dob'];
				unset($_SESSION['student_id']);
				unset($_SESSION['dob']);
			
			
			
			
				$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id and nr_stud_dob=:dob and nr_stud_status='Active' limit 1 ");
				$stmt->bindParam(':s_id', $s_id);
				$stmt->bindParam(':dob', $dob);
				$stmt->execute();
				$result = $stmt->fetchAll();
				
				if(count($result)==0)
				{
					header("location: index.php");
					die();
				}
				
				$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
				$stmt->execute();
				$result_t = $stmt->fetchAll();
				
				if(count($result_t)==0)
				{
					header("location: index.php");
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
				
				$stmt = $conn->prepare("insert into nr_transcript_print_reference values(:s_id,'Student',:s_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','$ref','Active') ");
				$stmt->bindParam(':s_id', $s_id);
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
					header("location: index.php");
					die();
				}
				
				//Search for student program credit
				$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
				$stmt->execute();
				$prcr_result = $stmt->fetchAll();
				if(count($prcr_result)==0)
				{
					header("location: index.php");
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
							$sz4=count($se_re[$key]);
							for($j=0;$j<$sz4;$j++)
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
				$sz3=count($stud_result);
				for($i = 0; $i < $sz3; $i++) {
					
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
				
				
				
				$html='
				<head>
					<style>
					
					.page-header, .page-header-space {
					  height: 120px;
					}

					.page-footer, .page-footer-space {
					  height: 50px;
					  margin-top:10px;
					}

					.page-footer {
					  position: fixed;
					  bottom: 0;
					  width: 700px;
					  
					}

					.page-header {
					  position: fixed;
					  top: 0mm;
					  width: 700px;
					  margin:0px;
					  
					}

					.page {
					  page-break-inside: avoid;
					  
					}

					@page {
					  margin: 6mm 15mm 6mm 15mm;
					  
					}
					
					@media print {
					   thead {display: table-header-group;} 
					   tfoot {display: table-footer-group;}
					   
					   
					   body {margin: 0;}
					}
					
					#gt td{border-right:1px solid black;}
					</style>
				</head>
				<html>
					<body onclick="document.getElementById(\'content\').innerHTML=\'\';window.close();"  style="font-family: "Century Schoolbook", sans-serif;font-size:12px;"><div id="content">';
				
					$html=$html.'
					<div class="page-header" style="text-align: center;">
						<div style="border-bottom: 3px solid black;">
							<div style="height:75px;">
								<div style="width:65px;padding:0px;margin:0px;float:left;">
									<img src="../images/system/'.$logo.'" alt="NEUB LOGO" style="width:68px;height:70px;">
								</div>
								<div style="width:630px;float:left;padding:0px;margin:0px;">
									<p style="padding: 0px;margin:10px 0px 5px 0px;font-size:25px;font-weight:bold;margin-left:8px;">NORTH EAST UNIVERSITY BANGLADESH (NEUB)</p>
									<p style="margin:0px;padding:0px;font-size: 22px;font-weight:bold;text-align:center;">SYLHET, BANGLADESH.</p>
								</div>
							</div>
						</div>
						<p style="color:red;font-size:11px;text-align:justify;margin:4px 0px 0px 0px;padding:0px;">
							<b>Note:</b> This is an unofficial transcript downloaded from North East University Bangladesh result portal. For any query you can visit the official website, result portal or can contact with the office of the controller of examination. 
						</p>
						<p style="color:purple;font-size:12px;text-align:right;margin:0px 0px 0px 0px;">
							<b>Ref: '.$ref.'</b>
						</p>
					</div>

					  <div class="page-footer">
						<div style="border-top:3px solid black;margin: 0px;padding:0px;width:700px;text-align:center;">
							<p style="margin:0px;padding:0px;font-size:12px;">Address: '.$address.'</p>
							<p style="margin:0px;padding:0px;font-size:12px;">Phone: '.$telephone.', Fax: 0821-710223, Mobile: '.$mobile.', E-mail: '.$email.'</p>
							<p style="margin:0px;padding:0px;font-size:12px;">Website: '.$web.'</p>
						</div>
					  </div>';

					
					
					
					
					$html=$html.'

					  <table>

						<thead>
						  <tr>
							<td>
							  <!--place holder for the fixed-position header-->
							  <div class="page-header-space"></div>
							</td>
						  </tr>
						</thead>

						<tbody>
						  <tr>
							<td>
								<p style="margin:0px 0px 5px 0px;padding:0px;font-size:17px;font-weight:bold;text-align:justify;">
									Online Transcript of Academic Record
								</p>
								<div style="width:700px;">
									<div style="width:90px;height:240px;float:left;padding:4px;box-sizing:border-box;">';
										if($photo=="" && $gender=="Male"){ 
												$html=$html.'<img src="../images/system/male_profile.png" style="margin:0px;padding:0px;width:70px;height: 80px;border:2px solid black;" title="Picture (120X100)"/>';
										} else if($photo==""){ 
												$html=$html.'<img src="../images/system/female_profile.png" style="margin:0px;padding:0px;width:70px;height: 80px;border: 2px solid black;" title="Picture (120X100)"/>';
										} else { 
												$html=$html.'<img src="../images/student/'.$photo.'"  style="margin:0px;padding:0px;width:70px;height: 80px;border: 2px solid black;" title="Picture (120X100)"/>';
										} 
									
									$html=$html.'</div>
									<div style="width:410px;float:left;height:240px;">
										<table style="font-weight:bold;font-size:12px;">
											<tr>
												<td valign="top">Student Name</td>
												<td valign="top">: '.$name.'</td>
											</tr>
											<tr>
												<td valign="top">Registration No</td>
												<td valign="top">: '.$reg_no.'</td>
											</tr>
											<tr>
												<td valign="top">Session</td>
												<td valign="top">: '.$session.'</td>
											</tr>
											<tr>
												<td valign="top">Gender</td>
												<td valign="top">: '.$gender.'</td>
											</tr>
											<tr>
												<td valign="top">Degree Name</td>
												<td valign="top">: '.$degree.'</td>
											</tr>
											<tr>
												<td valign="top">Credit Required</td>
												<td valign="top">: '.$total_credit.'</td>
											</tr>
											<tr>
												<td valign="top">Credit Earned</td>
												<td valign="top">: '.$earned_credit.'</td>
											</tr>
											<tr>
												<td valign="top">Credit Waived</td>
												<td valign="top">: '.$waived_credit.'</td>
											</tr>
											<tr>
												<td valign="top">CGPA Earned</td>
												<td valign="top">: '.$total_cgpa.'</td>
											</tr>
											<tr>
												<td valign="top">Degree Status</td>
												<td valign="top">: '.$degree_status.'</td>
											</tr>
											<tr>
												<td valign="top" style="color:blue;">Issue Date</td>
												<td valign="top" style="color:blue;">: '.get_date(get_current_date()).'</td>
											</tr>
										</table>
									</div>
									<div style="width:190px;padding:0px;margin:0px;float:left;height: 240px;">
										<p style="margin:0px 0px 3px 0px;padding:0px;font-size:12px;font-weight:bold;text-align:left;">
											Grading System
										</p>
										<table id="gt" style="border-collapse: collapse;border: 1px solid black;font-size:12px;text-align:center;width:190px;">
											<tr>
												<td style="border: 1px solid black;width:90px;margin:0px;padding:0px;"><b>Marks%</b></td>
												<td style="border: 1px solid black;width:50px;margin:0px;padding:0px;"><b>Letter</b></td>
												<td style="border: 1px solid black;width:50pxmargin:0px;padding:0px;"><b>Grade Point</b></td>
											</tr>
											<tr>
												<td>80% and Above</td> 
												<td>A+</td>
												<td>4.00</td>
											</tr>
											<tr>
												<td>75% - 79%</td>
												<td>A</td>
												<td>3.75</td>
											</tr> 
											<tr>
												<td>70% - 74%</td>
												<td>A-</td>
												<td>3.50</td>
											</tr> 
											<tr>
												<td>65% - 69%</td>
												<td>B+</td>
												<td>3.25</td>
											</tr> 
											<tr>
												<td>60% - 64%</td>
												<td>B</td>
												<td>3.00</td>
											</tr> 
											<tr>
												<td>55% - 59%</td>
												<td>B-</td>
												<td>2.75</td>
											</tr> 
											<tr>
												<td>50% - 54%</td>
												<td>C+</td>
												<td>2.50</td>
											</tr> 
											<tr>
												<td>45% - 49%</td>
												<td>C</td>
												<td>2.25</td>
											</tr> 
											<tr>
												<td>40% - 44%</td>
												<td>D</td>
												<td>2.00</td>
											</tr> 
											<tr>
												<td>Less than 40%</td>
												<td>F</td>
												<td>0.00</td>
											</tr>
												
										</table>
										
									</div>
								</div>
							
							
							';
							
							if(count($se_re)==0)
							{
								$html=$html.'<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No result available</p>';
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
										
										$html=$html.'<table style="width:700px;margin-top:10px;font-size:12px;" >
											<tr>
												<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>Semester: '.'Spring-'.$i.'</b></td>
												<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>CGPA: '; if($t_c==0.0){  $html=$html.number_format(0.0,2); } else{  $html=$html.number_format(($t_g/$t_c),2); } $html=$html.'</b></td>
												<td colspan="1" valign="top" style="border-top: 1px solid black;"><b>Credit: '.number_format($t_c,2).'</b></td>
											</tr>
											<tr class="w3-teal w3-bold">
												<td style="width:15%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Course Code</b></td>
												<td style="width:40%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Course Title</b></td>
												<td style="width:10%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Credit</b></td>
												<td style="width:10%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Grade</b></td>
												<td style="width:25%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Grade Point</b></td>
											</tr>';
											
												foreach($se_re['Spring-'.$i] as $z)
												{
													if(number_format($z['grade_point'],2)>0.0 or (number_format($z['grade_point'],2)==0.0 && $z['grade']=='F'))
													{										
														$html=$html.'<tr>
															<td valign="top">'.$z['course_code'].'</td>
															<td valign="top">'.$z['course_title'].'</td>
															<td valign="top">'.number_format($z['course_credit'],2).'</td>
															<td valign="top">'.$z['grade'].'</td>
															<td valign="top">'.number_format($z['grade_point'],2).'</td>
														</tr>';
													}
												}
											
										$html=$html.'<tr><td colspan="5" style="border-top: 1px solid black;"></td></tr></table>';
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
										$html=$html.'<table style="width:700px;margin-top:10px;font-size:12px;" >
											<tr>
												<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>Semester: '.'Summer-'.$i.'</b></td>
												<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>CGPA: '; if($t_c==0.0){  $html=$html.number_format(0.0,2); } else{  $html=$html.number_format(($t_g/$t_c),2); } $html=$html.'</b></td>
												<td colspan="1" valign="top" style="border-top: 1px solid black;"><b>Credit: '.number_format($t_c,2).'</b></td>
											</tr>
											<tr class="w3-teal w3-bold">
												<td style="width:15%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Course Code</b></td>
												<td style="width:40%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Course Title</b></td>
												<td style="width:10%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Credit</b></td>
												<td style="width:10%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Grade</b></td>
												<td style="width:25%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Grade Point</b></td>
											</tr>';
											
												foreach($se_re['Summer-'.$i] as $z)
												{
													if(number_format($z['grade_point'],2)>0.0 or (number_format($z['grade_point'],2)==0.0 && $z['grade']=='F'))
													{
														$html=$html.'<tr>
															<td valign="top">'.$z['course_code'].'</td>
															<td valign="top">'.$z['course_title'].'</td>
															<td valign="top">'.number_format($z['course_credit'],2).'</td>
															<td valign="top">'.$z['grade'].'</td>
															<td valign="top">'.number_format($z['grade_point'],2).'</td>
														</tr>';
													}
												}
											
										$html=$html.'<tr><td colspan="5" style="border-top: 1px solid black;"></td></tr></table>';
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
										$html=$html.'<table style="width:700px;margin-top:10px;font-size:12px;" >
											<tr>
												<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>Semester: '.'Fall-'.$i.'</b></td>
												<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>CGPA: '; if($t_c==0.0){  $html=$html.number_format(0.0,2); } else{  $html=$html.number_format(($t_g/$t_c),2); } $html=$html.'</b></td>
												<td colspan="1" valign="top" style="border-top: 1px solid black;"><b>Credit: '.number_format($t_c,2).'</b></td>
											</tr>
											<tr class="w3-teal w3-bold">
												<td style="width:15%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Course Code</b></td>
												<td style="width:40%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Course Title</b></td>
												<td style="width:10%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Credit</b></td>
												<td style="width:10%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Grade</b></td>
												<td style="width:25%;border-top: 1px solid black;border-bottom: 1px solid black;" valign="top"><b>Grade Point</b></td>
											</tr>';
											
												foreach($se_re['Fall-'.$i] as $z)
												{
													if(number_format($z['grade_point'],2)>0.0 or (number_format($z['grade_point'],2)==0.0 && $z['grade']=='F'))
													{
														$html=$html.'<tr>
															<td valign="top">'.$z['course_code'].'</td>
															<td valign="top">'.$z['course_title'].'</td>
															<td valign="top">'.number_format($z['course_credit'],2).'</td>
															<td valign="top">'.$z['grade'].'</td>
															<td valign="top">'.number_format($z['grade_point'],2).'</td>
														</tr>';
													}
												}
											
										$html=$html.'<tr><td colspan="5" style="border-top: 1px solid black;"></td></tr></table>';
										}	
									}
								}
								
								//show waived courses there
								if(count($ra_w)>0)
								{
									
									$html=$html.'<table id="course_waived" style="width:700px;margin-top:10px;font-size:12px;">
										<tr>
											<td colspan="2" valign="top" style="border-top: 1px solid black;"><b>Waived Courses</b></td>
											<td valign="top" style="border-top: 1px solid black;"><b>Credit: '.number_format($waived_credit,2).'</b></td>
										</tr>
										<tr class="w3-teal w3-bold">
											<td valign="top" style="width:15%;border-top: 1px solid black;border-bottom: 1px solid black;"><b>Course Code</b></td>
											<td valign="top" style="width:40%;border-top: 1px solid black;border-bottom: 1px solid black;"><b>Course Title</b></td>
											<td valign="top" style="width:45%;border-top: 1px solid black;border-bottom: 1px solid black;"><b>Credit</b></td>
										</tr>';
										
										foreach($ra_w as $cge)
										{
									
											$html=$html.'<tr>
												<td valign="top">'.$cge['course_code'].'</td>
												<td valign="top">'.$cge['course_title'].'</td>
												<td valign="top">'.number_format($cge['course_credit'],2).'</td>
											</tr>';
									
										}
										
									$html=$html.'<tr><td colspan="3" style="border-top: 1px solid black;"></td></tr></table>';
								}
							
							$html=$html.'</td>
						  </tr>
						</tbody>

						<tfoot>
						  <tr>
							<td>
							  <!--place holder for the fixed-position footer-->
							  <div class="page-footer-space"></div>
							</td>
						  </tr>
						</tfoot>

					  </table>
					';
					
					
						
					$html=$html.'</div></body>
				</html>';
				
				echo $html;
			?>
				
				<script>
					window.print();
					window.onfocus=setTimeout(function(){window.close()},300);
				</script>
				
			<?php
			}
				session_write_close();
		}
		catch(Exception $e)
		{
			header("location: index.php");
		}
	
?>
<?php	
	}
	else
		header("location: index.php");
	
?>