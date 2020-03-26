
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
			<p class="w3-xlarge"  id="page_title" style="margin:8px;"><i class="fa fa-dashboard"></i> Faculty Dashboard</p>
			
		</div>
		
		<div class="w3-container" style="height:530px;overflow:auto;padding:0px;margin:0px;">
			
			<p class="w3-right w3-margin-right w3-text-teal w3-bold">
				
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
			
			
			
			
		</div>
		
		
	</div>

</div>