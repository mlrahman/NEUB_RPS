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
	if(isset($_REQUEST['filter_status']) && isset($_REQUEST['filter_degree']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['prog_id']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$program_id=trim($_REQUEST['prog_id']);
		$admin_id=trim($_REQUEST['admin_id']);
		$filter_degree=trim($_REQUEST['filter_degree']);
		$filter_status=trim($_REQUEST['filter_status']);
		$dept_id=trim($_REQUEST['dept_id']);
		$sort=trim($_REQUEST['sort']);
		$search_text=trim($_REQUEST['search_text']);
		$filter='';
		$filter='';
		if($filter_degree==1)
		{
			$filter='and b.nr_studi_graduated=1';
		}
		else if($filter_degree==2)
		{
			$filter='and b.nr_studi_dropout=1';
		}
		if($filter_status==1)
		{
			$filter=$filter.' and a.nr_stud_status="Active"';
		}
		else if($filter_status==2)
		{
			$filter=$filter.' and a.nr_stud_status="Inactive"';
		}
		if($sort==1)
		{
			$order_by='a.nr_stud_id';
			$order='asc';
		}
		else if($sort==2)
		{
			$order_by='a.nr_stud_id';
			$order='desc';
		}
		else if($sort==3)
		{
			$order_by='a.nr_stud_name';
			$order='asc';
		}
		else if($sort==4)
		{
			$order_by='a.nr_stud_name';
			$order='desc';
		}
		else if($sort==5)
		{
			$order_by='b.nr_studi_earned_credit';
			$order='asc';
		}
		else if($sort==6)
		{
			$order_by='b.nr_studi_earned_credit';
			$order='desc';
		}
		else if($sort==7)
		{
			$order_by='b.nr_studi_waived_credit';
			$order='asc';
		}
		else if($sort==8)
		{
			$order_by='b.nr_studi_waived_credit';
			$order='desc';
		}
		else if($sort==9)
		{
			$order_by='b.nr_studi_cgpa';
			$order='asc';
		}
		else if($sort==10)
		{
			$order_by='b.nr_studi_cgpa';
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
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status,a.nr_stud_cell_no from nr_student a,nr_student_info b,nr_program_credit c where a.nr_stud_id=b.nr_stud_id ".$filter." and a.nr_prcr_id=c.nr_prcr_id and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order);
		}
		else if($program_id==-1 && $dept_id!=-1)
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status,a.nr_stud_cell_no from nr_student a,nr_student_info b,nr_program_credit c where a.nr_stud_id=b.nr_stud_id ".$filter." and a.nr_prcr_id=c.nr_prcr_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order);
			$stmt->bindParam(':dept_id', $dept_id);
		}
		else if($program_id!=-1 && $dept_id==-1)
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status,a.nr_stud_cell_no from nr_student a,nr_student_info b,nr_program_credit c where a.nr_prog_id=:prog_id ".$filter." and a.nr_stud_id=b.nr_stud_id and a.nr_prcr_id=c.nr_prcr_id and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order);
			$stmt->bindParam(':prog_id', $program_id);
		}
		else
		{
			$stmt = $conn->prepare("select a.nr_stud_id,a.nr_stud_name,b.nr_studi_earned_credit,b.nr_studi_waived_credit,c.nr_prcr_total,b.nr_studi_cgpa,a.nr_stud_status,a.nr_stud_cell_no from nr_student a,nr_student_info b,nr_program_credit c where a.nr_prog_id=:prog_id ".$filter." and a.nr_stud_id=b.nr_stud_id and a.nr_prcr_id=c.nr_prcr_id and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and (a.nr_stud_id LIKE CONCAT('%',:search_text,'%') or a.nr_stud_name LIKE CONCAT('%',:search_text,'%')) order by ".$order_by." ".$order);
			$stmt->bindParam(':dept_id', $dept_id);
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':search_text', $search_text);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$html = $html.'<h2 style="border-bottom: 2px solid black;width:95px;">Students</h2>Total Data: '.count($result).'<table style="width:695px;border: 2px solid black;">
		<tr style="font-weight:bold;">
			<td style="width:7%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
			<td style="width:8%;border: 2px solid black;padding:2px;" valign="top">Student ID</td>
			<td style="width:24%;border: 2px solid black;padding:2px;" valign="top">Name</td>
			<td style="width:17%;border: 2px solid black;padding:2px;" valign="top">Session</td>
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Credit Earned</td>
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Credit Waived</td>
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">Program Credit</td>
			<td style="width:7%;border: 2px solid black;padding:2px;" valign="top">CGPA</td>
			<td style="width:10%;border: 2px solid black;padding:2px;" valign="top">Mobile</td>
		</tr>';
		
		if(count($result)>0)
		{
			$sz=count($result);
			for($i=0;$i<$sz;$i++)
			{
				$wc=$result[$i][3];
				if($wc==0)
					$wc='N/A';
				$col='';
				if($result[$i][6]=='Inactive')
					$col='background:#ffdddd;';
				$html=$html.'<tr style="'.$col.'" title="Status '.$result[$i][6].'">
						<td valign="top" style="padding:2px;border: 2px solid black;">'.($i+1).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][0].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][1].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_session($result[$i][0]).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][2].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$wc.'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][4].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.number_format($result[$i][5],2).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][7].'</td>
						
					</tr>';
			}
		
		}
		else
			$html=$html.'<tr><td colspan="9"><p style="text-align:center;color:red;margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
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