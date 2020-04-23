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
	if(isset($_REQUEST['prog_dept']) && isset($_REQUEST['prog_credit']) && isset($_REQUEST['prog_code']) && isset($_REQUEST['prog_status']) && isset($_REQUEST['prog_title']) && isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$prog_title=trim($_REQUEST['prog_title']);
			$prog_code=trim($_REQUEST['prog_code']);
			$prog_credit=trim($_REQUEST['prog_credit']);
			$prog_dept=trim($_REQUEST['prog_dept']);
			$prog_status=trim($_REQUEST['prog_status']);
			$pass=trim($_REQUEST['pass']);
			
			if(password_encrypt($pass)!=$_SESSION['admin_password'])
			{
				echo 'pass_error';
				die();
			}
			
			//checking if prog is add able or not
			$stmt = $conn->prepare("select * from nr_program where nr_prog_title=:prog_title or nr_prog_code=:prog_code");
			$stmt->bindParam(':prog_title', $prog_title);
			$stmt->bindParam(':prog_code', $prog_code);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			//checking if prog is add able or not
			$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:prog_dept and nr_dept_status='Inctive'");
			$stmt->bindParam(':prog_dept', $prog_dept);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable2';
				die();
			}
			
			$stmt = $conn->prepare("insert into nr_program(nr_prog_title,nr_prog_code,nr_dept_id,nr_prog_status) values(:prog_title,:prog_code,:prog_dept,:prog_status) ");
			$stmt->bindParam(':prog_title', $prog_title);
			$stmt->bindParam(':prog_code', $prog_code);
			$stmt->bindParam(':prog_dept', $prog_dept);
			$stmt->bindParam(':prog_status', $prog_status);
			$stmt->execute();
			
			
			
			//getting last inserted one
			$stmt = $conn->prepare("select a.nr_prog_id,b.nr_dept_title from nr_program a,nr_department b where a.nr_dept_id=b.nr_dept_id and a.nr_dept_id=:prog_dept and a.nr_prog_title=:prog_title and a.nr_prog_code=:prog_code and a.nr_prog_status=:prog_status limit 1");
			$stmt->bindParam(':prog_title', $prog_title);
			$stmt->bindParam(':prog_code', $prog_code);
			$stmt->bindParam(':prog_dept', $prog_dept);
			$stmt->bindParam(':prog_status', $prog_status);
			$stmt->execute();
			$result = $stmt->fetchAll();
		
			$prog_id=$result[0][0];
			$dept_title=$result[0][1];
			$t=get_current_time();
			$d=get_current_date();
			
			//insert into prcr
			$stmt = $conn->prepare("insert into nr_program_credit(nr_prog_id,nr_prcr_total,nr_prcr_date,nr_prcr_status) values(:prog_id,:prog_credit,'$d','Active') ");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->bindParam(':prog_credit', $prog_credit);
			$stmt->execute();
			
			
			$task='Added program Title: '.$prog_title.', program Code: '.$prog_code.', Program Credit: '.$prog_credit.', Program Department: '.$dept_title.', program Status: '.$prog_status;
			$stmt = $conn->prepare("insert into nr_program_history(nr_prog_id,nr_admin_id,nr_progh_task,nr_progh_date,nr_progh_time,nr_progh_status) values(:prog_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':prog_id', $prog_id);
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