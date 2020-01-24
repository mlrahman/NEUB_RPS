
<header class="w3-display-container w3-grayscale-min w3-dark-gray w3-hover-teal" style="height:450px;overflow:hidden;">
	<img src="../images/system/video_alt.jpg" class="w3-image w3-grayscale w3-opacity-min" alt="Video Alternate" style="height:100%;width:100%;"/>
	
	<video autoplay muted loop id="myVideo" class="w3-grayscale" >
		<source src="../images/system/welcome.mp4" type="video/mp4"><img src="../images/system/video_alt.jpg" class="w3-image w3-grayscale w3-opacity-min" alt="Video Alternate" style="height:100%;width:100%;"/>
	</video>
	
	<div class="w3-display-bottomleft w3-container w3-padding-16 w3-black">
		Permanent Campus
	</div>
	
	<div class="w3-display-middle w3-center w3-cursor">
		<div class="w3-container w3-round-large w3-hide-small" style="width: 700px;padding:0px;margin-top:-90px;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 55px; font-size:22px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" id="s_id1" type="number" style="margin: 0px;padding:10px;width:235px;" autocomplete="off" required />
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth (DD-MM-YYYY)" id="dob1" type="text" style="margin: 0px;padding:10px;width:235px;" autocomplete="off" required />
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
		<div class="w3-container w3-round-large w3-hide-medium w3-hide-large " style="width: 350px;padding:0px;margin-top:-90px;height:auto;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 62px; font-size:20px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" type="number" id="s_id2" style="margin: 5px 0px;padding:10px;width:235px;" autocomplete="off" required />
			</br>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth (DD-MM-YYYY)" id="dob2" type="text" style="margin: 5px 0px 20px 0px;padding:10px;width:235px;" autocomplete="off" required />
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
		var s_id1=document.getElementById('s_id1').value;
		var dob1=document.getElementById('dob1').value;
		var s_id2=document.getElementById('s_id2').value;
		var dob2=document.getElementById('dob2').value;
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
		
	}
</script>