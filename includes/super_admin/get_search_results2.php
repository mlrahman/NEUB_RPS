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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['filter_status']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status=trim($_REQUEST['filter_status']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		
		if($sort==1)
		{
			$order_by='nr_dept_title';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='nr_dept_title';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='nr_dept_code';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='nr_dept_code';
			$order='desc';
		}
		
		$filter='';
		if($filter_status==1)
			$filter=' and nr_dept_status="Active" ';
		if($filter_status==2)
			$filter=' and nr_dept_status="Inactive" ';
		
		$stmt = $conn->prepare("select nr_dept_id,nr_dept_title,nr_dept_code,nr_dept_status,(select count(b.nr_prog_id) from nr_program b where b.nr_dept_id=a.nr_dept_id),(select count(c.nr_stud_id) from nr_student c where c.nr_prog_id in (select d.nr_prog_id from nr_program d where d.nr_dept_id=a.nr_dept_id))  from nr_department a where (nr_dept_title like concat('%',:search_text,'%') or nr_dept_code like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5 ");
		$stmt->bindParam(':search_text', $search_text); $stmt->execute();
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
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result2(\''.$result[$i][0].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
		}
		else
			echo '0';
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>