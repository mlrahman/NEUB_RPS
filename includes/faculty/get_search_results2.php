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
	if(isset($_REQUEST['filter_semester']) && isset($_REQUEST['filter_grade']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['program_id2']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id2=trim($_REQUEST['program_id2']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_grade=trim($_REQUEST['filter_grade']);
		if($filter_grade!='-1')
			$filter_grade=get_filter_grade($filter_grade);
		$filter_semester=trim($_REQUEST['filter_semester']);
		
		if($sort==1)
		{
			$order_by='nr_result_id';
			$order='asc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by ".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by ".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==2)
		{
			$order_by='nr_result_id';
			$order='desc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by ".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by ".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==3)
		{
			$order_by='c.nr_stud_id';
			$order='asc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by ".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by ".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==4)
		{
			$order_by='c.nr_stud_id';
			$order='desc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by ".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by ".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==5)
		{
			$order_by='nr_course_code';
			$order='asc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by b.".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by b.".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==6)
		{
			$order_by='nr_course_code';
			$order='desc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by b.".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by b.".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==7)
		{
			$order_by='nr_course_title';
			$order='asc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by b.".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by b.".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		else if($sort==8)
		{
			$order_by='nr_course_title';
			$order='desc';
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and nr_result_status='Active' order by b.".$order_by." ".$order);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a, nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and (b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id and a.nr_prog_id in (select nr_prog_id from nr_program where  nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' order by b.".$order_by." ".$order);
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
		}
		$result = $stmt->fetchAll();
		if(count($result)>0)
		{
			$sz=count($result);
			$xyz=array();
			for($kk=0;$kk<$sz;$kk++)
			{
				//individual course result
				$r_id=$result[$kk][0];
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
					$xyz[$r_id]=array('r_id'=>$r_id,'s_id'=>$s_id,'semester'=>$semester,'course_code'=>$course_code,'course_title'=>$course_title,'course_credit'=>$course_credit,'course_grade'=>$course_grade);
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
				if($xy['course_grade']=='F') $col='w3-text-red';
				
				echo '<tr class="'.$col.'">
					<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['semester'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['s_id'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['course_code'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['course_title'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.number_format($xy['course_credit'],2).'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$xy['course_grade'].'</td>
					<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result2('.$xy['r_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
				</tr>';
			}
		}
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>