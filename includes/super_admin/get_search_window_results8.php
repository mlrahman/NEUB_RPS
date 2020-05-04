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
	if(isset($_REQUEST['student_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$s_id=$_REQUEST['student_id'];
			
			$stmt = $conn->prepare("select nr_studi_graduated from nr_student_info where nr_stud_id=:s_id limit 1 ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll=0;
			if(count($result)!=0)
			{
				$flll=$result[0][0];
			}
			
			$stmt = $conn->prepare("select count(nr_stud_id) from nr_result where nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll1=0;
			if(count($result)!=0)
			{
				if($result[0][0]>=1)
				{
					$flll1=1;
				}
			}
			
			$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$flll2=0;
			if(count($result)!=0)
			{
				$flll2=1;
			}
			
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id limit 1 ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if(count($result)==0)
			{
				echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Data not found"><i class="fa fa-warning"></i> Data not found.</p>';
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
			$stmt = $conn->prepare("insert into nr_admin_result_check_transaction values(:s_id,:f_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','Active') ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':f_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			$name = $result[0][1];
			$reg_no = $result[0][0];
			$session = get_session($reg_no);
			$gender = $result[0][3];
			$birthdate = $result[0][2];
			$subscription_email = $result[0][4];
			$mobile = $result[0][5];
			$prog_id = $result[0][7];
			$prog_id2 = $result[0][7];
			$prcr_id = $result[0][8];
			$status = $result[0][9];
			
			//Search for student program
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=$prog_id");
			$stmt->execute();
			$prog_result = $stmt->fetchAll();
			$degree = $prog_result[0][1];
			if(count($prog_result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Network Network Error Occurred Occurred!!"> Network Error Occurred</i>';
				die();
			}
			
			
			//Search for student program credit
			$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
			$stmt->execute();
			$prcr_result = $stmt->fetchAll();
			if(count($prcr_result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Network Network Error Occurred Occurred!!"> Network Error Occurred</i>';
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
			$sz2=count($stud_result);
			for($i = 0; $i < $sz2; $i++) {
				
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
						$sz=count($se_re[$key]);
						for($j=0;$j<$sz;$j++)
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
						$sz=count($se_re[$key]);
						for($j=0;$j<$sz;$j++)
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
			$sz=count($stud_result);
			for($i = 0; $i < $sz; $i++) {
				
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
			
			if($waived_credit==0) $waived_credit='N/A';
			
			if(isset($_SESSION['student_id']))
			{
				unset($_SESSION['student_id']);
			}
			$_SESSION['student_id']=$s_id;
			
		}catch(PDOException $e)
		{
			echo '<i class="fa fa-warning w3-text-red" title="Network Network Error Occurred Occurred!!"> Network Error Occurred</i>';
			die();
		}
		catch(Exception $e)
		{
			echo '<i class="fa fa-warning w3-text-red" title="Network Network Error Occurred Occurred!!"> Network Error Occurred</i>';
			die();
		}
		
?>

	
		<div class="w3-container w3-row" style="height:100%;padding: 0px 12px 10px 12px;" id="student_view_box1" >
			<p class="w3-margin-0 w3-left w3-text-indigo w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('student_view_box1').style.display='none';document.getElementById('student_view_box2').style.display='none';document.getElementById('student_view_box3').style.display='none';document.getElementById('student_view_box4').style.display='block';document.getElementById('student_view_box5').style.display='none';"><i class="fa fa-edit"></i> Edit Student</p>
			<p class="w3-margin-0 w3-left w3-text-indigo w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('student_view_box1').style.display='none';document.getElementById('student_view_box2').style.display='none';document.getElementById('student_view_box3').style.display='none';document.getElementById('student_view_box4').style.display='none';document.getElementById('student_view_box5').style.display='block';"><i class="fa fa-pencil-square"></i> Modify Waived Courses</p>
			<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('student_view_box1').style.display='none';document.getElementById('student_view_box2').style.display='none';document.getElementById('student_view_box3').style.display='block';document.getElementById('student_view_box4').style.display='none';document.getElementById('student_view_box5').style.display='none';"><i class="fa fa-history"></i> Student History</p>
			<div class="w3-clear"></div>
			<div class="w3-container w3-padding-small w3-border w3-round-large" style="margin:0px;padding:0px;width:100%;min-height:200px;height:auto;">
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
								<td valign="top">
									<div class="w3-dropdown-hover w3-round-large w3-right">
										<button class="w3-button w3-black w3-round-large w3-hover-teal w3-padding-small"><i class="fa fa-print"></i> Print</button>
										<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
											<a onclick="admin_print_result('<?php echo password_encrypt($s_id.get_current_date()); ?>','<?php echo password_encrypt($_REQUEST['admin_id'].get_current_date()); ?>')" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Online Transcript</a>
											<a onclick="" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Official Transcript</a>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<button onclick="search_result_button(1)" id="se_re_btn_1" class="w3-button w3-teal w3-hover-teal w3-padding-small w3-border w3-border-teal w3-medium"><i class="fa fa-server"></i> All Result</button>
				<button onclick="search_result_button(2)" id="se_re_btn_2" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="fa fa-sticky-note-o"></i> Fail Courses</button>
				<button onclick="search_result_button(3)" id="se_re_btn_3" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="fa fa-check-square-o"></i> Pass Courses</button>
				<button onclick="search_result_button(4)" id="se_re_btn_4" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="fa fa-file-text-o"></i> Drop Courses</button>
				<button onclick="search_result_button(5)" id="se_re_btn_5" class="w3-button w3-white w3-hover-teal w3-padding-small w3-border w3-medium"><i class="	fa fa-ticket"></i> Waived Courses</button>
				<div id="se_re_div_1" class="w3-container w3-margin-0 w3-padding-0" style="height:auto;">
					<!-- Summer 2014 semester result -->
					<!-- use red in fail -->
					<!-- use blue in retake -->
					<!-- use yellow in incomplete -->
					<?php
						if(count($se_re)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
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
				<div id="se_re_div_2" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height:auto;">
					<?php
						//show failed courses there
						if(count($fail_re)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
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
									<td colspan="3" class="w3-padding-small" valign="top">Credit: <?php echo number_format($fail_credit,2); ?></td>
								</tr>
								<tr class="w3-teal w3-bold">
									<td valign="top" style="width:20%;" class="w3-padding-small">Course Code</td>
									<td valign="top" style="width:45%;" class="w3-padding-small">Course Title</td>
									<td valign="top" style="width:15%;" class="w3-padding-small">Credit</td>
									<td valign="top" style="width:20%;" class="w3-padding-small">Semester</td>
									<td valign="top" style="width:9%;" class="w3-padding-small">Remarks</td>
								
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
											<td valign="top" class="w3-padding-small  <?php if($cge['remarks']!=""){ echo 'w3-text-blue'; } ?>"><?php echo $cge['remarks']; ?></td>
										
										</tr>
								
								<?php
									}
								?>
							</table>
					<?php	
						}
						
					?>
					
				</div>
				<div id="se_re_div_3" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height:auto;">
					<?php
						//show passed courses there
						if(count($pass_re)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
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
											<td valign="top" class="w3-padding-small <?php if($cge['remarks']!=""){ echo 'w3-text-blue'; } ?>"><?php echo $cge['remarks']; ?></td>
										</tr>
								
								<?php
									}
								?>
							</table>
					<?php	
						}
						
					?>
				</div>
				<div id="se_re_div_4" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height:auto;">
					<?php
						//Drop courses there
						//getting dept last result semester
						$last_semester='';
						$last_year='';
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
						if($last_semester=='') $last_semester=$first_semester;
						if($last_year=='') $last_year=$first_year;
						//echo $first_semester.' '.$first_year.'</br>';
						
						if($first_year>$last_year)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
						
						}
						else if($first_year==$last_year && (($last_semester=="Spring" && ($first_semester=="Summer" || $first_semester=="Fall")) || ($last_semester=="Summer" && $first_semester=="Fall")))
						{
							echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
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
								echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
							}
							else
							{
								$drop_re=array();
								$drop_credit=0.0;
								$optional=array();
								$szz=count($stud_result);
								//echo $szz;
								for($p=0;$p<$szz;$p++)
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
								
							
								if(count($drop_re)==0)
								{
									echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
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
					
						}
					?>
				</div>
				<div id="se_re_div_5" class="w3-container w3-margin-0 w3-padding-0" style="display:none;height:auto;">
					<?php
						//show waived courses there
						if(count($ra_w)==0)
						{
							echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> No data available.</p>';
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
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="student_view_box2" style="display:none;">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="student_view_box3" style="display:none;">
			<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('student_view_box1').style.display='block';document.getElementById('student_view_box2').style.display='none';document.getElementById('student_view_box3').style.display='none';document.getElementById('student_view_box4').style.display='none';document.getElementById('student_view_box5').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-clear"></div>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<table style="width:100%;margin:5px 0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
					<tr class="w3-teal w3-bold">
						<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
						<td style="width:40%;" valign="top" class="w3-padding-small">Performed Action</td>
						<td style="width:20%;" valign="top" class="w3-padding-small">Performed By</td>
						<td style="width:15%;" valign="top" class="w3-padding-small">Date</td>
						<td style="width:15%;" valign="top" class="w3-padding-small">Time</td>
					</tr>
					<?php
						$stmt = $conn->prepare("select * from nr_student_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_stud_id=:student_id order by a.nr_studh_date desc,a.nr_studh_time desc ");
						$stmt->bindParam(':student_id', $s_id);
						$stmt->execute();
						$result = $stmt->fetchAll();
						if(count($result)==0)
						{
							echo '<tr>
								<td colspan="5"> <p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="No Data Available"> No Data Available.</i></p></td>
							</tr>';
						}
						else
						{
							$sz=count($result);
							for($i=0;$i<$sz;$i++)
							{
					
					?>
								<tr>
									<td valign="top" class="w3-padding-small w3-border"><?php echo $i+1; ?></td>
									<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][2]; ?></td>
									<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][7].' <b>('.$result[$i][12].')</b>, '.$result[$i][13]; ?></td>
									<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][3]); ?></td>
									<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][4]; ?></td>
								</tr>
					
					<?php
							}
						}
					?>
				</table>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="student_view_box4" style="display:none;">
			<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('student_view_box1').style.display='block';document.getElementById('student_view_box2').style.display='none';document.getElementById('student_view_box3').style.display='none';document.getElementById('student_view_box4').style.display='none';document.getElementById('student_view_box5').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-clear"></div>
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><b>Student ID</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" value="<?php echo $s_id; ?>" id="student_view_id" placeholder="Enter Student ID" autocomplete="off" oninput="student_view_form_change()" disabled>
						<input type="hidden" value="<?php echo $s_id; ?>" id="student_view_old_id">
							
						
						<label><i class="w3-text-red">*</i> <b>Student Name</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $name; ?>" id="student_view_name" placeholder="Enter Student Name" autocomplete="off" oninput="student_view_form_change()">
						<input type="hidden" value="<?php echo $name; ?>" id="student_view_old_name">
							
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Date of Birth</b> <i class="fa fa-exclamation-circle w3-cursor" title="Be careful inserting date of birth (MM/DD/YYYY) cause it will require for fetch result in student panel."></i></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" value="<?php echo $birthdate; ?>" id="student_view_birth_date" placeholder="Enter Student Birth Date" autocomplete="off" oninput="student_view_form_change()">
								<input type="hidden" value="<?php echo $birthdate; ?>" id="student_view_old_birth_date">
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><i class="w3-text-red">*</i> <b>Student Gender</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_view_gender" onchange="student_view_form_change()">
									<option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
									<?php if($gender!='Male'){ ?><option value="Male">Male</option><?php } ?>
									<?php if($gender!='Female'){ ?><option value="Female">Female</option><?php } ?>
									<?php if($gender!='Other'){ ?><option value="Other">Other</option><?php } ?>
								</select>
								<input type="hidden" value="<?php echo $gender; ?>" id="student_view_old_gender">
						
							</div>
						</div>	
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><b>Student Email</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting email the notification and two factor authentication service will be enabled for this student."></i></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" value="<?php echo $subscription_email; ?>" id="student_view_email" placeholder="Enter Student Email" autocomplete="off" oninput="student_view_form_change()">
								<input type="hidden" value="<?php echo $subscription_email; ?>" id="student_view_old_email">
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><b>Student Mobile</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $mobile; ?>" id="student_view_mobile" placeholder="Enter Student Mobile No" autocomplete="off" oninput="student_view_form_change()">
								<input type="hidden" value="<?php echo $mobile; ?>" id="student_view_old_mobile">
							</div>
						</div>
						<input type="hidden" value="<?php echo $prog_id; ?>" id="student_view_old_prog">
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Enrolled Program</b> <i class="fa fa-exclamation-circle w3-cursor" title="Be careful to change the program cause it will delete all the result and records of this student for current program."></i></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_view_prog" onchange="student_view_form_change()" <?php if($flll==1){ echo 'disabled'; } ?> >
									<option value="<?php echo $prog_id; ?>"><?php echo $degree; ?></option>
									<?php
										$stmt = $conn->prepare("SELECT * FROM nr_program where nr_prog_id!=:prog_id and nr_prog_status='Active' order by nr_prog_title asc");
										$stmt->bindParam(':prog_id', $prog_id);
										$stmt->execute();
										$stud_result=$stmt->fetchAll();
										if(count($stud_result)>0)
										{
											$sz=count($stud_result);
											for($k=0;$k<$sz;$k++)
											{
												$prog_id=$stud_result[$k][0];
												$prog_title=$stud_result[$k][1];
												echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
											}
										}
									?>
									
								</select>
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><i class="w3-text-red">*</i> <b>Status</b></label>
								<?php
									if($status=='Active') 
									{
								?>
										<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="student_view_status" onchange="student_view_form_change()">
											<option value="Active" class="w3-pale-green">Active</option>
											<option value="Inactive" class="w3-pale-red">Inactive</option>
										</select>
								<?php
									} else {
								?>
										<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="student_view_status" onchange="student_view_form_change()">
											<option value="Inactive" class="w3-pale-red">Inactive</option>
											<option value="Active" class="w3-pale-green">Active</option>
										</select>
								<?php
									}
								
									//spam Check 
									$aaa=rand(1,20);
									$bbb=rand(1,20);
									$ccc=$aaa+$bbb;
								?>
								<input type="hidden" value="<?php echo $status; ?>" id="student_view_old_status">
								<input type="hidden" value="<?php echo $ccc; ?>" id="student_view_old_captcha">
								<input type="hidden" value="<?php echo $s_id; ?>" id="student_view_id">
								
							</div>
						</div>
						<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:40%;">
								<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:58%;">
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="student_view_captcha" autocomplete="off" oninput="student_view_form_change()">
							</div>
						</div>
						
							
					</div>
					
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
						<div class="w3-col w3-margin-bottom w3-margin-left">			
							<?php if($photo=="" && $gender=="Male"){ ?>
								<img src="../images/system/male_profile.png" class="w3-image" style="border: 2px solid black;margin:22px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
							<?php } else if($photo==""){ ?>
								<img src="../images/system/female_profile.png" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
							<?php } else { ?>
								<img src="../images/student/<?php echo $photo; ?>" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;"  title="DP (120X100)px" alt="DP (120X100)px">
							<?php } ?> 
						</div>
						<div class="w3-col w3-margin-bottom w3-margin-left">										
							<label><b>Change DP</b></label>
							<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('student_dp_msg').style.display='block'" type="file" id="student_view_dp" title="Please upload DP (240X200)px"  onchange="student_view_form_change()">
							<i class="w3-text-red w3-small w3-bold" id="student_dp_msg" style="display: none;">*Upload DP with (240X200)px</i>
						</div>
						
						<button onclick="student_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Reset</button>
						
						<button onclick="document.getElementById('student_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($flll==1 || $flll1==1 || $flll2==1){ echo 'title="Sorry you can not remove this student." disabled'; }?>><i class="fa fa-eraser"></i> Remove</button>
					
						<button onclick="student_view_form_save_changes('<?php echo $s_id; ?>')" id="student_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
					
					
					</div>
					
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="student_view_box5" style="display:none;">
			<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('student_view_box1').style.display='block';document.getElementById('student_view_box2').style.display='none';document.getElementById('student_view_box3').style.display='none';document.getElementById('student_view_box4').style.display='none';document.getElementById('student_view_box5').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-clear"></div>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-top w3-margin-bottom w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-padding w3-border w3-round-large">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<p class="w3-xlarge w3-bold w3-text-teal w3-margin-0 w3-bottombar" style="width:277px;"><i class="fa fa-plus"></i> Add Waived Course</p>
						<label><i class="w3-text-red">*</i> <b>Course</b> </label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_waive_course" onchange="student_waive_form_change()" <?php if($flll==1){ echo 'disabled'; } ?> >
							<option value="">Select</option>
							<?php
								$stmt = $conn->prepare("SELECT nr_course_id,nr_course_code,nr_course_title FROM nr_course where nr_prog_id=:prog_id and nr_course_status='Active' and nr_course_id not in (select nr_course_id from nr_result where nr_stud_id=:student_id) and nr_course_id not in (select nr_course_id from nr_student_waived_credit where nr_stud_id=:student_id) order by nr_course_code asc, nr_course_title asc");
								$stmt->bindParam(':prog_id', $prog_id2);
								$stmt->bindParam(':student_id', $s_id);
								$stmt->execute();
								$stud_result=$stmt->fetchAll();
								if(count($stud_result)>0)
								{
									$sz=count($stud_result);
									for($k=0;$k<$sz;$k++)
									{
										$course_id=$stud_result[$k][0];
										$course_code=$stud_result[$k][1];
										$course_title=$stud_result[$k][2];
										echo '<option value="'.$course_id.'">'.$course_code.' : '.$course_title.'</option>';
									}
								}
								//spam Check 
								$aaa=rand(1,20);
								$bbb=rand(1,20);
								$ccc=$aaa+$bbb;
							?>
							
						</select>
						<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:40%;">
								<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:58%;">
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="student_waive_captcha" autocomplete="off" oninput="student_waive_form_change()" <?php if($flll==1){ echo 'disabled'; } ?> >
							</div>
						</div>
						
						<input type="hidden" value="<?php echo $ccc; ?>" id="student_waive_old_captcha">
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						<button onclick="student_waive_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button id="student_waive_save_btn" onclick="document.getElementById('student_waive_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" title="Sorry you can not add waive credit for this student." disabled><i class="fa fa-save"></i> Save</button>
					
					</div>
					
				</div>
				
				<table style="width:100%;margin:5px 0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
					<tr class="w3-black w3-bold">
						<td colspan="4" class="w3-padding-small">Waived Courses</td>
						<td colspan="2" class="w3-padding-small">Credit: <?php echo $waived_credit; ?></td>
					</tr>
					<tr class="w3-teal w3-bold">
						<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
						<td style="width:35%;" valign="top" class="w3-padding-small">Course Title</td>
						<td style="width:14%;" valign="top" class="w3-padding-small">Course Code</td>
						<td style="width:10%;" valign="top" class="w3-padding-small">Course Credit</td>
						<td style="width:16%;" valign="top" class="w3-padding-small">Added Date</td>
						<td style="width:15%;" valign="top" class="w3-padding-small">Action</td>
					</tr>
					<?php
						$stmt = $conn->prepare("select a.nr_stwacr_id,b.nr_course_title,b.nr_course_code,b.nr_course_credit,a.nr_stwacr_date from nr_student_waived_credit a,nr_course b where a.nr_course_id=b.nr_course_id and a.nr_stud_id=:s_id and a.nr_stwacr_status='Active' "); 
						$stmt->bindParam(':s_id', $s_id);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						$sz=count($stud_result);
						if($sz==0)
						{
							echo '<tr>
								<td colspan="6"> <p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="No Data Available"> No Data Available.</i></p></td>
							</tr>';
						}
						for($i=0;$i<$sz;$i++)
						{
					?>
						<tr class="">
							<td valign="top" class="w3-padding-small w3-border"><?php echo $i+1; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $stud_result[$i][1]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $stud_result[$i][2]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo number_format($stud_result[$i][3],2); ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($stud_result[$i][4]); ?></td>
							<td valign="top" class="w3-padding-small w3-border"><a onclick="delete_student_waived_credit(<?php echo $stud_result[$i][0]; ?>)" class="w3-text-blue w3-cursor" <?php if($flll==1){ echo 'title="unable to delete it" disabled'; } ?>><i class="fa fa-eraser"></i> Remove</a></td>
						</tr>
					
					<?php
						}
					?>
				</table>
			</div>
		</div>
<?php	
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>