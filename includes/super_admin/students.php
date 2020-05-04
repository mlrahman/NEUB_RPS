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

<i onclick="pa8_topFunction()" id="pa8_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
	<i class="fa fa-folder-open-o"></i> Program: 
	<select onchange="get_total_search_results8(0,0);" id="prog_id8" style="max-width:150px;">
		
	</select>
	
</p>

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 0px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select id="dept_id8" style="max-width:150px;" onchange="reload_dept8()">
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
<div id="student_multiple_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the students?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="student_multiple_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="student_multiple_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_multiple_add_re_confirmation').style.display='none';document.getElementById('student_multiple_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_student_multiple_add_confirm = document.getElementById("student_multiple_add_pass");
		function student_multiple_add_pass_co_fu()
		{
			if(pass_student_multiple_add_confirm.value.trim()!="")
			{
				pass_student_multiple_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_student_multiple_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_student_multiple_add_confirm.onchange=student_multiple_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add single-->
<div id="student_single_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add the student?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="student_single_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="student_single_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_single_add_re_confirmation').style.display='none';document.getElementById('student_single_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_student_single_add_confirm = document.getElementById("student_single_add_pass");
		function student_single_add_pass_co_fu()
		{
			if(pass_student_single_add_confirm.value.trim()!="")
			{
				pass_student_single_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_student_single_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_student_single_add_confirm.onchange=student_single_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add single waive course-->
<div id="student_single_waive_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add this course in waived list?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="student_single_waive_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="student_single_waive_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_single_waive_add_re_confirmation').style.display='none';document.getElementById('student_single_waive_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_student_single_waive_add_confirm = document.getElementById("student_single_waive_add_pass");
		function student_single_waive_add_pass_co_fu()
		{
			if(pass_student_single_waive_add_confirm.value.trim()!="")
			{
				pass_student_single_waive_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_student_single_waive_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_student_single_waive_add_confirm.onchange=student_single_waive_add_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add multiple waived courses -->
<div id="student_multiple_waive_add_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add all the waived courses?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="student_multiple_waive_add_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="student_multiple_waive_add_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_multiple_waive_add_re_confirmation').style.display='none';document.getElementById('student_multiple_waive_add_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_student_multiple_waive_add_confirm = document.getElementById("student_multiple_waive_add_pass");
		function student_multiple_waive_add_pass_co_fu()
		{
			if(pass_student_multiple_waive_add_confirm.value.trim()!="")
			{
				pass_student_multiple_waive_add_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_student_multiple_waive_add_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_student_multiple_waive_add_confirm.onchange=student_multiple_waive_add_pass_co_fu;
		
	</script>
</div>



<!-- Confirmation modal for remove waive course -->
<div id="student_waive2_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove this course from waived list?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="waive2_pass" placeholder="Enter your password" autocomplete="off">
			
			<input type="hidden" id="remove_waived_course_id" value="-1">
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_waive2_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_waive2()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_waive2_confirmation').style.display='none';document.getElementById('captcha_waive2_confirm').value='';document.getElementById('waive2_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_waive2_confirm = document.getElementById("captcha_waive2_confirm");
		var sol_waive2_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_waive2_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_waive2_confirm.value != sol_waive2_confirm) {
			reservation_captcha_waive2_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_waive2_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_waive2_confirm.onchange=reservation_captcha_val_waive2_confirm;
	
	
		var pass_waive2_confirm = document.getElementById("waive2_pass");
		function waive2_pass_co_fu()
		{
			if(pass_waive2_confirm.value.trim()!="")
			{
				pass_waive2_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_waive2_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_waive2_confirm.onchange=waive2_pass_co_fu;
		
	</script>
</div>


<!-- Confirmation modal for add waive course-->
<div id="student_waive_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to add this course in waived list?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large w3-margin-bottom" type="password" id="student_waive_pass" placeholder="Enter your password" autocomplete="off">
			
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="student_waive_form_save()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_waive_re_confirmation').style.display='none';document.getElementById('student_waive_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		var pass_student_waive_confirm = document.getElementById("student_waive_pass");
		function student_waive_pass_co_fu()
		{
			if(pass_student_waive_confirm.value.trim()!="")
			{
				pass_student_waive_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_student_waive_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_student_waive_confirm.onchange=student_waive_pass_co_fu;
		
	</script>
</div>

<!-- Confirmation modal for student delete -->
<div id="student_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove this student?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="student_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_student_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_student_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('student_view_re_confirmation').style.display='none';document.getElementById('captcha_student_view_confirm').value='';document.getElementById('student_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_student_view_confirm = document.getElementById("captcha_student_view_confirm");
		var sol_student_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_student_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_student_view_confirm.value != sol_student_view_confirm) {
			reservation_captcha_student_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_student_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_student_view_confirm.onchange=reservation_captcha_val_student_view_confirm;
	
	
		var pass_student_view_confirm = document.getElementById("student_view_pass");
		function student_view_pass_co_fu()
		{
			if(pass_student_view_confirm.value.trim()!="")
			{
				pass_student_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_student_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_student_view_confirm.onchange=student_view_pass_co_fu;
		
	</script>
</div>

<div class="w3-container w3-margin-bottom">
	
	<!-- Menu for student add -->

	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Student</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window8').style.display='block';document.getElementById('add_multiple_window8').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window8').style.display='block';document.getElementById('add_single_window8').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		
		
		<div class="w3-dropdown-hover w3-round-large w3-margin-left">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Waived Course</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a onclick="document.getElementById('add_single_window_waive8').style.display='block';document.getElementById('add_multiple_window_waive8').style.display='none';" class="w3-cursor w3-bar-item w3-button w3-hover-teal">Single</a>
				<a onclick="document.getElementById('add_multiple_window_waive8').style.display='block';document.getElementById('add_single_window_waive8').style.display='none';" class=" w3-cursor w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
		
		<button onclick="get_student_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
		
	</div>
	
	<!-- Window for add single student -->

	<div id="add_single_window8" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window8_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:275px;"><i class="fa fa-plus"></i> Add Single Student</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="student_single_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><i class="w3-text-red">*</i> <b>Student ID</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" id="student_single_add_id" placeholder="Enter Student ID" autocomplete="off" oninput="student_single_add_form_change()">
							
						
						<label><i class="w3-text-red">*</i> <b>Student Name</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="student_single_add_name" placeholder="Enter Student Name" autocomplete="off" oninput="student_single_add_form_change()">
							
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Date of Birth</b> <i class="fa fa-exclamation-circle w3-cursor" title="Be careful inserting date of birth (MM/DD/YYYY) cause it will require for fetch result in student panel."></i></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="date" id="student_single_add_birth_date" placeholder="Enter Student Birth Date" autocomplete="off" oninput="student_single_add_form_change()">
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><i class="w3-text-red">*</i> <b>Student Gender</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_single_add_gender" onchange="student_single_add_form_change()">
									<option value="">Select</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Other">Other</option>
								</select>
							</div>
						</div>	
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><b>Student Email</b> <i class="fa fa-exclamation-circle w3-cursor" title="By inserting email the notification and two factor authentication service will be enabled for this student."></i></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" id="student_single_add_email" placeholder="Enter Student Email" autocomplete="off" oninput="student_single_add_form_change()">
							</div>
							<div class="w3-col" style="margin-left:2%;width:49%;">
								<label><b>Student Mobile</b></label>
								<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" id="student_single_add_mobile" placeholder="Enter Student Mobile No" autocomplete="off" oninput="student_single_add_form_change()">
							</div>
						</div>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:49%;">
								<label><i class="w3-text-red">*</i> <b>Enrolled Program</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_single_add_prog" onchange="student_single_add_form_change()" >
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
								<label><i class="w3-text-red">*</i> <b>Status</b></label>
								<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="student_single_add_status" onchange="student_single_add_form_change()">
									<option value="" class="w3-pale-green">Select</option>
									<option value="Active" class="w3-pale-green">Active</option>
									<option value="Inactive" class="w3-pale-red">Inactive</option>
								</select>
								<?php
									
									//spam Check 
									$aaa=rand(1,20);
									$bbb=rand(1,20);
									$ccc=$aaa+$bbb;
								?>
								
							</div>
						</div>
						<input type="hidden" id="student_single_add_old_captcha" value="<?php echo $ccc; ?>">
						<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:40%;">
								<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:58%;">
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="student_single_add_captcha" autocomplete="off" oninput="student_single_add_form_change()">
							</div>
						</div>
						
						
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						
						<button onclick="student_single_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button onclick="document.getElementById('student_single_add_re_confirmation').style.display='block';" id="student_single_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="student_single_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>
	
	<!-- Window for add multiple student -->

	<div id="add_multiple_window8" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window8_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:305px;"><i class="fa fa-plus"></i> Add Multiple Student</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="student_multiple_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_student.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>Input date according to the format <b>YYYY-MM-DD</b>. Inserting email will subscribe the notification and 2FA service for a student. Photo is uploadable from the edit option only.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. Don't forget to select a program in the below form. You can insert at most <b>300 students</b> in a single upload under a single program.</li>
					<li>This process may take <b>up to five minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					<label><i class="w3-text-red">*</i> <b>Program</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_multiple_add_prog" onchange="student_multiple_add_form_change()">
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
					<input class="w3-input w3-border w3-round-large" type="file" id="student_excel_file" title="Please upload the formatted and filled up excel file."  onchange="student_multiple_add_form_change()">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="student_multiple_add_captcha" autocomplete="off" onkeyup="student_multiple_add_form_change()">
							<input type="hidden" value="<?php echo $ccc; ?>" id="student_multiple_add_old_captcha">
						</div>
					</div>
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:10px 0px 0px 6px;">
					
					<button onclick="student_multiple_add_form_clear()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
					</br>	
					<button onclick="document.getElementById('student_multiple_add_re_confirmation').style.display='block';" id="student_multiple_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
				</div>
			</div>
			
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="student_multiple_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="student_multiple_studentress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="student_multiple_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('student_multiple_add_box1').style.display='block';document.getElementById('student_multiple_add_box3').style.display='none';document.getElementById('student_multiple_add_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="student_multiple_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="student_multiple_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="student_multiple_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="student_multiple_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Window for add multiple waive courses -->

	<div id="add_multiple_window_waive8" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_multiple_window_waive8_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:295px;"><i class="fa fa-plus"></i> Add Multiple Course</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="student_multiple_waive_add_box1">
			<div class="w3-container w3-margin-top w3-margin-bottom w3-sand w3-justify w3-round-large w3-padding">
				<p class="w3-bold w3-margin-0"><u>Steps</u>:</p>
				<ol>
					<li>First download the formatted excel file from <a href="../excel_files/demo/insert_multiple_waive_course.xlsx" target="_blank" class="w3-text-blue">here</a>.</li>
					<li>In this excel file (<span class="w3-text-red">*</span>) marked columns are mandatory for each row (not valid for blank row). Very carefully fill up the rows with your data. <b>Don't put gap</b> between two rows. Also <b>ignore duplicated data</b> for consistent input.</li>
					<li>After filling the necessary rows you have to <b>submit it from the below form</b>. You can insert at most <b>300 waived courses</b> for students in a single upload.</li>
					<li>This process may take <b>up to four minutes</b> so keep patience. After finishing the process you will get a logs.</li>
				</ol>
			</div>
			
			<div class="w3-row w3-margin-top w3-margin-bottom w3-round-large w3-border w3-padding">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 6px;">
					
					<label><i class="w3-text-red">*</i> <b>Upload Excel File</b></label>
					<input class="w3-input w3-border w3-round-large" type="file" id="student_waive_excel_file" title="Please upload the formatted and filled up excel file."  onchange="student_multiple_waive_add_form_change()">
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="student_multiple_waive_add_captcha" autocomplete="off" onkeyup="student_multiple_waive_add_form_change()">
							<input type="hidden" value="<?php echo $ccc; ?>" id="student_multiple_waive_add_old_captcha">
						</div>
					</div>
				
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:10px 0px 0px 6px;">
					
					<button onclick="student_multiple_waive_add_form_clear()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
					</br>	
					<button onclick="document.getElementById('student_multiple_waive_add_re_confirmation').style.display='block';" id="student_multiple_waive_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
				</div>
			</div>
			
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="student_multiple_waive_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<div class="w3-light-grey w3-round-xlarge w3-border w3-margin-top w3-margin-bottom" style="width:50%;margin:0 auto;">
				<div class="w3-container w3-blue w3-round-xlarge w3-text-white w3-bold" id="student_multiple_waive_studentress_id" style="width:0%;">0%</div>
			</div>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="student_multiple_waive_add_box3" style="display: none;">
			<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('student_multiple_waive_add_box1').style.display='block';document.getElementById('student_multiple_waive_add_box3').style.display='none';document.getElementById('student_multiple_waive_add_box2').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
			<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
				<p class="w3-bold w3-margin-0 w3-xlarge"><u>Process Complete</u> 
					(<span id="student_multiple_waive_total" class="w3-text-blue w3-margin-0 w3-large"></span>), 
					(<span id="student_multiple_waive_success" class="w3-text-green w3-margin-0 w3-large"></span>), 
					(<span  id="student_multiple_waive_failed" class="w3-text-red w3-margin-0 w3-large"></span>)
				</p>
				<div class="w3-container w3-margin-0 w3-justify w3-small w3-padding w3-round-large w3-light-gray" id="student_multiple_waive_logs" style="height:auto;max-height: 250px;overflow:auto;">
					
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	<!-- Window for add single waive course -->

	<div id="add_single_window_waive8" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="add_single_window_waive8_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:265px;"><i class="fa fa-plus"></i> Add Single Course</p>
		<div class="w3-container w3-margin-0 w3-padding-0" id="student_single_waive_add_box1">
			<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
			<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
				<div class="w3-row w3-margin-0 w3-padding-0">
					<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
						<label><i class="w3-text-red">*</i> <b>Student ID</b></label>
						<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" id="student_single_waive_add_id" placeholder="Enter Student ID" autocomplete="off" oninput="student_single_waive_add_form_change()">
							
						<label><i class="w3-text-red">*</i> <b>Waive Course</b></label>
						<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="student_single_waive_add_course" onchange="student_single_waive_add_form_change()" placeholder="Select Waived Course">
							<option value="">Select</option>
							<?php
								$stmt = $conn->prepare("select nr_course_id,nr_course_code,nr_course_title from nr_course order by nr_course_code asc,nr_course_title asc");
								$stmt->execute();
								$stud_result=$stmt->fetchAll();
								if(count($stud_result)>0)
								{
									$sz=count($stud_result);
									for($k=0;$k<$sz;$k++)
									{
										$course_id=$stud_result[$k][0];
										$course_code=$stud_result[$k][1];
										$course_title=$stud_result[$k][2];
										echo '<option value="'.$course_id.'">'.$course_code.' : '.$course_title.'</option>';
									}
								}
							?>
						</select>
						<?php
							//spam Check 
							$aaa=rand(1,20);
							$bbb=rand(1,20);
							$ccc=$aaa+$bbb;
						?>
						<input type="hidden" id="student_single_waive_add_old_captcha" value="<?php echo $ccc; ?>">
						<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
						<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
							<div class="w3-col" style="width:40%;">
								<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
							</div>
							<div class="w3-col" style="margin-left:2%;width:58%;">
								<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="student_single_waive_add_captcha" autocomplete="off" oninput="student_single_waive_add_form_change()">
							</div>
						</div>
					</div>
					<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
						
						<button onclick="student_single_waive_add_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Clear</button>
						
						<button onclick="document.getElementById('student_single_waive_add_re_confirmation').style.display='block';" id="student_single_waive_add_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save</button>
					
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0 w3-center" style="display:none;" id="student_single_waive_add_box2">
			<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
			<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
		</div>
	</div>

	
	
	
	<!-- window for delete history -->
	<div id="student_delete_history_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="student_delete_history_window_close()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:340px;"><i class="fa fa-history"></i> Student Remove History</p>
		<div class="w3-container w3-margin-0 w3-padding-0"  id="student_delete_history_window_box">
			
		</div>
	</div>
	
	
	<!-- Search box -->

	<div class="w3-container" style="margin: 2px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text8" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_8').style.display='inline-block'; } else { document.getElementById('search_clear_btn_8').style.display='none'; } get_search_result8();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Student ID or Name for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_8" title="Clear search box" onclick="document.getElementById('search_text8').value=''; document.getElementById('search_clear_btn_8').style.display='none';get_search_result8();"></i>
		</div>
	</div>
	
	<!-- Wndow for view result -->

	<div id="search_window8" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box8()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:235px;"><i class="fa fa-eye"></i> Student Details</p>
		<div id="search_window_details8" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	

	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:155px;"><i class="fa fa-server"></i> Students</p>
	
	<!-- sort options for student list -->
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort8" onchange="get_total_search_results8(0,0)" type="w3-input w3-round-large">
				<option value="1">Student ID ASC</option>
				<option value="2">Student ID DESC</option>
				<option value="3">Name ASC</option>
				<option value="4">Name DESC</option>
				<option value="5">Credit Earned ASC</option>
				<option value="6">Credit Earned DESC</option>
				<option value="7">Credit Waived ASC</option>
				<option value="8">Credit Waived DESC</option>
				<option value="9">CGPA ASC</option>
				<option value="10">CGPA DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter8').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
		
	<!-- filter for student list -->
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter8" style="display:none;">
		Status: 
		<select id="filter_status8" onchange="get_total_search_results8(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Active</option>
			<option value="2">Inactive</option>
			
		</select>
		
		Degree Status: 
		<select id="filter_degree8" onchange="get_total_search_results8(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Graduated</option>
			<option value="2">Dropout</option>
			
		</select>
		
		<span onclick="document.getElementById('filter8').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
	</div>
	
	<div class="w3-clear"></div>
	
	<!-- table for student list -->
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label8"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:7%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:8%;" valign="top" class="w3-padding-small">Student ID</td>
			<td style="width:24%;" valign="top" class="w3-padding-small">Name</td>
			<td style="width:17%;" valign="top" class="w3-padding-small">Session</td>
			<td style="width:9%;" valign="top" class="w3-padding-small">Credit Earned</td>
			<td style="width:9%;" valign="top" class="w3-padding-small">Credit Waived</td>
			<td style="width:9%;" valign="top" class="w3-padding-small">Program Credit</td>
			<td style="width:7%;" valign="top" class="w3-padding-small">CGPA</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables8">
		
		
		</tbody>
		<tr id="search_results_loading8" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result8" onclick="get_total_search_results8(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>

	function student_single_waive_add_form_reset()
	{
		document.getElementById('student_single_waive_add_id').value='';
		document.getElementById('student_single_waive_add_course').value='';
		document.getElementById('student_single_waive_add_captcha').value='';
		document.getElementById('student_single_waive_add_save_btn').disabled=true;
	}
	
	function student_single_waive_add_form_change()
	{
		student_view_id=document.getElementById('student_single_waive_add_id').value.trim();
		student_view_course=document.getElementById('student_single_waive_add_course').value.trim();
		if(student_view_id=="" || student_view_course=="" || student_view_id.length!=12)
			document.getElementById('student_single_waive_add_save_btn').disabled=true;
		else
			document.getElementById('student_single_waive_add_save_btn').disabled=false;
		
	}
	
	function add_single_window_waive8_close()
	{
		document.getElementById('student_single_waive_add_id').value='';
		document.getElementById('student_single_waive_add_course').value='';
		document.getElementById('student_single_waive_add_captcha').value='';
		document.getElementById('student_single_waive_add_save_btn').disabled=true;
		
		document.getElementById('add_single_window_waive8').style.display='none';
		
	}
	
	
	function student_single_waive_add_form_save()
	{
		student_view_id=document.getElementById('student_single_waive_add_id').value.trim();
		student_view_course=document.getElementById('student_single_waive_add_course').value.trim();
		student_view_captcha=document.getElementById('student_single_waive_add_captcha').value.trim();
		student_view_old_captcha=document.getElementById('student_single_waive_add_old_captcha').value.trim();
		
		if(student_view_id=="" || student_view_course=="" || student_view_id.length!=12)
		{
			document.getElementById('student_single_waive_add_pass').value='';
			
			document.getElementById('student_single_waive_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_view_captcha=="" || student_view_captcha!=student_view_old_captcha)
		{
			document.getElementById('student_single_waive_add_pass').value='';
			
			document.getElementById('student_single_waive_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_single_waive_add_pass_co_fu()==true)
		{
			
			
			var pass=document.getElementById('student_single_waive_add_pass').value.trim();
			
			document.getElementById('student_single_waive_add_pass').value='';
			
			document.getElementById('student_single_waive_add_re_confirmation').style.display='none';
			
			
			document.getElementById('student_single_waive_add_box1').style.display='none';
			document.getElementById('student_single_waive_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						add_single_window_waive8_close();
						
						get_search_result8();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Course successfully added in student course waived list.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in student course waived list (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in student course waived list (course inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable3')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in student course waived list(invalid course ID).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable4')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in student course waived list (invalid student ID).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable5')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in student course waived list (student ID inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable6')
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in student course waived list (student graduated).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('student_single_waive_add_box1').style.display='block';
						document.getElementById('student_single_waive_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_single_waive_add_box1').style.display='block';
					document.getElementById('student_single_waive_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_waived_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&student_id="+student_view_id+"&course_id="+student_view_course, true);
			xhttp1.send();
		}
	}
	
	
	function student_multiple_waive_add_form_clear()
	{
		document.getElementById('student_waive_excel_file').value='';
		document.getElementById('student_multiple_waive_add_captcha').value='';
		document.getElementById('student_multiple_waive_add_save_btn').disabled=true;
	}
	
	function student_multiple_waive_add_form_change()
	{
		var excel=document.getElementById('student_waive_excel_file').value.trim();
		if(excel=="")
			document.getElementById('student_multiple_waive_add_save_btn').disabled=true;
		else
			document.getElementById('student_multiple_waive_add_save_btn').disabled=false;
	}
	
	function add_multiple_window_waive8_close()
	{
		document.getElementById('student_waive_excel_file').value='';
		document.getElementById('student_multiple_waive_add_captcha').value='';
		document.getElementById('student_multiple_waive_add_save_btn').disabled=true;
		
		document.getElementById('add_multiple_window_waive8').style.display='none';
		
	}
	
	
	function student_multiple_waive_add_form_save()
	{
		var student_excel_file=document.getElementById('student_waive_excel_file').value;
		
		student_view_captcha=document.getElementById('student_multiple_waive_add_captcha').value.trim();
		student_view_old_captcha=document.getElementById('student_multiple_waive_add_old_captcha').value.trim();
		
		if(student_excel_file=="" || file_validate3(student_excel_file)==false)
		{
			document.getElementById('student_multiple_waive_add_pass').value='';
			
			document.getElementById('student_multiple_waive_add_re_confirmation').style.display='none';
			
			document.getElementById("student_multiple_waive_add_save_btn").disabled = true;
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload the required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
	
		}
		else if(student_view_captcha=="" || student_view_captcha!=student_view_old_captcha)
		{
			document.getElementById('student_multiple_waive_add_pass').value='';
			
			document.getElementById('student_multiple_waive_add_re_confirmation').style.display='none';
		
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_multiple_waive_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('student_multiple_waive_add_pass').value.trim();
			
			document.getElementById('student_multiple_waive_add_pass').value='';
			
			document.getElementById('student_multiple_waive_add_re_confirmation').style.display='none';
			
			document.getElementById('student_multiple_waive_add_box1').style.display='none';
			document.getElementById('student_multiple_waive_add_box3').style.display='none';
			document.getElementById('student_multiple_waive_add_box2').style.display='block';
			
			document.getElementById('student_multiple_waive_total').innerHTML='';
			document.getElementById('student_multiple_waive_success').innerHTML='';
			document.getElementById('student_multiple_waive_failed').innerHTML='';
			document.getElementById('student_multiple_waive_logs').innerHTML='';
			
			var excel_file=document.getElementById('student_waive_excel_file').files[0];
			var fd_excel=new FormData();
			var link='student_waive_excel_file';
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
						
						
						document.getElementById('student_multiple_waive_studentress_id').style.width='0%';
						document.getElementById('student_multiple_waive_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_waive_add_box1').style.display='none';
						document.getElementById('student_multiple_waive_add_box3').style.display='block';
						document.getElementById('student_multiple_waive_add_box2').style.display='none';
				
						document.getElementById('student_multiple_waive_total').innerHTML=total;
						document.getElementById('student_multiple_waive_success').innerHTML=success;
						document.getElementById('student_multiple_waive_failed').innerHTML=failed;
						document.getElementById('student_multiple_waive_logs').innerHTML=logs;
			
						student_multiple_waive_add_form_clear();
						get_total_search_results8(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('student_multiple_waive_studentress_id').style.width='0%';
						document.getElementById('student_multiple_waive_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_waive_add_box1').style.display='block';
						document.getElementById('student_multiple_waive_add_box3').style.display='none';
						document.getElementById('student_multiple_waive_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('student_multiple_waive_studentress_id').style.width='0%';
						document.getElementById('student_multiple_waive_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_waive_add_box1').style.display='block';
						document.getElementById('student_multiple_waive_add_box3').style.display='none';
						document.getElementById('student_multiple_waive_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_multiple_waive_studentress_id').style.width='0%';
					document.getElementById('student_multiple_waive_studentress_id').innerHTML='0%';
					
					document.getElementById('student_multiple_waive_add_box1').style.display='block';
					document.getElementById('student_multiple_waive_add_box3').style.display='none';
					document.getElementById('student_multiple_waive_add_box2').style.display='none';
			
					
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
					 document.getElementById('student_multiple_waive_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('student_multiple_waive_studentress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('student_multiple_waive_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('student_multiple_waive_studentress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_waive_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass, true);
			xhttp1.send(fd_excel);
		
		
		}
	}
	
	function student_delete_history_window_close()
	{
		document.getElementById('student_delete_history_window_box').innerHTML='';
		document.getElementById('student_delete_history_window').style.display='none';
	}
	
	function get_student_delete_history()
	{
		document.getElementById('student_delete_history_window').style.display='block';
		document.getElementById('student_delete_history_window_box').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var xhttp1 = new XMLHttpRequest();
		xhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('student_delete_history_window_box').innerHTML=this.responseText;
			}
			else if(this.readyState==4 && (this.status==404 || this.status==403))
			{
				student_delete_history_window_close();
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('i_msg').innerHTML='Network error occurred.';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			}
		};
		xhttp1.open("POST", "../includes/super_admin/get_student_delete_history.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>, true);
		xhttp1.send();
	}
	

	function reload_dept8()
	{
		var dept_id=document.getElementById('dept_id8').value;
		var load_program = new XMLHttpRequest();
		load_program.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('prog_id8').innerHTML=this.responseText;
				get_total_search_results8(0,0);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('prog_id8').innerHTML='<option value="-1">All</option>';
		
			}
		};
				
		load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		load_program.send();
		
	}
	
	function add_multiple_window8_close()
	{
		document.getElementById('student_multiple_add_box1').style.display='block';
		document.getElementById('student_multiple_add_box2').style.display='none';
		document.getElementById('student_multiple_add_box3').style.display='none';
		document.getElementById('student_multiple_add_captcha').value='';
		document.getElementById('student_excel_file').value='';
		document.getElementById('student_multiple_add_prog').value='';
		
		document.getElementById('student_multiple_total').innerHTML='';
		document.getElementById('student_multiple_success').innerHTML='';
		document.getElementById('student_multiple_failed').innerHTML='';
		document.getElementById('student_multiple_logs').innerHTML='';
			
		document.getElementById("student_multiple_add_save_btn").disabled = true;
		document.getElementById('add_multiple_window8').style.display='none';
	
	}
	
	function student_multiple_add_form_change()
	{
		var student_excel_file=document.getElementById('student_excel_file').value;
		var student_prog=document.getElementById('student_multiple_add_prog').value;
		
		if(student_excel_file=="" || student_prog=="")
		{
			document.getElementById("student_multiple_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("student_multiple_add_save_btn").disabled = false;
		}
	}

	function student_multiple_add_form_clear()
	{
		document.getElementById('student_multiple_add_captcha').value='';
		document.getElementById('student_excel_file').value='';
		document.getElementById('student_multiple_add_prog').value='';
						
		document.getElementById("student_multiple_add_save_btn").disabled = true;
		
	}

	function add_single_window8_close()
	{
		document.getElementById('student_single_add_box1').style.display='block';
		document.getElementById('student_single_add_box2').style.display='none';
			
		document.getElementById('student_single_add_name').value='';
		document.getElementById('student_single_add_id').value='';
		document.getElementById('student_single_add_birth_date').value='';
		document.getElementById('student_single_add_gender').value='';
		document.getElementById('student_single_add_email').value='';
		document.getElementById('student_single_add_mobile').value='';
		document.getElementById('student_single_add_prog').value='';
		document.getElementById('student_single_add_status').value='';
		document.getElementById('student_single_add_captcha').value='';
		
		if(student_single_add_status=='Active')
		{
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_single_add_status').classList.add('w3-pale-green');
		}
		else if(student_single_add_status=='Inactive')
		{
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-red');
			}
		}
		
		document.getElementById('add_single_window8').style.display='none';
		
		document.getElementById("student_single_add_save_btn").disabled = true;
		
	}
	
	function student_single_add_form_change()
	{
		student_view_name=document.getElementById('student_single_add_name').value.trim();
		student_view_id=document.getElementById('student_single_add_id').value.trim();
		student_view_birth_date=document.getElementById('student_single_add_birth_date').value.trim();
		student_view_gender=document.getElementById('student_single_add_gender').value.trim();
		student_view_email=document.getElementById('student_single_add_email').value.trim();
		student_view_mobile=document.getElementById('student_single_add_mobile').value.trim();
		student_view_prog=document.getElementById('student_single_add_prog').value.trim();
		student_view_status=document.getElementById('student_single_add_status').value.trim();
		student_view_captcha=document.getElementById('student_single_add_captcha').value.trim();
		
		if(student_single_add_status=='Active')
		{
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_single_add_status').classList.add('w3-pale-green');
		}
		else if(student_single_add_status=='Inactive')
		{
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_single_add_status').classList.add('w3-pale-red');
		}
		else
		{
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_single_add_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_single_add_status').classList.remove('w3-pale-red');
			}
		}
		if(student_view_name=="" || student_view_id=="" || student_view_birth_date=="" || student_view_prog=="" || student_view_status=="" || student_view_gender=="")
		{
			document.getElementById("student_single_add_save_btn").disabled = true;
		}
		else
		{
			document.getElementById("student_single_add_save_btn").disabled = false;
		}
	}

	function student_single_add_form_reset()
	{
		document.getElementById('student_single_add_name').value='';
		document.getElementById('student_single_add_id').value='';
		document.getElementById('student_single_add_birth_date').value='';
		document.getElementById('student_single_add_gender').value='';
		document.getElementById('student_single_add_email').value='';
		document.getElementById('student_single_add_mobile').value='';
		document.getElementById('student_single_add_prog').value='';
		document.getElementById('student_single_add_status').value='';
		document.getElementById('student_single_add_captcha').value='';
					
		document.getElementById("student_single_add_save_btn").disabled = true;
	}
	
	function student_multiple_add_form_save()
	{
		var student_excel_file=document.getElementById('student_excel_file').value;
		var student_prog=document.getElementById('student_multiple_add_prog').value;
		student_view_captcha=document.getElementById('student_multiple_add_captcha').value.trim();
		student_view_old_captcha=document.getElementById('student_multiple_add_old_captcha').value.trim();
		
		if(student_prog=="" || student_excel_file=="" || file_validate3(student_excel_file)==false)
		{
			document.getElementById('student_multiple_add_pass').value='';
			
			document.getElementById('student_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById("student_multiple_add_save_btn").disabled = true;
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload the required excel file.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
	
		}
		else if(student_view_captcha=="" || student_view_captcha!=student_view_old_captcha)
		{
			document.getElementById('student_multiple_add_pass').value='';
			
			document.getElementById('student_multiple_add_re_confirmation').style.display='none';
		
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_multiple_add_pass_co_fu()==true)
		{
			var pass=document.getElementById('student_multiple_add_pass').value.trim();
			
			document.getElementById('student_multiple_add_pass').value='';
			
			document.getElementById('student_multiple_add_re_confirmation').style.display='none';
			
			document.getElementById('student_multiple_add_box1').style.display='none';
			document.getElementById('student_multiple_add_box3').style.display='none';
			document.getElementById('student_multiple_add_box2').style.display='block';
			
			document.getElementById('student_multiple_total').innerHTML='';
			document.getElementById('student_multiple_success').innerHTML='';
			document.getElementById('student_multiple_failed').innerHTML='';
			document.getElementById('student_multiple_logs').innerHTML='';
			
			var excel_file=document.getElementById('student_excel_file').files[0];
			var fd_excel=new FormData();
			var link='student_excel_file';
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
						
						
						document.getElementById('student_multiple_studentress_id').style.width='0%';
						document.getElementById('student_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_add_box1').style.display='none';
						document.getElementById('student_multiple_add_box3').style.display='block';
						document.getElementById('student_multiple_add_box2').style.display='none';
				
						document.getElementById('student_multiple_total').innerHTML=total;
						document.getElementById('student_multiple_success').innerHTML=success;
						document.getElementById('student_multiple_failed').innerHTML=failed;
						document.getElementById('student_multiple_logs').innerHTML=logs;
			
						student_multiple_add_form_clear();
						get_total_search_results8(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Process Successfully finished';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(status=='PE')
					{
						document.getElementById('student_multiple_studentress_id').style.width='0%';
						document.getElementById('student_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_add_box1').style.display='block';
						document.getElementById('student_multiple_add_box3').style.display='none';
						document.getElementById('student_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else if(status=='u2')
					{
						document.getElementById('student_multiple_studentress_id').style.width='0%';
						document.getElementById('student_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_add_box1').style.display='block';
						document.getElementById('student_multiple_add_box3').style.display='none';
						document.getElementById('student_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add (program inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					else
					{
						document.getElementById('student_multiple_studentress_id').style.width='0%';
						document.getElementById('student_multiple_studentress_id').innerHTML='0%';
						
						document.getElementById('student_multiple_add_box1').style.display='block';
						document.getElementById('student_multiple_add_box3').style.display='none';
						document.getElementById('student_multiple_add_box2').style.display='none';
				
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occured.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_multiple_studentress_id').style.width='0%';
					document.getElementById('student_multiple_studentress_id').innerHTML='0%';
					
					document.getElementById('student_multiple_add_box1').style.display='block';
					document.getElementById('student_multiple_add_box3').style.display='none';
					document.getElementById('student_multiple_add_box2').style.display='none';
			
					
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
					 document.getElementById('student_multiple_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('student_multiple_studentress_id').innerHTML= percentComplete+'%';
				  }
				  else
				  {
					 document.getElementById('student_multiple_studentress_id').style.width=percentComplete+'%';
					 document.getElementById('student_multiple_studentress_id').innerHTML= percentComplete+'%';
				  }
				}
			};
			xhttp1.open("POST", "../includes/super_admin/add_multiple_students.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&excel="+link+"&pass="+pass+"&student_prog="+student_prog, true);
			xhttp1.send(fd_excel);
		}
	}

	
	function student_single_add_form_save()
	{
		student_view_name=document.getElementById('student_single_add_name').value.trim();
		student_view_id=document.getElementById('student_single_add_id').value.trim();
		student_view_birth_date=document.getElementById('student_single_add_birth_date').value.trim();
		student_view_gender=document.getElementById('student_single_add_gender').value.trim();
		student_view_email=document.getElementById('student_single_add_email').value.trim();
		student_view_mobile=document.getElementById('student_single_add_mobile').value.trim();
		student_view_prog=document.getElementById('student_single_add_prog').value.trim();
		student_view_status=document.getElementById('student_single_add_status').value.trim();
		student_view_captcha=document.getElementById('student_single_add_captcha').value.trim();
		student_view_old_captcha=document.getElementById('student_single_add_old_captcha').value.trim();
		
		if(student_view_name=="" || student_view_id=="" || student_view_birth_date=="" || student_view_prog=="" || student_view_status=="" || student_view_gender=="")
		{
			document.getElementById('student_single_add_pass').value='';
			
			document.getElementById('student_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_view_captcha=="" || student_view_captcha!=student_view_old_captcha)
		{
			document.getElementById('student_single_add_pass').value='';
			
			document.getElementById('student_single_add_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_single_add_pass_co_fu()==true)
		{
			
			
			var pass=document.getElementById('student_single_add_pass').value.trim();
			
			document.getElementById('student_single_add_pass').value='';
			
			document.getElementById('student_single_add_re_confirmation').style.display='none';
			
			
			document.getElementById('student_single_add_box1').style.display='none';
			document.getElementById('student_single_add_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						add_single_window8_close();
						
						get_search_result8();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Student successfully added.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('student_single_add_box1').style.display='block';
						document.getElementById('student_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('student_single_add_box1').style.display='block';
						document.getElementById('student_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this student (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('student_single_add_box1').style.display='block';
						document.getElementById('student_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this student (program inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable3')
					{
						document.getElementById('student_single_add_box1').style.display='block';
						document.getElementById('student_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this student (invalid email).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable4')
					{
						document.getElementById('student_single_add_box1').style.display='block';
						document.getElementById('student_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this student (invalid student ID).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('student_single_add_box1').style.display='block';
						document.getElementById('student_single_add_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_single_add_box1').style.display='block';
					document.getElementById('student_single_add_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_single_student.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&student_name="+student_view_name+"&student_mobile="+student_view_mobile+"&student_email="+student_view_email+"&student_gender="+student_view_gender+"&student_id="+student_view_id+"&student_birth_date="+student_view_birth_date+"&student_prog="+student_view_prog+"&student_status="+student_view_status, true);
			xhttp1.send();
		}
	
	}
	
	
	var student_view_old_name;
	var student_view_old_id;
	var student_view_old_prog;
	var student_view_old_birth_date;
	var student_view_old_captcha;
	var student_view_old_status;
	var student_view_old_gender;
	var student_view_old_email;
	var student_view_old_mobile;
	var student_view_course;
	
	var student_view_name;
	var student_view_id;
	var student_view_prog;
	var student_view_birth_date;
	var student_view_captcha;
	var student_view_status;
	var student_view_gender;
	var student_view_email;
	var student_view_mobile;
	var student_view_dp;
	var student_waive_course,student_waive_captcha,student_waive_old_captcha;
	
	function remove_waive2()
	{
		var waive_course_id=document.getElementById('remove_waived_course_id').value.trim();
		if(waive_course_id!=-1)
		{
			var pass=document.getElementById('waive2_pass').value.trim();
			
			if(reservation_captcha_val_waive2_confirm()==true && waive2_pass_co_fu()==true)
			{
				document.getElementById('waive2_pass').value='';
				document.getElementById('captcha_waive2_confirm').value='';
				student_view_id=document.getElementById('student_view_id').value.trim();
			
				document.getElementById('student_waive2_confirmation').style.display='none';
				
				document.getElementById('student_view_box1').style.display='none';
				document.getElementById('student_view_box3').style.display='none';
				document.getElementById('student_view_box4').style.display='none';
				document.getElementById('student_view_box5').style.display='none';
				document.getElementById('student_view_box2').style.display='block';
				
				var xhttp1 = new XMLHttpRequest();
				xhttp1.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						//console.log(this.responseText.trim());
						if(this.responseText.trim()=='Ok')
						{
							close_search_box8();
							view_result8(student_view_id);
						
							get_total_search_results8(0,0);
							
							
							document.getElementById('valid_msg').style.display='block';
							document.getElementById('v_msg').innerHTML='Course successfully removed from waived list.';
							setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
			
						}
						else if(this.responseText.trim()=='pass_error')
						{
							document.getElementById('student_view_box4').style.display='none';
							document.getElementById('student_view_box2').style.display='none';
							document.getElementById('student_view_box3').style.display='none';
							document.getElementById('student_view_box1').style.display='none';
							document.getElementById('student_view_box5').style.display='block';
							
							document.getElementById('invalid_msg').style.display='block';
							document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
							setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
						}
						else
						{
							document.getElementById('student_view_box4').style.display='none';
							document.getElementById('student_view_box2').style.display='none';
							document.getElementById('student_view_box3').style.display='none';
							document.getElementById('student_view_box1').style.display='none';
							document.getElementById('student_view_box5').style.display='block';
							
							document.getElementById('invalid_msg').style.display='block';
							document.getElementById('i_msg').innerHTML='Unknown error occurred.';
							setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
						}
						
						
					}
					else if(this.readyState==4 && (this.status==404 || this.status==403))
					{
						document.getElementById('student_view_box4').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Network error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					
				};
				xhttp1.open("POST", "../includes/super_admin/remove_student_waive_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&course_id="+waive_course_id+"&student_id="+student_view_id, true);
				xhttp1.send();
			}
		}
	}
	
	function delete_student_waived_credit(waive_course_id)
	{
		document.getElementById('remove_waived_course_id').value=waive_course_id;
		document.getElementById('student_waive2_confirmation').style.display='block';
	}
	
	function student_waive_form_save()
	{
		student_waive_course=document.getElementById('student_waive_course').value.trim();
		student_view_id=document.getElementById('student_view_id').value.trim();
		student_waive_captcha=document.getElementById('student_waive_captcha').value.trim();
		student_waive_old_captcha=document.getElementById('student_waive_old_captcha').value.trim();
		
		if(student_waive_course=="")
		{
			document.getElementById('student_waive_pass').value='';
			
			document.getElementById('student_waive_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_waive_captcha=="" || student_waive_captcha!=student_waive_old_captcha)
		{
			document.getElementById('student_waive_pass').value='';
			
			document.getElementById('student_waive_re_confirmation').style.display='none';
			
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_waive_pass_co_fu()==true)
		{
			var pass=document.getElementById('student_waive_pass').value.trim();
			
			document.getElementById('student_waive_pass').value='';
			
			document.getElementById('student_waive_re_confirmation').style.display='none';
			
			document.getElementById('student_view_box1').style.display='none';
			document.getElementById('student_view_box3').style.display='none';
			document.getElementById('student_view_box4').style.display='none';
			document.getElementById('student_view_box5').style.display='none';
			document.getElementById('student_view_box2').style.display='block';
			
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText.trim());
					if(this.responseText.trim()=='Ok')
					{
						close_search_box8();
						view_result8(student_view_id);
					
						get_total_search_results8(0,0);
						
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Course successfully added in waived list.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('student_view_box4').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('student_view_box4').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to add this course in waived list.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('student_view_box4').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='block';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					
					
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_view_box4').style.display='none';
					document.getElementById('student_view_box2').style.display='none';
					document.getElementById('student_view_box3').style.display='none';
					document.getElementById('student_view_box1').style.display='none';
					document.getElementById('student_view_box5').style.display='block';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/add_student_waive_course.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&pass="+pass+"&student_waive_course="+student_waive_course+"&student_id="+student_view_id, true);
			xhttp1.send();
		}
			
	}
	
	function student_waive_form_reset()
	{
		document.getElementById('student_waive_course').value='';
		document.getElementById('student_waive_captcha').value='';
		document.getElementById("student_waive_save_btn").disabled = true;
	}
	
	function student_waive_form_change()
	{
		student_waive_course=document.getElementById('student_waive_course').value.trim();
		student_waive_captcha=document.getElementById('student_waive_captcha').value.trim();
		if(student_waive_course=="")
			document.getElementById("student_waive_save_btn").disabled = true;
		else
			document.getElementById("student_waive_save_btn").disabled = false;
		
	}
	
	function remove_student_view()
	{
		var pass=document.getElementById('student_view_pass').value.trim();
		if(reservation_captcha_val_student_view_confirm()==true && student_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_student_view_confirm').value='';
			document.getElementById('student_view_pass').value='';
			
			document.getElementById('student_view_re_confirmation').style.display='none';
			
			var student_id=document.getElementById('student_view_id').value.trim();
			
			document.getElementById('student_view_box1').style.display='none';
			document.getElementById('student_view_box3').style.display='none';
			document.getElementById('student_view_box2').style.display='block';
			document.getElementById('student_view_box4').style.display='none';
			document.getElementById('student_view_box5').style.display='none';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						get_search_result8();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Student successfully removed.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box5').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box5').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to remove this student.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box5').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_view_box1').style.display='none';
					document.getElementById('student_view_box2').style.display='none';
					document.getElementById('student_view_box3').style.display='none';
					document.getElementById('student_view_box4').style.display='block';
					document.getElementById('student_view_box5').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_student.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&student_id="+student_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function student_view_form_change()
	{
		student_view_name=document.getElementById('student_view_name').value.trim();
		student_view_id=document.getElementById('student_view_id').value.trim();
		student_view_birth_date=document.getElementById('student_view_birth_date').value.trim();
		student_view_gender=document.getElementById('student_view_gender').value.trim();
		student_view_email=document.getElementById('student_view_email').value.trim();
		student_view_mobile=document.getElementById('student_view_mobile').value.trim();
		student_view_prog=document.getElementById('student_view_prog').value.trim();
		student_view_captcha=document.getElementById('student_view_captcha').value.trim();
		student_view_status=document.getElementById('student_view_status').value.trim();
		student_view_dp=document.getElementById('student_view_dp').value.trim();
		
		student_view_old_name=document.getElementById('student_view_old_name').value.trim();
		student_view_old_id=document.getElementById('student_view_old_id').value.trim();
		student_view_old_birth_date=document.getElementById('student_view_old_birth_date').value.trim();
		student_view_old_gender=document.getElementById('student_view_old_gender').value.trim();
		student_view_old_email=document.getElementById('student_view_old_email').value.trim();
		student_view_old_mobile=document.getElementById('student_view_old_mobile').value.trim();
		student_view_old_prog=document.getElementById('student_view_old_prog').value.trim();
		student_view_old_captcha=document.getElementById('student_view_old_captcha').value.trim();
		student_view_old_status=document.getElementById('student_view_old_status').value.trim();
		
		if(student_view_status=='Active')
		{
			if(document.getElementById('student_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('student_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_view_status').classList.add('w3-pale-red');
		}
		
		if(student_view_name=="" || student_view_id=="" || student_view_status=="" || student_view_prog=="" || student_view_birth_date==""  || student_view_gender=="" || (student_view_gender==student_view_old_gender && student_view_name==student_view_old_name  && student_view_email==student_view_old_email  && student_view_mobile==student_view_old_mobile && student_view_id==student_view_old_id && student_view_birth_date==student_view_old_birth_date && student_view_prog==student_view_old_prog && student_view_status==student_view_old_status && student_view_dp==""))
		{
			document.getElementById("student_view_save_btn").disabled = true;
		}
		else if(student_view_dp!="" || student_view_name!=student_view_old_name || student_view_id!=student_view_old_id || student_view_status!=student_view_old_status || student_view_birth_date!=student_view_old_birth_date || student_view_prog!=student_view_old_prog || student_view_gender!=student_view_old_gender || student_view_email!=student_view_old_email || student_view_mobile!=student_view_old_mobile)
		{
			document.getElementById("student_view_save_btn").disabled = false;
		}
	}
	
	function student_view_form_reset()
	{
		student_view_old_name=document.getElementById('student_view_old_name').value.trim();
		student_view_old_id=document.getElementById('student_view_old_id').value.trim();
		student_view_old_birth_date=document.getElementById('student_view_old_birth_date').value.trim();
		student_view_old_gender=document.getElementById('student_view_old_gender').value.trim();
		student_view_old_email=document.getElementById('student_view_old_email').value.trim();
		student_view_old_mobile=document.getElementById('student_view_old_mobile').value.trim();
		student_view_old_prog=document.getElementById('student_view_old_prog').value.trim();
		student_view_old_captcha=document.getElementById('student_view_old_captcha').value.trim();
		student_view_old_status=document.getElementById('student_view_old_status').value.trim();
		
		document.getElementById('student_view_name').value=student_view_old_name;
		document.getElementById('student_view_id').value=student_view_old_id;
		document.getElementById('student_view_birth_date').value=student_view_old_birth_date;
		document.getElementById('student_view_gender').value=student_view_old_gender;
		document.getElementById('student_view_email').value=student_view_old_email;
		document.getElementById('student_view_mobile').value=student_view_old_mobile;
		document.getElementById('student_view_prog').value=student_view_old_prog;
		document.getElementById('student_view_captcha').value='';
		document.getElementById('student_view_dp').value='';
		document.getElementById('student_view_status').value=student_view_old_status;
		document.getElementById('student_dp_msg').style.display='none';
		
		student_view_status=document.getElementById('student_view_status').value.trim();
		
		if(student_view_status=='Active')
		{
			if(document.getElementById('student_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('student_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('student_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('student_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('student_view_status').classList.add('w3-pale-red');
		}
		
		document.getElementById("student_view_save_btn").disabled = true;
	}
	
	function student_view_form_save_changes(student_id)
	{
		student_view_name=document.getElementById('student_view_name').value.trim();
		student_view_id=document.getElementById('student_view_id').value.trim();
		student_view_birth_date=document.getElementById('student_view_birth_date').value.trim();
		student_view_gender=document.getElementById('student_view_gender').value.trim();
		student_view_email=document.getElementById('student_view_email').value.trim();
		student_view_mobile=document.getElementById('student_view_mobile').value.trim();
		student_view_dp=document.getElementById('student_view_dp').value.trim();
		student_view_prog=document.getElementById('student_view_prog').value.trim();
		student_view_captcha=document.getElementById('student_view_captcha').value.trim();
		student_view_status=document.getElementById('student_view_status').value.trim();
		
		student_view_old_name=document.getElementById('student_view_old_name').value.trim();
		student_view_old_id=document.getElementById('student_view_old_id').value.trim();
		student_view_old_birth_date=document.getElementById('student_view_old_birth_date').value.trim();
		student_view_old_gender=document.getElementById('student_view_old_gender').value.trim();
		student_view_old_email=document.getElementById('student_view_old_email').value.trim();
		student_view_old_mobile=document.getElementById('student_view_old_mobile').value.trim();
		student_view_old_prog=document.getElementById('student_view_old_prog').value.trim();
		student_view_old_captcha=document.getElementById('student_view_old_captcha').value.trim();
		student_view_old_status=document.getElementById('student_view_old_status').value.trim();
		
		
		if(student_view_name=="" || student_view_id=="" || student_view_status=="" || student_view_birth_date=="" || student_view_prog=="" || student_view_gender=="")
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(student_view_captcha=="" || student_view_captcha!=student_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if((student_view_dp!="" && file_validate(student_view_dp)==true) || student_view_dp=="")
		{
			
			//DP
			var image=document.getElementById('student_view_dp').files[0];
			var fd_image=new FormData();
			var link='student_view_dp';
			fd_image.append(link, image);
			
			document.getElementById('student_view_box1').style.display='none';
			document.getElementById('student_view_box3').style.display='none';
			document.getElementById('student_view_box4').style.display='none';
			document.getElementById('student_view_box5').style.display='none';
			document.getElementById('student_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
					if(this.responseText.trim()=='Ok')
					{
						close_search_box8();
						view_result8(student_id);
					
						get_total_search_results8(0,0);
						
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='none';
					
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (duplicate detected).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable2')
					{
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='none';
					
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (invalid email).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable3')
					{
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='none';
					
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change (program inactive).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else if(this.responseText.trim()=='unable4')
					{
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='none';
					
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unable to make change in program (student graduated).';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('student_view_box4').style.display='block';
						document.getElementById('student_view_box2').style.display='none';
						document.getElementById('student_view_box3').style.display='none';
						document.getElementById('student_view_box1').style.display='none';
						document.getElementById('student_view_box5').style.display='none';
					
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('student_view_box4').style.display='block';
					document.getElementById('student_view_box2').style.display='none';
					document.getElementById('student_view_box3').style.display='none';
					document.getElementById('student_view_box1').style.display='none';
					document.getElementById('student_view_box5').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_student.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&student_old_email="+student_view_old_email+"&student_old_id="+student_view_old_id+"&student_dp="+student_view_dp+"&student_dp_2="+link+"&student_name="+student_view_name+"&student_id="+student_view_id+"&student_status="+student_view_status+"&student_birth_date="+student_view_birth_date+"&student_prog="+student_view_prog+"&student_old_prog="+student_view_old_prog+"&student_gender="+student_view_gender+"&student_email="+student_view_email+"&student_mobile="+student_view_mobile, true);
			xhttp1.send(fd_image);
		}
		else
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please upload valid DP (.jpg,.png,.jpeg,.bmp).';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
		}
	}
	
	function get_search_result8()
	{
		close_search_box8();
		get_total_search_results8(0,0);
	}
	
	
	function search_result_button(id)
	{
		for(var i=1;i<=5;i++)
		{
			if(i!=parseInt(id))
			{
				document.getElementById('se_re_div_'+i).style.display='none';
				//console.log(document.getElementById('se_re_btn_'+i).classList);
				if(document.getElementById('se_re_btn_'+i).classList.contains("w3-teal"))
					document.getElementById('se_re_btn_'+i).classList.remove("w3-teal");
				if(document.getElementById('se_re_btn_'+i).classList.contains("w3-border-teal"))
					document.getElementById('se_re_btn_'+i).classList.remove("w3-border-teal");
				document.getElementById('se_re_btn_'+i).classList.add("w3-white");
			}
		}
		document.getElementById('se_re_btn_'+id).classList.add("w3-teal");
		document.getElementById('se_re_btn_'+id).classList.add("w3-border-teal");
		if(document.getElementById('se_re_btn_'+id).classList.contains("w3-white"))
			document.getElementById('se_re_btn_'+id).classList.remove("w3-white");
		document.getElementById('se_re_div_'+id).style.display='block';
	}
		
	function show_result_div(y)
	{
		var z=document.getElementById(y+'_icon').className;
		//console.log(z);
		if(z=="fa fa-plus-square")
		{
			document.getElementById(y+'_icon').classList.remove("fa-plus-square");
			document.getElementById(y+'_icon').classList.add("fa-minus-square");
			document.getElementById(y).style.display='block';
		}
		else if(z=="fa fa-minus-square")
		{
			document.getElementById(y+'_icon').classList.remove("fa-minus-square");
			document.getElementById(y+'_icon').classList.add("fa-plus-square");
			document.getElementById(y).style.display='none';
			
		}
	}

	function admin_print_result(s_id,a_id)
	{
		window.open('../includes/super_admin/admin_result_print.php?student_id='+s_id+'&admin_id='+a_id);		
	}
	function admin_print_result_official(s_id,a_id)
	{
		window.open('../includes/super_admin/admin_result_print_official.php?student_id='+s_id+'&admin_id='+a_id);		
	}
	
	function view_result8(student_id)
	{
		
		document.getElementById('search_window8').style.display='block';
		var page8=document.getElementById('page8');
		page8.scrollTop = 20;
		document.getElementById('search_window_details8').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details8').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details8').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results8.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&student_id="+student_id, true);
		search_window_result.send();
		
		
	}
	
	function close_search_box8()
	{
		document.getElementById('search_window_details8').innerHTML='';
		document.getElementById('search_window8').style.display='none';
	}
	
	
	var page8=0,total8;
	function get_total_search_results8(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading8").innerHTML='<td colspan="9"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort8').value;
		var search_text=document.getElementById('search_text8').value.trim();
		var filter_status8=document.getElementById('filter_status8').value.trim();
		var filter_degree8=document.getElementById('filter_degree8').value.trim();
		var dept_id8=document.getElementById('dept_id8').value.trim();
		var prog_id8=document.getElementById('prog_id8').value.trim();
		
		
		var total8_results = new XMLHttpRequest();
		total8_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total8=parseInt(this.responseText.trim());
				get_search_results8(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total8=0;
				get_search_results8(x,y);
			}
		};
		document.getElementById('search_data_label8').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total8_results.open("GET", "../includes/super_admin/get_total_search_results8.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&filter_status="+filter_status8+"&filter_degree="+filter_degree8+"&dept_id="+dept_id8+"&prog_id="+prog_id8, true);
		total8_results.send();
		
	}
	
	function get_search_results8(x,y)
	{
		if(x==0)
		{
			page8=0;
			document.getElementById('search_result_tables8').innerHTML='';
		}
		if(total8!=0)
		{
			var r_sort=document.getElementById('search_result_sort8').value;
			var search_text=document.getElementById('search_text8').value.trim();
			var filter_status8=document.getElementById('filter_status8').value.trim();
			var filter_degree8=document.getElementById('filter_degree8').value.trim();
			var dept_id8=document.getElementById('dept_id8').value.trim();
			var prog_id8=document.getElementById('prog_id8').value.trim();
		
		
			document.getElementById("show_more_btn_search_result8").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading8").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables8').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables8').innerHTML=document.getElementById('search_result_tables8').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label8').innerHTML=total8;
					
					if(total8>page8)
					{
						document.getElementById("show_more_btn_search_result8").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label8').innerHTML='N/A';
					document.getElementById("search_results_loading8").innerHTML = '<td colspan="9"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page8;
			page8=page8+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results8.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&filter_status="+filter_status8+"&filter_degree="+filter_degree8+"&dept_id="+dept_id8+"&prog_id="+prog_id8, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading8").innerHTML='';
			document.getElementById('search_data_label8').innerHTML='N/A';
			document.getElementById('search_result_tables8').innerHTML='<tr><td colspan="9"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result8").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa8_btn = document.getElementById("pa8_btn");
	var pa8=document.getElementById('page8');
	// When the user scrolls down 20px from the top of the document, show the button
	pa8.onscroll = function() {pa8_scrollFunction()};

	function pa8_scrollFunction() {
	  if (pa8.scrollTop > 20) {
		pa8_btn.style.display = "block";
	  } else {
		pa8_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa8_topFunction() {
	  pa8.scrollTop = 0;
	}
	
	
	reload_dept8();
	

</script>