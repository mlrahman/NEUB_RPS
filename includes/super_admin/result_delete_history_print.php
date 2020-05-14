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
	if(isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		
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
		
		
		$stmt = $conn->prepare("select * from nr_delete_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_deleteh_type='Result' order by a.nr_deleteh_date desc,a.nr_deleteh_time desc ");
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$html = $html.'<h2 style="border-bottom: 2px solid black;width:245px;">Result Remove History</h2>Total Data: '.count($result).'<table style="width:695px;border: 2px solid black;">
			<tr style="font-weight:bold;">
				<td style="width:10%;border: 2px solid black;padding:2px;" valign="top" >S.L. No</td>
				<td style="width:40%;border: 2px solid black;padding:2px;" valign="top" >Performed Action</td>
				<td style="width:20%;border: 2px solid black;padding:2px;" valign="top" >Performed By</td>
				<td style="width:15%;border: 2px solid black;padding:2px;" valign="top" >Date</td>
				<td style="width:15%;border: 2px solid black;padding:2px;" valign="top" >Time</td>
			</tr>';
			
				
				if(count($result)==0)
				{
					$html=$html.'<tr>
						<td colspan="5"> <p style="text-align:center;color:red;"><i class="fa fa-warning" title="No Data Available"> No Data Available.</i></p></td>
					</tr>';
				}
				else
				{
					$sz=count($result);
					for($i=0;$i<$sz;$i++)
					{
			
						$html=$html.'<tr style="text-align:center;">
							<td valign="top" style="padding:2px;border: 2px solid black;">'.($i+1).'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;font-size:11px;">'.$result[$i][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;font-size:11px;">'.$result[$i][7].' <b>('.$result[$i][12].')</b>, '.$result[$i][13].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.get_date($result[$i][2]).'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$result[$i][3].'</td>
						</tr>';
			
					}
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