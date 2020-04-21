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
	if(isset($_REQUEST['ref']) && isset($_REQUEST['user_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$ref=trim($_REQUEST['ref']);
		$user_id=trim($_REQUEST['user_id']);
		$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_reference=:ref and nr_trprre_user_id=:u_id and nr_trprre_status='Active' ");
		$stmt->bindParam(':ref', $ref);
		$stmt->bindParam(':u_id', $user_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if(count($result)==0)
		{
			echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Data not found"><i class="fa fa-warning"></i> Data not found.</p>';
			die();
		}
		else
		{
			$s_id=$result[0][0];
			$ip_address=$result[0][3];
			$country=$result[0][4];
			$city=$result[0][5];
			$lat=$result[0][6];
			$lng=$result[0][7];
			$timezone=$result[0][8];
			$date=get_date($result[0][9]);
			$time=$result[0][10];
			$role=$result[0][1];
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$result2 = $stmt->fetchAll();
			
			if(count($result2)==0)
			{
				echo '<p class="w3-center w3-text-red" style="margin: 50px 0px 50px 0px;" title="Data not found"><i class="fa fa-warning"></i> Data not found.</p>';
				die();
			}
			$photo=$result2[0][6];
			$gender=$result2[0][3];
			$name=$result2[0][1];
			$reg_no=$result2[0][0];
			$session=get_session($reg_no);
			$birthdate=$result2[0][2];
			
			
		}
?>
		<div class="w3-row w3-border-teal w3-bottombar">
				<!--part 1 -->
				<div class="w3-half w3-container w3-padding-0">
					<div class="w3-row w3-padding-0">
						<div class="w3-col w3-container w3-padding-0 w3-margin-0" style="width:110px;">
							<?php if($photo=="" && $gender=="Male"){ ?>
									<img src="../images/system/male_profile.png" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
							<?php } else if($photo==""){ ?>
									<img src="../images/system/female_profile.png" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
							<?php } else { ?>
									<img src="../images/student/<?php echo $photo; ?>" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
							<?php } ?>
						</div>
						<div class="w3-rest w3-container w3-padding-0 w3-margin-0" style="min-width:200px;">
							<table>
								<tr>
									<td valign="top">Name</td>
									<td valign="top" class="w3-bold">: <?php echo $name; ?></td>
								</tr>
								<tr>
									<td valign="top">Reg. No</td>
									<td valign="top" class="w3-bold">: <?php echo $reg_no; ?></td>
								</tr>
								<tr>
									<td valign="top">Session</td>
									<td valign="top">: <?php echo $session; ?></td>
								</tr>
								<tr>
									<td valign="top">Gender</td>
									<td valign="top">: <?php echo $gender; ?></td>
								</tr>
								<tr>
									<td valign="top">Birthdate</td>
									<td valign="top">: <?php echo get_date($birthdate); ?></td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
				<!-- part 2 -->
				<div class="w3-half w3-container w3-padding-0">
					<table style="width:100%;">
						<tr>
							<td valign="top">Ref. No.</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-purple">: <b><?php echo $ref; ?></b></td>
						</tr>
						<tr>
							<td valign="top">Print Date</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo $date; ?></td>
						</tr>
						<tr>
							<td valign="top">Print Time</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo $time; ?></td>
						</tr>
						
					</table>
				</div>
			</div>
			<table style="width:100%;" class="w3-margin-bottom">
				<tr>
					<td valign="top" style="width:140px;">Printed By</td>
					<td colspan="2" valign="top">: 
					<?php 
						if($role=='Student'){ echo '<span class="w3-text-blue w3-bold">Self</span>'; }
						else if($role=='Faculty'){
							$stmt = $conn->prepare("select * from nr_faculty a, nr_department b where a.nr_dept_id=b.nr_dept_id and nr_faculty_id=:u_id ");
							$stmt->bindParam(':u_id', $user_id);
							$stmt->execute();
							$result3 = $stmt->fetchAll();
							$name=$result3[0][1];
							$designation=$result3[0][2];
							$type=$result3[0][5];
							$department=$result3[0][15];
							echo '<span class="w3-text-blue w3-bold">'.$name.'</span> ('.$type.' Faculty)';
						}
						else
						{
							$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:u_id ");
							$stmt->bindParam(':u_id', $user_id);
							$stmt->execute();
							$result4 = $stmt->fetchAll();
							$name=$result4[0][1];
							$designation=$result4[0][7];
							echo '<span class="w3-text-blue w3-bold">'.$name.'</span>';
						}
					?>
					</td>
				</tr>
				<?php
					if($role!='Student'){
				?>
				<tr>
					<td valign="top" style="width:140px;">User Role</td>
					<td colspan="2" valign="top">: <b><?php echo $role; ?></b></td>
				</tr>
				<tr>
					<td valign="top">Designation</td>
					<td colspan="2" valign="top">: 
						<?php
							if($role=='Faculty'){
								echo '<b>'.$designation.'</b></br>&nbsp;&nbsp;Department of '.$department;
							}
							else
							{
								echo '<b>'.$designation.'</b>';
							}
						?>
					</td>
				</tr>
				<?php
					}
				?>
				<tr>
					<td valign="top">IP Address</td>
					<td colspan="2" valign="top" class="w3-text-red w3-bold">: <?php echo $ip_address; ?></td>
				</tr>
				<tr>
					<td valign="top">Country</td>
					<td colspan="2" valign="top" class="w3-text-brown">: <?php echo $country; ?></td>
				</tr>
				<tr>
					<td valign="top">City</td>
					<td colspan="2" valign="top" class="w3-text-brown">: <?php echo $city; ?></td>
				</tr>
				<tr>
					<td valign="top">(Lat, Lng)</td>
					<td valign="top" class="">: <a title="Click here to view it on google map." href="https://www.google.com/maps?q=<?php echo $lat; ?>,<?php echo $lng; ?>" target="_blank" class="w3-decoration-null w3-bold w3-text-blue"><?php echo '('.$lat.', '.$lng.')'; ?></a></td>
				</tr>
				<tr>
					<td valign="top">Timezone</td>
					<td valign="top" class="">: <?php echo $timezone; ?></td>
				</tr>
			
			</table>


<?php	
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';
	}
?>