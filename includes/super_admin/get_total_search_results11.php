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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['program_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$dept_id=trim($_REQUEST['dept_id']);
		$program_id=trim($_REQUEST['program_id']);
		$user_type=trim($_REQUEST['user_type']);
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and d.nr_admin_type!='Super Admin' ";
		}
		
		$tot=0;
		if($user_type==-1) //All - student,faculty,moderator,admin,super admin
		{
			
			//student 
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b where a.nr_stud_id=b.nr_stud_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
			
			//faculty
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_faculty d where a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
			
			//moderator admin super_admin
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_admin d where a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
			
		}
		else if($user_type==1) //Student
		{
			//student 
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b where a.nr_stud_id=b.nr_stud_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==2) //Faculty
		{
			//faculty
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_faculty d where a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==3) //moderator
		{
			$filter=" and d.nr_admin_type='Moderator' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_admin d where a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==4) //admin
		{
			$filter=" and d.nr_admin_type='Admin' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_admin d where a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		else if($user_type==5 && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$filter=" and d.nr_admin_type='Super Admin' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_admin d where a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select count(a.nr_stud_id) from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$tot=$tot+$result[0][0];
			}
		}
		echo $tot;
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>
