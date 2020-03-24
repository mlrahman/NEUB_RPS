<<<<<<< HEAD
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
				<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:270px;"><i class="fa fa-bar-chart-o"></i> Student Statistics</p>
			
				
				<canvas id="stu_stat" style="width:100%;height:260px;">
					<p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>
				</canvas>
				<script>
					var ctx = document.getElementById('stu_stat').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['Spring-2018', 'Summer-2018', 'Fall-2018', 'Spring-2019', 'Summer-2019', 'Fall-2019'],
							datasets: [{
								label: 'New Students',
								data: [86, 36, 19, 67, 35, 25],
								backgroundColor: [
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)'
								],
								borderColor: [
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)'
								],
								borderWidth: 2
							},
							{
								label: 'Graduated Students',
								data: [25, 16, 05, 08, 12, 14],
								backgroundColor: [
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)'
								],
								borderColor: [
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)'
								],
								borderWidth: 2
							},
							{
								label: 'Dropout Students',
								data: [5, 6, 2, 0, 1, 12],
								backgroundColor: [
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)'
								],
								borderColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)'
								],
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
=======
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
							<p class="w3-margin-0 w3-xlarge w3-text-blue">456</p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Total Students</p>
					</div>
				</div>
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-graduation-cap w3-xxlarge w3-text-green"></i></div>
						<div class="w3-right">
							<p class="w3-margin-0 w3-xlarge w3-text-blue">52</p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Graduates</p>
					</div>
				</div>
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-trophy w3-xxlarge w3-text-purple"></i></div>
						<div class="w3-right">
							<p class="w3-margin-0 w3-xlarge w3-text-blue">3.98</p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Top CGPA</p>
					</div>
				</div>
				<div class="w3-quarter w3-margin-bottom">
					<div class="w3-container w3-padding-16 w3-round-large w3-border w3-topbar w3-bottombar w3-leftbar w3-rightbar">
						<div class="w3-left"><i class="fa fa-user-times w3-xxlarge w3-text-red"></i></div>
						<div class="w3-right">
							<p class="w3-margin-0 w3-xlarge w3-text-blue">15</p>
						</div>
						<div class="w3-clear w3-margin-bottom"></div>
						<p class="w3-bold w3-large w3-margin-0">Dropouts</p>
					</div>
				</div>
			</div>
			
			<!-- Students Grpah -->
			<div class="w3-container w3-margin-bottom">
				<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:270px;"><i class="fa fa-bar-chart-o"></i> Student Statistics</p>
			
				
				<canvas id="stu_stat" style="width:100%;height:260px;">
					<p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>
				</canvas>
				<script>
					var ctx = document.getElementById('stu_stat').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['Spring-2018', 'Summer-2018', 'Fall-2018', 'Spring-2019', 'Summer-2019', 'Fall-2019'],
							datasets: [{
								label: 'New Students',
								data: [86, 36, 19, 67, 35, 25],
								backgroundColor: [
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)',
									'rgba(0, 128, 0, 0.5)'
								],
								borderColor: [
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)',
									'rgba(0, 128, 0, 1)'
								],
								borderWidth: 2
							},
							{
								label: 'Graduated Students',
								data: [25, 16, 05, 08, 12, 14],
								backgroundColor: [
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)',
									'rgba(54, 162, 235, 0.5)'
								],
								borderColor: [
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 162, 235, 1)'
								],
								borderWidth: 2
							},
							{
								label: 'Dropout Students',
								data: [5, 6, 2, 0, 1, 12],
								backgroundColor: [
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)',
									'rgba(255, 99, 132, 0.5)'
								],
								borderColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)',
									'rgba(255, 99, 132, 1)'
								],
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
>>>>>>> 3cbad3b731067af9672d2b64dd4ddf93db2f86d7
</div>