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
	if(isset($_REQUEST['prog_id']) && isset($_REQUEST['prog_title']) && isset($_REQUEST['prog_code']) && isset($_REQUEST['prog_status']) && isset($_REQUEST['prog_credit']) && isset($_REQUEST['prog_dept']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try{
			$prog_id=trim($_REQUEST['prog_id']);
			$prog_title=trim($_REQUEST['prog_title']);
			$prog_code=trim($_REQUEST['prog_code']);
			$prog_credit=trim($_REQUEST['prog_credit']);
			$prog_dept=trim($_REQUEST['prog_dept']);
			$prog_status=trim($_REQUEST['prog_status']);
			
			
			$stmt = $conn->prepare("update nr_program set nr_prog_title=:prog_title, nr_prog_code=:prog_code, nr_prog_status=:prog_status, nr_dept_id=:prog_dept where nr_prog_id=:prog_id ");
			$stmt->bindParam(':prog_title', $prog_title);
			$stmt->bindParam(':prog_code', $prog_code);
			$stmt->bindParam(':prog_dept', $prog_dept);
			$stmt->bindParam(':prog_status', $prog_status);
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			
			
			$t=get_current_time();
			$d=get_current_date();
			$stmt = $conn->prepare("select a.nr_prcr_id,a.nr_prcr_total from nr_program_credit a,nr_program c where a.nr_prog_id=c.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_prcr_ex_date='' order by a.nr_prcr_id desc limit 1");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$result=$stmt->fetchAll();
			if(count($result)==0) //program credit not available
			{
				$stmt = $conn->prepare("insert into nr_program_credit(nr_prog_id,nr_prcr_total,nr_prcr_date,nr_prcr_status) values(:prog_id,:prog_credit,'$d','Active') ");
				$stmt->bindParam(':prog_id', $prog_id);
				$stmt->bindParam(':prog_credit', $prog_credit);
				$stmt->execute();
				
			}
			else
			{
				$prcr_id=$result[0][0];
				$prcr_total=$result[0][1];
				if($prcr_total!=$prog_credit)
				{
					$stmt = $conn->prepare("update nr_program_credit set nr_prcr_ex_date='$d' where nr_prcr_id=:prcr_id");
					$stmt->bindParam(':prcr_id', $prcr_id);
					$stmt->execute();
					
					$stmt = $conn->prepare("insert into nr_program_credit(nr_prog_id,nr_prcr_total,nr_prcr_date,nr_prcr_status) values(:prog_id,:prog_credit,'$d','Active') ");
					$stmt->bindParam(':prog_id', $prog_id);
					$stmt->bindParam(':prog_credit', $prog_credit);
					$stmt->execute();
					
				}
			}
			
			
			$stmt = $conn->prepare("select a.nr_dept_title from nr_department a,nr_program c where a.nr_dept_id=c.nr_dept_id and c.nr_prog_id=:prog_id ");
			$stmt->bindParam(':prog_id', $prog_id);
			$stmt->execute();
			$dept_title='';
			$result=$stmt->fetchAll();
			if(count($result)!=0)
				$dept_title=$result[0][0];
			
			$task='Edited Program Title: '.$prog_title.', Program Code: '.$prog_code.', Program Credit: '.$prog_credit.', Program Department: '.$dept_title.', Program Status: '.$prog_status;
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