<?php
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location: index.php");
		die();
	}
?>

<i onclick="pa5_topFunction()" id="pa5_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
	<i class="fa fa-folder-open-o"></i> Program: 
	<select onchange="get_total_search_results5(0,0);" id="prog_id5" style="max-width:150px;">
		
	</select>
	
</p>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 0px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select id="dept_id5" style="max-width:150px;" onchange="reload_dept5()">
		<option value="-1">All</option>
		<?php
			$stmt = $conn->prepare("SELECT * FROM nr_department order by nr_dept_title asc");
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
</p>


<!-- Confirmation modal for add multiple -->
<div id="course_offer_multiple_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the courses in the offer list?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="course_offer_multiple_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="course_offer_multiple_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('course_offer_multiple_add_re_confirmation').style.display='none';document.getElementById('course_offer_multiple_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_course_offer_multiple_add_confirm = document.getElementById("course_offer_multiple_add_pass");
		function course_offer_multiple_add_pass_co_fu()
		{
			if(pass_course_offer_multiple_add_confirm.value.trim()!="")
			{
				pass_course_offer_multiple_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_course_offer_multiple_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_course_offer_multiple_add_confirm.onchange=course_offer_multiple_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add single-->
<div id="course_offer_single_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add the course in the offer list?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="course_offer_single_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="course_offer_single_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('course_offer_single_add_re_confirmation').style.display='none';document.getElementById('course_offer_single_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_course_offer_single_add_confirm = document.getElementById("course_offer_single_add_pass");
		function course_offer_single_add_pass_co_fu()
		{
			if(pass_course_offer_single_add_confirm.value.trim()!="")
			{
				pass_course_offer_single_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_course_offer_single_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_course_offer_single_add_confirm.onchange=course_offer_single_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for course delete -->
<div id="course_offer_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove the course from the offer list?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="course_offer_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_course_offer_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_course_offer_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('course_offer_view_re_confirmation').style.display='none';document.getElementById('captcha_course_offer_view_confirm').value='';document.getElementById('course_offer_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_course_offer_view_confirm = document.getElementById("captcha_course_offer_view_confirm");
		var sol_course_offer_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_course_offer_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_course_offer_view_confirm.value != sol_course_offer_view_confirm) {
			reservation_captcha_course_offer_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_course_offer_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_course_offer_view_confirm.onchange=reservation_captcha_val_course_offer_view_confirm;
	
	
		var pass_course_offer_view_confirm = document.getElementById("course_offer_view_pass");
		function course_offer_view_pass_co_fu()
		{
			if(pass_course_offer_view_confirm.value.trim()!="")
			{
				pass_course_offer_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_course_offer_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_course_offer_view_confirm.onchange=course_offer_view_pass_co_fu;
		
	</script>
</div>

<div class="w3-container w3-margin-bottom">
	
	<!-- Menu for course add -->

	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Offer Course</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window5').style.display='block';document.getElementById('add_multiple_window5').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window5').style.display='block';document.getElementById('add_single_window5').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		<button onclick="get_course_offer_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
		
		<button onclick="get_total_search_results5(0,0)" class="w3-button w3-brown w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-refresh"></i> Refresh</button>
			
	</div>
	
	<!-- Window for add single course -->

	<div id="add_single_window5" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window5_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:275px;"><i class="fa fa-plus"></i> Offer Single Course</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="course_offer_single_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory. Choose a progam first to enable all other options.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><i class="w3-text-red">*</i> <b>Offer Program</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_single_add_prog" onchange="course_offer_single_add_program_change()">
							<option value="">Select</option>
							<?php
								$stmt = $conn->prepare("SELECT * FROM nr_program where nr_prog_status='Active' order by nr_prog_title asc");
								$stmt->execute();
								$stud_result=$stmt->fetchAll();
								if(count($stud_result)>0)
								{
									$sz=count($stud_result);
									for($k=0;$k<$sz;$k++)
									{
										$prog_id=$stud_result[$k][0];
										$prog_title=$stud_result[$k][1];
										echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
									}
								}
							?>
						</select>
						
						<label><i class="w3-text-red">*</i> <b>Select Course</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_single_add_course" onchange="course_offer_single_add_form_change()" disabled>
							<option value="">Select</option>
						</select>
						
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Course Type</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_single_add_type" onchange="course_offer_single_add_form_change()" disabled>
									<option value="">Select</option>
									<option value="Compulsory">Compulsory</option>
									<option value="Optional I">Optional I</option>
									<option value="Optional II">Optional II</option>
									<option value="Optional III">Optional III</option>
									<option value="Optional IV">Optional IV</option>
									<option value="Optional V">Optional V</option>
								</select>
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><i class="w3-text-red">*</i> <b>Offer Semester</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_single_add_semester" onchange="course_offer_single_add_form_change()" disabled>
									<option value="">Select</option>
									<option value="1">1st</option>
									<option value="2">2nd</option>
									<option value="3">3rd</option>
									<option value="4">4th</option>
									<option value="5">5th</option>
									<option value="6">6th</option>
									<option value="7">7th</option>
									<option value="8">8th</option>
									<option value="9">9th</option>
									<option value="10">10th</option>
									<option value="11">11th</option>
									<option value="12">12th</option>
								</select>
							</div>
						</div>
						<label><i class="w3-text-red">*</i> <b>Status</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_single_add_status" onchange="course_offer_single_add_form_change()" disabled>
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
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="course_offer_single_add_captcha" autocomplete="off" onkeyup="course_offer_single_add_form_change()" disabled>
								<input type="hidden" value="<?php echo $ccc; ?>" id="course_offer_single_add_old_captcha">
							</div>
						</div>
						
						
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						
						<button onclick="course_offer_single_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button onclick="document.getElementById('course_offer_single_add_re_confirmation').style.display='block';" id="course_offer_single_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="course_offer_single_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>
	
	<!-- Window for add multiple course -->

	<div id="add_multiple_window5" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window5_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:300px;"><i class="fa fa-plus"></i> Offer Multiple Course</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="course_offer_multiple_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_course_offer.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. Don't forget to select a offer program. You can insert at most <b>100 courses</b> in the offer list by a single upload under a single program.</li>
					<li>This process may take <b>up to two minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<label><i class="w3-text-red">*</i> <b>Offer Program</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_multiple_add_prog" onchange="course_offer_multiple_add_form_change()">
						<option value="">Select</option>
						<?php
							$stmt = $conn->prepare("SELECT * FROM nr_program where nr_prog_status='Active' order by nr_prog_title asc");
							$stmt->execute();
							$stud_result=$stmt->fetchAll();
							if(count($stud_result)>0)
							{
								$sz=count($stud_result);
								for($k=0;$k<$sz;$k++)
								{
									$prog_id=$stud_result[$k][0];
									$prog_title=$stud_result[$k][1];
									echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
								}
							}
						?>
					</select>
						
					
					<label><i class="w3-text-red">*</i> <b>Upload Excel File</b></label>
					<input class="w3-input w3-border w3-round-large w3-margin-bottom" type="file" id="course_offer_excel_file" title="Please upload the formatted and filled up excel file."  onchange="course_offer_multiple_add_form_change()">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="course_offer_multiple_add_captcha" autocomplete="off" onkeyup="course_offer_multiple_add_form_change()">
							<input type="hidden" value="<?php echo $ccc; ?>" id="course_offer_multiple_add_old_captcha">
						</div>
					</div>
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:10px 0px 0px 6px;">
					
					<button onclick="course_offer_multiple_add_form_clear()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
					</br>	
					<button onclick="document.getElementById('course_offer_multiple_add_re_confirmation').style.display='block';" id="course_offer_multiple_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
				</div>
			</div>
			
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="course_offer_multiple_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="course_offer_multiple_courseress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="course_offer_multiple_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('course_offer_multiple_add_box1').style.display='block';document.getElementById('course_offer_multiple_add_box3').style.display='none';document.getElementById('course_offer_multiple_add_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="course_offer_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="course_offer_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="course_offer_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="course_offer_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	<!-- window for delete history -->
	<div id="course_offer_delete_history_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="course_offer_delete_history_window_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:310px;"><i class="fa fa-history"></i> Offer Remove History</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="course_offer_delete_history_window_box">
			
		</div>
	</div>
	
	
	<!-- Search box -->

	<div class="w3-container" style="margin: 2px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text5" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_5').style.display='inline-block'; } else { document.getElementById('search_clear_btn_5').style.display='none'; } get_search_result5();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Course Title or Code for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_5" title="Clear search box" onclick="document.getElementById('search_text5').value=''; document.getElementById('search_clear_btn_5').style.display='none';get_search_result5();"></i>
		</div>
	</div>
	
	<!-- Wndow for view result -->

	<div id="search_window5" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box5()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<span onclick="print_course_offer_view()" title="Print Window" class="w3-button w3-right w3-large w3-indigo w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 10px 0px 0px;"><i class="fa fa-print"></i></span>
		
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:225px;"><i class="fa fa-eye"></i> Course Details</p>
		<div id="search_window_details5" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	

	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:245px;"><i class="fa fa-server"></i> Offered Courses</p>
	
	<!-- sort options for course list -->
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort5" onchange="get_total_search_results5(0,0)" type="w3-input w3-round-large">
				<option value="1">Title ASC</option>
				<option value="2">Title DESC</option>
				<option value="3">Code ASC</option>
				<option value="4">Code DESC</option>
				<option value="5">Semester ASC</option>
				<option value="6">Semester DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter5').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
		
	<!-- filter for course list -->
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter5" style="display:none;">
		Status: 
		<select id="filter_status5" onchange="get_total_search_results5(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Active</option>
			<option value="2">Inactive</option>
			
		</select>
		&nbsp; Offer Semester: 
		<select id="filter_semester5" onchange="get_total_search_results5(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">1st</option>
			<option value="2">2nd</option>
			<option value="3">3rd</option>
			<option value="4">4th</option>
			<option value="5">5th</option>
			<option value="6">6th</option>
			<option value="7">7th</option>
			<option value="8">8th</option>
			<option value="9">9th</option>
			<option value="10">10th</option>
			<option value="11">11th</option>
			<option value="12">12th</option>
		</select>
		&nbsp; Course Type: 
		<select id="filter_course_type5" onchange="get_total_search_results5(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="Compulsory">Compulsory</option>
			<option value="Optional I">Optional I</option>
			<option value="Optional II">Optional II</option>
			<option value="Optional III">Optional III</option>
			<option value="Optional IV">Optional IV</option>
			<option value="Optional V">Optional V</option>			
		</select>
		
		<span onclick="document.getElementById('filter5').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
	</div>
	
	<div class="w3-clear"></div>
	
	<!-- table for course list -->
	<p class="w3-margin-0 w3-padding-0 w3-medium w3-left">Total Data: <span class="w3-text-red" id="search_data_label5"></span></p>		
	<p class="w3-margin-0 w3-padding-0 w3-medium w3-left w3-margin-left"><i class="fa fa-print w3-hover-text-teal w3-text-indigo w3-cursor" onclick="print_course_offers()"> Print</i></p>		
	<div class="w3-clear"></div>
	
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:7%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:20%;" valign="top" class="w3-padding-small">Course Title</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Course Code</td>
			<td style="width:9%;" valign="top" class="w3-padding-small">Course Credit</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Course Type</td>
			<td style="width:9%;" valign="top" class="w3-padding-small">Offer Semester</td>
			<td style="width:15%;" valign="top" class="w3-padding-small">Offer Program</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Program Credit</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables5">
		
		
		</tbody>
		<tr id="search_results_loading5" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result5" onclick="get_total_search_results5(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>

	/****************************************/
	function print_course_offers()
	{
		var r_sort=document.getElementById('search_result_sort5').value;
		var search_text=document.getElementById('search_text5').value.trim();
		var filter_status5=document.getElementById('filter_status5').value.trim();
		var filter_semester5=document.getElementById('filter_semester5').value.trim();
		var filter_course_type5=document.getElementById('filter_course_type5').value.trim();
		var dept_id5=document.getElementById('dept_id5').value.trim();
		var prog_id5=document.getElementById('prog_id5').value.trim();
		
		
		window.open('../includes/super_admin/course_offer_print.php?admin_id='+<?php echo $_SESSION["admin_id"]; ?>+'&sort='+r_sort+'&search_text='+search_text+'&filter_status5='+filter_status5+'&dept_id='+dept_id5+'&prog_id='+prog_id5+'&filter_semester5='+filter_semester5+'&filter_course_type5='+filter_course_type5);		
	}
	
	function print_course_offers_delete_history()
	{
		window.open('../includes/super_admin/course_offer_delete_history_print.php?admin_id='+<?php echo $_SESSION["admin_id"]; ?>);		
	}
	
	function print_course_offer_view() { 
		var divContents = document.getElementById("search_window5").innerHTML; 
		var a = window.open('', '', 'height=600, width=800'); 
		a.document.write('<html><head>'); 
		a.document.write('<link rel="stylesheet" href="../css/w3.css" type="text/css">');
		a.document.write('<link rel="stylesheet" href="../css/style.css">');
		a.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">');
		a.document.write('<?php echo $print_html_style; ?>'); 
		a.document.write('</head><body onclick="document.getElementById(\'content\').innerHTML=\'\';window.close();"  style="font-family: "Century Schoolbook", sans-serif;font-size:12px;"><div id="content">'); 
		a.document.write('<?php echo $print_html_body; ?>');
		a.document.write(divContents);
		a.document.write('<?php echo $print_html_footer; ?>');		
		a.document.write('</body></html>'); 
		a.document.close(); 
		setTimeout(function(){a.print();},1000);

	} 
	
/***************************************************/

	
	function course_offer_single_add_program_change()
	{
		var prog_id=document.getElementById('course_offer_single_add_prog').value;
		if(prog_id=='')
		{
			document.getElementById('course_offer_single_add_course').value='';
			document.getElementById('course_offer_single_add_course').disabled=true;
			document.getElementById('course_offer_single_add_type').value='';
			document.getElementById('course_offer_single_add_type').disabled=true;
			document.getElementById('course_offer_single_add_semester').value='';
			document.getElementById('course_offer_single_add_semester').disabled=true;
			document.getElementById('course_offer_single_add_status').value='';
			document.getElementById('course_offer_single_add_status').disabled=true;
			document.getElementById('course_offer_single_add_captcha').value='';
			document.getElementById('course_offer_single_add_captcha').disabled=true;
			course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
		
			if(course_offer_view_status=='Active')
			{
				if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
				{
					document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
				}
				if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
				{
					document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
				}
				document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
			}
			else if(course_offer_view_status=='Inactive')
			{
				if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
				{
					document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
				}
				if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
				{
					document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
				}
				document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
			}
			else
			{
				if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
				{
					document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
				}
				if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
				{
					document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
				}
			}
			document.getElementById('course_offer_single_add_save_btn').disabled=true;

		}
		else
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText.trim()=="")
					{
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry no course available to offer in this program.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				
						document.getElementById('course_offer_single_add_course').value='';
						document.getElementById('course_offer_single_add_course').disabled=true;
						document.getElementById('course_offer_single_add_type').value='';
						document.getElementById('course_offer_single_add_type').disabled=true;
						document.getElementById('course_offer_single_add_semester').value='';
						document.getElementById('course_offer_single_add_semester').disabled=true;
						document.getElementById('course_offer_single_add_status').value='';
						document.getElementById('course_offer_single_add_status').disabled=true;
						document.getElementById('course_offer_single_add_captcha').value='';
						document.getElementById('course_offer_single_add_captcha').disabled=true;
						
						course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
						
						if(course_offer_view_status=='Active')
						{
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
							}
							document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
						}
						else if(course_offer_view_status=='Inactive')
						{
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
							}
							document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
						}
						else
						{
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
							}
						}
						
						document.getElementById('course_offer_single_add_save_btn').disabled=true;
					}
					else
					{
						document.getElementById('course_offer_single_add_course').innerHTML=this.responseText;
						document.getElementById('course_offer_single_add_course').value='';
						document.getElementById('course_offer_single_add_course').disabled=false;
						document.getElementById('course_offer_single_add_type').value='';
						document.getElementById('course_offer_single_add_type').disabled=false;
						document.getElementById('course_offer_single_add_semester').value='';
						document.getElementById('course_offer_single_add_semester').disabled=false;
						document.getElementById('course_offer_single_add_status').value='';
						document.getElementById('course_offer_single_add_status').disabled=false;
						document.getElementById('course_offer_single_add_captcha').value='';
						document.getElementById('course_offer_single_add_captcha').disabled=false;
						
						course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
		
						if(course_offer_view_status=='Active')
						{
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
							}
							document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
						}
						else if(course_offer_view_status=='Inactive')
						{
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
							}
							document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
						}
						else
						{
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
							}
						}
						
						document.getElementById('course_offer_single_add_save_btn').disabled=true;
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_offer_single_add_course').value='';
					document.getElementById('course_offer_single_add_course').disabled=true;
					document.getElementById('course_offer_single_add_type').value='';
					document.getElementById('course_offer_single_add_type').disabled=true;
					document.getElementById('course_offer_single_add_semester').value='';
					document.getElementById('course_offer_single_add_semester').disabled=true;
					document.getElementById('course_offer_single_add_status').value='';
					document.getElementById('course_offer_single_add_status').disabled=true;
					document.getElementById('course_offer_single_add_captcha').value='';
					document.getElementById('course_offer_single_add_captcha').disabled=true;
					
					course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
		
					if(course_offer_view_status=='Active')
					{
						if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
						{
							document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
						}
						if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
						{
							document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
						}
						document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
					}
					else if(course_offer_view_status=='Inactive')
					{
						if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
						{
							document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
						}
						if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
						{
							document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
						}
						document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
					}
					else
					{
						if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
						{
							document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
						}
						if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
						{
							document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
						}
					}
					
					document.getElementById('course_offer_single_add_save_btn').disabled=true;
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_course_offer_courses.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_id="+prog_id, true);
			xhttp1.send();
		}
	}

	function course_offer_delete_history_window_close()
	{
		document.getElementById('course_offer_delete_history_window_box').innerHTML='';
		document.getElementById('course_offer_delete_history_window').style.display='none';
	}
	
	function get_course_offer_delete_history()
	{
		document.getElementById('course_offer_delete_history_window').style.display='block';
		document.getElementById('course_offer_delete_history_window_box').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var xhttp1 = new XMLHttpRequest();
		xhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('course_offer_delete_history_window_box').innerHTML=this.responseText;
			}
			else if(this.readyState==4 && (this.status==404 || this.status==403))
			{
				course_offer_delete_history_window_close();
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Network error occurred.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
		};
		xhttp1.open("POST", "../includes/super_admin/get_course_offer_delete_history.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>, true);
		xhttp1.send();
	}
	

	function reload_dept5()
	{
		var dept_id=document.getElementById('dept_id5').value;
		var load_program = new XMLHttpRequest();
		load_program.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('prog_id5').innerHTML=this.responseText;
				get_total_search_results5(0,0);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('prog_id5').innerHTML='<option value="-1">All</option>';
		
			}
		};
				
		load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		load_program.send();
		
	}
	
	function add_multiple_window5_close()
	{
		document.getElementById('course_offer_multiple_add_box1').style.display='block';
		document.getElementById('course_offer_multiple_add_box2').style.display='none';
		document.getElementById('course_offer_multiple_add_box3').style.display='none';
		document.getElementById('course_offer_multiple_add_captcha').value='';
		document.getElementById('course_offer_excel_file').value='';
		document.getElementById('course_offer_multiple_add_prog').value='';
		
		document.getElementById('course_offer_multiple_total').innerHTML='';
		document.getElementById('course_offer_multiple_success').innerHTML='';
		document.getElementById('course_offer_multiple_failed').innerHTML='';
		document.getElementById('course_offer_multiple_logs').innerHTML='';
			
		document.getElementById("course_offer_multiple_add_save_btn").disabled = true;
		document.getElementById('add_multiple_window5').style.display='none';
	
	}
	
	function course_offer_multiple_add_form_change()
	{
		var course_offer_excel_file=document.getElementById('course_offer_excel_file').value;
		var course_offer_prog=document.getElementById('course_offer_multiple_add_prog').value;
		
		if(course_offer_excel_file=="" || course_offer_prog=="")
		{
			document.getElementById("course_offer_multiple_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("course_offer_multiple_add_save_btn").disabled = false;
		}
	}

	function course_offer_multiple_add_form_clear()
	{
		document.getElementById('course_offer_multiple_add_captcha').value='';
		document.getElementById('course_offer_excel_file').value='';
		document.getElementById('course_offer_multiple_add_prog').value='';
						
		document.getElementById("course_offer_multiple_add_save_btn").disabled = true;
		
	}

	function add_single_window5_close()
	{
		document.getElementById('course_offer_single_add_box1').style.display='block';
		document.getElementById('course_offer_single_add_box2').style.display='none';
		
		document.getElementById('course_offer_single_add_prog').value='';		
		document.getElementById('course_offer_single_add_course').value='';
		document.getElementById('course_offer_single_add_course').disabled=true;
		document.getElementById('course_offer_single_add_type').value='';
		document.getElementById('course_offer_single_add_type').disabled=true;
		document.getElementById('course_offer_single_add_semester').value='';
		document.getElementById('course_offer_single_add_semester').disabled=true;
		document.getElementById('course_offer_single_add_status').value='';
		document.getElementById('course_offer_single_add_status').disabled=true;
		document.getElementById('course_offer_single_add_captcha').value='';
		document.getElementById('course_offer_single_add_captcha').disabled=true;
		course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
	
		if(course_offer_single_add_status=='Active')
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
		}
		else if(course_offer_single_add_status=='Inactive')
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		document.getElementById('add_single_window5').style.display='none';
		
		document.getElementById("course_offer_single_add_save_btn").disabled = true;
		
	}
	
	function course_offer_single_add_form_change()
	{
		course_offer_view_semester=document.getElementById('course_offer_single_add_semester').value.trim();
		course_offer_view_prog=document.getElementById('course_offer_single_add_prog').value.trim();
		course_offer_view_course=document.getElementById('course_offer_single_add_course').value.trim();
		course_offer_view_type=document.getElementById('course_offer_single_add_type').value.trim();
		course_offer_view_captcha=document.getElementById('course_offer_single_add_captcha').value.trim();
		course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
		
		if(course_offer_view_status=='Active')
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
		}
		else if(course_offer_view_status=='Inactive')
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
		}
		if(course_offer_view_prog=="" || course_offer_view_course=="" || course_offer_view_semester=="" || course_offer_view_type=="" || course_offer_view_status=="")
		{
			document.getElementById("course_offer_single_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("course_offer_single_add_save_btn").disabled = false;
		}
	}

	function course_offer_single_add_form_reset()
	{
		
		document.getElementById('course_offer_single_add_prog').value='';
		document.getElementById('course_offer_single_add_course').value='';
		document.getElementById('course_offer_single_add_course').disabled=true;
		document.getElementById('course_offer_single_add_type').value='';
		document.getElementById('course_offer_single_add_type').disabled=true;
		document.getElementById('course_offer_single_add_semester').value='';
		document.getElementById('course_offer_single_add_semester').disabled=true;
		document.getElementById('course_offer_single_add_status').value='';
		document.getElementById('course_offer_single_add_status').disabled=true;
		document.getElementById('course_offer_single_add_captcha').value='';
		document.getElementById('course_offer_single_add_captcha').disabled=true;
		
		course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
		
		if(course_offer_view_status=='Active')
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_single_add_status').classList.add('w3-pale-green');
		}
		else if(course_offer_view_status=='Inactive')
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_single_add_status').classList.remove('w3-pale-red');
			}
		}
		document.getElementById('course_offer_single_add_save_btn').disabled=true;
	}
	
	function course_offer_multiple_add_form_save()
	{
		var course_offer_excel_file=document.getElementById('course_offer_excel_file').value;
		var course_offer_prog=document.getElementById('course_offer_multiple_add_prog').value;
		course_offer_view_captcha=document.getElementById('course_offer_multiple_add_captcha').value.trim();
		course_offer_view_old_captcha=document.getElementById('course_offer_multiple_add_old_captcha').value.trim();
		
		if(course_offer_prog=="" || course_offer_excel_file=="" || file_validate3(course_offer_excel_file)==false)
		{
			document.getElementById('course_offer_multiple_add_pass').value='';
			
			document.getElementById('course_offer_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById("course_offer_multiple_add_save_btn").disabled = true;
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload the required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
	
		}
		else if(course_offer_view_captcha=="" || course_offer_view_captcha!=course_offer_view_old_captcha)
		{
			document.getElementById('course_offer_multiple_add_pass').value='';
			
			document.getElementById('course_offer_multiple_add_re_confirmation').style.display='none';
		
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_offer_multiple_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('course_offer_multiple_add_pass').value.trim();
			
			document.getElementById('course_offer_multiple_add_pass').value='';
			
			document.getElementById('course_offer_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('course_offer_multiple_add_box1').style.display='none';
			document.getElementById('course_offer_multiple_add_box3').style.display='none';
			document.getElementById('course_offer_multiple_add_box2').style.display='block';
			
			document.getElementById('course_offer_multiple_total').innerHTML='';
			document.getElementById('course_offer_multiple_success').innerHTML='';
			document.getElementById('course_offer_multiple_failed').innerHTML='';
			document.getElementById('course_offer_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('course_offer_excel_file').files[0];
			var fd_excel=new FormData();
			var link='course_offer_excel_file';
			fd_excel.append(link, excel_file);
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var str=this.responseText.trim();
					
					//console.log(str);
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
						
						
						document.getElementById('course_offer_multiple_courseress_id').style.width='0%';
						document.getElementById('course_offer_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_offer_multiple_add_box1').style.display='none';
						document.getElementById('course_offer_multiple_add_box3').style.display='block';
						document.getElementById('course_offer_multiple_add_box2').style.display='none';
				
						document.getElementById('course_offer_multiple_total').innerHTML=total;
						document.getElementById('course_offer_multiple_success').innerHTML=success;
						document.getElementById('course_offer_multiple_failed').innerHTML=failed;
						document.getElementById('course_offer_multiple_logs').innerHTML=logs;
			
						course_offer_multiple_add_form_clear();
						get_total_search_results5(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('course_offer_multiple_courseress_id').style.width='0%';
						document.getElementById('course_offer_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_offer_multiple_add_box1').style.display='block';
						document.getElementById('course_offer_multiple_add_box3').style.display='none';
						document.getElementById('course_offer_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='un')
					{
						document.getElementById('course_offer_multiple_courseress_id').style.width='0%';
						document.getElementById('course_offer_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_offer_multiple_add_box1').style.display='block';
						document.getElementById('course_offer_multiple_add_box3').style.display='none';
						document.getElementById('course_offer_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to offer this course (program inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u2')
					{
						document.getElementById('course_offer_multiple_courseress_id').style.width='0%';
						document.getElementById('course_offer_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_offer_multiple_add_box1').style.display='block';
						document.getElementById('course_offer_multiple_add_box3').style.display='none';
						document.getElementById('course_offer_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to offer this course (program credit not available).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('course_offer_multiple_courseress_id').style.width='0%';
						document.getElementById('course_offer_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_offer_multiple_add_box1').style.display='block';
						document.getElementById('course_offer_multiple_add_box3').style.display='none';
						document.getElementById('course_offer_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_offer_multiple_courseress_id').style.width='0%';
					document.getElementById('course_offer_multiple_courseress_id').innerHTML='0%';
					
					document.getElementById('course_offer_multiple_add_box1').style.display='block';
					document.getElementById('course_offer_multiple_add_box3').style.display='none';
					document.getElementById('course_offer_multiple_add_box2').style.display='none';
			
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occured.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
				}
			};
			xhttp1.upload.oncourseress = function(e) {
				if (e.lengthComputable) {
				  var percentComplete = Math.round((e.loaded / e.total) * 100);
				  percentComplete=percentComplete.toFixed(2);
				  if(percentComplete==100)
				  {
					 document.getElementById('course_offer_multiple_courseress_id').style.width=percentComplete+'%';
					 document.getElementById('course_offer_multiple_courseress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('course_offer_multiple_courseress_id').style.width=percentComplete+'%';
					 document.getElementById('course_offer_multiple_courseress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_courses_offer.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass+"&course_prog="+course_offer_prog, true);
			xhttp1.send(fd_excel);
		}
	}

	
	function course_offer_single_add_form_save()
	{
		course_offer_view_semester=document.getElementById('course_offer_single_add_semester').value.trim();
		course_offer_view_prog=document.getElementById('course_offer_single_add_prog').value.trim();
		course_offer_view_course=document.getElementById('course_offer_single_add_course').value.trim();
		course_offer_view_type=document.getElementById('course_offer_single_add_type').value.trim();
		course_offer_view_captcha=document.getElementById('course_offer_single_add_captcha').value.trim();
		course_offer_view_old_captcha=document.getElementById('course_offer_single_add_old_captcha').value.trim();
		course_offer_view_status=document.getElementById('course_offer_single_add_status').value.trim();
		
		if(course_offer_view_course=="" || course_offer_view_prog=="" || course_offer_view_semester=="" || course_offer_view_type=="" || course_offer_view_status=="")
		{
			document.getElementById('course_offer_single_add_pass').value='';
			
			document.getElementById('course_offer_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_offer_view_captcha=="" || course_offer_view_captcha!=course_offer_view_old_captcha)
		{
			document.getElementById('course_offer_single_add_pass').value='';
			
			document.getElementById('course_offer_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_offer_single_add_pass_co_fu()==true)
		{
			
			
			var pass=document.getElementById('course_offer_single_add_pass').value.trim();
			
			document.getElementById('course_offer_single_add_pass').value='';
			
			document.getElementById('course_offer_single_add_re_confirmation').style.display='none';
			
			
			document.getElementById('course_offer_single_add_box1').style.display='none';
			document.getElementById('course_offer_single_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						add_single_window5_close();
						
						get_search_result5();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Course successfully added in the offer list.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('course_offer_single_add_box1').style.display='block';
						document.getElementById('course_offer_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('course_offer_single_add_box1').style.display='block';
						document.getElementById('course_offer_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in the offer list (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('course_offer_single_add_box1').style.display='block';
						document.getElementById('course_offer_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course (program inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable3')
					{
						document.getElementById('course_offer_single_add_box1').style.display='block';
						document.getElementById('course_offer_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course (program credit not available).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('course_offer_single_add_box1').style.display='block';
						document.getElementById('course_offer_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_offer_single_add_box1').style.display='block';
					document.getElementById('course_offer_single_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_course_offer.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&course_offer_semester="+course_offer_view_semester+"&course_offer_type="+course_offer_view_type+"&course_offer_status="+course_offer_view_status+"&course_offer_course="+course_offer_view_course+"&course_offer_prog="+course_offer_view_prog, true);
			xhttp1.send();
		}
	
	}
	
	
	var course_offer_view_old_semester;
	var course_offer_view_old_type;
	var course_offer_view_old_captcha;
	var course_offer_view_old_status;
	
	var course_offer_view_semester;
	var course_offer_view_type;
	var course_offer_view_captcha;
	var course_offer_view_status;
	var course_offer_view_prog;
	var course_offer_view_course;
	
	function remove_course_offer_view()
	{
		var pass=document.getElementById('course_offer_view_pass').value.trim();
		if(reservation_captcha_val_course_offer_view_confirm()==true && course_offer_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_course_offer_view_confirm').value='';
			document.getElementById('course_offer_view_pass').value='';
			
			document.getElementById('course_offer_view_re_confirmation').style.display='none';
			
			var course_offer_id=document.getElementById('course_offer_view_id').value.trim();
			
			document.getElementById('course_offer_view_box1').style.display='none';
			document.getElementById('course_offer_view_box3').style.display='none';
			document.getElementById('course_offer_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						get_search_result5();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Course successfully removed from offer list.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('course_offer_view_box1').style.display='block';
						document.getElementById('course_offer_view_box2').style.display='none';
						document.getElementById('course_offer_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('course_offer_view_box1').style.display='block';
						document.getElementById('course_offer_view_box2').style.display='none';
						document.getElementById('course_offer_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_offer_view_box1').style.display='block';
					document.getElementById('course_offer_view_box2').style.display='none';
					document.getElementById('course_offer_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_course_offer.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_offer_id="+course_offer_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function course_offer_view_form_change()
	{
		course_offer_view_semester=document.getElementById('course_offer_view_semester').value.trim();
		course_offer_view_type=document.getElementById('course_offer_view_type').value.trim();
		course_offer_view_captcha=document.getElementById('course_offer_view_captcha').value.trim();
		course_offer_view_status=document.getElementById('course_offer_view_status').value.trim();
		
		course_offer_view_old_semester=document.getElementById('course_offer_view_old_semester').value.trim();
		course_offer_view_old_type=document.getElementById('course_offer_view_old_type').value.trim();
		course_offer_view_old_captcha=document.getElementById('course_offer_view_old_captcha').value.trim();
		course_offer_view_old_status=document.getElementById('course_offer_view_old_status').value.trim();
		
		if(course_offer_view_status=='Active')
		{
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_view_status').classList.add('w3-pale-red');
		}
		
		if(course_offer_view_semester=="" || course_offer_view_type=="" || course_offer_view_status=="" || (course_offer_view_semester==course_offer_view_old_semester && course_offer_view_type==course_offer_view_old_type && course_offer_view_status==course_offer_view_old_status))
		{
			document.getElementById("course_offer_view_save_btn").disabled = true;
		}
		else if(course_offer_view_semester!=course_offer_view_old_semester || course_offer_view_type!=course_offer_view_old_type || course_offer_view_status!=course_offer_view_old_status)
		{
			document.getElementById("course_offer_view_save_btn").disabled = false;
		}
	}
	
	function course_offer_view_form_reset()
	{
		course_offer_view_old_semester=document.getElementById('course_offer_view_old_semester').value.trim();
		course_offer_view_old_type=document.getElementById('course_offer_view_old_type').value.trim();
		course_offer_view_old_captcha=document.getElementById('course_offer_view_old_captcha').value.trim();
		course_offer_view_old_status=document.getElementById('course_offer_view_old_status').value.trim();
		
		document.getElementById('course_offer_view_semester').value=course_offer_view_old_semester;
		document.getElementById('course_offer_view_type').value=course_offer_view_old_type;
		document.getElementById('course_offer_view_captcha').value='';
		document.getElementById('course_offer_view_status').value=course_offer_view_old_status;
		
		course_offer_view_status=document.getElementById('course_offer_view_status').value.trim();
		
		if(course_offer_view_status=='Active')
		{
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_offer_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_offer_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_offer_view_status').classList.add('w3-pale-red');
		}
		
		document.getElementById("course_offer_view_save_btn").disabled = true;
	}
	
	function course_offer_view_form_save_changes(course_offer_id)
	{
		course_offer_view_semester=document.getElementById('course_offer_view_semester').value.trim();
		course_offer_view_type=document.getElementById('course_offer_view_type').value.trim();
		course_offer_view_captcha=document.getElementById('course_offer_view_captcha').value.trim();
		course_offer_view_status=document.getElementById('course_offer_view_status').value.trim();
		
		course_offer_view_old_semester=document.getElementById('course_offer_view_old_semester').value.trim();
		course_offer_view_old_type=document.getElementById('course_offer_view_old_type').value.trim();
		course_offer_view_old_captcha=document.getElementById('course_offer_view_old_captcha').value.trim();
		course_offer_view_old_status=document.getElementById('course_offer_view_old_status').value.trim();
		
		
		if(course_offer_view_semester=="" || course_offer_view_type=="" || course_offer_view_status=="")
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_offer_view_captcha=="" || course_offer_view_captcha!=course_offer_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else
		{
			document.getElementById('course_offer_view_box1').style.display='none';
			document.getElementById('course_offer_view_box3').style.display='none';
			document.getElementById('course_offer_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						close_search_box5();
						view_result5(course_offer_id);
						
						get_total_search_results5(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('course_offer_view_box1').style.display='block';
						document.getElementById('course_offer_view_box2').style.display='none';
						document.getElementById('course_offer_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_offer_view_box1').style.display='block';
					document.getElementById('course_offer_view_box2').style.display='none';
					document.getElementById('course_offer_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_course_offer.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_offer_view_semester="+course_offer_view_semester+"&course_offer_view_type="+course_offer_view_type+"&course_offer_view_status="+course_offer_view_status+"&course_offer_id="+course_offer_id, true);
			xhttp1.send();
		}
		
	}
	
	function get_search_result5()
	{
		close_search_box5();
		get_total_search_results5(0,0);
	}
	
	function view_result5(course_offer_id)
	{
		
		document.getElementById('search_window5').style.display='block';
		var page5=document.getElementById('page5');
		page5.scrollTop = 20;
		document.getElementById('search_window_details5').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details5').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details5').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results5.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_offer_id="+course_offer_id, true);
		search_window_result.send();
		
		
	}
	
	function close_search_box5()
	{
		document.getElementById('search_window_details5').innerHTML='';
		document.getElementById('search_window5').style.display='none';
	}
	
	
	var page5=0,total5;
	function get_total_search_results5(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading5").innerHTML='<td colspan="9"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort5').value;
		var search_text=document.getElementById('search_text5').value.trim();
		var filter_status5=document.getElementById('filter_status5').value.trim();
		var filter_semester5=document.getElementById('filter_semester5').value.trim();
		var filter_course_type5=document.getElementById('filter_course_type5').value.trim();
		var dept_id5=document.getElementById('dept_id5').value.trim();
		var prog_id5=document.getElementById('prog_id5').value.trim();
		
		
		var total5_results = new XMLHttpRequest();
		total5_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total5=parseInt(this.responseText.trim());
				get_search_results5(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total5=0;
				get_search_results5(x,y);
			}
		};
		document.getElementById('search_data_label5').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total5_results.open("GET", "../includes/super_admin/get_total_search_results5.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&filter_status5="+filter_status5+"&dept_id="+dept_id5+"&prog_id="+prog_id5+"&filter_semester5="+filter_semester5+"&filter_course_type5="+filter_course_type5, true);
		total5_results.send();
		
	}
	
	function get_search_results5(x,y)
	{
		if(x==0)
		{
			page5=0;
			document.getElementById('search_result_tables5').innerHTML='';
		}
		if(total5!=0)
		{
			var r_sort=document.getElementById('search_result_sort5').value;
			var search_text=document.getElementById('search_text5').value.trim();
			var filter_status5=document.getElementById('filter_status5').value.trim();
			var filter_semester5=document.getElementById('filter_semester5').value.trim();
			var filter_course_type5=document.getElementById('filter_course_type5').value.trim();
			var dept_id5=document.getElementById('dept_id5').value.trim();
			var prog_id5=document.getElementById('prog_id5').value.trim();
		
		
			document.getElementById("show_more_btn_search_result5").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading5").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables5').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables5').innerHTML=document.getElementById('search_result_tables5').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label5').innerHTML=total5;
					
					if(total5>page5)
					{
						document.getElementById("show_more_btn_search_result5").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label5').innerHTML='N/A';
					document.getElementById("search_results_loading5").innerHTML = '<td colspan="9"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page5;
			page5=page5+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results5.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&filter_status5="+filter_status5+"&dept_id="+dept_id5+"&prog_id="+prog_id5+"&filter_semester5="+filter_semester5+"&filter_course_type5="+filter_course_type5, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading5").innerHTML='';
			document.getElementById('search_data_label5').innerHTML='N/A';
			document.getElementById('search_result_tables5').innerHTML='<tr><td colspan="9"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result5").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa5_btn = document.getElementById("pa5_btn");
	var pa5=document.getElementById('page5');
	// When the user scrolls down 20px from the top of the document, show the button
	pa5.onscroll = function() {pa5_scrollFunction()};

	function pa5_scrollFunction() {
	  if (pa5.scrollTop > 20) {
		pa5_btn.style.display = "block";
	  } else {
		pa5_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa5_topFunction() {
	  pa5.scrollTop = 0;
	}
	
	
	reload_dept5();
	

</script>