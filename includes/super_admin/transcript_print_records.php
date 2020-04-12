<?php
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>
<i onclick="page12_topFunction()" id="page12_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

			
			

<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Program: 
	<select onchange="reload_dashboard12()" id="program_id12" style="max-width:150px;">
		
	</select>
	
</p>
<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
	
	<i class="fa fa-folder-open-o"></i> Department: 
	<select onchange="reload_dept12()" id="dept_id12" style="max-width:150px;">
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


<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:280px;"><i class="fa fa-server"></i> Transcript Records</p>

<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
	<span>
		Sort By: 
		<select id="search_result_sort12" onchange="get_total_search_results12(0)" type="w3-input w3-round-large">
			
		</select>
	</span>
</p>

<div class="w3-clear"></div>
	
	
<p class="w3-margin-0 w3-padding-0 w3-medium">Total Data: <span class="w3-text-red" id="search_data_label12"></span></p>		
<table style="width:100%;margin:0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
	<tr class="w3-teal w3-bold">
		<td style="width:7%;" valign="top" class="w3-padding-small">S.L. No</td>
		<td style="width:15%;" valign="top" class="w3-padding-small">Ref. No.</td>
		<td style="width:15%;" valign="top" class="w3-padding-small">Printed By</td>
		<td style="width:35%;" valign="top" class="w3-padding-small">Name</td>
		<td style="width:9%;" valign="top" class="w3-padding-small">Date</td>
		<td style="width:9%;" valign="top" class="w3-padding-small">Time</td>
		<td style="width:10%;" valign="top" class="w3-padding-small">Action</td>
	</tr>
	<tbody class="w3-container w3-margin-0 w3-padding-0" id="search_result_tables12">
	
	
	</tbody>
	<tr id="search_results_loading12" >
		
	</tr>
</table>
<p id="show_more_btn_search_result12" onclick="get_total_search_results12(1)" class="w3-center w3-margin-0" style="display:none;"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>





<script>
	function reload_dept12()
	{
		var dept_id=document.getElementById('dept_id12').value;
		var load_program = new XMLHttpRequest();
		load_program.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('program_id12').innerHTML=this.responseText;
				reload_dashboard12();
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById('program_id12').innerHTML='<option value="-1">All</option>';
		
			}
		};
				
		load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
		load_program.send();
		
	}
	reload_dept12();

	function reload_dashboard12()
	{
				

	}

	//Get the button
	var page12_btn = document.getElementById("page12_btn");
	var page12=document.getElementById('page12');
	// When the user scrolls down 20px from the top of the document, show the button
	page12.onscroll = function() {page12_scrollFunction()};

	function page12_scrollFunction() {
	  if (page12.scrollTop > 20) {
		page12_btn.style.display = "block";
	  } else {
		page12_btn.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function page12_topFunction() {
	  page12.scrollTop = 0;
	}

</script>



