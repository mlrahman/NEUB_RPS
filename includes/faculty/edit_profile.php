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

<div id="edit_loading" title="Please wait while uploading your profile.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;height:100%;width:100%;top:0;left:0;background:black;opacity:0.6;position:fixed;z-index:9999;padding-top:170px;border-radius:0px 0px 10px 10px;">
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
			<label><b>Name</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_name; ?>" disabled>
		  
			<label><b>Designation</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_designation; ?>" disabled>
		</div>
		<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 0px 6px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 0px;">			
					<?php if($photo=="" && $gender=="Male"){ ?>
						<img src="../images/system/male_profile.png" id="faculty_profile_image2" class="w3-image" style="border: 2px solid black;margin:22px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
					<?php } else if($photo==""){ ?>
						<img src="../images/system/female_profile.png" id="faculty_profile_image2" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="DP (120X100)px" alt="DP (120X100)px">
					<?php } else { ?>
						<img src="../images/faculty/<?php echo $photo; ?>" id="faculty_profile_image2" class="w3-image" style="border: 2px solid black;10px 0px 0px 0px;padding:0px;width:100%;max-width:100px;height: 120px;"  title="DP (120X100)px" alt="DP (120X100)px">
					<?php } ?>
				</div>
				
				<div class="w3-col w3-margin-0" style="width:70%;padding:5px 0px 0px 0px;">			
					
					<button onclick="clear_edit_profile()" class="w3-button w3-red w3-right w3-hover-teal w3-round-large w3-margin-left"><i class="	fa fa-eye-slash"></i> Clear</button>
					
					<button id="edit_btn" onclick="edit_profile()" class="w3-button w3-black w3-right w3-hover-teal w3-round-large" disabled><i class="fa fa-save"></i> Save Changes</button>
					
					
					<div class="w3-clear" style="margin-bottom: 30px;"></div>
					<label><i class="w3-text-red">*</i> <b>Upload DP</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" onclick="document.getElementById('dp_msg').style.display='block'" type="file" id="faculty_image" title="Please upload DP (120X100)px"  onchange="form_change()">
					<i class="w3-text-red w3-small w3-bold" id="dp_msg" style="display: none;">*Upload DP with (120X100)px</i>
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
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_cell_no; ?>" placeholder="Enter your 11 digits cell no" id="new_cell_phone" onkeyup="form_change()" autocomplete="off">
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
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" onkeyup="form_change()"  autocomplete="off" id="pass" placeholder="Enter only for change password">
		</div>
		<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
			<label><i class="w3-text-red">*</i> <b>Confirm New Password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" onkeyup="form_change()"  autocomplete="off" id="c_pass" placeholder="Confirm the new password">
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
					//new values
					var new_faculty_cell_no=document.getElementById('new_cell_phone').value.trim();
					var new_otp=document.getElementById('new_otp').value.trim();
					
					var faculty_image=document.getElementById('faculty_image').value.trim();
					var new_c_pass=document.getElementById("c_pass").value;
					var new_pass=document.getElementById("pass").value;
					if(password_check()==true && reservation_captcha_val5()==true && cellphone_check()==true)
					{
						if(faculty_image!="")
						{
							if(file_validate(faculty_image)==true)
							{
								c_pass.setCustomValidity('');
								pass.setCustomValidity('');
								n_cell_phone.setCustomValidity('');
								reservation_captcha5.setCustomValidity('');
								document.getElementById('faculty_image').setCustomValidity('');
								
								document.getElementById('edit_loading').style.display='block';
								document.getElementById('faculty_image').setCustomValidity('');
								var image=document.getElementById('faculty_image').files[0];
								var fd_image=new FormData();
								var link='faculty_image';
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
											$("#faculty_profile_image").fadeIn("fast").attr('src',tmppath);
											$("#faculty_profile_image2").fadeIn("fast").attr('src',tmppath);
											
											
											document.getElementById('image_progress_id').style.width='0%';
											document.getElementById('image_progress_id').innerHTML='0%';
											
											faculty_cell_no = document.getElementById('new_cell_phone').value;
											otp = document.getElementById('new_otp').value;
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
								xhttp1.open("POST", "../includes/faculty/set_profile_pic.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&image="+link+"&cell_no="+new_faculty_cell_no+"&otp="+new_otp+"&password="+new_c_pass, true);
								xhttp1.send(fd_image);
							}
							else
							{
								document.getElementById('faculty_image').setCustomValidity('Upload valid DP .jpg, .jpeg, .png, .bmp file');
							}
							
						}
						else
						{
							c_pass.setCustomValidity('');
							pass.setCustomValidity('');
							n_cell_phone.setCustomValidity('');
							reservation_captcha5.setCustomValidity('');
							document.getElementById('faculty_image').setCustomValidity('');
					
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
										
										faculty_cell_no = document.getElementById('new_cell_phone').value;
										otp = document.getElementById('new_otp').value;
										
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
							xhttp1.open("POST", "../includes/faculty/set_profile.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&cell_no="+new_faculty_cell_no+"&otp="+new_otp+"&password="+new_c_pass, true);
							xhttp1.send();
							
						}
					}
					
					
				}
				function clear_edit_profile()
				{
					
					//new values
					document.getElementById('new_cell_phone').value=faculty_cell_no;
					document.getElementById('new_otp').value=otp;
					
					document.getElementById('faculty_image').value='';
					document.getElementById('captcha5').value='';
					document.getElementById("c_pass").value='';
					document.getElementById("pass").value='';
					document.getElementById("dp_msg").style.display='none';
					document.getElementById("edit_btn").disabled = true;
				
					c_pass.setCustomValidity('');
					pass.setCustomValidity('');
					n_cell_phone.setCustomValidity('');
					reservation_captcha5.setCustomValidity('');
					document.getElementById('faculty_image').setCustomValidity('');
					
				}
			</script>
		</div>
	</div>
</div>
</form>
