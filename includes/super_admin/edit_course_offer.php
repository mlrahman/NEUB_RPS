<?php
	session_start();
	require("../db_connection.php"); 
	require("../function.php"); 
	try{
		require("logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
	if(isset($_REQUEST['course_offer_id']) && isset($_REQUEST['course_offer_view_semester']) && isset($_REQUEST['course_offer_view_type']) && isset($_REQUEST['course_offer_view_status']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$course_offer_id=trim($_REQUEST['course_offer_id']);
			$course_offer_view_semester=trim($_REQUEST['course_offer_view_semester']);
			$course_offer_view_type=trim($_REQUEST['course_offer_view_type']);
			$course_offer_view_status=trim($_REQUEST['course_offer_view_status']);
			
			
			$stmt = $conn->prepare("update nr_drop set nr_drop_semester=:course_offer_view_semester, nr_drop_remarks=:course_offer_view_type, nr_drop_status=:course_offer_view_status where nr_drop_id=:course_offer_id ");
			$stmt->bindParam(':course_offer_view_semester', $course_offer_view_semester);
			$stmt->bindParam(':course_offer_view_type', $course_offer_view_type);
			$stmt->bindParam(':course_offer_view_status', $course_offer_view_status);
			$stmt->bindParam(':course_offer_id', $course_offer_id);
			$stmt->execute();
			
			
			$t=get_current_time();
			$d=get_current_date();
			
			
			$stmt = $conn->prepare("select a.nr_drop_id,b.nr_course_title,b.nr_course_code,b.nr_course_credit, a.nr_drop_remarks, a.nr_drop_semester, c.nr_prog_id, c.nr_prog_title, d.nr_prcr_total, d.nr_prcr_ex_date,a.nr_drop_status from nr_drop a,nr_course b,nr_program c,nr_program_credit d where a.nr_prcr_id=d.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and a.nr_course_id=b.nr_course_id and a.nr_drop_id=:course_offer_id");
			$stmt->bindParam(':course_offer_id', $course_offer_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			$course_title=$result[0][1];
			$course_code=$result[0][2];
			$credit=$result[0][3];
			$course_type=$result[0][4];
			$course_semester=$result[0][5];
			$prog_id=$result[0][6];
			$prog_title=$result[0][7];
			$prog_credit=$result[0][8];
			$prog_expire=$result[0][9];
			$status=$result[0][10];
			$t=get_current_time();
			$d=get_current_date();
			
			$task='Edited Offer Course Title: '.$course_title.', Course Code: '.$course_code.', Course Credit: '.number_format($credit,2).', Course Type: '.$course_type.', Offer Semester: '.get_semester_format($course_semester).', Offer Program: '.$prog_title.', Program Credit: '.$prog_credit.', Offer Status: '.$status;
			$stmt = $conn->prepare("insert into nr_drop_history(nr_drop_id,nr_admin_id,nr_droph_task,nr_droph_date,nr_droph_time,nr_droph_status) values(:course_offer_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':course_offer_id', $course_offer_id);
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			
			echo 'Ok';

		}
		catch(PDOException $e)
		{
			
			echo 'Error';
			die();
		}
		catch(Exception $e)
		{
			echo 'Error';
			die();
		}
		
		
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>