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
		
		$logo='logo.png';
		$video_alt='video_alt.jpg';
		$video='welcome.mp4';
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
		$updated_by=$result[0][14];
		$designation=$result[0][20];
		$logo='logo.png';
		$video_alt='video_alt.jpg';
		$video='welcome.mp4';
	}
	
?>

<form onsubmit="return false">
	<p class="w3-text-red w3-small w3-bold" style="margin: 12px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
	<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:50%;padding:0px 6px 14px 0px;">
				<label><i class="w3-text-red">*</i> <b>Web Title</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $title; ?>" id="title" placeholder="Enter Web Title" autocomplete="off" required>
				
				<label><b>Web Display Caption</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $caption; ?>" id="caption" placeholder="Enter Web Display caption" autocomplete="off" >
			  
				<label><i class="w3-text-red">*</i> <b>University Address</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $address; ?>" id="address" placeholder="Enter University Address" autocomplete="off" required>
				
				
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
						<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_syco" autocomplete="off" required>
					</div>
				</div>
					
				
			</div>
			<div class="w3-col w3-margin-0" style="width:50%;padding:0px 0px 14px 6px;">
				<button onclick="reset_system_components()" class="w3-button w3-red w3-right w3-hover-teal w3-round-large w3-margin-left"><i class="fa fa-eye-slash"></i> Reset</button>
				<button id="up_syco_btn" onclick="update_system_components()" class="w3-button w3-black w3-right w3-hover-teal w3-round-large" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				<div class="w3-clear" style="margin-bottom: 23px;"></div>
				<label><b>Change Logo</b></label>
				<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('cl_msg').style.display='block'" type="file" id="logo" title="Please upload LOGO (204X180)px"  onchange="syco_form_change()">
				<i class="w3-text-red w3-small w3-bold" id="cl_msg" style="display: none;">*Upload DP with (120X100)px</i>
				
				<label class="w3-margin-top" style="display:inline-block;"><b>Change Display Image</b></label>
				<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('cdi_msg').style.display='block'" type="file" id="video_alt" title="Please upload Dispaly Image (450X1326)px"  onchange="syco_form_change()">
				<i class="w3-text-red w3-small w3-bold" id="cdi_msg" style="display: none;">*Upload Display Image with (450X1326)px</i>
				
				<label class="w3-margin-top" style="display:inline-block;"><b>Change Display Video</b></label>
				<input class="w3-input w3-border w3-round-large" onclick="document.getElementById('cdv_msg').style.display='block'" type="file" id="welcome" title="Please upload Dispaly Video (450X1326)px"  onchange="syco_form_change()">
				<i class="w3-text-red w3-small w3-bold" id="cdv_msg" style="display: none;">*Upload Display Video with (450X1326)px</i>
				
				
			</div>
		</div>
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
				<label><i class="w3-text-red">*</i> <b>Website Link</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $web; ?>" id="web" placeholder="Enter Website Link" autocomplete="off" required>
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Contact Email</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $contact_email; ?>" id="contact_email" placeholder="Enter Contact Email" autocomplete="off" required>
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 0px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Google Map Link</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $map_link; ?>" id="map_link" placeholder="Enter Google Map Link" autocomplete="off" required>
			</div>
		</div>
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
				<label><i class="w3-text-red">*</i> <b>Telephone</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $telephone; ?>" id="telephone" placeholder="Enter Telephone No." autocomplete="off" required>
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Web Email</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $email; ?>" id="email" placeholder="Enter Display Email" autocomplete="off" required>
			</div>
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 0px 0px 6px;">
				<label><i class="w3-text-red">*</i> <b>Cell No</b></label>
				<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $mobile; ?>" id="mobile" placeholder="Enter Mobile No." autocomplete="off" required>
			</div>
		</div>
		
		<div class="w3-row w3-margin-0 w3-padding-0">
			<div class="w3-col w3-margin-0" style="width:33.33%;padding:0px 6px 0px 0px;">
				<label><b>Updated On</b></label>
				<input class="w3-input w3-text-brown w3-bold w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $date; ?>" disabled>
			</div>
			<div class="w3-col w3-margin-0" style="width:66.67%;padding:0px 0px 0px 6px;">
				<label><b>Updated By</b></label>
				<input class="w3-input w3-text-brown w3-bold w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $updated_by.', '.$designation; ?>" disabled>
			</div>
			
		</div>
		
	</div>
</form>



<script>
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



</script>
