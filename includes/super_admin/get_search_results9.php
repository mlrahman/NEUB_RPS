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
	if(isset($_REQUEST['filter_instructor']) && isset($_REQUEST['filter_status']) && isset($_REQUEST['filter_semester']) && isset($_REQUEST['filter_grade']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['program_id']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$program_id=trim($_REQUEST['program_id']);
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_grade=trim($_REQUEST['filter_grade']);
		$filter_status=trim($_REQUEST['filter_status']);
		
		if($filter_grade!='-1')
			$filter_grade=get_filter_grade($filter_grade);
		$filter_semester=trim($_REQUEST['filter_semester']);
		$filter_instructor=trim($_REQUEST['filter_instructor']);
		$filter='';
		if($filter_instructor!=-1)
			$filter=' and d.nr_faculty_id='.$filter_instructor;
		if($filter_status!=-1)
			$filter=$filter.' and a.nr_result_status="'.$filter_status.'"';
		
		if($sort==1)
		{
			$order_by='a.nr_result_id';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='a.nr_result_id';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='c.nr_stud_id';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='c.nr_stud_id';
			$order='desc';
		}
		else if($sort==5)
		{
			$order_by='b.nr_course_code';
			$order='asc';
		}
		else if($sort==6)
		{
			$order_by='b.nr_course_code';
			$order='desc';
		}
		else if($sort==7)
		{
			$order_by='b.nr_course_title';
			$order='asc';
		}
		else if($sort==8)
		{
			$order_by='b.nr_course_title';
			$order='desc';
		}
		
		
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
		if(count($result)>0)
		{
			$sz=count($result);
			$xyz=array();
			for($kk=0;$kk<$sz;$kk++)
			{
				//individual course result
				$r_id=$result[$kk][0];
				$r_status=$result[$kk][9];
				$s_id=$result[$kk][1];
				$semester=$result[$kk][6].'-'.$result[$kk][7];
				$course_code=$result[$kk][14];
				$course_title=$result[$kk][15];
				$course_credit=$result[$kk][16];
				$course_grade=grade_decrypt($s_id,$result[$kk][4]);
				
				
				$fl=0;
				if($filter_grade!='-1' && $filter_semester!='-1')
				{
					if($filter_grade==$course_grade && $filter_semester==$semester)
						$fl=1;
				}
				else if($filter_grade!='-1' && $filter_semester=='-1')
				{
					if($filter_grade==$course_grade)
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
				{
					$xyz[$r_id]=array('r_id'=>$r_id,'s_id'=>$s_id,'semester'=>$semester,'course_code'=>$course_code,'course_title'=>$course_title,'course_credit'=>$course_credit,'course_grade'=>$course_grade,'r_status'=>$r_status);
				}
			}
			
			$count=0;
			$count2=0;
					
			foreach($xyz as $xy)
			{
				$count++;
				if($count<=$page) continue;
				$count2++;
				if($count2>5) break;
				$col='';
				$col2='';
				if($xy['course_grade']=='F') $col='w3-text-red';
				if($xy['r_status']=='Inactive') $col2='w3-pale-red';
				echo '<tr class="'.$col.' '.$col2.'">
					<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['semester'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['s_id'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['course_code'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['course_title'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.number_format($xy['course_credit'],2).'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['course_grade'].'</td>
					<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result9('.$xy['r_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
				</tr>';
			}
			if($count==0)
				echo '<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
		}
		else
			echo '<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>