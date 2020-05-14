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
	if(isset($_REQUEST['filter_instructor']) && isset($_REQUEST['filter_status']) && isset($_REQUEST['filter_semester']) && isset($_REQUEST['filter_grade']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['program_id']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$program_id=trim($_REQUEST['program_id']);
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$sort=trim($_REQUEST['sort']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_grade=trim($_REQUEST['filter_grade']);
		$filter_status=trim($_REQUEST['filter_status']);
		
		if($filter_grade!='-1')
			$filter_grade=get_filter_grade($filter_grade);
		$filter_semester=trim($_REQUEST['filter_semester']);
		$filter_instructor=trim($_REQUEST['filter_instructor']);
		$filter='';
		if($filter_instructor!=-1)
			$filter=' and d.nr_faculty_id='.$filter_instructor;
		if($filter_status!=-1)
			$filter=$filter.' and a.nr_result_status="'.$filter_status.'"';
		
		if($sort==1)
		{
			$order_by='a.nr_result_id';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='a.nr_result_id';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='c.nr_stud_id';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='c.nr_stud_id';
			$order='desc';
		}
		else if($sort==5)
		{
			$order_by='b.nr_course_code';
			$order='asc';
		}
		else if($sort==6)
		{
			$order_by='b.nr_course_code';
			$order='desc';
		}
		else if($sort==7)
		{
			$order_by='b.nr_course_title';
			$order='asc';
		}
		else if($sort==8)
		{
			$order_by='b.nr_course_title';
			$order='desc';
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
		
		if($program_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $program_id);
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c,nr_faculty d where a.nr_prog_id=:prog_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_faculty_id=d.nr_faculty_id and c.nr_stud_id=a.nr_stud_id and (c.nr_stud_id LIKE CONCAT('%',:search_text,'%') or c.nr_stud_name LIKE CONCAT('%',:search_text,'%') or b.nr_course_code LIKE CONCAT('%',:search_text,'%') or b.nr_course_title LIKE CONCAT('%',:search_text,'%')) and a.nr_course_id=b.nr_course_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $program_id);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$tot_c=0;
		if(count($result)>0)
		{
			$sz=count($result);
			$xyz=array();
			for($kk=0;$kk<$sz;$kk++)
			{
				//individual course result
				$r_id=$result[$kk][0];
				$r_status=$result[$kk][9];
				$s_id=$result[$kk][1];
				$semester=$result[$kk][6].'-'.$result[$kk][7];
				$course_code=$result[$kk][14];
				$course_title=$result[$kk][15];
				$course_credit=$result[$kk][16];
				$course_grade=grade_decrypt($s_id,$result[$kk][4]);
				$remarks=$result[$kk][8];
				
				$fl=0;
				if($filter_grade!='-1' && $filter_semester!='-1')
				{
					if($filter_grade==$course_grade && $filter_semester==$semester)
						$fl=1;
				}
				else if($filter_grade!='-1' && $filter_semester=='-1')
				{
					if($filter_grade==$course_grade)
						$fl=1;
				}
				else if($filter_grade=='-1' && $filter_semester!='-1')
				{
					if($filter_semester==$semester)
						$fl=1;
				}
				else if($filter_grade=='-1' && $filter_semester=='-1')
				{
					$fl=1;
				}
				if($fl==1)
				{
					$tot_c++;
					$xyz[$r_id]=array('r_id'=>$r_id,'s_id'=>$s_id,'semester'=>$semester,'course_code'=>$course_code,'course_title'=>$course_title,'course_credit'=>$course_credit,'course_grade'=>$course_grade,'r_status'=>$r_status,'remarks'=>$remarks);
				}
			}
			
			$html = $html.'<h2 style="border-bottom: 2px solid black;width:80px;">Results</h2>Total Data: '.$tot_c.'<table style="width:695px;border: 2px solid black;">
				<tr style="font-weight:bold;">
					<td style="width:7%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
					<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Semester</td>
					<td style="width:13%;border: 2px solid black;padding:2px;" valign="top">Student ID</td>
					<td style="width:11%;border: 2px solid black;padding:2px;" valign="top">Course Code</td>
					<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Course Title</td>
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">Credit</td>
					<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">Grade</td>
					<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">Remarks</td>
				</tr>';
			
			$i=1;
			$count=0;
			foreach($xyz as $xy)
			{
				$count++;
				$col='';
				$col2='';
				if($xy['course_grade']=='F') $col='color:red;';
				if($xy['r_status']=='Inactive') $col2='background:#ffdddd;';
				$html=$html.'<tr style="'.$col.' '.$col2.'">
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$i++.'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$xy['semester'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$xy['s_id'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$xy['course_code'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$xy['course_title'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.number_format($xy['course_credit'],2).'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$xy['course_grade'].'</td>
					<td valign="top" style="padding:2px;border: 2px solid black;">'.$xy['remarks'].'</td>
					
				</tr>';
			}
			if($count==0)
				$html=$html. '<tr><td colspan="8"><p style="text-align:center;color:red;margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
		}
		else
			$html=$html.'<tr><td colspan="8"><p style="text-align:center;color:red;margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
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
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>