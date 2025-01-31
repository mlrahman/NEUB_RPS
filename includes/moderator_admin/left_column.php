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
<!-- Left Column -->
<div class="w3-third w3-margin-top">
	<div class="w3-white w3-text-grey w3-card-4  w3-border w3-border-black w3-round-large" style="height:auto;max-height:603px;min-height:603px;overflow:auto;">
		
		<div class="w3-bar w3-black w3-card w3-padding">
			<a href="https://<?php echo $web; ?>" class="w3-bar-item" target="_blank" style="padding: 8px 5px;">
				<image src="../images/system/<?php echo $logo; ?>" alt="NEUB LOGO" class="w3-image" style="width:100%;max-width:30px;">
			</a>
			<a href="sa_index.php" class="w3-bar-item w3-xlarge w3-decoration-null" style="padding: 8px 3px;"><?php echo $title; ?></a>
			
		</div>
		
		<!-- moderator ID info -->
		<?php
			$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:moderator_id and nr_admin_email=:moderator_email and nr_admin_status='Active' and nr_admin_type='Moderator' ");
			$stmt->bindParam(':moderator_id', $_SESSION['moderator_id']);
			$stmt->bindParam(':moderator_email', $_SESSION['moderator_email']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=1)
				die();
			
			$photo=$result[0][5];
			$gender=$result[0][11];
			$designation=$result[0][7];
			
		?>
		<div class="w3-container w3-row w3-border w3-round-large w3-leftbar w3-rightbar" style="height: auto;margin: 20px 25px;padding: 10px 10px;">
			<p class="w3-align-left w3-text-black w3-margin-0">Welcome, </p>
			<div class="w3-col s3">
				<?php if($photo=="" && $gender=="Male"){ ?>
					<img src="../images/system/male_profile.png" id="moderator_profile_image" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } else if($photo==""){ ?>
					<img src="../images/system/female_profile.png" id="moderator_profile_image" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } else { ?>
					<img src="../images/moderator/<?php echo $photo; ?>" id="moderator_profile_image" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } ?>
			</div>
			<div class="w3-col s8">
				<p class="w3-align-left w3-text-black">
					<strong><?php echo $_SESSION['moderator_name']; ?></strong>
					</br><?php echo $designation; ?>
				</p>
			</div>
		</div>
		
		<div class="w3-bar-block w3-text-black" style="height: 326px;overflow:auto;margin: 20px 25px;">
			<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar w3-white" style="margin:0px 0px 15px 0px;position: -webkit-sticky;   position: sticky;  top: 0; z-index:99999;"><i class="fa fa-folder-open-o"></i> Menu</p>
			<a onclick="get_page(1)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-cursor"><i class="fa fa-dashboard"></i> Dashboard</a>
			<a onclick="get_page(8)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-users"></i> Students</a>
			<a onclick="get_page(9)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-database"></i> Results</a>
			
			<a onclick="get_page(3)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-edit"></i> Edit Profile</a>
			<a href="log_out.php?log_out=yes" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-sign-out"></i> Sign Out</a>
		</div>
		<script>
			function get_page(a)
			{
				if(a==1)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-dashboard"></i> <?php echo $_SESSION["moderator_type"]; ?> Dashboard';
					document.getElementById('page1').style.display='block';
					
					document.getElementById('page3').style.display='none';
					document.getElementById('page8').style.display='none';
					document.getElementById('page9').style.display='none';
				}
				else if(a==3)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-edit"></i> Edit Profile';
					document.getElementById('page1').style.display='none';
					document.getElementById('page8').style.display='none';
					document.getElementById('page9').style.display='none';
					
					document.getElementById('page3').style.display='block';
				}
				else if(a==8)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-users"></i> Students';
					document.getElementById('page1').style.display='none';
					document.getElementById('page8').style.display='block';
					document.getElementById('page9').style.display='none';
					
					document.getElementById('page3').style.display='none';
				}
				else if(a==9)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-database"></i> Results';
					document.getElementById('page1').style.display='none';
					document.getElementById('page8').style.display='none';
					document.getElementById('page9').style.display='block';
					
					document.getElementById('page3').style.display='none';
				}
			}
		</script>
		
		
		
	</div>

</div>