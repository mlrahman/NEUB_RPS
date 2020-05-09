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

			
			<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
				
				<i class="fa fa-folder-open-o"></i> Program: 
				<select onchange="reload_dashboard()" id="program_id" style="max-width:150px;">
					<option value="-1">All</option>
					<?php
						$stmt = $conn->prepare("SELECT * FROM nr_program where nr_dept_id=:dept_id order by nr_prog_id asc");
						$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)>0)
						{
							$sz=count($stud_result);
							for($k=0;$k<$sz;$k++)
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
			
			<!-- Menu -->

			<div class="w3-container w3-left" style="margin:14px 0px 14px 0px;">
				<button onclick="reload_dashboard()" class="w3-button w3-brown w3-round-large w3-hover-teal"><i class="fa fa-refresh"></i> Refresh</button>
			
			</div>
			
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
			
			<i onclick="page2_topFunction()" id="page2_btn" class="fa fa-chevron-circle-up w3-cursor w3-text-black w3-hover-text-teal w3-xxlarge" title="Go to top" style="display:none;bottom: 95px;right:45px;z-index: 99999;position:fixed;"></i>

			<!-- Program for student view -->
			<p id="prog_student" class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;">
				
				<i class="fa fa-folder-open-o"></i> Program: 
				<select onchange="reload_dashboard2()" id="program_id2" style="max-width:150px;">
					<option value="-1">All</option>
					<?php
						$stmt = $conn->prepare("SELECT * FROM nr_program where nr_dept_id=:dept_id order by nr_prog_id asc");
						$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)>0)
						{
							$sz=count($stud_result);
							for($k=0;$k<$sz;$k++)
							{
								$prog_id=$stud_result[$k][0];
								$prog_title=$stud_result[$k][1];
								echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
							}
						}
					?>
				</select>
				<script>
					function reload_dashboard2()
					{
						get_total2_search_results(0);
						close_search_box();
					}
				</script>
			</p>
			
			<!-- Program for course view -->
			<p id="prog_course" class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 0px;z-index: 99999;display:none;">
				
				<i class="fa fa-folder-open-o"></i> Program: 
				<select onchange="reload_dashboard3()" id="program_id3" style="max-width:150px;">
					<option value="-1">All</option>
					<?php
						$stmt = $conn->prepare("SELECT * FROM nr_program where nr_dept_id=:dept_id and nr_prog_status='Active' order by nr_prog_id asc");
						$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)>0)
						{
							$sz=count($stud_result);
							for($k=0;$k<$sz;$k++)
							{
								$prog_id=$stud_result[$k][0];
								$prog_title=$stud_result[$k][1];
								echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
							}
						}
					?>
				</select>
				<script>
					function reload_dashboard3()
					{
						get_total_search_results2(0);
						close_search_box2();
					}
				</script>
			</p>
			
			<p class="w3-right w3-white w3-padding w3-text-teal w3-bold w3-leftbar w3-bottombar" style="position: -webkit-sticky;   position: sticky;  top: 0; margin: 0px 0px 14px 0px;border-radius:0px 0px 0px 7px;z-index: 99999;">
				<i class="fa fa-hand-o-right"></i> View for:
				<select onchange="search_result_view_change()" id="search_view">
					<option value="1">Student</option>
					<option value="2">Course</option>
				</select>
			</p>
			
			<!-- Menu -->

			<div class="w3-container w3-left" style="margin:14px 0px 14px 0px;">
				<button onclick="reload_dashboard3();reload_dashboard2();" class="w3-button w3-brown w3-round-large w3-hover-teal"><i class="fa fa-refresh"></i> Refresh</button>
			
			</div>
			
			<!-- Student view -->			
			<?php include("../includes/faculty/search_result.php"); ?>
			<!-- Course View -->
			<?php include("../includes/faculty/search_result2.php"); ?>
			
			<!-- Go to top button-->
			<script>
				function page2_enable()
				{
						//Get the button
					var page2_btn = document.getElementById("page2_btn");
					var page2=document.getElementById('page2');
					// When the user scrolls down 20px from the top of the document, show the button
					page2.onscroll = function() {page2_scrollFunction()};

					function page2_scrollFunction() {
						//console.log("sad");
						//console.log(page2.scrollTop);
					  if (page2.scrollTop > 20) {
						page2_btn.style.display = "block";
					  } else {
						page2_btn.style.display = "none";
					  }
					}

					// When the user clicks on the button, scroll to the top of the document
					
				}
				function page2_topFunction() {
					var page2=document.getElementById('page2');
					
					page2.scrollTop = 0;
				}
				
				function search_result_view_change()
				{
					var id=document.getElementById('search_view').value;
					id=parseInt(id);
					if(id==1)
					{
						var prog=document.getElementById('program_id3').value;
						document.getElementById('program_id2').value=prog;
						
						document.getElementById('prog_course').style.display='none';
						document.getElementById('prog_student').style.display='block';
						
						reload_dashboard2();
						////
						document.getElementById('search_text2').value='';
						get_total_search_results2(0);
						close_search_box2();
						
						document.getElementById('search_view_2').style.display='none';
					}
					else
					{
						var prog=document.getElementById('program_id2').value;
						document.getElementById('program_id3').value=prog;
						
						document.getElementById('prog_student').style.display='none';
						document.getElementById('prog_course').style.display='block';
						
						reload_dashboard3();
						
						document.getElementById('search_text').value='';
						get_suggestions();
						close_search_box();
						
						document.getElementById('search_view_1').style.display='none';
					}
					document.getElementById('search_view_'+id).style.display='block';
					
				}
				
			</script>
			
			
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