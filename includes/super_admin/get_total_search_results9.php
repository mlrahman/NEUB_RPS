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
	if(isset($_REQUEST['filter_status']) && isset($_REQUEST['filter_semester']) && isset($_REQUEST['filter_grade'])  && isset($_REQUEST['filter_instructor']) && isset($_REQUEST['search_text']) && isset($_REQUEST['program_id']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$program_id=trim($_REQUEST['program_id']);
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$order_by='nr_result_id';
		$order='asc';
		$filter_grade=trim($_REQUEST['filter_grade']);
		$filter_status=trim($_REQUEST['filter_status']);
		if($filter_grade!='-1')
			$filter_grade=get_filter_grade($filter_grade);
		$filter_semester=trim($_REQUEST['filter_semester']);
		$filter_instructor=trim($_REQUEST['filter_instructor']);
		$search_text=trim($_REQUEST['search_text']);
		$filter='';
		if($filter_instructor!=-1)
			$filter=' and d.nr_faculty_id='.$filter_instructor;
		if($filter_status!=-1)
			$filter=$filter.' and a.nr_result_status="'.$filter_status.'"';
		
		if($program_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $program_id);
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_prog_id=:prog_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $program_id);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if(count($result)>=1)
		{
			$sz=count($result);
			$count=0;
			for($i=0;$i<$sz;$i++)
			{
				$fl=0;
				$s_id=$result[$i][1];
				$grade=grade_decrypt($s_id,$result[$i][4]);
				$semester=$result[$i][6].'-'.$result[$i][7];
				if($filter_grade!='-1' && $filter_semester!='-1')
				{
					if($filter_grade==$grade && $filter_semester==$semester)
						$fl=1;
				}
				else if($filter_grade!='-1' && $filter_semester=='-1')
				{
					if($filter_grade==$grade)
						$fl=1;
				}
				else if($filter_grade=='-1' && $filter_semester!='-1')
				{
					if($filter_semester==$semester)
						$fl=1;
				}
				else if($filter_grade=='-1' && $filter_semester=='-1')
				{
					$fl=1;
				}
				if($fl==1)
					$count++;
			}
			echo $count;
		}
		else
		{
			echo '0';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>