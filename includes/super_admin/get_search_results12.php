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
	if(isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		if($sort==1)
		{
			$order_by='nr_trprre_reference';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='nr_trprre_reference';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='nr_trprre_date';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='nr_trprre_date';
			$order='desc';
		}
		
		
		$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' order by ".$order_by." ".$order." ");
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>0)
		{
			$sz=count($result);
			$count=0;
			$count2=0;
			for($i=0;$i<$sz;$i++)
			{
				
				
				$role=$result[$i][1];
				$ref=$result[$i][11];
				$user_id=$result[$i][2];
				$date=get_date($result[$i][9]);
				$time=$result[$i][10];
				if($role=='Faculty')
				{
					$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_id='$user_id' ");
					$stmt->execute();
					$t_result = $stmt->fetchAll();
					if($search_text!='' && (stripos($t_result[0][1], $search_text) !== false || stripos($ref, $search_text) !== false))
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$ref.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$t_result[0][1].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$role.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$date.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$time.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result12('.$ref.','.$user_id.','.$t_result[0][1].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
						
					}
					else if($search_text=='')
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$ref.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$t_result[0][1].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$role.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$date.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$time.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result12('.$ref.','.$user_id.','.$t_result[0][1].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else if($role=='Student')
				{
					$stmt = $conn->prepare("select * from nr_student where nr_stud_id='$user_id' ");
					$stmt->execute();
					$t_result = $stmt->fetchAll();
					if($search_text!='' && (stripos($t_result[0][1], $search_text) !== false || stripos($ref, $search_text) !== false))
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$ref.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$t_result[0][1].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$role.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$date.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$time.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result12('.$ref.','.$user_id.','.$t_result[0][1].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
						
					}
					else if($search_text=='')
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$ref.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$t_result[0][1].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$role.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$date.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$time.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result12('.$ref.','.$user_id.','.$t_result[0][1].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else
				{
					$stmt = $conn->prepare("select * from nr_admin where nr_admin_id='$user_id'");
					$stmt->execute();
					$t_result = $stmt->fetchAll();
					if($search_text!='' && (stripos($t_result[0][1], $search_text) !== false || stripos($ref, $search_text) !== false))
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$ref.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$t_result[0][1].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$role.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$date.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$time.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result12('.$ref.','.$user_id.','.$t_result[0][1].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
						
					}
					else if($search_text=='')
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$ref.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$t_result[0][1].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$role.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$date.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$time.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result12('.$ref.','.$user_id.','.$t_result[0][1].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
			}
			
		}
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>
