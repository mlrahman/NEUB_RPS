<<<<<<< HEAD
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
	<div class="w3-white w3-text-grey w3-card-4  w3-border w3-border-black w3-round-large" style="height:auto;max-height:603px;min-height:603px;overflow:auto;">
		
		<div class="w3-bar w3-black w3-card w3-padding">
			<a href="https://<?php echo $web; ?>" class="w3-bar-item" target="_blank" style="padding: 8px 5px;">
				<image src="../images/system/logo.png" alt="NEUB LOGO" class="w3-image" style="width:100%;max-width:30px;">
			</a>
			<a href="f_index.php" class="w3-bar-item w3-xlarge w3-decoration-null" style="padding: 8px 3px;"><?php echo $title; ?></a>
			
		</div>
		
		<!-- Faculty ID info -->
		<?php
			$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_id=:faculty_id and nr_faculty_email=:faculty_email and nr_faculty_status='Active' ");
			$stmt->bindParam(':faculty_id', $_SESSION['faculty_id']);
			$stmt->bindParam(':faculty_email', $_SESSION['faculty_email']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=1)
				die();
			
			$photo=$result[0][10];
			$gender=$result[0][13];
			$designation=$result[0][2];
			
			$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:faculty_dept_id and nr_dept_status='Active' ");
			$stmt->bindParam(':faculty_dept_id', $_SESSION['faculty_dept_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=1)
				die();
			
			$department=$result[0][1];
		?>
		<div class="w3-container w3-row w3-border w3-round-large w3-leftbar w3-rightbar" style="height: auto;margin: 20px 25px;padding: 10px 10px;">
			<p class="w3-align-left w3-text-black w3-margin-0">Welcome, </p>
			<div class="w3-col s3">
				<?php if($photo=="" && $gender=="Male"){ ?>
					<img src="../images/system/male_profile.png" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } else if($photo==""){ ?>
					<img src="../images/system/female_profile.png" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } else { ?>
					<img src="../images/faculty/<?php echo $photo; ?>" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } ?>
			</div>
			<div class="w3-col s8">
				<p class="w3-align-left w3-text-black">
					<strong><?php echo $_SESSION['faculty_name']; ?></strong>
					</br><?php echo $designation; ?>
					</br>Department of <?php echo $department; ?>
				</p>
			</div>
		</div>
		
		<div class="w3-bar-block w3-text-black" style="height: auto;margin: 20px 25px;">
			<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;"><i class="fa fa-folder-open-o"></i> Menu</p>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar"><i class="fa fa-dashboard"></i> Dashboard</a>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-search"></i> Search Result</a>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-edit"></i> Edit Profile</a>
			<a href="log_out.php?log_out=yes" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-sign-out"></i> Sign Out</a>
		</div>
		
		
		
		
	</div>
=======
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
	<div class="w3-white w3-text-grey w3-card-4  w3-border w3-border-black w3-round-large" style="height:auto;max-height:603px;min-height:603px;overflow:auto;">
		
		<div class="w3-bar w3-black w3-card w3-padding">
			<a href="https://<?php echo $web; ?>" class="w3-bar-item" style="padding: 8px 5px;">
				<image src="../images/system/logo.png" alt="NEUB LOGO" class="w3-image" style="width:100%;max-width:30px;">
			</a>
			<a href="f_index.php" class="w3-bar-item w3-xlarge w3-decoration-null" style="padding: 8px 3px;"><?php echo $title; ?></a>
			
		</div>
		
		<!-- Faculty ID info -->
		<div class="w3-container w3-row w3-border w3-round-large w3-leftbar w3-rightbar" style="height: auto;margin: 20px 25px;padding: 10px 10px;">
			<p class="w3-align-left w3-text-black w3-margin-0">Welcome, </p>
			<div class="w3-col s3">
				<img src="../images/system/male_profile.png" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
			</div>
			<div class="w3-col s8">
				<p class="w3-align-left w3-text-black">
					<strong>Noushad Sojib</strong>
					</br>Assistant Professor
					</br>Department of Computer Science & Engineering
				</p>
			</div>
		</div>
		
		<div class="w3-bar-block w3-text-black" style="height: auto;margin: 20px 25px;">
			<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;"><i class="fa fa-folder-open-o"></i> Menu</p>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar"><i class="fa fa-dashboard"></i> Dashboard</a>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-search"></i> Search Result</a>
			<a href="#" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-edit"></i> Edit Profile</a>
			<a href="log_out.php?log_out=yes" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-sign-out"></i> Sign Out</a>
		</div>
		
		
		
		
	</div>
>>>>>>> 3cbad3b731067af9672d2b64dd4ddf93db2f86d7
</div>