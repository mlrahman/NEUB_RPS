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
				document.getElementById("search_results_loading").innerHTML='<td colspan="8"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
				
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
						document.getElementById("search_results_loading").innerHTML = '<td colspan="8"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i></p></td>';
					}
				};
				
				var search_results_from=page2;
				page2=page2+5;
				
				search_results.open("GET", "../includes/faculty/get_search_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&search_results_from="+search_results_from+"&program_id2="+prog_id+"&sort="+r_sort, true);
				search_results.send();
			}
			else
			{
				document.getElementById('search_data_label').innerHTML='N/A';
				document.getElementById('search_result_tables').innerHTML='<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
				document.getElementById("show_more_btn_search_result").style.display='none';
				
			}
		}
		
		get_total2_search_results(0);

			
	</script>


</div>