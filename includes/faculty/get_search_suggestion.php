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
	if(isset($_REQUEST['search_text']) && isset($_REQUEST['program_id2']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id2=trim($_REQUEST['program_id2']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		$search_text=trim($_REQUEST['search_text']);
		
		if($program_id2==-1)
		{
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id)  and nr_stud_status='Active' and (nr_stud_id LIKE CONCAT('%', :se_te, '%') or nr_stud_name LIKE CONCAT('%', :se_te, '%') ) ");
		}
		else
		{
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active'  and (nr_stud_id LIKE CONCAT('%', :se_te, '%') or nr_stud_name LIKE CONCAT('%', :se_te, '%') ) ");
			$stmt->bindParam(':prog_id', $program_id2);
		}
		$stmt->bindParam(':se_te', $search_text);
		$stmt->bindParam(':f_d_id', $faculty_dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>0)
		{
			
			$szz=count($result);
			for($kk=0;$kk<$szz;$kk++)
			{
				$s_id=$result[$kk][0];
				$s_name=$result[$kk][1];
				echo '<tr>
						<td valign="top" style="width:25%;" class="w3-padding-small w3-border">'.$s_id.'</td>
						<td valign="top" style="width:55%;" class="w3-padding-small w3-border">'.$s_name.'</td>
						<td valign="top" style="width:20%;" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$s_id.')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';
							
			}
		}
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>