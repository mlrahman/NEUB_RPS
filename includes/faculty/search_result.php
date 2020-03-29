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

<div class="w3-container w3-margin-bottom">
	
	<div class="w3-container" style="margin: 12px 0px 25px 0px;padding:0px;position:relative;">
	
		<div class="w3-container w3-topbar w3-bottombar w3-round-large w3-rightbar w3-leftbar w3-padding" style="margin:0 auto; width:50%;min-width:300px;">
			<i class="fa fa-search w3-text-teal"></i> 
			<input type="text" id="search_text" onkeyup="get_suggestions()" class="w3-input w3-border-teal" style="width:92%;min-width:230px;display:inline;" placeholder="Enter Student Name or ID for Search">
		</div>
		<div class="w3-container w3-margin-0 w3-padding-0" id="suggestion_box" style="display:none;width:50%;min-width:300px;margin:0 auto;">
			<div class="w3-container w3-bottombar w3-leftbar w3-white w3-padding-0 w3-margin-0" style="width:50%;min-width:300px;height:auto;max-height:190px;overflow-y:scroll;border-radius: 0px 0px 7px 7px;position:absolute;z-index:999;">
				<table style="width:100%;margin:0px;" class="w3-medium w3-round">
					<!--
					<tr class="w3-black w3-bold">
						<td style="width:30%;" valign="top" class="w3-padding-small">Student ID</td>
						<td style="width:48%;" valign="top" class="w3-padding-small">Name</td>
						<td style="width:22%;" valign="top" class="w3-padding-small">Action</td>
					</tr>
					-->
					<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_suggestion_tables">
		
		
					</tbody>
					<tr id="search_suggestion_loading" >
						
					</tr>
				</table>
			</div>
		</div>
		<script>
			function get_suggestions()
			{
				close_search_box();
				var search_text=document.getElementById('search_text').value.trim();
				if(search_text=="")
				{
					document.getElementById('search_suggestion_loading').innerHTML='';
					document.getElementById('search_suggestion_tables').innerHTML='';
					document.getElementById('suggestion_box').style.display='none';
				}
				else
				{
					var prog_id=document.getElementById('program_id2').value;
					document.getElementById('suggestion_box').style.display='block';
					document.getElementById('search_suggestion_loading').innerHTML='<td colspan="3"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
					var search_suggestion = new XMLHttpRequest();
					search_suggestion.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							var res=this.responseText.trim();
							if(res=="")
							{
								document.getElementById("search_suggestion_tables").innerHTML ='';
								document.getElementById("search_suggestion_loading").innerHTML = '<td colspan="3"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="No data found"> No data available</i></p></td>';
							}
							else
							{
								document.getElementById("search_suggestion_loading").innerHTML = '';
								document.getElementById("search_suggestion_tables").innerHTML = res;
								
								
								
							}
							
						}
						if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
							document.getElementById("search_suggestion_loading").innerHTML = '<td colspan="3"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
						}
					};
							
					search_suggestion.open("GET", "../includes/faculty/get_search_suggestion.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&program_id2="+prog_id+"&search_text="+search_text, true);
					search_suggestion.send();
				}
			}
		
		</script>
	</div>
	
	<div id="search_window" class="w3-container w3-topbar w3-leftbar w3-rightbar w3-bottombar w3-round-large w3-margin-bottom" style="display:none;">
		<span onclick="close_search_box()" title="Close window" class="w3-button w3-right w3-large w3-red w3-hover-teal w3-round" style="padding:2px 10px;margin: 15px 0px 0px 0px;"><i class="fa fa-close"></i></span>
		<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:10px 0px 15px 0px;width:230px;"><i class="fa fa-user"></i> Student Details</p>
		<div id="search_window_details" class="w3-container w3-margin-0 w3-padding-0">
		
		</div>
	</div>
	<script>
		function view_result(s_id)
		{
			document.getElementById('search_text').value='';
			get_suggestions();
			document.getElementById('search_window').style.display='block';
			var page2=document.getElementById('page2');
			page2.scrollTop = 20;
			document.getElementById('search_window_details').innerHTML='<p class="w3-center" style="margin: 50px 0px 50px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
			var search_window_result = new XMLHttpRequest();
			search_window_result.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					document.getElementById('search_window_details').innerHTML=this.responseText;
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById('search_window_details').innerHTML='<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Network Error Occurred"><i class="fa fa-warning"></i> Network Error Occurred</p>';
			
				}
			};
					
			search_window_result.open("GET", "../includes/faculty/get_search_window_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&s_id="+s_id, true);
			search_window_result.send();
			
			
		}
		function close_search_box()
		{
			document.getElementById('search_window_details').innerHTML='';
			document.getElementById('search_window').style.display='none';
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
		function faculty_print_result(s_id,f_id,f_d_id)
		{
			window.open('../includes/faculty/faculty_result_print.php?s_id='+s_id+'&faculty_id='+f_id+'&faculty_dept_id='+f_d_id);
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
	</script>
	
	
	<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:280px;"><i class="fa fa-server"></i> All Student Results</p>
	
	<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
		Sort By: 
		<select id="search_result_sort" onchange="get_total2_search_results(0)" type="w3-input w3-round-large">
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
	</p>
	
	<div class="w3-clear"></div>
	
	<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label"></span></p>		
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
		<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables">
		
		
		</tbody>
		<tr id="search_results_loading" >
			
		</tr>
	</table>
	<p id="show_more_btn_search_result" onclick="get_total2_search_results(1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>
	

	<script>
		var page2=0,total2;
		function get_total2_search_results(x)
		{
			//return 0;
			document.getElementById("search_results_loading").innerHTML='<td colspan="9"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
				
			var prog_id=document.getElementById('program_id2').value;
			var r_sort=document.getElementById('search_result_sort').value;
			
			var total2_results = new XMLHttpRequest();
			total2_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					total2=parseInt(this.responseText.trim());
					get_search_results(x);
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					total2=0;
					get_search_results(x);
				}
			};
			document.getElementById('search_data_label').innerHTML='<i class="fa fa-refresh w3-spin"></i>';
					
			total2_results.open("GET", "../includes/faculty/get_total2_search_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&program_id2="+prog_id, true);
			total2_results.send();
		}
		
		function get_search_results(x)
		{
			if(x==0)
			{
				page2=0;
				document.getElementById('search_result_tables').innerHTML='';
			}
			if(total2!=0)
			{
				var prog_id=document.getElementById('program_id2').value;
				var r_sort=document.getElementById('search_result_sort').value;
			
			
				document.getElementById("show_more_btn_search_result").style.display='none';
				
				var search_results = new XMLHttpRequest();
				search_results.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("search_results_loading").innerHTML='';
						document.getElementById('search_result_tables').innerHTML=document.getElementById('search_result_tables').innerHTML+this.responseText;
						document.getElementById('search_data_label').innerHTML=total2;
					
						if(total2>page2)
						{
							document.getElementById("show_more_btn_search_result").style.display='block';
						}
						
					}
					if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
						document.getElementById('search_data_label').innerHTML='N/A';
						document.getElementById("search_results_loading").innerHTML = '<td colspan="9"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occurred!!"> Network Error</i></p></td>';
					}
				};
				
				var search_results_from=page2;
				page2=page2+5;
				
				search_results.open("GET", "../includes/faculty/get_search_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&search_results_from="+search_results_from+"&program_id2="+prog_id+"&sort="+r_sort, true);
				search_results.send();
			}
			else
			{
				document.getElementById("search_results_loading").innerHTML='';
				document.getElementById('search_data_label').innerHTML='N/A';
				document.getElementById('search_result_tables').innerHTML='<tr><td colspan="9"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
				document.getElementById("show_more_btn_search_result").style.display='none';
				
			}
		}
		
		get_total2_search_results(0);

			
	</script>


</div>