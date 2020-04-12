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
	require("../includes/db_connection.php"); 
	require("../includes/function.php"); 
	require("../includes/faculty/logged_in_auth.php"); 
	try
	{
			
		$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
		$stmt->execute();
		$result = $stmt->fetchAll();
		//echo '<script>console.log("'.$result[0][1].'-ttt");</script>';
		if(count($result)==0)
		{
			echo 'System not ready';
			die();
		}
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
		
		
		//deleting login transaction
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_faculty_login_transaction order by nr_falotr_date desc, nr_falotr_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		for($i=0;$i<$sz;$i++)
		{
			if($i>$trx)
			{
				$fa_date=$re_trx[$i][7];
				$fa_time=$re_trx[$i][8];
				$stmt = $conn->prepare("delete from nr_faculty_login_transaction where nr_falotr_date='$fa_date' and nr_falotr_time='$fa_time' ");
				$stmt->execute();
			}
		}
		
		
		//deleting search transaction
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction order by nr_rechtr_date desc, nr_rechtr_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		for($i=0;$i<$sz;$i++)
		{
			if($i>$trx)
			{
				$re_date=$re_trx[$i][7];
				$re_time=$re_trx[$i][8];
				$stmt = $conn->prepare("delete from nr_faculty_result_check_transaction where nr_rechtr_date='$re_date' and nr_rechtr_time='$re_time' ");
				$stmt->execute();
			}
		}
		
		//deleting print transaction
		$trx=50000;
		$stmt = $conn->prepare("select * from nr_transcript_print_reference order by nr_trprre_date desc, nr_trprre_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		for($i=0;$i<$sz;$i++)
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
		die();
	}
	catch(Exception $e)
	{
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		
		
	</head>
	<body class="w3-black">
		<div id="invalid_msg" class="w3-container w3-animate-top w3-center w3-red w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		<div id="valid_msg" class="w3-container w3-animate-top w3-center w3-green w3-padding w3-large" style="width:100%;top:0;left:0;position:fixed;z-index:9999;display:none;">
			<i class="fa fa-bell-o"></i> <p id="v_msg" class="w3-margin-0 w3-padding-0" style="display: inline;"></p>
		</div>
		<div class="w3-content w3-white" style="max-width:2000px;">
		