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
<!-- Left Column -->
<div class="w3-third w3-margin-top">
	<div class="w3-white w3-text-grey w3-card-4  w3-border w3-border-black w3-round-large" style="height:auto;max-height:603px;overflow:auto;">
		
		<div class="w3-bar w3-black w3-card w3-padding">
			<a href="https://<?php echo $web; ?>" class="w3-bar-item" style="padding: 8px 5px;">
				<image src="../images/system/logo.png" alt="NEUB LOGO" class="w3-image" style="width:100%;max-width:30px;">
			</a>
			<a href="index.php" class="w3-bar-item w3-xlarge w3-decoration-null" style="padding: 8px 3px;"><?php echo $title; ?></a>
			
		</div>
		
		
		<div class="w3-bar-block w3-text-black" style="height: 493px;margin: 20px 25px;">
			<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;"><i class="fa fa-folder-open-o"></i> Menu</p>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-teal w3-round-large w3-border-teal w3-bottombar w3-leftbar"><i class="fa fa-dashboard"></i> Dashboard</a>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-teal w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-search"></i> Search Result</a>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-teal w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-edit"></i> Edit Profile</a>
			<a href="log_out.php?log_out=yes" class="w3-bar-item w3-bold w3-decoration-null w3-hover-teal w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-sign-out"></i> Sign Out</a>
		</div>
		
		
		
		
	</div>
</div>