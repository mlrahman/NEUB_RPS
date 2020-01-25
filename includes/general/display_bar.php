
<header class="w3-display-container w3-grayscale-min w3-dark-gray w3-hover-teal" style="height:450px;overflow:hidden;">
	<img src="../images/system/video_alt.jpg" class="w3-image w3-grayscale w3-opacity-min" alt="Video Alternate" style="height:100%;width:100%;"/>
	
	<video autoplay muted loop id="myVideo" class="w3-grayscale" >
		<source src="../images/system/welcome.mp4" type="video/mp4"><img src="../images/system/video_alt.jpg" class="w3-image w3-grayscale w3-opacity-min" alt="Video Alternate" style="height:100%;width:100%;"/>
	</video>
	
	<div class="w3-display-bottomleft w3-container w3-padding-16 w3-black">
		<?php echo $caption; ?>
	</div>
	
	<div class="w3-display-middle w3-center w3-cursor">
		<div class="w3-container w3-round-large w3-hide-small" style="width: 700px;padding:0px;margin-top:-90px;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 55px; font-size:22px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" id="s_id1" type="number" style="margin: 0px;padding:10px;width:235px;" autocomplete="off" />
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth" id="dob1" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" style="margin: 0px;padding:10px;width:235px;" autocomplete="off" />
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
		<div class="w3-container w3-round-large w3-hide-medium w3-hide-large " style="width: 350px;padding:0px;margin-top:-90px;height:auto;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 62px; font-size:20px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" type="number" id="s_id2" style="margin: 5px 0px;padding:10px;width:235px;" autocomplete="off" />
			</br>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth" id="dob2" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" style="margin: 5px 0px 20px 0px;padding:10px;width:235px;" autocomplete="off" />
			</br>
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
	</div>
	
</header>
<script>

	
	function get_result()
	{
		var s_id1=document.getElementById('s_id1').value.trim();
		var dob1=document.getElementById('dob1').value.trim();
		var s_id2=document.getElementById('s_id2').value.trim();
		var dob2=document.getElementById('dob2').value.trim();
		var s_id,dob;
		if(s_id2.length>=s_id1.length && dob2.length>=dob1.length)
		{
			s_id=s_id2;
			dob=dob2;
		}
		else
		{
			s_id=s_id1;
			dob=dob1;
		}
		
		if(s_id.length==0 || dob.length==0)
		{
			document.getElementById('rs_blank').style.display='block';
			setTimeout(function(){ document.getElementById('rs_blank').style.display='none'; }, 1500);
		}
		else if(s_id.length!=12 || dob.length!=10)
		{
			document.getElementById('rs_blank').style.display='block';
			setTimeout(function(){ document.getElementById('rs_blank').style.display='none'; }, 1500);
		}
		else
		{
			document.getElementById('s_id1').value='';
			document.getElementById('dob1').value='';
			document.getElementById('s_id2').value='';
			document.getElementById('dob2').value='';
			//date format: YYYY-MM-DD
			document.getElementById('rs_loading').style.display='block';
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('rs_loading').style.display='none';
					if(this.responseText=="not_found")
					{
						document.getElementById("rs_not_found").style.display="block";
						setTimeout(function(){ document.getElementById("rs_not_found").style.display="none"; }, 1500);
					}
					else
					{	
						document.getElementById("result_popup").innerHTML = this.responseText;
						document.getElementById('result_popup').style.display='block';
					}
				}
				else if(this.status==403 || this.status==404)
				{
					document.getElementById('rs_loading').style.display='none';
					document.getElementById('rs_server_failed').style.display='block';
					setTimeout(function(){ document.getElementById('rs_server_failed').style.display='none'; }, 1500);
				}
			};
			xmlhttp.open("GET", "get_result.php?s_id=" + s_id + "&dob=" + dob, true);
			xmlhttp.send();
			
		}
		
	}
</script>