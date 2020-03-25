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