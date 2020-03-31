<?php
	if(isset($_GET['s_id']) && isset($_GET['dob']))
	{
		try{
			$s_id=$_GET['s_id'];
			$dob=$_GET['dob'];
			ob_start();
			require("../includes/db_connection.php");
			require("../includes/function.php");
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id and nr_stud_dob=:dob and nr_stud_status='Active' limit 1 ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':dob', $dob);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if(count($result)==0)
			{
				echo 'not_found';
				die();
			}
			
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
			$stmt = $conn->prepare("insert into nr_result_check_transaction values(:s_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','Active') ");
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
				echo 'not_found';
				die();
			}
			
			
			//Search for student program credit
			$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
			$stmt->execute();
			$prcr_result = $stmt->fetchAll();
			if(count($prcr_result)==0)
			{
				echo 'not_found';
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
			$fail_re=array();
			$pass_re=array();
			$fail_credit=0;
			$pass_credit=0;
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
				
						
				//storing pass course only
				if(array_key_exists($stud_course_code,$pass_re))
				{
					if($stud_grade!='F')
					{
						if($stud_grade_point>$pass_re[$stud_course_code]['grade_point'])
						{
							$pass_re[$stud_course_code]=$abc;
						}
					}
					
				}
				else
				{
					if($stud_grade!='F')
					{
						$pass_re[$stud_course_code]=$abc;
						$pass_credit+=$stud_course_credit;
					}
				}
				
				
				//storing fail course only
				if(array_key_exists($stud_course_code,$fail_re))
				{
					if($stud_grade!='F')
					{
						unset($fail_re[$stud_course_code]);
						$fail_credit-=$stud_course_credit;
					}
					else
					{
						$fail_re[$stud_course_code]['semester']=$stud_semester;
						$fail_re[$stud_course_code]['year']=$stud_year;
					}
				}
				else
				{
					if($stud_grade=='F')
					{
						$fail_re[$stud_course_code]=$abc;
						$fail_credit+=$stud_course_credit;
					}
				}
				
				
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
			$wa_re=array();
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
				$wa_re[$stud_course_code]=$abc;
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
			
		}catch(PDOException $e)
		{
			echo 'error';
			die();
		}
		catch(Exception $e)
		{
			echo 'error';
			die();
		}
		
?>

	<div class=" w3-modal-content w3-round-large w3-animate-bottom w3-card-4 w3-leftbar w3-rightbar w3-bottombar w3-topbar w3-border-white">
		<header class="w3-container w3-black w3-bottombar w3-border-teal w3-round-top-large"> 
			<span onclick="document.getElementById('result_popup').style.display='none';document.getElementById('result_popup').innerHTML ='Oops..'" class="w3-button w3-display-topright w3-large w3-hover-teal w3-round" style="padding:2px 12px;margin: 15px 10px;"><i class="fa fa-close"></i> Close</span>
			<p class="w3-xxlarge" style="margin:5px 0px;">Fetched Result</p>
		</header>
		<div id="sub_loading" class="w3-container w3-margin-0 w3-padding-0 w3-black w3-animate-top w3-center" style="width:100%;height:100%;opacity:0.75;z-index:111;padding-top:150px;top:0;left:0;position:absolute;display:none;">
			<p class="w3-bold">Please wait while setting subscription email..</p>
			<i class="fa fa-spinner w3-spin " style="font-size:120px;"></i>
		</div>
		<div class="w3-container w3-row w3-round-bottom-large w3-padding w3-border w3-border-teal" style="height:100%;">
			
			<div class="w3-container w3-padding-small" style="margin:0px;padding:0px;width:100%;min-height:200px;height:auto;">
				<div class="w3-row w3-bottombar w3-border-teal">
					<!--part 1 -->
					<div class="w3-half w3-container w3-padding-0">
						<div class="w3-row w3-padding-0">
							<div class="w3-col w3-container w3-padding-0 w3-margin-0" style="width:110px;">
								<?php if($photo=="" && $gender=="Male"){ ?>
										<img src="../images/system/male_profile.png" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
								<?php } else if($photo==""){ ?>
										<img src="../images/system/female_profile.png" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
								<?php } else { ?>
										<img src="../images/student/<?php echo $photo; ?>" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
								<?php } ?>
							</div>
							<div class="w3-rest w3-container w3-padding-0 w3-margin-0" style="min-width:200px;">
								<table>
									<tr>
										<td valign="top">Name</td>
										<td valign="top" class="w3-bold">: <?php echo $name; ?></td>
									</tr>
									<tr>
										<td valign="top">Reg. No</td>
										<td valign="top" class="w3-bold">: <?php echo $reg_no; ?></td>
									</tr>
									<tr>
										<td valign="top">Session</td>
										<td valign="top">: <?php echo $session; ?></td>
									</tr>
									<tr>
										<td valign="top">Gender</td>
										<td valign="top">: <?php echo $gender; ?></td>
									</tr>
									<tr>
										<td valign="top">Birthdate</td>
										<td valign="top">: <?php echo get_date($birthdate); ?></td>
									</tr>
									<tr>
										<td colspan="2" class="w3-text-blue">
											<input type="checkbox" id="subscription" onclick="enable_subscribe(1)" value="checked-subscription" <?php if($subscription_email!="") { echo 'checked disabled'; } ?>/> 
											<font onclick="enable_subscribe(1)" class="w3-cursor">Subscribe Notification</font>
											<div class="w3-margin-0 w3-padding-0" id="edit_subscription" style="display:none;">
												<input type="email" placeholder=" Email Address" value="<?php if($subscription_email!="") { echo $subscription_email; } ?>" id="subscription_email" class="w3-round-large"> 
												<input type="hidden" id="sub_s_id" value="<?php echo $reg_no; ?>">
												<input type="hidden" id="sub_dob" value="<?php echo $birthdate; ?>">
												<input type="hidden" id="sub_email" value="<?php echo $subscription_email; ?>">
												<i class="w3-green fa fa-check-square-o w3-large" onclick="enable_subscribe(2)"></i> 
												<i class="w3-red fa fa-times-circle-o w3-large" onclick="enable_subscribe(0)"></i>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<!-- part 2 -->
					<div class="w3-half w3-container w3-padding-0">
						<table style="width:100%;">
							<tr>
								<td valign="top">Degree</td>
								<td colspan="2" valign="top" class="w3-bold">: <?php echo $degree; ?></td>
							</tr>
							<tr>
								<td valign="top">Degree Credit</td>
								<td colspan="2" valign="top" class="w3-bold">: <?php echo $total_credit; ?></td>
							</tr>
							<tr>
								<td valign="top">Credit Earned</td>
								<td colspan="2" valign="top" class="w3-text-green">: <?php echo $earned_credit; ?></td>
							</tr>
							<tr>
								<td valign="top">Credit Waived</td>
								<td colspan="2" valign="top">: <?php echo $waived_credit; ?></td>
							</tr>
							<tr>
								<td valign="top">CGPA</td>
								<td colspan="2" valign="top" class="w3-text-red">: <?php echo $total_cgpa; ?></td>
							</tr>
							<tr>
								<td valign="top">Degree Status</td>
								<td valign="top" class="w3-bold">: <?php echo $degree_status; ?></td>
								<td valign="top"><a onclick="window.open('print.php?s_id=<?php echo $s_id; ?>&dob=<?php echo $dob; ?>')" target="_blank" class="w3-button w3-round-large w3-black w3-hover-teal w3-padding-small w3-right"><i class="fa fa-print"></i> Print</a></td>
							</tr>
						</table>
					</div>
				</div>
				<button onclick="search_result_button(1)" id="se_re_btn_1" class="w3-button w3-teal w3-hover-teal w3-padding-small w3-border w3-border-teal w3-medium"><i class="fa fa-server"></i> All Result</button>
				<button onclick="search_result_button(2)" id="se_re_btn_2" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="fa fa-sticky-note-o"></i> Fail Courses</button>
				<button onclick="search_result_button(3)" id="se_re_btn_3" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="fa fa-check-square-o"></i> Pass Courses</button>
				<button onclick="search_result_button(4)" id="se_re_btn_4" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="fa fa-file-text-o"></i> Drop Courses</button>
				<button onclick="search_result_button(5)" id="se_re_btn_5" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="	fa fa-ticket"></i> Waived Courses</button>
				
				
				<div id="se_re_div_1" class="w3-container w3-margin-0 w3-padding-0" style="height: 270px;overflow:auto;">
					<!-- Summer 2014 semester result -->
					<!-- use red in fail -->
					<!-- use blue in retake -->
					<!-- use yellow in incomplete -->
					<?php
						if(count($se_re)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						}
						for($i=get_year($s_id);$i<=Date("Y");$i++)
						{			
							if(array_key_exists(('Spring-'.$i),$se_re))
							{
								$t_c=0.0;
								$t_g=0.0;
								foreach($se_re['Spring-'.$i] as $z)
								{
									if(number_format($z['grade_point'],2)>0.0)
									{
										$t_c=$t_c+$z['course_credit'];
										$t_g=$t_g+($z['grade_point']*$z['course_credit']);
									}
								}
								
								
					?>
								<button title="Click here to view details" onclick="show_result_div('<?php echo 'Spring-'.$i; ?>')" class="w3-button w3-black w3-round-large w3-hover-teal w3-padding w3-left-align" style="width:100%;max-width:300px;display:block;margin:8px 0px 5px 0px;"><i class="fa fa-plus-square" id="<?php echo 'Spring-'.$i; ?>_icon" ></i> Semester Result: <?php echo 'Spring-'.$i; ?></button>
								<table id="<?php echo 'Spring-'.$i; ?>" style="width:96%;display:none;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
									<tr class="w3-black w3-bold w3-padding-small">
										<td colspan="2" valign="top" class="w3-padding-small">Semester: <?php echo 'Spring-'.$i; ?></td>
										<td colspan="2" valign="top" class="w3-padding-small">CGPA: <?php if($t_c==0.0){ echo number_format(0.0,2); } else{ echo number_format(($t_g/$t_c),2); } ?></td>
										<td colspan="2" valign="top" class="w3-padding-small">Credit: <?php echo number_format($t_c,2); ?></td>
									</tr>
									<tr class="w3-teal w3-bold">
										<td style="width:20%;" valign="top" class="w3-padding-small">Course Code</td>
										<td style="width:40%;" valign="top" class="w3-padding-small">Course Title</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Credit</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Grade</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Grade Point</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Remarks</td>
									</tr>
									<?php
										foreach($se_re['Spring-'.$i] as $z)
										{
											if($z['grade']=='F')
												echo '<tr class="w3-text-red">';
											else
												echo '<tr>';
									?>
											
												<td valign="top" class="w3-padding-small"><?php echo $z['course_code']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $z['course_title']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($z['course_credit'],2); ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $z['grade']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($z['grade_point'],2); ?></td>
												<td valign="top" class="w3-padding-small <?php if($z['remarks']!=""){ echo 'w3-text-blue'; } ?>"><?php echo $z['remarks']; ?></td>
											</tr>
									<?php 
										}
									?>
								</table>
					
					<?php
								
							}
							
							if(array_key_exists(('Summer-'.$i),$se_re))
							{
								$t_c=0.0;
								$t_g=0.0;
								foreach($se_re['Summer-'.$i] as $z)
								{
									if(number_format($z['grade_point'],2)>0.0)
									{
										$t_c=$t_c+$z['course_credit'];
										$t_g=$t_g+($z['grade_point']*$z['course_credit']);
									}
								}
								
					?>
								<button title="Click here to view details" onclick="show_result_div('<?php echo 'Summer-'.$i; ?>')" class="w3-button w3-black w3-round-large w3-hover-teal w3-padding w3-left-align" style="width:100%;max-width:300px;display:block;margin:8px 0px 5px 0px;"><i class="fa fa-plus-square" id="<?php echo 'Summer-'.$i; ?>_icon" ></i> Semester Result: <?php echo 'Summer-'.$i; ?></button>
								<table id="<?php echo 'Summer-'.$i; ?>" style="width:96%;display:none;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
									<tr class="w3-black w3-bold w3-padding-small">
										<td colspan="2" valign="top" class="w3-padding-small">Semester: <?php echo 'Summer-'.$i; ?></td>
										<td colspan="2" valign="top" class="w3-padding-small">CGPA: <?php if($t_c==0.0){ echo number_format(0.0,2); } else{ echo number_format(($t_g/$t_c),2); } ?></td>
										<td colspan="2" valign="top" class="w3-padding-small">Credit: <?php echo number_format($t_c,2); ?></td>
									</tr>
									<tr class="w3-teal w3-bold">
										<td style="width:20%;" valign="top" class="w3-padding-small">Course Code</td>
										<td style="width:40%;" valign="top" class="w3-padding-small">Course Title</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Credit</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Grade</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Grade Point</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Remarks</td>
									</tr>
									<?php
										foreach($se_re['Summer-'.$i] as $z)
										{
											if($z['grade']=='F')
												echo '<tr class="w3-text-red">';
											else
												echo '<tr>';
									?>
											
												<td valign="top" class="w3-padding-small"><?php echo $z['course_code']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $z['course_title']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($z['course_credit'],2); ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $z['grade']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($z['grade_point'],2); ?></td>
												<td valign="top" class="w3-padding-small <?php if($z['remarks']!=""){ echo 'w3-text-blue'; } ?>"><?php echo $z['remarks']; ?></td>
											</tr>
									<?php 
										}
									?>
								</table>
					
					<?php
								
							}
							
							if(array_key_exists(('Fall-'.$i),$se_re))
							{
								$t_c=0.0;
								$t_g=0.0;
								foreach($se_re['Fall-'.$i] as $z)
								{
									if(number_format($z['grade_point'],2)>0.0)
									{
										$t_c=$t_c+$z['course_credit'];
										$t_g=$t_g+($z['grade_point']*$z['course_credit']);
									}
								}
								
								
					?>
								<button title="Click here to view details" onclick="show_result_div('<?php echo 'Fall-'.$i; ?>')" class="w3-button w3-black w3-round-large w3-hover-teal w3-padding w3-left-align" style="width:100%;max-width:300px;display:block;margin:8px 0px 5px 0px;"><i class="fa fa-plus-square" id="<?php echo 'Fall-'.$i; ?>_icon" ></i> Semester Result: <?php echo 'Fall-'.$i; ?></button>
								<table id="<?php echo 'Fall-'.$i; ?>" style="width:96%;display:none;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
									<tr class="w3-black w3-bold w3-padding-small">
										<td colspan="2" valign="top" class="w3-padding-small">Semester: <?php echo 'Fall-'.$i; ?></td>
										<td colspan="2" valign="top" class="w3-padding-small">CGPA: <?php if($t_c==0.0){ echo number_format(0.0,2); } else{ echo number_format(($t_g/$t_c),2); } ?></td>
										<td colspan="2" valign="top" class="w3-padding-small">Credit: <?php echo number_format($t_c,2); ?></td>
									</tr>
									<tr class="w3-teal w3-bold">
										<td style="width:20%;" valign="top" class="w3-padding-small">Course Code</td>
										<td style="width:40%;" valign="top" class="w3-padding-small">Course Title</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Credit</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Grade</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Grade Point</td>
										<td style="width:10%;" valign="top" class="w3-padding-small">Remarks</td>
									</tr>
									<?php
										foreach($se_re['Fall-'.$i] as $z)
										{
											if($z['grade']=='F')
												echo '<tr class="w3-text-red">';
											else
												echo '<tr>';
									?>
											
												<td valign="top" class="w3-padding-small"><?php echo $z['course_code']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $z['course_title']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($z['course_credit'],2); ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $z['grade']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($z['grade_point'],2); ?></td>
												<td valign="top" class="w3-padding-small <?php if($z['remarks']!=""){ echo 'w3-text-blue'; } ?>"><?php echo $z['remarks']; ?></td>
											</tr>
									<?php 
										}
									?>
								</table>
					
					<?php
								
							}
						}
					?>
					
				</div>
				<div id="se_re_div_2" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height: 270px;overflow:auto;">
					<?php
						//show failed courses there
						if(count($fail_re)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						}
						if(count($fail_re)>0)
						{
							foreach($fail_re as $cge)
							{
								if(array_key_exists($cge['course_code'],$pass_re))
								{
									$ww=$cge['course_code'];
									$fail_credit-=$cge['course_credit'];
									unset($fail_re[$ww]);
								}
							}
					?>
							<table style="width:96%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
								<tr class="w3-black w3-bold w3-padding-small">
									<td colspan="2" valign="top" class="w3-padding-small">Fail Courses</td>
									<td colspan="2" class="w3-padding-small" valign="top">Credit: <?php echo number_format($fail_credit,2); ?></td>
								</tr>
								<tr class="w3-teal w3-bold">
									<td valign="top" style="width:20%;" class="w3-padding-small">Course Code</td>
									<td valign="top" style="width:45%;" class="w3-padding-small">Course Title</td>
									<td valign="top" style="width:15%;" class="w3-padding-small">Credit</td>
									<td valign="top" style="width:20%;" class="w3-padding-small">Semester</td>
								</tr>
								<?php
									foreach($fail_re as $cge)
									{
								?>
										<tr>
											<td valign="top" class="w3-padding-small"><?php echo $cge['course_code']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['course_title']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo number_format($cge['course_credit'],2); ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['semester'].'-'.$cge['year']; ?></td>
										</tr>
								
								<?php
									}
								?>
							</table>
					<?php	
						}
						
					?>
					
				</div>
				<div id="se_re_div_3" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height: 270px;overflow:auto;">
					<?php
						//show passed courses there
						if(count($pass_re)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						}
						if(count($pass_re)>0)
						{
							
					?>
							<table style="width:96%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
								<tr class="w3-black w3-bold w3-padding-small">
									<td colspan="4" valign="top" class="w3-padding-small">Pass Courses</td>
									<td colspan="3" class="w3-padding-small" valign="top">Credit: <?php echo number_format($pass_credit,2); ?></td>
								</tr>
								<tr class="w3-teal w3-bold">
									<td valign="top" style="width:13%;" class="w3-padding-small">Course Code</td>
									<td valign="top" style="width:33%;" class="w3-padding-small">Course Title</td>
									<td valign="top" style="width:9%;" class="w3-padding-small">Credit</td>
									<td valign="top" style="width:9%;" class="w3-padding-small">Grade</td>
									<td valign="top" style="width:9%;" class="w3-padding-small">Grade Point</td>
									<td valign="top" style="width:18%;" class="w3-padding-small">Semester</td>
									<td valign="top" style="width:9%;" class="w3-padding-small">Remarks</td>
								</tr>
								<?php
									foreach($pass_re as $cge)
									{
								?>
										<tr>
											<td valign="top" class="w3-padding-small"><?php echo $cge['course_code']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['course_title']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo number_format($cge['course_credit'],2); ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['grade']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo number_format($cge['grade_point'],2); ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['semester'].'-'.$cge['year']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['remarks']; ?></td>
										</tr>
								
								<?php
									}
								?>
							</table>
					<?php	
						}
						
					?>
				</div>
				<div id="se_re_div_4" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height: 270px;overflow:auto;">
					<?php
						//Drop courses there
						//getting dept last result semester
						$stmt = $conn->prepare("SELECT * FROM nr_result where nr_prog_id=:prog_id and  nr_result_status='Active' order by nr_result_year desc, nr_result_semester desc");
						$stmt->bindParam(':prog_id', $prog_id);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)!=0)  //check for students who have results in db
						{
							$last_semester=$stud_result[0][6];
							$last_year=$stud_result[0][7];
						}
						
						//echo $last_semester.' '.$last_year.'</br>';
						$first_semester=get_session_semester($s_id);
						$first_year=get_year($s_id);
						//echo $first_semester.' '.$first_year.'</br>';
						
						if($first_year>$last_year)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						
						}
						else if($first_year==$last_year && (($last_semester=="Spring" && ($first_semester=="Summer" || $first_semester=="Fall")) || ($last_semester=="Summer" && $first_semester=="Fall")))
						{
							echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						}
						else
						{
							//getting total semester count
							$ct=1;
							for($q=$last_year;$q>=$first_year;$q--)
							{
								if($q==$last_year)
								{
									if($last_semester=='Fall')
									{
										if(('Fall-'.$last_year)!=($first_semester.'-'.$first_year))
										{
											$from_semester='Fall';
											$from_year=$q;
											$ct++;
										}
										else
											break;
										
										if(('Summer-'.$last_year)!=($first_semester.'-'.$first_year))
										{
											$from_semester='Summer';
											$from_year=$q;
											$ct++;
										}
										else 
											break;
											
										if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
										{
											$from_semester='Spring';
											$from_year=$q;
											$ct++;
										}
										else
											break;
									}
									else if($last_semester=='Summer')
									{
										if(('Summer-'.$last_year)!=($first_semester.'-'.$first_year))
										{
											$from_semester='Summer';
											$from_year=$q;
											$ct++;
										}
										else 
											break;
											
										if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
										{
											$from_semester='Spring';
											$from_year=$q;
											$ct++;
										}
										else
											break;
									}
									else if($last_semester=='Spring')
									{
																				
										if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
										{
											$from_semester='Spring';
											$from_year=$q;
											$ct++;
										}
										else
											break;
									}
								}
								else
								{
									if(('Fall-'.$q)!=($first_semester.'-'.$first_year))
									{
										$from_semester='Fall';
										$from_year=$q;
										$ct++;
									}
									else
										break;
									
									if(('Summer-'.$q)!=($first_semester.'-'.$first_year))
									{
										$from_semester='Summer';
										$from_year=$q;
										$ct++;
									}
									else
										break;
									
									if(('Spring-'.$q)!=($first_semester.'-'.$first_year))
									{
										$from_semester='Spring';
										$from_year=$q;
										$ct++;
									}
									else
										break;
								}
							}
							//echo $ct;  //no of semester passed with published result
							$stmt = $conn->prepare("select * from nr_course a,nr_drop b where a.nr_course_id=b.nr_course_id and b.nr_drop_semester<='$ct' and b.nr_prcr_id=:prcr_id and b.nr_drop_status='Active' ");
							$stmt->bindParam(':prcr_id', $prcr_id);
							$stmt->execute();
							$stud_result=$stmt->fetchAll();
							if(count($stud_result)==0)
							{
								//no drop course found
								echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
							}
							else
							{
								$drop_re=array();
								$drop_credit=0.0;
								$optional=array();
								$sz5=count($stud_result);
								for($p=0;$p<$sz5;$p++)
								{
									$course_code=$stud_result[$p][1];
									$course_title=$stud_result[$p][2];
									$course_credit=$stud_result[$p][3];
									if($stud_result[$p][11]=="Compulsory")
									{
										if(!array_key_exists($course_code,$pass_re) && !array_key_exists($course_code,$fail_re) && !array_key_exists($course_code,$wa_re))
										{
											$drop_re[$course_code]=array('course_code'=>$course_code,'course_title'=>$course_title,'course_credit'=>$course_credit);
											$drop_credit+=$course_credit;
										}
									}
									else
									{
										//storing optional course data for further calculation
										$course_remarks=$stud_result[$p][11];
										$optional[$course_remarks][$course_code]=array('course_type'=>$course_remarks,'course_code'=>$course_code,'course_title'=>$course_title,'course_credit'=>$course_credit);
									}
								}
								//Generating Optional Courses
								foreach($optional as $option)
								{
									$fl=0;
									$crs_title="";
									$crs_code="";
									foreach($option as $sub)
									{
										//echo $sub['course_type'].' '.$sub['course_code'].'</br>';
										if(array_key_exists($sub['course_code'],$pass_re) || array_key_exists($sub['course_code'],$fail_re) || array_key_exists($sub['course_code'],$wa_re))
										{
											$fl=1;
											break;
										}
									}
									if($fl==0)
									{
										$crs_title=$sub['course_type'];
										$crs_code="";
										$yy=$sub['course_code'];
										for($s=0;$s<5;$s++)
										{
											$crs_code=$crs_code.$yy[$s];
										}
										$crs_code=$crs_code.'*'.'*';
										$drop_re[$crs_code]=array('course_code'=>$crs_code,'course_title'=>$crs_title,'course_credit'=>$sub['course_credit']);
										$drop_credit+=$sub['course_credit'];
									}
								}
								
							}
							if(count($drop_re)==0)
							{
								echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
							}
							else
							{
								?>
								<p class="w3-margin-0 w3-padding-0 w3-small w3-bold w3-justify w3-text-red">
									Note: This drop courses list generated according to the program syllabus so it may not be same with the department offered course list.
								</p>
								<table style="width:96%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
									<tr class="w3-black w3-bold w3-padding-small">
										<td colspan="2" valign="top" class="w3-padding-small">Drop Courses</td>
										<td colspan="1" class="w3-padding-small" valign="top">Credit: <?php echo number_format($drop_credit,2); ?></td>
									</tr>
									<tr class="w3-teal w3-bold">
										<td valign="top" style="width:30%;" class="w3-padding-small">Course Code</td>
										<td valign="top" style="width:45%;" class="w3-padding-small">Course Title</td>
										<td valign="top" style="width:25%;" class="w3-padding-small">Credit</td>
									</tr>
									<?php
										foreach($drop_re as $cge)
										{
									?>
											<tr>
												<td valign="top" class="w3-padding-small"><?php echo $cge['course_code']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo $cge['course_title']; ?></td>
												<td valign="top" class="w3-padding-small"><?php echo number_format($cge['course_credit'],2); ?></td>
											</tr>
									
									<?php
										}
									?>
								</table>
							<?php	
							}
						
					
						}
					?>
				</div>
				<div id="se_re_div_5" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height: 270px;overflow:auto;">
					<?php
						//show waived courses there
						if(count($ra_w)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 100px 0px 0px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						}
						if(count($ra_w)>0)
						{
					?>
							<table style="width:96%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
								<tr class="w3-black w3-bold w3-padding-small">
									<td colspan="2" valign="top" class="w3-padding-small">Waived Courses</td>
									<td class="w3-padding-small" valign="top">Credit: <?php echo number_format($waived_credit,2); ?></td>
								</tr>
								<tr class="w3-teal w3-bold">
									<td valign="top" style="width:25%;" class="w3-padding-small">Course Code</td>
									<td valign="top" style="width:45%;" class="w3-padding-small">Course Title</td>
									<td valign="top" style="width:30%;" class="w3-padding-small">Credit</td>
								</tr>
								<?php
									foreach($ra_w as $cge)
									{
								?>
										<tr>
											<td valign="top" class="w3-padding-small"><?php echo $cge['course_code']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo $cge['course_title']; ?></td>
											<td valign="top" class="w3-padding-small"><?php echo number_format($cge['course_credit'],2); ?></td>
										</tr>
								
								<?php
									}
								?>
							</table>
					<?php	
						}
						
					?>
				</div>
			</div>
		</div>
	</div>

<?php	
	}
	else
		header("location: index.php");
?>