
<?php
	
	$enable=0;
	if(isset($_REQUEST['forget_password2']) && isset($_REQUEST['moderator_email']))
	{
		$email=trim($_REQUEST['moderator_email']);
		$stmt = $conn->prepare("select * from nr_admin where nr_admin_email=:email and nr_admin_type='Moderator' ");
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==1)
		{
			if($result[0][8]=='Active')
			{
				//Creating forget password link and sending to user
				$ip_server = $_SERVER['SERVER_ADDR']; //root link 
				$token=get_link();
				$link=$ip_server.'/moderator_admin/forget_password.php?token='.$token;
				$d=get_current_date();
				$t=get_current_time();
				$moderator_id=$result[0][0];
				$sa_name=$result[0][1];
				
				//clearing previous links and otps
				$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:sa_id");
				$stmt->bindParam(':sa_id', $moderator_id);
				$stmt->execute();
				
				//Inserting new OTPs
				$stmt = $conn->prepare("insert into nr_admin_link_token values(:sa_id,'$token','Forget Password','$d','$t','Active') ");
				$stmt->bindParam(':sa_id', $moderator_id);
				$stmt->execute();
				
				//sending password recovery link to user
				$msg="Dear ".$sa_name.", Your Password Recovery Link is: <a href='https://".$link."' target='_blank'>".$link."</a>";
				$message = '<html><body>';
				$message .= '<h1>Password Recovery Link from - '.$title.'</h1><p>  </p>';
				$message .= '<p><b>Message Details:</b></p>';
				$message .= '<p>'.$msg.'</p></body></html>';
				
				
				sent_mail($email,$title.' - Password Recovery Link',$message,$title,$contact_email);
				
				$_SESSION['sa_success']='Password recovery link sent to your email address.';
			}
			else
			{
				$_SESSION['sa_error']='Sorry! this ID is inactive.';
				$enable=1;
			}
		}
		else
		{
			$_SESSION['sa_error']='Sorry! email not found.';
			$enable=1;
		}
		
		
	}
	if(isset($_REQUEST['forget_password']) or $enable==1)
	{
?>

		
<div class="w3-container" style="padding:80px 0px 30px 0px;min-height:500px;">
	<div class="w3-container w3-card-4 w3-animate-zoom w3-light-gray w3-round-large" style="max-width:450px;margin: 0 auto;">
	
		<div class="w3-container" style="margin:0px;padding:0px;">

			<div class="w3-container"><br>
				<h2  style="margin-bottom:0px;font-family: 'Comic Sans MS', cursive, sans-serif;" class="w3-xlarge w3-bold w3-center" >Recover Your Password</h2>
			</div>
			<form style="margin-top:0px;" class="w3-container w3-margin-bottom" action="index.php" method="post">				
				<div class="w3-section w3-border w3-round-large w3-padding">
				  <label><b>Email</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" placeholder="Enter Email" autocomplete="off" name="moderator_email" required>
				  
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
					<div class="w3-col" style="width:50%;padding: 0px 10px 0px 0px;">
						<a href="index.php" class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large"><i class="fa fa-sign-in"></i> Sign In</a>
						
					</div>
					<div class="w3-col" style="width:50%;padding: 0px 0px 0px 10px;">
						<button class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large" type="submit" name="forget_password2"><i class="fa fa-send"></i> Submit</button>
					</div>
				  </div>
				</div>
			</form>
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
		</div>
	</div>
</div>
		
		
		
		
		


<?php	
	}
	else
	{
?>
<div class="w3-container" style="padding:30px 0px 30px 0px;min-height:500px;">
	<div class="w3-container w3-card-4 w3-animate-zoom w3-light-gray w3-round-large" style="max-width:450px;margin: 0 auto;">
	
		<div class="w3-container" style="margin:0px;padding:0px;">

			<div class="w3-container"><br>
				<h2  style="margin-bottom:0px;font-family: 'Comic Sans MS', cursive, sans-serif;" class="w3-xlarge w3-bold w3-center" >Moderator Login</h2>
			</div>

			<form style="margin-top:0px;" class="w3-container w3-margin-bottom" action="login_exec.php" method="post">
				
				<div id="invalid_msg" style="display:none;" class="w3-section w3-padding w3-center w3-bold w3-text-red">
					
				</div>
				
							
				<div class="w3-section w3-border w3-round-large w3-padding">
				  <label><b>Email</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" placeholder="Enter Email" autocomplete="off" name="moderator_email" value="<?php if(isset($_COOKIE["moderator_email"])) { echo $_COOKIE["moderator_email"]; } ?>" required>
				  <label><b>Password</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" placeholder="Enter Password" autocomplete="off" name="moderator_password" value="<?php if(isset($_COOKIE["moderator_password"])) { echo $_COOKIE["moderator_password"]; } ?>" required>
				  
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
				  
				  <button class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large" type="submit" name="sign_in"><i class="fa fa-sign-in"></i> Sign In</button>
				</div>
				
				<div class="w3-row w3-margin-bottom">
					<div class="w3-col" style="width:50%;">
						<input class="w3-check" type="checkbox" name="re_moderator" <?php if(isset($_COOKIE["moderator_login"])) { ?> checked <?php } ?>> Remember me	
					</div>
					<div class="w3-col" style="width:50%;padding: 8px 0px 0px 0px;">
						<a href="index.php?forget_password=true" class="w3-decoration-null w3-text-blue w3-right">Forget My Password</a>
					</div>
				</div>
			</form>
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
		</div>
	</div>
</div>
	<?php } 
	if(isset($_SESSION['error']))
	{
		echo "<script>
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('msg').innerHTML='".$_SESSION['error']."';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			</script>";
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['sa_error']))
	{
		echo "<script>
				document.getElementById('invalid_msg').style.display='block';
				document.getElementById('msg').innerHTML='".$_SESSION['sa_error']."';
				setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);
			</script>";
		unset($_SESSION['sa_error']);
	}
	if(isset($_SESSION['sa_success']))
	{
		echo "<script>
				document.getElementById('valid_msg').style.display='block';
				document.getElementById('v_msg').innerHTML='".$_SESSION['sa_success']."';
				setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);
			</script>";
		unset($_SESSION['sa_success']);
	}
	
?>