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
		
		<button onclick="" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-eraser"></i> Remove Multiple Result</button>
		
		<button onclick="get_result_delete_history()" class="w3-button w3-black w3-round-large w3-hover-teal w3-margin-left"><i class="fa fa-history"></i> Remove History</button>
		
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
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label9"></span></p>		
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



