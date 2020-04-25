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
	if(isset($_REQUEST['course_offer_prog']) && isset($_REQUEST['course_offer_type']) && isset($_REQUEST['course_offer_semester']) && isset($_REQUEST['course_offer_status']) && isset($_REQUEST['course_offer_course']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$course_offer_course=trim($_REQUEST['course_offer_course']);
			$course_offer_semester=trim($_REQUEST['course_offer_semester']);
			$course_offer_type=trim($_REQUEST['course_offer_type']);
			$course_offer_prog=trim($_REQUEST['course_offer_prog']);
			$course_offer_status=trim($_REQUEST['course_offer_status']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			$stmt = $conn->prepare("select * from nr_drop a,nr_program b where a.nr_prog_id=b.nr_prog_id and b.nr_prog_id=:prog_id and a.nr_course_id=:course_id and a.nr_prcr_id=(select c.nr_prcr_id from nr_program_credit c where c.nr_prog_id=b.nr_prog_id and c.nr_prcr_ex_date='' order by c.nr_prcr_id desc limit 1) ");
			$stmt->bindParam(':prog_id', $course_offer_prog);
			$stmt->bindParam(':course_id', $course_offer_course);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			//checking if prog is active or not
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=:course_offer_prog and nr_prog_status='Inctive'");
			$stmt->bindParam(':course_offer_prog', $course_offer_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable2';
				die();
			}
			
			$stmt = $conn->prepare("select a.nr_prcr_id,a.nr_prcr_total,b.nr_prog_title from nr_program_credit a,nr_program b where a.nr_prog_id=b.nr_prog_id and a.nr_prog_id=:course_offer_prog and a.nr_prcr_ex_date='' order by a.nr_prcr_id desc limit 1 ");
			$stmt->bindParam(':course_offer_prog', $course_offer_prog);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo 'unable3';
				die();
			}
			
			$prcr_id=$result[0][0];
			$prog_credit=$result[0][1];
			$prog_title=$result[0][2];
			
			
			$stmt = $conn->prepare("insert into nr_drop(nr_prog_id,nr_prcr_id,nr_course_id,nr_drop_remarks,nr_drop_semester,nr_drop_status) values(:course_offer_prog,:prcr_id,:course_offer_course,:course_offer_type,:course_offer_semester,:course_offer_status) ");
			$stmt->bindParam(':prcr_id', $prcr_id);
			$stmt->bindParam(':course_offer_course', $course_offer_course);
			$stmt->bindParam(':course_offer_semester', $course_offer_semester);
			$stmt->bindParam(':course_offer_prog', $course_offer_prog);
			$stmt->bindParam(':course_offer_status', $course_offer_status);
			$stmt->bindParam(':course_offer_type', $course_offer_type);
			$stmt->execute();
			
			
			
			//getting last inserted one
			$stmt = $conn->prepare("select nr_drop_id,b.nr_course_title,b.nr_course_code,b.nr_course_credit from nr_drop, nr_course b where nr_drop.nr_course_id=b.nr_course_id and nr_drop.nr_course_id=:course_offer_course and nr_drop_semester=:course_offer_semester and nr_drop.nr_prog_id=:course_offer_prog and nr_drop_remarks=:course_offer_type and nr_drop_status=:course_offer_status and nr_drop.nr_prcr_id=:prcr_id limit 1");
			$stmt->bindParam(':course_offer_course', $course_offer_course);
			$stmt->bindParam(':course_offer_semester', $course_offer_semester);
			$stmt->bindParam(':course_offer_prog', $course_offer_prog);
			$stmt->bindParam(':course_offer_status', $course_offer_status);
			$stmt->bindParam(':course_offer_type', $course_offer_type);
			$stmt->bindParam(':prcr_id', $prcr_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
		
			$course_offer_id=$result[0][0];
			$course_title=$result[0][1];
			$course_code=$result[0][2];
			$course_credit=$result[0][3];
			
			$t=get_current_time();
			$d=get_current_date();
			$task='Added Course Title: '.$course_title.', Course Code: '.$course_code.', Course Credit: '.number_format($course_credit,2).', Course Type: '.$course_offer_type.', Offer Semester: '.$course_offer_semester.', Offer Program: '.$prog_title.', Program Credit: '.$prog_credit.', Offer Status: '.$course_offer_status;
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