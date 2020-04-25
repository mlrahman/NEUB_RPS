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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['filter_status4']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$prog_id=trim($_REQUEST['prog_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status4=trim($_REQUEST['filter_status4']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		
		if($sort==1)
		{
			$order_by='a.nr_course_title';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='a.nr_course_title';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='a.nr_course_code';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='a.nr_course_code';
			$order='desc';
		}
		
		$filter='';
		if($filter_status4==1)
			$filter=' and a.nr_course_status="Active" ';
		if($filter_status4==2)
			$filter=' and a.nr_course_status="Inactive" ';
		
		
		if($prog_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_course_id,a.nr_course_title,a.nr_course_code,a.nr_course_status,a.nr_course_credit,b.nr_prog_title from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_dept_id=c.nr_dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
		}
		else if($prog_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select a.nr_course_id,a.nr_course_title,a.nr_course_code,a.nr_course_status,a.nr_course_credit,b.nr_prog_title from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_dept_id=c.nr_dept_id and c.nr_dept_id=:dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($prog_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_course_id,a.nr_course_title,a.nr_course_code,a.nr_course_status,a.nr_course_credit,b.nr_prog_title from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_prog_id=:prog_id and b.nr_dept_id=c.nr_dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
			$stmt->bindParam(':prog_id', $prog_id);
		}
		else
		{
			$stmt = $conn->prepare("select a.nr_course_id,a.nr_course_title,a.nr_course_code,a.nr_course_status,a.nr_course_credit,b.nr_prog_title from nr_course a,nr_program b,nr_department c where a.nr_prog_id=b.nr_prog_id and b.nr_prog_id=:prog_id and b.nr_dept_id=c.nr_dept_id and c.nr_dept_id=:dept_id and (a.nr_course_title like concat('%',:search_text,'%') or a.nr_course_code like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		
		$stmt->bindParam(':search_text', $search_text);
		
		
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
						<td valign="top" class="w3-padding-small w3-border">'.number_format($result[$i][4],2).'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][5].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result4(\''.$result[$i][0].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
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