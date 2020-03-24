
<?php
	try{
		require("../includes/faculty/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>
<!-- Right Column -->
<div class="w3-twothird w3-margin-top">

	<!-- Dashboard -->
	<div class="w3-container w3-card w3-white w3-margin-bottom w3-border w3-border-black w3-round-large" style="height:603px;padding:0px;" id="faculty_dashboard">
	
		<div class="w3-bar w3-black w3-card w3-padding" style="border-radius:7px 7px 0px 0px;">
			<p id="page_title" class="w3-xlarge" style="margin:8px;"><i class="fa fa-dashboard"></i> Faculty Dashboard</p>
		</div>
		
		<div class="w3-container" style="height:530px;overflow:auto;padding:0px;margin:0px;">
			<!-- Dashboard basic box-->
			<div class="w3-row-padding w3-margin-bottom w3-margin-top">
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-users w3-xxlarge w3-text-orange"></i></div>
						<div class="w3-right">
							<p id="total_students" class="w3-margin-0 w3-xlarge w3-text-blue"><i class="fa fa-refresh w3-spin" title="loading.."></i></p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Total Students</p>
					</div>
				</div>
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-graduation-cap w3-xxlarge w3-text-green"></i></div>
						<div class="w3-right">
							<p id="graduates" class="w3-margin-0 w3-xlarge w3-text-blue"><i class="fa fa-refresh w3-spin" title="loading.."></i></p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Graduates</p>
					</div>
				</div>
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-trophy w3-xxlarge w3-text-purple"></i></div>
						<div class="w3-right">
							<p id="top_cgpa" class="w3-margin-0 w3-xlarge w3-text-blue"><i class="fa fa-refresh w3-spin" title="loading.."></i></p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Top CGPA</p>
					</div>
				</div>
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-user-times w3-xxlarge w3-text-red"></i></div>
						<div class="w3-right">
							<p id="dropouts" class="w3-margin-0 w3-xlarge w3-text-blue"><i class="fa fa-refresh w3-spin" title="loading.."></i></p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Dropouts</p>
					</div>
				</div>
				
				<script>
				//Total Students
					var total_students = new XMLHttpRequest();
					total_students.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("total_students").innerHTML = this.responseText;
						}
						if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
							document.getElementById("total_students").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
						}
					};
					total_students.open("GET", "../includes/faculty/get_total_students.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>, true);
					total_students.send();
					
					//Graduated
					var graduates = new XMLHttpRequest();
					graduates.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("graduates").innerHTML = this.responseText;
						}
						if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
							document.getElementById("graduates").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
						}
					};
					graduates.open("GET", "../includes/faculty/get_graduates.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>, true);
					graduates.send();
					
					//Top CGPA
					var top_cgpa = new XMLHttpRequest();
					top_cgpa.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("top_cgpa").innerHTML = this.responseText;
						}
						if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
							document.getElementById("top_cgpa").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
						}
					};
					top_cgpa.open("GET", "../includes/faculty/get_top_cgpa.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>, true);
					top_cgpa.send();
					
					//Dropouts
					var dropouts = new XMLHttpRequest();
					dropouts.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("dropouts").innerHTML = this.responseText;
						}
						if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
							document.getElementById("dropouts").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
						}
					};
					dropouts.open("GET", "../includes/faculty/get_dropouts.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>, true);
					dropouts.send();
				
				</script>
				
				
			</div>
			
			<!-- Students Grpah -->
			<div class="w3-container w3-margin-bottom">
				<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:270px;"><i class="fa fa-bar-chart-o"></i> Student Statistics</p>
				
				<p class="w3-right w3-margin-top w3-padding-0">
				<?php
					$stmt = $conn->prepare("SELECT * FROM nr_result where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc");
					$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
					$stmt->execute();
					$stud_result=$stmt->fetchAll();
					if(count($stud_result)!=0)  //check for students who have results in db
					{
						$first_semester=$stud_result[0][6];
						$first_year=$stud_result[0][7];
					}
					
					//echo $first_semester.'-'.$first_year;
					
					$stmt = $conn->prepare("SELECT * FROM nr_result where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and  nr_result_status='Active' order by nr_result_year desc, nr_result_semester desc");
					$stmt->bindParam(':dept_id', $_SESSION['faculty_dept_id']);
					$stmt->execute();
					$stud_result=$stmt->fetchAll();
					if(count($stud_result)!=0)  //check for students who have results in db
					{
						$last_semester=$stud_result[0][6];
						$last_year=$stud_result[0][7];
					}
					
					//echo $last_semester.'-'.$last_year;
					
					//getting initial from semester
					$ct=0;
					for($q=$last_year;$q>=$first_year;$q--)
					{
						if($q==$last_year)
						{
							if($last_semester=='Fall')
							{
								if(('Fall-'.$last_year)!=($first_semester.'-'.$first_year))
								{
									$from_semester='Fall';
									$from_year=$last_year;
									$ct++;
								}
								else
									break;
								
								if(('Summer-'.$last_year)!=($first_semester.'-'.$first_year))
								{
									$from_semester='Summer';
									$from_year=$last_year;
									$ct++;
								}
								else 
									break;
									
								if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
								{
									$from_semester='Spring';
									$from_year=$last_year;
									$ct++;
								}
								else
									break;
							}
							else if($last_semester=='Summer')
							{
								if(('Summer-'.$last_year)!=($first_semester.'-'.$first_year))
								{
									$from_semester='Summer';
									$from_year=$last_year;
									$ct++;
								}
								else 
									break;
									
								if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
								{
									$from_semester='Spring';
									$from_year=$last_year;
									$ct++;
								}
								else
									break;
							}
							else if($last_semester=='Spring')
							{
																		
								if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
								{
									$from_semester='Spring';
									$from_year=$last_year;
									$ct++;
								}
								else
									break;
							}
						}
						else
						{
							if(('Fall-'.$q)!=($first_semester.'-'.$first_year))
							{
								$from_semester='Fall';
								$from_year=$q;
								$ct++;
							}
							else
								break;
							
							if(('Summer-'.$q)!=($first_semester.'-'.$first_year))
							{
								$from_semester='Summer';
								$from_year=$q;
								$ct++;
							}
							else
								break;
							
							if(('Spring-'.$q)!=($first_semester.'-'.$first_year))
							{
								$from_semester='Spring';
								$from_year=$q;
								$ct++;
							}
							else
								break;
						}
						
						if($ct==5)
							break;
					}
					
				?>
					From: 
					<select id="student_graph_from" onchange="get_student_graph_to()" type="w3-input w3-round-large">
						<option value="<?php echo $from_semester.'-'.$from_year; ?>"><?php echo $from_semester.'-'.$from_year; ?></option>
						<?php
							for($q=$first_year;$q<=$last_year;$q++)
							{
								if($q==$first_year)
								{
									if($first_semester=='Spring')
									{
										if(('Spring-'.$first_year)!=($last_semester.'-'.$last_year))
										{
											if(($from_semester.'-'.$from_year)!=('Spring-'.$first_year))
												echo '<option value="'.'Spring-'.$q.'">'.'Spring-'.$q.'</option>';
										}
										else
											break;
										
										if(('Summer-'.$first_year)!=($last_semester.'-'.$last_year))
										{
											if(($from_semester.'-'.$from_year)!=('Summer-'.$first_year))	
												echo '<option value="'.'Summer-'.$q.'">'.'Summer-'.$q.'</option>';
										}
										else 
											break;
											
										if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
										{
											if(($from_semester.'-'.$from_year)!=('Fall-'.$first_year))
												echo '<option value="'.'Fall-'.$q.'">'.'Fall-'.$q.'</option>';
										}
										else
											break;
									}
									else if($first_semester=='Summer')
									{
										if(('Summer-'.$first_year)!=($last_semester.'-'.$last_year))
										{
											if(($from_semester.'-'.$from_year)!=('Summer-'.$first_year))
												echo '<option value="'.'Summer-'.$q.'">'.'Summer-'.$q.'</option>';
										}
										else 
											break;
											
										if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
										{
											if(($from_semester.'-'.$from_year)!=('Fall-'.$first_year))
												echo '<option value="'.'Fall-'.$q.'">'.'Fall-'.$q.'</option>';
										}
										else
											break;
									}
									else if($first_semester=='Fall')
									{
																				
										if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
										{
											if(($from_semester.'-'.$from_year)!=('Fall-'.$first_year))
												echo '<option value="'.'Fall-'.$q.'">'.'Fall-'.$q.'</option>';
										}
										else
											break;
									}
								}
								else
								{
									if(('Spring-'.$q)!=($last_semester.'-'.$last_year))
									{
										if(($from_semester.'-'.$from_year)!=('Spring-'.$q))
											echo '<option value="'.'Spring-'.$q.'">'.'Spring-'.$q.'</option>';
									}
									else
										break;
									if(('Summer-'.$q)!=($last_semester.'-'.$last_year))
									{
										if(($from_semester.'-'.$from_year)!=('Summer-'.$q))	
											echo '<option value="'.'Summer-'.$q.'">'.'Summer-'.$q.'</option>';
									}
									else
										break;
									if(('Fall-'.$q)!=($last_semester.'-'.$last_year))
									{
										if(($from_semester.'-'.$from_year)!=('Fall-'.$q))
											echo '<option value="'.'Fall-'.$q.'">'.'Fall-'.$q.'</option>';
									}
									else
										break;
								}
							}
						?>
					</select> 
					To: 
					<select id="student_graph_to" onchange="get_student_graph()" type="w3-input w3-round-large">
						<option value="<?php echo $last_semester.'-'.$last_year; ?>"><?php echo $last_semester.'-'.$last_year; ?></option>
					</select>
				</p>
				
				<canvas id="stu_stat" style="width:100%;height:260px;">
					<p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>
				</canvas>
				
			
			
		
				<script>
					//generate to values
					function get_student_graph_to()
					{
						document.getElementById('student_graph_to').innerHTML='<option value="">Loading..</option>';
					}
					//student_graph
					function get_student_graph()
					{
						var student_graph_from=document.getElementById('student_graph_from').value;
						var student_graph_to=document.getElementById('student_graph_to').value;
						if(student_graph_to!="")
						{
							//console.log(student_graph_from+' '+student_graph_to);
							var student_graph = new XMLHttpRequest();
							student_graph.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									var arr1=new Array();
									var arr2=new Array();
									var arr3=new Array();
									
									var lab=new Array("Spring-2018", "Summer-2018", "Fall-2018", "Spring-2019", "Summer-2019", "Fall-2019");
									
									var bgc1=new Array("rgba(0, 128, 0, 0.5)","rgba(0, 128, 0, 0.5)","rgba(0, 128, 0, 0.5)","rgba(0, 128, 0, 0.5)","rgba(0, 128, 0, 0.5)","rgba(0, 128, 0, 0.5)");
									var boc1=new Array("rgba(0, 128, 0, 1)","rgba(0, 128, 0, 1)","rgba(0, 128, 0, 1)","rgba(0, 128, 0, 1)","rgba(0, 128, 0, 1)","rgba(0, 128, 0, 1)");
									
									var bgc2=new Array("rgba(54, 162, 235, 0.5)","rgba(54, 162, 235, 0.5)","rgba(54, 162, 235, 0.5)","rgba(54, 162, 235, 0.5)","rgba(54, 162, 235, 0.5)","rgba(54, 162, 235, 0.5)");
									var boc2=new Array("rgba(54, 162, 235, 1)","rgba(54, 162, 235, 1)","rgba(54, 162, 235, 1)","rgba(54, 162, 235, 1)","rgba(54, 162, 235, 1)","rgba(54, 162, 235, 1)");
									
									var bgc3=new Array("rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)");
									var boc3=new Array("rgba(255, 99, 132, 1)","rgba(255, 99, 132, 1)","rgba(255, 99, 132, 1)","rgba(255, 99, 132, 1)","rgba(255, 99, 132, 1)","rgba(255, 99, 132, 1)");

									var data=this.responseText;
									var num_s="";
									var num=0;
									var st_sz=data.length,i;
									for(i=0;i<st_sz;i++)
									{
										if(data[i]>="0" && data[i]<="9")
										{
											num_s=num_s+data[i];
										}
										else
										{
											num=parseInt(num_s);
											arr1.push(num);
											num=0;
											num_s="";
										}
										if(data[i]=="@")
											break;
									}
									i++;
									num_s="",num=0;
									for(;i<st_sz;i++)
									{
										if(data[i]>="0" && data[i]<="9")
										{
											num_s=num_s+data[i];
										}
										else
										{
											num=parseInt(num_s);
											arr2.push(num);
											num=0;
											num_s="";
										}
										if(data[i]=="@")
											break;
									}
									i++;
									num_s="",num=0;
									for(;i<st_sz;i++)
									{
										if(data[i]>="0" && data[i]<="9")
										{
											num_s=num_s+data[i];
										}
										else
										{
											num=parseInt(num_s);
											arr3.push(num);
											num=0;
											num_s="";
										}
										if(data[i]=="@")
											break;
									}
									
									//grpah area
									var ctx = document.getElementById('stu_stat').getContext('2d');
									var myChart = new Chart(ctx, {
										type: 'bar',
										data: {
											labels: lab,
											datasets: [{
												label: 'New Students',
												data: arr1,
												backgroundColor: bgc1,
												borderColor: boc1,
												borderWidth: 2
											},
											{
												label: 'Graduated Students',
												data: arr2,
												backgroundColor: bgc2,
												borderColor: boc2,
												borderWidth: 2
											},
											{
												label: 'Dropout Students',
												data: arr3,
												backgroundColor: bgc3,
												borderColor: boc3,
												borderWidth: 2
											}
											
											]
										},
										options : {
											
											scales: {
												xAxes: [{
													display:true,
													scaleLabel: {
														display:true,
														labelString: 'Semesters'
													},
													gridLines: {
														offsetGridLines: true
													}
												}],
												yAxes: [{
													display:true,
													scaleLabel: {
														display:true,
														labelString: 'Number of Students'
													}
												}]
											}
										}
									});
									
								}
								if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
									document.getElementById("stu_stat").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
								}
							};
							student_graph.open("GET", "../includes/faculty/get_student_graph.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&student_graph_from="+student_graph_from+"&student_graph_to="+student_graph_to, true);
							student_graph.send();
						}
					}
					//calling on page loading
					get_student_graph();
				</script>
			</div>
			
			<!-- CGPA Grpah -->
			<div class="w3-container w3-margin-bottom">
				<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:270px;"><i class="fa fa-bar-chart-o"></i> CGPA Statistics</p>
			
				<canvas id="cgpa_stat" style="width:100%;height:260px;">
					<p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>
				</canvas>
				<script>
					var ctx2 = document.getElementById('cgpa_stat').getContext('2d');
					var myChart2 = new Chart(ctx2, {
						type: 'line',
						data: {
							labels: ['Spring-2018', 'Summer-2018', 'Fall-2018', 'Spring-2019', 'Summer-2019', 'Fall-2019'],
							datasets: [{
								label: 'Semester Top CGPA',
								fill:false,
								borderDash: [5,5],
								data: [3.86, 3.50, 3.95, 4.00, 3.80, 3.56],
								backgroundColor: [
									'rgba(0, 0, 255, 0.6)',
									'rgba(0, 0, 255, 0.6)',
									'rgba(0, 0, 255, 0.6)',
									'rgba(0, 0, 255, 0.6)',
									'rgba(0, 0, 255, 0.6)',
									'rgba(0, 0, 255, 0.6)'
								],
								borderColor: [
									'rgba(128, 0, 128, 1)'
									
								],
								borderWidth: 2
							}]						
						},
						options : {
							
							scales: {
								xAxes: [{
									display:true,
									scaleLabel: {
										display:true,
										labelString: 'Semesters'
									},
									gridLines: {
										offsetGridLines: true
									}
								}],
								yAxes: [{
									display:true,
									scaleLabel: {
										display:true,
										labelString: 'Top CGPA'
									}
									
								}]
							}
						}
					});
					
				</script>
			</div>
			
			<!-- Students Recent Results -->
			<div class="w3-container w3-margin-bottom">
				<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:270px;"><i class="fa fa-bar-chart-o"></i> Recent Results</p>
			
			
				<table style="width:100%;" class="w3-border w3-round w3-border-black w3-topbar w3-bottombar">
					<tr class="w3-teal w3-bold">
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Semester</td>
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Student ID</td>
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Course Code</td>
						<td style="width:30%;" vertical-align="top" class="w3-padding-small">Course Title</td>
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Credit</td>
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Grade</td>
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Grade Point</td>
						<td style="width:10%;" vertical-align="top" class="w3-padding-small">Remarks</td>
					</tr>
					<tr>
						<td vertical-align="top" class="w3-padding-small">Fall-2018</td>
						<td vertical-align="top" class="w3-padding-small">140203020002</td>
						<td vertical-align="top" class="w3-padding-small">CSE 111</td>
						<td vertical-align="top" class="w3-padding-small">Fundamentals of Computers</td>
						<td vertical-align="top" class="w3-padding-small">3.00</td>
						<td vertical-align="top" class="w3-padding-small">A+</td>
						<td vertical-align="top" class="w3-padding-small">4.00</td>
						<td vertical-align="top" class="w3-padding-small"></td>
					</tr><tr>
						<td vertical-align="top" class="w3-padding-small">Fall-2018</td>
						<td vertical-align="top" class="w3-padding-small">140203020002</td>
						<td vertical-align="top" class="w3-padding-small">CSE 111</td>
						<td vertical-align="top" class="w3-padding-small">Fundamentals of Computers</td>
						<td vertical-align="top" class="w3-padding-small">3.00</td>
						<td vertical-align="top" class="w3-padding-small">A+</td>
						<td vertical-align="top" class="w3-padding-small">4.00</td>
						<td vertical-align="top" class="w3-padding-small"></td>
					</tr><tr>
						<td vertical-align="top" class="w3-padding-small">Fall-2018</td>
						<td vertical-align="top" class="w3-padding-small">140203020002</td>
						<td vertical-align="top" class="w3-padding-small">CSE 111</td>
						<td vertical-align="top" class="w3-padding-small">Fundamentals of Computers</td>
						<td vertical-align="top" class="w3-padding-small">3.00</td>
						<td vertical-align="top" class="w3-padding-small">A+</td>
						<td vertical-align="top" class="w3-padding-small">4.00</td>
						<td vertical-align="top" class="w3-padding-small"></td>
					</tr><tr>
						<td vertical-align="top" class="w3-padding-small">Fall-2018</td>
						<td vertical-align="top" class="w3-padding-small">140203020002</td>
						<td vertical-align="top" class="w3-padding-small">CSE 111</td>
						<td vertical-align="top" class="w3-padding-small">Fundamentals of Computers</td>
						<td vertical-align="top" class="w3-padding-small">3.00</td>
						<td vertical-align="top" class="w3-padding-small">A+</td>
						<td vertical-align="top" class="w3-padding-small">4.00</td>
						<td vertical-align="top" class="w3-padding-small"></td>
					</tr><tr>
						<td vertical-align="top" class="w3-padding-small">Fall-2018</td>
						<td vertical-align="top" class="w3-padding-small">140203020002</td>
						<td vertical-align="top" class="w3-padding-small">CSE 111</td>
						<td vertical-align="top" class="w3-padding-small">Fundamentals of Computers</td>
						<td vertical-align="top" class="w3-padding-small">3.00</td>
						<td vertical-align="top" class="w3-padding-small">A+</td>
						<td vertical-align="top" class="w3-padding-small">4.00</td>
						<td vertical-align="top" class="w3-padding-small"></td>
					</tr>
					
					
					<tr>
						<td colspan="8">
							<p class="w3-center w3-margin-0"><a class="w3-cursor w3-bold w3-text-blue w3-decoration-null w3-margin-bottom" style="margin:5px 0px;">Show More <i class="fa fa-sort-down"></i></a></p>
						</td>
					</tr>
				</table>
				
			</div>
			
			
			
			
		</div>
		
		
	</div>

</div>