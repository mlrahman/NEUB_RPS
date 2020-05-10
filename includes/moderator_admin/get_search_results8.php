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
	if(isset($_REQUEST['filter_status']) && isset($_REQUEST['filter_degree']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['moderator_id']) && $_REQUEST['moderator_id']==$_SESSION['moderator_id'])
	{
		$program_id=trim($_REQUEST['prog_id']);
		$moderator_id=trim($_REQUEST['moderator_id']);
		$filter_degree=trim($_REQUEST['filter_degree']);
		$filter_status=trim($_REQUEST['filter_status']);
		$dept_id=trim($_REQUEST['dept_id']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		$search_text=trim($_REQUEST['search_text']);
		$filter='';
		$filter='';
		if($filter_degree==1)
		{
			$filter='and b.nr_studi_graduated=1';
		}
		else if($filter_degree==2)
		{
			$filter='and b.nr_studi_dropout=1';
		}
		if($filter_status==1)
		{
			$filter=$filter.' and a.nr_stud_status="Active"';
		}
		else if($filter_status==2)
		{
			$filter=$filter.' and a.nr_stud_status="Inactive"';
		}
		if($sort==1)
		{
			$order_by='a.nr_stud_id';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='a.nr_stud_id';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='a.nr_stud_name';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='a.nr_stud_name';
			$order='desc';
		}
		else if($sort==5)
		{
			$order_by='b.nr_studi_earned_credit';
			$order='asc';
		}
		else if($sort==6)
		{
			$order_by='b.nr_studi_earned_credit';
			$order='desc';
		}
		else if($sort==7)
		{
			$order_by='b.nr_studi_waived_credit';
			$order='asc';
		}
		else if($sort==8)
		{
			$order_by='b.nr_studi_waived_credit';
			$order='desc';
		}
		else if($sort==9)
		{
			$order_by='b.nr_studi_cgpa';
			$order='asc';
		}
		else if($sort==10)
		{
			$order_by='b.nr_studi_cgpa';
			$order='desc';
		}
		
		if($program_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status from nr_student a,nr_student_info b,nr_program_credit c where a.nr_stud_id=b.nr_stud_id ".$filter." and a.nr_prcr_id=c.nr_prcr_id and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order." limit $page,5 ");
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status from nr_student a,nr_student_info b,nr_program_credit c where a.nr_stud_id=b.nr_stud_id ".$filter." and a.nr_prcr_id=c.nr_prcr_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order." limit $page,5 ");
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status from nr_student a,nr_student_info b,nr_program_credit c where a.nr_prog_id=:prog_id ".$filter." and a.nr_stud_id=b.nr_stud_id and a.nr_prcr_id=c.nr_prcr_id and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order." limit $page,5 ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		else
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status from nr_student a,nr_student_info b,nr_program_credit c where a.nr_prog_id=:prog_id ".$filter." and a.nr_stud_id=b.nr_stud_id and a.nr_prcr_id=c.nr_prcr_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order." limit $page,5 ");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>0)
		{
			$sz=count($result);
			for($i=0;$i<$sz;$i++)
			{
				$wc=$result[$i][3];
				if($wc==0)
					$wc='N/A';
				$col='';
				if($result[$i][6]=='Inactive')
					$col='w3-pale-red';
				echo '<tr class="'.$col.'" title="Status '.$result[$i][6].'">
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][0].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][1].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_session($result[$i][0]).'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][2].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$wc.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][4].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.number_format($result[$i][5],2).'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result8('.$result[$i][0].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';
			}
		
		}
		else
			echo '<tr><td colspan="9"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>