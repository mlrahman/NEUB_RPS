<!--Header-->
<?php 
	if(isset($_REQUEST['token']))
	{

		require("../includes/faculty/header.php"); 
		require("../includes/faculty/navbar.php"); 
		
		$faculty_otp=trim($_REQUEST['token']);
		
		$stmt = $conn->prepare("select * from nr_faculty_link_token where nr_falito_token=:f_tok and nr_falito_status='Active' ");
		$stmt->bindParam(':f_tok', $faculty_otp);
		$stmt->execute();
		$result=$stmt->fetchAll();
		if(count($result)==0)
		{
			$_SESSION['error']='Invalid link no permission for access.';
			header("location: index.php");
			die();
		}
		else
		{
			
			$faculty_id=$result[0][0];
			$link_date=$result[0][3];
			//clearing previous links and otps
			$stmt = $conn->prepare("delete from nr_faculty_link_token where nr_faculty_id=:f_id");
			$stmt->bindParam(':f_id', $faculty_id);
			$stmt->execute();
			//faculty info
			$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_status='Active' and nr_faculty_id=:f_id");
			$stmt->bindParam(':f_id', $faculty_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				$_SESSION['error']='ID inactive no permission for access.';
				header("location: index.php");
				die();
			}
			$faculty_name=$result[0][1];
			$faculty_email=$result[0][8];
		}

?>
<div class="w3-container" style="padding:30px 0px 30px 0px;min-height:500px;">
	<div class="w3-container w3-card-4 w3-animate-zoom w3-light-gray w3-round-large" style="max-width:450px;margin: 0 auto;">
	
		<div class="w3-container" style="margin:0px;padding:0px;">

			<div class="w3-container"><br>
				<h2  style="margin-bottom:0px;font-family: 'Comic Sans MS', cursive, sans-serif;" class="w3-xlarge w3-bold w3-center" >Set New Password</h2>
			</div>
			<form style="margin-top:0px;" class="w3-container w3-margin-bottom" action="forget_password.php" method="post">
					
				<div id="invalid_msg" style="display:none;" class="w3-section w3-padding w3-center w3-bold w3-text-red">
					
				</div>
				
							
				<div class="w3-section w3-border w3-round-large w3-padding">
				  <label><b>Name</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_name; ?>" disabled>
				  
				  <label><b>Email</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $faculty_email; ?>" disabled>
				  
				  <label><b>New Password</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" placeholder="Enter New Password" autocomplete="off" name="faculty_password" required>
				  <label><b>Confirm New Password</b></label>
				  <input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" placeholder="Enter Confirm New Password" autocomplete="off" name="faculty_cpassword" required>
				  
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
						<a href="forget_password.php?back_sign_in=yes" class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large"><i class="fa fa-sign-in"></i> Sign In</a>
						
					</div>
					<div class="w3-col" style="width:50%;padding: 0px 0px 0px 10px;">
						<button class="w3-button w3-block w3-black w3-hover-teal w3-margin-top w3-padding w3-round-large" type="submit" name="set_password"><i class="fa fa-send"></i> Submit</button>
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
		require("../includes/faculty/footer.php"); 
	}
	else
	{
		header("location: index.php");
		die();
	}

?>