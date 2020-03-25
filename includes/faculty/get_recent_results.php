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
	if(isset($_REQUEST['recent_results_from']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$page=$_REQUEST['recent_results_from'];
		$stmt = $conn->prepare("SELECT * FROM nr_result a,nr_course b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_course_id=b.nr_course_id and nr_result_status='Active' order by nr_result_id desc limit $page,5");
		$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
		$stmt->execute();
		$stud_result=$stmt->fetchAll();
		if(count($stud_result)>=1)
		{
			for($k=0;$k<count($stud_result);$k++)
			{
				$s_id=$stud_result[$k][1];
				$semester=$stud_result[$k][6].'-'.$stud_result[$k][7];
				$c_code=$stud_result[$k][14];
				$c_title=$stud_result[$k][15];
				$c_credit=number_format($stud_result[$k][16],2);
				$grade=grade_decrypt($s_id,$stud_result[$k][4]);
				$grade_point=number_format(grade_point_decrypt($s_id,$stud_result[$k][5]),2);
				$remarks=$stud_result[$k][8];


				echo '<tr>
					<td valign="top" class="w3-padding-small">'.$semester.'</td>
					<td valign="top" class="w3-padding-small">'.$s_id.'</td>
					<td valign="top" class="w3-padding-small">'.$c_code.'</td>
					<td valign="top" class="w3-padding-small">'.$c_title.'</td>
					<td valign="top" class="w3-padding-small">'.$c_credit.'</td>
					<td valign="top" class="w3-padding-small">'.$grade.'</td>
					<td valign="top" class="w3-padding-small">'.$grade_point.'</td>
					<td valign="top" class="w3-padding-small">'.$remarks.'</td>
				</tr>';

			}
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>