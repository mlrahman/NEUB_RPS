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
	if($_SESSION['admin_type']!='Super Admin'){
		header("location: index.php");
		die();
	}
	if(isset($_REQUEST['admin_member_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$admin_member_id=trim($_REQUEST['admin_member_id']);
?>		
		<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('admin_view_box1').style.display='block';document.getElementById('admin_view_box2').style.display='none';document.getElementById('admin_view_box3').style.display='none';document.getElementById('admin_view_box4').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
		<div class="w3-clear"></div>
		<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
			<table style="width:100%;margin:5px 0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
				<tr class="w3-teal w3-bold">
					<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
					<td style="width:60%;" valign="top" class="w3-padding-small">Performed Action</td>
					<td style="width:15%;" valign="top" class="w3-padding-small">Date</td>
					<td style="width:15%;" valign="top" class="w3-padding-small">Time</td>
				</tr>
				<?php
					$stmt = $conn->prepare("(((((((((select nr_droph_task,nr_droph_date as d,nr_droph_time from nr_drop_history where nr_admin_id=:admin_member_id) union all (select nr_facultyh_task,nr_facultyh_date as d,nr_facultyh_time from nr_faculty_history where nr_admin_id=:admin_member_id)) union all (select nr_adminh_task,nr_adminh_date as d,nr_adminh_time from nr_admin_history where nr_admin_id=:admin_member_id))  union all (select nr_courseh_task,nr_courseh_date as d,nr_courseh_time from nr_course_history where nr_admin_id=:admin_member_id)) union all (select nr_deleteh_task,nr_deleteh_date as d,nr_deleteh_time from nr_delete_history where nr_admin_id=:admin_member_id))  union all (select nr_depth_task,nr_depth_date as d,nr_depth_time from nr_department_history where nr_admin_id=:admin_member_id)) union all (select nr_progh_task,nr_progh_date as d,nr_progh_time from nr_program_history where nr_admin_id=:admin_member_id)) union all (select nr_resulth_task,nr_resulth_date as d,nr_resulth_time from nr_result_history where nr_admin_id=:admin_member_id)) union all (select nr_studh_task,nr_studh_date as d,nr_studh_time from nr_student_history where nr_admin_id=:admin_member_id)) order by d desc;  ");
					$stmt->bindParam(':admin_member_id', $admin_member_id);
					$stmt->execute();
					$result = $stmt->fetchAll();
					if(count($result)==0)
					{
						echo '<tr>
							<td colspan="4"> <p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="No Data Available"> No Data Available.</i></p></td>
						</tr>';
					}
					else
					{
						$sz=count($result);
						for($i=0;$i<$sz;$i++)
						{
				
				?>
							<tr>
								<td valign="top" class="w3-padding-small w3-border"><?php echo $i+1; ?></td>
								<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][0]; ?></td>
								<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][1]); ?></td>
								<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][2]; ?></td>
							</tr>
				
				<?php
						}
					}
				?>
			</table>
		</div>
		

<?php		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>