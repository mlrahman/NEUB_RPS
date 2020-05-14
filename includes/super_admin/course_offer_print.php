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
	if(isset($_REQUEST['filter_course_type5']) && isset($_REQUEST['filter_semester5']) && isset($_REQUEST['sort']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['filter_status5']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$prog_id=trim($_REQUEST['prog_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status5=trim($_REQUEST['filter_status5']);
		$filter_semester5=trim($_REQUEST['filter_semester5']);
		$filter_course_type5=trim($_REQUEST['filter_course_type5']);
		$sort=trim($_REQUEST['sort']);
		
		if($sort==1)
		{
			$order_by='e.nr_course_title';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='e.nr_course_title';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='e.nr_course_code';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='e.nr_course_code';
			$order='desc';
		}
		else if($sort==5)
		{
			$order_by='a.nr_drop_semester';
			$order='asc';
		}
		else if($sort==6)
		{
			$order_by='a.nr_drop_semester';
			$order='desc';
		}
		
		$filter='';
		if($filter_status5==1)
			$filter=' and a.nr_drop_status="Active" ';
		if($filter_status5==2)
			$filter=' and a.nr_drop_status="Inactive" ';
		
		if($filter_semester5!=-1)
			$filter=$filter.' and a.nr_drop_semester="'.$filter_semester5.'"';
		
		if($filter_course_type5!=-1)
			$filter=$filter.' and a.nr_drop_remarks="'.$filter_course_type5.'"';
		
		
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
		
		
		if($prog_id==-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_drop_id, e.nr_course_title, e.nr_course_code, e.nr_course_credit, a.nr_drop_remarks, a.nr_drop_semester, c.nr_prog_title, b.nr_prcr_total, a.nr_drop_status from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) ".$filter." order by ".$order_by." ".$order);
		}
		else if($prog_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select a.nr_drop_id, e.nr_course_title, e.nr_course_code, e.nr_course_credit, a.nr_drop_remarks, a.nr_drop_semester, c.nr_prog_title, b.nr_prcr_total, a.nr_drop_status from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) and d.nr_dept_id=:dept_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($prog_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_drop_id, e.nr_course_title, e.nr_course_code, e.nr_course_credit, a.nr_drop_remarks, a.nr_drop_semester, c.nr_prog_title, b.nr_prcr_total, a.nr_drop_status from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) and a.nr_prog_id=:prog_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		else
		{
			$stmt = $conn->prepare("select a.nr_drop_id, e.nr_course_title, e.nr_course_code, e.nr_course_credit, a.nr_drop_remarks, a.nr_drop_semester, c.nr_prog_title, b.nr_prcr_total, a.nr_drop_status from nr_drop a,nr_program_credit b,nr_program c,nr_department d,nr_course e where a.nr_course_id=e.nr_course_id and (e.nr_course_code like concat('%',:search_text,'%') or e.nr_course_title like concat('%',:search_text,'%')) and a.nr_prcr_id=b.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and c.nr_dept_id=d.nr_dept_id and a.nr_prcr_id=(select e.nr_prcr_id from nr_program_credit e where e.nr_prcr_ex_date='' and e.nr_prog_id=a.nr_prog_id order by e.nr_prcr_id desc limit 1) and d.nr_dept_id=:dept_id and a.nr_prog_id=:prog_id ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $prog_id);
		}
		
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$html = $html.'<h2 style="border-bottom: 2px solid black;width:175px;">Offered Courses</h2>Total Data: '.count($result).'<table style="width:695px;border: 2px solid black;">
		<tr style="font-weight:bold;">
			<td style="width:7%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
			<td style="width:28%;border: 2px solid black;padding:2px;" valign="top">Course Title</td>
			<td style="width:12%;border: 2px solid black;padding:2px;" valign="top">Course Code</td>
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Course Credit</td>
			<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">Course Type</td>
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Offer Semester</td>
			<td style="width:15%;border: 2px solid black;padding:2px;" valign="top">Offer Program</td>
			<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">Program Credit</td>
		</tr>';
		
		
		if(count($result)!=0)
		{
			$sz=count($result);
			for($i=0;$i<$sz;$i++)
			{
				$col='';
				if($result[$i][8]=='Inactive')
				{
					$col='background:#ffdddd;';
				}
				$html=$html.'<tr style="'.$col.'" title="Status '.$result[$i][8].'">
						<td valign="top" style="padding:2px;border: 2px solid black;">'.($i+1).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][1].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][2].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.number_format($result[$i][3],2).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][4].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_semester_format($result[$i][5]).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][6].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][7].'</td>
					</tr>';				
			}
		}
		else
			$html=$html.'<tr><td colspan="8"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
		
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