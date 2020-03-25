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

<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:270px;"><i class="fa fa-bar-chart-o"></i> Recent Results</p>


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
<p id="show_more_btn" onclick="get_recent_results()" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>
<?php
	$stmt = $conn->prepare("SELECT count(nr_result_id) FROM nr_result a,nr_course b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id");
	$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
	$stmt->execute();
	$stud_result=$stmt->fetchAll();
?>
<script>
	var page=0;
	<?php 
		if(count($stud_result)>0)
			echo 'var total='.$stud_result[0][0].';';
		else
			echo 'var total=0;';
	?>
	
	function get_recent_results()
	{
		document.getElementById("show_more_btn").style.display='none';
		document.getElementById("recent_results_loading").innerHTML='<td colspan="8"><p class="w3-center" style="margin: 10px 0px 10px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></td>';
		
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
				document.getElementById("recent_results_loading").innerHTML = '<td colspan="8"><p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i></p></td>';
			}
		};
		
		var recent_results_from=page;
		page=page+5;
		
		recent_results.open("GET", "../includes/faculty/get_recent_results.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&recent_results_from="+recent_results_from, true);
		recent_results.send();
	}
	if(total!=0)
		get_recent_results();
	else
		document.getElementById('recent_result_tables').innerHTML='<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';

</script>