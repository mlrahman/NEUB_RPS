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
	if($_SESSION['admin_type']!='Super Admin'){
		header("location: index.php");
		die();
	}
	if(isset($_REQUEST['filter_type15']) && isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['filter_status15']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status15=trim($_REQUEST['filter_status15']);
		$filter_type15=trim($_REQUEST['filter_type15']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		
		if($sort==1)
		{
			$order_by='nr_admin_name';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='nr_admin_name';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='nr_admin_designation';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='nr_admin_designation';
			$order='desc';
		}
		
		$filter='';
		if($filter_status15==1)
			$filter=' and nr_admin_status="Active" ';
		if($filter_status15==2)
			$filter=' and nr_admin_status="Inactive" ';
		if($filter_type15!=-1)
			$filter=$filter.' and nr_admin_type="'.$filter_type15.'"';
		
		
		
		$stmt = $conn->prepare("select nr_admin_id,nr_admin_name,nr_admin_designation,nr_admin_type,nr_admin_join_date,nr_admin_status from nr_admin where (nr_admin_name like concat('%',:search_text,'%') or nr_admin_designation like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order." limit $page,5");
		$stmt->bindParam(':search_text', $search_text); 
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
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result15(\''.$result[$i][0].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
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