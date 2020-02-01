			
			<footer class=" w3-center w3-black">
				<div class="w3-container w3-white w3-padding-32">
					<div class="w3-row">
						<p class="w3-hide-medium w3-hide-large"> &nbsp </p>
						<div class="w3-third w3-container w3-mobile w3-left-align">
							<p style="margin:0px 15px;"><b>CONTACT US</b></p>
							<p style="margin:0px 15px;width:50px;" class="w3-bottombar w3-border-teal"> </p>
							<table class="w3-table " style="width:100%;max-width:350px;">
								<tr>
									<td>Address:</td><td><?php echo $address; ?></td>
								</tr>
								<tr>
									<td>Tel:</td><td><?php echo $telephone; ?></td>
								</tr>
								<tr>
									<td>Email:</td><td><a href="mailto:<?php echo $email; ?>" title="<?php echo $title; ?>" target="_blank" class="w3-hover-text-teal w3-decoration-null"><?php echo $email; ?></a></td>
								</tr>
								<tr>
									<td>Mobile:</td><td><?php echo $mobile; ?></td>
								</tr>
								<tr>
									<td>Web:</td><td><a href="https://<?php echo $web; ?>" title="<?php echo $title; ?>" target="_blank" class="w3-hover-text-teal w3-decoration-null"><?php echo $web; ?></a></td>
								</tr>
							</table>
						</div>
						<p class="w3-hide-medium w3-hide-large"> &nbsp </p>
						<div class="w3-third w3-container w3-mobile w3-left-align">
							<p style="margin:0px 15px;"><b>FIND US ON MAP</b></p>
							<p style="margin:0px 15px;width:50px;" class="w3-bottombar w3-border-teal"> </p>
							<div class="w3-container w3-padding-16" style="width:100%;max-width:400px; height:210px;"><div class="gmap_canvas"><iframe id="gmap_canvas" style="height:100%;width:100%;" src="<?php echo $map; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div></div>
						</div>
						<div style="padding: 0px 0px 0px 50px;" class="w3-third w3-container w3-mobile w3-left-align w3-hide-small w3-hide-medium">
							<p style="margin:0px;"><b>CONTACT US</b></p>
							<p style="margin:0px;width:50px;" class="w3-bottombar w3-border-teal"> </p>
							<input class="w3-input w3-animate-input w3-border-teal" placeholder=" Your Name" id="y_name1" type="text" style="width:80%;max-width:100%;margin:10px 0px;" autocomplete="off">
							<input class="w3-input w3-animate-input w3-border-teal" placeholder=" Your Email" id="y_email1" type="text" style="width:80%;max-width:100%;margin:10px 0px;" autocomplete="off">
							<input class="w3-input w3-animate-input w3-border-teal" placeholder=" Your Message" id="y_msg1" type="text" style="width:80%;max-width:100%;margin:10px 0px;" autocomplete="off">
							<button class="w3-button w3-right w3-round w3-black w3-hover-teal" onclick="send_message()"><i class="fa fa-send"> Submit</i></button>
						</div>
						<div style="padding: 0px 0px 0px 30px;" class="w3-third w3-container w3-mobile w3-left-align w3-hide-large">
							<p style="margin:0px;"><b>CONTACT US</b></p>
							<p style="margin:0px;width:50px;" class="w3-bottombar w3-border-teal"> </p>
							<input class="w3-input w3-animate-input w3-border-teal" placeholder=" Your Name" id="y_name2" type="text" style="width:80%;max-width:100%;margin:10px 0px;" autocomplete="off">
							<input class="w3-input w3-animate-input w3-border-teal" placeholder=" Your Email" id="y_email2" type="text" style="width:80%;max-width:100%;margin:10px 0px;" autocomplete="off">
							<input class="w3-input w3-animate-input w3-border-teal" placeholder=" Your Message" id="y_msg2" type="text" style="width:80%;max-width:100%;margin:10px 0px;" autocomplete="off">
							<button class="w3-button w3-right w3-round w3-black w3-hover-teal" onclick="send_message()"><i class="fa fa-send"> Submit</i></button>
						</div>
					</div>
				</div>
				<script>
					
					
					function send_message()
					{
						var y_name1=document.getElementById('y_name1').value.trim();
						var y_email1=document.getElementById('y_email1').value.trim();
						var y_message1=document.getElementById('y_msg1').value.trim();
						var y_name2=document.getElementById('y_name2').value.trim();
						var y_email2=document.getElementById('y_email2').value.trim();
						var y_message2=document.getElementById('y_msg2').value.trim();
						var y_name,y_email,y_message;
						if(y_name2.length>=y_name1.length && y_email2.length>=y_email1.length && y_message2.length>=y_message1.length)
						{
							y_name=y_name2;
							y_email=y_email2;
							y_message=y_message2;
						}
						else
						{
							y_name=y_name1;
							y_email=y_email1;
							y_message=y_message1;
						}
						if(y_name.length==0 || y_email.length==0 || y_message.length==0)
						{
							document.getElementById('rs_blank').style.display='block';
							setTimeout(function(){ document.getElementById('rs_blank').style.display='none'; }, 1500);
						}
						else if(ValidateEmail(y_email)==false)
						{
							document.getElementById('sub_invalid').style.display='block';
							setTimeout(function(){ document.getElementById('sub_invalid').style.display='none'; }, 1500);
						}
						else
						{
							document.getElementById('y_name1').value='';
							document.getElementById('y_email1').value='';
							document.getElementById('y_msg1').value='';
							document.getElementById('y_name2').value='';
							document.getElementById('y_email2').value='';
							document.getElementById('y_msg2').value='';
								
							document.getElementById('y_loading').style.display='block';
							var xmlhttp3 = new XMLHttpRequest();
							xmlhttp3.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById('y_loading').style.display='none';
									console.log(this.responseText.trim());
									if(this.responseText.trim()=="done")
									{
										document.getElementById('y_sent').style.display='block';
										setTimeout(function(){ document.getElementById('y_sent').style.display='none'; }, 1500);
					
									}
									else if(this.responseText.trim()!="done")
									{
										document.getElementById("rs_system_failed").style.display="block";
										setTimeout(function(){ document.getElementById("rs_system_failed").style.display="none"; }, 1500);
					
									}
								}
								else if(this.status==403 || this.status==404)
								{
									document.getElementById('y_loading').style.display='none';
									document.getElementById('rs_server_failed').style.display='block';
									setTimeout(function(){ document.getElementById('rs_server_failed').style.display='none'; }, 1500);
								}
							};
							xmlhttp3.open("GET", "send_message.php?y_name=" + y_name + "&y_email=" + y_email +"&y_message=" + y_message, true);
							xmlhttp3.send();
							
						}
					}
				
				</script>
					
				<p class="w3-cursor w3-hide-medium w3-hide-small w3-large w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
				<p class="w3-cursor w3-hide-large w3-hide-small w3-medium w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
				<p class="w3-cursor w3-hide-medium w3-hide-large w3-small w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
			</footer>
		</div>
	</body>
</html>