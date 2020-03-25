
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
			<p id="page_title" class="w3-xlarge" style="margin:8px;"><i class="fa fa-dashboard"></i> Faculty Dashboard</p>
		</div>
		
		<div class="w3-container" style="height:530px;overflow:auto;padding:0px;margin:0px;">
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