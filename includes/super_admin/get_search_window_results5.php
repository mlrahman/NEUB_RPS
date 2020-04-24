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
	if(isset($_REQUEST['course_offer_id']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$course_offer_id=trim($_REQUEST['course_offer_id']);
		
		$stmt = $conn->prepare("select a.nr_drop_id,b.nr_course_title,b.nr_course_code,b.nr_course_credit, a.nr_drop_remarks, a.nr_drop_semester, c.nr_prog_id, c.nr_prog_title, d.nr_prcr_total, d.nr_prcr_ex_date,a.nr_drop_status from nr_drop a,nr_course b,nr_program c,nr_program_credit d where a.nr_prcr_id=d.nr_prcr_id and a.nr_prog_id=c.nr_prog_id and a.nr_course_id=b.nr_course_id and a.nr_drop_id=:course_offer_id");
		$stmt->bindParam(':course_offer_id', $course_offer_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$course_title=$result[0][1];
		$course_code=$result[0][2];
		$credit=$result[0][3];
		$course_type=$result[0][4];
		$course_semester=$result[0][5];
		$prog_id=$result[0][6];
		$prog_title=$result[0][7];
		$prog_credit=$result[0][8];
		$prog_expire=$result[0][9];
		$status=$result[0][10];
?>
	<div class="w3-container w3-margin-0 w3-padding-0" id="course_offer_view_box1">
		<p class="w3-margin-0 w3-right w3-text-purple w3-cursor" style="margin: 0px 12px 5px 0px;" onclick="document.getElementById('course_offer_view_box1').style.display='none';document.getElementById('course_offer_view_box2').style.display='none';document.getElementById('course_offer_view_box3').style.display='block';"><i class="fa fa-history"></i> Offered Course History</p>
		<p class="w3-text-red w3-small w3-bold" style="margin: 2px 0px 0px 12px;padding:0px;">Note: (*) marked fields are mandatory.</p>
		<div class="w3-container w3-border w3-round-large w3-padding w3-margin-bottom" style="margin: 0px 12px 12px 12px;">
			<div class="w3-row w3-margin-0 w3-padding-0">
				<div class="w3-col w3-margin-0" style="width:70%;padding:0px 6px 0px 0px;">
					<label><b>Course Title</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $course_title; ?>" disabled>
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:32%;">
							<label><b>Course Code</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $course_code; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:32%;">
							<label><b>Course Credit</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" value="<?php echo $credit; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:32%;">
							<label><i class="w3-text-red">*</i> <b>Offer Semester</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_view_semester" onchange="course_offer_view_form_change()">
								<option value="<?php echo $course_semester; ?>"><?php echo get_semester_format($course_semester); ?></option>
								<?php if($course_semester!=1){ ?><option value="1">1st</option><?php } ?>
								<?php if($course_semester!=2){ ?><option value="2">2nd</option><?php } ?>
								<?php if($course_semester!=3){ ?><option value="3">3rd</option><?php } ?>
								<?php if($course_semester!=4){ ?><option value="4">4th</option><?php } ?>
								<?php if($course_semester!=5){ ?><option value="5">5th</option><?php } ?>
								<?php if($course_semester!=6){ ?><option value="6">6th</option><?php } ?>
								<?php if($course_semester!=7){ ?><option value="7">7th</option><?php } ?>
								<?php if($course_semester!=8){ ?><option value="8">8th</option><?php } ?>
								<?php if($course_semester!=9){ ?><option value="9">9th</option><?php } ?>
								<?php if($course_semester!=10){ ?><option value="10">10th</option><?php } ?>
								<?php if($course_semester!=11){ ?><option value="11">11th</option><?php } ?>
								<?php if($course_semester!=12){ ?><option value="12">12th</option><?php } ?>
							</select>
						</div>
					</div>
					
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:30%;">
							<label><i class="w3-text-red">*</i> <b>Course Type</b></label>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large" id="course_offer_view_type" onchange="course_offer_view_form_change()">
								<option value="<?php echo $course_type; ?>"><?php echo $course_type; ?></option>
								<?php if($course_type!="Compulsory"){ ?><option value="Compulsory">Compulsory</option><?php } ?>
								<?php if($course_type!="Optional I"){ ?><option value="Optional I">Optional I</option><?php } ?>
								<?php if($course_type!="Optional II"){ ?><option value="Optional II">Optional II</option><?php } ?>
								<?php if($course_type!="Optional III"){ ?><option value="Optional III">Optional III</option><?php } ?>
								<?php if($course_type!="Optional IV"){ ?><option value="Optional IV">Optional IV</option><?php } ?>
								<?php if($course_type!="Optional V"){ ?><option value="Optional V">Optional V</option><?php } ?>
							</select>
						</div>
						<div class="w3-col" style="margin-left:2%;width:36%;">
							<label><b>Offer Program</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" value="<?php echo $prog_title; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:30%;">
							<label><b>Program Credit</b></label>
							<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="number" value="<?php echo $prog_credit; ?>" disabled>
						</div>
					</div>
					
					<input type="hidden" value="<?php echo $course_semester; ?>" id="course_offer_view_old_semester">
					<input type="hidden" value="<?php echo $course_type; ?>" id="course_offer_view_old_type">
					
								
					<label><i class="w3-text-red">*</i> <b>Status</b></label>
					<?php
						if($status=='Active') 
						{
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-green" id="course_offer_view_status" onchange="course_offer_view_form_change()">
								<option value="Active" class="w3-pale-green">Active</option>
								<option value="Inactive" class="w3-pale-red">Inactive</option>
							</select>
					<?php
						} else {
					?>
							<select class="w3-input w3-border w3-margin-bottom w3-round-large w3-pale-red" id="course_offer_view_status" onchange="course_offer_view_form_change()">
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
					<input type="hidden" value="<?php echo $status; ?>" id="course_offer_view_old_status">
					<input type="hidden" value="<?php echo $ccc; ?>" id="course_offer_view_old_captcha">
					<input type="hidden" value="<?php echo $course_offer_id; ?>" id="course_offer_view_id">
					
					
					<label><i class="w3-text-red">*</i> <b>Captcha</b></label>
					<div class="w3-row" style="margin:0px 0px 8px 0px;padding:0px;">
						<div class="w3-col" style="width:40%;">
							<input class="w3-input w3-border w3-center w3-round-large" type="text" value="<?php echo $aaa.' + '.$bbb.' = '; ?>" disabled>
						</div>
						<div class="w3-col" style="margin-left:2%;width:58%;">
							<input class="w3-input w3-border w3-round-large" type="text"  maxlength="2"  placeholder=" * " id="course_offer_view_captcha" autocomplete="off" onkeyup="course_offer_view_form_change()">
						</div>
					</div>
					
					
				</div>
				<div class="w3-col w3-margin-0" style="width:30%;padding:0px 6px 0px 6px;">
					
					<button onclick="course_offer_view_form_reset()" class="w3-button w3-margin-top w3-red w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eye-slash"></i> Reset</button>
					
					<button onclick="document.getElementById('course_offer_view_re_confirmation').style.display='block';" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;"><i class="fa fa-eraser"></i> Remove</button>
				
					<button onclick="course_offer_view_form_save_changes('<?php echo $course_offer_id; ?>')" id="course_offer_view_save_btn" class="w3-button w3-margin-top w3-black w3-hover-teal w3-round-large w3-margin-left" style="min-width:150px;" disabled><i class="fa fa-save"></i> Save Changes</button>
				
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="course_offer_view_box2" style="display:none;">
		<p style="font-size:15px;font-weight:bold;">Please wait while making changes..</p>
		<i class="fa fa-spinner w3-spin w3-margin-bottom w3-margin-top" style="font-size:50px;"></i>
	
	</div>
	<div class="w3-container w3-margin-0 w3-padding-0 w3-center" id="course_offer_view_box3" style="display:none;">
		<p class="w3-margin-0 w3-left-align w3-text-purple w3-cursor" style="margin: 0px 0px 0px 12px;" onclick="document.getElementById('course_offer_view_box1').style.display='block';document.getElementById('course_offer_view_box2').style.display='none';document.getElementById('course_offer_view_box3').style.display='none';"><i class="fa fa-mail-reply"></i> Back</p>
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
					$stmt = $conn->prepare("select * from nr_drop_history a,nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_drop_id=:course_offer_id order by a.nr_droph_date desc,a.nr_droph_time desc ");
					$stmt->bindParam(':course_offer_id', $course_offer_id);
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