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
	if(isset($_REQUEST['course_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$course_id=trim($_REQUEST['course_id']);
		
		$fl=0; $fl2=0; $fl3=0;
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_drop where nr_course_id=:course_id");
		$stmt->bindParam(':course_id', $course_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl=1;
		}
		
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_result where nr_course_id=:course_id");
		$stmt->bindParam(':course_id', $course_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl2=1;
		}
		
		//checking if prog is delete able or not
		$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_course_id=:course_id");
		$stmt->bindParam(':course_id', $course_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$fl3=1;
		}
		
		
		
		$stmt = $conn->prepare("select a.nr_course_id,a.nr_course_title,a.nr_course_code,a.nr_course_credit,a.nr_course_status,a.nr_prog_id,b.nr_prog_title from nr_course a,nr_program b where a.nr_course_id=:course_id and a.nr_prog_id=b.nr_prog_id ");
		$stmt->bindParam(':course_id', $course_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$course_title=$result[0][1];
		$course_code=$result[0][2];
		$credit=$result[0][3];
		$status=$result[0][4];
		$prog_id=$result[0][5];
		$prog_title=$result[0][6];
		
?>
	<div class="w3-container w3-margin-0 w3-padding-0" id="course_view_box1">
		<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('course_view_box1').style.display='none';document.getElementById('course_view_box2').style.display='none';document.getElementById('course_view_box3').style.display='block';"><i class="fa fa-history"></i> Program History</p>
		<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
		<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
					<label><i class="w3-text-red">*</i> <b>Course Title</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $course_title; ?>" id="course_view_title" placeholder="Enter Course Title" autocomplete="off" onkeyup="course_view_form_change()">
					<input type="hidden" value="<?php echo $course_title; ?>" id="course_view_old_title">
					
					<label><i class="w3-text-red">*</i> <b>Course Code</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $course_code; ?>" id="course_view_code" placeholder="Enter Course Code" autocomplete="off" onkeyup="course_view_form_change()">
					<input type="hidden" value="<?php echo $course_code; ?>" id="course_view_old_code">
					
					<label><i class="w3-text-red">*</i> <b>Course Credit</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" value="<?php echo $credit; ?>" id="course_view_credit" placeholder="Enter Course Credit" autocomplete="off" onkeyup="course_view_form_change()">
					<input type="hidden" value="<?php echo $credit; ?>" id="course_view_old_credit">
					<input type="hidden" value="<?php echo $prog_id; ?>" id="course_view_old_prog">
					
					<label><?php if($fl==0 && $fl2==0 && $fl3==0){ ?><i class="w3-text-red">*</i><?php } ?> <b>Course Program</b></label>
					<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_view_prog" onchange="course_view_form_change()" <?php if($fl==1 || $fl2==1 || $fl3==1){ echo 'title="Sorry you can not change it." disabled'; } ?>>
						<option value="<?php echo $prog_id; ?>"><?php echo $prog_title; ?></option>
						<?php
							$stmt = $conn->prepare("SELECT * FROM nr_program where nr_prog_id!=:prog_id and nr_prog_status='Active' order by nr_prog_title asc");
							$stmt->bindParam(':prog_id', $prog_id);
							$stmt->execute();
							$stud_result=$stmt->fetchAll();
							if(count($stud_result)>0)
							{
								$sz=count($stud_result);
								for($k=0;$k<$sz;$k++)
								{
									$prog_id=$stud_result[$k][0];
									$prog_title=$stud_result[$k][1];
									echo '<option value="'.$prog_id.'">'.$prog_title.'</option>';
								}
							}
						?>
						
					</select>
					
					
					<label><i class="w3-text-red">*</i> <b>Status</b></label>
					<?php
						if($status=='Active') 
						{
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="course_view_status" onchange="course_view_form_change()">
								<option value="Active" class="w3-pale-green">Active</option>
								<option value="Inactive" class="w3-pale-red">Inactive</option>
							</select>
					<?php
						} else {
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="course_view_status" onchange="course_view_form_change()">
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
					<input type="hidden" value="<?php echo $status; ?>" id="course_view_old_status">
					<input type="hidden" value="<?php echo $ccc; ?>" id="course_view_old_captcha">
					<input type="hidden" value="<?php echo $course_id; ?>" id="course_view_id">
					
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="course_view_captcha" autocomplete="off" onkeyup="course_view_form_change()">
						</div>
					</div>
					
					
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<button onclick="course_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Reset</button>
					
					<button onclick="document.getElementById('course_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" <?php if($fl==1 || $fl2==1 || $fl3==1){ echo 'title="Sorry you can not delete it." disabled'; } ?>><i class="fa fa-eraser"></i> Remove</button>
				
					<button onclick="course_view_form_save_changes('<?php echo $course_id; ?>')" id="course_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="course_view_box2" style="display:none;">
		<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
		<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
	
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="course_view_box3" style="display:none;">
		<p class="w3-margin-0 w3-left w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('course_view_box1').style.display='block';document.getElementById('course_view_box2').style.display='none';document.getElementById('course_view_box3').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
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
					$stmt = $conn->prepare("select * from nr_course_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_course_id=:course_id order by a.nr_courseh_date desc,a.nr_courseh_time desc ");
					$stmt->bindParam(':course_id', $course_id);
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