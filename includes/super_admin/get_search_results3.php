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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['filter_status3']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status3=trim($_REQUEST['filter_status3']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		
		if($sort==1)
		{
			$order_by='nr_prog_title';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='nr_prog_title';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='nr_prog_code';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='nr_prog_code';
			$order='desc';
		}
		
		$filter='';
		if($filter_status3==1)
			$filter=' and nr_prog_status="Active" ';
		if($filter_status3==2)
			$filter=' and nr_prog_status="Inactive" ';
		
		if($dept_id==-1)
		{
			$stmt = $conn->prepare("select nr_prog_id,nr_prog_title,nr_prog_code,nr_prog_status,(select b.nr_prcr_total from nr_program_credit b where b.nr_prog_id=a.nr_prog_id and b.nr_prcr_ex_date='' order by b.nr_prcr_id desc limit 1),(select count(c.nr_stud_id) from nr_student c where c.nr_prog_id=a.nr_prog_id) from nr_program a where (nr_prog_title like concat('%',:search_text,'%') or nr_prog_code like concat('%',:search_text,'%'))  ".$filter." order by ".$order_by." ".$order." limit $page,5 ");
			$stmt->bindParam(':search_text', $search_text); 
		}
		else
		{
			$stmt = $conn->prepare("select nr_prog_id,nr_prog_title,nr_prog_code,nr_prog_status,(select b.nr_prcr_total from nr_program_credit b where b.nr_prog_id=a.nr_prog_id and b.nr_prcr_ex_date='' order by b.nr_prcr_id desc limit 1),(select count(c.nr_stud_id) from nr_student c where c.nr_prog_id=a.nr_prog_id) from nr_program a where (nr_prog_title like concat('%',:search_text,'%') or nr_prog_code like concat('%',:search_text,'%')) and a.nr_dept_id=:dept_id  ".$filter." order by ".$order_by." ".$order." limit $page,5 ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->bindParam(':dept_id', $dept_id);

		}			
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)!=0)
		{
			$sz=count($result);
			for($i=0;$i<$sz;$i++)
			{
				$col='';
				if($result[$i][3]=='Inactive')
				{
					$col='w3-pale-red';
				}
				echo '<tr class="'.$col.'" title="Status '.$result[$i][3].'">
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][1].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][2].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][4].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][5].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result3(\''.$result[$i][0].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
		}
		else
			echo '<tr><td colspan="6"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>