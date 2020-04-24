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



<p class="w3-bold w3-left w3-xlarge w3-text-teal w3-bottombar" style="margin:0px 0px 15px 0px;width:245px;"><i class="fa fa-line-chart"></i> CGPA Statistics</p>
				
<p class="w3-right w3-padding w3-margin-0 w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-round-large">
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
	if($first_semester==$last_semester && $first_year==$last_year)
	{
		$from_semester=$first_semester;
		$first_year-=1;
		$from_year=$first_year;
	}
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
					$from_year=$q;
					$ct++;
				}
				else
					break;
				
				if(('Summer-'.$last_year)!=($first_semester.'-'.$first_year))
				{
					$from_semester='Summer';
					$from_year=$q;
					$ct++;
				}
				else 
					break;
					
				if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
				{
					$from_semester='Spring';
					$from_year=$q;
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
					$from_year=$q;
					$ct++;
				}
				else 
					break;
					
				if(('Spring-'.$last_year)!=($first_semester.'-'.$first_year))
				{
					$from_semester='Spring';
					$from_year=$q;
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
					$from_year=$q;
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
		if($ct>4)
			break;
	}
	//echo $from_year.' '.$from_semester;
	
?>
	From: 
	<select id="student_cgpa_from" onchange="get_student_cgpa_to()" type="w3-input w3-round-large">
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
	<select id="student_cgpa_to" onchange="get_student_cgpa()" type="w3-input w3-round-large">
		<option value="<?php echo $last_semester.'-'.$last_year; ?>"><?php echo $last_semester.'-'.$last_year; ?></option>
	</select>
</p>

<div class="w3-container w3-margin-0 w3-padding-0" id="student_cgpa">
	<p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>
</div>

<script>
	//generate to values
	var last_semester=<?php echo '"'.$last_semester.'"';?>;
	var last_year=parseInt(<?php echo '"'.$last_year.'"';?>);
	function get_student_cgpa_to()
	{
		document.getElementById('student_cgpa_to').innerHTML='<option value="">Loading..</option>';
		var student_cgpa_from=document.getElementById('student_cgpa_from').value;
		if(student_cgpa_from!="")
		{
			var first_semester="";
			for(var i=0;i<student_cgpa_from.length;i++)
			{
				if(student_cgpa_from[i]=='-') break;
				else
					first_semester=first_semester+student_cgpa_from[i];
			}
			var first_year=parseInt(""+student_cgpa_from[student_cgpa_from.length-4]+student_cgpa_from[student_cgpa_from.length-3]+student_cgpa_from[student_cgpa_from.length-2]+student_cgpa_from[student_cgpa_from.length-1]);
			//console.log(first_semester+" "+first_year);
			var kkr="";
			for(var q=first_year;q<=last_year;q++)
			{
				if(q==first_year)
				{
					if(first_semester=="Spring")
					{
						if(("Summer-"+first_year)!=(last_semester+"-"+last_year))
						{
							kkr=kkr+ "<option value='Summer-"+q+"'>Summer-"+q+"</option>";
						}
						else 
							break;
							
						if(("Fall-"+first_year)!=(last_semester+"-"+last_year))
						{
							kkr=kkr+ "<option value='Fall-"+q+"'>Fall-"+q+"</option>";
						}
						else
							break;
					}
					else if(first_semester=="Summer")
					{
						
						if(("Fall-"+first_year)!=(last_semester+"-"+last_year))
						{
							
							kkr=kkr+ "<option value='Fall-"+q+"'>Fall-"+q+"</option>";
						}
						else
							break;
					}
				}
				else
				{
					if(("Spring-"+q)!=(last_semester+"-"+last_year))
					{
						kkr=kkr+ "<option value='Spring-"+q+"'>Spring-"+q+"</option>";
					}
					else
						break;
					if(("Summer-"+q)!=(last_semester+"-"+last_year))
					{
						kkr=kkr+ "<option value='Summer-"+q+"'>Summer-"+q+"</option>";
					}
					else
						break;
					if(("Fall-"+q)!=(last_semester+"-"+last_year))
					{
						kkr=kkr+ "<option value='Fall-"+q+"'>Fall-"+q+"</option>";
					}
					else
						break;
				}
			}
			document.getElementById('student_cgpa_to').innerHTML='<option value="">Select</option>'+kkr+'<option value="'+last_semester+'-'+last_year+'">'+last_semester+'-'+last_year+'</option>';
			
			
		}
		
	}
	//student_cgpa
	function get_student_cgpa()
	{
		var prog_id=document.getElementById('program_id').value;
		
		var student_cgpa_from=document.getElementById('student_cgpa_from').value;
		var student_cgpa_to=document.getElementById('student_cgpa_to').value;
		if(student_cgpa_to!="" || student_cgpa_from!="")
		{

			//console.log(student_cgpa_from+' '+student_cgpa_to);
			document.getElementById('student_cgpa').innerHTML='<p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p>';
			var student_cgpa = new XMLHttpRequest();
			student_cgpa.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var arr=new Array();
					var arr2=new Array();
					
					var lab=new Array();
					
					var bgc=new Array();
					var bgc2=new Array();
					var boc=new Array();
					var boc2=new Array();
					
					var data=this.responseText;
					//console.log(data);
					
					var num_s="";
					var num=0;
					var st_sz=data.length,i;
					for(i=0;i<st_sz;i++)
					{
						if(data[i]>="0" && data[i]<="9" || data[i]=='.')
						{
							num_s=num_s+data[i];
						}
						else
						{
							num=parseFloat(num_s);
							arr.push(num);
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
						if(data[i]>="0" && data[i]<="9" || data[i]=='.')
						{
							num_s=num_s+data[i];
						}
						else
						{
							num=parseFloat(num_s);
							arr2.push(num);
							num=0;
							num_s="";
						}
						if(data[i]=="@")
							break;
					}
					
					i++;
					num_s="",num=0;
					var xx=0;
					for(;i<st_sz;i++)
					{
						if(data[i]>="0" && data[i]<="9")
						{
							num_s=num_s+data[i];
						}
						else
						{
							num=parseInt(num_s);
							xx=num;
							num=0;
							num_s="";
						}
						if(data[i]=="@")
							break;
					}
					i++;
					num_s="";
					for(;i<st_sz;i++)
					{
						if(data[i]=="%")
							break;
						if(data[i]!="@")
						{
							num_s=num_s+data[i];
						}
						else
						{
							lab.push(num_s);
							num_s="";
						}
					}
					
					
					for(var j=0;j<xx;j++)
					{
						boc.push("rgba(0, 0, 255, 0.8)");
						bgc.push("rgba(165, 42, 42, 1)");
						
						bgc2.push("rgba(255, 255, 0, 0.8)");
						boc2.push("rgba(255, 0, 0, 1)");
					}
					
					document.getElementById('student_cgpa').innerHTML='<canvas id="stu_cgpa_stat" style="width:100%;height:260px;"><p class="w3-center" style="margin: 50px 0px 0px 0px;"><i class="fa fa-refresh w3-spin"></i> Please wait!! while loading...</p></canvas>';
					
					var ctx2 = document.getElementById('stu_cgpa_stat').getContext('2d');
					var myChart2 = new Chart(ctx2, {
						type: 'line',
						data: {
							labels: lab,
							datasets: [{
								label: 'Semester Top CGPA',
								fill:false,
								borderDash: [5,5],
								data: arr,
								backgroundColor: bgc,
								borderColor: boc,
								borderWidth: 2
							},
							{
								label: 'Semester Graduates Top CGPA',
								fill:false,
								borderDash: [5,5],
								data: arr2,
								backgroundColor: bgc2,
								borderColor: boc2,
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
										labelString: 'Top CGPA'
									}
									
								}]
							}
						}
					});
					
					}
				if (this.readyState == 4 && (this.status == 403 || this.status == 404)) {
					document.getElementById("student_cgpa").innerHTML = '<p class="w3-center w3-margin"><i class="fa fa-warning w3-text-red" title="Error occured!!"> Network Error</i></p>';
				}
			};
					
			student_cgpa.open("GET", "../includes/faculty/get_student_cgpa.php?faculty_dept_id="+<?php echo $_SESSION['faculty_dept_id']; ?>+"&faculty_id="+<?php echo $_SESSION['faculty_id']; ?>+"&student_cgpa_from="+student_cgpa_from+"&student_cgpa_to="+student_cgpa_to+"&program_id="+prog_id, true);
			student_cgpa.send();
		}
	}
	//calling on page loading
	get_student_cgpa();
					
</script>