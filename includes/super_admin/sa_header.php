<?php

	try
	{
		ob_start();
		session_start();
		require("../includes/db_connection.php"); 
		require("../includes/function.php"); 
		require("../includes/super_admin/logged_out_auth.php"); 

			
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
		$logo=$result[0][13];
		$video_alt=$result[0][14];
		$video=$result[0][15];
		
		$print_html_style='<style>.page-header, .page-header-space {height: 90px;} .page-footer, .page-footer-space { height: 50px; margin-top:10px; } .page-footer { position: fixed; bottom: 0; width: 700px; background:white; } .page-header { position: fixed; top: 0mm; width: 700px; margin:0px; background:white; } .page { page-break-inside: avoid; } @page { margin: 6mm 15mm 6mm 15mm; } @media print { thead {display: table-header-group;}  tfoot {display: table-footer-group;} body {margin: 0;} } </style>';
				
		$print_html_body='<div class="page-header" style="text-align: center;"><div style="border-bottom: 3px solid black;"><div style="height:75px;"><div style="width:65px;padding:0px;margin:0px;float:left;"><img src="../images/system/'.$logo.'" alt="NEUB LOGO" style="width:68px;height:70px;"></div><div style="width:630px;float:left;padding:0px;margin:0px;"><p style="padding: 0px;margin:10px 0px 5px 0px;font-size:22px;font-weight:bold;margin-left:8px;">NORTH EAST UNIVERSITY BANGLADESH (NEUB)</p><p style="margin:0px;padding:0px;font-size: 19px;font-weight:bold;text-align:center;">SYLHET, BANGLADESH.</p></div></div></div></div><div class="page-footer"><div style="border-top:3px solid black;margin: 0px;padding:0px;width:700px;text-align:center;"><p style="margin:0px;padding:0px;font-size:12px;">Address: '.$address.'</p><p style="margin:0px;padding:0px;font-size:12px;">Phone: '.$telephone.', Fax: 0821-710223, Mobile: '.$mobile.', E-mail: '.$email.'</p><p style="margin:0px;padding:0px;font-size:12px;">Website: '.$web.'</p></div></div><table><thead><tr><td><div class="page-header-space"></div></td></tr></thead><tbody><tr><td>';
		
		$print_html_footer='</td></tr></tbody><tfoot><tr><td><div class="page-footer-space"></div></td></tr></tfoot></table></div>';
		
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
		<link rel="shortcut icon" id="site_logo_link" href="../images/system/<?php echo $logo; ?>">
		<title id="site_title_link"><?php echo $title; ?></title>
		<link rel="stylesheet" href="../css/w3.css">
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/welcome_video.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../js/main.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			n_c=1;
			function check_login()
			{
				//console.log('clicked');
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
						
					if (this.readyState == 4 && this.status == 200) {
						if(this.responseText.trim()=='Ok')
						{
							//session available
							
							if(n_c==0) //checking network
							{
								n_c=1;
								document.getElementById('valid_msg').style.display='block';
								document.getElementById('v_msg').innerHTML='Network connected.';
								setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);	
					
							}
						}
						else
						{
							//session destroyed
							window.location.replace("index.php");
						}
					}
					if (this.readyState == 4 && (this.status == 403 || this.status == 404 || this.status == 0)) {
						//network error
						n_c=0;
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Network disconnected (Please Wait.. trying to reconnect in 8s)';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);	
					}
					
				};
				xmlhttp.open("GET", "../includes/super_admin/check_login.php?admin_id="+<?php echo $_SESSION['admin_id']; ?>+"&login_check=yes", true);
				xmlhttp.send();
			}
			setInterval(check_login, 8000);
		</script>
		
	</head>
	<body class="w3-black">
		<div id="welcome_msg" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:999999999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		
		<div id="invalid_msg" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:999999999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="i_msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		
		<div id="valid_msg" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:999999999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="v_msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		
		<div id="resend_otp_msg" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:999999999;display:none;">
			<i class="fa fa-bell-o"></i> <p class="w3-margin-0 w3-padding-0" style="display: inline;"> We have sent you an email with a new OTP.</p>
		</div>
	
		
		<div id="two_factor" class="w3-modal">
			<!--two factor window will be here -->
			<div class=" w3-modal-content w3-round-large w3-animate-bottom w3-card-4 w3-leftbar w3-rightbar w3-bottombar w3-topbar w3-border-white" style="margin-top:50px;">
				<header class="w3-container w3-black w3-bottombar w3-border-teal w3-round-top-large"> 
					<p class="w3-xxlarge" style="margin:5px 0px;">Two Factor Authentication</p>
				</header>
				<div class="w3-container w3-row w3-round-bottom-large w3-padding w3-border w3-border-teal" style="height:100%;">
					<form style="margin: 0 auto;" class="w3-container w3-margin-bottom" action="sa_index.php" method="post">
						<div class="w3-section w3-padding w3-center w3-bold w3-text-red">
							*We have sent you an OTP to your email. Please insert the OTP to pass the two factor authentication.<font class="w3-text-blue"> Five times wrong OTP submission will temporarily block your ID.</font> 
						</div>
						<div class="w3-section w3-border w3-round-large w3-padding w3-text-black w3-justify">
							<label><b>Your OTP</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" placeholder="Enter your OTP" autocomplete="off" name="admin_otp" required>
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
									<a href="sa_index.php?resend_otp=yes" class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large"><i class="fa fa-send"></i> Resend OTP</a>
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
			//checking otp
			if(isset($_REQUEST['two_check']))
			{
				$admin_id=$_SESSION['admin_id'];
				$admin_otp=trim($_REQUEST['admin_otp']);
				$stmt = $conn->prepare("select * from nr_admin_link_token where nr_admin_id=:sa_id and nr_suadlito_token=:sa_tok ");
				$stmt->bindParam(':sa_id', $admin_id);
				$stmt->bindParam(':sa_tok', $admin_otp);
				$stmt->execute();
				$result=$stmt->fetchAll();
				if(count($result)==0)
				{
					$_SESSION['error']='Sorry! you have entered an invalid OTP ('.(5-($_SESSION['otp_count2']+1)).')';
					$_SESSION['otp_count2']=$_SESSION['otp_count2']+1;
					if($_SESSION['otp_count2']>=5)
					{
						$stmt = $conn->prepare("update nr_admin set nr_admin_status='Inactive' where nr_admin_id=:sa_id");
						$stmt->bindParam(':sa_id', $admin_id);
						$stmt->execute();
						$_SESSION['error']='Your ID temporarily blocked for wrong OTPs.';
						header("location: log_out.php?log_out=yes");
						die();
					}
					
				}
				else
				{
					if($result[0][5]=='Active')
					{
						//two factor_passed
						$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:sa_id");
						$stmt->bindParam(':sa_id', $admin_id);
						$stmt->execute();
						
						$_SESSION['admin_two_factor_check']='Y';
						$_SESSION['done']="Two factor authentication successful.";
						header("location: sa_index.php");
						die();
					}
					else
					{
						$_SESSION['error']='Sorry! you have entered an invalid OTP ('.(5-($_SESSION['otp_count2']+1)).')';
						$_SESSION['otp_count2']=$_SESSION['otp_count2']+1;
						if($_SESSION['otp_count2']>=5)
						{
							$stmt = $conn->prepare("update nr_admin set nr_admin_status='Inactive' where nr_admin_id=:sa_id");
							$stmt->bindParam(':sa_id', $admin_id);
							$stmt->execute();
							$_SESSION['error']='Your ID temporarily blocked for wrong OTPs.';
							header("location: log_out.php?log_out=yes");
							die();
						}
					}
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
			if(isset($_SESSION['error']))
			{
				echo "<script>
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='".$_SESSION['error']."';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
					</script>";
				unset($_SESSION['error']);
			}
			
			if(isset($_REQUEST['resend_otp']))
			{
				$admin_id=$_SESSION['admin_id'];
				$sa_name=$_SESSION['admin_name'];
				//clearing previous OTPs & Forget My Password links
				$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:sa_id");
				$stmt->bindParam(':sa_id', $admin_id);
				$stmt->execute();
				
				$iotp=get_otp();
				$d=get_current_date();
				$t=get_current_time();
				//Inserting new OTPs
				$stmt = $conn->prepare("insert into nr_admin_link_token values(:sa_id,'$iotp','Two Factor','$d','$t','Active') ");
				$stmt->bindParam(':sa_id', $admin_id);
				$stmt->execute();
				
				//sending new OTP to user
				$msg="Dear ".$sa_name.", Your Two Factor Authentication OTP is: ".$iotp;
				$message = '<html><body>';
				$message .= '<h1>Two Factor Authentication OTP From - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($_SESSION['admin_email'],$title.' - OTP for Two Factor Authentication',$message,$title,$contact_email);
				
				$_SESSION['otp_sent']='yes';
				header("location: sa_index.php");
				die();
				
			}
			if(isset($_SESSION['otp_sent']))
			{
				echo "<script>
						document.getElementById('resend_otp_msg').style.display='block';
						setTimeout(function(){ document.getElementById('resend_otp_msg').style.display='none'; }, 2000);
					</script>";
				unset($_SESSION['otp_sent']);
			}
			
		
			if($_SESSION['admin_two_factor_status']==1) //two factor enabled
			{
				if($_SESSION['admin_two_factor_check']=='N') //two factor not passed yet
				{
					echo '
					<script>
						document.getElementById("two_factor").style.display="block";
					</script>
					';
					die();
				}
				
			}
			
			
		?>