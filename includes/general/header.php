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
	ob_start();
	session_start();
	if(isset($_SESSION['student_id']) && isset($_SESSION['dob']))
	{
		unset($_SESSION['student_id']);
		unset($_SESSION['dob']);
	}
	require("../includes/db_connection.php"); 
	require("../includes/function.php"); 
	try
	{
		$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)==0)
		{
			echo 'System not ready';
			die();
		}
		//echo '<script>console.log("'.$result[0][1].'-ttt");</script>';
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
		
		
		//deleting search transaction
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_result_check_transaction order by nr_rechtr_date desc, nr_rechtr_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		for($i=0;$i<count($re_trx);$i++)
		{
			if($i>$trx)
			{
				$re_date=$re_trx[$i][7];
				$re_time=$re_trx[$i][8];
				$stmt = $conn->prepare("delete from nr_result_check_transaction where nr_rechtr_date='$re_date' and nr_rechtr_time='$re_time' ");
				$stmt->execute();
			}
		}
		
		//deleting print transaction
		$trx=50000;
		$stmt = $conn->prepare("select * from nr_transcript_print_reference order by nr_trprre_date desc, nr_trprre_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		for($i=0;$i<count($re_trx);$i++)
		{
			if($i>$trx)
			{
				$re_date=$re_trx[$i][7];
				$re_time=$re_trx[$i][8];
				$stmt = $conn->prepare("delete from nr_transcript_print_reference where nr_trprre_date='$re_date' and nr_trprre_time='$re_time' ");
				$stmt->execute();
			}
		}
	}
	catch(PDOException $e)
	{
		echo 'System not ready';
		die();
	}
	catch(Exception $e)
	{
		echo 'System not ready';
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
		<link rel="shortcut icon" href="../images/system/<?php echo $logo; ?>">
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="../css/w3.css">
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/welcome_video.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../js/main.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			n_c=1;
			function check_online()
			{
				//console.log('clicked');
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
						
					if (this.readyState == 4 && this.status == 200) {
						if(this.responseText.trim()=='Ok')
						{
							if(n_c==0) //checking network
							{
								n_c=1;
								document.getElementById('valid_msg').style.display='block';
								document.getElementById('v_msg').innerHTML='Network connected.';
								setTimeout(function(){ document.getElementById('valid_msg').style.display='none'; }, 2000);	
					
							}
						}
						
					}
					if (this.readyState == 4 && (this.status == 403 || this.status == 404 || this.status == 0)) {
						//network error
						n_c=0;
						document.getElementById('invalid_msg').style.display='block';
						document.getElementById('i_msg').innerHTML='Network disconnected (Please Wait.. trying to reconnect in 5s)';
						setTimeout(function(){ document.getElementById('invalid_msg').style.display='none'; }, 2000);	
					}
					
				};
				xmlhttp.open("GET", "../includes/general/check_online.php?online_check=yes", true);
				xmlhttp.send();
			}
			setInterval(check_online, 5000);
		</script>
		
	</head>
	
	<body class="w3-black">
		<!-- Notification messages -->
		<div id="rs_blank" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Please fill up the fields properly.
		</div>
		
		<div id="rs_not_found" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! No data available.
		</div>
		
		<div id="rs_server_failed" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! Internal server error occurred.
		</div>
		
		<div id="rs_system_failed" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! System error occurred.
		</div>
		
		<div id="rs_loading" title="Fetching result, please wait.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;width:100%;height:100%;background:black;opacity:0.6;top:0;left:0;position:fixed;z-index:9999999999999;padding-top:170px;">
			<p style="font-size:15px;font-weight:bold;">Please wait while fetching result..</p>
			<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
		</div>
		
		<div id="y_loading" title="Sending message, please wait.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;width:100%;height:100%;background:black;opacity:0.6;top:0;left:0;position:fixed;z-index:9999999999999;padding-top:170px;">
			<p style="font-size:15px;font-weight:bold;">Please wait while sending message..</p>
			<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
		</div>
		
		
		<div id="sub_no_change" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> No changes made.
		</div>
		
		<div id="sub_invalid" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Please check your email.
		</div>
		
		<div id="sub_failed" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! Failed to made the changes.
		</div>
		
		<div id="sub_change_done" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Subscription email changed successfully.
		</div>
		
		<div id="y_sent" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999999999999;display:none;">
			<i class="fa fa-bell-o"></i> Your message sent successfully.
		</div>
		
		<div id="invalid_msg" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:999999999999999999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="i_msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		
		<div id="valid_msg" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:999999999999999999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="v_msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		
		<div class="w3-content w3-white" style="max-width:1450px;">
		
		