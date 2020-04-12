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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['recent_results_from']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$page=$_REQUEST['recent_results_from'];
		$program_id=$_REQUEST['program_id'];
		$dept_id=trim($_REQUEST['dept_id']);
		
		if($program_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id desc limit $page,5");
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id desc limit $page,5");
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and a.nr_prog_id=:prog_id and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id desc limit $page,5");
			$stmt->bindParam(':prog_id', $program_id);
		}
		else
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_prog_id=:prog_id and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id desc limit $page,5");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->execute();
		$stud_result=$stmt->fetchAll();
		if(count($stud_result)>=1)
		{
			$sz=count($stud_result);
			for($k=0;$k<$sz;$k++)
			{
				$s_id=$stud_result[$k][1];
				$semester=$stud_result[$k][6].'-'.$stud_result[$k][7];
				$c_code=$stud_result[$k][14];
				$c_title=$stud_result[$k][15];
				$c_credit=number_format($stud_result[$k][16],2);
				$grade=grade_decrypt($s_id,$stud_result[$k][4]);
				$grade_point=number_format(grade_point_decrypt($s_id,$stud_result[$k][5]),2);
				$remarks=$stud_result[$k][8];
				
				$col1='';
				if($grade=='F') $col1='w3-text-red';
				$col2='';
				if($remarks!="") $col2='w3-text-blue';

				echo '<tr class="'.$col1.'">
					<td valign="top" class="w3-padding-small">'.$semester.'</td>
					<td valign="top" class="w3-padding-small">'.$s_id.'</td>
					<td valign="top" class="w3-padding-small">'.$c_code.'</td>
					<td valign="top" class="w3-padding-small">'.$c_title.'</td>
					<td valign="top" class="w3-padding-small">'.$c_credit.'</td>
					<td valign="top" class="w3-padding-small">'.$grade.'</td>
					<td valign="top" class="w3-padding-small">'.$grade_point.'</td>
					<td valign="top" class="w3-padding-small '.$col2.'">'.$remarks.'</td>
				</tr>';

			}
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>