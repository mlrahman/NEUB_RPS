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

<i onclick="pa2_topFunction()" id="pa2_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

<!-- Confirmation modal -->
<div id="dept_view_re_confirmation" class="w3-modal" style="padding-top:100px;">
	<div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border w3-border-black" style="max-width:700px;width:80%;">
		<header class="w3-container w3-black"> 
			<p class="w3-xxlarge" style="margin:0px 0px 10px 0px;">Confirmation</p>
		</header>
		<form onsubmit="return false">
			
		<div class="w3-container w3-padding">
			<p class="w3-large w3-bold w3-text-brown">Are you sure you want to remove the department?</p>
			
			<label><i class="w3-text-red">*</i> <b>Enter your password</b></label>
			<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" id="dept_view_pass" placeholder="Enter your password" autocomplete="off">
			
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
					<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha_dept_view_confirm" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-grey w3-padding w3-black">
			<button class="w3-button w3-right w3-green w3-border w3-round-large" onclick="remove_dept_view()">Yes</button>
			<button class="w3-button w3-right w3-red w3-border w3-round-large w3-margin-right" onclick="document.getElementById('dept_view_re_confirmation').style.display='none';document.getElementById('captcha_dept_view_confirm').value='';document.getElementById('dept_view_pass').value='';">No</button>
		</div>
		</form>
	</div>
	<script>
		//Captcha Validation for create new password
		var reservation_captcha_dept_view_confirm = document.getElementById("captcha_dept_view_confirm");
		var sol_dept_view_confirm=<?php echo $ccc; ?>;
		function reservation_captcha_val_dept_view_confirm(){
		  
		  //console.log(reservation_captcha.value);
		  //console.log(sol);
		  if(reservation_captcha_dept_view_confirm.value != sol_dept_view_confirm) {
			reservation_captcha_dept_view_confirm.setCustomValidity("Please Enter Valid Answer.");
			return false;
		  } else {
			reservation_captcha_dept_view_confirm.setCustomValidity('');
			return true;
		  }
		}
		reservation_captcha_dept_view_confirm.onchange=reservation_captcha_val_dept_view_confirm;
	
	
		var pass_dept_view_confirm = document.getElementById("dept_view_pass");
		function dept_view_pass_co_fu()
		{
			if(pass_dept_view_confirm.value.trim()!="")
			{
				pass_dept_view_confirm.setCustomValidity('');
				return true;
			}
			else
			{
				pass_dept_view_confirm.setCustomValidity('Enter valid password');
				return false;
			}
		}
		pass_dept_view_confirm.onchange=dept_view_pass_co_fu;
		
	</script>
</div>

<div class="w3-container w3-margin-bottom w3-margin-top">
	
	<div class="w3-container w3-padding-0" style="margin:0px 0px 20px 0px;">
		<div class="w3-dropdown-hover w3-round-large">
			<button class="w3-button w3-black w3-round-large w3-hover-teal"><i class="fa fa-plus"></i> Add Department</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4 w3-animate-zoom">
				<a href="#" class="w3-bar-item w3-button w3-hover-teal">Single</a>
				<a href="#" class="w3-bar-item w3-button w3-hover-teal">Multiple</a>
			</div>
		</div>
			
	</div>
	
	<div class="w3-container" style="margin: 2px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text2" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_2').style.display='inline-block'; } else { document.getElementById('search_clear_btn_2').style.display='none'; } get_search_result2();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Department Title or Code for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_2" title="Clear search box" onclick="document.getElementById('search_text2').value=''; document.getElementById('search_clear_btn_2').style.display='none';get_search_result2();"></i>
		</div>
	</div>
	

	<div id="search_window2" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box2()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:285px;"><i class="fa fa-eye"></i> Department Details</p>
		<div id="search_window_details2" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:205px;"><i class="fa fa-server"></i> Departments</p>

	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort2" onchange="get_total_search_results2(0,0)" type="w3-input w3-round-large">
				<option value="1">Title ASC</option>
				<option value="2">Title DESC</option>
				<option value="3">Code ASC</option>
				<option value="4">Code DESC</option>
			</select>
		</span>
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter2').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
		
		
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter2" style="display:none;">
		Status: 
		<select id="filter_status" onchange="get_total_search_results2(0,0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			<option value="1">Active</option>
			<option value="2">Inactive</option>
			
		</select>
		
		<span onclick="document.getElementById('filter2').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
	</div>
	
	<div class="w3-clear"></div>
		
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label2"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:30%;" valign="top" class="w3-padding-small">Department Title</td>
			<td style="width:20%;" valign="top" class="w3-padding-small">Department Code</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Total Programs</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Total Students</td>
			<td style="width:16%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables2">
		
		
		</tbody>
		<tr id="search_results_loading2" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result2" onclick="get_total_search_results2(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>

	var dept_view_old_title;
	var dept_view_old_code;
	var dept_view_old_captcha;
	var dept_view_old_status;
	
	var dept_view_title;
	var dept_view_code;
	var dept_view_captcha;
	var dept_view_status;
	
	function remove_dept_view()
	{
		var pass=document.getElementById('dept_view_pass').value.trim();
		if(reservation_captcha_val_dept_view_confirm()==true && dept_view_pass_co_fu()==true)
		{
			document.getElementById('captcha_dept_view_confirm').value='';
			document.getElementById('dept_view_pass').value='';
			
			document.getElementById('dept_view_re_confirmation').style.display='none';
			
			var dept_id=document.getElementById('dept_view_id').value.trim();
			
			document.getElementById('dept_view_box1').style.display='none';
			document.getElementById('dept_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText.trim()=='Ok')
					{
						get_search_result2();
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Department successfully removed.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
					
						
					}
					else if(this.responseText.trim()=='pass_error')
					{
						document.getElementById('dept_view_box1').style.display='block';
						document.getElementById('dept_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry password doesn\'t match.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else if(this.responseText.trim()=='unable')
					{
						document.getElementById('dept_view_box1').style.display='block';
						document.getElementById('dept_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Sorry unable to remove this department.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					}
					else
					{
						document.getElementById('dept_view_box1').style.display='block';
						document.getElementById('dept_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('dept_view_box1').style.display='block';
					document.getElementById('dept_view_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/delete_department.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id+"&pass="+pass, true);
			xhttp1.send();
		}
	}
	
	function dept_view_form_change()
	{
		dept_view_title=document.getElementById('dept_view_title').value.trim();
		dept_view_code=document.getElementById('dept_view_code').value.trim();
		dept_view_captcha=document.getElementById('dept_view_captcha').value.trim();
		dept_view_status=document.getElementById('dept_view_status').value.trim();
		
		dept_view_old_title=document.getElementById('dept_view_old_title').value.trim();
		dept_view_old_code=document.getElementById('dept_view_old_code').value.trim();
		dept_view_old_captcha=document.getElementById('dept_view_old_captcha').value.trim();
		dept_view_old_status=document.getElementById('dept_view_old_status').value.trim();
		
		if(dept_view_status=='Active')
		{
			if(document.getElementById('dept_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('dept_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('dept_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('dept_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('dept_view_status').classList.add('w3-pale-green');
		}
		else
		{
			if(document.getElementById('dept_view_status').classList.contains('w3-pale-green'))
			{
				document.getElementById('dept_view_status').classList.remove('w3-pale-green');
			}
			if(document.getElementById('dept_view_status').classList.contains('w3-pale-red'))
			{
				document.getElementById('dept_view_status').classList.remove('w3-pale-red');
			}
			document.getElementById('dept_view_status').classList.add('w3-pale-red');
		}
		
		if(dept_view_title=="" || dept_view_code=="" || dept_view_status=="" || (dept_view_title==dept_view_old_title && dept_view_code==dept_view_old_code && dept_view_status==dept_view_old_status))
		{
			document.getElementById("dept_view_save_btn").disabled = true;
		}
		else if(dept_view_title!=dept_view_old_title || dept_view_code!=dept_view_old_code || dept_view_status!=dept_view_old_status)
		{
			document.getElementById("dept_view_save_btn").disabled = false;
		}
	}
	
	function dept_view_form_reset()
	{
		dept_view_old_title=document.getElementById('dept_view_old_title').value.trim();
		dept_view_old_code=document.getElementById('dept_view_old_code').value.trim();
		dept_view_old_captcha=document.getElementById('dept_view_old_captcha').value.trim();
		dept_view_old_status=document.getElementById('dept_view_old_status').value.trim();
		
		document.getElementById('dept_view_title').value=dept_view_old_title;
		document.getElementById('dept_view_code').value=dept_view_old_code;
		document.getElementById('dept_view_captcha').value='';
		document.getElementById('dept_view_status').value=dept_view_old_status;
		
		document.getElementById("dept_view_save_btn").disabled = true;
	}
	
	function dept_view_form_save_changes(dept_id)
	{
		dept_view_title=document.getElementById('dept_view_title').value.trim();
		dept_view_code=document.getElementById('dept_view_code').value.trim();
		dept_view_captcha=document.getElementById('dept_view_captcha').value.trim();
		dept_view_status=document.getElementById('dept_view_status').value.trim();
		
		dept_view_old_title=document.getElementById('dept_view_old_title').value.trim();
		dept_view_old_code=document.getElementById('dept_view_old_code').value.trim();
		dept_view_old_captcha=document.getElementById('dept_view_old_captcha').value.trim();
		dept_view_old_status=document.getElementById('dept_view_old_status').value.trim();
		
		
		if(dept_view_title=="" || dept_view_code=="" || dept_view_status=="")
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please fill up all the fields.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else if(dept_view_captcha=="" || dept_view_captcha!=dept_view_old_captcha)
		{
			document.getElementById('invalid_msg').style.display='block';
			document.getElementById('i_msg').innerHTML='Please insert valid captcha.';
			setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		}
		else
		{
			document.getElementById('dept_view_box1').style.display='none';
			document.getElementById('dept_view_box2').style.display='block';
			var xhttp1 = new XMLHttpRequest();
			xhttp1.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText.trim()=='Ok')
					{
						document.getElementById('dept_view_box1').style.display='block';
						document.getElementById('dept_view_box2').style.display='none';
						document.getElementById('dept_view_old_title').value=dept_view_title;
						document.getElementById('dept_view_old_code').value=dept_view_code;
						document.getElementById('dept_view_old_status').value=dept_view_status;
						document.getElementById('dept_view_captcha').value='';
						document.getElementById("dept_view_save_btn").disabled = true;
						
						if(dept_view_status=='Active')
						{
							if(document.getElementById('dept_view_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('dept_view_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('dept_view_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('dept_view_status').classList.remove('w3-pale-red');
							}
							document.getElementById('dept_view_status').classList.add('w3-pale-green');
						}
						else
						{
							if(document.getElementById('dept_view_status').classList.contains('w3-pale-green'))
							{
								document.getElementById('dept_view_status').classList.remove('w3-pale-green');
							}
							if(document.getElementById('dept_view_status').classList.contains('w3-pale-red'))
							{
								document.getElementById('dept_view_status').classList.remove('w3-pale-red');
							}
							document.getElementById('dept_view_status').classList.add('w3-pale-red');
						}
						
						get_total_search_results2(0,0);
						
						document.getElementById('valid_msg').style.display='block';
						document.getElementById('v_msg').innerHTML='Changes saved successfully.';
						setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
		
					}
					else
					{
						document.getElementById('dept_view_box1').style.display='block';
						document.getElementById('dept_view_box2').style.display='none';
						
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Unknown error occurred.';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
		
					}
				}
				else if(this.readyState==4 && (this.status==404 || this.status==403))
				{
					document.getElementById('dept_view_box1').style.display='block';
					document.getElementById('dept_view_box2').style.display='none';
					
					document.getElementById('invalid_msg').style.display='block';
					document.getElementById('i_msg').innerHTML='Network error occurred.';
					setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
				}
				
			};
			xhttp1.open("POST", "../includes/super_admin/edit_department.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_title="+dept_view_title+"&dept_code="+dept_view_code+"&dept_status="+dept_view_status+"&dept_id="+dept_id, true);
			xhttp1.send();
		}
		
	}
	
	function get_search_result2()
	{
		close_search_box2();
		get_total_search_results2(0,0);
	}
	
	function view_result2(dept_id)
	{
		
		document.getElementById('search_window2').style.display='block';
		var page2=document.getElementById('page2');
		page2.scrollTop = 20;
		document.getElementById('search_window_details2').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details2').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details2').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results2.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		search_window_result.send();
		
		
	}
	function close_search_box2()
	{
		document.getElementById('search_window_details2').innerHTML='';
		document.getElementById('search_window2').style.display='none';
	}
	
	
	var page2=0,total2;
	function get_total_search_results2(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading2").innerHTML='<td colspan="6"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort2').value;
		var search_text=document.getElementById('search_text2').value.trim();
		var filter_status=document.getElementById('filter_status').value.trim();
		
		
		var total2_results = new XMLHttpRequest();
		total2_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total2=parseInt(this.responseText.trim());
				get_search_results2(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total2=0;
				get_search_results2(x,y);
			}
		};
		document.getElementById('search_data_label2').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total2_results.open("GET", "../includes/super_admin/get_total_search_results2.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&filter_status="+filter_status, true);
		total2_results.send();
		
	}
	
	function get_search_results2(x,y)
	{
		if(x==0)
		{
			page2=0;
			document.getElementById('search_result_tables2').innerHTML='';
		}
		if(total2!=0)
		{
			var r_sort=document.getElementById('search_result_sort2').value;
			var search_text=document.getElementById('search_text2').value.trim();
			var filter_status=document.getElementById('filter_status').value.trim();
			
		
			document.getElementById("show_more_btn_search_result2").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading2").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables2').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables2').innerHTML=document.getElementById('search_result_tables2').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label2').innerHTML=total2;
					
					if(total2>page2)
					{
						document.getElementById("show_more_btn_search_result2").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label2').innerHTML='N/A';
					document.getElementById("search_results_loading2").innerHTML = '<td colspan="6"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page2;
			page2=page2+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results2.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&filter_status="+filter_status, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading2").innerHTML='';
			document.getElementById('search_data_label2').innerHTML='N/A';
			document.getElementById('search_result_tables2').innerHTML='<tr><td colspan="6"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result2").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa2_btn = document.getElementById("pa2_btn");
	var pa2=document.getElementById('page2');
	// When the user scrolls down 20px from the top of the document, show the button
	pa2.onscroll = function() {pa2_scrollFunction()};

	function pa2_scrollFunction() {
	  if (pa2.scrollTop > 20) {
		pa2_btn.style.display = "block";
	  } else {
		pa2_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa2_topFunction() {
	  pa2.scrollTop = 0;
	}
	
	
	get_search_result2();
	

</script>