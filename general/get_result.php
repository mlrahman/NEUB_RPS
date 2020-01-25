<?php
	if(isset($_GET['s_id']) && isset($_GET['dob']))
	{
		$s_id=$_GET['s_id'];
		$dob=$_GET['dob'];
		require("../includes/db_connection.php");
		require("../includes/function.php");
		$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id and nr_stud_dob=:dob and nr_stud_status='Active' limit 1 ");
		$stmt->bindParam(':s_id', $s_id);
		$stmt->bindParam(':dob', $dob);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if(count($result)==0)
		{
			echo 'not_found';
			die();
		}
		
		$name = $result[0][1];
		$reg_no = $result[0][0];
		$session = get_session($reg_no);
		$gender = $result[0][3];
		$birthdate = $result[0][2];
		$prog_id = $result[0][6];
		$prcr_id = $result[0][7];
		
		$stmt = $conn->prepare("select * from nr_program where nr_prog_id=$prog_id");
		$stmt->execute();
		$prog_result = $stmt->fetchAll();
		$degree = $prog_result[0][1];
		
		$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
		$stmt->execute();
		$prcr_result = $stmt->fetchAll();
		$total_credit=$prcr_result[0][2];
		
		$earned_credit=0.0; //need to be calculate
		
		$waived_credit=$result[0][8];
		
		$total_cgpa=0.0; //nedd to be calculate
		
		$degree_status=$total_credit-($earned_credit+$waived_credit);
		if($degree_status==0)
			$degree_status='Completed';
		else
			$degree_status='Not Completed';
		
		$photo=$result[0][5];
		
		if($waived_credit==0) $waived_credit='N/A';
?>

	<div class=" w3-modal-content w3-round-large w3-animate-bottom w3-card-4 w3-leftbar w3-rightbar w3-bottombar w3-topbar w3-border-white">
		<header class="w3-container w3-black w3-bottombar w3-border-teal w3-round-top-large"> 
			<span onclick="document.getElementById('result_popup').style.display='none';document.getElementById('result_popup').innerHTML ='Oops..'" class="w3-button w3-display-topright w3-xlarge w3-hover-teal w3-round" style="padding:2px 12px;margin: 15px 10px;"><b>&times;</b></span>
			<p class="w3-xxlarge" style="margin:5px 0px;">Fetched Result</p>
		</header>
		<div class="w3-container w3-row w3-round-bottom-large w3-padding w3-border w3-border-teal" style="height:100%;">
			<div class="w3-container w3-padding-small" style="margin:0px;padding:0px;width:100%;min-height:200px;height:auto;">
				<div class="w3-row w3-bottombar">
					<!--part 1 -->
					<div class="w3-half w3-container w3-padding-0">
						<div class="w3-row w3-padding-0">
							<div class="w3-col w3-container w3-padding-0 w3-margin-0" style="width:110px;">
								<?php if($photo=="" && $gender=="Male"){ ?>
										<img src="../images/system/male_profile.png" class="w3-image" style="margin:0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="Picture (120X100)"/>
								<?php } else if($photo==""){ ?>
										<img src="../images/system/female_profile.png" class="w3-image" style="margin:0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="Picture (120X100)"/>
								<?php } else { ?>
										<img src="../images/student/<?php echo $photo; ?>" class="w3-image" style="margin:0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="Picture (120X100)"/>
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
									<tr>
										<td colspan="2" class="w3-text-blue">
											<input type="checkbox" id="subscription" value="checked-subscription"/> 
											Subscribe Notification
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<!-- part 2 -->
					<div class="w3-half w3-container w3-padding-0">
						<table>
							<tr>
								<td valign="top">Degree</td>
								<td valign="top" class="w3-bold">: <?php echo $degree; ?></td>
							</tr>
							<tr>
								<td valign="top">Degree Credit</td>
								<td valign="top" class="w3-bold">: <?php echo $total_credit; ?></td>
							</tr>
							<tr>
								<td valign="top">Credit Earned</td>
								<td valign="top" class="w3-text-green">: <?php echo $earned_credit; ?></td>
							</tr>
							<tr>
								<td valign="top">Credit Waived</td>
								<td valign="top">: <?php echo $waived_credit; ?></td>
							</tr>
							<tr>
								<td valign="top">CGPA</td>
								<td valign="top" class="w3-text-red">: <?php echo $total_cgpa; ?></td>
							</tr>
							<tr>
								<td valign="top">Degree Status</td>
								<td valign="top" class="w3-bold">: <?php echo $degree_status; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="w3-container w3-margin-0 w3-padding-0" style="height:230px;overflow:auto;">
					<!-- Summer 2014 semester result -->
					<!-- use red in fail -->
					<!-- use blue in retake -->
					<!-- use yellow in incomplete -->
					<button class="w3-button w3-black w3-round-large w3-hover-teal w3-padding w3-left-align" style="width:100%;max-width:270px;display:block;margin:5px 0px;"><i class="fa fa-arrow-circle-o-down"></i> Semester: Summer-2014</button>
					<table style="width:90%;" class="w3-hide w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
						<tr class="w3-black w3-bold w3-padding-small">
							<td colspan="2" class="w3-padding-small">Semester: Summer-2014</td>
							<td colspan="2" class="w3-padding-small">CGPA: 4.00</td>
							<td colspan="2" class="w3-padding-small">Credit: 7.5</td>
						</tr>
						<tr class="w3-teal w3-bold">
							<td style="width:20%;" class="w3-padding-small">Course Code</td>
							<td style="width:40%;" class="w3-padding-small">Course Title</td>
							<td style="width:10%;" class="w3-padding-small">Credit</td>
							<td style="width:10%;" class="w3-padding-small">Grade</td>
							<td style="width:10%;" class="w3-padding-small">Grade Point</td>
							<td style="width:10%;" class="w3-padding-small">Remarks</td>
						</tr>
						<tr>
							<td class="w3-padding-small">CSE 111</td>
							<td class="w3-padding-small">Fundamentals of Computers</td>
							<td class="w3-padding-small">3.00</td>
							<td class="w3-padding-small">A+</td>
							<td class="w3-padding-small">4.00</td>
							<td class="w3-padding-small"></td>
						</tr>
						<tr class="w3-light-gray">
							<td class="w3-padding-small">CSE 113</td>
							<td class="w3-padding-small">Structured Programming Language</td>
							<td class="w3-padding-small">3.00</td>
							<td class="w3-padding-small">A+</td>
							<td class="w3-padding-small">4.00</td>
							<td class="w3-padding-small"></td>
						</tr>
						<tr>
							<td class="w3-padding-small">CSE 114</td>
							<td class="w3-padding-small">Structured Programming Language Lab</td>
							<td class="w3-padding-small">1.50</td>
							<td class="w3-padding-small">A+</td>
							<td class="w3-padding-small">4.00</td>
							<td class="w3-padding-small"></td>
						</tr>
					</table>
					
					<button class="w3-button w3-black w3-round-large w3-hover-teal w3-padding w3-left-align" style="width:100%;max-width:270px; display:block;margin:5px 0px;"><i class="fa fa-arrow-circle-o-down"></i> Semester: Fall-2014</button>
					<table style="width:90%;" class="w3-hide w3-border w3-round w3-border-black w3-topbar w3-bottombar w3-margin">
						<tr class="w3-black w3-bold w3-padding-small">
							<td colspan="2" class="w3-padding-small">Semester: Summer-2014</td>
							<td colspan="2" class="w3-padding-small">CGPA: 4.00</td>
							<td colspan="2"class="w3-padding-small">Credit: 7.5</td>
						</tr>
						<tr class="w3-teal w3-bold">
							<td style="width:20%;" class="w3-padding-small">Course Code</td>
							<td style="width:40%;" class="w3-padding-small">Course Title</td>
							<td style="width:10%;" class="w3-padding-small">Credit</td>
							<td style="width:10%;" class="w3-padding-small">Grade</td>
							<td style="width:10%;" class="w3-padding-small">Grade Point</td>
							<td style="width:10%;" class="w3-padding-small">Remarks</td>
						</tr>
						<tr>
							<td class="w3-padding-small">CSE 111</td>
							<td class="w3-padding-small">Fundamentals of Computers</td>
							<td class="w3-padding-small">3.00</td>
							<td class="w3-padding-small">A+</td>
							<td class="w3-padding-small">4.00</td>
							<td class="w3-padding-small"></td>
						</tr>
						<tr class="w3-light-gray">
							<td class="w3-padding-small">CSE 113</td>
							<td class="w3-padding-small">Structured Programming Language</td>
							<td class="w3-padding-small">3.00</td>
							<td class="w3-padding-small">A+</td>
							<td class="w3-padding-small">4.00</td>
							<td class="w3-padding-small"></td>
						</tr>
						<tr>
							<td class="w3-padding-small">CSE 114</td>
							<td class="w3-padding-small">Structured Programming Language Lab</td>
							<td class="w3-padding-small">1.50</td>
							<td class="w3-padding-small">A+</td>
							<td class="w3-padding-small">4.00</td>
							<td class="w3-padding-small"></td>
						</tr>
					</table>
					
				</div>
			</div>
		</div>
	</div>

<?php	
	}
	else
		header("location: index.php");
?>