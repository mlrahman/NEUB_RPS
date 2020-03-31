<?php
	try{
		require("../includes/faculty/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>

<div id="search_view_2" class="w3-container w3-margin-bottom" style="display:none;">
	
	<div class="w3-container" style="margin: 12px 0px 25px 0px;padding:0px;position:relative;">
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:300px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text2" onkeyup="get_search_result2()" class="w3-input w3-border-teal" style="width:92%;min-width:230px;display:inline;" placeholder="Enter Course Name or Code for Search">
		</div>
	</div>

	<script>
		function get_search_result2()
		{
			close_search_box2();
			get_total_search_results2(0);
		}
	</script>
	
	
	<div id="search_window2" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box2()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:230px;"><i class="fa fa-cube"></i> Result Details</p>
		<div id="search_window_details2" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	<script>
		function view_result2(r_id)
		{
			document.getElementById('search_text2').value='';
			get_search_result2();
			
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
					
			search_window_result.open("GET", "../includes/faculty/get_search_window_results2.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&r_id="+r_id, true);
			search_window_result.send();
			
			
		}
		function close_search_box2()
		{
			document.getElementById('search_window_details2').innerHTML='';
			document.getElementById('search_window2').style.display='none';
		}
	
	</script>
	
	
	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:280px;"><i class="fa fa-server"></i> All Course Results</p>
	
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		<span>
			Sort By: 
			<select id="search_result_sort2" onchange="get_total_search_results2(0)" type="w3-input w3-round-large">
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
		<i class="fa fa-filter w3-button w3-black w3-hover-teal w3-round-large" onclick="document.getElementById('filter').style.display='block'" style="margin:0px 0px 0px 8px;" > Filter</i>
	</p>
	
	<div class="w3-clear"></div>
	
	<div class="w3-container w3-padding w3-margin-0 w3-padding-0 w3-topbar w3-right w3-leftbar w3-bottombar w3-rightbar w3-round-large" id="filter" style="display:none;">
		Semester: 
		<select id="filter_semester" onchange="get_total_search_results2(0)" type="w3-input w3-round-large">
			<option value="-1">All</option>
			
		</select>
		Grade: 
		<select id="filter_grade" onchange="get_total_search_results2(0)" type="w3-input w3-round-large">
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
		 
		<span onclick="document.getElementById('filter').style.display='none';" title="Close filter" class="w3-button w3-medium w3-red w3-hover-teal w3-round w3-margin-0" style="padding:0px 4px; margin:0px 0px 0px 8px;"><i class="fa fa-minus w3-margin-0 w3-padding-0"></i></span>
		
		<script>
			function get_filter_semester()
			{
				var prog_id=document.getElementById('program_id3').value;
			
				var fi_sem = new XMLHttpRequest();
				fi_sem.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						
						document.getElementById('filter_semester').innerHTML=this.responseText;
					}
					if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
						document.getElementById('filter_semester').innerHTML='<option value="-1">All</option>';
					}
				};
				fi_sem.open("GET", "../includes/faculty/get_filter_semester.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&program_id2="+prog_id, true);
				fi_sem.send();
			}
		</script>
		
	</div>
	
	<div class="w3-clear"></div>
	
	
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label2"></span></p>		
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
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables2">
		
		
		</tbody>
		<tr id="search_results_loading2" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result2" onclick="get_total_search_results2(1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>
	
	<script>
		
		var page3=0,total3;
		function get_total_search_results2(x)
		{
			//return 0;
			document.getElementById("search_results_loading2").innerHTML='<td colspan="8"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
				
			var prog_id=document.getElementById('program_id3').value;
			var r_sort=document.getElementById('search_result_sort2').value;
			var filter_semester=document.getElementById('filter_semester').value;
			var filter_grade=document.getElementById('filter_grade').value;
			var search_text=document.getElementById('search_text2').value.trim();
			
			
			var total3_results = new XMLHttpRequest();
			total3_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
					total3=parseInt(this.responseText.trim());
					get_search_results2(x);
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					total3=0;
					get_search_results2(x);
				}
			};
			document.getElementById('search_data_label2').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
					
			total3_results.open("GET", "../includes/faculty/get_total_search_results2.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&program_id2="+prog_id+"&search_text="+search_text+"&filter_semester="+filter_semester+"&filter_grade="+filter_grade, true);
			total3_results.send();
		}
		
		function get_search_results2(x)
		{
			if(x==0)
			{
				page3=0;
				document.getElementById('search_result_tables2').innerHTML='';
			}
			if(total3!=0)
			{
				var prog_id=document.getElementById('program_id3').value;
				var r_sort=document.getElementById('search_result_sort2').value;
				var search_text=document.getElementById('search_text2').value.trim();
			
				var filter_semester=document.getElementById('filter_semester').value;
				var filter_grade=document.getElementById('filter_grade').value;
			
				document.getElementById("show_more_btn_search_result2").style.display='none';
				
				var search_results = new XMLHttpRequest();
				search_results.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("search_results_loading2").innerHTML='';
						document.getElementById('search_result_tables2').innerHTML=document.getElementById('search_result_tables2').innerHTML+this.responseText;
						document.getElementById('search_data_label2').innerHTML=total3;
					
						if(total3>page3)
						{
							document.getElementById("show_more_btn_search_result2").style.display='block';
						}
						
					}
					if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
						document.getElementById('search_data_label2').innerHTML='N/A';
						document.getElementById("search_results_loading2").innerHTML = '<td colspan="8"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
					}
				};
				
				var search_results_from=page3;
				page3=page3+5;
				
				search_results.open("GET", "../includes/faculty/get_search_results2.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&search_results_from="+search_results_from+"&program_id2="+prog_id+"&sort="+r_sort+"&search_text="+search_text+"&filter_semester="+filter_semester+"&filter_grade="+filter_grade, true);
				search_results.send();
			}
			else
			{
				document.getElementById("search_results_loading2").innerHTML='';
				document.getElementById('search_data_label2').innerHTML='N/A';
				document.getElementById('search_result_tables2').innerHTML='<tr><td colspan="9"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
				document.getElementById("show_more_btn_search_result2").style.display='none';
				
			}
		}
		
		get_total_search_results2(0);

	
	</script>
	
</div>