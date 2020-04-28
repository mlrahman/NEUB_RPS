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
	if(isset($_REQUEST['prog_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$prog_id=trim($_REQUEST['prog_id']);
		
		$fl=0; $fl2=0; $fl3=0; $fl4=0;
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_course where nr_prog_id=:prog_id");
		$stmt->bindParam(':prog_id', $prog_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl=1;
		}
		
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_drop where nr_prog_id=:prog_id");
		$stmt->bindParam(':prog_id', $prog_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl2=1;
		}
		
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_result where nr_prog_id=:prog_id");
		$stmt->bindParam(':prog_id', $prog_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl3=1;
		}
		
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_student where nr_prog_id=:prog_id");
		$stmt->bindParam(':prog_id', $prog_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl4=1;
		}
		
		$stmt = $conn->prepare("select a.nr_prog_id,a.nr_prog_title,a.nr_prog_code,(select c.nr_prcr_total from nr_program_credit c where c.nr_prog_id=a.nr_prog_id and c.nr_prcr_ex_date='' order by c.nr_prcr_id desc limit 1),a.nr_prog_status,a.nr_dept_id,b.nr_dept_title from nr_program a,nr_department b where a.nr_prog_id=:prog_id and a.nr_dept_id=b.nr_dept_id ");
		$stmt->bindParam(':prog_id', $prog_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$prog_title=$result[0][1];
		$prog_code=$result[0][2];
		$credit=$result[0][3];
		$status=$result[0][4];
		$dept_id=$result[0][5];
		$dept_title=$result[0][6];
		
?>
	<div class="w3-container w3-margin-0 w3-padding-0" id="prog_view_box1">
		<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('prog_view_box1').style.display='none';document.getElementById('prog_view_box2').style.display='none';document.getElementById('prog_view_box3').style.display='block';"><i class="fa fa-history"></i> Program History</p>
		<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
		<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
					<label><i class="w3-text-red">*</i> <b>Program Title</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $prog_title; ?>" id="prog_view_title" placeholder="Enter Program Title" autocomplete="off" onkeyup="prog_view_form_change()">
					<input type="hidden" value="<?php echo $prog_title; ?>" id="prog_view_old_title">
					
					<label><i class="w3-text-red">*</i> <b>Program Code</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $prog_code; ?>" id="prog_view_code" placeholder="Enter Program Code" autocomplete="off" onkeyup="prog_view_form_change()">
					<input type="hidden" value="<?php echo $prog_code; ?>" id="prog_view_old_code">
					
					<label><i class="w3-text-red">*</i> <b>Program Credit</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" value="<?php echo $credit; ?>" id="prog_view_credit" placeholder="Enter Program Credit" autocomplete="off" onkeyup="prog_view_form_change()">
					<input type="hidden" value="<?php echo $credit; ?>" id="prog_view_old_credit">
					<input type="hidden" value="<?php echo $dept_id; ?>" id="prog_view_old_dept">
					
					<label><i class="w3-text-red">*</i> <b>Department</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="prog_view_dept" onchange="prog_view_form_change()">
						<option value="<?php echo $dept_id; ?>"><?php echo $dept_title; ?></option>
						<?php
							$stmt = $conn->prepare("SELECT * FROM nr_department where nr_dept_id!=:dept_id and nr_dept_status='Active' order by nr_dept_title asc");
							$stmt->bindParam(':dept_id', $dept_id);
							$stmt->execute();
							$stud_result=$stmt->fetchAll();
							if(count($stud_result)>0)
							{
								$sz=count($stud_result);
								for($k=0;$k<$sz;$k++)
								{
									$dept_id=$stud_result[$k][0];
									$dept_title=$stud_result[$k][1];
									echo '<option value="'.$dept_id.'">'.$dept_title.'</option>';
								}
							}
						?>
						
					</select>
					
					
					<label><i class="w3-text-red">*</i> <b>Status</b></label>
					<?php
						if($status=='Active') 
						{
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="prog_view_status" onchange="prog_view_form_change()">
								<option value="Active" class="w3-pale-green">Active</option>
								<option value="Inactive" class="w3-pale-red">Inactive</option>
							</select>
					<?php
						} else {
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="prog_view_status" onchange="prog_view_form_change()">
								<option value="Inactive" class="w3-pale-red">Inactive</option>
								<option value="Active" class="w3-pale-green">Active</option>
							</select>
					<?php
						}
					
						//spam Check 
						$aaa=rand(1,20);
						$bbb=rand(1,20);
						$ccc=$aaa+$bbb;
					?>
					<input type="hidden" value="<?php echo $status; ?>" id="prog_view_old_status">
					<input type="hidden" value="<?php echo $ccc; ?>" id="prog_view_old_captcha">
					<input type="hidden" value="<?php echo $prog_id; ?>" id="prog_view_id">
					
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="prog_view_captcha" autocomplete="off" onkeyup="prog_view_form_change()">
						</div>
					</div>
					
					
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<button onclick="prog_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Reset</button>
					
					<button onclick="document.getElementById('prog_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($fl==1 || $fl2==1 || $fl3==1 || $fl4==1){ echo 'title="Sorry you can not delete it." disabled'; } ?>><i class="fa fa-eraser"></i> Remove</button>
				
					<button onclick="prog_view_form_save_changes('<?php echo $prog_id; ?>')" id="prog_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="prog_view_box2" style="display:none;">
		<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
		<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
	
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="prog_view_box3" style="display:none;">
		<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('prog_view_box1').style.display='block';document.getElementById('prog_view_box2').style.display='none';document.getElementById('prog_view_box3').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
		<div class="w3-clear"></div>
		<div class="w3-container w3-border w3-round-large w3-padding" style="margin: 0px 12px 12px 12px;">
			<table style="width:100%;margin:5px 0px;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
				<tr class="w3-teal w3-bold">
					<td style="width:10%;" valign="top" class="w3-padding-small">S.L. No</td>
					<td style="width:40%;" valign="top" class="w3-padding-small">Performed Action</td>
					<td style="width:20%;" valign="top" class="w3-padding-small">Performed By</td>
					<td style="width:15%;" valign="top" class="w3-padding-small">Date</td>
					<td style="width:15%;" valign="top" class="w3-padding-small">Time</td>
				</tr>
				<?php
					$stmt = $conn->prepare("select * from nr_program_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_prog_id=:prog_id order by a.nr_progh_date desc,a.nr_progh_time desc ");
					$stmt->bindParam(':prog_id', $prog_id);
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
							<tr>
								<td valign="top" class="w3-padding-small w3-border"><?php echo $i+1; ?></td>
								<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][2]; ?></td>
								<td valign="top" class="w3-padding-small w3-border w3-small"><?php echo $result[$i][7].' <b>('.$result[$i][12].')</b>, '.$result[$i][13]; ?></td>
								<td valign="top" class="w3-padding-small w3-border"><?php echo get_date($result[$i][3]); ?></td>
								<td valign="top" class="w3-padding-small w3-border"><?php echo $result[$i][4]; ?></td>
							</tr>
				
				<?php
						}
					}
				?>
			</table>
		</div>
	</div>
<?php		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>