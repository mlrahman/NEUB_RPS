<!-- 
Jan 18, 2020
Developed By:
------------- 
Mir Lutfur Rahman
Lecturer
Department of Computer Science & Engineering
North East University Bangladesh
Website: https://mlrahman.github.io
Email: mlrahman@neub.edu.bd
       mirlutfur.rahman@gmail.com
-->
<?php

	ob_start();
	session_start();
	require("../includes/db_connection.php"); 
	require("../includes/function.php"); 
	require("../includes/faculty/logged_out_auth.php"); 

	//*********************************************check for two factor
	
	
	
	try
	{
			
		$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			echo 'System not ready';
			die();
		}
		$title=$result[0][2];
		$caption=$result[0][3];
		$address=$result[0][4];
		$telephone=$result[0][5];
		$email=$result[0][6];
		$mobile=$result[0][7];
		$web=$result[0][8];
		$contact_email=$result[0][9];//for sending message from contact us form
		$map=$result[0][10];
		//logo and video is always fixed in name 
	}
	catch(PDOException $e)
	{
		die();
	}
	catch(Exception $e)
	{
		die();
	}

?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#"  lang="en-gb">
	<head>
		<base href="#"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="North,East,University,Bangladesh,Sylhet,Result,NEUB,Portal" />
		<meta name="description" content="<?php echo $title; ?>" />
		<meta name="generator" content="<?php echo $title; ?>"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../images/system/logo.png">
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="../css/w3.css">
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/welcome_video.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../js/main.js"></script>
		
		
	</head>
	<body class="w3-black">
		<div id="welcome_msg" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
	
	
		<?php
			if(isset($_SESSION['done']))
			{
				echo "<script>
						document.getElementById('welcome_msg').style.display='block';
						document.getElementById('msg').innerHTML='".$_SESSION['done']."';
						setTimeout(function(){ document.getElementById('welcome_msg').style.display='none'; }, 2000);
					</script>";
				unset($_SESSION['done']);
			}
			
			
			session_write_close();
		?>
	
		
		
		<div class="w3-content" style="max-width:1400px;">
			<!-- The Grid -->
			<div class="w3-row-padding w3-white">
				
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
				
				<!-- Right Column -->
				<div class="w3-twothird w3-margin-top">
					<div class="w3-container w3-card w3-white w3-margin-bottom w3-border w3-border-black w3-round-large" style="height:603px;overflow:auto;padding:0px;">
						<div class="w3-bar w3-black w3-card w3-padding">
							<p id="page_title" class="w3-xlarge" style="margin:8px;"><i class="fa fa-dashboard"></i> Dashboard</p>
						</div>
						
						
						
						
						
						
						
					</div>
				</div>
				
			</div>
			
			
			<!-- Footer -->
			<div class="w3-container w3-center">
				<p class="w3-cursor w3-hide-medium w3-hide-small w3-large w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
				<p class="w3-cursor w3-hide-large w3-hide-small w3-medium w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
				<p class="w3-cursor w3-hide-medium w3-hide-large w3-small w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
			</div>
			
			
		</div>
		
		
	</body>
</html>		
		
		