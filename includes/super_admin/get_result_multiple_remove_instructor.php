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
	if(isset($_REQUEST['semester']) && isset($_REQUEST['course_id']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		try
		{
			$semester=trim($_REQUEST['semester']);
			$sem='';
			$yea='';
			$sz=strlen($semester);
			$f=0;
			//seperating semester and year
			for($i=0;$i<$sz;$i++)
			{
				if($semester[$i]==' ')
				{
					$f=1;
					continue;
				}
				if($f==0)
					$sem=$sem.$semester[$i];
				else
					$yea=$yea.$semester[$i];
			}
			
			$stmt = $conn->prepare(" select a.nr_faculty_id,a.nr_faculty_name,a.nr_faculty_designation,b.nr_dept_title from nr_faculty a,nr_department b where a.nr_dept_id=b.nr_dept_id and a.nr_faculty_status='Active' and a.nr_faculty_id in(select nr_faculty_id from nr_result where nr_course_id=:course_id and nr_prog_id=:prog_id and nr_result_semester=:sem and nr_result_year=:yea ) order by a.nr_faculty_name asc ");
			$stmt->bindParam(':prog_id', $_REQUEST['prog_id']);
			$stmt->bindParam(':course_id', $_REQUEST['course_id']);
			$stmt->bindParam(':sem', $sem);
			$stmt->bindParam(':yea', $yea);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$sz=count($result);
			echo '<option value="">Select</option>';
			for($i=0;$i<$sz;$i++)
			{
				$faculty_id=$result[$i][0];
				$faculty_name=$result[$i][1];
				echo '<option value="'.$faculty_id.'">'.$faculty_name.', '.$result[$i][2].' ('.$result[$i][3].')</option>';
			}
			
		
		}
		catch(PDOException $e)
		{
			echo '<option value="">Select</option>';
			die();
		}
		catch(Exception $e)
		{
			echo '<option value="">Select</option>';
			die();
		}

	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred!!"> Network Error Occurred</i>';
	}
?>