<?php
	try{
		require("../includes/faculty/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>
<?php
	//faculty info
	$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_status='Active' and nr_faculty_id=:f_id");
	$stmt->bindParam(':f_id', $_SESSION['faculty_id']);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if(count($result)==0)
	{
		die();
	}
	$faculty_id=$result[0][0];
	$faculty_name=$result[0][1];
	$faculty_designation=$result[0][2];
	$faculty_email=$result[0][8];
	$faculty_cell_no=$result[0][9];
	$faculty_joining_date=get_date($result[0][3]);
	$faculty_type=$result[0][5];
	$faculty_gender=$result[0][13];
	$photo=$result[0][10];
	$otp=$result[0][12];
?>

<p class="w3-text-red w3-small" style="margin: 12px 0px 0px 12px;padding:0px;">Note: Only (*) marked fields are changeable.</p>
<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 0px 0px;">
			<label><b>Name</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_name; ?>" disabled>
		  
			<label><b>Designation</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_designation; ?>" disabled>
		</div>
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 0px;">			
					<?php if($photo=="" && $gender=="Male"){ ?>
						<img src="../images/system/male_profile.png" id="faculty_profile_image" class="w3-image" style="border: 2px solid black;margin:22px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;">
					<?php } else if($photo==""){ ?>
						<img src="../images/system/female_profile.png" id="faculty_profile_image" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;">
					<?php } else { ?>
						<img src="../images/faculty/<?php echo $photo; ?>" id="faculty_profile_image" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;">
					<?php } ?>
				</div>
				
				<div class="w3-col w3-margin-0" style="width:70%;padding:5px 0px 0px 0px;">			
					
					<button onclick="clear_edit_profile()" class="w3-button w3-red w3-right w3-hover-teal w3-round-large w3-margin-left"><i class="	fa fa-eye-slash"></i> Clear</button>
					
					<button id="edit_btn" onclick="edit_profile()" class="w3-button w3-black w3-right w3-hover-teal w3-round-large" disabled><i class="fa fa-save"></i> Save Changes</button>
					
					<div class="w3-clear" style="margin-bottom: 30px;"></div>
					<label><i class="w3-text-red">*</i> <b>Upload DP</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="file" id="faculty_image" onchange="form_change()">
					
				</div>
			</div>
		</div>
	</div>
	
	
	<label><b>Department</b></label>
	<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $department; ?>" disabled>
		
	
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
			<label><b>Email</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_email; ?>" disabled>
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
			<label><i class="w3-text-red">*</i> <b>Cell No</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_cell_no; ?>" placeholder="Enter your cellphone no" id="new_cell_phone" onkeyup="form_change()">
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
			<label><i class="w3-text-red">*</i> <b>2-Step Verification</b></label>
			<?php
				if($otp==1) //enabled
				{
			?>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="new_otp" onchange="form_change()">
						<option value="1">Enabled</option>
						<option value="0">Disabled</option>
					</select>
			<?php
				} else {
			?>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="new_otp" onchange="form_change()">
						<option value="0">Disabled</option>
						<option value="1">Enabled</option>
					</select>
			<?php
				}
			?>
		</div>
	</div>
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
			<label><b>Joining Date</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_joining_date; ?>" disabled>
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
			<label><b>Faculty Type</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_type; ?>" disabled>
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 0px 0px 6px;">
			<label><b>Gender</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_gender; ?>" disabled>
		</div>
	</div>
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
			<label><i class="w3-text-red">*</i> <b>New Password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" onkeyup="form_change()" id="pass" placeholder="Enter only for change password">
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
			<label><i class="w3-text-red">*</i> <b>Confirm New Password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" onkeyup="form_change()" id="c_pass" placeholder="Confirm the new password">
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 0px 0px 6px;">
			<?php 
				//spam Check 
				$aaa=rand(1,20);
				$bbb=rand(1,20);
				$ccc=$aaa+$bbb;
			?>
			<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
			<div class="w3-row" style="margin:0px;padding:0px;">
				<div class="w3-col" style="width:40%;">
					<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
				</div>
				<div class="w3-col" style="margin-left:2%;width:58%;">
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha5" autocomplete="off" required>
				</div>
			</div>
			<script>
				//Captcha Validation for create new password
				var reservation_captcha5 = document.getElementById("captcha5");
				var sol4=<?php echo $ccc; ?>;
				function reservation_captcha_val4(){
				  
				  //console.log(reservation_captcha.value);
				  //console.log(sol);
				  if(reservation_captcha5.value != sol4) {
					reservation_captcha5.setCustomValidity("Please Enter Valid Answer.");
					return false;
				  } else {
					reservation_captcha5.setCustomValidity('');
					return true;
				  }
				}
				reservation_captcha5.onchange=reservation_captcha_val4;
				//checking password similarity
				var c_pass=document.getElementById("c_pass");
				var pass=document.getElementById("pass");
				function password_check()
				{
					if(pass.value!="" || c_pass.value!="")
					{
						if(c_pass.value != pass.value) {
							c_pass.setCustomValidity("Password doesn't match.");
							return false;
						}
						else if((pass.value).length < 6)
						{
							c_pass.setCustomValidity("Password must be 6 digits or more.");
							return false;
						}
						else
						{
							c_pass.setCustomValidity('');
							pass.setCustomValidity('');
							return true;
						}
					}
					else
					{
						c_pass.setCustomValidity('');
						pass.setCustomValidity('');
						return true;
					}
				}
				c_pass.onchange=password_check;
				
				//old values
				var faculty_cell_no=<?php echo '"'.$faculty_cell_no.'"'; ?>;
				var otp=<?php echo $otp; ?>;
					
				function form_change()
				{
					
					//new values
					var new_faculty_cell_no=document.getElementById('new_cell_phone').value.trim();
					var new_otp=document.getElementById('new_otp').value.trim();
					
					var faculty_image=document.getElementById('faculty_image').value.trim();
					var new_c_pass=document.getElementById("c_pass").value;
					var new_pass=document.getElementById("pass").value;
					
					if(faculty_cell_no!=new_faculty_cell_no || otp!=new_otp || faculty_image!="" || new_c_pass!="" || new_pass!="")
					{
						document.getElementById("edit_btn").disabled = false;
					}
					else
					{
						document.getElementById("edit_btn").disabled = true;
					}
				}
				function edit_profile()
				{
					
					
				}
				function clear_edit_profile()
				{
					
					//new values
					document.getElementById('new_cell_phone').value=faculty_cell_no;
					document.getElementById('new_otp').value=otp;
					
					document.getElementById('faculty_image').value='';
					document.getElementById("c_pass").value='';
					document.getElementById("pass").value='';
					form_change();
				}
			</script>
		</div>
	</div>
</div>