
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

<!-- Right Column -->
<div class="w3-twothird w3-margin-top">

	<!-- Dashboard -->
	<div class="w3-container w3-card w3-white w3-margin-bottom w3-border w3-border-black w3-round-large" style="height:603px;padding:0px;" id="admin_dashboard">
	
		<div class="w3-bar w3-black w3-card w3-padding" style="border-radius:7px 7px 0px 0px;">
			<p class="w3-xlarge"  id="page_title" style="margin:8px;"></p>
		</div>
		<!-- page1 starts here -->
		<div id="page1" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			<i onclick="page1_topFunction()" id="page1_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

			
			
			
			<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
				<i class="fa fa-folder-open-o"></i> Program: 
				<select onchange="reload_dashboard()" id="program_id" style="max-width:150px;">
					
				</select>
				
			</p>
			<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
				
				<i class="fa fa-folder-open-o"></i> Department: 
				<select onchange="reload_dept()" id="dept_id" style="max-width:150px;">
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
			
			
			<!-- Dashboard basic box-->
			<div class="w3-row-padding w3-margin-bottom w3-margin-top">
				<?php include("../includes/super_admin/dashboard_basic.php"); ?>
			</div>
			
			<!-- Students Grpah -->
			<div class="w3-container w3-margin-bottom">
				<?php include("../includes/super_admin/student_graph.php"); ?>
			</div>
			
			<!-- CGPA Grpah -->
			<div class="w3-container w3-margin-bottom">
				<?php include("../includes/super_admin/cgpa_graph.php"); ?>
			</div>
			
			<!-- Students Recent Results -->
			<div class="w3-container w3-margin-bottom">
				<?php include("../includes/super_admin/recent_results.php"); ?>
			</div>
			
			
			<!-- Go to top button-->
			<script>
				function reload_dept()
				{
					var dept_id=document.getElementById('dept_id').value;
					var load_program = new XMLHttpRequest();
					load_program.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById('program_id').innerHTML=this.responseText;
							reload_dashboard();
						}
						if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
							document.getElementById('program_id').innerHTML='<option value="-1">All</option>';
					
						}
					};
							
					load_program.open("GET", "../includes/super_admin/get_programs.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&dept_id="+dept_id, true);
					load_program.send();
					
				}
				reload_dept();
				
				function reload_dashboard()
				{
					load_total_students();
					load_graduates();
					load_top_cgpa();
					load_dropouts();
					get_student_graph();
					get_student_cgpa();
					get_total_recent_results(0);
				}
				
				//Get the button
				var page1_btn = document.getElementById("page1_btn");
				var page1=document.getElementById('page1');
				// When the user scrolls down 20px from the top of the document, show the button
				page1.onscroll = function() {page1_scrollFunction()};

				function page1_scrollFunction() {
				  if (page1.scrollTop > 20) {
					page1_btn.style.display = "block";
				  } else {
					page1_btn.style.display = "none";
				  }
				}

				// When the user clicks on the button, scroll to the top of the document
				function page1_topFunction() {
				  page1.scrollTop = 0;
				}
			</script>
			
			
		</div>
		
		<!-- page2 starts here -->
		<div id="page2" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/departments.php"); ?>
		</div>
		
		<!-- page3 starts here -->
		<div id="page3" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/programs.php"); ?>
		</div>
		<!-- page4 starts here -->
		<div id="page4" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/course_list.php"); ?>
		</div>
		<!-- page5 starts here -->
		<div id="page5" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/course_offer_list.php"); ?>
		</div>
		<!-- page6 starts here -->
		<div id="page6" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			
			
		</div>
		<!-- page7 starts here -->
		<div id="page7" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/faculties.php"); ?>
		</div>
		<!-- page8 starts here -->
		<div id="page8" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			
			
		</div>
		<!-- page9 starts here -->
		<div id="page9" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			
			
		</div>
		<!-- page10 starts here -->
		<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
		<div id="page10" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/system_components.php"); ?>
		</div>
		<?php } ?>
		<!-- page11 starts here -->
		<div id="page11" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/result_search_records.php"); ?>
		</div>
		<!-- page12 starts here -->
		<div id="page12" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/transcript_print_records.php"); ?>
		</div>
		<!-- page13 starts here -->
		<div id="page13" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/super_admin/user_login_records.php"); ?>
		</div>
		<!-- Page 14 starts here -->
		<div id="page14" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
		
		</div>
		<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
		<!-- page15 starts here -->
		<div id="page15" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			
			
		</div>
		<?php } ?>
		
		<script>
			//initially calling page1
			get_page(1);
		</script>
	</div>

</div>