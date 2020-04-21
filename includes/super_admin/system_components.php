<?php
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location: index.php");
		die();
	}
	if($_SESSION['admin_type']!='Super Admin')
	{
		header("location: index.php");
		die();
	}
	
	$stmt = $conn->prepare("select * from nr_system_component a, nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_syco_status='Active' order by a.nr_syco_id desc limit 1 ");
	$stmt->execute();
	$result = $stmt->fetchAll();
	
	if(count($result)==0)
	{
		$title='N/A';
		$caption='N/A';
		$address='N/A';
		$telephone='N/A';
		$email='N/A';
		$mobile='N/A';
		$web='N/A';
		$contact_email='N/A';
		$map_link='N/A';
		$date='N/A';
		$updated_by='N/A';
		$designation='N/A';
		
		$logo='';
		$video_alt='';
		$video='';
	}
	else
	{
		$title=$result[0][2];
		$caption=$result[0][3];
		$address=$result[0][4];
		$telephone=$result[0][5];
		$email=$result[0][6];
		$mobile=$result[0][7];
		$web=$result[0][8];
		$contact_email=$result[0][9];
		$map_link=$result[0][10];
		$date=$result[0][11];
		$updated_by=$result[0][17];
		$designation=$result[0][23];
		$logo=$result[0][13];
		$video_alt=$result[0][14];
		$video=$result[0][15];
		
	}
	
?>

<div id="syco_loading" title="Please wait while uploading the content.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;height:100%;width:100%;top:0;left:0;background:black;opacity:0.6;position:fixed;z-index:999999999;padding-top:170px;border-radius:0px 0px 10px 10px;">
	<p style="font-size:15px;font-weight:bold;">Please wait while uploading the content..</p>
	<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
		<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="syco_progress_id" style="width:0%;">0%</div>
	</div>
	<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
</div>

<div id="syco_re_loading" title="Please wait while deleting the display video.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;height:100%;width:100%;top:0;left:0;background:black;opacity:0.6;position:fixed;z-index:999999999;padding-top:170px;border-radius:0px 0px 10px 10px;">
	<p style="font-size:15px;font-weight:bold;">Please wait while deleting the display video..</p>
	<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
		<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="syco_re_progress_id" style="width:0%;">0%</div>
	</div>
	<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
</div>

<!-- Confirmation modal -->
<div id="syco_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove the display video?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="syco_pass" placeholder="Enter your password" autocomplete="off">
			
			<?php 
				//spam Check 
				$aaa=rand(1,20);
				$bbb=rand(1,20);
				$ccc=$aaa+$bbb;
			?>
			<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
			<div class="w3-row" style="margin:0px 0px 10px 0px;padding:0px;">
				<div class="w3-col" style="width:40%;">
					<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
				</div>
				<div class="w3-col" style="margin-left:2%;width:58%;">
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_syco_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_syco_video()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('syco_re_confirmation').style.display='none';document.getElementById('captcha_syco_confirm').value='';document.getElementById('syco_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_syco_confirm = document.getElementById("captcha_syco_confirm");
		var sol_syco_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_syco_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_syco_confirm.value != sol_syco_confirm) {
			reservation_captcha_syco_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_syco_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_syco_confirm.onchange=reservation_captcha_val_syco_confirm;
	
	
		var pass_syco_confirm = document.getElementById("syco_pass");
		function syco_pass_co_fu()
		{
			if(pass_syco_confirm.value.trim()!="")
			{
				pass_syco_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_syco_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_syco_confirm.onchange=syco_pass_co_fu;
		
	</script>
</div>


<form onsubmit="return false">
	<p class="w3-text-red w3-small w3-bold" style="margin: 12px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
	<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 14px 0px;">
				<label><i class="w3-text-red">*</i> <b>Web Title</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $title; ?>" id="title" placeholder="Enter Web Title" autocomplete="off" onkeyup="syco_form_change()">
				
				<label><b>Web Display Caption</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $caption; ?>" id="caption" placeholder="Enter Web Display caption" autocomplete="off" onkeyup="syco_form_change()" >
			  
				<label><i class="w3-text-red">*</i> <b>University Address</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $address; ?>" id="address" placeholder="Enter University Address" autocomplete="off" onkeyup="syco_form_change()">
				
				
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
						<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_syco" autocomplete="off">
					</div>
				</div>
					
				
			</div>
			<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 14px 6px;">
				<button onclick="reset_system_components()" class="w3-button w3-red w3-right w3-hover-teal w3-round-large w3-margin-left"><i class="fa fa-eye-slash"></i> Reset</button>
				<button id="up_syco_btn" onclick="update_system_components()" class="w3-button w3-black w3-right w3-hover-teal w3-round-large" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				<div class="w3-clear" style="margin-bottom: 23px;"></div>
				
				<div id="syco_window10" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
					<i onclick="close_syco_window10()" title="Close window" class=" w3-cursor w3-right w3-margin-top w3-large w3-hover-text-teal w3-round fa fa-close w3-text-red w3-xlarge"></i>
					<p class="w3-bold w3-left w3-large w3-text-teal" style="margin:10px 0px 15px 0px;width:270px;"><i class="fa fa-eye"></i> <span id="syco_window10_title"></span></p>
					<div id="syco_window10_details" class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
						<i class="fa fa-refresh w3-large w3-spin w3-center w3-margin-top w3-margin-bottom"  title="loading" id="syco_window10_loading"></i>
						<img src="" id="syco_window_img" style="max-height:150px;max-width:328px;display:none;margin: 0 auto;"/>
						<video autoplay muted loop id="syco_window_vid" class="w3-grayscale" style="display:none;max-height:150px;max-width:328px;margin: 0 auto;">
						</video>
					</div>
				</div>
				
				<label><b>Change Logo</b></label><a class="w3-right w3-decoration-null w3-cursor w3-text-blue w3-margin-top" title="Click for view the logo" onclick="view_syco_window(1)"><i class="fa fa-desktop"></i> View</a>
				<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('cl_msg').style.display='block'" type="file" id="logo" title="Please upload LOGO (204X180)px"  onchange="syco_form_change()">
				<i class="w3-text-red w3-small w3-bold" id="cl_msg" style="display: none;">*Upload Logo with (204X180)px</i>
				
				<label class="w3-margin-top" style="display:inline-block;"><b>Change Display Image</b></label><a class="w3-right w3-decoration-null w3-cursor w3-text-blue w3-margin-top" title="Click for view the display image" onclick="view_syco_window(2)"><i class="fa fa-desktop"></i> View</a>
				<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('cdi_msg').style.display='block'" type="file" id="video_alt" title="Please upload Dispaly Image (450X1500)px"  onchange="syco_form_change()">
				<i class="w3-text-red w3-small w3-bold" id="cdi_msg" style="display: none;">*Upload Display Image with (450X1500)px</i>
				
				<label class="w3-margin-top" style="display:inline-block;"><b>Change Display Video</b></label><a class="w3-right w3-decoration-null w3-cursor w3-text-blue w3-margin-left w3-margin-top" style="<?php if($video==""){ echo 'display:none;'; } ?>" id="syco_vvi_btn" title="Click for view the display video" onclick="view_syco_window(3)"><i class="fa fa-desktop"></i> View</a><a class="w3-right w3-decoration-null w3-cursor w3-text-red  w3-margin-top" style="<?php if($video==""){ echo 'display:none;'; } ?>" id="syco_vre_btn" onclick="document.getElementById('syco_re_confirmation').style.display='block'" title="Click for delete the display video"><i class="fa fa-eraser"></i> Remove</a>
				<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('cdv_msg').style.display='block'" type="file" id="video" title="Please upload Dispaly Video (450X1500)px"  onchange="syco_form_change()">
				<i class="w3-text-red w3-small w3-bold" id="cdv_msg" style="display: none;">*Upload Display Video with (450X1500)px</i>
				
				
			</div>
		</div>
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
				<label><i class="w3-text-red">*</i> <b>Website Link</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $web; ?>" id="web" placeholder="Enter Website Link" autocomplete="off" onkeyup="syco_form_change()">
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Contact Email</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" value="<?php echo $contact_email; ?>" id="contact_email" placeholder="Enter Contact Email" autocomplete="off" onkeyup="syco_form_change()">
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 0px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Google Map Link</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $map_link; ?>" id="map_link" placeholder="Enter Google Map Link" autocomplete="off" onkeyup="syco_form_change()">
			</div>
		</div>
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
				<label><i class="w3-text-red">*</i> <b>Telephone</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $telephone; ?>" id="telephone" placeholder="Enter Telephone No." autocomplete="off" onkeyup="syco_form_change()">
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Web Email</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" value="<?php echo $email; ?>" id="email" placeholder="Enter Display Email" autocomplete="off" onkeyup="syco_form_change()">
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 0px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Cell No</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $mobile; ?>" id="mobile" placeholder="Enter Mobile No." autocomplete="off" onkeyup="syco_form_change()">
			</div>
		</div>
		
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
				<label><b>Updated On</b></label>
				<input class="w3-input w3-text-brown w3-bold w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo get_date($date); ?>" id="updated_on" disabled>
			</div>
			<div class="w3-col w3-margin-0" style="width:66.67%;padding:0px 0px 0px 6px;">
				<label><b>Updated By</b></label>
				<input class="w3-input w3-text-brown w3-bold w3-border w3-margin-bottom w3-round-large" type="text" id="updated_by" value="<?php echo $updated_by.', '.$designation; ?>" disabled>
			</div>
			
		</div>
		
	</div>




	<script>
		
		
		function close_syco_window10()
		{
			document.getElementById('syco_window_img').src='';
			document.getElementById('syco_window_img').style.display='none';
			document.getElementById('syco_window_vid').style.display='none';
			document.getElementById('syco_window10').style.display='none';
			document.getElementById('syco_window10_loading').style.display='none';
			document.getElementById('syco_window10_title').innerHTML='';
			
		}
		
		function view_syco_window(id)
		{
			close_syco_window10();
			document.getElementById('syco_window10').style.display='block';
			document.getElementById('syco_window10_loading').style.display='block';
						
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					str=this.responseText.trim();
					
					var msg3='',i=0;
					for(;i<str.length;i++)
					{
						if(str[i]=='@')
							break;
						else
							msg3=msg3+str[i];
					}
					i++;
					var dat='';
					for(;i<str.length;i++)
					{
						if(str[i]=='@')
							break;
						else
							dat=dat+str[i];
					}
					document.getElementById('syco_window10_loading').style.display='none';
			
					if(msg3=='Ok')
					{
						if(id==1)
						{
							document.getElementById('syco_window10_title').innerHTML='Logo';
						}
						else if(id==2)
						{
							document.getElementById('syco_window10_title').innerHTML='Display Image';
							
						}
						else if(id==3)
						{
							document.getElementById('syco_window10_title').innerHTML='Display Video';
			
						}
						if(id==1 || id==2)
						{
							document.getElementById('syco_window_img').style.display='block';
							document.getElementById('syco_window_img').src='../images/system/'+dat;
						}
						else
						{
							document.getElementById('syco_window_vid').style.display='block';
							document.getElementById('syco_window_vid').innerHTML='<source src="../images/system/'+dat+'" type="video/mp4">'+'<source src="../images/system/'+dat+'" type="video/ogg">'+'<source src="../images/system/'+dat+'" type="video/webm">'+'Browser does not support';
						}
			
					}
					else
					{
						close_syco_window10();
					
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					close_syco_window10();
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occured.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
				}
			};
			xhttp1.open("POST", "../includes/super_admin/syco_view.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&id="+id, true);
			xhttp1.send();
		}
		
		
		var sycotitle=<?php echo '"'.$title.'"'; ?>;
		var sycocaption=<?php echo '"'.$caption.'"'; ?>;
		var sycoaddress=<?php echo '"'.$address.'"'; ?>;
		var sycotelephone=<?php echo '"'.$telephone.'"'; ?>;
		var sycoemail=<?php echo '"'.$email.'"'; ?>;
		var sycomobile=<?php echo '"'.$mobile.'"'; ?>;
		var sycoweb=<?php echo '"'.$web.'"'; ?>;
		var sycocontact_email=<?php echo '"'.$contact_email.'"'; ?>;
		var sycomap_link=<?php echo '"'.$map_link.'"'; ?>;
		var sycodate=<?php echo '"'.$date.'"'; ?>;
		var sycoupdated_by=<?php echo '"'.$updated_by.'"'; ?>;
		var sycodesignation=<?php echo '"'.$designation.'"'; ?>;
		

		//Captcha Validation for create new password
		var reservation_captcha_syco = document.getElementById("captcha_syco");
		var sol_syco=<?php echo $ccc; ?>;
		function reservation_captcha_val_syco(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_syco.value != sol_syco) {
			reservation_captcha_syco.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_syco.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_syco.onchange=reservation_captcha_val_syco;
		
		
		n_mobile=document.getElementById('mobile');
		function mobile_check()
		{
			if(n_mobile.value.trim()!="")
			{
				if((n_mobile.value.trim()).length!=11)
				{
					n_mobile.setCustomValidity('Enter exactly 11 digits');
					return false;
				}
				else
				{
					var i=0,c=0,st=n_mobile.value.trim();
					for(;i<(n_mobile.value.trim()).length;i++)
					{
						if(st[i]>='0' && st[i]<='9') c++;
					}
					if(c==11)
					{	
						n_mobile.setCustomValidity('');
						return true;
					}
					else
					{
						n_mobile.setCustomValidity('Enter valid 11 digits (0-9)');
						return false;
					}
				}
			}
			else
			{
				n_mobile.setCustomValidity('');
				return true;
			}
		}
		n_mobile.onchange=mobile_check;
		
		
		function remove_syco_video()
		{
			var pass=document.getElementById('syco_pass').value.trim();
			if(reservation_captcha_val_syco_confirm()==true && syco_pass_co_fu()==true)
			{
				
				document.getElementById('captcha_syco_confirm').value='';
				document.getElementById('syco_pass').value='';
				
				document.getElementById('syco_re_confirmation').style.display='none';
				
				document.getElementById('video').setCustomValidity('');
				document.getElementById('logo').setCustomValidity('');
				document.getElementById('video_alt').setCustomValidity('');
				document.getElementById('captcha_syco').setCustomValidity('');
				n_mobile.setCustomValidity('');
				
				document.getElementById('syco_re_loading').style.display='block';
				var xhttp1 = new XMLHttpRequest();
				xhttp1.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
					
						//response of 3
						var str=this.responseText.trim();
						//console.log(str);
						
						
						var msg3='',i=0;
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								msg3=msg3+str[i];
						}
						i++;
						var dat='';
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								dat=dat+str[i];
						}
						i++;
						var admin_name='';
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								admin_name=admin_name+str[i];
						}
						i++;
						var admin_designation='';
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								admin_designation=admin_designation+str[i];
						}
						
						
						
						
						document.getElementById('syco_re_progress_id').style.width='0%';
						document.getElementById('syco_re_progress_id').innerHTML='0%';
						document.getElementById('syco_re_loading').style.display='none';
						
						
						if(msg3=='Ok')
						{
							
							document.getElementById('syco_vvi_btn').style.display='none';
							document.getElementById('syco_vre_btn').style.display='none';
							
							document.getElementById('updated_on').value=dat;
							document.getElementById('updated_by').value=admin_name+', '+admin_designation;
							
							reset_system_components();
							document.getElementById('valid_msg').style.display='block';
							document.getElementById('v_msg').innerHTML='Display video successfully removed.';
							setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
							
						}
						if(msg3=='Error')
						{
							reset_system_components();
							document.getElementById('invalid_msg').style.display='block';
							document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
							setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
							
						}
						else
						{
							reset_system_components();
							document.getElementById('invalid_msg').style.display='block';
							document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
							setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
							
						}
						
						
					}
					else if(this.readyState==4 && (this.status==404 || this.status==403))
					{
						document.getElementById('syco_re_progress_id').style.width='0%';
						document.getElementById('syco_re_progress_id').innerHTML='0%';
						document.getElementById('syco_re_loading').style.display='none';
						reset_system_components();
						
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
						 document.getElementById('syco_re_progress_id').style.width=percentComplete+'%';
						 document.getElementById('syco_re_progress_id').innerHTML= percentComplete+'%';
					  }
					  else
					  {
						 document.getElementById('syco_re_progress_id').style.width=percentComplete+'%';
						 document.getElementById('syco_re_progress_id').innerHTML= percentComplete+'%';
					  }
					}
				};
				xhttp1.open("POST", "../includes/super_admin/syco_remove.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass, true);
				xhttp1.send();
			}
		}
		
		function syco_form_change()
		{
			var new_sycotitle=document.getElementById('title').value.trim();
			var new_sycocaption=document.getElementById('caption').value.trim();
			var new_sycoaddress=document.getElementById('address').value.trim();
			var new_sycotelephone=document.getElementById('telephone').value.trim();
			var new_sycoemail=document.getElementById('email').value.trim();
			var new_sycomobile=document.getElementById('mobile').value.trim();
			var new_sycoweb=document.getElementById('web').value.trim();
			var new_sycocontact_email=document.getElementById('contact_email').value.trim();
			var new_sycomap_link=document.getElementById('map_link').value.trim();
			var new_logo=document.getElementById('logo').value.trim();
			var new_video_alt=document.getElementById('video_alt').value.trim();
			var new_video=document.getElementById('video').value.trim();
			if((new_sycotitle!=sycotitle || new_sycocaption!=sycocaption || new_sycoaddress!=sycoaddress || new_sycotelephone!=sycotelephone || new_sycoemail!=sycoemail || new_sycomobile!=sycomobile || new_sycoweb!=sycoweb || new_sycocontact_email!=sycocontact_email || new_sycomap_link!=sycomap_link || new_logo!="" || new_video_alt!="" || new_video!="") && (new_sycotitle!='' && new_sycoaddress!='' && new_sycotelephone!='' && new_sycoemail!='' && new_sycomobile!='' && new_sycoweb!='' && new_sycocontact_email!='' && new_sycomap_link!=''))
			{
				document.getElementById("up_syco_btn").disabled = false;
			}
			else
			{
				document.getElementById("up_syco_btn").disabled = true;
			}
			
		}
		function update_system_components()
		{
			var new_sycotitle=document.getElementById('title').value.trim();
			var new_sycocaption=document.getElementById('caption').value.trim();
			var new_sycoaddress=document.getElementById('address').value.trim();
			var new_sycotelephone=document.getElementById('telephone').value.trim();
			var new_sycoemail=document.getElementById('email').value.trim();
			var new_sycomobile=document.getElementById('mobile').value.trim();
			var new_sycoweb=document.getElementById('web').value.trim();
			var new_sycocontact_email=document.getElementById('contact_email').value.trim();
			var new_sycomap_link=document.getElementById('map_link').value.trim();
			var new_logo=document.getElementById('logo').value.trim();
			var new_video_alt=document.getElementById('video_alt').value.trim();
			var new_video=document.getElementById('video').value.trim();
			if(reservation_captcha_val_syco()==true && mobile_check()==true)
			{
								
				
				if(new_logo!="" && file_validate(new_logo)==true)
				{
					if(new_video_alt!="" && file_validate(new_video_alt)==true) //video alt available
					{
						if(new_video!="" && file_validate2(new_video)==true) //text,logo,video_alt,video
						{
							
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//logo
							var image1=document.getElementById('logo').files[0];
							var fd_image=new FormData();
							var link1='logo';
							fd_image.append(link1, image1);
							
							//video_alt
							var image2=document.getElementById('video_alt').files[0];
							var link2='video_alt';
							fd_image.append(link2, image2);
							
							//video
							var image3=document.getElementById('video').files[0];
							var link3='video';
							fd_image.append(link3, image3);
							
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									var msg1='',i;
									for(i=0;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg1=msg1+str[i];
									}
									i++;
									var msg2='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg2=msg2+str[i];
									}
									i++;
									var msg3='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg3=msg3+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg1=='Ok' && msg2=='Ok' && msg3=='Ok')
									{
										var tmppath = URL.createObjectURL(image1);
										$("#site_logo").fadeIn("fast").attr('src',tmppath);
										$("#site_logo_link").fadeIn("fast").attr('href',tmppath);
										
										document.getElementById('syco_vvi_btn').style.display='block';
										document.getElementById('syco_vre_btn').style.display='block';
							
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update1.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&logo="+link1+"&video_alt="+link2+"&video="+link3+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
							
								
						}
						else if(new_video=="") //text,logo,video_alt
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//logo
							var image1=document.getElementById('logo').files[0];
							var fd_image=new FormData();
							var link1='logo';
							fd_image.append(link1, image1);
							
							//video_alt
							var image2=document.getElementById('video_alt').files[0];
							var link2='video_alt';
							fd_image.append(link2, image2);
							
														
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									var msg1='',i;
									for(i=0;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg1=msg1+str[i];
									}
									i++;
									var msg2='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg2=msg2+str[i];
									}
									i++;
									
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg1=='Ok' && msg2=='Ok')
									{
										var tmppath = URL.createObjectURL(image1);
										$("#site_logo").fadeIn("fast").attr('src',tmppath);
										$("#site_logo_link").fadeIn("fast").attr('href',tmppath);
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update2.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&logo="+link1+"&video_alt="+link2+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
						}
						else //invalid
						{
							document.getElementById('video').setCustomValidity('Upload valid display video .mp4, .ogg, .webm file');
						}
					}
					else if(new_video_alt=="") //video alt not available
					{
						if(new_video!="" && file_validate2(new_video)==true) //text,logo,video
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//logo
							var image1=document.getElementById('logo').files[0];
							var fd_image=new FormData();
							var link1='logo';
							fd_image.append(link1, image1);
							
							
							//video
							var image3=document.getElementById('video').files[0];
							var link3='video';
							fd_image.append(link3, image3);
							
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									var msg1='',i;
									for(i=0;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg1=msg1+str[i];
									}
									i++;
									
									var msg3='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg3=msg3+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg1=='Ok' && msg3=='Ok')
									{
										var tmppath = URL.createObjectURL(image1);
										$("#site_logo").fadeIn("fast").attr('src',tmppath);
										$("#site_logo_link").fadeIn("fast").attr('href',tmppath);
										document.getElementById('syco_vvi_btn').style.display='block';
										document.getElementById('syco_vre_btn').style.display='block';
							
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update3.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&logo="+link1+"&video="+link3+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
							
						}
						else if(new_video=="") //text,logo
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//logo
							var image1=document.getElementById('logo').files[0];
							var fd_image=new FormData();
							var link1='logo';
							fd_image.append(link1, image1);
							
							
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									var msg1='',i;
									for(i=0;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg1=msg1+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg1=='Ok')
									{
										var tmppath = URL.createObjectURL(image1);
										$("#site_logo").fadeIn("fast").attr('src',tmppath);
										$("#site_logo_link").fadeIn("fast").attr('href',tmppath);
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update4.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&logo="+link1+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
							
						}
						else //invalid
						{
							document.getElementById('video').setCustomValidity('Upload valid display video .mp4, .ogg, .webm file');
						}
					}
					else //invalid
					{
						document.getElementById('video_alt').setCustomValidity('Upload valid display image .jpg, .jpeg, .png, .bmp file');
					}
				}
				else if(new_logo=="")  //logo not available
				{
					if(new_video_alt!="" && file_validate(new_video_alt)==true) //video alt available
					{
						if(new_video!="" && file_validate2(new_video)==true) //text video_alt and video available
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//video_alt
							var image2=document.getElementById('video_alt').files[0];
							var fd_image=new FormData();
							
							var link2='video_alt';
							fd_image.append(link2, image2);
							
							//video
							var image3=document.getElementById('video').files[0];
							var link3='video';
							fd_image.append(link3, image3);
							
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									
									var msg2='',i=0;
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg2=msg2+str[i];
									}
									i++;
									var msg3='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg3=msg3+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg2=='Ok' && msg3=='Ok')
									{
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										document.getElementById('syco_vvi_btn').style.display='block';
										document.getElementById('syco_vre_btn').style.display='block';
							
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update5.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&video_alt="+link2+"&video="+link3+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
							
						}
						else if(new_video=="") //only text with video_alt 
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//video_alt
							var image2=document.getElementById('video_alt').files[0];
							var fd_image=new FormData();
							
							var link2='video_alt';
							fd_image.append(link2, image2);
							
							
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									
									var msg2='',i=0;
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg2=msg2+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg2=='Ok')
									{
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update6.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&video_alt="+link2+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
						}
						else //invalid
						{
							document.getElementById('video').setCustomValidity('Upload valid display video .mp4, .ogg, .webm file');
						}
					}
					else if(new_video_alt=="") //video alt not available
					{
						if(new_video!="" && file_validate2(new_video)==true) //only text with video
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							var fd_image=new FormData();
							
							//video
							var image3=document.getElementById('video').files[0];
							var link3='video';
							fd_image.append(link3, image3);
							
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									
									
									var msg3='',i=0;
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg3=msg3+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg3=='Ok')
									{
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										document.getElementById('syco_vvi_btn').style.display='block';
										document.getElementById('syco_vre_btn').style.display='block';
							
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update7.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&video="+link3+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send(fd_image);
						}
						else if(new_video=="") //only text
						{
							document.getElementById('video').setCustomValidity('');
							document.getElementById('logo').setCustomValidity('');
							document.getElementById('video_alt').setCustomValidity('');
							document.getElementById('captcha_syco').setCustomValidity('');
							n_mobile.setCustomValidity('');
							
							document.getElementById('syco_loading').style.display='block';
				
							//Ajax for image upload
							var xhttp1 = new XMLHttpRequest();
							xhttp1.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								
									//response of 3
									var str=this.responseText.trim();
									//console.log(str);
									
									
									var msg3='',i=0;
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											msg3=msg3+str[i];
									}
									i++;
									var dat='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											dat=dat+str[i];
									}
									i++;
									var admin_name='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_name=admin_name+str[i];
									}
									i++;
									var admin_designation='';
									for(;i<str.length;i++)
									{
										if(str[i]=='@')
											break;
										else
											admin_designation=admin_designation+str[i];
									}
									
									
									//console.log(admin_name+' '+admin_designation);
									
									
									
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									
									
									if(msg3=='Ok')
									{
										
										document.getElementById('site_title').innerHTML=new_sycotitle;
										document.getElementById('site_title_link').innerHTML=new_sycotitle;
										document.getElementById('updated_on').value=dat;
										document.getElementById('updated_by').value=admin_name+', '+admin_designation;
										
										sycotitle=new_sycotitle;
										sycocaption=new_sycocaption;
										sycoaddress=new_sycoaddress;
										sycoemail=new_sycoemail;
										sycocontact_email=new_sycocontact_email;
										sycomap_link=new_sycomap_link;
										sycomobile=new_sycomobile;
										sycotelephone=new_sycotelephone;
										sycoweb=new_sycoweb;
										
										reset_system_components();
										document.getElementById('valid_msg').style.display='block';
										document.getElementById('v_msg').innerHTML='System components Successfully updated.';
										setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
										
									}
									else
									{
										reset_system_components();
										document.getElementById('invalid_msg').style.display='block';
										document.getElementById('i_msg').innerHTML='Unknown Error Occured.';
										setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
										
									}
									
									
								}
								else if(this.readyState==4 && (this.status==404 || this.status==403))
								{
									document.getElementById('syco_progress_id').style.width='0%';
									document.getElementById('syco_progress_id').innerHTML='0%';
									document.getElementById('syco_loading').style.display='none';
									reset_system_components();
									
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
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								  else
								  {
									 document.getElementById('syco_progress_id').style.width=percentComplete+'%';
									 document.getElementById('syco_progress_id').innerHTML= percentComplete+'%';
								  }
								}
							};
							xhttp1.open("POST", "../includes/super_admin/syco_update8.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&title="+new_sycotitle+"&caption="+new_sycocaption+"&address="+new_sycoaddress+"&web="+new_sycoweb+"&email="+new_sycoemail+"&contact_email="+new_sycocontact_email+"&map_link="+new_sycomap_link+"&telephone="+new_sycotelephone+"&mobile="+new_sycomobile, true);
							xhttp1.send();
						}
						else //invalid
						{
							document.getElementById('video').setCustomValidity('Upload valid display video .mp4, .ogg, .webm file');
						}
					}
					else //invalid
					{
						document.getElementById('video_alt').setCustomValidity('Upload valid display image .jpg, .jpeg, .png, .bmp file');
					}
				}
				else //invalid
				{
					document.getElementById('logo').setCustomValidity('Upload valid logo .jpg, .jpeg, .png, .bmp file');
				}
			}
		}
		
		function reset_system_components()
		{
			close_syco_window10();
			document.getElementById('title').value=sycotitle;
			document.getElementById('caption').value=sycocaption;
			document.getElementById('address').value=sycoaddress;
			document.getElementById('telephone').value=sycotelephone;
			document.getElementById('email').value=sycoemail;
			document.getElementById('mobile').value=sycomobile;
			document.getElementById('web').value=sycoweb;
			document.getElementById('contact_email').value=sycocontact_email;
			document.getElementById('map_link').value=sycomap_link;
			document.getElementById('logo').value='';
			document.getElementById('video_alt').value='';
			document.getElementById('video').value='';
			document.getElementById('captcha_syco').value='';
			
						
			document.getElementById("cl_msg").style.display='none';
			document.getElementById("cdi_msg").style.display='none';
			document.getElementById("cdv_msg").style.display='none';
			document.getElementById("up_syco_btn").disabled = true;
			
			document.getElementById('video').setCustomValidity('');
			document.getElementById('logo').setCustomValidity('');
			document.getElementById('video_alt').setCustomValidity('');
			document.getElementById('captcha_syco').setCustomValidity('');
			n_mobile.setCustomValidity('');
			
		}
		
		
	</script>

</form>