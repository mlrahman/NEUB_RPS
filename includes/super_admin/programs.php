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

<i onclick="pa3_topFunction()" id="pa3_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 0px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select id="dept_id3" style="max-width:150px;" onchange="get_total_search_results3(0,0);">
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
<div id="prog_multiple_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the programs?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="prog_multiple_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="prog_multiple_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('prog_multiple_add_re_confirmation').style.display='none';document.getElementById('prog_multiple_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_prog_multiple_add_confirm = document.getElementById("prog_multiple_add_pass");
		function prog_multiple_add_pass_co_fu()
		{
			if(pass_prog_multiple_add_confirm.value.trim()!="")
			{
				pass_prog_multiple_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_prog_multiple_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_prog_multiple_add_confirm.onchange=prog_multiple_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add single-->
<div id="prog_single_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add the program?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="prog_single_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="prog_single_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('prog_single_add_re_confirmation').style.display='none';document.getElementById('prog_single_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_prog_single_add_confirm = document.getElementById("prog_single_add_pass");
		function prog_single_add_pass_co_fu()
		{
			if(pass_prog_single_add_confirm.value.trim()!="")
			{
				pass_prog_single_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_prog_single_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_prog_single_add_confirm.onchange=prog_single_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for prog delete -->
<div id="prog_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove the program?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="prog_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_prog_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_prog_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('prog_view_re_confirmation').style.display='none';document.getElementById('captcha_prog_view_confirm').value='';document.getElementById('prog_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_prog_view_confirm = document.getElementById("captcha_prog_view_confirm");
		var sol_prog_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_prog_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_prog_view_confirm.value != sol_prog_view_confirm) {
			reservation_captcha_prog_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_prog_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_prog_view_confirm.onchange=reservation_captcha_val_prog_view_confirm;
	
	
		var pass_prog_view_confirm = document.getElementById("prog_view_pass");
		function prog_view_pass_co_fu()
		{
			if(pass_prog_view_confirm.value.trim()!="")
			{
				pass_prog_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_prog_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_prog_view_confirm.onchange=prog_view_pass_co_fu;
		
	</script>
</div>

<div class="w3-container w3-margin-bottom">
	
	<!-- Menu for prog add -->

	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Program</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window3').style.display='block';document.getElementById('add_multiple_window3').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window3').style.display='block';document.getElementById('add_single_window3').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		<button onclick="get_prog_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
		<button onclick="get_total_search_results3(0,0)" class="w3-button w3-brown w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-refresh"></i> Refresh</button>
		
			
	</div>
	
	<!-- Window for add single prog -->

	<div id="add_single_window3" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window3_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:290px;"><i class="fa fa-plus"></i> Add Single Program</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="prog_single_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><i class="w3-text-red">*</i> <b>Program Title</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="prog_single_add_title" placeholder="Enter Program Title" autocomplete="off" onkeyup="prog_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Program Code</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="prog_single_add_code" placeholder="Enter Program Code" autocomplete="off" onkeyup="prog_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Program Credit</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" id="prog_single_add_credit" placeholder="Enter Program Credit" autocomplete="off" onkeyup="prog_single_add_form_change()">
						
						<label><i class="w3-text-red">*</i> <b>Department</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="prog_single_add_dept" onchange="prog_single_add_form_change()">
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
						
						<label><i class="w3-text-red">*</i> <b>Status</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="prog_single_add_status" onchange="prog_single_add_form_change()">
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
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="prog_single_add_captcha" autocomplete="off" onkeyup="prog_single_add_form_change()">
								<input type="hidden" value="<?php echo $ccc; ?>" id="prog_single_add_old_captcha">
							</div>
						</div>
						
						
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						
						<button onclick="prog_single_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button onclick="document.getElementById('prog_single_add_re_confirmation').style.display='block';" id="prog_single_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="prog_single_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>
	
	<!-- Window for add multiple prog -->

	<div id="add_multiple_window3" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window3_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:315px;"><i class="fa fa-plus"></i> Add Multiple Program</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="prog_multiple_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_program.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. Don't forget to select a department. You can insert at most <b>50 programs</b> in a single upload under a single department.</li>
					<li>This process may take <b>up to two minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<label><i class="w3-text-red">*</i> <b>Department</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="prog_multiple_add_dept" onchange="prog_single_add_form_change()">
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
					<input class="w3-input w3-border w3-round-large w3-margin-bottom" type="file" id="prog_excel_file" title="Please upload the formatted and filled up excel file."  onchange="prog_multiple_add_form_change()">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="prog_multiple_add_captcha" autocomplete="off" onkeyup="prog_multiple_add_form_change()">
							<input type="hidden" value="<?php echo $ccc; ?>" id="prog_multiple_add_old_captcha">
						</div>
					</div>
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:10px 0px 0px 6px;">
					
					<button onclick="prog_multiple_add_form_clear()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
					</br>	
					<button onclick="document.getElementById('prog_multiple_add_re_confirmation').style.display='block';" id="prog_multiple_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
				</div>
			</div>
			
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="prog_multiple_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="prog_multiple_progress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="prog_multiple_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('prog_multiple_add_box1').style.display='block';document.getElementById('prog_multiple_add_box3').style.display='none';document.getElementById('prog_multiple_add_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="prog_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="prog_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="prog_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="prog_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- window for delete history -->
	<div id="prog_delete_history_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="prog_delete_history_window_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:355px;"><i class="fa fa-history"></i> Program Remove History</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="prog_delete_history_window_box">
			
		</div>
	</div>
	
	<!-- Search box -->

	<div class="w3-container" style="margin: 2px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text3" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_3').style.display='inline-block'; } else { document.getElementById('search_clear_btn_3').style.display='none'; } get_search_result3();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Program Title or Code for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_3" title="Clear search box" onclick="document.getElementById('search_text3').value=''; document.getElementById('search_clear_btn_3').style.display='none';get_search_result3();"></i>
		</div>
	</div>
	
	<!-- Wndow for view result -->

	<div id="search_window3" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box3()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:250px;"><i class="fa fa-eye"></i> Program Details</p>
		<div id="search_window_details3" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	

	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:165px;"><i class="fa fa-server"></i> Programs</p>
	
	<!-- sort options for prog list -->
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort3" onchange="get_total_search_results3(0,0)" type="w3-input w3-round-large">
				<option value="1">Title ASC</option>
				<option value="2">Title DESC</option>
				<option value="3">Code ASC</option>
				<option value="4">Code DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter3').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
		
	<!-- filter for prog list -->
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter3" style="display:none;">
		Status: 
		<select id="filter_status3" onchange="get_total_search_results3(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Active</option>
			<option value="2">Inactive</option>
			
		</select>
		
		<span onclick="document.getElementById('filter3').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
	</div>
	
	<div class="w3-clear"></div>
	
	<!-- table for prog list -->
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label3"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:30%;" valign="top" class="w3-padding-small">Program Title</td>
			<td style="width:20%;" valign="top" class="w3-padding-small">Program Code</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Program Credit</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Total Students</td>
			<td style="width:16%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables3">
		
		
		</tbody>
		<tr id="search_results_loading3" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result3" onclick="get_total_search_results3(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>
	
	function prog_delete_history_window_close()
	{
		document.getElementById('prog_delete_history_window_box').innerHTML='';
		document.getElementById('prog_delete_history_window').style.display='none';
	}
	
	function get_prog_delete_history()
	{
		document.getElementById('prog_delete_history_window').style.display='block';
		document.getElementById('prog_delete_history_window_box').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var xhttp1 = new XMLHttpRequest();
		xhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('prog_delete_history_window_box').innerHTML=this.responseText;
			}
			else if(this.readyState==4 && (this.status==404 || this.status==403))
			{
				prog_delete_history_window_close();
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Network error occurred.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
		};
		xhttp1.open("POST", "../includes/super_admin/get_prog_delete_history.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>, true);
		xhttp1.send();
	}
	
	function add_multiple_window3_close()
	{
		document.getElementById('prog_multiple_add_box1').style.display='block';
		document.getElementById('prog_multiple_add_box2').style.display='none';
		document.getElementById('prog_multiple_add_box3').style.display='none';
		document.getElementById('prog_multiple_add_captcha').value='';
		document.getElementById('prog_excel_file').value='';
		document.getElementById('prog_multiple_add_dept').value='';
		
		document.getElementById('prog_multiple_total').innerHTML='';
		document.getElementById('prog_multiple_success').innerHTML='';
		document.getElementById('prog_multiple_failed').innerHTML='';
		document.getElementById('prog_multiple_logs').innerHTML='';
			
		document.getElementById("prog_multiple_add_save_btn").disabled = true;
		document.getElementById('add_multiple_window3').style.display='none';
	
	}
	
	function prog_multiple_add_form_change()
	{
		var prog_excel_file=document.getElementById('prog_excel_file').value;
		var prog_dept=document.getElementById('prog_multiple_add_dept').value;
		
		if(prog_excel_file=="" || prog_dept=="")
		{
			document.getElementById("prog_multiple_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("prog_multiple_add_save_btn").disabled = false;
		}
	}

	function prog_multiple_add_form_clear()
	{
		document.getElementById('prog_multiple_add_captcha').value='';
		document.getElementById('prog_excel_file').value='';
		document.getElementById('prog_multiple_add_dept').value='';
						
		document.getElementById("prog_multiple_add_save_btn").disabled = true;
		
	}

	function add_single_window3_close()
	{
		document.getElementById('prog_single_add_box1').style.display='block';
		document.getElementById('prog_single_add_box2').style.display='none';
			
		document.getElementById('prog_single_add_title').value='';
		document.getElementById('prog_single_add_code').value='';
		document.getElementById('prog_single_add_credit').value='';
		document.getElementById('prog_single_add_dept').value='';
		document.getElementById('prog_single_add_status').value='';
		document.getElementById('prog_single_add_captcha').value='';
		
		if(prog_single_add_status=='Active')
		{
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_single_add_status').classList.add('w3-pale-green');
		}
		else if(prog_single_add_status=='Inactive')
		{
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		document.getElementById('add_single_window3').style.display='none';
		
		document.getElementById("prog_single_add_save_btn").disabled = true;
		
	}
	
	function prog_single_add_form_change()
	{
		prog_view_title=document.getElementById('prog_single_add_title').value.trim();
		prog_view_code=document.getElementById('prog_single_add_code').value.trim();
		prog_view_credit=document.getElementById('prog_single_add_credit').value.trim();
		prog_view_dept=document.getElementById('prog_single_add_dept').value.trim();
		prog_view_captcha=document.getElementById('prog_single_add_captcha').value.trim();
		prog_view_status=document.getElementById('prog_single_add_status').value.trim();
		
		if(prog_single_add_status=='Active')
		{
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_single_add_status').classList.add('w3-pale-green');
		}
		else if(prog_single_add_status=='Inactive')
		{
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_single_add_status').classList.remove('w3-pale-red');
			}
		}
		if(prog_view_title=="" || prog_view_code=="" || prog_view_credit=="" || prog_view_dept=="" || prog_view_status=="")
		{
			document.getElementById("prog_single_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("prog_single_add_save_btn").disabled = false;
		}
	}

	function prog_single_add_form_reset()
	{
		document.getElementById('prog_single_add_title').value='';
		document.getElementById('prog_single_add_code').value='';
		document.getElementById('prog_single_add_credit').value='';
		document.getElementById('prog_single_add_dept').value='';
		document.getElementById('prog_single_add_status').value='';
		document.getElementById('prog_single_add_captcha').value='';
						
		document.getElementById("prog_single_add_save_btn").disabled = true;
	}
	
	function prog_multiple_add_form_save()
	{
		var prog_excel_file=document.getElementById('prog_excel_file').value;
		var prog_dept=document.getElementById('prog_multiple_add_dept').value;
		prog_view_captcha=document.getElementById('prog_multiple_add_captcha').value.trim();
		prog_view_old_captcha=document.getElementById('prog_multiple_add_old_captcha').value.trim();
		
		if(prog_dept=="" || prog_excel_file=="" || file_validate3(prog_excel_file)==false)
		{
			document.getElementById('prog_multiple_add_pass').value='';
			
			document.getElementById('prog_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById("prog_multiple_add_save_btn").disabled = true;
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload the required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
	
		}
		else if(prog_view_captcha=="" || prog_view_captcha!=prog_view_old_captcha)
		{
			document.getElementById('prog_multiple_add_pass').value='';
			
			document.getElementById('prog_multiple_add_re_confirmation').style.display='none';
		
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(prog_multiple_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('prog_multiple_add_pass').value.trim();
			
			document.getElementById('prog_multiple_add_pass').value='';
			
			document.getElementById('prog_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('prog_multiple_add_box1').style.display='none';
			document.getElementById('prog_multiple_add_box3').style.display='none';
			document.getElementById('prog_multiple_add_box2').style.display='block';
			
			document.getElementById('prog_multiple_total').innerHTML='';
			document.getElementById('prog_multiple_success').innerHTML='';
			document.getElementById('prog_multiple_failed').innerHTML='';
			document.getElementById('prog_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('prog_excel_file').files[0];
			var fd_excel=new FormData();
			var link='prog_excel_file';
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
						
						
						document.getElementById('prog_multiple_progress_id').style.width='0%';
						document.getElementById('prog_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('prog_multiple_add_box1').style.display='none';
						document.getElementById('prog_multiple_add_box3').style.display='block';
						document.getElementById('prog_multiple_add_box2').style.display='none';
				
						document.getElementById('prog_multiple_total').innerHTML=total;
						document.getElementById('prog_multiple_success').innerHTML=success;
						document.getElementById('prog_multiple_failed').innerHTML=failed;
						document.getElementById('prog_multiple_logs').innerHTML=logs;
			
						prog_multiple_add_form_clear();
						get_total_search_results3(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('prog_multiple_progress_id').style.width='0%';
						document.getElementById('prog_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('prog_multiple_add_box1').style.display='block';
						document.getElementById('prog_multiple_add_box3').style.display='none';
						document.getElementById('prog_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u2')
					{
						document.getElementById('prog_multiple_progress_id').style.width='0%';
						document.getElementById('prog_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('prog_multiple_add_box1').style.display='block';
						document.getElementById('prog_multiple_add_box3').style.display='none';
						document.getElementById('prog_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (department inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('prog_multiple_progress_id').style.width='0%';
						document.getElementById('prog_multiple_progress_id').innerHTML='0%';
						
						document.getElementById('prog_multiple_add_box1').style.display='block';
						document.getElementById('prog_multiple_add_box3').style.display='none';
						document.getElementById('prog_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('prog_multiple_progress_id').style.width='0%';
					document.getElementById('prog_multiple_progress_id').innerHTML='0%';
					
					document.getElementById('prog_multiple_add_box1').style.display='block';
					document.getElementById('prog_multiple_add_box3').style.display='none';
					document.getElementById('prog_multiple_add_box2').style.display='none';
			
					
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
					 document.getElementById('prog_multiple_progress_id').style.width=percentComplete+'%';
					 document.getElementById('prog_multiple_progress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('prog_multiple_progress_id').style.width=percentComplete+'%';
					 document.getElementById('prog_multiple_progress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass+"&prog_dept="+prog_dept, true);
			xhttp1.send(fd_excel);
		}
	}

	
	function prog_single_add_form_save()
	{
		prog_view_title=document.getElementById('prog_single_add_title').value.trim();
		prog_view_code=document.getElementById('prog_single_add_code').value.trim();
		prog_view_credit=document.getElementById('prog_single_add_credit').value.trim();
		prog_view_dept=document.getElementById('prog_single_add_dept').value.trim();
		prog_view_captcha=document.getElementById('prog_single_add_captcha').value.trim();
		prog_view_old_captcha=document.getElementById('prog_single_add_old_captcha').value.trim();
		prog_view_status=document.getElementById('prog_single_add_status').value.trim();
		
		if(prog_view_title=="" || prog_view_code=="" || prog_view_credit=="" || prog_view_dept=="" || prog_view_status=="")
		{
			document.getElementById('prog_single_add_pass').value='';
			
			document.getElementById('prog_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(prog_view_captcha=="" || prog_view_captcha!=prog_view_old_captcha)
		{
			document.getElementById('prog_single_add_pass').value='';
			
			document.getElementById('prog_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(prog_single_add_pass_co_fu()==true)
		{
			
			
			var pass=document.getElementById('prog_single_add_pass').value.trim();
			
			document.getElementById('prog_single_add_pass').value='';
			
			document.getElementById('prog_single_add_re_confirmation').style.display='none';
			
			
			document.getElementById('prog_single_add_box1').style.display='none';
			document.getElementById('prog_single_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						add_single_window3_close();
						
						get_search_result3();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Program successfully added.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('prog_single_add_box1').style.display='block';
						document.getElementById('prog_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('prog_single_add_box1').style.display='block';
						document.getElementById('prog_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this program (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('prog_single_add_box1').style.display='block';
						document.getElementById('prog_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this program (department inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('prog_single_add_box1').style.display='block';
						document.getElementById('prog_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('prog_single_add_box1').style.display='block';
					document.getElementById('prog_single_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_program.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&prog_title="+prog_view_title+"&prog_code="+prog_view_code+"&prog_credit="+prog_view_credit+"&prog_dept="+prog_view_dept+"&prog_status="+prog_view_status, true);
			xhttp1.send();
		}
	
	}
	
	
	var prog_view_old_title;
	var prog_view_old_code;
	var prog_view_old_dept;
	var prog_view_old_credit;
	var prog_view_old_captcha;
	var prog_view_old_status;
	
	var prog_view_title;
	var prog_view_code;
	var prog_view_dept;
	var prog_view_credit;
	var prog_view_captcha;
	var prog_view_status;
	
	function remove_prog_view()
	{
		var pass=document.getElementById('prog_view_pass').value.trim();
		if(reservation_captcha_val_prog_view_confirm()==true && prog_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_prog_view_confirm').value='';
			document.getElementById('prog_view_pass').value='';
			
			document.getElementById('prog_view_re_confirmation').style.display='none';
			
			var prog_id=document.getElementById('prog_view_id').value.trim();
			
			document.getElementById('prog_view_box1').style.display='none';
			document.getElementById('prog_view_box3').style.display='none';
			document.getElementById('prog_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						get_search_result3();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Program successfully removed.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('prog_view_box1').style.display='block';
						document.getElementById('prog_view_box2').style.display='none';
						document.getElementById('prog_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('prog_view_box1').style.display='block';
						document.getElementById('prog_view_box3').style.display='none';
						document.getElementById('prog_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to remove this program.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('prog_view_box1').style.display='block';
						document.getElementById('prog_view_box2').style.display='none';
						document.getElementById('prog_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('prog_view_box1').style.display='block';
					document.getElementById('prog_view_box2').style.display='none';
					document.getElementById('prog_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_program.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_id="+prog_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function prog_view_form_change()
	{
		prog_view_title=document.getElementById('prog_view_title').value.trim();
		prog_view_code=document.getElementById('prog_view_code').value.trim();
		prog_view_credit=document.getElementById('prog_view_credit').value.trim();
		prog_view_dept=document.getElementById('prog_view_dept').value.trim();
		prog_view_captcha=document.getElementById('prog_view_captcha').value.trim();
		prog_view_status=document.getElementById('prog_view_status').value.trim();
		
		prog_view_old_title=document.getElementById('prog_view_old_title').value.trim();
		prog_view_old_code=document.getElementById('prog_view_old_code').value.trim();
		prog_view_old_credit=document.getElementById('prog_view_old_credit').value.trim();
		prog_view_old_dept=document.getElementById('prog_view_old_dept').value.trim();
		prog_view_old_captcha=document.getElementById('prog_view_old_captcha').value.trim();
		prog_view_old_status=document.getElementById('prog_view_old_status').value.trim();
		
		if(prog_view_status=='Active')
		{
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_view_status').classList.add('w3-pale-red');
		}
		
		if(prog_view_title=="" || prog_view_code=="" || prog_view_status=="" || prog_view_dept=="" || prog_view_credit=="" || (prog_view_title==prog_view_old_title && prog_view_code==prog_view_old_code && prog_view_credit==prog_view_old_credit && prog_view_dept==prog_view_old_dept && prog_view_status==prog_view_old_status))
		{
			document.getElementById("prog_view_save_btn").disabled = true;
		}
		else if(prog_view_title!=prog_view_old_title || prog_view_code!=prog_view_old_code || prog_view_status!=prog_view_old_status || prog_view_credit!=prog_view_old_credit || prog_view_dept!=prog_view_old_dept)
		{
			document.getElementById("prog_view_save_btn").disabled = false;
		}
	}
	
	function prog_view_form_reset()
	{
		prog_view_old_title=document.getElementById('prog_view_old_title').value.trim();
		prog_view_old_code=document.getElementById('prog_view_old_code').value.trim();
		prog_view_old_credit=document.getElementById('prog_view_old_credit').value.trim();
		prog_view_old_dept=document.getElementById('prog_view_old_dept').value.trim();
		prog_view_old_captcha=document.getElementById('prog_view_old_captcha').value.trim();
		prog_view_old_status=document.getElementById('prog_view_old_status').value.trim();
		
		document.getElementById('prog_view_title').value=prog_view_old_title;
		document.getElementById('prog_view_code').value=prog_view_old_code;
		document.getElementById('prog_view_credit').value=prog_view_old_credit;
		document.getElementById('prog_view_dept').value=prog_view_old_dept;
		document.getElementById('prog_view_captcha').value='';
		document.getElementById('prog_view_status').value=prog_view_old_status;
		
		prog_view_status=document.getElementById('prog_view_status').value.trim();
		
		if(prog_view_status=='Active')
		{
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('prog_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('prog_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('prog_view_status').classList.add('w3-pale-red');
		}
		
		document.getElementById("prog_view_save_btn").disabled = true;
	}
	
	function prog_view_form_save_changes(prog_id)
	{
		prog_view_title=document.getElementById('prog_view_title').value.trim();
		prog_view_code=document.getElementById('prog_view_code').value.trim();
		prog_view_credit=document.getElementById('prog_view_credit').value.trim();
		prog_view_dept=document.getElementById('prog_view_dept').value.trim();
		prog_view_captcha=document.getElementById('prog_view_captcha').value.trim();
		prog_view_status=document.getElementById('prog_view_status').value.trim();
		
		prog_view_old_title=document.getElementById('prog_view_old_title').value.trim();
		prog_view_old_code=document.getElementById('prog_view_old_code').value.trim();
		prog_view_old_credit=document.getElementById('prog_view_old_credit').value.trim();
		prog_view_old_dept=document.getElementById('prog_view_old_dept').value.trim();
		prog_view_old_captcha=document.getElementById('prog_view_old_captcha').value.trim();
		prog_view_old_status=document.getElementById('prog_view_old_status').value.trim();
		
		
		if(prog_view_title=="" || prog_view_code=="" || prog_view_status=="" || prog_view_credit=="" || prog_view_dept=="")
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(prog_view_captcha=="" || prog_view_captcha!=prog_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else
		{
			document.getElementById('prog_view_box1').style.display='none';
			document.getElementById('prog_view_box3').style.display='none';
			document.getElementById('prog_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText.trim()=='Ok')
					{
						close_search_box3();
						view_result3(prog_id);
						
						get_total_search_results3(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('prog_view_box1').style.display='block';
						document.getElementById('prog_view_box2').style.display='none';
						document.getElementById('prog_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('prog_view_box1').style.display='block';
						document.getElementById('prog_view_box2').style.display='none';
						document.getElementById('prog_view_box3').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('prog_view_box1').style.display='block';
					document.getElementById('prog_view_box2').style.display='none';
					document.getElementById('prog_view_box3').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_program.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_title="+prog_view_title+"&prog_code="+prog_view_code+"&prog_status="+prog_view_status+"&prog_credit="+prog_view_credit+"&prog_dept="+prog_view_dept+"&prog_id="+prog_id, true);
			xhttp1.send();
		}
		
	}
	
	function get_search_result3()
	{
		close_search_box3();
		get_total_search_results3(0,0);
	}
	
	function view_result3(prog_id)
	{
		
		document.getElementById('search_window3').style.display='block';
		var page3=document.getElementById('page3');
		page3.scrollTop = 20;
		document.getElementById('search_window_details3').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details3').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details3').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results3.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_id="+prog_id, true);
		search_window_result.send();
		
		
	}
	
	function close_search_box3()
	{
		document.getElementById('search_window_details3').innerHTML='';
		document.getElementById('search_window3').style.display='none';
	}
	
	
	var page3=0,total3;
	function get_total_search_results3(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading3").innerHTML='<td colspan="6"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort3').value;
		var search_text=document.getElementById('search_text3').value.trim();
		var filter_status3=document.getElementById('filter_status3').value.trim();
		var dept_id3=document.getElementById('dept_id3').value.trim();
		
		
		var total3_results = new XMLHttpRequest();
		total3_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total3=parseInt(this.responseText.trim());
				get_search_results3(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total3=0;
				get_search_results3(x,y);
			}
		};
		document.getElementById('search_data_label3').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total3_results.open("GET", "../includes/super_admin/get_total_search_results3.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&filter_status3="+filter_status3+"&dept_id="+dept_id3, true);
		total3_results.send();
		
	}
	
	function get_search_results3(x,y)
	{
		if(x==0)
		{
			page3=0;
			document.getElementById('search_result_tables3').innerHTML='';
		}
		if(total3!=0)
		{
			var r_sort=document.getElementById('search_result_sort3').value;
			var search_text=document.getElementById('search_text3').value.trim();
			var filter_status3=document.getElementById('filter_status3').value.trim();
			var dept_id3=document.getElementById('dept_id3').value.trim();
		
		
			document.getElementById("show_more_btn_search_result3").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading3").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables3').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables3').innerHTML=document.getElementById('search_result_tables3').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label3').innerHTML=total3;
					
					if(total3>page3)
					{
						document.getElementById("show_more_btn_search_result3").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label3').innerHTML='N/A';
					document.getElementById("search_results_loading3").innerHTML = '<td colspan="6"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page3;
			page3=page3+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results3.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&filter_status3="+filter_status3+"&dept_id="+dept_id3, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading3").innerHTML='';
			document.getElementById('search_data_label3').innerHTML='N/A';
			document.getElementById('search_result_tables3').innerHTML='<tr><td colspan="6"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result3").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa3_btn = document.getElementById("pa3_btn");
	var pa3=document.getElementById('page3');
	// When the user scrolls down 20px from the top of the document, show the button
	pa3.onscroll = function() {pa3_scrollFunction()};

	function pa3_scrollFunction() {
	  if (pa3.scrollTop > 20) {
		pa3_btn.style.display = "block";
	  } else {
		pa3_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa3_topFunction() {
	  pa3.scrollTop = 0;
	}
	
	
	get_search_result3();
	

</script>