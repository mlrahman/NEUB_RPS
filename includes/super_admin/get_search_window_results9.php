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
	if(isset($_REQUEST['r_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$r_id=$_REQUEST['r_id'];
		$stmt = $conn->prepare("select * from nr_result a,nr_course b, nr_faculty c, nr_student d, nr_department e where a.nr_course_id=b.nr_course_id and a.nr_faculty_id=c.nr_faculty_id and a.nr_stud_id=d.nr_stud_id and a.nr_result_id=:r_id and c.nr_dept_id=e.nr_dept_id limit 1 ");
		$stmt->bindParam(':r_id', $r_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if(count($result)==0)
		{
			echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Data not found"><i class="fa fa-warning"></i> Data not found.</p>';
			die();
		}
		$photo=$result[0][39];
		$gender=$result[0][36];
		$name=$result[0][34];
		$reg_no=$result[0][33];
		$session=get_session($reg_no);
		$birthdate=$result[0][35];
		$course_code=$result[0][14];
		$course_title=$result[0][15];
		$course_credit=$result[0][16];
		$course_semester=$result[0][6].' '.$result[0][7];
		$course_marks=marks_decrypt($reg_no,$result[0][3]);
		$course_grade=grade_decrypt($reg_no,$result[0][4]);
		$course_grade_point=grade_point_decrypt($reg_no,$result[0][5]);
		$course_remarks=$result[0][8];
		$course_instructor=$result[0][20];
		$course_instructor_designation=$result[0][21];
		$course_instructor_type=$result[0][24];
		$course_instructor_department=$result[0][44];
		$course_publish=get_date($result[0][11]);
		
?>
		<div class="w3-container w3-row" style="height:100%;padding: 0px 12px 10px 12px;" id="result_view_box1" >
			<p class="w3-margin-0 w3-left w3-text-indigo w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('result_view_box1').style.display='none';document.getElementById('result_view_box2').style.display='none';document.getElementById('result_view_box3').style.display='none';document.getElementById('result_view_box4').style.display='block';"><i class="fa fa-edit"></i> Edit Result</p>
			<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('result_view_box1').style.display='none';document.getElementById('result_view_box2').style.display='none';document.getElementById('result_view_box3').style.display='block';document.getElementById('result_view_box4').style.display='none';"><i class="fa fa-history"></i> Result History</p>
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
								<td valign="top">Course Code</td>
								<td colspan="2" valign="top" class="w3-bold w3-text-purple">: <?php echo $course_code; ?></td>
							</tr>
							<tr>
								<td valign="top">Course Title</td>
								<td colspan="2" valign="top" class="w3-bold w3-text-purple">: <?php echo $course_title; ?></td>
							</tr>
							<tr>
								<td valign="top">Course Credit</td>
								<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo number_format($course_credit,2); ?></td>
							</tr>
							<tr>
								<td valign="top">Semester</td>
								<td colspan="2" valign="top" class="w3-bold w3-text-brown">: <?php echo $course_semester; ?></td>
							</tr>
							
						</table>
					</div>
				</div>
				<table style="width:100%;" class="w3-margin-bottom">
					<tr>
						<td valign="top" style="width:140px;">Marks</td>
						<td colspan="2" valign="top" class="<?php if($course_grade=='F'){ echo 'w3-text-red'; } ?>">: <b><?php echo $course_marks; ?></b></td>
					</tr>
					<tr>
						<td valign="top">Grade</td>
						<td colspan="2" valign="top" class="<?php if($course_grade=='F'){ echo 'w3-text-red'; } ?>">: <?php echo $course_grade; ?></td>
					</tr>
					<tr>
						<td valign="top">Grade Point</td>
						<td colspan="2" valign="top" class="<?php if($course_grade=='F'){ echo 'w3-text-red'; } ?>">: <?php echo number_format($course_grade_point,2); ?></td>
					</tr>
					<tr>
						<td valign="top">Course Instructor</td>
						<td colspan="2" valign="top">: <b><?php echo $course_instructor; ?></b>
						</br>
						&nbsp;&nbsp;<?php echo $course_instructor_designation.' <span class="w3-text-indigo">('.$course_instructor_type.' Faculty)</span>'; ?></br>
						&nbsp;&nbsp;Department of <?php echo $course_instructor_department; ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Published In</td>
						<td colspan="2" valign="top">: <b><?php echo $course_publish; ?></b></td>
					</tr>
					<tr>
						<td valign="top">Remarks</td>
						<td valign="top" class="w3-text-blue">: <?php if($course_remarks=="") { echo 'N/A'; } else { echo $course_remarks; } ?></td>
					</tr>
				
				</table>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="result_view_box2" style="display:none;">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="result_view_box3" style="display:none;">
			<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('result_view_box1').style.display='block';document.getElementById('result_view_box2').style.display='none';document.getElementById('result_view_box3').style.display='none';document.getElementById('result_view_box4').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
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
						$stmt = $conn->prepare("select * from nr_result_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_result_id=:result_id order by a.nr_resulth_date desc,a.nr_resulth_time desc ");
						$stmt->bindParam(':result_id', $r_id);
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
		<div class="w3-container w3-margin-0 w3-padding-0" id="result_view_box4" style="display:none;">
			<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('result_view_box1').style.display='block';document.getElementById('result_view_box2').style.display='none';document.getElementById('result_view_box3').style.display='none';document.getElementById('result_view_box4').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-clear"></div>
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
				
				
				</div>
			</div>
		</div>
<?php	
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>