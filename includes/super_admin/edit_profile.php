<?php
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	try{
		//super_admin info
		$stmt = $conn->prepare("select * from nr_admin where nr_admin_status='Active' and nr_admin_id=:f_id");
		$stmt->bindParam(':f_id', $_SESSION['admin_id']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			die();
		}
		$admin_id=$result[0][0];
		$admin_name=$result[0][1];
		$admin_designation=$result[0][7];
		$admin_email=$result[0][2];
		$admin_cell_no=$result[0][4];
		$admin_joining_date=get_date($result[0][12]);
		$admin_joining_date2=$result[0][12];
		$admin_type=$result[0][6];
		$admin_gender=$result[0][11];
		$photo=$result[0][5];
		$otp=$result[0][10];
		
?>

<!-- email otp -->
<div id="profile_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Verification</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">We have sent you an OTP in new email please insert it for verification.</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter OTP</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="profile_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="profile_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('profile_add_re_confirmation').style.display='none';document.getElementById('profile_add_pass').value='';clear_edit_profile();">No</button>
		</div>
		</form>
	</div>
</div>


<div id="edit_loading" title="Please wait while uploading your profile.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;height:100%;width:100%;top:0;left:0;background:black;opacity:0.6;position:fixed;z-index:99999999;padding-top:170px;border-radius:0px 0px 10px 10px;">
	<p style="font-size:15px;font-weight:bold;">Please wait while uploading your profile..</p>
	<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
		<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="image_progress_id" style="width:0%;">0%</div>
	</div>
	<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
</div>
	
<form onsubmit="return false">
<p class="w3-text-red w3-small w3-bold" style="margin: 12px 0px 0px 12px;padding:0px;">Note: Only (*) marked fields are changeable.</p>
<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 0px 0px;">
			<label><?php if($_SESSION['admin_type']!='Admin') { ?><i class="w3-text-red">*</i> <?php } ?><b>Name</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_name; ?>" id="admin_name" placeholder="Enter Your Name" <?php if($_SESSION['admin_type']=='Admin') { echo 'disabled'; }?>>
			
			<label><?php if($_SESSION['admin_type']!='Admin') { ?><i class="w3-text-red">*</i> <?php } ?><b>Designation</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_designation; ?>" id="admin_designation" placeholder="Enter Your Designation" <?php if($_SESSION['admin_type']=='Admin') { echo 'disabled'; }?>>
			
		</div>
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 0px;">			
					<?php if($photo=="" && $admin_gender=="Male"){ ?>
						<img src="../images/system/male_profile.png" id="admin_profile_image2" class="w3-image" style="border: 2px solid black;margin:22px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
					<?php } else if($photo==""){ ?>
						<img src="../images/system/female_profile.png" id="admin_profile_image2" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
					<?php } else { ?>
						<img src="../images/admin/<?php echo $photo; ?>" id="admin_profile_image2" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;"  title="DP (120X100)px" alt="DP (120X100)px">
					<?php } ?>
				</div>
				
				<div class="w3-col w3-margin-0" style="width:70%;padding:5px 0px 0px 0px;">			
					
					<button onclick="clear_edit_profile()" class="w3-button w3-red w3-right w3-hover-teal w3-round-large w3-margin-left"><i class="	fa fa-eye-slash"></i> Clear</button>
					
					<button id="edit_btn" onclick="edit_profile()" class="w3-button w3-black w3-right w3-hover-teal w3-round-large" disabled><i class="fa fa-save"></i> Save Changes</button>
					
					
					<div class="w3-clear" style="margin-bottom: 30px;"></div>
					<label><i class="w3-text-red">*</i> <b>Upload DP</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" onclick="document.getElementById('dp_msg').style.display='block'" type="file" id="admin_image" title="Please upload DP (120X100)px"  onchange="form_change()">
					<i class="w3-text-red w3-small w3-bold" id="dp_msg" style="display: none;">*Upload DP with (120X100)px</i>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 0px 0px;">
			<label><?php if($_SESSION['admin_type']!='Admin') { ?><i class="w3-text-red">*</i> <?php } ?><b>Email</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_email; ?>" id="admin_email" placeholder="Enter Your Email" <?php if($_SESSION['admin_type']=='Admin') { echo 'disabled'; }?>>
			
		</div>
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
			<label><?php if($_SESSION['admin_type']!='Admin') { ?><i class="w3-text-red">*</i> <?php } ?><b>Joining Date</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" <?php if($_SESSION['admin_type']=='Admin') { ?> type="text" value="<?php echo get_date($result[0][12]); ?>"  <?php } else { ?> type="date" value="<?php echo $result[0][12]; ?>" <?php } ?> id="admin_joining_date" placeholder="Enter Your Joining Date" <?php if($_SESSION['admin_type']=='Admin') { echo 'disabled'; }?>>
			
		</div>
		
	</div>
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 0px 0px;">
			<label><i class="w3-text-red">*</i> <b>Cell No</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $admin_cell_no; ?>" placeholder="Enter your 11 digits cell no" id="new_cell_phone" onkeyup="form_change()" autocomplete="off" >
		</div>
		
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
			<label><?php if($_SESSION['admin_type']!='Admin') { ?><i class="w3-text-red">*</i> <?php } ?><b>Gender</b></label>
			<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_gender" <?php if($_SESSION['admin_type']=='Admin') { echo 'disabled'; }?>>
				<option value="<?php echo $admin_gender; ?>"><?php echo $admin_gender; ?></option>
				<?php if($admin_gender!='Male'){ ?><option value="Male">Male</option><?php } ?>
				<?php if($admin_gender!='Female'){ ?><option value="Female">Female</option><?php } ?>
				<?php if($admin_gender!='Other'){ ?><option value="Other">Other</option><?php } ?>
			</select>
			
		</div>
	</div>
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 0px 0px;">
			<label><i class="w3-text-red">*</i> <b>New Password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" onkeyup="form_change()"  autocomplete="off" id="pass" placeholder="Enter only for change password">
		</div>
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
			<label><i class="w3-text-red">*</i> <b>Confirm New Password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" onkeyup="form_change()"  autocomplete="off" id="c_pass" placeholder="Confirm the new password">
		</div>
	</div>
	<div class="w3-row w3-margin-0 w3-padding-0">
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 0px 0px;">
			<label><b>2-Step Verification</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php if($otp==1) { echo 'Enabled'; } else { echo 'Disabled'; } ?>" disabled>
		</div>
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
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
				var verification_otp='';
				//Captcha Validation for create new password
				var reservation_captcha5 = document.getElementById("captcha5");
				var sol4=<?php echo $ccc; ?>;
				function reservation_captcha_val5(){
				  
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
				reservation_captcha5.onchange=reservation_captcha_val5;
				
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
				
				n_cell_phone=document.getElementById('new_cell_phone');
				function cellphone_check()
				{
					if(n_cell_phone.value.trim()!="")
					{
						if((n_cell_phone.value.trim()).length!=11)
						{
							n_cell_phone.setCustomValidity('Enter exactly 11 digits');
							return false;
						}
						else
						{
							var i=0,c=0,st=n_cell_phone.value.trim();
							for(;i<(n_cell_phone.value.trim()).length;i++)
							{
								if(st[i]>='0' && st[i]<='9') c++;
							}
							if(c==11)
							{	
								n_cell_phone.setCustomValidity('');
								return true;
							}
							else
							{
								n_cell_phone.setCustomValidity('Enter valid 11 digits (0-9)');
								return false;
							}
						}
					}
					else
					{
						n_cell_phone.setCustomValidity('');
						return true;
					}
				}
				n_cell_phone.onchange=cellphone_check;
				//old values
				var admin_cell_no=<?php echo '"'.$admin_cell_no.'"'; ?>;
				var admin_name=<?php echo '"'.$admin_name.'"'; ?>;
				var admin_designation=<?php echo '"'.$admin_designation.'"'; ?>;
				var admin_email=<?php echo '"'.$admin_email.'"'; ?>;
				var admin_joining_date=<?php echo '"'.$admin_joining_date2.'"'; ?>;
				var admin_gender=<?php echo '"'.$admin_gender.'"'; ?>;
				
				function form_change()
				{
					
					//new values
					var new_admin_cell_no=document.getElementById('new_cell_phone').value.trim();
					
					var admin_image=document.getElementById('admin_image').value.trim();
					var new_c_pass=document.getElementById("c_pass").value.trim();
					var new_pass=document.getElementById("pass").value.trim();
					
					var new_admin_name=document.getElementById("admin_name").value.trim();
					var new_admin_designation=document.getElementById("admin_designation").value.trim();
					var new_admin_email=document.getElementById("admin_email").value.trim();
					var new_admin_joining_date=document.getElementById("admin_joining_date").value.trim();
					var new_admin_gender=document.getElementById("admin_gender").value.trim();
					
					if((admin_cell_no!=new_admin_cell_no || admin_image!="" || new_c_pass!="" || new_pass!="" || new_admin_name!=admin_name || new_admin_designation!=admin_designation || new_admin_email!=admin_email || new_admin_joining_date!=admin_joining_date || new_admin_gender!=admin_gender) && new_admin_name!="" && new_admin_designation!="" && new_admin_email!="" && new_admin_joining_date!="" && new_admin_gender!="")
					{
						document.getElementById("edit_btn").disabled = false;
					}
					else
					{
						document.getElementById("edit_btn").disabled = true;
					}
				}
				
				function profile_add_form_save()
				{
					var new_admin_cell_no=document.getElementById('new_cell_phone').value.trim();
					
					var admin_image=document.getElementById('admin_image').value.trim();
					var new_c_pass=document.getElementById("c_pass").value.trim();
					var new_pass=document.getElementById("pass").value.trim();
					
					var new_admin_name=document.getElementById("admin_name").value.trim();
					var new_admin_designation=document.getElementById("admin_designation").value.trim();
					var new_admin_email=document.getElementById("admin_email").value.trim();
					<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
						var new_admin_joining_date=document.getElementById("admin_joining_date").value.trim();
					<?php } else { ?>
						var new_admin_joining_date=admin_joining_date;
					<?php } ?>
					var new_admin_gender=document.getElementById("admin_gender").value.trim();
					
					
					if(password_check()==true && reservation_captcha_val5()==true && cellphone_check()==true)
					{
						if(admin_image!="")
						{
							if(file_validate(admin_image)==true)
							{
								c_pass.setCustomValidity('');
								pass.setCustomValidity('');
								n_cell_phone.setCustomValidity('');
								reservation_captcha5.setCustomValidity('');
								document.getElementById('admin_image').setCustomValidity('');
								
								document.getElementById('edit_loading').style.display='block';
								document.getElementById('admin_image').setCustomValidity('');
								var image=document.getElementById('admin_image').files[0];
								var fd_image=new FormData();
								var link='admin_image';
								fd_image.append(link, image);
								//Ajax for image upload
								var xhttp1 = new XMLHttpRequest();
								xhttp1.onreadystatechange = function() {
									if (this.readyState == 4 && this.status == 200) {
										//receive upload details
										var image_name=this.responseText.trim();
										//console.log(image_name);
										
										image_name=image_name[image_name.length-2]+image_name[image_name.length-1];
										
										
										if(image_name=="Ok")
										{
											var tmppath = URL.createObjectURL(image);
											$("#admin_profile_image").fadeIn("fast").attr('src',tmppath);
											$("#admin_profile_image2").fadeIn("fast").attr('src',tmppath);
											
											
											document.getElementById('image_progress_id').style.width='0%';
											document.getElementById('image_progress_id').innerHTML='0%';
											
											admin_cell_no = document.getElementById('new_cell_phone').value;
											admin_name = document.getElementById('admin_name').value.trim();
											admin_designation = document.getElementById('admin_designation').value.trim();
											admin_email = document.getElementById('admin_email').value.trim();
											<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
											admin_joining_date = document.getElementById('admin_joining_date').value.trim();
											<?php } ?>
											admin_gender = document.getElementById('admin_gender').value.trim();
											
											document.getElementById('edit_loading').style.display='none';
										
											clear_edit_profile();
											
											document.getElementById('valid_msg').style.display='block';
											document.getElementById('v_msg').innerHTML='Profile Successfully updated.';
											setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										}
										else
										{
											document.getElementById('image_progress_id').style.width='0%';
											document.getElementById('image_progress_id').innerHTML='0%';
											document.getElementById('edit_loading').style.display='none';
											clear_edit_profile();
											document.getElementById('invalid_msg').style.display='block';
											document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
											setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
										}
									}
									else if(this.readyState==4 && (this.status==404 || this.status==403))
									{
										document.getElementById('edit_loading').style.display='none';
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Network error occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
									}
								};
								xhttp1.upload.onprogress = function(e) {
									if (e.lengthComputable) {
									  var percentComplete = Math.round((e.loaded / e.total) * 100);
									  percentComplete=percentComplete.toFixed(2);
									  if(percentComplete==100)
									  {
										 document.getElementById('image_progress_id').style.width=percentComplete+'%';
										 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
									  }
									  else
									  {
										 document.getElementById('image_progress_id').style.width=percentComplete+'%';
										 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
									  }
									}
								};
								xhttp1.open("POST", "../includes/super_admin/set_profile_pic.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&image="+link+"&cell_no="+new_admin_cell_no+"&password="+new_c_pass+"&name="+new_admin_name+"&designation="+new_admin_designation+"&email="+new_admin_email+"&joining_date="+new_admin_joining_date+"&gender="+new_admin_gender, true);
								xhttp1.send(fd_image);
							}
							else
							{
								document.getElementById('admin_image').setCustomValidity('Upload valid DP .jpg, .jpeg, .png, .bmp file');
							}
							
						}
						else
						{
							c_pass.setCustomValidity('');
							pass.setCustomValidity('');
							n_cell_phone.setCustomValidity('');
							reservation_captcha5.setCustomValidity('');
							document.getElementById('admin_image').setCustomValidity('');
					
							document.getElementById('edit_loading').style.display='block';
							//upload without image
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									//receive update details
									
									var image_name=this.responseText.trim();
									image_name=image_name[image_name.length-2]+image_name[image_name.length-1];
										
									if(image_name=="Ok")
									{
										document.getElementById('image_progress_id').style.width='0%';
										document.getElementById('image_progress_id').innerHTML='0%';
										document.getElementById('edit_loading').style.display='none';
										
										admin_cell_no = document.getElementById('new_cell_phone').value;
										admin_name = document.getElementById('admin_name').value.trim();
										admin_designation = document.getElementById('admin_designation').value.trim();
										admin_email = document.getElementById('admin_email').value.trim();
										<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
										admin_joining_date = document.getElementById('admin_joining_date').value.trim();
										<?php } ?>
										admin_gender = document.getElementById('admin_gender').value.trim();
											
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='Profile Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none';},2000);
										clear_edit_profile();
										
									}
									else
									{
										document.getElementById('image_progress_id').style.width='0%';
										document.getElementById('image_progress_id').innerHTML='0%';
										document.getElementById('edit_loading').style.display='none';
										clear_edit_profile();
										
										
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('image_progress_id').style.width='0%';
									document.getElementById('image_progress_id').innerHTML='0%';
									document.getElementById('edit_loading').style.display='none';
									clear_edit_profile();
									
									
									document.getElementById('invalid_msg').style.display='block';
									document.getElementById('i_msg').innerHTML='Network error occured.';
									setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
									
									
								}
							};
							xhttp1.upload.onprogress = function(e) {
								if (e.lengthComputable) {
								  var percentComplete = Math.round((e.loaded / e.total) * 100);
								  percentComplete=percentComplete.toFixed(2);
								  if(percentComplete==100)
								  {
									 document.getElementById('image_progress_id').style.width=percentComplete+'%';
									 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('image_progress_id').style.width=percentComplete+'%';
									 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/set_profile.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&cell_no="+new_admin_cell_no+"&password="+new_c_pass+"&name="+new_admin_name+"&designation="+new_admin_designation+"&email="+new_admin_email+"&joining_date="+new_admin_joining_date+"&gender="+new_admin_gender, true);
							xhttp1.send();
							
						}

					}
					
					
				}
				
				function edit_profile()
				{
					//new values
					var new_admin_cell_no=document.getElementById('new_cell_phone').value.trim();
					
					var admin_image=document.getElementById('admin_image').value.trim();
					var new_c_pass=document.getElementById("c_pass").value.trim();
					var new_pass=document.getElementById("pass").value.trim();
					
					var new_admin_name=document.getElementById("admin_name").value.trim();
					var new_admin_designation=document.getElementById("admin_designation").value.trim();
					var new_admin_email=document.getElementById("admin_email").value.trim();
					<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
						var new_admin_joining_date=document.getElementById("admin_joining_date").value.trim();
					<?php } else { ?>
						var new_admin_joining_date=admin_joining_date;
					<?php } ?>
					var new_admin_gender=document.getElementById("admin_gender").value.trim();
					
					
					if(password_check()==true && reservation_captcha_val5()==true && cellphone_check()==true)
					{
						//check for email change
						if(admin_email!=new_admin_email)
						{
							document.getElementById('edit_loading').style.display='block';
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									if(this.responseText.trim()=='Error')
									{
										document.getElementById('edit_loading').style.display='none';
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Invalid Email Inserted.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
								
									}
									else
									{
										verification_otp=this.responseText.trim();
										document.getElementById('profile_add_re_confirmation').style.display='block';
										document.getElementById('edit_loading').style.display='none';
									}									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('edit_loading').style.display='none';
												
									document.getElementById('invalid_msg').style.display='block';
									document.getElementById('i_msg').innerHTML='Network error occured.';
									setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
								}
							};
							xhttp1.open("POST", "../includes/super_admin/get_otp_edit_profile.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&email="+new_admin_email, true);
							xhttp1.send();
						}
						else
						{
						
							if(admin_image!="")
							{
								if(file_validate(admin_image)==true)
								{
									c_pass.setCustomValidity('');
									pass.setCustomValidity('');
									n_cell_phone.setCustomValidity('');
									reservation_captcha5.setCustomValidity('');
									document.getElementById('admin_image').setCustomValidity('');
									
									document.getElementById('edit_loading').style.display='block';
									document.getElementById('admin_image').setCustomValidity('');
									var image=document.getElementById('admin_image').files[0];
									var fd_image=new FormData();
									var link='admin_image';
									fd_image.append(link, image);
									//Ajax for image upload
									var xhttp1 = new XMLHttpRequest();
									xhttp1.onreadystatechange = function() {
										if (this.readyState == 4 && this.status == 200) {
											//receive upload details
											var image_name=this.responseText.trim();
											//console.log(image_name);
											
											image_name=image_name[image_name.length-2]+image_name[image_name.length-1];
											
											
											if(image_name=="Ok")
											{
												var tmppath = URL.createObjectURL(image);
												$("#admin_profile_image").fadeIn("fast").attr('src',tmppath);
												$("#admin_profile_image2").fadeIn("fast").attr('src',tmppath);
												
												
												document.getElementById('image_progress_id').style.width='0%';
												document.getElementById('image_progress_id').innerHTML='0%';
												
												admin_cell_no = document.getElementById('new_cell_phone').value;
												admin_name = document.getElementById('admin_name').value.trim();
												admin_designation = document.getElementById('admin_designation').value.trim();
												admin_email = document.getElementById('admin_email').value.trim();
												<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
												admin_joining_date = document.getElementById('admin_joining_date').value.trim();
												<?php } ?>
												admin_gender = document.getElementById('admin_gender').value.trim();
												
												document.getElementById('edit_loading').style.display='none';
											
												clear_edit_profile();
												
												document.getElementById('valid_msg').style.display='block';
												document.getElementById('v_msg').innerHTML='Profile Successfully updated.';
												setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
											}
											else
											{
												document.getElementById('image_progress_id').style.width='0%';
												document.getElementById('image_progress_id').innerHTML='0%';
												document.getElementById('edit_loading').style.display='none';
												clear_edit_profile();
												document.getElementById('invalid_msg').style.display='block';
												document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
												setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
											
											}
										}
										else if(this.readyState==4 && (this.status==404 || this.status==403))
										{
											document.getElementById('edit_loading').style.display='none';
											document.getElementById('invalid_msg').style.display='block';
											document.getElementById('i_msg').innerHTML='Network error occured.';
											setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										}
									};
									xhttp1.upload.onprogress = function(e) {
										if (e.lengthComputable) {
										  var percentComplete = Math.round((e.loaded / e.total) * 100);
										  percentComplete=percentComplete.toFixed(2);
										  if(percentComplete==100)
										  {
											 document.getElementById('image_progress_id').style.width=percentComplete+'%';
											 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
										  }
										  else
										  {
											 document.getElementById('image_progress_id').style.width=percentComplete+'%';
											 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
										  }
										}
									};
									xhttp1.open("POST", "../includes/super_admin/set_profile_pic.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&image="+link+"&cell_no="+new_admin_cell_no+"&password="+new_c_pass+"&name="+new_admin_name+"&designation="+new_admin_designation+"&email="+new_admin_email+"&joining_date="+new_admin_joining_date+"&gender="+new_admin_gender, true);
									xhttp1.send(fd_image);
								}
								else
								{
									document.getElementById('admin_image').setCustomValidity('Upload valid DP .jpg, .jpeg, .png, .bmp file');
								}
								
							}
							else
							{
								c_pass.setCustomValidity('');
								pass.setCustomValidity('');
								n_cell_phone.setCustomValidity('');
								reservation_captcha5.setCustomValidity('');
								document.getElementById('admin_image').setCustomValidity('');
						
								document.getElementById('edit_loading').style.display='block';
								//upload without image
								var xhttp1 = new XMLHttpRequest();
								xhttp1.onreadystatechange = function() {
									if (this.readyState == 4 && this.status == 200) {
										//receive update details
										
										var image_name=this.responseText.trim();
										image_name=image_name[image_name.length-2]+image_name[image_name.length-1];
											
										if(image_name=="Ok")
										{
											document.getElementById('image_progress_id').style.width='0%';
											document.getElementById('image_progress_id').innerHTML='0%';
											document.getElementById('edit_loading').style.display='none';
											
											admin_cell_no = document.getElementById('new_cell_phone').value;
											admin_name = document.getElementById('admin_name').value.trim();
											admin_designation = document.getElementById('admin_designation').value.trim();
											admin_email = document.getElementById('admin_email').value.trim();
											<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
											admin_joining_date = document.getElementById('admin_joining_date').value.trim();
											<?php } ?>
											admin_gender = document.getElementById('admin_gender').value.trim();
												
											document.getElementById('valid_msg').style.display='block';
											document.getElementById('v_msg').innerHTML='Profile Successfully updated.';
											setTimeout(function(){ document.getElementById('valid_msg').style.display='none';},2000);
											clear_edit_profile();
											
										}
										else
										{
											document.getElementById('image_progress_id').style.width='0%';
											document.getElementById('image_progress_id').innerHTML='0%';
											document.getElementById('edit_loading').style.display='none';
											clear_edit_profile();
											
											
											document.getElementById('invalid_msg').style.display='block';
											document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
											setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
											
										}
										
										
									}
									else if(this.readyState==4 && (this.status==404 || this.status==403))
									{
										document.getElementById('image_progress_id').style.width='0%';
										document.getElementById('image_progress_id').innerHTML='0%';
										document.getElementById('edit_loading').style.display='none';
										clear_edit_profile();
										
										
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Network error occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
										
									}
								};
								xhttp1.upload.onprogress = function(e) {
									if (e.lengthComputable) {
									  var percentComplete = Math.round((e.loaded / e.total) * 100);
									  percentComplete=percentComplete.toFixed(2);
									  if(percentComplete==100)
									  {
										 document.getElementById('image_progress_id').style.width=percentComplete+'%';
										 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
									  }
									  else
									  {
										 document.getElementById('image_progress_id').style.width=percentComplete+'%';
										 document.getElementById('image_progress_id').innerHTML= percentComplete+'%';
									  }
									}
								};
								xhttp1.open("POST", "../includes/super_admin/set_profile.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&cell_no="+new_admin_cell_no+"&password="+new_c_pass+"&name="+new_admin_name+"&designation="+new_admin_designation+"&email="+new_admin_email+"&joining_date="+new_admin_joining_date+"&gender="+new_admin_gender, true);
								xhttp1.send();
								
							}
						}
					}
					
					
				}
				
				function clear_edit_profile()
				{
					
					//new values
					document.getElementById('new_cell_phone').value=admin_cell_no;
					document.getElementById('admin_name').value=admin_name;
					document.getElementById('admin_designation').value=admin_designation;
					document.getElementById('admin_email').value=admin_email;
					<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
						document.getElementById('admin_joining_date').value=admin_joining_date;
					<?php } ?>
					document.getElementById('admin_gender').value=admin_gender;
					
					document.getElementById('admin_image').value='';
					document.getElementById('captcha5').value='';
					document.getElementById("c_pass").value='';
					document.getElementById("pass").value='';
					document.getElementById("dp_msg").style.display='none';
					document.getElementById("edit_btn").disabled = true;
				
					c_pass.setCustomValidity('');
					pass.setCustomValidity('');
					n_cell_phone.setCustomValidity('');
					reservation_captcha5.setCustomValidity('');
					document.getElementById('admin_image').setCustomValidity('');
					
				}
			</script>
		</div>
	</div>
</div>
</form>
<?php 

	}
	catch(Exception $e)
	{
		echo $e;
	}

?>
