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

<i onclick="pa11_topFunction()" id="pa11_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>


<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
	<i class="fa fa-folder-open-o"></i> Program: 
	<select onchange="get_search_result11();" id="program_id11" style="max-width:150px;">
		
	</select>
	
</p>
<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select onchange="reload_dept11()" id="dept_id11" style="max-width:150px;">
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
<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	<i class="fa fa-folder-open-o"></i> User Role: 
	<select onchange="get_search_result11();" id="user_type11" style="max-width:150px;">
		<option value="-1">All</option>
		<option value="1">Student</option>
		<option value="2">Faculty</option>
		<option value="3">Moderator</option>
		<option value="4">Admin</option>
		<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
		<option value="5">Super Admin</option>
		<?php } ?>
	</select>
</p>



<div class="w3-container w3-margin-bottom w3-margin-top">

	<div class="w3-container" style="margin: 11px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:310px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text11" oninput="if(this.value!=''){ document.getElementById('search_clear_btn_11').style.display='inline-block'; } else { document.getElementById('search_clear_btn_11').style.display='none'; } get_search_result11()" class="w3-input w3-border-teal" style="width:89%;min-width:220px;display:inline;" placeholder="Enter Student ID or Searched By for Search"  autocomplete="off">
			<i class="fa fa-close w3-text-red w3-hover-text-teal w3-cursor w3-large" style="display:none;" id="search_clear_btn_11" title="Clear search box" onclick="document.getElementById('search_text11').value=''; document.getElementById('search_clear_btn_11').style.display='none';get_search_result11();"></i>
		</div>
	</div>
	

	<div id="search_window11" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box11()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:270px;"><i class="fa fa-eye"></i> Search Details</p>
		<div id="search_window_details11" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>

	
	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:230px;"><i class="fa fa-server"></i> Search Records</p>

	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort11" onchange="get_total_search_results11(0,0)" type="w3-input w3-round-large">
				<option value="1">Student ID ASC</option>
				<option value="2">Student ID DESC</option>
				<option value="3">Searched By ASC</option>
				<option value="4">Searched By DESC</option>
				<option value="5">Date ASC</option>
				<option value="6">Date DESC</option>
			</select>
		</span>
	</p>

	<div class="w3-clear"></div>
		
		
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label11"></span></p>		
	<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
		<tr class="w3-teal w3-bold">
			<td style="width:9%;" valign="top" class="w3-padding-small">S.L. No</td>
			<td style="width:19%;" valign="top" class="w3-padding-small">Student ID</td>
			<td style="width:25%;" valign="top" class="w3-padding-small">Searched By</td>
			<td style="width:11%;" valign="top" class="w3-padding-small">User Role</td>
			<td style="width:14%;" valign="top" class="w3-padding-small">Date</td>
			<td style="width:11%;" valign="top" class="w3-padding-small">Time</td>
			<td style="width:10%;" valign="top" class="w3-padding-small">Action</td>
		</tr>
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables11">
		
		
		</tbody>
		<tr id="search_results_loading11" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result11" onclick="get_total_search_results11(1,1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>


</div>


<script>
	
	function reload_dept11()
	{
		var dept_id=document.getElementById('dept_id11').value;
		var load_program = new XMLHttpRequest();
		load_program.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('program_id11').innerHTML=this.responseText;
				get_search_result11();
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('program_id11').innerHTML='<option value="-1">All</option>';
		
			}
		};
				
		load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		load_program.send();
		
	}
	
	function get_search_result11()
	{
		close_search_box11();
		get_total_search_results11(0,0);
	}
	
	function view_result11(user_type,user_id,s_id,date,time)
	{
		
		document.getElementById('search_window11').style.display='block';
		var page11=document.getElementById('page11');
		page11.scrollTop = 20;
		document.getElementById('search_window_details11').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
		var search_window_result = new XMLHttpRequest();
		search_window_result.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('search_window_details11').innerHTML=this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('search_window_details11').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
		
			}
		};
				
		search_window_result.open("GET", "../includes/super_admin/get_search_window_results11.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&user_type="+user_type+"&user_id="+user_id+"&s_id="+s_id+"&date="+date+"&time="+time, true);
		search_window_result.send();
		
		
	}
	function close_search_box11()
	{
		document.getElementById('search_window_details11').innerHTML='';
		document.getElementById('search_window11').style.display='none';
	}
	
	
	var page11=0,total11;
	function get_total_search_results11(x,y)
	{
		//return 0;
		document.getElementById("search_results_loading11").innerHTML='<td colspan="7"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var r_sort=document.getElementById('search_result_sort11').value;
		var search_text=document.getElementById('search_text11').value.trim();
		var dept_id=document.getElementById('dept_id11').value;
		var prog_id=document.getElementById('program_id11').value;
		var user_type=document.getElementById('user_type11').value;
		
		
		var total11_results = new XMLHttpRequest();
		total11_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				total11=parseInt(this.responseText.trim());
				get_search_results11(x,y);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total11=0;
				get_search_results11(x,y);
			}
		};
		document.getElementById('search_data_label11').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
		
		total11_results.open("GET", "../includes/super_admin/get_total_search_results11.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_text="+search_text+"&program_id="+prog_id+"&dept_id="+dept_id+"&user_type="+user_type, true);
		total11_results.send();
		
	}
	
	function get_search_results11(x,y)
	{
		if(x==0)
		{
			page11=0;
			document.getElementById('search_result_tables11').innerHTML='';
		}
		if(total11!=0)
		{
			var r_sort=document.getElementById('search_result_sort11').value;
			var search_text=document.getElementById('search_text11').value.trim();
			var dept_id=document.getElementById('dept_id11').value;
			var prog_id=document.getElementById('program_id11').value;
			var user_type=document.getElementById('user_type11').value;
		
		
			document.getElementById("show_more_btn_search_result11").style.display='none';
			
			var search_results = new XMLHttpRequest();
			search_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("search_results_loading11").innerHTML='';
					if(y==0) //first call
					{
						document.getElementById('search_result_tables11').innerHTML=this.responseText;
					}
					else //show_more
					{
						document.getElementById('search_result_tables11').innerHTML=document.getElementById('search_result_tables11').innerHTML+this.responseText;
					}
					document.getElementById('search_data_label11').innerHTML=total11;
					
					if(total11>page11)
					{
						document.getElementById("show_more_btn_search_result11").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_data_label11').innerHTML='N/A';
					document.getElementById("search_results_loading11").innerHTML = '<td colspan="7"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
				}
			};
			
			var search_results_from=page11;
			page11=page11+5;
			
			search_results.open("GET", "../includes/super_admin/get_search_results11.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&search_results_from="+search_results_from+"&sort="+r_sort+"&search_text="+search_text+"&program_id="+prog_id+"&dept_id="+dept_id+"&user_type="+user_type, true);
			search_results.send();
		}
		else
		{
			
			document.getElementById("search_results_loading11").innerHTML='';
			document.getElementById('search_data_label11').innerHTML='N/A';
			document.getElementById('search_result_tables11').innerHTML='<tr><td colspan="7"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn_search_result11").style.display='none';
			
		}
	}

	
	
	//Get the button
	var pa11_btn = document.getElementById("pa11_btn");
	var pa11=document.getElementById('page11');
	// When the user scrolls down 20px from the top of the document, show the button
	pa11.onscroll = function() {pa11_scrollFunction()};

	function pa11_scrollFunction() {
	  if (pa11.scrollTop > 20) {
		pa11_btn.style.display = "block";
	  } else {
		pa11_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function pa11_topFunction() {
	  pa11.scrollTop = 0;
	}
	
	
	reload_dept11();
	

</script>



