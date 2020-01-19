
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
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" class="s_id" type="number" style="margin: 0px;padding:10px;width:235px;" autocomplete="off">
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth (DD-MM-YYYY)" class="dob" type="text" style="margin: 0px;padding:10px;width:235px;" autocomplete="off">
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
		<div class="w3-container w3-round-large w3-hide-medium w3-hide-large " style="width: 350px;padding:0px;margin-top:-90px;height:auto;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 62px; font-size:20px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" type="number" class="s_id" style="margin: 5px 0px;padding:10px;width:235px;" autocomplete="off"/>
			</br>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth (DD-MM-YYYY)" class="dob" type="text" style="margin: 5px 0px 20px 0px;padding:10px;width:235px;" autocomplete="off"/>
			</br>
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
		
		
	</div>
</header>