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

	try
	{
		ob_start();
		session_start();
		require("../includes/db_connection.php"); 
		require("../includes/function.php"); 
		require("../includes/faculty/logged_out_auth.php"); 

			
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
	
		
		<div id="two_factor" class="w3-modal">
			<!--two factor window will be here -->
			<div class=" w3-modal-content w3-round-large w3-animate-bottom w3-card-4 w3-leftbar w3-rightbar w3-bottombar w3-topbar w3-border-white">
				<header class="w3-container w3-black w3-bottombar w3-border-teal w3-round-top-large"> 
					<p class="w3-xxlarge" style="margin:5px 0px;">Two Factor Authentication</p>
				</header>
				<div class="w3-container w3-row w3-round-bottom-large w3-padding w3-border w3-border-teal" style="height:100%;">
					<form style="margin: 0 auto;" class="w3-container w3-margin-bottom" action="f_header.php" method="post">
						<div class="w3-section w3-padding w3-center w3-bold w3-text-red">
							*We have sent you an OTP to your email. Please insert the OTP to pass the two factor authentication.<font class="w3-text-blue"> Three times wrong OTP submission will temporarily block your ID.</font> 
						</div>
						<div class="w3-section w3-border w3-round-large w3-padding w3-text-black w3-justify">
							<label><b>Your OTP</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" placeholder="Enter your OTP" autocomplete="off" name="faculty_otp" required>
							<?php 
								//spam Check 
								$aaa=rand(1,20);
								$bbb=rand(1,20);
								$ccc=$aaa+$bbb;
							?>
							<label><b>Captcha</b></label>
							<div class="w3-row" style="margin:0px;padding:0px;">
								<div class="w3-col" style="width:40%;">
									<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
								</div>
								<div class="w3-col" style="margin-left:2%;width:58%;">
									<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha4" autocomplete="off" required>
								</div>
							</div>
							<div class="w3-row" style="margin:0px;padding:0px;">
								<div class="w3-col" style="width:33.33%;padding: 0px 10px 0px 0px;">
									<button class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large" type="submit" name="two_check"><i class="fa fa-sign-in"></i> Submit</button>
								</div>
					
								<div class="w3-col" style="width:33.33%;padding: 0px 10px 0px 10px;">
									<a href="#" class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large"><i class="fa fa-send"></i> Resend OTP</a>
								</div>
								
								<div class="w3-col" style="width:33.33%;padding: 0px 0px 0px 10px;">
									<a href="log_out.php?log_out=yes" class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large"><i class="fa fa-sign-out"></i> Sign Out</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			//Captcha Validation for create new password
			var reservation_captcha4 = document.getElementById("captcha4");
			var sol4=<?php echo $ccc; ?>;
			function reservation_captcha_val4(){
			  
			  //console.log(reservation_captcha.value);
			  //console.log(sol);
			  if(reservation_captcha4.value != sol4) {
				reservation_captcha4.setCustomValidity("Please Enter Valid Answer.");
			  } else {
				reservation_captcha4.setCustomValidity('');
			  }
			}
			reservation_captcha4.onchange=reservation_captcha_val4;
		</script>
		<?php
			if($_SESSION['faculty_two_factor_status']==1) //two factor enabled
			{
				if($_SESSION['faculty_two_factor_check']=='N') //two factor not passed yet
				{
					echo '
					<script>
						document.getElementById("two_factor").style.display="block";
					</script>
					';
					die();
				}
				
			}
			if(isset($_SESSION['done']))
			{
				echo "<script>
						document.getElementById('welcome_msg').style.display='block';
						document.getElementById('msg').innerHTML='".$_SESSION['done']."';
						setTimeout(function(){ document.getElementById('welcome_msg').style.display='none'; }, 2000);
					</script>";
				unset($_SESSION['done']);
			}
		?>
		