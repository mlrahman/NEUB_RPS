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

<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:230px;"><i class="fa fa-server"></i> Recent Results</p>


<table style="width:100%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
	<tr class="w3-teal w3-bold">
		<td style="width:16%;" valign="top" class="w3-padding-small">Semester</td>
		<td style="width:9%;" valign="top" class="w3-padding-small">Student ID</td>
		<td style="width:10%;" valign="top" class="w3-padding-small">Course Code</td>
		<td style="width:29%;" valign="top" class="w3-padding-small">Course Title</td>
		<td style="width:9%;" valign="top" class="w3-padding-small">Credit</td>
		<td style="width:10%;" valign="top" class="w3-padding-small">Grade</td>
		<td style="width:7%;" valign="top" class="w3-padding-small">Grade Point</td>
		<td style="width:10%;" valign="top" class="w3-padding-small">Remarks</td>
	</tr>
	<tbody class="w3-container w3-margin-0 w3-padding-0" id="recent_result_tables">
	
	
	</tbody>
	<tr id="recent_results_loading" >
		
	</tr>
</table>
<p id="show_more_btn" onclick="get_total_recent_results(1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>

<script>
	var page=0,total;
	function get_total_recent_results(x)
	{
		//return 0;
		var prog_id=document.getElementById('program_id').value;
		document.getElementById("recent_results_loading").innerHTML='<td colspan="8"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
			
		var total_results = new XMLHttpRequest();
		total_results.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				total=parseInt(this.responseText.trim());
				get_recent_results(x);
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				total=0;
				get_recent_results(x);
			}
		};
		total_results.open("GET", "../includes/faculty/get_total_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&program_id="+prog_id, true);
		total_results.send();
	}
	
	function get_recent_results(x)
	{
		if(x==0)
		{
			page=0;
			document.getElementById('recent_result_tables').innerHTML='';
		}
		if(total!=0)
		{
			var prog_id=document.getElementById('program_id').value;
		
			document.getElementById("show_more_btn").style.display='none';
			
			var recent_results = new XMLHttpRequest();
			recent_results.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("recent_results_loading").innerHTML='';
					document.getElementById('recent_result_tables').innerHTML=document.getElementById('recent_result_tables').innerHTML+this.responseText;
					
					if(total>page)
					{
						document.getElementById("show_more_btn").style.display='block';
					}
					
				}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById("recent_results_loading").innerHTML = '<td colspan="8"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i></p></td>';
				}
			};
			
			var recent_results_from=page;
			page=page+5;
			
			recent_results.open("GET", "../includes/faculty/get_recent_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&recent_results_from="+recent_results_from+"&program_id="+prog_id, true);
			recent_results.send();
		}
		else
		{
			document.getElementById("recent_results_loading").innerHTML='';
			document.getElementById('recent_result_tables').innerHTML='<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
			document.getElementById("show_more_btn").style.display='none';
			
		}
	}
	
	get_total_recent_results(0);

		
</script>