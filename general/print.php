<?php
	require_once '../includes/library/autoload.inc.php';

	use Dompdf\Dompdf;
	$dompdf = new Dompdf();
	
		
	if(isset($_GET['s_id']) && isset($_GET['dob']))
	{
		try{
			$s_id=$_GET['s_id'];
			$dob=$_GET['dob'];
			ob_start();
			require("../includes/db_connection.php");
			require("../includes/function.php");
			$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id and nr_stud_dob=:dob and nr_stud_status='Active' limit 1 ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':dob', $dob);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if(count($result)==0)
			{
				header("location: index.php");
				die();
			}
			
			//Check details will insert into transaction
			$vis_ip = getVisIPAddr();
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip));
			if($vis_ip=="")$vis_ip="N/A";
			$country=$ipdat->geoplugin_countryName;
			if($country=="")$country="N/A";
			$city=$ipdat->geoplugin_city;
			if($city=="")$city="N/A";
			$lat=$ipdat->geoplugin_latitude;
			if($lat=="")$lat="N/A";
			$lng=$ipdat->geoplugin_longitude;
			if($lng=="")$lng="N/A";
			$timezone=$ipdat->geoplugin_timezone;
			if($timezone=="")$timezone="N/A";
			$date=get_current_date();
			$time=get_current_time();
			$stmt = $conn->prepare("insert into nr_result_check_transaction values(:s_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','Active') ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			
			
			$name = $result[0][1];
			$reg_no = $result[0][0];
			$session = get_session($reg_no);
			$gender = $result[0][3];
			$birthdate = $result[0][2];
			$subscription_email = $result[0][4];
			$prog_id = $result[0][7];
			$prcr_id = $result[0][8];
			
			//Search for student program
			$stmt = $conn->prepare("select * from nr_program where nr_prog_id=$prog_id");
			$stmt->execute();
			$prog_result = $stmt->fetchAll();
			$degree = $prog_result[0][1];
			
			
			//Search for student program credit
			$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
			$stmt->execute();
			$prcr_result = $stmt->fetchAll();
			$total_credit=$prcr_result[0][2];
			
			
			//Fetching student result
			$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' "); 
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			$cg=array();
			$se_re=array();
			for($i = 0; $i < count($stud_result); $i++) {
				
				$stud_result_id=$stud_result[$i][0];
				$stud_course_id=$stud_result[$i][2];
				$stud_marks=marks_decrypt($s_id,$stud_result[$i][3]);
				$stud_grade=grade_decrypt($s_id,$stud_result[$i][4]);
				$stud_grade_point=grade_point_decrypt($s_id,$stud_result[$i][5]);
				$stud_semester=$stud_result[$i][6];
				$stud_year=$stud_result[$i][7];
				$stud_remarks=$stud_result[$i][8];
				//$stud_status=$stud_result[$i][9];
				$stud_prog_id=$stud_result[$i][10];
				$stud_pub_date=$stud_result[$i][11];
				//echo '--> '.$stud_result_id.' --- '.$stud_marks.' --- '.$stud_grade.' --- '.$stud_grade_point.' --- '.$stud_course_id.'</br>';
				$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
				$stmt->execute();
				$course_result=$stmt->fetchAll();
				$stud_course_code=$course_result[0][1];
				$stud_course_title=$course_result[0][2];
				$stud_course_credit=$course_result[0][3];
				//echo '--> '.$stud_course_code.' --- '.$stud_course_title.' --- '.$stud_course_credit.'</br>';
				$abc=array('course_code'=>$stud_course_code,'course_title'=>$stud_course_title,'course_credit'=>$stud_course_credit,'grade'=>$stud_grade,'marks'=>$stud_marks,'grade_point'=>$stud_grade_point,'semester'=>$stud_semester,'year'=>$stud_year,'remarks'=>$stud_remarks);
				
				//Storing data for showing in tables
								
				if(array_key_exists(($stud_semester.'-'.$stud_year),$se_re))
				{
					$se_re[($stud_semester.'-'.$stud_year)][count($se_re[($stud_semester.'-'.$stud_year)])]=$abc;
				}
				else
					$se_re[($stud_semester.'-'.$stud_year)][0]=$abc;
				
				
				//Calculating cg and credits by checking unique and best result
				if(array_key_exists($stud_course_code,$cg))
				{
					$prev_grade_point=$cg[$stud_course_code]['gpa'];
					if($stud_grade_point>=$prev_grade_point)
						$cg[$stud_course_code]=array('credit'=>$stud_course_credit,'gpa'=>$stud_grade_point);
				}
				else
				{
					if($stud_grade_point>0.0)
						$cg[$stud_course_code]=array('credit'=>$stud_course_credit,'gpa'=>$stud_grade_point);
				}
				
			}
			
			$earned_credit=0.0;
			$earned_gpa=0.0;
			foreach($cg as $cge)
			{
				$earned_credit=$earned_credit+$cge['credit'];
				$earned_gpa=$earned_gpa+($cge['credit']*$cge['gpa']);
			}
			$earned_credit=number_format($earned_credit, 2);
			

					
			//fetching waived course result
			$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id and nr_stwacr_status='Active' "); 
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			$ra_w=array();
			for($i = 0; $i < count($stud_result); $i++) {
				
				$stud_stwacr_id=$stud_result[$i][0];
				$stud_course_id=$stud_result[$i][2];
				$stud_pub_date=$stud_result[$i][3];
				//echo '--> '.$stud_result_id.' --- '.$stud_marks.' --- '.$stud_grade.' --- '.$stud_grade_point.' --- '.$stud_course_id.'</br>';
				$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
				$stmt->execute();
				$course_result=$stmt->fetchAll();
				$stud_course_code=$course_result[0][1];
				$stud_course_title=$course_result[0][2];
				$stud_course_credit=$course_result[0][3];
				
				$abc=array('course_code'=>$stud_course_code,'course_title'=>$stud_course_title,'course_credit'=>$stud_course_credit);
				
				//Storing data for showing in tables
				$ra_w[$i]=$abc;	
			}
			
			$waived_credit=0.0; 
			foreach($ra_w as $cge)
			{
				$waived_credit=$waived_credit+$cge['course_credit'];
			}
			
			$waived_credit=number_format($waived_credit, 2);
			
			
			
			//Calculating cgpa from earned_credit
			$total_cgpa=number_format(($earned_gpa/$earned_credit),2); 
			
			
			$degree_status=$total_credit-($earned_credit+$waived_credit);
			if($degree_status==0)
				$degree_status='Completed';
			else
				$degree_status='Not Completed';
			
			
			
			$photo=$result[0][6];
			$info['photo']=$photo;
			
			if($waived_credit==0) $waived_credit='N/A';
				
				
			
			
			/*******************************************/
			
			
			
			$html='
			<style>
			.header, .header-space,
			.footer, .footer-space {
			  height: 100px;
			}
			.header {
			  position: fixed;
			  top: 0;
			}
			.footer {
			  position: fixed;
			  bottom: 0;
			}
			</style>
			<body style="font-family: "Century Schoolbook", sans-serif;">
			
			<div class="header">
				<div style="margin:0px;padding:0px;width:100%;max-width:800px;">
					<image src="../images/system/logo.png" alt="NEUB LOGO" style="width:100%;max-width:90px;float:left;">
					<p style="float:left;margin: 5px 0px 0px 0px;font-size:45px;">North East University Bangladesh</p>
					<p style="float:left;font-size:30px;margin:0px 0px 20px 160px;">Sylhet, Bangladesh.</p>
				</div>
				<div style="border-top:4px solid black;margin: 0px;padding:0px;width:100%;max-width:750px;height:auto;clear:left;display:block;">
					<p style="color:red;font-size:10px;text-align:justify;">
						<b>Note:</b> This is an unofficial transcript downloaded from North East University Bangladesh result portal. For any query you can visit the official website, result portal or can contact with the controller of examination. 
					</p>
					<p style="font-weight:bold;">Online Transcript of Academic Record</p>
							
					<div>
						<div style="width:50%;min-width:350px;float:left;">
							<div>
								<div style="width:110px;float:left;">';
									if($photo=="" && $gender=="Male"){ 
										$html=$html.'<img src="../images/system/male_profile.png" class="w3-image" style="margin:0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="Picture (120X100)"/>';
									} else if($photo==""){ 
										$html=$html.'<img src="../images/system/female_profile.png" class="w3-image" style="margin:0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="Picture (120X100)"/>';
									} else { 
										$html=$html.'<img src="../images/student/'.$photo.'" class="w3-image" style="margin:0px;padding:0px;width:100%;max-width:100px;height: 120px;" title="Picture (120X100)"/>';
									}
									
								$html=$html.'</div>
								<div style="min-width:200px;float:left;">
									<table>
										<tr>
											<td valign="top">Name</td>
											<td valign="top" class="w3-bold">: '.$name.'</td>
										</tr>
										<tr>
											<td valign="top">Reg. No</td>
											<td valign="top" class="w3-bold">: '.$reg_no.'</td>
										</tr>
										<tr>
											<td valign="top">Session</td>
											<td valign="top">: '.$session.'</td>
										</tr>
										<tr>
											<td valign="top">Gender</td>
											<td valign="top">: '.$gender.'</td>
										</tr>
										<tr>
											<td valign="top">Birthdate</td>
											<td valign="top">: '.get_date($birthdate).'</td>
										</tr>
										<tr>
											<td valign="top" style="font-weight:bold;">Issue Date</td>
											<td valign="top" style="font-weight:bold;">: '.get_date(get_current_date()).'</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div style="width:50%;min-width:350px;float:left;">
							<table style="width:100%;">
								<tr>
									<td valign="top">Degree</td>
									<td colspan="2" valign="top" class="w3-bold">: '.$degree.'</td>
								</tr>
								<tr>
									<td valign="top">Degree Credit</td>
									<td colspan="2" valign="top" class="w3-bold">: '.$total_credit.'</td>
								</tr>
								<tr>
									<td valign="top">Credit Earned</td>
									<td colspan="2" valign="top" class="w3-text-green">: '.$earned_credit.'</td>
								</tr>
								<tr>
									<td valign="top">Credit Waived</td>
									<td colspan="2" valign="top">: '.$waived_credit.'</td>
								</tr>
								<tr>
									<td valign="top">CGPA</td>
									<td colspan="2" valign="top" class="w3-text-red">: '.$total_cgpa.'</td>
								</tr>
								<tr>
									<td valign="top">Degree Status</td>
									<td valign="top" class="w3-bold">: '.$degree_status.'</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="footer">
			
			</div>
			
			
			<table>
				<thead>
					<tr><td>
						<div class="header-space">&nbsp;</div>
					</td></tr>
				</thead>
				<tbody><tr><td>
					
					
				</td></tr></tbody>
				<tfoot><tr><td>
				
				</td></tr></tfoot>
				</table>
			</body>';
			
			$dompdf->loadHtml($html);

			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('Legal', 'portrait');

			// Render the HTML as PDF
			$dompdf->render();

			// Output the generated PDF to Browser
			$dompdf->stream();
			//echo $html;
			


			
		}
		catch(Exception $e)
		{
			header("location: index.php");
		}
	
?>
<?php	
	}
	else
		header("location: index.php");
	
?>