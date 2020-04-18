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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$user_type=trim($_REQUEST['user_type']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and b.nr_admin_type!='Super Admin' ";
		}
	
		if($user_type==-1) //All
		{
			$data=array();
			
			$stmt = $conn->prepare("select distinct(b.nr_faculty_id),b.nr_faculty_name,b.nr_faculty_designation,(select count(c.nr_faculty_id) from nr_faculty_login_transaction c where c.nr_faculty_id=b.nr_faculty_id),(select d.nr_falotr_date from nr_faculty_login_transaction d where d.nr_faculty_id=b.nr_faculty_id order by d.nr_falotr_date desc,d.nr_falotr_time desc limit 1),(select e.nr_falotr_time from nr_faculty_login_transaction e where e.nr_faculty_id=b.nr_faculty_id order by e.nr_falotr_date desc,e.nr_falotr_time desc limit 1),(select d.nr_falotr_date from nr_faculty_login_transaction d where d.nr_faculty_id=b.nr_faculty_id order by d.nr_falotr_date asc,d.nr_falotr_time asc limit 1),(select e.nr_falotr_time from nr_faculty_login_transaction e where e.nr_faculty_id=b.nr_faculty_id order by e.nr_falotr_date asc,e.nr_falotr_time asc limit 1),(select count(f.nr_faculty_id) from nr_faculty_login_transaction f where f.nr_faculty_id=b.nr_faculty_id and f.nr_falotr_status='Active') from nr_faculty_login_transaction a,nr_faculty b where a.nr_faculty_id=b.nr_faculty_id and b.nr_faculty_name like concat('%',:search_text,'%') ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('user_id'=>$result[$i][0],'user_type'=>'Faculty','user_name'=>$result[$i][1],'user_designation'=>$result[$i][2],'user_total_session'=>$result[$i][3],'user_last_session_date'=>$result[$i][4],'user_last_session_time'=>$result[$i][5],'user_first_session_date'=>$result[$i][6],'user_first_session_time'=>$result[$i][7],'on'=>$result[$i][8]);
				}
			}
			
			$stmt = $conn->prepare("select distinct(b.nr_admin_id),b.nr_admin_name,b.nr_admin_designation,(select count(c.nr_admin_id) from nr_admin_login_transaction c where c.nr_admin_id=b.nr_admin_id),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date desc,d.nr_suadlotr_time desc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date desc,e.nr_suadlotr_time desc limit 1),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date asc,d.nr_suadlotr_time asc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date asc,e.nr_suadlotr_time asc limit 1),b.nr_admin_type,(select count(f.nr_admin_id) from nr_admin_login_transaction f where f.nr_admin_id=b.nr_admin_id and f.nr_suadlotr_status='Active') from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') ".$filter);
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('user_id'=>$result[$i][0],'user_type'=>$result[$i][8],'user_name'=>$result[$i][1],'user_designation'=>$result[$i][2],'user_total_session'=>$result[$i][3],'user_last_session_date'=>$result[$i][4],'user_last_session_time'=>$result[$i][5],'user_first_session_date'=>$result[$i][6],'user_first_session_time'=>$result[$i][7],'on'=>$result[$i][9]);
				}
			}
			if($sort==2)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]<$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]<$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==1)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]>$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]>$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==3)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]>$b["user_name"]);
				}
				usort($data, "cmp");
			}
			else if($sort==4)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]<$b["user_name"]);
				}
				usort($data, "cmp");
			}
			$count=0;
			$count2=0;
			foreach($data as $r)
			{
				$count++;
				if($count<=$page) continue;
				$count2++;
				if($count2>5) break;
				$on='';
				if($r['on']>0)
					$on='<i class="fa fa-circle w3-text-light-green w3-cursor" style="font-size:9px;" title="Active session is available"></i> ';
				echo '<tr>
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$on.$r['user_name'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_designation'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_type'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_total_session'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result13(\''.$r['user_type'].'\',\''.$r['user_id'].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
		
		}
		else if($user_type==1) //Faculty
		{
			$data=array();
			
			$stmt = $conn->prepare("select distinct(b.nr_faculty_id),b.nr_faculty_name,b.nr_faculty_designation,(select count(c.nr_faculty_id) from nr_faculty_login_transaction c where c.nr_faculty_id=b.nr_faculty_id),(select d.nr_falotr_date from nr_faculty_login_transaction d where d.nr_faculty_id=b.nr_faculty_id order by d.nr_falotr_date desc,d.nr_falotr_time desc limit 1),(select e.nr_falotr_time from nr_faculty_login_transaction e where e.nr_faculty_id=b.nr_faculty_id order by e.nr_falotr_date desc,e.nr_falotr_time desc limit 1),(select d.nr_falotr_date from nr_faculty_login_transaction d where d.nr_faculty_id=b.nr_faculty_id order by d.nr_falotr_date asc,d.nr_falotr_time asc limit 1),(select e.nr_falotr_time from nr_faculty_login_transaction e where e.nr_faculty_id=b.nr_faculty_id order by e.nr_falotr_date asc,e.nr_falotr_time asc limit 1),(select count(f.nr_faculty_id) from nr_faculty_login_transaction f where f.nr_faculty_id=b.nr_faculty_id and f.nr_falotr_status='Active') from nr_faculty_login_transaction a,nr_faculty b where a.nr_faculty_id=b.nr_faculty_id and b.nr_faculty_name like concat('%',:search_text,'%') ");
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('user_id'=>$result[$i][0],'user_type'=>'Faculty','user_name'=>$result[$i][1],'user_designation'=>$result[$i][2],'user_total_session'=>$result[$i][3],'user_last_session_date'=>$result[$i][4],'user_last_session_time'=>$result[$i][5],'user_first_session_date'=>$result[$i][6],'user_first_session_time'=>$result[$i][7],'on'=>$result[$i][8]);
				}
			}
			
			
			if($sort==2)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]<$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]<$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==1)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]>$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]>$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==3)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]>$b["user_name"]);
				}
				usort($data, "cmp");
			}
			else if($sort==4)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]<$b["user_name"]);
				}
				usort($data, "cmp");
			}
			$count=0;
			$count2=0;
			foreach($data as $r)
			{
				$count++;
				if($count<=$page) continue;
				$count2++;
				if($count2>5) break;
				$on='';
				if($r['on']>0)
					$on='<i class="fa fa-circle w3-text-light-green w3-cursor" style="font-size:9px;" title="Active session is available"></i> ';
				
				echo '<tr>
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$on.$r['user_name'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_designation'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_type'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_total_session'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result13(\''.$r['user_type'].'\',\''.$r['user_id'].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
			
		}
		else if($user_type==2) //moderator
		{
			$data=array();
			$stmt = $conn->prepare("select distinct(b.nr_admin_id),b.nr_admin_name,b.nr_admin_designation,(select count(c.nr_admin_id) from nr_admin_login_transaction c where c.nr_admin_id=b.nr_admin_id),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date desc,d.nr_suadlotr_time desc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date desc,e.nr_suadlotr_time desc limit 1),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date asc,d.nr_suadlotr_time asc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date asc,e.nr_suadlotr_time asc limit 1),b.nr_admin_type,(select count(f.nr_admin_id) from nr_admin_login_transaction f where f.nr_admin_id=b.nr_admin_id and f.nr_suadlotr_status='Active') from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') and b.nr_admin_type='Moderator' ".$filter);
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('user_id'=>$result[$i][0],'user_type'=>$result[$i][8],'user_name'=>$result[$i][1],'user_designation'=>$result[$i][2],'user_total_session'=>$result[$i][3],'user_last_session_date'=>$result[$i][4],'user_last_session_time'=>$result[$i][5],'user_first_session_date'=>$result[$i][6],'user_first_session_time'=>$result[$i][7],'on'=>$result[$i][9]);
				}
			}
			if($sort==2)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]<$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]<$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==1)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]>$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]>$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==3)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]>$b["user_name"]);
				}
				usort($data, "cmp");
			}
			else if($sort==4)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]<$b["user_name"]);
				}
				usort($data, "cmp");
			}
			$count=0;
			$count2=0;
			foreach($data as $r)
			{
				$count++;
				if($count<=$page) continue;
				$count2++;
				if($count2>5) break;
				$on='';
				if($r['on']>0)
					$on='<i class="fa fa-circle w3-text-light-green w3-cursor" style="font-size:9px;" title="Active session is available"></i> ';
				
				echo '<tr>
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$on.$r['user_name'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_designation'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_type'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_total_session'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result13(\''.$r['user_type'].'\',\''.$r['user_id'].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
			
		}
		else if($user_type==3) //admin
		{
			$data=array();
			$stmt = $conn->prepare("select distinct(b.nr_admin_id),b.nr_admin_name,b.nr_admin_designation,(select count(c.nr_admin_id) from nr_admin_login_transaction c where c.nr_admin_id=b.nr_admin_id),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date desc,d.nr_suadlotr_time desc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date desc,e.nr_suadlotr_time desc limit 1),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date asc,d.nr_suadlotr_time asc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date asc,e.nr_suadlotr_time asc limit 1),b.nr_admin_type,(select count(f.nr_admin_id) from nr_admin_login_transaction f where f.nr_admin_id=b.nr_admin_id and f.nr_suadlotr_status='Active') from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') and b.nr_admin_type='Admin' ".$filter);
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('user_id'=>$result[$i][0],'user_type'=>$result[$i][8],'user_name'=>$result[$i][1],'user_designation'=>$result[$i][2],'user_total_session'=>$result[$i][3],'user_last_session_date'=>$result[$i][4],'user_last_session_time'=>$result[$i][5],'user_first_session_date'=>$result[$i][6],'user_first_session_time'=>$result[$i][7],'on'=>$result[$i][9]);
				}
			}
			if($sort==2)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]<$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]<$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==1)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]>$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]>$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==3)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]>$b["user_name"]);
				}
				usort($data, "cmp");
			}
			else if($sort==4)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]<$b["user_name"]);
				}
				usort($data, "cmp");
			}
			$count=0;
			$count2=0;
			foreach($data as $r)
			{
				$count++;
				if($count<=$page) continue;
				$count2++;
				if($count2>5) break;
				$on='';
				if($r['on']>0)
					$on='<i class="fa fa-circle w3-text-light-green w3-cursor" style="font-size:9px;" title="Active session is available"></i> ';
				
				echo '<tr>
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$on.$r['user_name'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_designation'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_type'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_total_session'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result13(\''.$r['user_type'].'\',\''.$r['user_id'].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
		}
		else if($user_type==4 && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$data=array();
			$stmt = $conn->prepare("select distinct(b.nr_admin_id),b.nr_admin_name,b.nr_admin_designation,(select count(c.nr_admin_id) from nr_admin_login_transaction c where c.nr_admin_id=b.nr_admin_id),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date desc,d.nr_suadlotr_time desc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date desc,e.nr_suadlotr_time desc limit 1),(select d.nr_suadlotr_date from nr_admin_login_transaction d where d.nr_admin_id=b.nr_admin_id order by d.nr_suadlotr_date asc,d.nr_suadlotr_time asc limit 1),(select e.nr_suadlotr_time from nr_admin_login_transaction e where e.nr_admin_id=b.nr_admin_id order by e.nr_suadlotr_date asc,e.nr_suadlotr_time asc limit 1),b.nr_admin_type,(select count(f.nr_admin_id) from nr_admin_login_transaction f where f.nr_admin_id=b.nr_admin_id and f.nr_suadlotr_status='Active') from nr_admin_login_transaction a,nr_admin b where a.nr_admin_id=b.nr_admin_id and b.nr_admin_name like concat('%',:search_text,'%') and b.nr_admin_type='Super Admin' ".$filter);
			$stmt->bindParam(':search_text', $search_text);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('user_id'=>$result[$i][0],'user_type'=>$result[$i][8],'user_name'=>$result[$i][1],'user_designation'=>$result[$i][2],'user_total_session'=>$result[$i][3],'user_last_session_date'=>$result[$i][4],'user_last_session_time'=>$result[$i][5],'user_first_session_date'=>$result[$i][6],'user_first_session_time'=>$result[$i][7],'on'=>$result[$i][9]);
				}
			}
			if($sort==2)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]<$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]<$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==1)
			{
				function cmp($a, $b)
				{
					if($a["user_last_session_date"]>$b["user_last_session_date"])
					{
						return true;
					}
					else if($a["user_last_session_date"]==$b["user_last_session_date"] && $a["user_last_session_time"]>$b["user_last_session_time"])
					{
						return true;
					}
					return false;
				}
				usort($data, "cmp");
			}
			else if($sort==3)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]>$b["user_name"]);
				}
				usort($data, "cmp");
			}
			else if($sort==4)
			{
				function cmp($a, $b)
				{
					return ($a["user_name"]<$b["user_name"]);
				}
				usort($data, "cmp");
			}
			$count=0;
			$count2=0;
			foreach($data as $r)
			{
				$count++;
				if($count<=$page) continue;
				$count2++;
				if($count2>5) break;
				$on='';
				if($r['on']>0)
					$on='<i class="fa fa-circle w3-text-light-green w3-cursor" style="font-size:9px;" title="Active session is available"></i> ';
				
				echo '<tr>
						<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$on.$r['user_name'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_designation'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_type'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.$r['user_total_session'].'</td>
						<td valign="top" class="w3-padding-small w3-border">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
						<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result13(\''.$r['user_type'].'\',\''.$r['user_id'].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
					</tr>';				
			}
		}


	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>
