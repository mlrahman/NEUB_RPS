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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['user_type']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['program_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$dept_id=trim($_REQUEST['dept_id']);
		$program_id=trim($_REQUEST['program_id']);
		$user_type=trim($_REQUEST['user_type']);
		$sort=trim($_REQUEST['sort']);
		
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and d.nr_admin_type!='Super Admin' ";
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
						
						
		
		
		
		$data=array();
		
		if($user_type==-1) //All - student,faculty,moderator,admin,super admin
		{
			
			//student 
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b where a.nr_stud_id=b.nr_stud_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][0],'user_type'=>'Student','user_name'=>$result[$i][11],'user_search_date'=>$result[$i][7],'user_search_time'=>$result[$i][8]);
				}
			}
			
			//faculty
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>'Faculty','user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
			
			//moderator admin super_admin
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
			
		}
		else if($user_type==1) //Student
		{
			//student 
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b where a.nr_stud_id=b.nr_stud_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>'Student','user_name'=>$result[$i][11],'user_search_date'=>$result[$i][7],'user_search_time'=>$result[$i][8]);
				}
			}
			
		}
		else if($user_type==2) //Faculty
		{
			//faculty
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>'Faculty','user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		else if($user_type==3) //moderator
		{
			$filter=" and d.nr_admin_type='Moderator' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		else if($user_type==4) //admin
		{
			$filter=" and d.nr_admin_type='Admin' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		else if($user_type==5 && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$filter=" and d.nr_admin_type='Super Admin' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		if($sort==2)
		{
			function cmp($a, $b)
			{
				if($a["student_id"]<$b["student_id"])
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
				if($a["student_id"]>$b["student_id"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==4)
		{
			function cmp($a, $b)
			{
				if($a["user_name"]<$b["user_name"])
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
				if($a["user_name"]>$b["user_name"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==6)
		{
			function cmp($a, $b)
			{
				if($a["user_search_date"]<$b["user_search_date"])
				{
					return true;
				}
				else if($a["user_search_date"]==$b["user_search_date"] && $a["user_search_time"]<$b["user_search_time"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==5)
		{
			function cmp($a, $b)
			{
				if($a["user_search_date"]>$b["user_search_date"])
				{
					return true;
				}
				else if($a["user_search_date"]==$b["user_search_date"] && $a["user_search_time"]>$b["user_search_time"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		$count=0;
		$html = $html.'<h2 style="border-bottom: 2px solid black;width:170px;">Search Records</h2>Total Data: '.count($data).'<table style="width:695px;border: 2px solid black;">
		<tr style="font-weight:bold;">
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
			<td style="width:20%;border: 2px solid black;padding:2px;" valign="top">Student ID</td>
			<td style="width:30%;border: 2px solid black;padding:2px;" valign="top">Searched By</td>
			<td style="width:11%;border: 2px solid black;padding:2px;" valign="top">User Role</td>
			<td style="width:18%;border: 2px solid black;padding:2px;" valign="top">Date</td>
			<td style="width:12%;border: 2px solid black;padding:2px;" valign="top">Time</td>
		</tr>';
		
		foreach($data as $r)
		{
			$html=$html.'<tr>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.++$count.'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['student_id'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_name'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_type'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($r['user_search_date']).'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$r['user_search_time'].'</td>
				</tr>';				
		}
		if($count==0)
			$html=$html. '<tr><td colspan="6"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
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
