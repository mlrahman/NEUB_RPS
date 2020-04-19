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

<i onclick="pa13_topFunction()" id="pa13_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>
<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	<i class="fa fa-folder-open-o"></i> User Type: 
	<select onchange="get_search_result13();" id="user_type13" style="max-width:150px;">
		<option value="-1">All</option>
		<option value="1">Faculty</option>
		<option value="2">Moderator</option>
		<option value="3">Admin</option>
		<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
		<option value="4">Super Admin</option>
		<?php } ?>
	</select>
</p>

<div class="w3-container w3-margin-bottom w3-margin-top">

	<div class="w3-container" style="margin: 13px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text13" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_13').style.display='inline-block'; } else { document.getElementById('search_clear_btn_13').style.display='none'; } get_search_result13();  " class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter User Name for Search the Session"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_13" title="Clear search box" onclick="document.getElementById('search_text13').value=''; document.getElementById('search_clear_btn_13').style.display='none';get_search_result13();"></i>
		</div>
	</div>
	

	<div id="search_window13" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box13()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:230px;"><i class="fa fa-eye"></i> Session Details</p>
		<div id="search_window_details13" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	
	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:245px;"><i class="fa fa-server"></i> Session Records</p>

	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort13" onchange="get_total_search_results13(0,0)" type="w3-input w3-round-large">
				<option value="1">Session ASC</option>
				<option value="2">Session DESC</option>
				<option value="3">Name ASC</option>
				<option value="4">Name DESC</option>
			</select>
		</span>
	</p>
	
	<div class="w3-clear"></div>
		
		
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label13"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:8%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:28%;" valign="top" class="w3-padding-small">Name</td>
			<td style="width:19%;" valign="top" class="w3-padding-small">Designation</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">User Type</td>
			<td style="width:9%;" valign="top" class="w3-padding-small">Total Session</td>
			<td style="width:15%;" valign="top" class="w3-padding-small">Last Session</td>
			<td style="width:12%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables13">
		
		
		</tbody>
		<tr id="search_results_loading13" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result13" onclick="get_total_search_results13(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>

<script>

	function session_inactive_function(status,user_type,user_id,date,time)
	{
		if(date=='-1' && time=='-1') //Request for all
		{
			document.getElementById('user_session_table_details').innerHTML='<tr><td class="w3-center" colspan="7" style="padding: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</td</tr>';
		}
		else //individual request
		{
			document.getElementById(user_type+user_id+date+time).innerHTML='<td valign="top" colspan="7" class="w3-padding-small w3-border w3-center"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</td>';
		}
		
		var session_var = new XMLHttpRequest();
		session_var.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if(date=='-1' && time=='-1') //Request for all
				{
					document.getElementById('user_session_table_details').innerHTML=this.responseText.trim();
					document.getElementById('session_inactive_btn').style.display="none";
				}
				else //individual request
				{
					document.getElementById(user_type+user_id+date+time).classList.add("w3-pale-red");
					document.getElementById(user_type+user_id+date+time).innerHTML=this.responseText.trim();
				}
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				if(date=='-1' && time=='-1') //Request for all
				{
					document.getElementById('user_session_table_details').innerHTML='<tr><td class="w3-center w3-text-red" colspan="7" style="padding: 50px 0px 50px 0px;"><i class="fa fa-warning"></i> Network Error Occurred</td</tr>';
				}
				else //individual request
				{
					document.getElementById(user_type+user_id+date+time).innerHTML='<td valign="top" colspan="7" class="w3-padding-small w3-border w3-center w3-text-red" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</td>';
				}
			}
		};
				
		session_var.open("GET", "../includes/super_admin/set_session_status.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&user_type="+user_type+"&user_id="+user_id+"&status="+status+"&date="+date+"&time="+time, true);
		session_var.send();
		
		
	}

	function get_search_result13()
	{
		close_search_box13();
		get_total_search_results13(0,0);
	}
	
	function view_result13(user_type,user_id)
	{
		
		document.getElementById('search_window13').style.display='block';
		var page13=document.getElementById('page13');
		page13.scrollTop = 20;
		document.getElementById('search_window_details13').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details13').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details13').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results13.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&user_type="+user_type+"&user_id="+user_id, true);
		search_window_result.send();
		
		
	}
	function close_search_box13()
	{
		document.getElementById('search_window_details13').innerHTML='';
		document.getElementById('search_window13').style.display='none';
	}
	
	
	var page13=0,total13;
	function get_total_search_results13(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading13").innerHTML='<td colspan="7"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort13').value;
		var search_text=document.getElementById('search_text13').value.trim();
		var user_type=document.getElementById('user_type13').value;
		
		
		var total13_results = new XMLHttpRequest();
		total13_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total13=parseInt(this.responseText.trim());
				get_search_results13(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total13=0;
				get_search_results13(x,y);
			}
		};
		document.getElementById('search_data_label13').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total13_results.open("GET", "../includes/super_admin/get_total_search_results13.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&user_type="+user_type, true);
		total13_results.send();
		
	}
	
	function get_search_results13(x,y)
	{
		if(x==0)
		{
			page13=0;
			document.getElementById('search_result_tables13').innerHTML='';
		}
		if(total13!=0)
		{
			var r_sort=document.getElementById('search_result_sort13').value;
			var search_text=document.getElementById('search_text13').value.trim();
			var user_type=document.getElementById('user_type13').value;
		
		
			document.getElementById("show_more_btn_search_result13").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading13").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables13').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables13').innerHTML=document.getElementById('search_result_tables13').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label13').innerHTML=total13;
					
					if(total13>page13)
					{
						document.getElementById("show_more_btn_search_result13").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label13').innerHTML='N/A';
					document.getElementById("search_results_loading13").innerHTML = '<td colspan="7"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page13;
			page13=page13+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results13.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&user_type="+user_type, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading13").innerHTML='';
			document.getElementById('search_data_label13').innerHTML='N/A';
			document.getElementById('search_result_tables13').innerHTML='<tr><td colspan="7"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result13").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa13_btn = document.getElementById("pa13_btn");
	var pa13=document.getElementById('page13');
	// When the user scrolls down 20px from the top of the document, show the button
	pa13.onscroll = function() {pa13_scrollFunction()};

	function pa13_scrollFunction() {
	  if (pa13.scrollTop > 20) {
		pa13_btn.style.display = "block";
	  } else {
		pa13_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa13_topFunction() {
	  pa13.scrollTop = 0;
	}
	
	
	get_search_result13();
	

</script>