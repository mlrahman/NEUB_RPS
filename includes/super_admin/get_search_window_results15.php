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
	if($_SESSION['admin_type']!='Super Admin'){
		header("location: index.php");
		die();
	}
	if(isset($_REQUEST['admin_member_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$admin_member_id=trim($_REQUEST['admin_member_id']);
		
		$fl=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_course_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl=1;
		}
		
		$fl1=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_delete_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl1=1;
		}
		
		$fl2=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_department_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl2=1;
		}
		
		$fl3=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_drop_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl3=1;
		}
		
		$fl4=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_faculty_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl4=1;
		}
		
		$fl5=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_program_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl5=1;
		}
		
		$fl6=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_result_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl6=1;
		}
		
		$fl7=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_student_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl7=1;
		}
		
		$fl8=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_system_component where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl8=1;
		}
		
		$fl9=0; 
		//checking if admin is delete able or not
		$stmt = $conn->prepare("select * from nr_admin_history where nr_admin_id=:admin_member_id");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl9=1;
		}
		
		$stmt = $conn->prepare("select a.nr_admin_id,a.nr_admin_name, a.nr_admin_designation,a.nr_admin_join_date,a.nr_admin_resign_date,a.nr_admin_type,a.nr_admin_email,a.nr_admin_status,a.nr_admin_gender,a.nr_admin_photo,a.nr_admin_cell_no from nr_admin a where nr_admin_id=:admin_member_id ");
		$stmt->bindParam(':admin_member_id', $admin_member_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$admin_name=$result[0][1];
		$admin_designation=$result[0][2];
		$admin_join_date=$result[0][3];
		$admin_resign_date=$result[0][4];
		$admin_type=$result[0][5];
		$admin_email=$result[0][6];
		$status=$result[0][7];
		$admin_gender=$result[0][8];
		$photo=$result[0][9];
		$admin_mobile=$result[0][10];
		
?>
	<div class="w3-container w3-margin-0 w3-padding-0" id="admin_view_box1">
		<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('admin_view_box1').style.display='none';document.getElementById('admin_view_box2').style.display='none';document.getElementById('admin_view_box3').style.display='block';"><i class="fa fa-history"></i> Admin History</p>
		<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
		<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
					<label><i class="w3-text-red">*</i> <b>Admin Name</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_name; ?>" id="admin_view_name" placeholder="Enter Admin Name" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
					<input type="hidden" value="<?php echo $admin_name; ?>" id="admin_view_old_name">
					
					<label><i class="w3-text-red">*</i> <b>Admin Designation</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_designation; ?>" id="admin_view_designation" placeholder="Enter Admin Designation" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
					<input type="hidden" value="<?php echo $admin_designation; ?>" id="admin_view_old_designation">
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:49%;">
							<label><b>Admin Email</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting email you are giving the admin panel access. This admin can access all the features of admin panel through this email. He will get an one time link to set his password for the admin panel. He will get the access till inactive status or resign of his ID."></i> </label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" value="<?php echo $admin_email; ?>" id="admin_view_email" placeholder="Enter Admin Email" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
							<input type="hidden" value="<?php echo $admin_email; ?>" id="admin_view_old_email">
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
							<label><b>Admin Mobile</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_mobile; ?>" id="admin_view_mobile" placeholder="Enter Admin Mobile" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
							<input type="hidden" value="<?php echo $admin_mobile; ?>" id="admin_view_old_mobile">
						</div>
						
					</div>
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:49%;">
							<label><i class="w3-text-red">*</i> <b>Join Date</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" value="<?php echo $admin_join_date; ?>" id="admin_view_join_date" placeholder="Enter Admin Join Date" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
							<input type="hidden" value="<?php echo $admin_join_date; ?>" id="admin_view_old_join_date">
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
							<label><b>Resign Date</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting resign date you are confirming that this admin resigned from NEUB and he will lose his access from admin panel."></i> </label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" value="<?php echo $admin_resign_date; ?>" id="admin_view_resign_date" placeholder="Enter Admin Resign Date" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
							<input type="hidden" value="<?php echo $admin_resign_date; ?>" id="admin_view_old_resign_date">
						</div>
					</div>
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:49%;">
							<label><i class="w3-text-red">*</i> <b>Admin Type</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_view_type" onchange="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
								<option value="<?php echo $admin_type; ?>"><?php echo $admin_type; ?></option>
								<?php if($admin_type!='Admin'){ ?><option value="Admin">Admin</option><?php } ?>
								<?php if($admin_type!='Moderator'){ ?><option value="Moderator">Moderator</option><?php } ?>
							</select>
							<input type="hidden" value="<?php echo $admin_type; ?>" id="admin_view_old_type">
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
							<label><i class="w3-text-red">*</i> <b>Gender</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_view_gender" onchange="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
								<option value="<?php echo $admin_gender; ?>"><?php echo $admin_gender; ?></option>
								<?php if($admin_gender!='Male'){ ?><option value="Male">Male</option><?php } ?>
								<?php if($admin_gender!='Female'){ ?><option value="Female">Female</option><?php } ?>
								<?php if($admin_gender!='Other'){ ?><option value="Other">Other</option><?php } ?>
							</select>
							<input type="hidden" value="<?php echo $admin_gender; ?>" id="admin_view_old_gender">
						</div>
						
					</div>
					
					<label><i class="w3-text-red">*</i> <b>Status</b></label>
					<?php
						if($status=='Active') 
						{
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="admin_view_status" onchange="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
								<option value="Active" class="w3-pale-green">Active</option>
								<option value="Inactive" class="w3-pale-red">Inactive</option>
							</select>
					<?php
						} else {
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="admin_view_status" onchange="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
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
					<input type="hidden" value="<?php echo $status; ?>" id="admin_view_old_status">
					<input type="hidden" value="<?php echo $ccc; ?>" id="admin_view_old_captcha">
					<input type="hidden" value="<?php echo $admin_member_id; ?>" id="admin_view_id">
					
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="admin_view_captcha" autocomplete="off" oninput="admin_view_form_change()" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>>
						</div>
					</div>
					
					
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<div class="w3-col w3-margin-bottom w3-margin-left">			
						<?php if($photo=="" && $admin_gender=="Male"){ ?>
							<img src="../images/system/male_profile.png" class="w3-image" style="border: 2px solid black;margin:22px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
						<?php } else if($photo==""){ ?>
							<img src="../images/system/female_profile.png" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
						<?php } else { ?>
							<img src="../images/<?php if($admin_type=="Moderator"){ echo 'moderator'; } else { echo 'admin'; } ?>/<?php echo $photo; ?>" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;"  title="DP (120X100)px" alt="DP (120X100)px">
						<?php } ?> 
						<i class="fa fa-exclamation-circle w3-cursor" title="DP is updatable from admin panel."></i>
					</div>
					
					<button onclick="admin_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?>><i class="fa fa-eye-slash"></i> Reset</button>
					
					<button onclick="document.getElementById('admin_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($admin_type=='Super Admin'){ echo 'disabled'; } ?> <?php if($fl==1 || $fl1==1 || $fl2==1 || $fl3==1 || $fl4==1 || $fl5==1 || $fl6==1 || $fl7==1 || $fl8==1 || $fl9==1){ echo 'title="Sorry you can not delete it." disabled'; } ?>><i class="fa fa-eraser"></i> Remove</button>
				
					<button onclick="admin_view_form_save_changes('<?php echo $admin_member_id; ?>')" id="admin_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="admin_view_box2" style="display:none;">
		<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
		<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
	
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="admin_view_box3" style="display:none;">
		<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('admin_view_box1').style.display='block';document.getElementById('admin_view_box2').style.display='none';document.getElementById('admin_view_box3').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
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
					$stmt = $conn->prepare("select * from nr_admin_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_admin_id=:admin_member_id order by a.nr_adminh_date desc,a.nr_adminh_time desc ");
					$stmt->bindParam(':admin_member_id', $admin_member_id);
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