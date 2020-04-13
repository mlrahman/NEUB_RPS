<?php
	try{
		require("../includes/moderator_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>
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
	function load_total_students()
	{
		var prog_id=document.getElementById('program_id').value;
		var dept_id=document.getElementById('dept_id').value;
		
		document.getElementById("total_students").innerHTML='<i class="fa fa-refresh w3-spin" title="loading..">';
		var total_students = new XMLHttpRequest();
		total_students.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("total_students").innerHTML = this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById("total_students").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i>';
			}
		};
		total_students.open("GET", "../includes/moderator_admin/get_total_students.php?moderator_id="+<?php echo $_SESSION['moderator_id']; ?>+"&program_id="+prog_id+"&dept_id="+dept_id, true);
		total_students.send();
	}
	//load_total_students();
	
	//Graduated
	function load_graduates()
	{
		var prog_id=document.getElementById('program_id').value;
		var dept_id=document.getElementById('dept_id').value;
		
		document.getElementById("graduates").innerHTML='<i class="fa fa-refresh w3-spin" title="loading..">';
	
		var graduates = new XMLHttpRequest();
		graduates.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("graduates").innerHTML = this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById("graduates").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i>';
			}
		};
		graduates.open("GET", "../includes/moderator_admin/get_graduates.php?dept_id="+dept_id+"&moderator_id="+<?php echo $_SESSION['moderator_id']; ?>+"&program_id="+prog_id, true);
		graduates.send();
	}
	//load_graduates();
	
	//Top CGPA
	function load_top_cgpa()
	{
		var prog_id=document.getElementById('program_id').value;
		var dept_id=document.getElementById('dept_id').value;
		
		document.getElementById("top_cgpa").innerHTML='<i class="fa fa-refresh w3-spin" title="loading..">';
	
		var top_cgpa = new XMLHttpRequest();
		top_cgpa.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("top_cgpa").innerHTML = this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById("top_cgpa").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i>';
			}
		};
		top_cgpa.open("GET", "../includes/moderator_admin/get_top_cgpa.php?dept_id="+dept_id+"&moderator_id="+<?php echo $_SESSION['moderator_id']; ?>+"&program_id="+prog_id, true);
		top_cgpa.send();
	}
	//load_top_cgpa();
	
	//Dropouts
	function load_dropouts()
	{
		var prog_id=document.getElementById('program_id').value;
		var dept_id=document.getElementById('dept_id').value;
		
		document.getElementById("dropouts").innerHTML='<i class="fa fa-refresh w3-spin" title="loading..">';
	
		var dropouts = new XMLHttpRequest();
		dropouts.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("dropouts").innerHTML = this.responseText;
			}
			if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
				document.getElementById("dropouts").innerHTML = '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i>';
			}
		};
		dropouts.open("GET", "../includes/moderator_admin/get_dropouts.php?dept_id="+dept_id+"&moderator_id="+<?php echo $_SESSION['moderator_id']; ?>+"&program_id="+prog_id, true);
		dropouts.send();
	}
	//load_dropouts();
</script>
