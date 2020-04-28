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
	if(isset($_REQUEST['faculty_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		
		$fl=0; 
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_result where nr_faculty_id=:faculty_id");
		$stmt->bindParam(':faculty_id', $faculty_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl=1;
		}
		
		$stmt = $conn->prepare("select a.nr_faculty_id,a.nr_faculty_name, a.nr_faculty_designation,a.nr_faculty_join_date,a.nr_faculty_resign_date,a.nr_faculty_type,b.nr_dept_id,b.nr_Dept_title,a.nr_faculty_email,a.nr_faculty_status,a.nr_faculty_gender,a.nr_faculty_photo,a.nr_faculty_cell_no from nr_faculty a,nr_department b where a.nr_dept_id=b.nr_dept_id and nr_faculty_id=:faculty_id ");
		$stmt->bindParam(':faculty_id', $faculty_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$faculty_name=$result[0][1];
		$faculty_designation=$result[0][2];
		$faculty_join_date=$result[0][3];
		$faculty_resign_date=$result[0][4];
		$faculty_type=$result[0][5];
		$dept_id=$result[0][6];
		$dept_title=$result[0][7];
		$faculty_email=$result[0][8];
		$status=$result[0][9];
		$faculty_gender=$result[0][10];
		$photo=$result[0][11];
		$faculty_mobile=$result[0][12];
		
?>
	<div class="w3-container w3-margin-0 w3-padding-0" id="faculty_view_box1">
		<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('faculty_view_box1').style.display='none';document.getElementById('faculty_view_box2').style.display='none';document.getElementById('faculty_view_box3').style.display='block';"><i class="fa fa-history"></i> Faculty History</p>
		<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
		<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
					<label><i class="w3-text-red">*</i> <b>Faculty Name</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_name; ?>" id="faculty_view_name" placeholder="Enter Faculty Name" autocomplete="off" oninput="faculty_view_form_change()">
					<input type="hidden" value="<?php echo $faculty_name; ?>" id="faculty_view_old_name">
					
					<label><i class="w3-text-red">*</i> <b>Faculty Designation</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_designation; ?>" id="faculty_view_designation" placeholder="Enter Faculty Designation" autocomplete="off" oninput="faculty_view_form_change()">
					<input type="hidden" value="<?php echo $faculty_designation; ?>" id="faculty_view_old_designation">
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:49%;">
							<label><b>Faculty Email</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting email you are giving the faculty panel access. This faculty can access all the features of faculty panel through this email. He will get an one time link to set his password for the faculty panel. He will get the access till inactive status or resign of his ID."></i> </label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" value="<?php echo $faculty_email; ?>" id="faculty_view_email" placeholder="Enter Faculty Email" autocomplete="off" oninput="faculty_view_form_change()">
							<input type="hidden" value="<?php echo $faculty_email; ?>" id="faculty_view_old_email">
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
							<label><b>Faculty Mobile</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_mobile; ?>" id="faculty_view_mobile" placeholder="Enter Faculty Mobile" autocomplete="off" oninput="faculty_view_form_change()">
							<input type="hidden" value="<?php echo $faculty_mobile; ?>" id="faculty_view_old_mobile">
						</div>
						
					</div>
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:49%;">
							<label><i class="w3-text-red">*</i> <b>Join Date</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" value="<?php echo $faculty_join_date; ?>" id="faculty_view_join_date" placeholder="Enter Faculty Join Date" autocomplete="off" oninput="faculty_view_form_change()">
							<input type="hidden" value="<?php echo $faculty_join_date; ?>" id="faculty_view_old_join_date">
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
							<label><b>Resign Date</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting resign date you are confirming that faculty resigned from NEUB and he will lose his access from faculty panel."></i> </label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" value="<?php echo $faculty_resign_date; ?>" id="faculty_view_resign_date" placeholder="Enter Faculty Resign Date" autocomplete="off" oninput="faculty_view_form_change()">
							<input type="hidden" value="<?php echo $faculty_resign_date; ?>" id="faculty_view_old_resign_date">
						</div>
					</div>
					
					<input type="hidden" value="<?php echo $dept_id; ?>" id="faculty_view_old_dept">
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:32%;">
							<label><i class="w3-text-red">*</i> <b>Department</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="faculty_view_dept" onchange="faculty_view_form_change()">
								<option value="<?php echo $dept_id; ?>"><?php echo $dept_title; ?></option>
								<?php
									$stmt = $conn->prepare("SELECT * FROM nr_department where nr_dept_id!=:dept_id and nr_dept_status='Active' order by nr_dept_title asc");
									$stmt->bindParam(':dept_id', $dept_id);
									$stmt->execute();
									$stud_result=$stmt->fetchAll();
									if(count($stud_result)>0)
									{
										$sz=count($stud_result);
										for($k=0;$k<$sz;$k++)
										{
											$dept_id=$stud_result[$k][0];
											$dept_title=$stud_result[$k][1];
											echo '<option value="'.$dept_id.'">'.$dept_title.'</option>';
										}
									}
								?>
								
							</select>
						</div>
						<div class="w3-col" style="margin-left:2%;width:32%;">
							<label><i class="w3-text-red">*</i> <b>Faculty Type</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="faculty_view_type" onchange="faculty_view_form_change()">
								<option value="<?php echo $faculty_type; ?>"><?php echo $faculty_type; ?></option>
								<?php if($faculty_type!='Permanent'){ ?><option value="Permanent">Permanent</option><?php } ?>
								<?php if($faculty_type!='Adjunct'){ ?><option value="Adjunct">Adjunct</option><?php } ?>
								<?php if($faculty_type!='Guest'){ ?><option value="Guest">Guest</option><?php } ?>
							</select>
							<input type="hidden" value="<?php echo $faculty_type; ?>" id="faculty_view_old_type">
						</div>
						<div class="w3-col" style="margin-left:2%;width:32%;">
							<label><i class="w3-text-red">*</i> <b>Gender</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="faculty_view_gender" onchange="faculty_view_form_change()">
								<option value="<?php echo $faculty_gender; ?>"><?php echo $faculty_gender; ?></option>
								<?php if($faculty_gender!='Male'){ ?><option value="Male">Male</option><?php } ?>
								<?php if($faculty_gender!='Female'){ ?><option value="Female">Female</option><?php } ?>
								<?php if($faculty_gender!='Other'){ ?><option value="Other">Other</option><?php } ?>
							</select>
							<input type="hidden" value="<?php echo $faculty_gender; ?>" id="faculty_view_old_gender">
						</div>
						
					</div>
					
					<label><i class="w3-text-red">*</i> <b>Status</b></label>
					<?php
						if($status=='Active') 
						{
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="faculty_view_status" onchange="faculty_view_form_change()">
								<option value="Active" class="w3-pale-green">Active</option>
								<option value="Inactive" class="w3-pale-red">Inactive</option>
							</select>
					<?php
						} else {
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="faculty_view_status" onchange="faculty_view_form_change()">
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
					<input type="hidden" value="<?php echo $status; ?>" id="faculty_view_old_status">
					<input type="hidden" value="<?php echo $ccc; ?>" id="faculty_view_old_captcha">
					<input type="hidden" value="<?php echo $faculty_id; ?>" id="faculty_view_id">
					
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="faculty_view_captcha" autocomplete="off" oninput="faculty_view_form_change()">
						</div>
					</div>
					
					
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<div class="w3-col w3-margin-bottom w3-margin-left">			
						<?php if($photo=="" && $faculty_gender=="Male"){ ?>
							<img src="../images/system/male_profile.png" class="w3-image" style="border: 2px solid black;margin:22px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
						<?php } else if($photo==""){ ?>
							<img src="../images/system/female_profile.png" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
						<?php } else { ?>
							<img src="../images/faculty/<?php echo $photo; ?>" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;"  title="DP (120X100)px" alt="DP (120X100)px">
						<?php } ?> 
						<i class="fa fa-exclamation-circle w3-cursor" title="DP is updatable from faculty panel."></i>
					</div>
					
					<button onclick="faculty_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Reset</button>
					
					<button onclick="document.getElementById('faculty_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($fl==1){ echo 'title="Sorry you can not delete it." disabled'; } ?>><i class="fa fa-eraser"></i> Remove</button>
				
					<button onclick="faculty_view_form_save_changes('<?php echo $faculty_id; ?>')" id="faculty_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="faculty_view_box2" style="display:none;">
		<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
		<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
	
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="faculty_view_box3" style="display:none;">
		<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('faculty_view_box1').style.display='block';document.getElementById('faculty_view_box2').style.display='none';document.getElementById('faculty_view_box3').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
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
					$stmt = $conn->prepare("select * from nr_faculty_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_faculty_id=:faculty_id order by a.nr_facultyh_date desc,a.nr_facultyh_time desc ");
					$stmt->bindParam(':faculty_id', $faculty_id);
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
<?php		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>