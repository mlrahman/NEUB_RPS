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
?>		
		<p class="w3-margin-0 w3-padding-0 w3-medium"><i class="fa fa-print w3-hover-text-teal w3-text-indigo w3-cursor" onclick="print_courses_delete_history()"> Print</i></p>		
	
		<table style="width:100%;margin:5px 0px 15px 0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
			<tr class="w3-teal w3-bold">
				<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
				<td style="width:40%;" valign="top" class="w3-padding-small">Performed Action</td>
				<td style="width:20%;" valign="top" class="w3-padding-small">Performed By</td>
				<td style="width:15%;" valign="top" class="w3-padding-small">Date</td>
				<td style="width:15%;" valign="top" class="w3-padding-small">Time</td>
			</tr>
			<?php
				$stmt = $conn->prepare("select * from nr_delete_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_deleteh_type='Course List' order by a.nr_deleteh_date desc,a.nr_deleteh_time desc ");
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result)==0)
				{
					echo '<tr>
						<td colspan="5"> <p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="No Data Available"> No Data Available.</i></p></td>
					</tr>';
				}
				else
				{
					$sz=count($result);
					for($i=0;$i<$sz;$i++)
					{
			
			?>
						<tr class="w3-center">
							<td valign="top" class="w3-padding-small w3-border"><?php echo $i+1; ?></td>
							<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][1]; ?></td>
							<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][7].' <b>('.$result[$i][12].')</b>, '.$result[$i][13]; ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][2]); ?></td>
							<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][3]; ?></td>
						</tr>
			
			<?php
					}
				}
			?>
		</table>
<?php		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>