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

<i onclick="pa9_topFunction()" id="pa9_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<!-- top filter -->
<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
	<i class="fa fa-folder-open-o"></i> Program: 
	<select onchange="get_search_result9();" id="program_id9" style="max-width:150px;">
		
	</select>
	
</p>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select onchange="reload_dept9()" id="dept_id9" style="max-width:150px;">
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


<!-- Confirmation modal for result delete -->
<div id="result_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove this result?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="result_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_result_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_result_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('result_view_re_confirmation').style.display='none';document.getElementById('captcha_result_view_confirm').value='';document.getElementById('result_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_result_view_confirm = document.getElementById("captcha_result_view_confirm");
		var sol_result_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_result_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_result_view_confirm.value != sol_result_view_confirm) {
			reservation_captcha_result_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_result_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_result_view_confirm.onchange=reservation_captcha_val_result_view_confirm;
	
	
		var pass_result_view_confirm = document.getElementById("result_view_pass");
		function result_view_pass_co_fu()
		{
			if(pass_result_view_confirm.value.trim()!="")
			{
				pass_result_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_result_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_result_view_confirm.onchange=result_view_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for edit multiple -->
<div id="result_multiple_edit_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to edit all the results?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="result_multiple_edit_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="result_multiple_edit_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('result_multiple_edit_re_confirmation').style.display='none';document.getElementById('result_multiple_edit_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_result_multiple_edit_confirm = document.getElementById("result_multiple_edit_pass");
		function result_multiple_edit_pass_co_fu()
		{
			if(pass_result_multiple_edit_confirm.value.trim()!="")
			{
				pass_result_multiple_edit_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_result_multiple_edit_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_result_multiple_edit_confirm.onchange=result_multiple_edit_pass_co_fu;
		
	</script>
</div>



<!-- Confirmation modal for add single result-->
<div id="result_single_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add this result?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="result_single_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="result_single_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('result_single_add_re_confirmation').style.display='none';document.getElementById('result_single_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_result_single_add_confirm = document.getElementById("result_single_add_pass");
		function result_single_add_pass_co_fu()
		{
			if(pass_result_single_add_confirm.value.trim()!="")
			{
				pass_result_single_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_result_single_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_result_single_add_confirm.onchange=result_single_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add multiple -->
<div id="result_multiple_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the results?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="result_multiple_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="result_multiple_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('result_multiple_add_re_confirmation').style.display='none';document.getElementById('result_multiple_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_result_multiple_add_confirm = document.getElementById("result_multiple_add_pass");
		function result_multiple_add_pass_co_fu()
		{
			if(pass_result_multiple_add_confirm.value.trim()!="")
			{
				pass_result_multiple_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_result_multiple_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_result_multiple_add_confirm.onchange=result_multiple_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for remove multiple -->
<div id="result_multiple_remove_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove the selected results?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="result_multiple_remove_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="result_multiple_remove_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('result_multiple_remove_re_confirmation').style.display='none';document.getElementById('result_multiple_remove_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_result_multiple_remove_confirm = document.getElementById("result_multiple_remove_pass");
		function result_multiple_remove_pass_co_fu()
		{
			if(pass_result_multiple_remove_confirm.value.trim()!="")
			{
				pass_result_multiple_remove_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_result_multiple_remove_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_result_multiple_remove_confirm.onchange=result_multiple_remove_pass_co_fu;
		
	</script>
</div>


<div class="w3-container w3-margin-bottom w3-margin-top">
	
	<!-- Menu -->
	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Result</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window9').style.display='block';document.getElementById('add_multiple_window9').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window9').style.display='block';document.getElementById('add_single_window9').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		
		<button onclick="document.getElementById('remove_multiple_window9').style.display='block';" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-eraser"></i> Remove Multiple</button>
		
		<button onclick="document.getElementById('edit_multiple_window9').style.display='block';" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-edit"></i> Edit Multiple</button>
		
		<button onclick="get_result_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
		
		<button onclick="get_total_search_results9(0,0)" class="w3-button w3-brown w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-refresh"></i> Refresh</button>
	</div>
	
	<!-- window for edit multiple -->
	<div id="edit_multiple_window9" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="edit_multiple_window9_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:290px;"><i class="fa fa-edit"></i> Edit Multiple Result</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="result_multiple_edit_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_edit_result.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. You can edit at most <b>300 results</b> in a single upload. <b>Note:</b> In multiple edit you can change the <b>status, remarks and marks</b> of the result.</li>
					<li>Please select the semester carefully also insert year in the format of <b>YYYY</b>. System will search for the result by matching <b>student ID, Course Code, Semester</b>.</li>
					<li>This process may take <b>up to six minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<label><i class="w3-text-red">*</i> <b>Upload Excel File</b></label>
					<input class="w3-input w3-border w3-round-large w3-margin-bottom" type="file" id="result_edit_excel_file" title="Please upload the formatted and filled up excel file."  onchange="result_multiple_edit_form_change()">
					
					<?php
						//spam Check 
						$aaa=rand(1,20);
						$bbb=rand(1,20);
						$ccc=$aaa+$bbb;
					?>
					<input type="hidden" value="<?php echo $ccc; ?>" id="result_multiple_edit_old_captcha">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="result_multiple_edit_captcha" autocomplete="off" oninput="result_multiple_edit_form_change()">
						</div>
					</div>
									
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					<button onclick="result_multiple_edit_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
					
					
					<button onclick="document.getElementById('result_multiple_edit_re_confirmation').style.display='block';" id="result_multiple_edit_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
				
				
				</div>
			</div>
		
		</div>
			<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="result_multiple_edit_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="result_multiple_edit_studentress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="result_multiple_edit_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('result_multiple_edit_box1').style.display='block';document.getElementById('result_multiple_edit_box3').style.display='none';document.getElementById('result_multiple_edit_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="result_edit_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="result_edit_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="result_edit_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="result_edit_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	
	<!-- Window for add multiple result -->
	<div id="add_multiple_window9" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window9_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:285px;"><i class="fa fa-plus"></i> Add Multiple Result</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="result_multiple_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_result.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. Don't forget to select the program, course, course instructor and semester in the below form. You can insert at most <b>300 results</b> in a single upload under a single program for a single course and a course instructor in a particular semester.</li>
					<li>This process may take <b>up to six minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<div class="w3-row"  style="margin:0px 0px 0px 0px;padding:0px;">
							
						<div class="w3-col" style="width:49%;">
							<label><i class="w3-text-red">*</i> <b>Select Program</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_add_prog" onchange="result_multiple_add_program_change()">
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
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
						
							<label><i class="w3-text-red">*</i> <b>Select Course</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_add_course" onchange="result_multiple_add_form_change()" disabled>
								<option value="">Select</option>
							</select>
						</div>
					</div>
					<label><i class="w3-text-red">*</i> <b>Select Course Instructor</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_add_course_instructor" onchange="result_multiple_add_form_change()" disabled>
						<option value="">Select</option>
						<?php
							$stmt = $conn->prepare("SELECT nr_faculty_id,nr_faculty_name,nr_faculty_designation,nr_dept_title FROM nr_faculty,nr_department where nr_faculty.nr_dept_id=nr_department.nr_dept_id and nr_faculty_resign_date='' and nr_faculty_status='Active' order by nr_faculty_name asc");
							$stmt->execute();
							$stud_result=$stmt->fetchAll();
							if(count($stud_result)>0)
							{
								$sz=count($stud_result);
								for($k=0;$k<$sz;$k++)
								{
									$faculty_id=$stud_result[$k][0];
									$faculty_name=$stud_result[$k][1];
									echo '<option value="'.$faculty_id.'">'.$faculty_name.', '.$stud_result[$k][2].' ('.$stud_result[$k][3].')</option>';
								}
							}
						?>
					</select>
						
					<label><i class="w3-text-red">*</i> <b>Select Semester</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_add_semester" onchange="result_multiple_add_form_change()" disabled>
						<option value="">Select</option>
						<?php
							$yy=get_current_year();
							$ss=get_current_semester();
							if($global_result_insert_semester_limit_flag==1)
							{
								$y=$yy-2;
							}
							else
							{
								$y=2012;
							}
							for($i=$y;$i<=$yy;$i++)
							{
								if($ss=='Spring' && $i==$yy) break;
								echo '<option value="Spring '.$i.'">Spring '.$i.'</option>';
								if($ss=='Summer' && $i==$yy) break;
								echo '<option value="Summer '.$i.'">Summer '.$i.'</option>';
								if($ss=='Fall' && $i==$yy) break;
								echo '<option value="Fall '.$i.'">Fall '.$i.'</option>';
								
							}
						?>
					</select>
					<label><i class="w3-text-red">*</i> <b>Upload Excel File</b></label>
					<input class="w3-input w3-border w3-round-large w3-margin-bottom" type="file" id="result_excel_file" title="Please upload the formatted and filled up excel file."  onchange="result_multiple_add_form_change()" disabled>
					
					<?php
						//spam Check 
						$aaa=rand(1,20);
						$bbb=rand(1,20);
						$ccc=$aaa+$bbb;
					?>
					<input type="hidden" value="<?php echo $ccc; ?>" id="result_multiple_add_old_captcha">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="result_multiple_add_captcha" autocomplete="off" oninput="result_multiple_add_form_change()" disabled>
						</div>
					</div>
									
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<button onclick="result_multiple_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
					
					
					<button onclick="document.getElementById('result_multiple_add_re_confirmation').style.display='block';" id="result_multiple_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
				
				
				</div>
			</div>
		
		</div>
			<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="result_multiple_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="result_multiple_studentress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="result_multiple_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('result_multiple_add_box1').style.display='block';document.getElementById('result_multiple_add_box3').style.display='none';document.getElementById('result_multiple_add_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="result_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="result_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="result_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="result_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Window for remove multiple result -->
	<div id="remove_multiple_window9" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="remove_multiple_window9_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:333px;"><i class="fa fa-plus"></i> Remove Multiple Result</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="result_multiple_remove_box1">
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<div class="w3-row"  style="margin:0px 0px 0px 0px;padding:0px;">
							
						<div class="w3-col" style="width:49%;">
							<label><i class="w3-text-red">*</i> <b>Select Program</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_remove_prog" onchange="result_multiple_remove_program_change()">
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
						</div>
						<div class="w3-col" style="margin-left:2%;width:49%;">
						
							<label><i class="w3-text-red">*</i> <b>Select Course</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_remove_course" onchange="result_multiple_remove_course_change()" disabled>
								<option value="">Select</option>
							</select>
						</div>
					</div>
					
					<label><i class="w3-text-red">*</i> <b>Select Semester</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_remove_semester" onchange="result_multiple_remove_semester_change()" disabled>
						<option value="">Select</option>
						
					</select>
					
					
					<label><i class="w3-text-red">*</i> <b>Select Course Instructor</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_multiple_remove_course_instructor" onchange="result_multiple_remove_form_change()" disabled>
						<option value="">Select</option>
					</select>
						
					
					<?php
						//spam Check 
						$aaa=rand(1,20);
						$bbb=rand(1,20);
						$ccc=$aaa+$bbb;
					?>
					<input type="hidden" value="<?php echo $ccc; ?>" id="result_multiple_remove_old_captcha">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="result_multiple_remove_captcha" autocomplete="off" oninput="result_multiple_remove_form_change()" disabled>
						</div>
					</div>
									
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<button onclick="result_multiple_remove_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
					
					
					<button onclick="document.getElementById('result_multiple_remove_re_confirmation').style.display='block';" id="result_multiple_remove_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
				
				
				</div>
			</div>
		
		</div>
			<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="result_multiple_remove_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="result_multiple_remove_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('result_multiple_remove_box1').style.display='block';document.getElementById('result_multiple_remove_box3').style.display='none';document.getElementById('result_multiple_remove_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="result_multiple_remove_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="result_multiple_remove_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="result_multiple_remove_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="result_multiple_remove_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	
	<!-- Window for add single result -->
	<div id="add_single_window9" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window9_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:255px;"><i class="fa fa-plus"></i> Add Single Result</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="result_single_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<div class="w3-row"  style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								
								<label><i class="w3-text-red">*</i> <b>Select Program</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_single_add_prog" onchange="result_single_add_program_change()">
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
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
							
								<label><i class="w3-text-red">*</i> <b>Select Course</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_single_add_course" onchange="result_single_add_form_change()" disabled>
									<option value="">Select</option>
								</select>
							</div>
						</div>
						<label><i class="w3-text-red">*</i> <b>Select Course Instructor</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_single_add_course_instructor" onchange="result_single_add_form_change()" disabled>
							<option value="">Select</option>
							<?php
								$stmt = $conn->prepare("SELECT nr_faculty_id,nr_faculty_name,nr_faculty_designation,nr_dept_title FROM nr_faculty,nr_department where nr_faculty.nr_dept_id=nr_department.nr_dept_id and nr_faculty_resign_date='' and nr_faculty_status='Active' order by nr_faculty_name asc");
								$stmt->execute();
								$stud_result=$stmt->fetchAll();
								if(count($stud_result)>0)
								{
									$sz=count($stud_result);
									for($k=0;$k<$sz;$k++)
									{
										$faculty_id=$stud_result[$k][0];
										$faculty_name=$stud_result[$k][1];
										echo '<option value="'.$faculty_id.'">'.$faculty_name.', '.$stud_result[$k][2].' ('.$stud_result[$k][3].')</option>';
									}
								}
							?>
						</select>
						
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:35%;">
								<label><i class="w3-text-red">*</i> <b>Student ID</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" placeholder="Enter Student ID" autocomplete="off" id="result_single_add_student_id" oninput="result_single_add_form_change()" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:63%;">
								<label><b>Student Name</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" placeholder="---- N/A ----" autocomplete="off" id="result_single_add_student_name" disabled>
							</div>
						</div>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:32%;">
								<label><i class="w3-text-red">*</i> <b>Marks</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number"  placeholder="Enter Marks" id="result_single_add_marks" autocomplete="off"  oninput="result_single_add_form_change()" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:32%;">
								<label><b>Grade</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="result_single_add_grade" placeholder="---- N/A ----" autocomplete="off" disabled>
								
							</div>
							<div class="w3-col" style="margin-left:2%;width:32%;">
								<label><b>Grade Point</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="result_single_add_grade_point" placeholder="---- N/A ----" autocomplete="off" disabled>
								
							</div>
						</div>
						<div class="w3-row"  style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Remarks</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_single_add_remarks" onchange="result_single_add_form_change()" disabled>
									<option value="">N/A</option>
									<option value="Incomplete">Incomplete</option>
									<option value="Expelled_Mid">Expelled_Mid</option>
									<option value="MakeUp_MS">MakeUp_MS</option>
									<option value="MakeUp_SF">MakeUp_SF</option>
									<option value="MakeUp_MS_SF">MakeUp_MS_SF</option>
									<option value="Expelled_SF">Expelled_SF</option>
									<option value="MakeUp_MS, Expelled_SF">MakeUp_MS, Expelled_SF</option>
									<option value="MakeUp_MS, Incomplete">MakeUp_MS, Incomplete</option>
									<option value="Improvement">Improvement</option>
									<option value="Retake">Retake</option>
								</select>
							</div>
							
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><i class="w3-text-red">*</i> <b>Select Semester</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_single_add_semester" onchange="result_single_add_form_change()" disabled>
									<option value="">Select</option>
									<?php
										$yy=get_current_year();
										$ss=get_current_semester();
										if($global_result_insert_semester_limit_flag==1)
										{
											$y=$yy-2;
										}
										else
										{
											$y=2012;
										}
										for($i=$y;$i<=$yy;$i++)
										{
											if($ss=='Spring' && $i==$yy) break;
											echo '<option value="Spring '.$i.'">Spring '.$i.'</option>';
											if($ss=='Summer' && $i==$yy) break;
											echo '<option value="Summer '.$i.'">Summer '.$i.'</option>';
											if($ss=='Fall' && $i==$yy) break;
											echo '<option value="Fall '.$i.'">Fall '.$i.'</option>';
											
										}
									?>
								</select>
								
							</div>
						</div>
						<label><i class="w3-text-red">*</i> <b>Status</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="result_single_add_status" onchange="result_single_add_form_change()" disabled>
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
						<input type="hidden" value="<?php echo $ccc; ?>" id="result_single_add_old_captcha">
						
						<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:40%;">
								<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:58%;">
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="result_single_add_captcha" autocomplete="off" oninput="result_single_add_form_change()" disabled>
							</div>
						</div>
							
							
						
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
						<button onclick="result_single_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						
						<button onclick="document.getElementById('result_single_add_re_confirmation').style.display='block';" id="result_single_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					
					</div>
				</div>
			</div>
		</div>
		
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="result_single_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>
	
	
	<!-- window for delete history -->
	<div id="result_delete_history_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="result_delete_history_window_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:320px;"><i class="fa fa-history"></i> Result Remove History</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="result_delete_history_window_box">
			
		</div>
	</div>
	
	
	<!-- search box -->
	<div class="w3-container" style="margin: 9px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text9" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_9').style.display='inline-block'; } else { document.getElementById('search_clear_btn_9').style.display='none'; } get_search_result9()" class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Student or Course Info for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_9" title="Clear search box" onclick="document.getElementById('search_text9').value=''; document.getElementById('search_clear_btn_9').style.display='none';get_search_result9();"></i>
		</div>
	</div>
	
	
	<!-- Details Window -->
	<div id="search_window9" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box9()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<span onclick="print_result_view()" title="Print Window" class="w3-button w3-right w3-large w3-indigo w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 10px 0px 0px;"><i class="fa fa-print"></i></span>
		
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:215px;"><i class="fa fa-eye"></i> Result Details</p>
		<div id="search_window_details9" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>

	
	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:130px;"><i class="fa fa-server"></i> Results</p>
	
	<!-- Sort -->
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort9" onchange="get_total_search_results9(0,0)" type="w3-input w3-round-large">
				<option value="1">Result ASC</option>
				<option value="2">Result DESC</option>
				<option value="3">Student ID ASC</option>
				<option value="4">Student ID DESC</option>
				<option value="5">Course Code ASC</option>
				<option value="6">Course Code DESC</option>
				<option value="7">Course Title ASC</option>
				<option value="8">Course Title DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter9').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	
	</p>
	
	<div class="w3-clear"></div>
	
	<!-- Filter -->
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter9" style="display:none;">
		Course Instructor: 
		<select id="filter_instructor9" onchange="get_total_search_results9(0,0)" type="w3-input w3-round-large" style="max-width:150px;">
			<option value="-1">All</option>
			<?php 
				$stmt = $conn->prepare("SELECT nr_faculty_id,nr_faculty_name FROM nr_faculty order by nr_faculty_name asc");
				$stmt->execute();
				$stud_result=$stmt->fetchAll();
				if(count($stud_result)>0)
				{
					$sz=count($stud_result);
					for($k=0;$k<$sz;$k++)
					{
						echo '<option value="'.$stud_result[$k][0].'">'.$stud_result[$k][1].'</option>';
					}
				}
			?>
			
		</select>
		&nbsp;Semester: 
		<select id="filter_semester9" onchange="get_total_search_results9(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<?php 
			
				for($year=2012;$year<=Date("Y");$year++)
				{
					echo '<option value="Spring-'.$year.'">Spring-'.$year.'</option>';
					echo '<option value="Summer-'.$year.'">Summer-'.$year.'</option>';
					echo '<option value="Fall-'.$year.'">Fall-'.$year.'</option>';	
				}
			?>
			
		</select>
		&nbsp;Grade: 
		<select id="filter_grade9" onchange="get_total_search_results9(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">A+</option>
			<option value="2">A</option>
			<option value="3">A-</option>
			<option value="4">B+</option>
			<option value="5">B</option>
			<option value="6">B-</option>
			<option value="7">C+</option>
			<option value="8">C</option>
			<option value="9">D</option>
			<option value="10">F</option>
		</select>
		
		&nbsp;Status:
		<select id="filter_status9" onchange="get_total_search_results9(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="Active">Active</option>
			<option value="Inactive">Inactive</option>
		</select>
		 
		<span onclick="document.getElementById('filter9').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
	</div>

	<div class="w3-clear"></div>
		
	<!-- Table -->	
	<p class="w3-margin-0 w3-padding-0 w3-medium w3-left">Total Data: <span class="w3-text-red" id="search_data_label9"></span></p>		
	<p class="w3-margin-0 w3-padding-0 w3-medium w3-left w3-margin-left"><i class="fa fa-print w3-hover-text-teal w3-text-indigo w3-cursor" onclick="print_results()"> Print</i></p>		
	<div class="w3-clear"></div>
	
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:7%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:15%;" valign="top" class="w3-padding-small">Semester</td>
			<td style="width:13%;" valign="top" class="w3-padding-small">Student ID</td>
			<td style="width:11%;" valign="top" class="w3-padding-small">Course Code</td>
			<td style="width:28%;" valign="top" class="w3-padding-small">Course Title</td>
			<td style="width:8%;" valign="top" class="w3-padding-small">Credit</td>
			<td style="width:8%;" valign="top" class="w3-padding-small">Grade</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables9">
		
		
		</tbody>
		<tr id="search_results_loading9" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result9" onclick="get_total_search_results9(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>


<script>
	/****************************************/
	function print_results()
	{
		var r_sort=document.getElementById('search_result_sort9').value;
		var search_text=document.getElementById('search_text9').value.trim();
		var dept_id=document.getElementById('dept_id9').value;
		var prog_id=document.getElementById('program_id9').value;
		var filter_semester=document.getElementById('filter_semester9').value;
		var filter_grade=document.getElementById('filter_grade9').value;
		var filter_instructor=document.getElementById('filter_instructor9').value;
		var filter_status=document.getElementById('filter_status9').value;
		
		window.open('../includes/super_admin/result_print.php?admin_id='+<?php echo $_SESSION["admin_id"]; ?>+'&sort='+r_sort+'&search_text='+search_text+'&filter_status='+filter_status+'&filter_semester='+filter_semester+'&filter_grade='+filter_grade+'&filter_instructor='+filter_instructor+'&program_id='+prog_id+'&dept_id='+dept_id);		
	}
	
	function print_results_delete_history()
	{
		window.open('../includes/super_admin/result_delete_history_print.php?admin_id='+<?php echo $_SESSION["admin_id"]; ?>);		
	}
	
	function print_result_view() { 
		var divContents = document.getElementById("search_window9").innerHTML; 
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

	
	function result_multiple_remove_program_change()
	{
		var result_multiple_remove_prog=document.getElementById('result_multiple_remove_prog').value.trim();
		if(result_multiple_remove_prog!="")
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('result_multiple_remove_course').innerHTML=this.responseText.trim();
					document.getElementById('result_multiple_remove_course').disabled=false;
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_result_multiple_remove_courses.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_id="+result_multiple_remove_prog, true);
			xhttp1.send();
			
		}
		else
		{
			document.getElementById('result_multiple_remove_course').innerHTML='<option value="">Select</option>';
			document.getElementById('result_multiple_remove_course').disabled=true;
			
			document.getElementById('result_multiple_remove_course_instructor').value='';
			document.getElementById('result_multiple_remove_course_instructor').disabled=true;
			
			document.getElementById('result_multiple_remove_semester').value='';
			document.getElementById('result_multiple_remove_semester').disabled=true;
			
			document.getElementById('result_multiple_remove_captcha').value='';
			document.getElementById('result_multiple_remove_captcha').disabled=true;
			
			document.getElementById('result_multiple_remove_save_btn').disabled=true;
			
			
		}
		
	}
	
	function result_multiple_remove_course_change()
	{
		var result_multiple_remove_course=document.getElementById('result_multiple_remove_course').value.trim();
		var result_multiple_remove_prog=document.getElementById('result_multiple_remove_prog').value.trim();
		if(result_multiple_remove_course!="")
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('result_multiple_remove_semester').innerHTML=this.responseText.trim();
					document.getElementById('result_multiple_remove_semester').disabled=false;
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_result_multiple_remove_semester.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_id="+result_multiple_remove_course+"&prog_id="+result_multiple_remove_prog, true);
			xhttp1.send();
			
		}
		else
		{
			
			
			document.getElementById('result_multiple_remove_semester').innerHTML='<option value="">Select</option>';
			document.getElementById('result_multiple_remove_semester').disabled=true;
			
			document.getElementById('result_multiple_remove_course_instructor').value='';
			document.getElementById('result_multiple_remove_course_instructor').disabled=true;
			
			document.getElementById('result_multiple_remove_captcha').value='';
			document.getElementById('result_multiple_remove_captcha').disabled=true;
			
			document.getElementById('result_multiple_remove_save_btn').disabled=true;
			
		}
		
	}

	function result_multiple_remove_form_reset()
	{
		document.getElementById('result_multiple_remove_prog').value='';
		
		
		document.getElementById('result_multiple_remove_course').innerHTML='<option value="">Select</option>';
		document.getElementById('result_multiple_remove_course').disabled=true;
		
		document.getElementById('result_multiple_remove_course_instructor').value='';
		document.getElementById('result_multiple_remove_course_instructor').disabled=true;
		
		document.getElementById('result_multiple_remove_semester').value='';
		document.getElementById('result_multiple_remove_semester').disabled=true;
		
		document.getElementById('result_multiple_remove_captcha').value='';
		document.getElementById('result_multiple_remove_captcha').disabled=true;
		
		document.getElementById('result_multiple_remove_save_btn').disabled=true;
		
		
	}


	function result_multiple_edit_form_reset()
	{
		document.getElementById('result_edit_excel_file').value='';
		
		document.getElementById('result_multiple_edit_captcha').value='';
		
		document.getElementById('result_multiple_edit_save_btn').disabled=true;
		
		
	}


	function edit_multiple_window9_close()
	{
		document.getElementById('result_edit_excel_file').value='';
		
		document.getElementById('result_multiple_edit_captcha').value='';
		
		document.getElementById('result_multiple_edit_save_btn').disabled=true;
		
		document.getElementById('edit_multiple_window9').style.display='none';
		
		document.getElementById('result_multiple_edit_box1').style.display='block';
		document.getElementById('result_multiple_edit_box3').style.display='none';
		document.getElementById('result_multiple_edit_box2').style.display='none';
		
		document.getElementById('result_edit_multiple_total').innerHTML='';
		document.getElementById('result_edit_multiple_success').innerHTML='';
		document.getElementById('result_edit_multiple_failed').innerHTML='';
		document.getElementById('result_edit_multiple_logs').innerHTML='';
		
	}

	function result_multiple_edit_form_change()
	{
		var result_edit_excel_file=document.getElementById('result_edit_excel_file').value.trim();
		if(result_edit_excel_file=="")
		{
			document.getElementById('result_multiple_edit_save_btn').disabled=true;
		}
		else
		{
			document.getElementById('result_multiple_edit_save_btn').disabled=false;
		}
		
	}



	function remove_multiple_window9_close()
	{
		document.getElementById('result_multiple_remove_prog').value='';
		
		
		document.getElementById('result_multiple_remove_course').innerHTML='<option value="">Select</option>';
		document.getElementById('result_multiple_remove_course').disabled=true;
		
		document.getElementById('result_multiple_remove_course_instructor').value='';
		document.getElementById('result_multiple_remove_course_instructor').disabled=true;
		
		document.getElementById('result_multiple_remove_semester').value='';
		document.getElementById('result_multiple_remove_semester').disabled=true;
		
		document.getElementById('result_multiple_remove_captcha').value='';
		document.getElementById('result_multiple_remove_captcha').disabled=true;
		
		document.getElementById('result_multiple_remove_save_btn').disabled=true;
		
		document.getElementById('remove_multiple_window9').style.display='none';
		
		document.getElementById('result_multiple_remove_box1').style.display='block';
		document.getElementById('result_multiple_remove_box3').style.display='none';
		document.getElementById('result_multiple_remove_box2').style.display='none';
		
		document.getElementById('result_multiple_remove_total').innerHTML='';
		document.getElementById('result_multiple_remove_success').innerHTML='';
		document.getElementById('result_multiple_remove_failed').innerHTML='';
		document.getElementById('result_multiple_remove_logs').innerHTML='';
			
			
	}

	function result_multiple_remove_semester_change()
	{
		var result_multiple_remove_course=document.getElementById('result_multiple_remove_course').value.trim();
		var result_multiple_remove_prog=document.getElementById('result_multiple_remove_prog').value.trim();
		var result_multiple_remove_semester=document.getElementById('result_multiple_remove_semester').value.trim();
		if(result_multiple_remove_semester!="")
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('result_multiple_remove_course_instructor').innerHTML=this.responseText.trim();
					document.getElementById('result_multiple_remove_course_instructor').disabled=false;
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_result_multiple_remove_instructor.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&course_id="+result_multiple_remove_course+"&prog_id="+result_multiple_remove_prog+"&semester="+result_multiple_remove_semester, true);
			xhttp1.send();
			
		}
		else
		{
			
			
			document.getElementById('result_multiple_remove_course_instructor').innerHTML='<option value="">Select</option>';
			document.getElementById('result_multiple_remove_course_instructor').disabled=true;
			
			document.getElementById('result_multiple_remove_captcha').value='';
			document.getElementById('result_multiple_remove_captcha').disabled=true;
			
			document.getElementById('result_multiple_remove_save_btn').disabled=true;
			
		}
		
	}

	function result_multiple_remove_form_change()
	{
		var result_multiple_remove_course=document.getElementById('result_multiple_remove_course').value.trim();
		var result_multiple_remove_prog=document.getElementById('result_multiple_remove_prog').value.trim();
		var result_multiple_remove_semester=document.getElementById('result_multiple_remove_semester').value.trim();
		var result_multiple_remove_course_instructor=document.getElementById('result_multiple_remove_course_instructor').value.trim();
		if(result_multiple_remove_prog=="" || result_multiple_remove_semester=="" || result_multiple_remove_course=="" || result_multiple_remove_course_instructor=="")
		{
			document.getElementById('result_multiple_remove_captcha').disabled=true;
			document.getElementById('result_multiple_remove_save_btn').disabled=true;
		}
		else
		{
			document.getElementById('result_multiple_remove_captcha').disabled=false;
			document.getElementById('result_multiple_remove_save_btn').disabled=false;
		}
		
	}

	function result_single_add_form_save()
	{
		var result_single_add_prog=document.getElementById('result_single_add_prog').value.trim();
		var result_single_add_course=document.getElementById('result_single_add_course').value.trim();
		var result_single_add_course_instructor=document.getElementById('result_single_add_course_instructor').value.trim();
		var result_single_add_student_id=document.getElementById('result_single_add_student_id').value.trim();
		var result_single_add_student_name=document.getElementById('result_single_add_student_name').value.trim();
		var result_single_add_marks=document.getElementById('result_single_add_marks').value.trim();
		var result_single_add_remarks=document.getElementById('result_single_add_remarks').value.trim();
		var result_single_add_semester=document.getElementById('result_single_add_semester').value.trim();
		var result_single_add_status=document.getElementById('result_single_add_status').value.trim();
		var result_single_add_captcha=document.getElementById('result_single_add_captcha').value.trim();
		var result_single_add_old_captcha=document.getElementById('result_single_add_old_captcha').value.trim();
		
		if(result_single_add_prog=="" || result_single_add_course=="" || result_single_add_course_instructor=="" || result_single_add_student_id=="" || result_single_add_student_id.length!=12 || result_single_add_student_name=="" || result_single_add_student_name=="Unknown" || result_single_add_marks=="" || parseInt(result_single_add_marks)>100 || parseInt(result_single_add_marks)<0 || result_single_add_semester=="" ||  result_single_add_status=="")
		{
			document.getElementById('result_single_add_pass').value='';
			
			document.getElementById('result_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
		}
		else if(result_single_add_captcha=="" || result_single_add_captcha!=result_single_add_old_captcha)
		{
			document.getElementById('result_single_add_pass').value='';
			
			document.getElementById('result_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(result_single_add_prog!="" && result_single_add_course!="" && result_single_add_course_instructor!="" && result_single_add_student_id!="" && result_single_add_student_id.length==12 && result_single_add_student_name!="" && result_single_add_student_name!="Unknown" && result_single_add_marks!="" && parseInt(result_single_add_marks)<=100 && parseInt(result_single_add_marks)>=0 && result_single_add_semester!="" &&  result_single_add_status!="" && result_single_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('result_single_add_pass').value.trim();
			
			document.getElementById('result_single_add_pass').value='';
			
			document.getElementById('result_single_add_re_confirmation').style.display='none';
			
			
			document.getElementById('result_single_add_box1').style.display='none';
			document.getElementById('result_single_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText.trim());
					if(this.responseText.trim()=='Ok')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
			
						get_search_result9();
						document.getElementById('result_single_add_student_id').value=(parseInt(result_single_add_student_id.trim())+1);
						document.getElementById('result_single_add_marks').focus();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Result successfully added.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else  if(this.responseText.trim()=='unable')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (invalid student ID).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable2')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (student graduated).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable3')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (invalid course).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable4')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (invalid instructor).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable5')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (invalid program).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable6')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (ambiguous program and student).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable7')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (duplicate data).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else  if(this.responseText.trim()=='unable8')
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to add this result (waived course).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('result_single_add_box1').style.display='block';
						document.getElementById('result_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('result_single_add_box1').style.display='block';
					document.getElementById('result_single_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_result.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&prog_id="+result_single_add_prog+"&course_id="+result_single_add_course+"&instructor_id="+result_single_add_course_instructor+"&student_id="+result_single_add_student_id+"&marks="+result_single_add_marks+"&remarks="+result_single_add_remarks+"&semester="+result_single_add_semester+"&status="+result_single_add_status, true);
			xhttp1.send();
		}
	}
	
	function result_single_add_form_change()
	{
		var result_single_add_prog=document.getElementById('result_single_add_prog').value.trim();
		var result_single_add_course=document.getElementById('result_single_add_course').value.trim();
		var result_single_add_course_instructor=document.getElementById('result_single_add_course_instructor').value.trim();
		var result_single_add_student_id=document.getElementById('result_single_add_student_id').value.trim();
		var result_single_add_student_name=document.getElementById('result_single_add_student_name').value.trim();
		var result_single_add_marks=document.getElementById('result_single_add_marks').value.trim();
		var result_single_add_remarks=document.getElementById('result_single_add_remarks').value.trim();
		var result_single_add_semester=document.getElementById('result_single_add_semester').value.trim();
		var result_single_add_status=document.getElementById('result_single_add_status').value.trim();
		var result_single_add_captcha=document.getElementById('result_single_add_captcha').value.trim();
		
		if(result_single_add_student_id.length==12)
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				
					document.getElementById('result_single_add_student_name').value=this.responseText.trim();
					result_single_add_form_change();
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('result_single_add_student_name').value='Unknown';
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_result_single_add_student_name.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&student_id="+result_single_add_student_id+"&prog_id="+result_single_add_prog, true);
			xhttp1.send();
			
			
			
		}
		else
		{
			document.getElementById('result_single_add_student_name').value='';
		}
		
		
		if(result_single_add_marks!="")
		{
			if(parseInt(result_single_add_marks)>100)
			{
				document.getElementById('result_single_add_grade').value="";
				document.getElementById('result_single_add_grade_point').value="";
			
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Please insert valid marks.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
			else if(parseInt(result_single_add_marks)<101 && parseInt(result_single_add_marks)>79)
			{
				document.getElementById('result_single_add_grade').value="A+";
				document.getElementById('result_single_add_grade_point').value="4.00";
			}
			else if(parseInt(result_single_add_marks)<80 && parseInt(result_single_add_marks)>74)
			{
				document.getElementById('result_single_add_grade').value="A";
				document.getElementById('result_single_add_grade_point').value="3.75";
			}
			else if(parseInt(result_single_add_marks)<75 && parseInt(result_single_add_marks)>69)
			{
				document.getElementById('result_single_add_grade').value="A-";
				document.getElementById('result_single_add_grade_point').value="3.50";
			}
			else if(parseInt(result_single_add_marks)<70 && parseInt(result_single_add_marks)>64)
			{
				document.getElementById('result_single_add_grade').value="B+";
				document.getElementById('result_single_add_grade_point').value="3.25";
			}
			else if(parseInt(result_single_add_marks)<65 && parseInt(result_single_add_marks)>59)
			{
				document.getElementById('result_single_add_grade').value="B";
				document.getElementById('result_single_add_grade_point').value="3.00";
			}
			else if(parseInt(result_single_add_marks)<60 && parseInt(result_single_add_marks)>54)
			{
				document.getElementById('result_single_add_grade').value="B-";
				document.getElementById('result_single_add_grade_point').value="2.75";
			}
			else if(parseInt(result_single_add_marks)<55 && parseInt(result_single_add_marks)>49)
			{
				document.getElementById('result_single_add_grade').value="C+";
				document.getElementById('result_single_add_grade_point').value="2.50";
			}
			else if(parseInt(result_single_add_marks)<50 && parseInt(result_single_add_marks)>44)
			{
				document.getElementById('result_single_add_grade').value="C";
				document.getElementById('result_single_add_grade_point').value="2.25";
			}
			else if(parseInt(result_single_add_marks)<45 && parseInt(result_single_add_marks)>39)
			{
				document.getElementById('result_single_add_grade').value="D";
				document.getElementById('result_single_add_grade_point').value="2.00";
			}
			else if(parseInt(result_single_add_marks)<40 && parseInt(result_single_add_marks)>-1)
			{
				document.getElementById('result_single_add_grade').value="F";
				document.getElementById('result_single_add_grade_point').value="0.00";
			}
			else
			{
				document.getElementById('result_single_add_grade').value="";
				document.getElementById('result_single_add_grade_point').value="";
			
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Please insert valid marks.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
			}
		}
		else
		{
			document.getElementById('result_single_add_grade').value="";
			document.getElementById('result_single_add_grade_point').value="";
			
		}
		
		if(result_single_add_status=='Active')
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_single_add_status').classList.add('w3-pale-green');
		}
		else if(result_single_add_status=='Inactive')
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		if(result_single_add_prog=="" || result_single_add_course=="" || result_single_add_course_instructor=="" || result_single_add_student_id=="" || result_single_add_student_id.length!=12 || result_single_add_student_name=="" || result_single_add_student_name=="Unknown" || result_single_add_marks=="" || parseInt(result_single_add_marks)>100 || parseInt(result_single_add_marks)<0 || result_single_add_semester=="" ||  result_single_add_status=="")
		{
			document.getElementById('result_single_add_save_btn').disabled=true;
		}
		else
		{
			document.getElementById('result_single_add_save_btn').disabled=false;
		}
		
		
	}

	function result_single_add_form_reset()
	{
		document.getElementById('result_single_add_prog').value='';
		document.getElementById('result_single_add_course').innerHTML='<option value="">Select</option>';
		document.getElementById('result_single_add_course').disabled=true;
		
		document.getElementById('result_single_add_course_instructor').value='';
		document.getElementById('result_single_add_course_instructor').disabled=true;
		
		document.getElementById('result_single_add_student_id').value='';
		document.getElementById('result_single_add_student_id').disabled=true;
		
		document.getElementById('result_single_add_student_name').value='';
		document.getElementById('result_single_add_student_name').disabled=true;
		
		document.getElementById('result_single_add_marks').value='';
		document.getElementById('result_single_add_marks').disabled=true;
		
		document.getElementById('result_single_add_grade').value='';
		document.getElementById('result_single_add_grade').disabled=true;
		
		document.getElementById('result_single_add_grade_point').value='';
		document.getElementById('result_single_add_grade_point').disabled=true;
		
		document.getElementById('result_single_add_remarks').value='';
		document.getElementById('result_single_add_remarks').disabled=true;
		
		document.getElementById('result_single_add_semester').value='';
		document.getElementById('result_single_add_semester').disabled=true;
		
		document.getElementById('result_single_add_status').value='';
		document.getElementById('result_single_add_status').disabled=true;
		
		document.getElementById('result_single_add_captcha').value='';
		document.getElementById('result_single_add_captcha').disabled=true;
		
		document.getElementById('result_single_add_save_btn').disabled=true;
		
		var result_single_add_status=document.getElementById('result_single_add_status').value.trim();
		
		if(result_single_add_status=='Active')
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_single_add_status').classList.add('w3-pale-green');
		}
		else if(result_single_add_status=='Inactive')
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
		}
	}
	
	function result_single_add_program_change()
	{
		var result_single_add_prog=document.getElementById('result_single_add_prog').value.trim();
		if(result_single_add_prog!="")
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('result_single_add_course').innerHTML=this.responseText.trim();
					document.getElementById('result_single_add_course').disabled=false;
					document.getElementById('result_single_add_course_instructor').disabled=false;
					document.getElementById('result_single_add_student_id').disabled=false;
					document.getElementById('result_single_add_marks').disabled=false;
					document.getElementById('result_single_add_remarks').disabled=false;
					document.getElementById('result_single_add_semester').disabled=false;
					document.getElementById('result_single_add_status').disabled=false;
					document.getElementById('result_single_add_captcha').disabled=false;
		
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_result_single_add_courses.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_id="+result_single_add_prog, true);
			xhttp1.send();
			
		}
		else
		{
			document.getElementById('result_single_add_course').innerHTML='<option value="">Select</option>';
			document.getElementById('result_single_add_course').disabled=true;
			
			document.getElementById('result_single_add_course_instructor').value='';
			document.getElementById('result_single_add_course_instructor').disabled=true;
			
			document.getElementById('result_single_add_student_id').value='';
			document.getElementById('result_single_add_student_id').disabled=true;
			
			document.getElementById('result_single_add_student_name').value='';
			document.getElementById('result_single_add_student_name').disabled=true;
			
			document.getElementById('result_single_add_marks').value='';
			document.getElementById('result_single_add_marks').disabled=true;
			
			document.getElementById('result_single_add_grade').value='';
			document.getElementById('result_single_add_grade').disabled=true;
			
			document.getElementById('result_single_add_grade_point').value='';
			document.getElementById('result_single_add_grade_point').disabled=true;
			
			document.getElementById('result_single_add_remarks').value='';
			document.getElementById('result_single_add_remarks').disabled=true;
			
			document.getElementById('result_single_add_semester').value='';
			document.getElementById('result_single_add_semester').disabled=true;
			
			document.getElementById('result_single_add_status').value='';
			document.getElementById('result_single_add_status').disabled=true;
			
			document.getElementById('result_single_add_captcha').value='';
			document.getElementById('result_single_add_captcha').disabled=true;
			
			document.getElementById('result_single_add_save_btn').disabled=true;
			
			var result_single_add_status=document.getElementById('result_single_add_status').value.trim();
			
			if(result_single_add_status=='Active')
			{
				if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
				{
					document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
				}
				if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
				{
					document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
				}
				document.getElementById('result_single_add_status').classList.add('w3-pale-green');
			}
			else if(result_single_add_status=='Inactive')
			{
				if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
				{
					document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
				}
				if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
				{
					document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
				}
				document.getElementById('result_single_add_status').classList.add('w3-pale-red');
			}
			else
			{
				if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
				{
					document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
				}
				if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
				{
					document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
				}
			}
			
		}
		
	}
	
	function add_single_window9_close()
	{
		document.getElementById('result_single_add_prog').value='';
		document.getElementById('result_single_add_course').innerHTML='<option value="">Select</option>';
		document.getElementById('result_single_add_course').disabled=true;
		
		document.getElementById('result_single_add_course_instructor').value='';
		document.getElementById('result_single_add_course_instructor').disabled=true;
		
		document.getElementById('result_single_add_student_id').value='';
		document.getElementById('result_single_add_student_id').disabled=true;
		
		document.getElementById('result_single_add_student_name').value='';
		document.getElementById('result_single_add_student_name').disabled=true;
		
		document.getElementById('result_single_add_marks').value='';
		document.getElementById('result_single_add_marks').disabled=true;
		
		document.getElementById('result_single_add_grade').value='';
		document.getElementById('result_single_add_grade').disabled=true;
		
		document.getElementById('result_single_add_grade_point').value='';
		document.getElementById('result_single_add_grade_point').disabled=true;
		
		document.getElementById('result_single_add_remarks').value='';
		document.getElementById('result_single_add_remarks').disabled=true;
		
		document.getElementById('result_single_add_semester').value='';
		document.getElementById('result_single_add_semester').disabled=true;
		
		document.getElementById('result_single_add_status').value='';
		document.getElementById('result_single_add_status').disabled=true;
		
		document.getElementById('result_single_add_captcha').value='';
		document.getElementById('result_single_add_captcha').disabled=true;
		
		document.getElementById('result_single_add_save_btn').disabled=true;
		
		var result_single_add_status=document.getElementById('result_single_add_status').value.trim();
		
		if(result_single_add_status=='Active')
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_single_add_status').classList.add('w3-pale-green');
		}
		else if(result_single_add_status=='Inactive')
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_single_add_status').classList.remove('w3-pale-red');
			}
		}
		document.getElementById('add_single_window9').style.display='none';
	}
	
	function add_multiple_window9_close()
	{
		document.getElementById('result_multiple_add_prog').value='';
		document.getElementById('result_multiple_add_course').innerHTML='<option value="">Select</option>';
		document.getElementById('result_multiple_add_course').disabled=true;
		
		document.getElementById('result_multiple_add_course_instructor').value='';
		document.getElementById('result_multiple_add_course_instructor').disabled=true;
		
		document.getElementById('result_multiple_add_semester').value='';
		document.getElementById('result_multiple_add_semester').disabled=true;
		
		document.getElementById('result_multiple_add_captcha').value='';
		document.getElementById('result_multiple_add_captcha').disabled=true;
		
		document.getElementById('result_excel_file').value='';
		document.getElementById('result_excel_file').disabled=true;
		
		document.getElementById('result_multiple_add_save_btn').disabled=true;
		
		document.getElementById('result_multiple_add_box1').style.display='block';
		document.getElementById('result_multiple_add_box3').style.display='none';
		document.getElementById('result_multiple_add_box2').style.display='none';
			
		
		document.getElementById('add_multiple_window9').style.display='none';
	}
	
	function result_multiple_add_program_change()
	{
		var result_multiple_add_prog=document.getElementById('result_multiple_add_prog').value.trim();
		if(result_multiple_add_prog!="")
		{
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('result_multiple_add_course').innerHTML=this.responseText.trim();
					document.getElementById('result_multiple_add_course').disabled=false;
					document.getElementById('result_multiple_add_course_instructor').disabled=false;
					document.getElementById('result_multiple_add_semester').disabled=false;
					document.getElementById('result_multiple_add_captcha').disabled=false;
					document.getElementById('result_excel_file').disabled=false;
		
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
			};
			xhttp1.open("POST", "../includes/super_admin/get_result_single_add_courses.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&prog_id="+result_multiple_add_prog, true);
			xhttp1.send();
			
		}
		else
		{
			document.getElementById('result_multiple_add_course').innerHTML='<option value="">Select</option>';
			document.getElementById('result_multiple_add_course').disabled=true;
			
			document.getElementById('result_multiple_add_course_instructor').value='';
			document.getElementById('result_multiple_add_course_instructor').disabled=true;
			
			document.getElementById('result_multiple_add_semester').value='';
			document.getElementById('result_multiple_add_semester').disabled=true;
			
			document.getElementById('result_excel_file').value='';
			document.getElementById('result_excel_file').disabled=true;
		
			
			document.getElementById('result_multiple_add_captcha').value='';
			document.getElementById('result_multiple_add_captcha').disabled=true;
			
			document.getElementById('result_multiple_add_save_btn').disabled=true;
			
			
		}
		
	}
	
	function result_multiple_add_form_reset()
	{
		document.getElementById('result_multiple_add_prog').value='';
		document.getElementById('result_multiple_add_course').innerHTML='<option value="">Select</option>';
		document.getElementById('result_multiple_add_course').disabled=true;
		
		document.getElementById('result_multiple_add_course_instructor').value='';
		document.getElementById('result_multiple_add_course_instructor').disabled=true;
		
		document.getElementById('result_multiple_add_semester').value='';
		document.getElementById('result_multiple_add_semester').disabled=true;
		
		document.getElementById('result_multiple_add_captcha').value='';
		document.getElementById('result_excel_file').value='';
		document.getElementById('result_excel_file').disabled=true;
		document.getElementById('result_multiple_add_captcha').disabled=true;
		
		document.getElementById('result_multiple_add_save_btn').disabled=true;
		
		
	}
	
	
	function result_multiple_add_form_change()
	{
		var result_multiple_add_prog=document.getElementById('result_multiple_add_prog').value.trim();
		var result_multiple_add_course=document.getElementById('result_multiple_add_course').value.trim();
		var result_multiple_add_course_instructor=document.getElementById('result_multiple_add_course_instructor').value.trim();
		var result_multiple_add_semester=document.getElementById('result_multiple_add_semester').value.trim();
		var result_excel_file=document.getElementById('result_excel_file').value.trim();
		var result_multiple_add_captcha=document.getElementById('result_multiple_add_captcha').value.trim();
		
		
		if(result_multiple_add_prog=="" || result_multiple_add_course=="" || result_multiple_add_course_instructor=="" || result_excel_file==""|| result_multiple_add_semester=="")
		{
			document.getElementById('result_multiple_add_save_btn').disabled=true;
		}
		else
		{
			document.getElementById('result_multiple_add_save_btn').disabled=false;
		}
		
		
	}


	function result_multiple_remove_form_save()
	{
		var result_multiple_remove_course=document.getElementById('result_multiple_remove_course').value.trim();
		var result_multiple_remove_prog=document.getElementById('result_multiple_remove_prog').value.trim();
		var result_multiple_remove_semester=document.getElementById('result_multiple_remove_semester').value.trim();
		var result_multiple_remove_course_instructor=document.getElementById('result_multiple_remove_course_instructor').value.trim();
		var result_multiple_remove_captcha=document.getElementById('result_multiple_remove_captcha').value.trim();
		var result_multiple_remove_old_captcha=document.getElementById('result_multiple_remove_old_captcha').value.trim();
		if(result_multiple_remove_prog=="" || result_multiple_remove_semester=="" || result_multiple_remove_course=="" || result_multiple_remove_course_instructor=="")
		{
			document.getElementById('result_multiple_remove_pass').value='';
			
			document.getElementById('result_multiple_remove_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
		}
		else if(result_multiple_remove_captcha=="" || result_multiple_remove_captcha!=result_multiple_remove_old_captcha)
		{
			document.getElementById('result_multiple_remove_pass').value='';
			
			document.getElementById('result_multiple_remove_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(result_multiple_remove_pass_co_fu()==true)
		{
			var pass=document.getElementById('result_multiple_remove_pass').value.trim();
		
			document.getElementById('result_multiple_remove_pass').value='';
			
			document.getElementById('result_multiple_remove_re_confirmation').style.display='none';
			
			document.getElementById('result_multiple_remove_box1').style.display='none';
			document.getElementById('result_multiple_remove_box3').style.display='none';
			document.getElementById('result_multiple_remove_box2').style.display='block';
			
			document.getElementById('result_multiple_remove_total').innerHTML='';
			document.getElementById('result_multiple_remove_success').innerHTML='';
			document.getElementById('result_multiple_remove_failed').innerHTML='';
			document.getElementById('result_multiple_remove_logs').innerHTML='';
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
						
						document.getElementById('result_multiple_remove_box1').style.display='none';
						document.getElementById('result_multiple_remove_box3').style.display='block';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						document.getElementById('result_multiple_remove_total').innerHTML=total;
						document.getElementById('result_multiple_remove_success').innerHTML=success;
						document.getElementById('result_multiple_remove_failed').innerHTML=failed;
						document.getElementById('result_multiple_remove_logs').innerHTML=logs;
			
						result_multiple_remove_form_reset();
						get_total_search_results9(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						
						document.getElementById('result_multiple_remove_box1').style.display='block';
						document.getElementById('result_multiple_remove_box3').style.display='none';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u2')
					{
						
						document.getElementById('result_multiple_remove_box1').style.display='block';
						document.getElementById('result_multiple_remove_box3').style.display='none';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (invalid program).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u3')
					{
						
						document.getElementById('result_multiple_remove_box1').style.display='block';
						document.getElementById('result_multiple_remove_box3').style.display='none';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (invalid course).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u4')
					{
						
						document.getElementById('result_multiple_remove_box1').style.display='block';
						document.getElementById('result_multiple_remove_box3').style.display='none';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (invalid course instructor).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u5')
					{
						
						document.getElementById('result_multiple_remove_box1').style.display='block';
						document.getElementById('result_multiple_remove_box3').style.display='none';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (no result found).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						
						document.getElementById('result_multiple_remove_box1').style.display='block';
						document.getElementById('result_multiple_remove_box3').style.display='none';
						document.getElementById('result_multiple_remove_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					
					document.getElementById('result_multiple_remove_box1').style.display='block';
					document.getElementById('result_multiple_remove_box3').style.display='none';
					document.getElementById('result_multiple_remove_box2').style.display='none';
			
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occured.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
				}
			};
			
			xhttp1.open("POST", "../includes/super_admin/remove_multiple_results.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&prog_id="+result_multiple_remove_prog+"&course_id="+result_multiple_remove_course+"&instructor_id="+result_multiple_remove_course_instructor+"&semester="+result_multiple_remove_semester, true);
			xhttp1.send();
			
			
		}
	}


	function result_multiple_edit_form_save()
	{
		var result_edit_excel_file=document.getElementById('result_edit_excel_file').value.trim();
		var result_multiple_edit_captcha=document.getElementById('result_multiple_edit_captcha').value.trim();
		var result_multiple_edit_old_captcha=document.getElementById('result_multiple_edit_old_captcha').value.trim();
		
		if(result_edit_excel_file=="" || file_validate3(result_edit_excel_file)==false)
		{
			document.getElementById('result_multiple_edit_pass').value='';
			
			document.getElementById('result_multiple_edit_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
		}
		else if(result_multiple_edit_captcha=="" || result_multiple_edit_captcha!=result_multiple_edit_old_captcha)
		{
			document.getElementById('result_multiple_edit_pass').value='';
			
			document.getElementById('result_multiple_edit_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else
		{
			var pass=document.getElementById('result_multiple_edit_pass').value.trim();
		
			document.getElementById('result_multiple_edit_pass').value='';
			
			document.getElementById('result_multiple_edit_re_confirmation').style.display='none';
			
			document.getElementById('result_multiple_edit_box1').style.display='none';
			document.getElementById('result_multiple_edit_box3').style.display='none';
			document.getElementById('result_multiple_edit_box2').style.display='block';
			
			document.getElementById('result_edit_multiple_total').innerHTML='';
			document.getElementById('result_edit_multiple_success').innerHTML='';
			document.getElementById('result_edit_multiple_failed').innerHTML='';
			document.getElementById('result_edit_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('result_edit_excel_file').files[0];
			var fd_excel=new FormData();
			var link='result_edit_excel_file';
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
						
						
						document.getElementById('result_multiple_edit_studentress_id').style.width='0%';
						document.getElementById('result_multiple_edit_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_edit_box1').style.display='none';
						document.getElementById('result_multiple_edit_box3').style.display='block';
						document.getElementById('result_multiple_edit_box2').style.display='none';
				
						document.getElementById('result_edit_multiple_total').innerHTML=total;
						document.getElementById('result_edit_multiple_success').innerHTML=success;
						document.getElementById('result_edit_multiple_failed').innerHTML=failed;
						document.getElementById('result_edit_multiple_logs').innerHTML=logs;
			
						result_multiple_edit_form_reset();
						get_total_search_results9(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('result_multiple_edit_studentress_id').style.width='0%';
						document.getElementById('result_multiple_edit_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_edit_box1').style.display='block';
						document.getElementById('result_multiple_edit_box3').style.display='none';
						document.getElementById('result_multiple_edit_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
					else
					{
						document.getElementById('result_multiple_edit_studentress_id').style.width='0%';
						document.getElementById('result_multiple_edit_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_edit_box1').style.display='block';
						document.getElementById('result_multiple_edit_box3').style.display='none';
						document.getElementById('result_multiple_edit_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('result_multiple_edit_studentress_id').style.width='0%';
					document.getElementById('result_multiple_edit_studentress_id').innerHTML='0%';
					
					document.getElementById('result_multiple_edit_box1').style.display='block';
					document.getElementById('result_multiple_edit_box3').style.display='none';
					document.getElementById('result_multiple_edit_box2').style.display='none';
			
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occured.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
				}
			};
			xhttp1.upload.onstudentress = function(e) {
				if (e.lengthComputable) {
				  var percentComplete = Math.round((e.loaded / e.total) * 100);
				  percentComplete=percentComplete.toFixed(2);
				  if(percentComplete==100)
				  {
					 document.getElementById('result_multiple_edit_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('result_multiple_edit_studentress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('result_multiple_edit_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('result_multiple_edit_studentress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/edit_multiple_results.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass, true);
			xhttp1.send(fd_excel);
			
			
		}
	}

	function result_multiple_add_form_save()
	{
		var result_excel_file=document.getElementById('result_excel_file').value.trim();
		
		var result_multiple_add_prog=document.getElementById('result_multiple_add_prog').value.trim();
		var result_multiple_add_course=document.getElementById('result_multiple_add_course').value.trim();
		var result_multiple_add_course_instructor=document.getElementById('result_multiple_add_course_instructor').value.trim();
		var result_multiple_add_semester=document.getElementById('result_multiple_add_semester').value.trim();
		var result_multiple_add_captcha=document.getElementById('result_multiple_add_captcha').value.trim();
		var result_multiple_add_old_captcha=document.getElementById('result_multiple_add_old_captcha').value.trim();
		
		if(result_multiple_add_prog=="" || result_multiple_add_course=="" || result_multiple_add_course_instructor=="" || result_multiple_add_semester=="" || result_excel_file=="" || file_validate3(result_excel_file)==false)
		{
			document.getElementById('result_multiple_add_pass').value='';
			
			document.getElementById('result_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
		}
		else if(result_multiple_add_captcha=="" || result_multiple_add_captcha!=result_multiple_add_old_captcha)
		{
			document.getElementById('result_multiple_add_pass').value='';
			
			document.getElementById('result_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(result_multiple_add_prog!="" && result_multiple_add_course!="" && result_multiple_add_course_instructor!="" && result_multiple_add_semester!="" &&  result_multiple_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('result_multiple_add_pass').value.trim();
		
			document.getElementById('result_multiple_add_pass').value='';
			
			document.getElementById('result_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('result_multiple_add_box1').style.display='none';
			document.getElementById('result_multiple_add_box3').style.display='none';
			document.getElementById('result_multiple_add_box2').style.display='block';
			
			document.getElementById('result_multiple_total').innerHTML='';
			document.getElementById('result_multiple_success').innerHTML='';
			document.getElementById('result_multiple_failed').innerHTML='';
			document.getElementById('result_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('result_excel_file').files[0];
			var fd_excel=new FormData();
			var link='result_excel_file';
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
						
						
						document.getElementById('result_multiple_studentress_id').style.width='0%';
						document.getElementById('result_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_add_box1').style.display='none';
						document.getElementById('result_multiple_add_box3').style.display='block';
						document.getElementById('result_multiple_add_box2').style.display='none';
				
						document.getElementById('result_multiple_total').innerHTML=total;
						document.getElementById('result_multiple_success').innerHTML=success;
						document.getElementById('result_multiple_failed').innerHTML=failed;
						document.getElementById('result_multiple_logs').innerHTML=logs;
			
						result_multiple_add_form_reset();
						get_total_search_results9(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('result_multiple_studentress_id').style.width='0%';
						document.getElementById('result_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_add_box1').style.display='block';
						document.getElementById('result_multiple_add_box3').style.display='none';
						document.getElementById('result_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u2')
					{
						document.getElementById('result_multiple_studentress_id').style.width='0%';
						document.getElementById('result_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_add_box1').style.display='block';
						document.getElementById('result_multiple_add_box3').style.display='none';
						document.getElementById('result_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (invalid program).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u3')
					{
						document.getElementById('result_multiple_studentress_id').style.width='0%';
						document.getElementById('result_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_add_box1').style.display='block';
						document.getElementById('result_multiple_add_box3').style.display='none';
						document.getElementById('result_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (invalid course).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u4')
					{
						document.getElementById('result_multiple_studentress_id').style.width='0%';
						document.getElementById('result_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_add_box1').style.display='block';
						document.getElementById('result_multiple_add_box3').style.display='none';
						document.getElementById('result_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (invalid course instructor).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('result_multiple_studentress_id').style.width='0%';
						document.getElementById('result_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('result_multiple_add_box1').style.display='block';
						document.getElementById('result_multiple_add_box3').style.display='none';
						document.getElementById('result_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('result_multiple_studentress_id').style.width='0%';
					document.getElementById('result_multiple_studentress_id').innerHTML='0%';
					
					document.getElementById('result_multiple_add_box1').style.display='block';
					document.getElementById('result_multiple_add_box3').style.display='none';
					document.getElementById('result_multiple_add_box2').style.display='none';
			
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occured.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
				}
			};
			xhttp1.upload.onstudentress = function(e) {
				if (e.lengthComputable) {
				  var percentComplete = Math.round((e.loaded / e.total) * 100);
				  percentComplete=percentComplete.toFixed(2);
				  if(percentComplete==100)
				  {
					 document.getElementById('result_multiple_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('result_multiple_studentress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('result_multiple_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('result_multiple_studentress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_results.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass+"&prog_id="+result_multiple_add_prog+"&course_id="+result_multiple_add_course+"&instructor_id="+result_multiple_add_course_instructor+"&semester="+result_multiple_add_semester, true);
			xhttp1.send(fd_excel);
			
		}
	}
	
	
	function remove_result_view()
	{
		var pass=document.getElementById('result_view_pass').value.trim();
		if(reservation_captcha_val_result_view_confirm()==true && result_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_result_view_confirm').value='';
			document.getElementById('result_view_pass').value='';
			
			document.getElementById('result_view_re_confirmation').style.display='none';
			
			var result_id=document.getElementById('result_view_id').value.trim();
			
			document.getElementById('result_view_box1').style.display='none';
			document.getElementById('result_view_box3').style.display='none';
			document.getElementById('result_view_box2').style.display='block';
			document.getElementById('result_view_box4').style.display='none';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						get_search_result9();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Result successfully removed.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('result_view_box1').style.display='none';
						document.getElementById('result_view_box2').style.display='none';
						document.getElementById('result_view_box3').style.display='none';
						document.getElementById('result_view_box4').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('result_view_box1').style.display='none';
						document.getElementById('result_view_box3').style.display='none';
						document.getElementById('result_view_box2').style.display='none';
						document.getElementById('result_view_box4').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to remove this result.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('result_view_box1').style.display='none';
						document.getElementById('result_view_box2').style.display='none';
						document.getElementById('result_view_box3').style.display='none';
						document.getElementById('result_view_box4').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('result_view_box1').style.display='none';
					document.getElementById('result_view_box2').style.display='none';
					document.getElementById('result_view_box3').style.display='none';
					document.getElementById('result_view_box4').style.display='block';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_result.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&result_id="+result_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function result_view_form_change()
	{
		var result_view_status=document.getElementById('result_view_status').value.trim();
		var result_view_old_status=document.getElementById('result_view_old_status').value.trim();
		var result_view_marks=document.getElementById('result_view_marks').value.trim();
		var result_view_old_marks=document.getElementById('result_view_old_marks').value.trim();
		var result_view_remarks=document.getElementById('result_view_remarks').value.trim();
		var result_view_old_remarks=document.getElementById('result_view_old_remarks').value.trim();
		
		if(result_view_status=='Active')
		{
			if(document.getElementById('result_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_view_status').classList.add('w3-pale-green');
		}
		else if(result_view_status=='Inactive')
		{
			if(document.getElementById('result_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_view_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('result_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-red');
			}
		}
		
		if(parseInt(result_view_marks)!=parseInt(result_view_old_marks) && result_view_marks!="")
		{
			if(parseInt(result_view_marks)>100)
			{
				document.getElementById('result_view_grade').value="";
				document.getElementById('result_view_grade_point').value="";
			
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Please insert valid marks.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
			else if(parseInt(result_view_marks)<101 && parseInt(result_view_marks)>79)
			{
				document.getElementById('result_view_grade').value="A+";
				document.getElementById('result_view_grade_point').value="4.00";
			}
			else if(parseInt(result_view_marks)<80 && parseInt(result_view_marks)>74)
			{
				document.getElementById('result_view_grade').value="A";
				document.getElementById('result_view_grade_point').value="3.75";
			}
			else if(parseInt(result_view_marks)<75 && parseInt(result_view_marks)>69)
			{
				document.getElementById('result_view_grade').value="A-";
				document.getElementById('result_view_grade_point').value="3.50";
			}
			else if(parseInt(result_view_marks)<70 && parseInt(result_view_marks)>64)
			{
				document.getElementById('result_view_grade').value="B+";
				document.getElementById('result_view_grade_point').value="3.25";
			}
			else if(parseInt(result_view_marks)<65 && parseInt(result_view_marks)>59)
			{
				document.getElementById('result_view_grade').value="B";
				document.getElementById('result_view_grade_point').value="3.00";
			}
			else if(parseInt(result_view_marks)<60 && parseInt(result_view_marks)>54)
			{
				document.getElementById('result_view_grade').value="B-";
				document.getElementById('result_view_grade_point').value="2.75";
			}
			else if(parseInt(result_view_marks)<55 && parseInt(result_view_marks)>49)
			{
				document.getElementById('result_view_grade').value="C+";
				document.getElementById('result_view_grade_point').value="2.50";
			}
			else if(parseInt(result_view_marks)<50 && parseInt(result_view_marks)>44)
			{
				document.getElementById('result_view_grade').value="C";
				document.getElementById('result_view_grade_point').value="2.25";
			}
			else if(parseInt(result_view_marks)<45 && parseInt(result_view_marks)>39)
			{
				document.getElementById('result_view_grade').value="D";
				document.getElementById('result_view_grade_point').value="2.00";
			}
			else if(parseInt(result_view_marks)<40 && parseInt(result_view_marks)>-1)
			{
				document.getElementById('result_view_grade').value="F";
				document.getElementById('result_view_grade_point').value="0.00";
			}
			else
			{
				document.getElementById('result_view_grade').value="";
				document.getElementById('result_view_grade_point').value="";
			
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Please insert valid marks.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
			}
		}
		if(result_view_marks=="")
		{
			document.getElementById('result_view_grade').value="";
			document.getElementById('result_view_grade_point').value="";
			
		}
		
		if(parseInt(result_view_marks)>100 || parseInt(result_view_marks)<0 || result_view_status=="" || result_view_marks=="" || (result_view_status==result_view_old_status && result_view_marks==result_view_old_marks && result_view_remarks==result_view_old_remarks))
		{
			document.getElementById('result_view_save_btn').disabled=true;
		}
		else
		{
			document.getElementById('result_view_save_btn').disabled=false;
		}
	}
	
	function result_view_form_reset()
	{
		document.getElementById('result_view_captcha').value='';
		document.getElementById('result_view_status').value=document.getElementById('result_view_old_status').value.trim();
		document.getElementById('result_view_remarks').value=document.getElementById('result_view_old_remarks').value.trim();
		document.getElementById('result_view_grade_point').value=document.getElementById('result_view_old_grade_point').value.trim();
		document.getElementById('result_view_grade').value=document.getElementById('result_view_old_grade').value.trim();
		document.getElementById('result_view_marks').value=document.getElementById('result_view_old_marks').value.trim();
		var result_view_status=document.getElementById('result_view_status').value.trim();
		
		if(result_view_status=='Active')
		{
			if(document.getElementById('result_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_view_status').classList.add('w3-pale-green');
		}
		else if(result_view_status=='Inactive')
		{
			if(document.getElementById('result_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('result_view_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('result_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('result_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('result_view_status').classList.remove('w3-pale-red');
			}
		}
		
		document.getElementById('result_view_save_btn').disabled=true;
		
	}
	
	function result_delete_history_window_close()
	{
		document.getElementById('result_delete_history_window_box').innerHTML='';
		document.getElementById('result_delete_history_window').style.display='none';
	}
	
	function get_result_delete_history()
	{
		document.getElementById('result_delete_history_window').style.display='block';
		document.getElementById('result_delete_history_window_box').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var xhttp1 = new XMLHttpRequest();
		xhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('result_delete_history_window_box').innerHTML=this.responseText;
			}
			else if(this.readyState==4 && (this.status==404 || this.status==403))
			{
				result_delete_history_window_close();
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Network error occurred.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
		};
		xhttp1.open("POST", "../includes/super_admin/get_result_delete_history.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>, true);
		xhttp1.send();
	}
	
	function reload_dept9()
	{
		var dept_id=document.getElementById('dept_id9').value;
		var load_program = new XMLHttpRequest();
		load_program.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('program_id9').innerHTML=this.responseText;
				get_search_result9();
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('program_id9').innerHTML='<option value="-1">All</option>';
		
			}
		};
				
		load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		load_program.send();
		
	}
	
	function get_search_result9()
	{
		close_search_box9();
		get_total_search_results9(0,0);
	}
	
	function result_view_form_save_changes(result_id)
	{
		var result_view_status=document.getElementById('result_view_status').value.trim();
		var result_view_old_status=document.getElementById('result_view_old_status').value.trim();
		var result_view_marks=document.getElementById('result_view_marks').value.trim();
		var result_view_old_marks=document.getElementById('result_view_old_marks').value.trim();
		var result_view_remarks=document.getElementById('result_view_remarks').value.trim();
		var result_view_old_remarks=document.getElementById('result_view_old_remarks').value.trim();
		var result_view_captcha=document.getElementById('result_view_captcha').value.trim();
		var result_view_old_captcha=document.getElementById('result_view_old_captcha').value.trim();
		
		if(result_view_status=="" || result_view_marks=="" || parseInt(result_view_marks)>100 || parseInt(result_view_marks)<0)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(result_view_captcha=="" || result_view_captcha!=result_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else
		{
			document.getElementById('result_view_box1').style.display='none';
			document.getElementById('result_view_box3').style.display='none';
			document.getElementById('result_view_box4').style.display='none';
			document.getElementById('result_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						close_search_box9();
						view_result9(result_id);
					
						get_total_search_results9(0,0);
						
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('result_view_box4').style.display='block';
						document.getElementById('result_view_box2').style.display='none';
						document.getElementById('result_view_box3').style.display='none';
						document.getElementById('result_view_box1').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change in result (invalid marks).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('result_view_box4').style.display='block';
						document.getElementById('result_view_box2').style.display='none';
						document.getElementById('result_view_box3').style.display='none';
						document.getElementById('result_view_box1').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('result_view_box4').style.display='block';
					document.getElementById('result_view_box2').style.display='none';
					document.getElementById('result_view_box3').style.display='none';
					document.getElementById('result_view_box1').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_result.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&result_id="+result_id+"&result_status="+result_view_status+"&result_remarks="+result_view_remarks+"&result_marks="+result_view_marks, true);
			xhttp1.send();
			
		}
	}

	function view_result9(r_id)
	{
		
		document.getElementById('search_window9').style.display='block';
		var page9=document.getElementById('page9');
		page9.scrollTop = 20;
		document.getElementById('search_window_details9').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details9').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details9').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results9.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&r_id="+r_id, true);
		search_window_result.send();

	}
	
	function close_search_box9()
	{
		document.getElementById('search_window_details9').innerHTML='';
		document.getElementById('search_window9').style.display='none';
	}
	
	
	var page9=0,total9;
	function get_total_search_results9(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading9").innerHTML='<td colspan="8"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort9').value;
		var search_text=document.getElementById('search_text9').value.trim();
		var dept_id=document.getElementById('dept_id9').value;
		var prog_id=document.getElementById('program_id9').value;
		var filter_semester=document.getElementById('filter_semester9').value;
		var filter_grade=document.getElementById('filter_grade9').value;
		var filter_instructor=document.getElementById('filter_instructor9').value;
		var filter_status=document.getElementById('filter_status9').value;
			
		
		var total9_results = new XMLHttpRequest();
		total9_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total9=parseInt(this.responseText.trim());
				get_search_results9(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total9=0;
				get_search_results9(x,y);
			}
		};
		document.getElementById('search_data_label9').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total9_results.open("GET", "../includes/super_admin/get_total_search_results9.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&program_id="+prog_id+"&dept_id="+dept_id+"&filter_semester="+filter_semester+"&filter_grade="+filter_grade+"&filter_instructor="+filter_instructor+"&filter_status="+filter_status, true);
		total9_results.send();
		
	}
	
	function get_search_results9(x,y)
	{
		if(x==0)
		{
			page9=0;
			document.getElementById('search_result_tables9').innerHTML='';
		}
		if(total9!=0)
		{
			var r_sort=document.getElementById('search_result_sort9').value;
			var search_text=document.getElementById('search_text9').value.trim();
			var dept_id=document.getElementById('dept_id9').value;
			var prog_id=document.getElementById('program_id9').value;
			var filter_semester=document.getElementById('filter_semester9').value;
			var filter_grade=document.getElementById('filter_grade9').value;
			var filter_instructor=document.getElementById('filter_instructor9').value;
			var filter_status=document.getElementById('filter_status9').value;
		
		
			document.getElementById("show_more_btn_search_result9").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading9").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables9').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables9').innerHTML=document.getElementById('search_result_tables9').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label9').innerHTML=total9;
					
					if(total9>page9)
					{
						document.getElementById("show_more_btn_search_result9").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label9').innerHTML='N/A';
					document.getElementById("search_results_loading9").innerHTML = '<td colspan="8"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page9;
			page9=page9+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results9.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&program_id="+prog_id+"&dept_id="+dept_id+"&filter_semester="+filter_semester+"&filter_grade="+filter_grade+"&filter_instructor="+filter_instructor+"&filter_status="+filter_status, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading9").innerHTML='';
			document.getElementById('search_data_label9').innerHTML='N/A';
			document.getElementById('search_result_tables9').innerHTML='<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result9").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa9_btn = document.getElementById("pa9_btn");
	var pa9=document.getElementById('page9');
	// When the user scrolls down 20px from the top of the document, show the button
	pa9.onscroll = function() {pa9_scrollFunction()};

	function pa9_scrollFunction() {
	  if (pa9.scrollTop > 20) {
		pa9_btn.style.display = "block";
	  } else {
		pa9_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa9_topFunction() {
	  pa9.scrollTop = 0;
	}
	
	
	reload_dept9();
	

</script>



