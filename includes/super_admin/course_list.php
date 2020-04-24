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

<i onclick="pa4_topFunction()" id="pa4_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
	<i class="fa fa-folder-open-o"></i> Program: 
	<select onchange="get_total_search_results4(0,0);" id="prog_id4" style="max-width:150px;">
		
	</select>
	
</p>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 0px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select id="dept_id4" style="max-width:150px;" onchange="reload_dept4()">
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
<div id="course_multiple_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the courses?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="course_multiple_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="course_multiple_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('course_multiple_add_re_confirmation').style.display='none';document.getElementById('course_multiple_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_course_multiple_add_confirm = document.getElementById("course_multiple_add_pass");
		function course_multiple_add_pass_co_fu()
		{
			if(pass_course_multiple_add_confirm.value.trim()!="")
			{
				pass_course_multiple_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_course_multiple_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_course_multiple_add_confirm.onchange=course_multiple_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add single-->
<div id="course_single_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add the course?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="course_single_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="course_single_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('course_single_add_re_confirmation').style.display='none';document.getElementById('course_single_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_course_single_add_confirm = document.getElementById("course_single_add_pass");
		function course_single_add_pass_co_fu()
		{
			if(pass_course_single_add_confirm.value.trim()!="")
			{
				pass_course_single_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_course_single_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_course_single_add_confirm.onchange=course_single_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for course delete -->
<div id="course_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove the course?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="course_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_course_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_course_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('course_view_re_confirmation').style.display='none';document.getElementById('captcha_course_view_confirm').value='';document.getElementById('course_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_course_view_confirm = document.getElementById("captcha_course_view_confirm");
		var sol_course_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_course_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_course_view_confirm.value != sol_course_view_confirm) {
			reservation_captcha_course_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_course_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_course_view_confirm.onchange=reservation_captcha_val_course_view_confirm;
	
	
		var pass_course_view_confirm = document.getElementById("course_view_pass");
		function course_view_pass_co_fu()
		{
			if(pass_course_view_confirm.value.trim()!="")
			{
				pass_course_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_course_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_course_view_confirm.onchange=course_view_pass_co_fu;
		
	</script>
</div>

<div class="w3-container w3-margin-bottom">
	
	<!-- Menu for course add -->

	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Course</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window4').style.display='block';document.getElementById('add_multiple_window4').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window4').style.display='block';document.getElementById('add_single_window4').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		<button onclick="get_course_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
		
			
	</div>
	
	<!-- Window for add single course -->

	<div id="add_single_window4" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window4_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:265px;"><i class="fa fa-plus"></i> Add Single Course</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="course_single_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><i class="w3-text-red">*</i> <b>Course Title</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="course_single_add_title" placeholder="Enter Course Title" autocomplete="off" onkeyup="course_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Course Code</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="course_single_add_code" placeholder="Enter Course Code" autocomplete="off" onkeyup="course_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Course Credit</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" id="course_single_add_credit" placeholder="Enter Course Credit" autocomplete="off" onkeyup="course_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Program</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_single_add_prog" onchange="course_single_add_form_change()">
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
						
						<label><i class="w3-text-red">*</i> <b>Status</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_single_add_status" onchange="course_single_add_form_change()">
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
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="course_single_add_captcha" autocomplete="off" onkeyup="course_single_add_form_change()">
								<input type="hidden" value="<?php echo $ccc; ?>" id="course_single_add_old_captcha">
							</div>
						</div>
						
						
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						
						<button onclick="course_single_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button onclick="document.getElementById('course_single_add_re_confirmation').style.display='block';" id="course_single_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="course_single_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>
	
	<!-- Window for add multiple course -->

	<div id="add_multiple_window4" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window4_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:290px;"><i class="fa fa-plus"></i> Add Multiple Course</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="course_multiple_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_course.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. Don't forget to select a program. You can insert at most <b>100 courses</b> in a single upload under a single program.</li>
					<li>This process may take <b>up to two minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<label><i class="w3-text-red">*</i> <b>Program</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_multiple_add_prog" onchange="course_multiple_add_form_change()">
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
					<input class="w3-input w3-border w3-round-large" type="file" id="course_excel_file" title="Please upload the formatted and filled up excel file."  onchange="course_multiple_add_form_change()">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="course_multiple_add_captcha" autocomplete="off" onkeyup="course_multiple_add_form_change()">
							<input type="hidden" value="<?php echo $ccc; ?>" id="course_multiple_add_old_captcha">
						</div>
					</div>
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:10px 0px 0px 6px;">
					
					<button onclick="course_multiple_add_form_clear()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
					</br>	
					<button onclick="document.getElementById('course_multiple_add_re_confirmation').style.display='block';" id="course_multiple_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
				</div>
			</div>
			
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="course_multiple_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="course_multiple_courseress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="course_multiple_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('course_multiple_add_box1').style.display='block';document.getElementById('course_multiple_add_box3').style.display='none';document.getElementById('course_multiple_add_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="course_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="course_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="course_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="course_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	<!-- window for delete history -->
	<div id="course_delete_history_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="course_delete_history_window_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:335px;"><i class="fa fa-history"></i> Course Remove History</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="course_delete_history_window_box">
			
		</div>
	</div>
	
	
	<!-- Search box -->

	<div class="w3-container" style="margin: 2px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text4" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_4').style.display='inline-block'; } else { document.getElementById('search_clear_btn_4').style.display='none'; } get_search_result4();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Course Title or Code for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_4" title="Clear search box" onclick="document.getElementById('search_text4').value=''; document.getElementById('search_clear_btn_4').style.display='none';get_search_result4();"></i>
		</div>
	</div>
	
	<!-- Wndow for view result -->

	<div id="search_window4" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box4()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:225px;"><i class="fa fa-eye"></i> Course Details</p>
		<div id="search_window_details4" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	

	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:140px;"><i class="fa fa-server"></i> Courses</p>
	
	<!-- sort options for course list -->
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort4" onchange="get_total_search_results4(0,0)" type="w3-input w3-round-large">
				<option value="1">Title ASC</option>
				<option value="2">Title DESC</option>
				<option value="3">Code ASC</option>
				<option value="4">Code DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter4').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
		
	<!-- filter for course list -->
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter4" style="display:none;">
		Status: 
		<select id="filter_status4" onchange="get_total_search_results4(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Active</option>
			<option value="2">Inactive</option>
			
		</select>
		
		<span onclick="document.getElementById('filter4').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
	</div>
	
	<div class="w3-clear"></div>
	
	<!-- table for course list -->
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label4"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:30%;" valign="top" class="w3-padding-small">Course Title</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Course Code</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Course Credit</td>
			<td style="width:20%;" valign="top" class="w3-padding-small">Course Program</td>
			<td style="width:16%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables4">
		
		
		</tbody>
		<tr id="search_results_loading4" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result4" onclick="get_total_search_results4(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>


	function course_delete_history_window_close()
	{
		document.getElementById('course_delete_history_window_box').innerHTML='';
		document.getElementById('course_delete_history_window').style.display='none';
	}
	
	function get_course_delete_history()
	{
		document.getElementById('course_delete_history_window').style.display='block';
		document.getElementById('course_delete_history_window_box').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var xhttp1 = new XMLHttpRequest();
		xhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('course_delete_history_window_box').innerHTML=this.responseText;
			}
			else if(this.readyState==4 && (this.status==404 || this.status==403))
			{
				course_delete_history_window_close();
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Network error occurred.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
		};
		xhttp1.open("POST", "../includes/super_admin/get_course_delete_history.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>, true);
		xhttp1.send();
	}
	

	function reload_dept4()
	{
		var dept_id=document.getElementById('dept_id4').value;
		var load_program = new XMLHttpRequest();
		load_program.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('prog_id4').innerHTML=this.responseText;
				get_total_search_results4(0,0);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('prog_id4').innerHTML='<option value="-1">All</option>';
		
			}
		};
				
		load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		load_program.send();
		
	}
	
	function add_multiple_window4_close()
	{
		document.getElementById('course_multiple_add_box1').style.display='block';
		document.getElementById('course_multiple_add_box2').style.display='none';
		document.getElementById('course_multiple_add_box3').style.display='none';
		document.getElementById('course_multiple_add_captcha').value='';
		document.getElementById('course_excel_file').value='';
		document.getElementById('course_multiple_add_prog').value='';
		
		document.getElementById('course_multiple_total').innerHTML='';
		document.getElementById('course_multiple_success').innerHTML='';
		document.getElementById('course_multiple_failed').innerHTML='';
		document.getElementById('course_multiple_logs').innerHTML='';
			
		document.getElementById("course_multiple_add_save_btn").disabled = true;
		document.getElementById('add_multiple_window4').style.display='none';
	
	}
	
	function course_multiple_add_form_change()
	{
		var course_excel_file=document.getElementById('course_excel_file').value;
		var course_prog=document.getElementById('course_multiple_add_prog').value;
		
		if(course_excel_file=="" || course_prog=="")
		{
			document.getElementById("course_multiple_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("course_multiple_add_save_btn").disabled = false;
		}
	}

	function course_multiple_add_form_clear()
	{
		document.getElementById('course_multiple_add_captcha').value='';
		document.getElementById('course_excel_file').value='';
		document.getElementById('course_multiple_add_prog').value='';
						
		document.getElementById("course_multiple_add_save_btn").disabled = true;
		
	}

	function add_single_window4_close()
	{
		document.getElementById('course_single_add_box1').style.display='block';
		document.getElementById('course_single_add_box2').style.display='none';
			
		document.getElementById('course_single_add_title').value='';
		document.getElementById('course_single_add_code').value='';
		document.getElementById('course_single_add_credit').value='';
		document.getElementById('course_single_add_prog').value='';
		document.getElementById('course_single_add_status').value='';
		document.getElementById('course_single_add_captcha').value='';
		
		if(course_single_add_status=='Active')
		{
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_single_add_status').classList.add('w3-pale-green');
		}
		else if(course_single_add_status=='Inactive')
		{
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		document.getElementById('add_single_window4').style.display='none';
		
		document.getElementById("course_single_add_save_btn").disabled = true;
		
	}
	
	function course_single_add_form_change()
	{
		course_view_title=document.getElementById('course_single_add_title').value.trim();
		course_view_code=document.getElementById('course_single_add_code').value.trim();
		course_view_credit=document.getElementById('course_single_add_credit').value.trim();
		course_view_prog=document.getElementById('course_single_add_prog').value.trim();
		course_view_captcha=document.getElementById('course_single_add_captcha').value.trim();
		course_view_status=document.getElementById('course_single_add_status').value.trim();
		
		if(course_single_add_status=='Active')
		{
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_single_add_status').classList.add('w3-pale-green');
		}
		else if(course_single_add_status=='Inactive')
		{
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_single_add_status').classList.remove('w3-pale-red');
			}
		}
		if(course_view_title=="" || course_view_code=="" || course_view_credit=="" || course_view_prog=="" || course_view_status=="")
		{
			document.getElementById("course_single_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("course_single_add_save_btn").disabled = false;
		}
	}

	function course_single_add_form_reset()
	{
		document.getElementById('course_single_add_title').value='';
		document.getElementById('course_single_add_code').value='';
		document.getElementById('course_single_add_credit').value='';
		document.getElementById('course_single_add_prog').value='';
		document.getElementById('course_single_add_status').value='';
		document.getElementById('course_single_add_captcha').value='';
						
		document.getElementById("course_single_add_save_btn").disabled = true;
	}
	
	function course_multiple_add_form_save()
	{
		var course_excel_file=document.getElementById('course_excel_file').value;
		var course_prog=document.getElementById('course_multiple_add_prog').value;
		course_view_captcha=document.getElementById('course_multiple_add_captcha').value.trim();
		course_view_old_captcha=document.getElementById('course_multiple_add_old_captcha').value.trim();
		
		if(course_prog=="" || course_excel_file=="" || file_validate3(course_excel_file)==false)
		{
			document.getElementById('course_multiple_add_pass').value='';
			
			document.getElementById('course_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById("course_multiple_add_save_btn").disabled = true;
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload the required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
	
		}
		else if(course_view_captcha=="" || course_view_captcha!=course_view_old_captcha)
		{
			document.getElementById('course_multiple_add_pass').value='';
			
			document.getElementById('course_multiple_add_re_confirmation').style.display='none';
		
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_multiple_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('course_multiple_add_pass').value.trim();
			
			document.getElementById('course_multiple_add_pass').value='';
			
			document.getElementById('course_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('course_multiple_add_box1').style.display='none';
			document.getElementById('course_multiple_add_box3').style.display='none';
			document.getElementById('course_multiple_add_box2').style.display='block';
			
			document.getElementById('course_multiple_total').innerHTML='';
			document.getElementById('course_multiple_success').innerHTML='';
			document.getElementById('course_multiple_failed').innerHTML='';
			document.getElementById('course_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('course_excel_file').files[0];
			var fd_excel=new FormData();
			var link='course_excel_file';
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
						
						
						document.getElementById('course_multiple_courseress_id').style.width='0%';
						document.getElementById('course_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_multiple_add_box1').style.display='none';
						document.getElementById('course_multiple_add_box3').style.display='block';
						document.getElementById('course_multiple_add_box2').style.display='none';
				
						document.getElementById('course_multiple_total').innerHTML=total;
						document.getElementById('course_multiple_success').innerHTML=success;
						document.getElementById('course_multiple_failed').innerHTML=failed;
						document.getElementById('course_multiple_logs').innerHTML=logs;
			
						course_multiple_add_form_clear();
						get_total_search_results4(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('course_multiple_courseress_id').style.width='0%';
						document.getElementById('course_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_multiple_add_box1').style.display='block';
						document.getElementById('course_multiple_add_box3').style.display='none';
						document.getElementById('course_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='unable2')
					{
						document.getElementById('course_multiple_courseress_id').style.width='0%';
						document.getElementById('course_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_multiple_add_box1').style.display='block';
						document.getElementById('course_multiple_add_box3').style.display='none';
						document.getElementById('course_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (department inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('course_multiple_courseress_id').style.width='0%';
						document.getElementById('course_multiple_courseress_id').innerHTML='0%';
						
						document.getElementById('course_multiple_add_box1').style.display='block';
						document.getElementById('course_multiple_add_box3').style.display='none';
						document.getElementById('course_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_multiple_courseress_id').style.width='0%';
					document.getElementById('course_multiple_courseress_id').innerHTML='0%';
					
					document.getElementById('course_multiple_add_box1').style.display='block';
					document.getElementById('course_multiple_add_box3').style.display='none';
					document.getElementById('course_multiple_add_box2').style.display='none';
			
					
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
					 document.getElementById('course_multiple_courseress_id').style.width=percentComplete+'%';
					 document.getElementById('course_multiple_courseress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('course_multiple_courseress_id').style.width=percentComplete+'%';
					 document.getElementById('course_multiple_courseress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_courses.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass+"&course_prog="+course_prog, true);
			xhttp1.send(fd_excel);
		}
	}

	
	function course_single_add_form_save()
	{
		course_view_title=document.getElementById('course_single_add_title').value.trim();
		course_view_code=document.getElementById('course_single_add_code').value.trim();
		course_view_credit=document.getElementById('course_single_add_credit').value.trim();
		course_view_prog=document.getElementById('course_single_add_prog').value.trim();
		course_view_captcha=document.getElementById('course_single_add_captcha').value.trim();
		course_view_old_captcha=document.getElementById('course_single_add_old_captcha').value.trim();
		course_view_status=document.getElementById('course_single_add_status').value.trim();
		
		if(course_view_title=="" || course_view_code=="" || course_view_credit=="" || course_view_prog=="" || course_view_status=="")
		{
			document.getElementById('course_single_add_pass').value='';
			
			document.getElementById('course_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_view_captcha=="" || course_view_captcha!=course_view_old_captcha)
		{
			document.getElementById('course_single_add_pass').value='';
			
			document.getElementById('course_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_single_add_pass_co_fu()==true)
		{
			
			
			var pass=document.getElementById('course_single_add_pass').value.trim();
			
			document.getElementById('course_single_add_pass').value='';
			
			document.getElementById('course_single_add_re_confirmation').style.display='none';
			
			
			document.getElementById('course_single_add_box1').style.display='none';
			document.getElementById('course_single_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						add_single_window4_close();
						
						get_search_result4();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Course successfully added.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('course_single_add_box1').style.display='block';
						document.getElementById('course_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('course_single_add_box1').style.display='block';
						document.getElementById('course_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('course_single_add_box1').style.display='block';
						document.getElementById('course_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course (program inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('course_single_add_box1').style.display='block';
						document.getElementById('course_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_single_add_box1').style.display='block';
					document.getElementById('course_single_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&course_title="+course_view_title+"&course_code="+course_view_code+"&course_credit="+course_view_credit+"&course_prog="+course_view_prog+"&course_status="+course_view_status, true);
			xhttp1.send();
		}
	
	}
	
	
	var course_view_old_title;
	var course_view_old_code;
	var course_view_old_dept;
	var course_view_old_credit;
	var course_view_old_captcha;
	var course_view_old_status;
	
	var course_view_title;
	var course_view_code;
	var course_view_prog;
	var course_view_credit;
	var course_view_captcha;
	var course_view_status;
	
	function remove_course_view()
	{
		var pass=document.getElementById('course_view_pass').value.trim();
		if(reservation_captcha_val_course_view_confirm()==true && course_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_course_view_confirm').value='';
			document.getElementById('course_view_pass').value='';
			
			document.getElementById('course_view_re_confirmation').style.display='none';
			
			var course_id=document.getElementById('course_view_id').value.trim();
			
			document.getElementById('course_view_box1').style.display='none';
			document.getElementById('course_view_box3').style.display='none';
			document.getElementById('course_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						get_search_result4();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Course successfully removed.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('course_view_box1').style.display='block';
						document.getElementById('course_view_box2').style.display='none';
						document.getElementById('course_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('course_view_box1').style.display='block';
						document.getElementById('course_view_box3').style.display='none';
						document.getElementById('course_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to remove this course.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('course_view_box1').style.display='block';
						document.getElementById('course_view_box2').style.display='none';
						document.getElementById('course_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_view_box1').style.display='block';
					document.getElementById('course_view_box2').style.display='none';
					document.getElementById('course_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_id="+course_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function course_view_form_change()
	{
		course_view_title=document.getElementById('course_view_title').value.trim();
		course_view_code=document.getElementById('course_view_code').value.trim();
		course_view_credit=document.getElementById('course_view_credit').value.trim();
		course_view_prog=document.getElementById('course_view_prog').value.trim();
		course_view_captcha=document.getElementById('course_view_captcha').value.trim();
		course_view_status=document.getElementById('course_view_status').value.trim();
		
		course_view_old_title=document.getElementById('course_view_old_title').value.trim();
		course_view_old_code=document.getElementById('course_view_old_code').value.trim();
		course_view_old_credit=document.getElementById('course_view_old_credit').value.trim();
		course_view_old_dept=document.getElementById('course_view_old_dept').value.trim();
		course_view_old_captcha=document.getElementById('course_view_old_captcha').value.trim();
		course_view_old_status=document.getElementById('course_view_old_status').value.trim();
		
		if(course_view_status=='Active')
		{
			if(document.getElementById('course_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('course_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('course_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('course_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('course_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('course_view_status').classList.add('w3-pale-red');
		}
		
		if(course_view_title=="" || course_view_code=="" || course_view_status=="" || course_view_prog=="" || course_view_credit=="" || (course_view_title==course_view_old_title && course_view_code==course_view_old_code && course_view_credit==course_view_old_credit && course_view_prog==course_view_old_dept && course_view_status==course_view_old_status))
		{
			document.getElementById("course_view_save_btn").disabled = true;
		}
		else if(course_view_title!=course_view_old_title || course_view_code!=course_view_old_code || course_view_status!=course_view_old_status || course_view_credit!=course_view_old_credit || course_view_prog!=course_view_old_dept)
		{
			document.getElementById("course_view_save_btn").disabled = false;
		}
	}
	
	function course_view_form_reset()
	{
		course_view_old_title=document.getElementById('course_view_old_title').value.trim();
		course_view_old_code=document.getElementById('course_view_old_code').value.trim();
		course_view_old_credit=document.getElementById('course_view_old_credit').value.trim();
		course_view_old_dept=document.getElementById('course_view_old_dept').value.trim();
		course_view_old_captcha=document.getElementById('course_view_old_captcha').value.trim();
		course_view_old_status=document.getElementById('course_view_old_status').value.trim();
		
		document.getElementById('course_view_title').value=course_view_old_title;
		document.getElementById('course_view_code').value=course_view_old_code;
		document.getElementById('course_view_credit').value=course_view_old_credit;
		document.getElementById('course_view_prog').value=course_view_old_dept;
		document.getElementById('course_view_captcha').value='';
		document.getElementById('course_view_status').value=course_view_old_status;
		
		document.getElementById("course_view_save_btn").disabled = true;
	}
	
	function course_view_form_save_changes(course_id)
	{
		course_view_title=document.getElementById('course_view_title').value.trim();
		course_view_code=document.getElementById('course_view_code').value.trim();
		course_view_credit=document.getElementById('course_view_credit').value.trim();
		course_view_prog=document.getElementById('course_view_prog').value.trim();
		course_view_captcha=document.getElementById('course_view_captcha').value.trim();
		course_view_status=document.getElementById('course_view_status').value.trim();
		
		course_view_old_title=document.getElementById('course_view_old_title').value.trim();
		course_view_old_code=document.getElementById('course_view_old_code').value.trim();
		course_view_old_credit=document.getElementById('course_view_old_credit').value.trim();
		course_view_old_dept=document.getElementById('course_view_old_dept').value.trim();
		course_view_old_captcha=document.getElementById('course_view_old_captcha').value.trim();
		course_view_old_status=document.getElementById('course_view_old_status').value.trim();
		
		
		if(course_view_title=="" || course_view_code=="" || course_view_status=="" || course_view_credit=="" || course_view_prog=="")
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(course_view_captcha=="" || course_view_captcha!=course_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else
		{
			document.getElementById('course_view_box1').style.display='none';
			document.getElementById('course_view_box3').style.display='none';
			document.getElementById('course_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						close_search_box4();
						view_result4(course_id);
						
						get_total_search_results4(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('course_view_box1').style.display='block';
						document.getElementById('course_view_box2').style.display='none';
						document.getElementById('course_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('course_view_box1').style.display='block';
					document.getElementById('course_view_box2').style.display='none';
					document.getElementById('course_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_title="+course_view_title+"&course_code="+course_view_code+"&course_status="+course_view_status+"&course_credit="+course_view_credit+"&course_prog="+course_view_prog+"&course_id="+course_id, true);
			xhttp1.send();
		}
		
	}
	
	function get_search_result4()
	{
		close_search_box4();
		get_total_search_results4(0,0);
	}
	
	function view_result4(course_id)
	{
		
		document.getElementById('search_window4').style.display='block';
		var page4=document.getElementById('page4');
		page4.scrollTop = 20;
		document.getElementById('search_window_details4').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details4').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details4').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results4.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_id="+course_id, true);
		search_window_result.send();
		
		
	}
	
	function close_search_box4()
	{
		document.getElementById('search_window_details4').innerHTML='';
		document.getElementById('search_window4').style.display='none';
	}
	
	
	var page4=0,total4;
	function get_total_search_results4(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading4").innerHTML='<td colspan="6"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort4').value;
		var search_text=document.getElementById('search_text4').value.trim();
		var filter_status4=document.getElementById('filter_status4').value.trim();
		var dept_id4=document.getElementById('dept_id4').value.trim();
		var prog_id4=document.getElementById('prog_id4').value.trim();
		
		
		var total4_results = new XMLHttpRequest();
		total4_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total4=parseInt(this.responseText.trim());
				get_search_results4(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total4=0;
				get_search_results4(x,y);
			}
		};
		document.getElementById('search_data_label4').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total4_results.open("GET", "../includes/super_admin/get_total_search_results4.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&filter_status4="+filter_status4+"&dept_id="+dept_id4+"&prog_id="+prog_id4, true);
		total4_results.send();
		
	}
	
	function get_search_results4(x,y)
	{
		if(x==0)
		{
			page4=0;
			document.getElementById('search_result_tables4').innerHTML='';
		}
		if(total4!=0)
		{
			var r_sort=document.getElementById('search_result_sort4').value;
			var search_text=document.getElementById('search_text4').value.trim();
			var filter_status4=document.getElementById('filter_status4').value.trim();
			var dept_id4=document.getElementById('dept_id4').value.trim();
			var prog_id4=document.getElementById('prog_id4').value.trim();
		
		
			document.getElementById("show_more_btn_search_result4").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading4").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables4').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables4').innerHTML=document.getElementById('search_result_tables4').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label4').innerHTML=total4;
					
					if(total4>page4)
					{
						document.getElementById("show_more_btn_search_result4").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label4').innerHTML='N/A';
					document.getElementById("search_results_loading4").innerHTML = '<td colspan="6"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page4;
			page4=page4+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results4.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&filter_status4="+filter_status4+"&dept_id="+dept_id4+"&prog_id="+prog_id4, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading4").innerHTML='';
			document.getElementById('search_data_label4').innerHTML='N/A';
			document.getElementById('search_result_tables4').innerHTML='<tr><td colspan="6"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result4").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa4_btn = document.getElementById("pa4_btn");
	var pa4=document.getElementById('page4');
	// When the user scrolls down 20px from the top of the document, show the button
	pa4.onscroll = function() {pa4_scrollFunction()};

	function pa4_scrollFunction() {
	  if (pa4.scrollTop > 20) {
		pa4_btn.style.display = "block";
	  } else {
		pa4_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa4_topFunction() {
	  pa4.scrollTop = 0;
	}
	
	
	reload_dept4();
	

</script>