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
	if(isset($_REQUEST['status']) && isset($_REQUEST['time']) && isset($_REQUEST['date']) && isset($_REQUEST['user_type']) && isset($_REQUEST['user_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$user_type=trim($_REQUEST['user_type']);
		$user_id=trim($_REQUEST['user_id']);
		$date=trim($_REQUEST['date']);
		$time=trim($_REQUEST['time']);
		$status=trim($_REQUEST['status']);
		if($user_type=='Super Admin' && $_SESSION['admin_type']!='Super Admin')
		{
			echo '<i class="fa fa-warning w3-text-red" title="Unknown Error Occurred!!"> Unknown Error Occurred</i>';
			die();
		}
		if($date=='-1' && $time=='-1') //change all
		{
			if($user_type=='Faculty')
			{
				$stmt = $conn->prepare("update nr_faculty_login_transaction set nr_falotr_status=:status where nr_faculty_id=:u_id ");
				$stmt->bindParam(':status', $status);
				$stmt->bindParam(':u_id', $user_id);
				$stmt->execute();
				
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
					<td valign="top" class="w3-padding-small w3-border"><?php echo '('.$result[$i][4].', '.$result[$i][5].')'; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][7]); ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][8]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php if($result[$i][9]=='Active'){ echo '<i class="w3-text-red w3-hover-text-teal w3-cursor fa fa-circle-o" onclick="session_inactive_function(\'Inactive\',\'Faculty\',\''.$user_id.'\',\''.$result[$i][7].'\',\''.$result[$i][8].'\')" title="Click here for inactive this session"> Inactive</i>'; } ?></td>
				</tr>
			
			<?php 
				} 
			
			}
			else
			{
				$stmt = $conn->prepare("update nr_admin_login_transaction set nr_suadlotr_status=:status where nr_admin_id=:u_id ");
				$stmt->bindParam(':status', $status);
				$stmt->bindParam(':u_id', $user_id);
				$stmt->execute();
				
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
				<tr class=" <?php echo $col; ?>" id="<?php echo $user_type.$user_id.$result[$i][7].$result[$i][8]; ?>">
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][1]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][2]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][3]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo '('.$result[$i][4].', '.$result[$i][5].')'; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][7]); ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][8]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php if($result[$i][9]=='Active'){ echo '<i class="w3-text-red w3-hover-text-teal w3-cursor fa fa-circle-o" onclick="session_inactive_function(\'Inactive\',\''.$role.'\',\''.$user_id.'\',\''.$result[$i][7].'\',\''.$result[$i][8].'\')" title="Click here for inactive this session"> Inactive</i>'; }  ?></td>
				</tr>
			
			<?php 
				}
			}
		}
		else  //individual change
		{
			if($user_type=='Faculty')
			{
				$stmt = $conn->prepare("update nr_faculty_login_transaction set nr_falotr_status=:status where nr_faculty_id=:u_id and nr_falotr_date=:date and nr_falotr_time=:time ");
				$stmt->bindParam(':status', $status);
				$stmt->bindParam(':u_id', $user_id);
				$stmt->bindParam(':date', $date);
				$stmt->bindParam(':time', $time);
				$stmt->execute();
				
				$stmt = $conn->prepare("select * from nr_faculty_login_transaction where nr_faculty_id=:u_id and nr_falotr_date=:date and nr_falotr_time=:time order by nr_falotr_date desc, nr_falotr_time desc limit 1");
				$stmt->bindParam(':date', $date);
				$stmt->bindParam(':time', $time);
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
					<td valign="top" class="w3-padding-small w3-border"><?php echo '('.$result[$i][4].', '.$result[$i][5].')'; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][7]); ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][8]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php if($result[$i][9]=='Active'){ echo '<i class="w3-text-red w3-hover-text-teal w3-cursor fa fa-circle-o" onclick="session_inactive_function(\'Inactive\',\'Faculty\',\''.$user_id.'\',\''.$result[$i][7].'\',\''.$result[$i][8].'\')" title="Click here for inactive this session"> Inactive</i>'; } ?></td>
				</tr>
			
			<?php 
				} 
			}
			else
			{
				$stmt = $conn->prepare("update nr_admin_login_transaction set nr_suadlotr_status=:status where nr_admin_id=:u_id and nr_suadlotr_date=:date and nr_suadlotr_time=:time ");
				$stmt->bindParam(':status', $status);
				$stmt->bindParam(':u_id', $user_id);
				$stmt->bindParam(':date', $date);
				$stmt->bindParam(':time', $time);
				$stmt->execute();
				
				
				$stmt = $conn->prepare("select * from nr_admin_login_transaction where nr_admin_id=:u_id and nr_suadlotr_date=:date and nr_suadlotr_time=:time order by nr_suadlotr_date desc, nr_suadlotr_time desc limit 1");
				$stmt->bindParam(':date', $date);
				$stmt->bindParam(':time', $time);
				$stmt->bindParam(':u_id', $user_id);
				$stmt->execute();
				$result = $stmt->fetchAll();
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$col='';
					if($result[$i][9]=='Inactive'){ $col='w3-pale-red'; }
			?>
				<tr class=" <?php echo $col; ?>" id="<?php echo $user_type.$user_id.$result[$i][7].$result[$i][8]; ?>">
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][1]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][2]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][3]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo '('.$result[$i][4].', '.$result[$i][5].')'; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][7]); ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][8]; ?></td>
					<td valign="top" class="w3-padding-small w3-border"><?php if($result[$i][9]=='Active'){ echo '<i class="w3-text-red w3-hover-text-teal w3-cursor fa fa-circle-o" onclick="session_inactive_function(\'Inactive\',\''.$role.'\',\''.$user_id.'\',\''.$result[$i][7].'\',\''.$result[$i][8].'\')" title="Click here for inactive this session"> Inactive</i>'; }  ?></td>
				</tr>
			
			<?php 
				}
			}
			
		}



	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Network Error Occurred occurred!!"> Network Error Occurred</i>';

	}
?>