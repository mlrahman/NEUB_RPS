
<header class="w3-display-container w3-grayscale-min w3-dark-gray w3-hover-teal" style="height:450px;overflow:hidden;">
	
	<img src="../images/system/video_alt.jpg" class="w3-image w3-grayscale w3-opacity-min" alt="Video Alternate" style="height:100%;width:100%;"/>
	
	<video autoplay muted loop id="myVideo" class="w3-grayscale">
		<source src="../images/system/welcome.mp4" type="video/mp4"><img src="../images/system/video_alt.jpg" class="w3-image w3-grayscale w3-opacity-min" alt="Video Alternate" style="height:100%;width:100%;"/>
	</video>
	
	<div class="w3-display-bottomleft w3-container w3-padding-16 w3-black">
		<?php echo $caption; ?>
	</div>
	
	<div class="w3-display-middle w3-center w3-cursor">
		<div class="w3-container w3-round-large w3-hide-small" style="width: 700px;padding:0px;margin-top:-90px;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 55px; font-size:22px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" id="s_id1" type="number" style="margin: 0px;padding:10px;width:235px;" autocomplete="off" />
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth (YYYY-MM-DD)" id="dob1" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" style="margin: 0px;padding:10px;width:235px;" autocomplete="off" />
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
		<div class="w3-container w3-round-large w3-hide-medium w3-hide-large " style="width: 350px;padding:0px;margin-top:-90px;height:auto;">
			<p class="w3-left-align w3-bold" style="padding: 0px; margin:0px 0px 5px 62px; font-size:20px;">Search Your Result:</p>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Student ID" type="number" id="s_id2" style="margin: 5px 0px;padding:10px;width:235px;" autocomplete="off" />
			</br>
			<input class="w3-border w3-border-black w3-round-large" placeholder=" Date of Birth (YYYY-MM-DD)" id="dob2" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" style="margin: 5px 0px 20px 0px;padding:10px;width:235px;" autocomplete="off" />
			</br>
			<a class=" w3-black w3-round-large w3-hover-teal" href="#" onclick="get_result()" style="margin: 0px;padding:12px;text-decoration: none;">
				<i class="fa fa-search"></i> Get Result
			</a>
		</div>
	</div>
	
</header>
<script>

	function show_result_div(y)
	{
		var z=document.getElementById(y+'_icon').className;
		//console.log(z);
		if(z=="fa fa-plus-square")
		{
			document.getElementById(y+'_icon').classList.remove("fa-plus-square");
			document.getElementById(y+'_icon').classList.add("fa-minus-square");
			document.getElementById(y).style.display='block';
		}
		else if(z=="fa fa-minus-square")
		{
			document.getElementById(y+'_icon').classList.remove("fa-minus-square");
			document.getElementById(y+'_icon').classList.add("fa-plus-square");
			document.getElementById(y).style.display='none';
			
		}
	}

	function ValidateEmail(x)  
	{  
		var atposition=x.indexOf("@");  
		var dotposition=x.lastIndexOf(".");  
		if (atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length){  
			return false;  
		}
		else return true; 		
	}
	
	function enable_subscribe(flag)
	{
		if(flag==1)
		{
			document.getElementById('edit_subscription').style.display='block';
		}
		else if(flag==0)
		{
			document.getElementById('edit_subscription').style.display='none';
		}
		else if(flag==2)
		{
			var p_sub_email=document.getElementById('sub_email').value;
			var s_id=document.getElementById('sub_s_id').value;
			var dob=document.getElementById('sub_dob').value;
			var sub_email=document.getElementById('subscription_email').value.trim();
			if(p_sub_email==sub_email)
			{
				document.getElementById('sub_no_change').style.display='block';
				setTimeout(function(){ document.getElementById('sub_no_change').style.display='none'; }, 1500);
			}
			else if(ValidateEmail(sub_email)==false)
			{
				document.getElementById('subscription_email').value=p_sub_email;
				document.getElementById('sub_invalid').style.display='block';
				setTimeout(function(){ document.getElementById('sub_invalid').style.display='none'; }, 1500);
			
			}
			else
			{
				document.getElementById('sub_loading').style.display='block';
				var xmlhttp2 = new XMLHttpRequest();
				xmlhttp2.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById('sub_loading').style.display='none';
						//console.log(this.responseText);
						if(this.responseText.trim()=="not_done")
						{
							document.getElementById('sub_failed').style.display='block';
							setTimeout(function(){ document.getElementById('sub_failed').style.display='none'; }, 1500);
					
						}
						else if(this.responseText.trim()=="done")
						{
							//console.log('kjhg');
							document.getElementById('sub_email').value=sub_email;
							document.getElementById('sub_change_done').style.display='block';
							setTimeout(function(){ document.getElementById('sub_change_done').style.display='none'; }, 1500);
					
						}
					}
					else if(this.status==403 || this.status==404)
					{
						document.getElementById('sub_loading').style.display='none';
						document.getElementById('rs_server_failed').style.display='block';
						setTimeout(function(){ document.getElementById('rs_server_failed').style.display='none'; }, 1500);
					}
				};
				xmlhttp2.open("GET", "set_sub_email.php?s_id=" + s_id + "&dob=" + dob +"&email=" + sub_email, true);
				xmlhttp2.send();
			}
		}
	}
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
					if(this.responseText.trim()=="not_found")
					{
						document.getElementById("rs_not_found").style.display="block";
						setTimeout(function(){ document.getElementById("rs_not_found").style.display="none"; }, 1500);
					}
					else if(this.responseText.trim()=="error")
					{
						document.getElementById("rs_system_failed").style.display="block";
						setTimeout(function(){ document.getElementById("rs_system_failed").style.display="none"; }, 1500);
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
	
	function search_result_button(id)
	{
		for(var i=1;i<=5;i++)
		{
			if(i!=parseInt(id))
			{
				document.getElementById('se_re_div_'+i).style.display='none';
				//console.log(document.getElementById('se_re_btn_'+i).classList);
				if(document.getElementById('se_re_btn_'+i).classList.contains("w3-teal"))
					document.getElementById('se_re_btn_'+i).classList.remove("w3-teal");
				if(document.getElementById('se_re_btn_'+i).classList.contains("w3-border-teal"))
					document.getElementById('se_re_btn_'+i).classList.remove("w3-border-teal");
				document.getElementById('se_re_btn_'+i).classList.add("w3-white");
			}
		}
		document.getElementById('se_re_btn_'+id).classList.add("w3-teal");
		document.getElementById('se_re_btn_'+id).classList.add("w3-border-teal");
		if(document.getElementById('se_re_btn_'+id).classList.contains("w3-white"))
			document.getElementById('se_re_btn_'+id).classList.remove("w3-white");
		document.getElementById('se_re_div_'+id).style.display='block';
	}
</script>