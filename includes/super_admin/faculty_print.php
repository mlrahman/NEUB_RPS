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
	if(isset($_REQUEST['filter_type7']) && isset($_REQUEST['sort']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['filter_status7']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$dept_id=trim($_REQUEST['dept_id']);
		$search_text=trim($_REQUEST['search_text']);
		$filter_status7=trim($_REQUEST['filter_status7']);
		$filter_type7=trim($_REQUEST['filter_type7']);
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
		
		
		
		if($dept_id==-1)
		{
			$stmt = $conn->prepare("select nr_faculty_id,nr_faculty_name,nr_faculty_designation,nr_faculty_type,nr_faculty_join_date,nr_faculty_status,nr_faculty_cell_no from nr_faculty where (nr_faculty_name like concat('%',:search_text,'%') or nr_faculty_designation like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':search_text', $search_text); 
		}
		else
		{
			$stmt = $conn->prepare("select nr_faculty_id,nr_faculty_name,nr_faculty_designation,nr_faculty_type,nr_faculty_join_date,nr_faculty_status,nr_faculty_cell_no from nr_faculty where nr_dept_id=:dept_id and (nr_faculty_name like concat('%',:search_text,'%') or nr_faculty_designation like concat('%',:search_text,'%')) ".$filter." order by ".$order_by." ".$order);
			$stmt->bindParam(':search_text', $search_text);
			$stmt->bindParam(':dept_id', $dept_id);

		}			
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$html = $html.'<h2 style="border-bottom: 2px solid black;width:190px;">Faculty Members</h2>Total Data: '.count($result).'<table style="width:695px;border: 2px solid black;">
		<tr style="font-weight:bold;">
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
			<td style="width:29%;border: 2px solid black;padding:2px;" valign="top">Faculty Name</td>
			<td style="width:20%;border: 2px solid black;padding:2px;" valign="top">Designation</td>
			<td style="width:12%;border: 2px solid black;padding:2px;" valign="top">Type</td>
			<td style="width:14%;border: 2px solid black;padding:2px;" valign="top">Join Date</td>
			<td style="width:16%;border: 2px solid black;padding:2px;" valign="top">Mobile</td>
		
		</tr>';
		
		if(count($result)!=0)
		{
			$sz=count($result);
			for($i=0;$i<$sz;$i++)
			{
				$col='';
				if($result[$i][5]=='Inactive')
				{
					$col='background:#ffdddd;';
				}
				$html=$html.'<tr class="'.$col.'" title="Status '.$result[$i][5].'">
						<td valign="top" style="padding:2px;border: 2px solid black;">'.($i+1).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][1].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][2].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][3].'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($result[$i][4]).'</td>
						<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][6].'</td>
					</tr>';				
			}
		}
		else
			$html=$html.'<tr><td colspan="6"><p style="text-align:center;color:right;margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
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