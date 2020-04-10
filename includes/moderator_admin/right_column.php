
<?php
	try{
		require("../includes/moderator_admin/logged_out_auth.php");
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
	<div class="w3-container w3-card w3-white w3-margin-bottom w3-border w3-border-black w3-round-large" style="height:603px;padding:0px;" id="moderator_dashboard">
	
		<div class="w3-bar w3-black w3-card w3-padding" style="border-radius:7px 7px 0px 0px;">
			<p class="w3-xlarge"  id="page_title" style="margin:8px;"></p>
		</div>
		<!-- page1 starts here -->
		<div id="page1" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
			
			
		</div>
		
		<!-- Page 3 starts here -->
		<div id="page3" class="w3-container" style="display:none;height:530px;overflow:auto;padding:0px;margin:0px;">
			
		
		</div>
		
		<script>
			//initially calling page1
			get_page(1);
		</script>
	</div>

</div>