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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['user_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$user_type=trim($_REQUEST['user_type']);
		$user_id=trim($_REQUEST['user_id']);
		if($user_type=='Super Admin' && $_SESSION['admin_type']!='Super Admin')
		{
			echo '<i class="fa fa-warning w3-text-red" title="Unknown Error Occurred!!"> Unknown Error Occurred</i>';
			die();
		}
		if($user_type=='Faculty')
		{
			$stmt = $conn->prepare("select * from nr_faculty a,nr_department b where a.nr_dept_id=b.nr_dept_id and nr_faculty_id=:u_id  ");
			$stmt->bindParam(':u_id', $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Unknown Error Occurred!!"> Unknown Error Occurred</i>';
				die();
			}
			$photo=$result[0][10];
			$name=$result[0][1];
			$role=$result[0][5].' Faculty';
			$designation='<b>'.$result[0][2].'</b></br>&nbsp;&nbsp;Department of '.$result[0][15];
			$gender=$result[0][13];
			$join_date=$result[0][3];
			$email=$result[0][8];
			$mobile=$result[0][9];
			$stmt = $conn->prepare("select count(nr_faculty_id) from nr_faculty_login_transaction where nr_faculty_id=:u_id  ");
			$stmt->bindParam(':u_id', $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
				$total_session=0;
			else
				$total_session=$result[0][0];
			
			$stmt = $conn->prepare("select nr_falotr_date,nr_falotr_time from nr_faculty_login_transaction where nr_faculty_id=:u_id order by nr_falotr_date desc, nr_falotr_time desc limit 1 ");
			$stmt->bindParam(':u_id', $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
				$last_session='N/A';
			else
				$last_session=get_date($result[0][0]).' at '.$result[0][1];
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
									<img src="../images/faculty/<?php echo $photo; ?>" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
							<?php } ?>
						</div>
						<div class="w3-rest w3-container w3-padding-0 w3-margin-0" style="min-width:200px;">
							<table>
								<tr>
									<td valign="top">Name</td>
									<td valign="top" class="w3-bold">: <?php echo $name; ?></td>
								</tr>
								<tr>
									<td valign="top">User Type</td>
									<td valign="top" class="w3-bold">: <?php echo $role; ?></td>
								</tr>
								<tr>
									<td valign="top">Designation</td>
									<td valign="top">: <?php echo $designation; ?></td>
								</tr>
								<tr>
									<td valign="top">Gender</td>
									<td valign="top">: <?php echo $gender; ?></td>
								</tr>
								<tr>
									<td valign="top">Join Date</td>
									<td valign="top" class="w3-bold">: <?php echo get_date($join_date); ?></td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
				<!-- part 2 -->
				<div class="w3-half w3-container w3-padding-0">
					<table style="width:100%;">
						<tr>
							<td valign="top">Total Session</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-purple">: <b><?php echo $total_session; ?></b></td>
						</tr>
						<tr>
							<td valign="top">Last Session</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo $last_session; ?></td>
						</tr>
						<tr>
							<td valign="top">Email</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-blue">: <?php if($email=='') { echo 'N/A'; } else { echo '<a href="'.$email.'" target="_blank" class="w3-hover-text-teal w3-decoration-null">'.$email.'</a>'; } ?></td>
						</tr>
						<tr>
							<td valign="top">Cell No</td>
							<td colspan="2" valign="top" class="w3-bold">: <?php if($mobile=='') { echo 'N/A'; } else { echo $mobile; } ?></td>
						</tr>
						<tr>
							<td colspan="3" valign="top" class="w3-bold">
								<?php
								
									$stmt = $conn->prepare("select count(nr_faculty_id) from nr_faculty_login_transaction where nr_faculty_id=:u_id and nr_falotr_status='Active' ");
									$stmt->bindParam(':u_id', $user_id);
									$stmt->execute();
									$result = $stmt->fetchAll();
									if($result[0][0]!=0)
									{
										echo '<i class="w3-red w3-button w3-round-large w3-padding w3-hover-teal w3-cursor fa fa-circle-o w3-right" onclick="session_inactive_function(\'Inactive\',\'Faculty\',\''.$user_id.'\',\'-1\',\'-1\')" title="Click here for inactive all the session" id="session_inactive_btn"> Inactive All</i>';
									}
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<table id="user_session_tables" style="width:96%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
				<tr class="w3-teal w3-bold">
					<td style="width:15%;" valign="top" class="w3-padding-small">IP Address</td>
					<td style="width:12%;" valign="top" class="w3-padding-small">Country</td>
					<td style="width:12%;" valign="top" class="w3-padding-small">City</td>
					<td style="width:16%;" valign="top" class="w3-padding-small">GEO Location</td>
					<td style="width:17%;" valign="top" class="w3-padding-small">Date</td>
					<td style="width:14%;" valign="top" class="w3-padding-small">Time</td>
					<td style="width:14%;" valign="top" class="w3-padding-small">Action</td>
				</tr>
				<tbody class="w3-container w3-margin-0 w3-padding-0" id="user_session_table_details">
					<?php
						$stmt = $conn->prepare("select * from nr_faculty_login_transaction where nr_faculty_id=:u_id order by nr_falotr_date desc, nr_falotr_time desc");
						$stmt->bindParam(':u_id', $user_id);
						$stmt->execute();
						$result = $stmt->fetchAll();
						$sz=count($result);
						for($i=0;$i<$sz;$i++)
						{
							$col='';
							if($result[$i][9]=='Inactive'){ $col='w3-pale-red'; }
					?>
						<tr class=" <?php echo $col; ?>" id="<?php echo 'Faculty'.$user_id.$result[$i][7].$result[$i][8]; ?>">
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][1]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][2]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][3]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><a title="Click here to view it on google map." href="https://www.google.com/maps?q=<?php echo $result[$i][4]; ?>,<?php echo $result[$i][5]; ?>" target="_blank" class="w3-decoration-null w3-bold w3-text-blue"><?php echo '('.$result[$i][4].', '.$result[$i][5].')'; ?></a></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][7]); ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][8]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php if($result[$i][9]=='Active'){ echo '<i class="w3-text-red w3-hover-text-teal w3-cursor fa fa-circle-o" onclick="session_inactive_function(\'Inactive\',\'Faculty\',\''.$user_id.'\',\''.$result[$i][7].'\',\''.$result[$i][8].'\')" title="Click here for inactive this session"> Inactive</i>'; } ?></td>
						</tr>
					
					<?php 
						} 
					?>
				</tbody>
			</table>
<?php
		}
		else
		{
			
			$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:u_id  ");
			$stmt->bindParam(':u_id', $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
			{
				echo '<i class="fa fa-warning w3-text-red" title="Unknown Error Occurred !!"> Unknown Error Occurred</i>';
				die();
			}
			$photo=$result[0][5];
			$name=$result[0][1];
			$role=$user_type;
			$designation=$result[0][7];
			$gender=$result[0][11];
			$join_date=$result[0][12];
			$email=$result[0][2];
			$mobile=$result[0][4];
			$stmt = $conn->prepare("select count(nr_admin_id) from nr_admin_login_transaction where nr_admin_id=:u_id  ");
			$stmt->bindParam(':u_id', $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
				$total_session=0;
			else
				$total_session=$result[0][0];
			
			$stmt = $conn->prepare("select nr_suadlotr_date,nr_suadlotr_time from nr_admin_login_transaction where nr_admin_id=:u_id order by nr_suadlotr_date desc, nr_suadlotr_time desc limit 1 ");
			$stmt->bindParam(':u_id', $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)==0)
				$last_session='N/A';
			else
				$last_session=get_date($result[0][0]).' at '.$result[0][1];
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
									<img src="../images/<?php if($role=='Admin' || $role=='Super Admin'){ echo 'admin/'; } if($role=='Moderator'){ echo 'moderator/'; }    echo $photo; ?>" class="w3-image" style="margin:5px 0px;padding:0px;width:100%;max-width:100px;height: 120px;border: 2px solid black;" title="Picture (120X100)"/>
							<?php } ?>
						</div>
						<div class="w3-rest w3-container w3-padding-0 w3-margin-0" style="min-width:200px;">
							<table>
								<tr>
									<td valign="top">Name</td>
									<td valign="top" class="w3-bold">: <?php echo $name; ?></td>
								</tr>
								<tr>
									<td valign="top">Role</td>
									<td valign="top" class="w3-bold">: <?php echo $role; ?></td>
								</tr>
								<tr>
									<td valign="top">Designation</td>
									<td valign="top">: <?php echo $designation; ?></td>
								</tr>
								<tr>
									<td valign="top">Gender</td>
									<td valign="top">: <?php echo $gender; ?></td>
								</tr>
								<tr>
									<td valign="top">Join Date</td>
									<td valign="top" class="w3-bold">: <?php echo get_date($join_date); ?></td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
				<!-- part 2 -->
				<div class="w3-half w3-container w3-padding-0">
					<table style="width:100%;">
						<tr>
							<td valign="top">Total Session</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-purple">: <b><?php echo $total_session; ?></b></td>
						</tr>
						<tr>
							<td valign="top">Last Session</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-green">: <?php echo $last_session; ?></td>
						</tr>
						<tr>
							<td valign="top">Email</td>
							<td colspan="2" valign="top" class="w3-bold w3-text-blue">: <?php if($email=='') { echo 'N/A'; } else { echo '<a href="'.$email.'" target="_blank" class="w3-hover-text-teal w3-decoration-null">'.$email.'</a>'; } ?></td>
						</tr>
						<tr>
							<td valign="top">Cell No</td>
							<td colspan="2" valign="top" class="w3-bold">: <?php if($mobile=='') { echo 'N/A'; } else { echo $mobile; } ?></td>
						</tr>
						<tr>
							<td colspan="3" valign="top" class="w3-bold">
								<?php
								
									$stmt = $conn->prepare("select count(nr_admin_id) from nr_admin_login_transaction where nr_admin_id=:u_id and nr_suadlotr_status='Active' ");
									$stmt->bindParam(':u_id', $user_id);
									$stmt->execute();
									$result = $stmt->fetchAll();
									if($result[0][0]!=0)
									{
										echo '<i class="w3-red w3-button w3-round-large w3-padding w3-hover-teal w3-cursor fa fa-circle-o w3-right" onclick="session_inactive_function(\'Inactive\',\''.$role.'\',\''.$user_id.'\',\'-1\',\'-1\')" title="Click here for inactive all the session" id="session_inactive_btn"> Inactive All</i>';
									}
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<table id="user_session_tables" style="width:96%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
				<tr class="w3-teal w3-bold">
					<td style="width:15%;" valign="top" class="w3-padding-small">IP Address</td>
					<td style="width:12%;" valign="top" class="w3-padding-small">Country</td>
					<td style="width:12%;" valign="top" class="w3-padding-small">City</td>
					<td style="width:16%;" valign="top" class="w3-padding-small">GEO Location</td>
					<td style="width:17%;" valign="top" class="w3-padding-small">Date</td>
					<td style="width:14%;" valign="top" class="w3-padding-small">Time</td>
					<td style="width:14%;" valign="top" class="w3-padding-small">Action</td>
				</tr>
				<tbody class="w3-container w3-margin-0 w3-padding-0" id="user_session_table_details">
					<?php
						$stmt = $conn->prepare("select * from nr_admin_login_transaction where nr_admin_id=:u_id order by nr_suadlotr_date desc, nr_suadlotr_time desc");
						$stmt->bindParam(':u_id', $user_id);
						$stmt->execute();
						$result = $stmt->fetchAll();
						$sz=count($result);
						for($i=0;$i<$sz;$i++)
						{
							$col='';
							if($result[$i][9]=='Inactive'){ $col='w3-pale-red'; }
					?>
						<tr class=" <?php echo $col; ?>" id="<?php echo $role.$user_id.$result[$i][7].$result[$i][8]; ?>">
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][1]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][2]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][3]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><a title="Click here to view it on google map." href="https://www.google.com/maps?q=<?php echo $result[$i][4]; ?>,<?php echo $result[$i][5]; ?>" target="_blank" class="w3-decoration-null w3-bold w3-text-blue"><?php echo '('.$result[$i][4].', '.$result[$i][5].')'; ?></a></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][7]); ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][8]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php if($result[$i][9]=='Active'){ echo '<i class="w3-text-red w3-hover-text-teal w3-cursor fa fa-circle-o" onclick="session_inactive_function(\'Inactive\',\''.$role.'\',\''.$user_id.'\',\''.$result[$i][7].'\',\''.$result[$i][8].'\')" title="Click here for inactive this session"> Inactive</i>'; }  ?></td>
						</tr>
					
					<?php 
						} 
					?>
				</tbody>
			</table>


<?php
		}



	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';

	}
?>