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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['program_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['sort']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$user_type=trim($_REQUEST['user_type']);
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
		
		$dept_id=trim($_REQUEST['dept_id']);
		$program_id=trim($_REQUEST['program_id']);
		
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and nr_trprre_printed_by!='Super Admin' ";
		}
		
		if($user_type==-1) //all
		{
		
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' ".$filter." order by ".$order_by." ".$order." ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' ".$filter." order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' ".$filter." order by ".$order_by." ".$order." ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' ".$filter." order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			
		}
		else if($user_type==1) //student
		{
			$user_ty='Student';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==2) //Faculty
		{
			$user_ty='Faculty';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==3) //Moderator
		{
			$user_ty='Moderator';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==4) //Admin
		{
			$user_ty='Admin';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==5  && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$user_ty='Super Admin';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type order by ".$order_by." ".$order." ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$html = $html.'<h2 style="border-bottom: 2px solid black;width:210px;">Transcript Records</h2>Total Data: '.count($result).'<table style="width:695px;border: 2px solid black;">
		<tr style="font-weight:bold;">
			
			<td style="width:9%;border: 2px solid black;padding:2px;" valign="top">S.L. No</td>
			<td style="width:20%;border: 2px solid black;padding:2px;" valign="top">Ref. No.</td>
			<td style="width:30%;border: 2px solid black;padding:2px;" valign="top">Printed By</td>
			<td style="width:14%;border: 2px solid black;padding:2px;" valign="top">User Role</td>
			<td style="width:16%;border: 2px solid black;padding:2px;" valign="top">Date</td>
			<td style="width:11%;border: 2px solid black;padding:2px;" valign="top">Time</td>
			
		</tr>';
		
		
		if(count($result)>0)
		{
			$sz=count($result);
			$count=0;
			for($i=0;$i<$sz;$i++)
			{
				
				
				$role=$result[$i][1];
				$ref=$result[$i][11];
				$ref_t="'".$ref."'";
				$user_id=$result[$i][2];
				$user_id_t="'".$user_id."'";
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
						$html=$html.'<tr>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$ref.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$t_result[0][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$role.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$date.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$time.'</td>
							</tr>';
						
					}
					else if($search_text=='')
					{
						$count++;
						
						$html=$html. '<tr>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$ref.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$t_result[0][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$role.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$date.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$time.'</td>
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
						
						$html=$html. '<tr>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$ref.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$t_result[0][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$role.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$date.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$time.'</td>
							</tr>';
						
					}
					else if($search_text=='')
					{
						$count++;
						
						$html=$html. '<tr>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$ref.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$t_result[0][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$role.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$date.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$time.'</td>
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
						
						$html=$html. '<tr>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$ref.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$t_result[0][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$role.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$date.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$time.'</td>
							</tr>';
						
					}
					else if($search_text=='')
					{
						$count++;
						
						$html=$html. '<tr>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$count.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$ref.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$t_result[0][1].'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$role.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$date.'</td>
							<td valign="top" style="padding:2px;border: 2px solid black;">'.$time.'</td>
							</tr>';
					}
				}
			}
			if($count==0)
				$html=$html. '<tr><td colspan="6"><p style="text-align:center;color:red;margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
			
		}
		else
			$html=$html. '<tr><td colspan="6"><p style="text-align:center;color:red;margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
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
