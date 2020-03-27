
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
<!-- Right Column -->
<div class="w3-twothird w3-margin-top">

	<!-- Dashboard -->
	<div class="w3-container w3-card w3-white w3-margin-bottom w3-border w3-border-black w3-round-large" style="height:603px;padding:0px;" id="faculty_dashboard">
	
		<div class="w3-bar w3-black w3-card w3-padding" style="border-radius:7px 7px 0px 0px;">
			<p class="w3-xlarge"  id="page_title" style="margin:8px;"></p>
		</div>
		<!-- page1 starts here -->
		<div id="page1" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			
			<i onclick="page1_topFunction()" id="page1_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

			
			<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;">
				
				<i class="fa fa-folder-open-o"></i> Program: 
				<select onchange="reload_dashboard()" id="program_id">
					<option value="-1">All</option>
					<?php
						$stmt = $conn->prepare("SELECT * FROM nr_program where nr_dept_id=:dept_id and nr_prog_status='Active' order by nr_prog_id asc");
						$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)>0)
						{
							for($k=0;$k<count($stud_result);$k++)
							{
								$prog_id=$stud_result[$k][0];
								$prog_title=$stud_result[$k][1];
								echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
							}
						}
					?>
				</select>
				<script>
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
				</script>
			</p>
			
			<!-- Dashboard basic box-->
			<div class="w3-row-padding w3-margin-bottom w3-margin-top">
				<?php include("../includes/faculty/dashboard_basic.php"); ?>
			</div>
			
			<!-- Students Grpah -->
			<div class="w3-container w3-margin-bottom">
				<?php include("../includes/faculty/student_graph.php"); ?>
			</div>
			
			<!-- CGPA Grpah -->
			<div class="w3-container w3-margin-bottom">
				<?php include("../includes/faculty/cgpa_graph.php"); ?>
			</div>
			
			<!-- Students Recent Results -->
			<div class="w3-container w3-margin-bottom">
				<?php include("../includes/faculty/recent_results.php"); ?>
			</div>
			
			
			<!-- Go to top button-->
			<script>
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
		<!-- Page 2 starts here -->
		<div id="page2" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
		
		</div>
		<!-- Page 3 starts here -->
		<div id="page3" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			<?php include("../includes/faculty/edit_profile.php"); ?>
		</div>
		<!-- Page 3 ends here -->
		
		<script>
			get_page(1);
		</script>
	</div>

</div>