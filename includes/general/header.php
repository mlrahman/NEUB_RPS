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
		//logo and video is always fixed in name 
		
		//deleting search transaction
		$trx=1000;
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
		<link rel="shortcut icon" href="../images/system/logo.png">
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="../css/w3.css">
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/welcome_video.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../js/main.js"></script>
		
		
	</head>
	<body class="w3-black">
		<!-- Notification messages -->
		<div id="rs_blank" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Please fill up the fields properly.
		</div>
		
		<div id="rs_not_found" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! No data available.
		</div>
		
		<div id="rs_server_failed" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! Internal server error occurred.
		</div>
		
		<div id="rs_system_failed" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! System error occurred.
		</div>
		
		<div id="rs_loading" title="Fetching result, please wait.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;width:100%;height:100%;background:black;opacity:0.6;top:0;left:0;position:fixed;z-index:9999;padding-top:170px;">
			<p style="font-size:15px;font-weight:bold;">Please wait while fetching result..</p>
			<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
		</div>
		
		<div id="y_loading" title="Sending message, please wait.." class="w3-container w3-animate-top w3-text-white w3-center" style="display:none;width:100%;height:100%;background:black;opacity:0.6;top:0;left:0;position:fixed;z-index:9999;padding-top:170px;">
			<p style="font-size:15px;font-weight:bold;">Please wait while sending message..</p>
			<i class="fa fa-spinner w3-spin" style="font-size:180px;"></i>
		</div>
		
		
		<div id="sub_no_change" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> No changes made.
		</div>
		
		<div id="sub_invalid" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Please check your email.
		</div>
		
		<div id="sub_failed" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Sorry! Failed to made the changes.
		</div>
		
		<div id="sub_change_done" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Subscription email changed successfully.
		</div>
		
		<div id="y_sent" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> Your message sent successfully.
		</div>
		
		<div class="w3-content w3-white" style="max-width:2000px;">
		