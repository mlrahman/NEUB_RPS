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
	if(isset($_REQUEST['time']) && isset($_REQUEST['date']) && isset($_REQUEST['s_id']) && isset($_REQUEST['user_type']) && isset($_REQUEST['user_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$user_type=trim($_REQUEST['user_type']);
		$user_id=trim($_REQUEST['user_id']);
		$s_id=trim($_REQUEST['s_id']);
		$date=trim($_REQUEST['date']);
		$time=trim($_REQUEST['time']);
		if($user_type=='Super Admin' && $_SESSION['admin_type']!='Super Admin')
		{
			echo '<i class="fa fa-warning w3-text-red" title="Unknown Error Occurred!!"> Unknown Error Occurred</i>';
			die();
		}
		
		if($user_type=='Student')
		{
			$stmt = $conn->prepare("select * from nr_result_check_transaction where nr_rechtr_date=:date and nr_rechtr_time=:time and nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':date', $date);
			$stmt->bindParam(':time', $time);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$ip_address=$result[0][1];
			$country=$result[0][2];
			$city=$result[0][3];
			$lat=$result[0][4];
			$lng=$result[0][5];
			$timezone=$result[0][6];
		
		}
		else if($user_type=='Faculty')
		{
			$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction where nr_rechtr_date=:date and nr_rechtr_time=:time and nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':date', $date);
			$stmt->bindParam(':time', $time);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$ip_address=$result[0][2];
			$country=$result[0][3];
			$city=$result[0][4];
			$lat=$result[0][5];
			$lng=$result[0][6];
			$timezone=$result[0][7];
		
		}
		else 
		{
			$stmt = $conn->prepare("select * from nr_admin_result_check_transaction where nr_rechtr_date=:date and nr_rechtr_time=:time and nr_stud_id=:s_id ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':date', $date);
			$stmt->bindParam(':time', $time);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$ip_address=$result[0][2];
			$country=$result[0][3];
			$city=$result[0][4];
			$lat=$result[0][5];
			$lng=$result[0][6];
			$timezone=$result[0][7];
		
		}
		$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id ");
		$stmt->bindParam(':s_id', $s_id);
		$stmt->execute();
		$result2 = $stmt->fetchAll();
		$role=$user_type;
		$photo=$result2[0][6];
		$gender=$result2[0][3];
		$name=$result2[0][1];
		$reg_no=$result2[0][0];
		$session=get_session($reg_no);
		$birthdate=$result2[0][2];
		
		
		
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
							<td valign="top">Search Date</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo get_date($date); ?></td>
						</tr>
						<tr>
							<td valign="top">Search Time</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo $time; ?></td>
						</tr>
						
					</table>
				</div>
			</div>
			<table style="width:100%;" class="w3-margin-bottom">
				<tr>
					<td valign="top" style="width:140px;">Searched By</td>
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