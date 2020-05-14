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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$user_type=trim($_REQUEST['user_type']);
		$sort=trim($_REQUEST['sort']);
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and b.nr_admin_type!='Super Admin' ";
		}
		
		$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
		$stmt->execute();
		$result_t = $stmt->fetchAll();
		
		if(count($result_t)==0)
		{
			echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
			die();
		}
		
		$title=$result_t[0][2];
		$caption=$result_t[0][3];
		$address=$result_t[0][4];
		$telephone=$result_t[0][5];
		$email=$result_t[0][6];
		$mobile=$result_t[0][7];
		$web=$result_t[0][8];
		$contact_email=$result_t[0][9];
		$map=$result_t[0][10];
		$logo=$result_t[0][13];
		$video_alt=$result_t[0][14];
		$video=$result_t[0][15];
		$html='
			<head>
				<style>
				
				.page-header, .page-header-space {
				  height: 90px;
				}

				.page-footer, .page-footer-space {
				  height: 50px;
				  margin-top:10px;
				}

				.page-footer {
				  position: fixed;
				  bottom: 0;
				  width: 700px;
				  background:white;
				}

				.page-header {
				  position: fixed;
				  top: 0mm;
				  width: 700px;
				  margin:0px;
				  background:white;
				}

				.page {
				  page-break-inside: avoid;
				  
				}

				@page {
				  margin: 6mm 15mm 6mm 15mm;
				  
				}
				
				@media print {
				   thead {display: table-header-group;} 
				   tfoot {display: table-footer-group;}
				   
				   
				   body {margin: 0;}
				}
				
				</style>
			</head>
			<html>
				<body onclick="document.getElementById(\'content\').innerHTML=\'\';window.close();"  style="font-family: "Century Schoolbook", sans-serif;font-size:12px;"><div id="content">
					<div class="page-header" style="text-align: center;">
						<div style="border-bottom: 3px solid black;">
							<div style="height:75px;">
								<div style="width:65px;padding:0px;margin:0px;float:left;">
									<img src="../../images/system/'.$logo.'" alt="NEUB LOGO" style="width:68px;height:70px;">
								</div>
								<div style="width:630px;float:left;padding:0px;margin:0px;">
									<p style="padding: 0px;margin:10px 0px 5px 0px;font-size:25px;font-weight:bold;margin-left:8px;">NORTH EAST UNIVERSITY BANGLADESH (NEUB)</p>
									<p style="margin:0px;padding:0px;font-size: 22px;font-weight:bold;text-align:center;">SYLHET, BANGLADESH.</p>
								</div>
							</div>
						</div>
						
					</div>

					<div class="page-footer">
						<div style="border-top:3px solid black;margin: 0px;padding:0px;width:700px;text-align:center;">
							<p style="margin:0px;padding:0px;font-size:12px;">Address: '.$address.'</p>
							<p style="margin:0px;padding:0px;font-size:12px;">Phone: '.$telephone.', Fax: 0821-710223, Mobile: '.$mobile.', E-mail: '.$email.'</p>
							<p style="margin:0px;padding:0px;font-size:12px;">Website: '.$web.'</p>
						</div>
					</div>
					<table>

					<thead>
					  <tr>
						<td>
						  <!--place holder for the fixed-position header-->
						  <div class="page-header-space"></div>
						</td>
					  </tr>
					</thead>

					<tbody>
					  <tr>
						<td>';
						
		
		
	
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
			
			$html = $html.'<h2 style="border-bottom: 2px solid black;width:175px;">Session Records</h2>Total Data: '.count($data).'<table style="width:695px;border: 2px solid black;">
				<tr style="font-weight:bold;">
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
					<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Name</td>
					<td style="width:19%;border: 2px solid black;padding:2px;" valign="top">Designation</td>
					<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">User Type</td>
					<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Total Session</td>
					<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Last Session</td>
				</tr>';
			
			$count=0;
			foreach($data as $r)
			{
				$count++;
				
				$on='';
				if($r['on']>0)
					$on='(Online) ';$html=$html.'<tr>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$on.$r['user_name'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_designation'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_type'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_total_session'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
					</tr>';				
			}
			if($count==0)
			{
				echo '<tr><td colspan="6"><p style="margin: 10px 0px 10px 0px;text-align:center;color:red;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
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
			$html = $html.'<h2 style="border-bottom: 2px solid black;width:175px;">Session Records</h2>Total Data: '.count($data).'<table style="width:695px;border: 2px solid black;">
				<tr style="font-weight:bold;">
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
					<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Name</td>
					<td style="width:19%;border: 2px solid black;padding:2px;" valign="top">Designation</td>
					<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">User Type</td>
					<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Total Session</td>
					<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Last Session</td>
				</tr>';
			foreach($data as $r)
			{
				$count++;
				$on='';
				if($r['on']>0)
					$on='(Online) ';
				$html=$html.'<tr>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$on.$r['user_name'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_designation'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_type'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_total_session'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
					</tr>';				
			}
			if($count==0)
				$html=$html.'<tr><td colspan="6"><p style="margin: 10px 0px 10px 0px;text-align:center;color:red;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
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
			$html = $html.'<h2 style="border-bottom: 2px solid black;width:175px;">Session Records</h2>Total Data: '.count($data).'<table style="width:695px;border: 2px solid black;">
				<tr style="font-weight:bold;">
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
					<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Name</td>
					<td style="width:19%;border: 2px solid black;padding:2px;" valign="top">Designation</td>
					<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">User Type</td>
					<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Total Session</td>
					<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Last Session</td>
				</tr>';
			foreach($data as $r)
			{
				$count++;
				
				$on='';
				if($r['on']>0)
					$on='(Online) ';
				$html=$html.'<tr>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$on.$r['user_name'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_designation'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_type'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_total_session'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
					</tr>';				
			}
			if($count==0)
				$html=$html. '<tr><td colspan="6"><p style="margin: 10px 0px 10px 0px;text-align:center;color:red;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
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
			$html = $html.'<h2 style="border-bottom: 2px solid black;width:175px;">Session Records</h2>Total Data: '.count($data).'<table style="width:695px;border: 2px solid black;">
				<tr style="font-weight:bold;">
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
					<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Name</td>
					<td style="width:19%;border: 2px solid black;padding:2px;" valign="top">Designation</td>
					<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">User Type</td>
					<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Total Session</td>
					<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Last Session</td>
				</tr>';
			foreach($data as $r)
			{
				$count++;
				
				$on='';
				if($r['on']>0)
					$on='(Online) ';
				$html=$html.'<tr>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$on.$r['user_name'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_designation'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_type'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_total_session'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
					</tr>';				
			}
			if($count==0)
				$html=$html.'<tr><td colspan="6"><p style="margin: 10px 0px 10px 0px;text-align:center;color:red;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
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
			$html = $html.'<h2 style="border-bottom: 2px solid black;width:175px;">Session Records</h2>Total Data: '.count($data).'<table style="width:695px;border: 2px solid black;">
				<tr style="font-weight:bold;">
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
					<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Name</td>
					<td style="width:19%;border: 2px solid black;padding:2px;" valign="top">Designation</td>
					<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">User Type</td>
					<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Total Session</td>
					<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Last Session</td>
				</tr>';
			foreach($data as $r)
			{
				$count++;
				
				$on='';
				if($r['on']>0)
					$on='(Online) ';
				$html=$html. '<tr>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$on.$r['user_name'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_designation'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_type'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_total_session'].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($r['user_last_session_date']).' at '.$r['user_last_session_time'].'</td>
					</tr>';				
			}
			if($count==0)
				$html=$html.'<tr><td colspan="6"><p style="margin: 10px 0px 10px 0px;text-align:center;color:red;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
		}

		$html=$html.'</table>
						</td>
					  </tr>
					</tbody>

					<tfoot>
					  <tr>
						<td>
						  <!--place holder for the fixed-position footer-->
						  <div class="page-footer-space"></div>
						</td>
					  </tr>
					</tfoot>

				  </table></div></body>
			</html>';
			
		echo $html;
		
		
		?>
			
			<script>
				window.print();
				window.onfocus=setTimeout(function(){window.close()},300);
			</script>
			
		<?php
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>
