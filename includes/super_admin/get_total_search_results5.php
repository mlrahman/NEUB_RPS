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
	if(isset($_REQUEST['filter_course_type5']) && isset($_REQUEST['filter_semester5']) && isset($_REQUEST['filter_status5']) && isset($_REQUEST['prog_id'])  && isset($_REQUEST['dept_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$prog_id=trim($_REQUEST['prog_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status5=trim($_REQUEST['filter_status5']);
		$filter_semester5=trim($_REQUEST['filter_semester5']);
		$filter_course_type5=trim($_REQUEST['filter_course_type5']);
		
		$filter='';
		if($filter_status5==1)
			$filter=' and a.nr_drop_status="Active" ';
		if($filter_status5==2)
			$filter=' and a.nr_drop_status="Inactive" ';
		
		if($filter_semester5!=-1)
			$filter=$filter.' and a.nr_drop_semester="'.$filter_semester5.'"';
		
		if($filter_course_type5!=-1)
			$filter=$filter.' and a.nr_drop_remarks="'.$filter_course_type5.'"';
		
		
		if($prog_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(a.nr_drop_id) from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) ".$filter);
		}
		else if($prog_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select count(a.nr_drop_id) from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) and d.nr_dept_id=:dept_id ".$filter);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($prog_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select count(a.nr_drop_id) from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) and a.nr_prog_id=:prog_id ".$filter);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		else
		{
			$stmt = $conn->prepare("select count(a.nr_drop_id) from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) and d.nr_dept_id=:dept_id and a.nr_prog_id=:prog_id ".$filter);
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)!=0)
		{
			echo $result[0][0];
		}
		else
			echo '0';
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>