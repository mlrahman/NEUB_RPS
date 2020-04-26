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
	if(isset($_REQUEST['filter_type7']) && isset($_REQUEST['sort']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['filter_status7']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status7=trim($_REQUEST['filter_status7']);
		$filter_type7=trim($_REQUEST['filter_type7']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		
		if($sort==1)
		{
			$order_by='nr_faculty_name';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='nr_faculty_name';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='nr_faculty_designation';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='nr_faculty_designation';
			$order='desc';
		}
		
		$filter='';
		if($filter_status7==1)
			$filter=' and nr_faculty_status="Active" ';
		if($filter_status7==2)
			$filter=' and nr_faculty_status="Inactive" ';
		if($filter_type7!=-1)
			$filter=$filter.' and nr_faculty_type="'.$filter_type7.'" ';
		
		
		if($dept_id==-1)
		{
			$stmt = $conn->prepare("select nr_faculty_id,nr_faculty_name,nr_faculty_designation,nr_faculty_type,nr_faculty_join_date,nr_faculty_status from nr_faculty where (nr_faculty_name like concat('%',:search_text,'%') or nr_faculty_designation like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
			$stmt->bindParam(':search_text', $search_text); 
		}
		else
		{
			$stmt = $conn->prepare("select nr_faculty_id,nr_faculty_name,nr_faculty_designation,nr_faculty_type,nr_faculty_join_date,nr_faculty_status from nr_faculty where nr_dept_id=:dept_id and (nr_faculty_name like concat('%',:search_text,'%') or nr_faculty_designation like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
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
				if($result[$i][5]=='Inactive')
				{
					$col='w3-pale-red';
				}
				echo '<tr class="'.$col.'" title="Status '.$result[$i][5].'">
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][1].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][2].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$result[$i][3].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_date($result[$i][4]).'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result7(\''.$result[$i][0].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
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