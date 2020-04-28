<?php
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location: index.php");
		die();
	}
	if($_SESSION['admin_type']!='Super Admin'){
		header("location: index.php");
		die();
	}
?>

<i onclick="pa15_topFunction()" id="pa15_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<!-- Confirmation modal for add multiple -->
<div id="admin_multiple_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the admins?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="admin_multiple_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="admin_multiple_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('admin_multiple_add_re_confirmation').style.display='none';document.getElementById('admin_multiple_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_admin_multiple_add_confirm = document.getElementById("admin_multiple_add_pass");
		function admin_multiple_add_pass_co_fu()
		{
			if(pass_admin_multiple_add_confirm.value.trim()!="")
			{
				pass_admin_multiple_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_admin_multiple_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_admin_multiple_add_confirm.onchange=admin_multiple_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add single-->
<div id="admin_single_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add the admin?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="admin_single_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="admin_single_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('admin_single_add_re_confirmation').style.display='none';document.getElementById('admin_single_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_admin_single_add_confirm = document.getElementById("admin_single_add_pass");
		function admin_single_add_pass_co_fu()
		{
			if(pass_admin_single_add_confirm.value.trim()!="")
			{
				pass_admin_single_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_admin_single_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_admin_single_add_confirm.onchange=admin_single_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for admin delete -->
<div id="admin_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove this admin?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="admin_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_admin_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_admin_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('admin_view_re_confirmation').style.display='none';document.getElementById('captcha_admin_view_confirm').value='';document.getElementById('admin_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_admin_view_confirm = document.getElementById("captcha_admin_view_confirm");
		var sol_admin_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_admin_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_admin_view_confirm.value != sol_admin_view_confirm) {
			reservation_captcha_admin_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_admin_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_admin_view_confirm.onchange=reservation_captcha_val_admin_view_confirm;
	
	
		var pass_admin_view_confirm = document.getElementById("admin_view_pass");
		function admin_view_pass_co_fu()
		{
			if(pass_admin_view_confirm.value.trim()!="")
			{
				pass_admin_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_admin_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_admin_view_confirm.onchange=admin_view_pass_co_fu;
		
	</script>
</div>

<div class="w3-container w3-margin-bottom w3-margin-top">
	
	<!-- Menu for admin add -->

	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Admin Member</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window15').style.display='block';document.getElementById('add_multiple_window15').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window15').style.display='block';document.getElementById('add_single_window15').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		
		<button onclick="get_admin_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
			
			
	</div>
	
	<!-- Window for add single admin -->

	<div id="add_single_window15" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window15_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:280px;"><i class="fa fa-plus"></i> Add Single Member</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="admin_single_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><i class="w3-text-red">*</i> <b>Admin Name</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="admin_single_add_name" placeholder="Enter admin Name" autocomplete="off" oninput="admin_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Admin Designation</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="admin_single_add_designation" placeholder="Enter admin Designation" autocomplete="off" oninput="admin_single_add_form_change()">
						
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><b>Admin Email</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting email you are giving the admin panel access. This admin can access all the features of admin panel through this email. He will get an one time link to set his password for the admin panel. He will get the access till inactive status or resign of his ID."></i> </label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" id="admin_single_add_email" placeholder="Enter admin Email" autocomplete="off" onchange="admin_single_add_form_change()">
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><b>admin Mobile</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="admin_single_add_mobile" placeholder="Enter admin Mobile" autocomplete="off" onchange="admin_single_add_form_change()">
							</div>
							
						</div>
						
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Join Date</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" id="admin_single_add_join_date" placeholder="Enter admin Join Date" autocomplete="off" onchange="admin_single_add_form_change()">
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><b>Resign Date</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting resign date you are confirming that admin resigned from NEUB and he will lose his access from admin panel."></i> </label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" id="admin_single_add_resign_date" placeholder="Enter admin Resign Date" autocomplete="off" onchange="admin_single_add_form_change()">
							</div>
						</div>
						
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:32%;">
								<label><i class="w3-text-red">*</i> <b>Department</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_single_add_dept" onchange="admin_single_add_form_change()">
									<option value="">Select</option>
									<?php
										$stmt = $conn->prepare("SELECT * FROM nr_department where nr_dept_status='Active' order by nr_dept_title asc");
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
								<label><i class="w3-text-red">*</i> <b>admin Type</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_single_add_type" onchange="admin_single_add_form_change()">
									<option value="">Select</option>
									<option value="Permanent">Permanent</option>
									<option value="Adjunct">Adjunct</option>
									<option value="Guest">Guest</option>
								</select>
							</div>
							<div class="w3-col" style="margin-left:2%;width:32%;">
								<label><i class="w3-text-red">*</i> <b>Gender</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_single_add_gender" onchange="admin_single_add_form_change()">
									<option value="">Select</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Other">Other</option>
								</select>
							</div>
							
						</div>
						<label><i class="w3-text-red">*</i> <b>Status</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_single_add_status" onchange="admin_single_add_form_change()">
							<option value="">Select</option>
							<option value="Active" class="w3-pale-green">Active</option>
							<option value="Inactive" class="w3-pale-red">Inactive</option>
						</select>
						<?php
							//spam Check 
							$aaa=rand(1,20);
							$bbb=rand(1,20);
							$ccc=$aaa+$bbb;
						?>
						
						<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:40%;">
								<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:58%;">
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="admin_single_add_captcha" autocomplete="off" onchange="admin_single_add_form_change()">
								<input type="hidden" value="<?php echo $ccc; ?>" id="admin_single_add_old_captcha">
							</div>
						</div>
						
						
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						
						<button onclick="admin_single_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button onclick="document.getElementById('admin_single_add_re_confirmation').style.display='block';" id="admin_single_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="admin_single_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>
	
	<!-- Window for add multiple admin -->

	<div id="add_multiple_window15" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window15_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:325px;"><i class="fa fa-plus"></i> Add Multiple Members</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="admin_multiple_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_admin.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>Input date according to the format <b>YYYY-MM-DD</b>. Inserting email will give the access of the admin panel. Photo is uploadable from the admin panel only.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. Don't forget to select a department in the below form. You can insert at most <b>50 admin members</b> in a single upload under a single department.</li>
					<li>This process may take <b>up to three minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<label><i class="w3-text-red">*</i> <b>admin Department</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="admin_multiple_add_dept" onchange="admin_multiple_add_form_change()">
						<option value="">Select</option>
						<?php
							$stmt = $conn->prepare("SELECT * FROM nr_department where nr_dept_status='Active' order by nr_dept_title asc");
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
					
					<label><i class="w3-text-red">*</i> <b>Upload Excel File</b></label>
					<input class="w3-input w3-border w3-round-large" type="file" id="admin_excel_file" title="Please upload the formatted and filled up excel file."  onchange="admin_multiple_add_form_change()">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="admin_multiple_add_captcha" autocomplete="off" onkeyup="admin_multiple_add_form_change()">
							<input type="hidden" value="<?php echo $ccc; ?>" id="admin_multiple_add_old_captcha">
						</div>
					</div>
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:10px 0px 0px 6px;">
					
					<button onclick="admin_multiple_add_form_clear()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
					</br>	
					<button onclick="document.getElementById('admin_multiple_add_re_confirmation').style.display='block';" id="admin_multiple_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
				</div>
			</div>
			
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="admin_multiple_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="admin_multiple_progress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="admin_multiple_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('admin_multiple_add_box1').style.display='block';document.getElementById('admin_multiple_add_box15').style.display='none';document.getElementById('admin_multiple_add_box3').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="admin_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="admin_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="admin_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="admin_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- window for delete history -->
	<div id="admin_delete_history_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="admin_delete_history_window_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:325px;"><i class="fa fa-history"></i> Admin Remove History</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="admin_delete_history_window_box">
			
		</div>
	</div>
	
	<!-- Search box -->

	<div class="w3-container" style="margin: 2px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text15" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_15').style.display='inline-block'; } else { document.getElementById('search_clear_btn_15').style.display='none'; } get_search_result15();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Admin Name or Designation for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_15" title="Clear search box" onclick="document.getElementById('search_text15').value=''; document.getElementById('search_clear_btn_15').style.display='none';get_search_result15();"></i>
		</div>
	</div>
	
	<!-- Wndow for view result -->

	<div id="search_window15" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box15()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:220px;"><i class="fa fa-eye"></i> Admin Details</p>
		<div id="search_window_details15" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	

	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:245px;"><i class="fa fa-server"></i> Admin Members</p>
	
	<!-- sort options for admin list -->
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort15" onchange="get_total_search_results15(0,0)" type="w3-input w3-round-large">
				<option value="1">Name ASC</option>
				<option value="2">Name DESC</option>
				<option value="3">Designation ASC</option>
				<option value="4">Designation DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter15').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
		
	<!-- filter for admin list -->
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter15" style="display:none;">
		Status: 
		<select id="filter_status15" onchange="get_total_search_results15(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Active</option>
			<option value="2">Inactive</option>
			
		</select>
		
		&nbsp; Admin Type: 
		<select id="filter_type15" onchange="get_total_search_results15(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="Moderator">Moderator</option>
			<option value="Admin">Admin</option>
			<option value="Super Admin">Super Admin</option>
			
		</select>
		
		<span onclick="document.getElementById('filter15').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
	</div>
	
	<div class="w3-clear"></div>
	
	<!-- table for admin list -->
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label15"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:9%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:29%;" valign="top" class="w3-padding-small">Admin Name</td>
			<td style="width:20%;" valign="top" class="w3-padding-small">Designation</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Type</td>
			<td style="width:14%;" valign="top" class="w3-padding-small">Join Date</td>
			<td style="width:16%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables15">
		
		
		</tbody>
		<tr id="search_results_loading15" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result15" onclick="get_total_search_results15(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>

	function admin_delete_history_window_close()
	{
		document.getElementById('admin_delete_history_window_box').innerHTML='';
		document.getElementById('admin_delete_history_window').style.display='none';
	}
	
	function get_admin_delete_history()
	{
		document.getElementById('admin_delete_history_window').style.display='block';
		document.getElementById('admin_delete_history_window_box').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var xhttp1 = new XMLHttpRequest();
		xhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('admin_delete_history_window_box').innerHTML=this.responseText;
			}
			else if(this.readyState==4 && (this.status==404 || this.status==403))
			{
				admin_delete_history_window_close();
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Network error occurred.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
		};
		xhttp1.open("POST", "../includes/super_admin/get_admin_delete_history.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>, true);
		xhttp1.send();
	}
	
	function add_multiple_window15_close()
	{
		document.getElementById('admin_multiple_add_box1').style.display='block';
		document.getElementById('admin_multiple_add_box2').style.display='none';
		document.getElementById('admin_multiple_add_box3').style.display='none';
		document.getElementById('admin_multiple_add_captcha').value='';
		document.getElementById('admin_excel_file').value='';
		
		document.getElementById('admin_multiple_total').innerHTML='';
		document.getElementById('admin_multiple_success').innerHTML='';
		document.getElementById('admin_multiple_failed').innerHTML='';
		document.getElementById('admin_multiple_logs').innerHTML='';
			
		document.getElementById("admin_multiple_add_save_btn").disabled = true;
		document.getElementById('add_multiple_window15').style.display='none';
	
	}
	
	function admin_multiple_add_form_change()
	{
		var admin_excel_file=document.getElementById('admin_excel_file').value;
		var admin_multiple_add_dept=document.getElementById('admin_multiple_add_dept').value;
		
		if(admin_excel_file=="" || admin_multiple_add_dept=="")
		{
			document.getElementById("admin_multiple_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("admin_multiple_add_save_btn").disabled = false;
		}
	}

	function admin_multiple_add_form_clear()
	{
		document.getElementById('admin_multiple_add_captcha').value='';
		document.getElementById('admin_excel_file').value='';
		document.getElementById('admin_multiple_add_dept').value='';
						
		document.getElementById("admin_multiple_add_save_btn").disabled = true;
		
	}

	function add_single_window15_close()
	{
		document.getElementById('admin_single_add_box1').style.display='block';
		document.getElementById('admin_single_add_box2').style.display='none';
			
		document.getElementById('admin_single_add_name').value='';
		document.getElementById('admin_single_add_designation').value='';
		document.getElementById('admin_single_add_email').value='';
		document.getElementById('admin_single_add_mobile').value='';
		document.getElementById('admin_single_add_join_date').value='';
		document.getElementById('admin_single_add_resign_date').value='';
		document.getElementById('admin_single_add_dept').value='';
		document.getElementById('admin_single_add_type').value='';
		document.getElementById('admin_single_add_gender').value='';
		document.getElementById('admin_single_add_captcha').value='';
		document.getElementById('admin_single_add_status').value='';
		var admin_single_add_status=document.getElementById('admin_single_add_status').value.trim();
		
		
		
		if(admin_single_add_status=='Active')
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_single_add_status').classList.add('w3-pale-green');
		}
		else if(admin_single_add_status=='Inactive')
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		document.getElementById('add_single_window15').style.display='none';
		
		document.getElementById("admin_single_add_save_btn").disabled = true;
		
	}
	
	function admin_single_add_form_change()
	{
		var admin_single_add_name=document.getElementById('admin_single_add_name').value.trim();
		var admin_single_add_designation=document.getElementById('admin_single_add_designation').value.trim();
		var admin_single_add_email=document.getElementById('admin_single_add_email').value.trim();
		var admin_single_add_mobile=document.getElementById('admin_single_add_mobile').value.trim();
		var admin_single_add_join_date=document.getElementById('admin_single_add_join_date').value.trim();
		var admin_single_add_resign_date=document.getElementById('admin_single_add_resign_date').value.trim();
		var admin_single_add_dept=document.getElementById('admin_single_add_dept').value.trim();
		var admin_single_add_type=document.getElementById('admin_single_add_type').value.trim();
		var admin_single_add_gender=document.getElementById('admin_single_add_gender').value.trim();
		var admin_single_add_captcha=document.getElementById('admin_single_add_captcha').value.trim();
		var admin_single_add_status=document.getElementById('admin_single_add_status').value.trim();
		
		if(admin_single_add_status=='Active')
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_single_add_status').classList.add('w3-pale-green');
		}
		else if(admin_single_add_status=='Inactive')
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
		}
		if(admin_single_add_name=="" || admin_single_add_designation=="" || admin_single_add_join_date=="" || admin_single_add_dept=="" || admin_single_add_type=="" || admin_single_add_gender=="" || admin_single_add_status=="")
		{
			document.getElementById("admin_single_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("admin_single_add_save_btn").disabled = false;
		}
	}

	function admin_single_add_form_reset()
	{
		document.getElementById('admin_single_add_name').value='';
		document.getElementById('admin_single_add_designation').value='';
		document.getElementById('admin_single_add_email').value='';
		document.getElementById('admin_single_add_mobile').value='';
		document.getElementById('admin_single_add_join_date').value='';
		document.getElementById('admin_single_add_resign_date').value='';
		document.getElementById('admin_single_add_dept').value='';
		document.getElementById('admin_single_add_type').value='';
		document.getElementById('admin_single_add_gender').value='';
		document.getElementById('admin_single_add_captcha').value='';
		document.getElementById('admin_single_add_status').value='';
		var admin_single_add_status=document.getElementById('admin_single_add_status').value.trim();
		
		
		
		if(admin_single_add_status=='Active')
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_single_add_status').classList.add('w3-pale-green');
		}
		else if(admin_single_add_status=='Inactive')
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		
		document.getElementById("admin_single_add_save_btn").disabled = true;
		
	}
	
	function admin_multiple_add_form_save()
	{
		var admin_excel_file=document.getElementById('admin_excel_file').value;
		var admin_multiple_add_dept=document.getElementById('admin_multiple_add_dept').value;
		admin_view_captcha=document.getElementById('admin_multiple_add_captcha').value.trim();
		admin_view_old_captcha=document.getElementById('admin_multiple_add_old_captcha').value.trim();
		
		if(admin_excel_file=="" || admin_multiple_add_dept=="" || file_validate3(admin_excel_file)==false)
		{
			document.getElementById('admin_multiple_add_pass').value='';
			
			document.getElementById('admin_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById("admin_multiple_add_save_btn").disabled = true;
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload the required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
	
		}
		else if(admin_view_captcha=="" || admin_view_captcha!=admin_view_old_captcha)
		{
			document.getElementById('admin_multiple_add_pass').value='';
			
			document.getElementById('admin_multiple_add_re_confirmation').style.display='none';
		
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(admin_multiple_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('admin_multiple_add_pass').value.trim();
			
			document.getElementById('admin_multiple_add_pass').value='';
			
			document.getElementById('admin_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('admin_multiple_add_box1').style.display='none';
			document.getElementById('admin_multiple_add_box3').style.display='none';
			document.getElementById('admin_multiple_add_box2').style.display='block';
			
			document.getElementById('admin_multiple_total').innerHTML='';
			document.getElementById('admin_multiple_success').innerHTML='';
			document.getElementById('admin_multiple_failed').innerHTML='';
			document.getElementById('admin_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('admin_excel_file').files[0];
			var fd_excel=new FormData();
			var link='admin_excel_file';
			fd_excel.append(link, excel_file);
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var str=this.responseText.trim();
					
					
					var status=str[0]+str[1];
					
					if(status=='Ok')
					{
						var success='',i=3;
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								success=success+str[i];
						}
						i++;
						var failed='';
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								failed=failed+str[i];
						}
						i++;
						var total='';
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								total=total+str[i];
						}
						i++;
						var logs='';
						for(;i<str.length;i++)
						{
							if(str[i]=='@')
								break;
							else
								logs=logs+str[i];
						}
						
						
						document.getElementById('admin_multiple_progress_id').style.width='0%';
						document.getElementById('admin_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('admin_multiple_add_box1').style.display='none';
						document.getElementById('admin_multiple_add_box3').style.display='block';
						document.getElementById('admin_multiple_add_box2').style.display='none';
				
						document.getElementById('admin_multiple_total').innerHTML=total;
						document.getElementById('admin_multiple_success').innerHTML=success;
						document.getElementById('admin_multiple_failed').innerHTML=failed;
						document.getElementById('admin_multiple_logs').innerHTML=logs;
			
						admin_multiple_add_form_clear();
						get_total_search_results15(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('admin_multiple_progress_id').style.width='0%';
						document.getElementById('admin_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('admin_multiple_add_box1').style.display='block';
						document.getElementById('admin_multiple_add_box3').style.display='none';
						document.getElementById('admin_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u2')
					{
						document.getElementById('admin_multiple_progress_id').style.width='0%';
						document.getElementById('admin_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('admin_multiple_add_box1').style.display='block';
						document.getElementById('admin_multiple_add_box3').style.display='none';
						document.getElementById('admin_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (Department Inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('admin_multiple_progress_id').style.width='0%';
						document.getElementById('admin_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('admin_multiple_add_box1').style.display='block';
						document.getElementById('admin_multiple_add_box3').style.display='none';
						document.getElementById('admin_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('admin_multiple_progress_id').style.width='0%';
					document.getElementById('admin_multiple_progress_id').innerHTML='0%';
					
					document.getElementById('admin_multiple_add_box1').style.display='block';
					document.getElementById('admin_multiple_add_box3').style.display='none';
					document.getElementById('admin_multiple_add_box2').style.display='none';
			
					
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
					 document.getElementById('admin_multiple_progress_id').style.width=percentComplete+'%';
					 document.getElementById('admin_multiple_progress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('admin_multiple_progress_id').style.width=percentComplete+'%';
					 document.getElementById('admin_multiple_progress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_admins.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass+"&admin_dept="+admin_multiple_add_dept, true);
			xhttp1.send(fd_excel);
		}
	}

	
	function admin_single_add_form_save()
	{
		var admin_single_add_name=document.getElementById('admin_single_add_name').value.trim();
		var admin_single_add_designation=document.getElementById('admin_single_add_designation').value.trim();
		var admin_single_add_email=document.getElementById('admin_single_add_email').value.trim();
		var admin_single_add_mobile=document.getElementById('admin_single_add_mobile').value.trim();
		var admin_single_add_join_date=document.getElementById('admin_single_add_join_date').value.trim();
		var admin_single_add_resign_date=document.getElementById('admin_single_add_resign_date').value.trim();
		var admin_single_add_dept=document.getElementById('admin_single_add_dept').value.trim();
		var admin_single_add_type=document.getElementById('admin_single_add_type').value.trim();
		var admin_single_add_gender=document.getElementById('admin_single_add_gender').value.trim();
		var admin_single_add_captcha=document.getElementById('admin_single_add_captcha').value.trim();
		var admin_single_add_old_captcha=document.getElementById('admin_single_add_old_captcha').value.trim();
		var admin_single_add_status=document.getElementById('admin_single_add_status').value.trim();
		
		if(admin_single_add_name=="" || admin_single_add_designation=="" || admin_single_add_join_date=="" || admin_single_add_dept=="" || admin_single_add_type=="" || admin_single_add_gender=="" || admin_single_add_status=="")
		{
			document.getElementById('admin_single_add_pass').value='';
			
			document.getElementById('admin_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(admin_single_add_captcha=="" || admin_single_add_captcha!=admin_single_add_old_captcha)
		{
			document.getElementById('admin_single_add_pass').value='';
			
			document.getElementById('admin_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(admin_single_add_pass_co_fu()==true)
		{
			
			
			var pass=document.getElementById('admin_single_add_pass').value.trim();
			
			document.getElementById('admin_single_add_pass').value='';
			
			document.getElementById('admin_single_add_re_confirmation').style.display='none';
			
			
			document.getElementById('admin_single_add_box1').style.display='none';
			document.getElementById('admin_single_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						add_single_window15_close();
						
						get_search_result15();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='admin successfully added.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('admin_single_add_box1').style.display='block';
						document.getElementById('admin_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('admin_single_add_box1').style.display='block';
						document.getElementById('admin_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this admin (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('admin_single_add_box1').style.display='block';
						document.getElementById('admin_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this admin (department inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable3')
					{
						document.getElementById('admin_single_add_box1').style.display='block';
						document.getElementById('admin_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this admin (invalid email).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('admin_single_add_box1').style.display='block';
						document.getElementById('admin_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('admin_single_add_box1').style.display='block';
					document.getElementById('admin_single_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_admin.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&admin_name="+admin_single_add_name+"&admin_designation="+admin_single_add_designation+"&admin_status="+admin_single_add_status+"&admin_email="+admin_single_add_email+"&admin_mobile="+admin_single_add_mobile+"&admin_join_date="+admin_single_add_join_date+"&admin_resign_date="+admin_single_add_resign_date+"&admin_dept="+admin_single_add_dept+"&admin_type="+admin_single_add_type+"&admin_gender="+admin_single_add_gender, true);
			xhttp1.send();
		}
	
	}
	
	
	var admin_view_old_name;
	var admin_view_old_email;
	var admin_view_old_mobile;
	var admin_view_old_dept;
	var admin_view_old_type;
	var admin_view_old_gender;
	var admin_view_old_join_date;
	var admin_view_old_resign_date
	var admin_view_old_designation;
	var admin_view_old_captcha;
	var admin_view_old_status;
	
	var admin_view_name;
	var admin_view_email;
	var admin_view_mobile;
	var admin_view_dept;
	var admin_view_type;
	var admin_view_gender;
	var admin_view_join_date;
	var admin_view_resign_date
	var admin_view_designation;
	var admin_view_captcha;
	var admin_view_status;
	
	function remove_admin_view()
	{
		var pass=document.getElementById('admin_view_pass').value.trim();
		if(reservation_captcha_val_admin_view_confirm()==true && admin_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_admin_view_confirm').value='';
			document.getElementById('admin_view_pass').value='';
			
			document.getElementById('admin_view_re_confirmation').style.display='none';
			
			var admin_id=document.getElementById('admin_view_id').value.trim();
			
			document.getElementById('admin_view_box1').style.display='none';
			document.getElementById('admin_view_box3').style.display='none';
			document.getElementById('admin_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						get_search_result15();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Admin successfully removed.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('admin_view_box1').style.display='block';
						document.getElementById('admin_view_box2').style.display='none';
						document.getElementById('admin_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('admin_view_box1').style.display='block';
						document.getElementById('admin_view_box3').style.display='none';
						document.getElementById('admin_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to remove this admin.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('admin_view_box1').style.display='block';
						document.getElementById('admin_view_box2').style.display='none';
						document.getElementById('admin_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('admin_view_box1').style.display='block';
					document.getElementById('admin_view_box2').style.display='none';
					document.getElementById('admin_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_admin.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&admin_member_id="+admin_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function admin_view_form_change()
	{
		admin_view_name=document.getElementById('admin_view_name').value.trim();
		admin_view_designation=document.getElementById('admin_view_designation').value.trim();
		admin_view_email=document.getElementById('admin_view_email').value.trim();
		admin_view_mobile=document.getElementById('admin_view_mobile').value.trim();
		admin_view_join_date=document.getElementById('admin_view_join_date').value.trim();
		admin_view_resign_date=document.getElementById('admin_view_resign_date').value.trim();
		admin_view_type=document.getElementById('admin_view_type').value.trim();
		admin_view_gender=document.getElementById('admin_view_gender').value.trim();
		admin_view_captcha=document.getElementById('admin_view_captcha').value.trim();
		admin_view_status=document.getElementById('admin_view_status').value.trim();
		
		admin_view_old_name=document.getElementById('admin_view_old_name').value.trim();
		admin_view_old_designation=document.getElementById('admin_view_old_designation').value.trim();
		admin_view_old_email=document.getElementById('admin_view_old_email').value.trim();
		admin_view_old_mobile=document.getElementById('admin_view_old_mobile').value.trim();
		admin_view_old_join_date=document.getElementById('admin_view_old_join_date').value.trim();
		admin_view_old_resign_date=document.getElementById('admin_view_old_resign_date').value.trim();
		admin_view_old_type=document.getElementById('admin_view_old_type').value.trim();
		admin_view_old_gender=document.getElementById('admin_view_old_gender').value.trim();
		admin_view_old_captcha=document.getElementById('admin_view_old_captcha').value.trim();
		admin_view_old_status=document.getElementById('admin_view_old_status').value.trim();
		
		if(admin_view_status=='Active')
		{
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_view_status').classList.add('w3-pale-red');
		}
		
		if(admin_view_name=="" || admin_view_designation=="" || admin_view_status=="" || admin_view_join_date=="" || admin_view_type=="" || admin_view_gender=="" || (admin_view_name==admin_view_old_name && admin_view_designation==admin_view_old_designation && admin_view_status==admin_view_old_status && admin_view_join_date==admin_view_old_join_date && admin_view_type==admin_view_old_type && admin_view_gender==admin_view_old_gender && admin_view_email==admin_view_old_email && admin_view_mobile==admin_view_old_mobile && admin_view_resign_date==admin_view_old_resign_date))
		{
			document.getElementById("admin_view_save_btn").disabled = true;
		}
		else if(admin_view_resign_date!=admin_view_old_resign_date || admin_view_mobile!=admin_view_old_mobile || admin_view_email!=admin_view_old_email || admin_view_name!=admin_view_old_name || admin_view_designation!=admin_view_old_designation || admin_view_status!=admin_view_old_status || admin_view_join_date!=admin_view_old_join_date || admin_view_type!=admin_view_old_type || admin_view_gender!=admin_view_old_gender)
		{
			document.getElementById("admin_view_save_btn").disabled = false;
		}
	}
	
	function admin_view_form_reset()
	{
		admin_view_old_name=document.getElementById('admin_view_old_name').value.trim();
		admin_view_old_designation=document.getElementById('admin_view_old_designation').value.trim();
		admin_view_old_email=document.getElementById('admin_view_old_email').value.trim();
		admin_view_old_mobile=document.getElementById('admin_view_old_mobile').value.trim();
		admin_view_old_join_date=document.getElementById('admin_view_old_join_date').value.trim();
		admin_view_old_resign_date=document.getElementById('admin_view_old_resign_date').value.trim();
		admin_view_old_type=document.getElementById('admin_view_old_type').value.trim();
		admin_view_old_gender=document.getElementById('admin_view_old_gender').value.trim();
		admin_view_old_captcha=document.getElementById('admin_view_old_captcha').value.trim();
		admin_view_old_status=document.getElementById('admin_view_old_status').value.trim();
		
		document.getElementById('admin_view_name').value=admin_view_old_name;
		document.getElementById('admin_view_type').value=admin_view_old_type;
		document.getElementById('admin_view_gender').value=admin_view_old_gender;
		document.getElementById('admin_view_designation').value=admin_view_old_designation;
		document.getElementById('admin_view_email').value=admin_view_old_email;
		document.getElementById('admin_view_mobile').value=admin_view_old_mobile;
		document.getElementById('admin_view_join_date').value=admin_view_old_join_date;
		document.getElementById('admin_view_resign_date').value=admin_view_old_resign_date;
		document.getElementById('admin_view_captcha').value='';
		document.getElementById('admin_view_status').value=admin_view_old_status;
		
		admin_view_status=document.getElementById('admin_view_status').value.trim();
		
		if(admin_view_status=='Active')
		{
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('admin_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('admin_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('admin_view_status').classList.add('w3-pale-red');
		}
		
		document.getElementById("admin_view_save_btn").disabled = true;
	}
	
	function admin_view_form_save_changes(admin_id)
	{
		admin_view_name=document.getElementById('admin_view_name').value.trim();
		admin_view_designation=document.getElementById('admin_view_designation').value.trim();
		admin_view_email=document.getElementById('admin_view_email').value.trim();
		admin_view_mobile=document.getElementById('admin_view_mobile').value.trim();
		admin_view_join_date=document.getElementById('admin_view_join_date').value.trim();
		admin_view_resign_date=document.getElementById('admin_view_resign_date').value.trim();
		admin_view_type=document.getElementById('admin_view_type').value.trim();
		admin_view_gender=document.getElementById('admin_view_gender').value.trim();
		admin_view_captcha=document.getElementById('admin_view_captcha').value.trim();
		admin_view_status=document.getElementById('admin_view_status').value.trim();
		
		admin_view_old_name=document.getElementById('admin_view_old_name').value.trim();
		admin_view_old_designation=document.getElementById('admin_view_old_designation').value.trim();
		admin_view_old_email=document.getElementById('admin_view_old_email').value.trim();
		admin_view_old_mobile=document.getElementById('admin_view_old_mobile').value.trim();
		admin_view_old_join_date=document.getElementById('admin_view_old_join_date').value.trim();
		admin_view_old_resign_date=document.getElementById('admin_view_old_resign_date').value.trim();
		admin_view_old_type=document.getElementById('admin_view_old_type').value.trim();
		admin_view_old_gender=document.getElementById('admin_view_old_gender').value.trim();
		admin_view_old_captcha=document.getElementById('admin_view_old_captcha').value.trim();
		admin_view_old_status=document.getElementById('admin_view_old_status').value.trim();
		
		
		if(admin_view_name=="" || admin_view_designation=="" || admin_view_status=="" || admin_view_join_date=="" || admin_view_type=="" || admin_view_gender=="")
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(admin_view_captcha=="" || admin_view_captcha!=admin_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(admin_view_mobile!="" && check_mobile_no(admin_view_mobile)==false)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid mobile no.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
		}
		else
		{
			document.getElementById('admin_view_box1').style.display='none';
			document.getElementById('admin_view_box3').style.display='none';
			document.getElementById('admin_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText.trim());
					if(this.responseText.trim()=='Ok')
					{
						close_search_box15();
						view_result15(admin_id);
						
						get_total_search_results15(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('admin_view_box1').style.display='block';
						document.getElementById('admin_view_box2').style.display='none';
						document.getElementById('admin_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('admin_view_box1').style.display='block';
						document.getElementById('admin_view_box2').style.display='none';
						document.getElementById('admin_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (Invalid Email).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('admin_view_box1').style.display='block';
						document.getElementById('admin_view_box2').style.display='none';
						document.getElementById('admin_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('admin_view_box1').style.display='block';
					document.getElementById('admin_view_box2').style.display='none';
					document.getElementById('admin_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_admin.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&admin_name="+admin_view_name+"&admin_designation="+admin_view_designation+"&admin_email="+admin_view_email+"&admin_mobile="+admin_view_mobile+"&admin_join_date="+admin_view_join_date+"&admin_resign_date="+admin_view_resign_date+"&admin_type="+admin_view_type+"&admin_gender="+admin_view_gender+"&admin_status="+admin_view_status+"&admin_member_id="+admin_id, true);
			xhttp1.send();
		}
		
	}
	
	function get_search_result15()
	{
		close_search_box15();
		get_total_search_results15(0,0);
	}
	
	function view_result15(admin_id)
	{
		
		document.getElementById('search_window15').style.display='block';
		var page15=document.getElementById('page15');
		page15.scrollTop = 20;
		document.getElementById('search_window_details15').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details15').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details15').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results15.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&admin_member_id="+admin_id, true);
		search_window_result.send();
		
		
	}
	
	function close_search_box15()
	{
		document.getElementById('search_window_details15').innerHTML='';
		document.getElementById('search_window15').style.display='none';
	}
	
	
	var page15=0,total15;
	function get_total_search_results15(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading15").innerHTML='<td colspan="6"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort15').value;
		var search_text=document.getElementById('search_text15').value.trim();
		var filter_status15=document.getElementById('filter_status15').value.trim();
		var filter_type15=document.getElementById('filter_type15').value.trim();
		
		
		var total15_results = new XMLHttpRequest();
		total15_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total15=parseInt(this.responseText.trim());
				get_search_results15(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total15=0;
				get_search_results15(x,y);
			}
		};
		document.getElementById('search_data_label15').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total15_results.open("GET", "../includes/super_admin/get_total_search_results15.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&filter_status15="+filter_status15+"&filter_type15="+filter_type15, true);
		total15_results.send();
		
	}
	
	function get_search_results15(x,y)
	{
		if(x==0)
		{
			page15=0;
			document.getElementById('search_result_tables15').innerHTML='';
		}
		if(total15!=0)
		{
			var r_sort=document.getElementById('search_result_sort15').value;
			var search_text=document.getElementById('search_text15').value.trim();
			var filter_status15=document.getElementById('filter_status15').value.trim();
			var filter_type15=document.getElementById('filter_type15').value.trim();
			
		
			document.getElementById("show_more_btn_search_result15").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading15").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables15').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables15').innerHTML=document.getElementById('search_result_tables15').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label15').innerHTML=total15;
					
					if(total15>page15)
					{
						document.getElementById("show_more_btn_search_result15").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label15').innerHTML='N/A';
					document.getElementById("search_results_loading15").innerHTML = '<td colspan="6"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page15;
			page15=page15+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results15.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&filter_status15="+filter_status15+"&filter_type15="+filter_type15, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading15").innerHTML='';
			document.getElementById('search_data_label15').innerHTML='N/A';
			document.getElementById('search_result_tables15').innerHTML='<tr><td colspan="6"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result15").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa15_btn = document.getElementById("pa15_btn");
	var pa15=document.getElementById('page15');
	// When the user scrolls down 20px from the top of the document, show the button
	pa15.onscroll = function() {pa15_scrollFunction()};

	function pa15_scrollFunction() {
	  if (pa15.scrollTop > 20) {
		pa15_btn.style.display = "block";
	  } else {
		pa15_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa15_topFunction() {
	  pa15.scrollTop = 0;
	}
	
	
	get_search_result15();
	

</script>