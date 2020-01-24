<div class="w3-container" style="padding:40px 0px 20px 0px;min-height:500px;">
	<div class="w3-container w3-card-4 w3-animate-zoom w3-light-gray w3-round-large" style="max-width:450px;margin: 0 auto;">
	
		<div class="w3-container" style="margin:0px;padding:0px;">

			<div class="w3-container"><br>
				<h2  style="margin-bottom:0px;font-family: 'Comic Sans MS', cursive, sans-serif;" class="w3-xlarge w3-bold w3-center" >Super Admin</h2>
			</div>

			<form style="margin-top:0px;" class="w3-container w3-margin-bottom" action="index.php" method="post">
				
				<div id="invalid_msg" style="display:none;" class="w3-section w3-padding w3-center w3-bold w3-text-red">
					Invalid Email or Password
				</div>
				
				<div id="active_msg" style="display:none;" class="w3-section w3-padding w3-center w3-bold w3-text-teal">
					ID Disabled. Please Contact with Developer.
				</div>
				
				<div class="w3-section w3-border w3-round-large w3-padding">
				  <label><b>Email</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="email" placeholder="Enter Email" name="controller_email" value="<?php if(isset($_COOKIE["controller_login"])) { echo $_COOKIE["controller_login"]; } ?>" required>
				  <label><b>Password</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" placeholder="Enter Password" name="controller_password" value="<?php if(isset($_COOKIE["controller_password"])) { echo $_COOKIE["controller_password"]; } ?>" required>
				  
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
						<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="captcha4"  required>
					</div>
				  </div>
				  
				  <button class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large" type="submit" name="sign_in"><i class="fa fa-sign-in"></i> Sign In</button>
				</div>
				
				<div class="w3-container w3-light-grey w3-margin-bottom">
					<input class="w3-check" type="checkbox" name="recontroller" <?php if(isset($_COOKIE["controller_login"])) { ?> checked <?php } ?>> Remember me	
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