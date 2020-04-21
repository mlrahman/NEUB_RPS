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
	if(isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		
		$fl=0; $fl1=0;
		//checking if dept is delete able or not
		$stmt = $conn->prepare("select * from nr_faculty where nr_dept_id=:dept_id");
		$stmt->bindParam(':dept_id', $dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl=1;
		}
		
		//checking if dept is delete able or not
		$stmt = $conn->prepare("select * from nr_program where nr_dept_id=:dept_id");
		$stmt->bindParam(':dept_id', $dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl1=1;
		}
		
		$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:dept_id");
		$stmt->bindParam(':dept_id', $dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$dept_title=$result[0][1];
		$dept_code=$result[0][2];
		$status=$result[0][3];
		
?>
	<div class="w3-container w3-margin-0 w3-padding-0" id="dept_view_box1">
		<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
		<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
					<label><i class="w3-text-red">*</i> <b>Department Title</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $dept_title; ?>" id="dept_view_title" placeholder="Enter Department Title" autocomplete="off" onkeyup="dept_view_form_change()">
					<input type="hidden" value="<?php echo $dept_title; ?>" id="dept_view_old_title">
					
					<label><i class="w3-text-red">*</i> <b>Department Code</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $dept_code; ?>" id="dept_view_code" placeholder="Enter Department Code" autocomplete="off" onkeyup="dept_view_form_change()">
					<input type="hidden" value="<?php echo $dept_code; ?>" id="dept_view_old_code">
					
					<label><i class="w3-text-red">*</i> <b>Status</b></label>
					<?php
						if($status=='Active') 
						{
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="dept_view_status" onchange="dept_view_form_change()">
								<option value="Active" class="w3-pale-green">Active</option>
								<option value="Inactive" class="w3-pale-red">Inactive</option>
							</select>
					<?php
						} else {
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="dept_view_status" onchange="dept_view_form_change()">
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
					<input type="hidden" value="<?php echo $status; ?>" id="dept_view_old_status">
					<input type="hidden" value="<?php echo $ccc; ?>" id="dept_view_old_captcha">
					<input type="hidden" value="<?php echo $dept_id; ?>" id="dept_view_id">
					
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="dept_view_captcha" autocomplete="off" onkeyup="dept_view_form_change()">
						</div>
					</div>
					
					
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<button onclick="dept_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Reset</button>
					
					<button onclick="document.getElementById('dept_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($fl==1 || $fl1==1){ echo 'title="Sorry you can not delete it." disabled'; } ?>><i class="fa fa-eraser"></i> Remove</button>
				
					<button onclick="dept_view_form_save_changes('<?php echo $dept_id; ?>')" id="dept_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="dept_view_box2" style="display:none;">
		<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
		<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
	
	</div>
<?php		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>