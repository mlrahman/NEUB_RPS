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
	require("../includes/super_admin/logged_in_auth.php"); 
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
		$logo=$result[0][13];
		$video_alt=$result[0][14];
		$video=$result[0][15];
		
		//deleting login transaction
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_admin_login_transaction order by nr_suadlotr_date desc, nr_suadlotr_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$fa_date=$re_trx[$i][7];
					$fa_time=$re_trx[$i][8];
					$stmt = $conn->prepare("delete from nr_admin_login_transaction where nr_suadlotr_date='$fa_date' and nr_suadlotr_time='$fa_time' ");
					$stmt->execute();
				}
			}
		}
		
		//deleting search transaction
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_admin_result_check_transaction order by nr_rechtr_date desc, nr_rechtr_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][7];
					$re_time=$re_trx[$i][8];
					$stmt = $conn->prepare("delete from nr_admin_result_check_transaction where nr_rechtr_date='$re_date' and nr_rechtr_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		
		//clearing delete history
		$trx=5000;
		$stmt = $conn->prepare("select * from nr_delete_history order by nr_deleteh_date desc, nr_deleteh_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_delete_history where nr_deleteh_date='$re_date' and nr_deleteh_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing admin history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_admin_history order by nr_adminh_date desc, nr_adminh_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_admin_history where nr_adminh_date='$re_date' and nr_adminh_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing course history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_course_history order by nr_courseh_date desc, nr_courseh_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_course_history where nr_courseh_date='$re_date' and nr_courseh_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing department history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_department_history order by nr_depth_date desc, nr_depth_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_department_history where nr_depth_date='$re_date' and nr_depth_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing drop history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_drop_history order by nr_droph_date desc, nr_droph_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_drop_history where nr_droph_date='$re_date' and nr_droph_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing faculty history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_faculty_history order by nr_facultyh_date desc, nr_facultyh_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_faculty_history where nr_facultyh_date='$re_date' and nr_facultyh_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		
		//clearing program history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_program_history order by nr_progh_date desc, nr_progh_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_program_history where nr_progh_date='$re_date' and nr_progh_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing result history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_result_history order by nr_resulth_date desc, nr_resulth_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_result_history where nr_resulth_date='$re_date' and nr_resulth_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//clearing student history
		$trx=3000;
		$stmt = $conn->prepare("select * from nr_student_history order by nr_studh_date desc, nr_studh_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
			for($i=0;$i<$sz;$i++)
			{
				if($i>$trx)
				{
					$re_date=$re_trx[$i][2];
					$re_time=$re_trx[$i][3];
					$stmt = $conn->prepare("delete from nr_student_history where nr_studh_date='$re_date' and nr_studh_time='$re_time' ");
					$stmt->execute();
				}
			}
		}
		
		//deleting print transaction
		$trx=50000;
		$stmt = $conn->prepare("select * from nr_transcript_print_reference order by nr_trprre_date desc, nr_trprre_time desc ");
		$stmt->execute();
		$re_trx = $stmt->fetchAll();
		$sz=count($re_trx);
		if($sz>$trx){
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
		<link rel="shortcut icon" href="../images/system/<?php echo $logo; ?>">
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
		