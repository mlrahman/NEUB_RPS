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
	if(isset($_REQUEST['faculty_resign_date']) && isset($_REQUEST['faculty_join_date']) && isset($_REQUEST['faculty_status']) && isset($_REQUEST['faculty_gender']) && isset($_REQUEST['faculty_type']) && isset($_REQUEST['faculty_id']) && isset($_REQUEST['faculty_name']) && isset($_REQUEST['faculty_designation']) && isset($_REQUEST['faculty_email']) && isset($_REQUEST['faculty_mobile']) && isset($_REQUEST['faculty_dept']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$faculty_id=trim($_REQUEST['faculty_id']);
			$faculty_name=trim($_REQUEST['faculty_name']);
			$faculty_designation=trim($_REQUEST['faculty_designation']);
			$faculty_email=trim($_REQUEST['faculty_email']);
			$faculty_mobile=trim($_REQUEST['faculty_mobile']);
			$faculty_join_date=trim($_REQUEST['faculty_join_date']);
			$faculty_resign_date=trim($_REQUEST['faculty_resign_date']);
			$faculty_dept=trim($_REQUEST['faculty_dept']);
			$faculty_type=trim($_REQUEST['faculty_type']);
			$faculty_gender=trim($_REQUEST['faculty_gender']);
			$faculty_status=trim($_REQUEST['faculty_status']);
			
			
			//checking if faculty is add able or not
			$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_id!=:faculty_id and ((nr_faculty_email!='' and nr_faculty_email=:faculty_email) or (nr_faculty_name=:faculty_name and nr_faculty_designation=:faculty_designation and nr_faculty_join_date=:faculty_join_date))");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->bindParam(':faculty_name', $faculty_name);
			$stmt->bindParam(':faculty_designation', $faculty_designation);
			$stmt->bindParam(':faculty_join_date', $faculty_join_date);
			$stmt->bindParam(':faculty_email', $faculty_email);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable';
				die();
			}
			
			//checking if dept is active or not
			$stmt = $conn->prepare("select * from nr_department where nr_dept_id=:dept_id and nr_dept_status='Inactive' ");
			$stmt->bindParam(':dept_id', $faculty_dept);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				echo 'unable2';
				die();
			}
			
			if(email_check($faculty_email)==false)
			{
				echo 'unable3';
				die();
			}
			
			$stmt = $conn->prepare("update nr_faculty set nr_faculty_name=:faculty_name, nr_faculty_designation=:faculty_designation,nr_faculty_email=:faculty_email,nr_faculty_cell_no=:faculty_mobile,nr_faculty_join_date=:faculty_join_date, nr_faculty_resign_date=:faculty_resign_date,nr_dept_id=:faculty_dept,nr_faculty_gender=:faculty_gender,nr_faculty_type=:faculty_type,nr_faculty_status=:faculty_status where nr_faculty_id=:faculty_id ");
			$stmt->bindParam(':faculty_id', $faculty_id);
			$stmt->bindParam(':faculty_name', $faculty_name);
			$stmt->bindParam(':faculty_designation', $faculty_designation);
			$stmt->bindParam(':faculty_email', $faculty_email);
			$stmt->bindParam(':faculty_mobile', $faculty_mobile);
			$stmt->bindParam(':faculty_join_date', $faculty_join_date);
			$stmt->bindParam(':faculty_resign_date', $faculty_resign_date);
			$stmt->bindParam(':faculty_dept', $faculty_dept);
			$stmt->bindParam(':faculty_type', $faculty_type);
			$stmt->bindParam(':faculty_gender', $faculty_gender);
			$stmt->bindParam(':faculty_status', $faculty_status);
			$stmt->execute();
			
			$stmt = $conn->prepare("select nr_dept_title from nr_department where nr_dept_id=:faculty_dept ");
			$stmt->bindParam(':faculty_dept', $faculty_dept);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$dept_title=$result[0][0];
			
			$t=get_current_time();
			$d=get_current_date();
			$task='Edited Faculty Name: '.$faculty_name.', Faculty Designation: '.$faculty_designation.', Faculty Gender: '.$faculty_gender.', Faculty Join Date: '.$faculty_join_date.', Faculty Resign Date: '.$faculty_resign_date.', Faculty Department: '.$dept_title.', Faculty Type: '.$faculty_type.', Faculty Email: '.$faculty_email.', Faculty Mobile: '.$faculty_mobile.', Faculty Status: '.$faculty_status;
			$stmt = $conn->prepare("insert into nr_faculty_history(nr_faculty_id,nr_admin_id,nr_facultyh_task,nr_facultyh_date,nr_facultyh_time,nr_facultyh_status) values(:faculty_id,:admin_id,'$task','$d','$t','Active') ");
			$stmt->bindParam(':faculty_id', $faculty_id);
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