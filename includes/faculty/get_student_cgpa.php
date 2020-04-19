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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['student_cgpa_to']) && isset($_REQUEST['student_cgpa_from']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		//Data transfer format
		//echo '3.15-3.40-3.65@3@Spring-2015@Summer-2015@Fall-2015@%';
		$store_semester="@";
		
		
		function fetch_student_cgpa_data($semester,$year)
		{
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			if($program_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_result_status='Active' and a.nr_course_id=b.nr_course_id and a.nr_result_semester='$semester' and a.nr_result_year='$year' order by a.nr_stud_id asc");
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and a.nr_prog_id=:prog_id and nr_result_status='Active' and a.nr_course_id=b.nr_course_id and a.nr_result_semester='$semester' and a.nr_result_year='$year' order by a.nr_stud_id asc");
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':f_d_id', $_REQUEST['faculty_dept_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$cg=array();
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$s_id=$result[$i][1];
					$gpa=grade_point_decrypt($s_id,$result[$i][5]);
					$credit=$result[$i][16];
					if(array_key_exists($s_id,$cg))
					{
						if($gpa>0.00)
						{
							$cg[$s_id]=array('gp'=>($cg[$s_id]['gp']+($gpa*$credit)),'tc'=>($cg[$s_id]['tc']+$credit));
						}
					}
					else
					{
						if($gpa>0.00)
						{
							$cg[$s_id]=array('gp'=>($gpa*$credit),'tc'=>$credit);							
						}	
					}
				}
				$max_cgpa=0.00;
				foreach($cg as $cge)
				{
					if(($cge['gp']/$cge['tc'])>$max_cgpa)
						$max_cgpa=($cge['gp']/$cge['tc']);
				}
				return (number_format($max_cgpa, 2).'-');
			}
			else
				return '0.00-';
			
		}
		
		function fetch_student_g_cgpa_data($semester,$year)
		{
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			if($program_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_stud_status='Active' ");
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':f_d_id', $_REQUEST['faculty_dept_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$y=count($result);
				$grad_max_cgpa=0.00;
				for($index=0;$index<$y;$index++) //per student
				{
					$s_id=$result[$index][0];
					$prcr_id = $result[$index][8];
					
					$x=get_cgpa($s_id,$prcr_id);
					
					if($x!=0.00)
					{
						$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year desc, nr_result_semester desc"); 
						$stmt->bindParam(':s_id', $s_id);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)!=0)  //check for students who have results in db
						{
							$last_semester=$stud_result[0][6];
							$last_year=$stud_result[0][7];
						}
						if($last_semester==$semester && $last_year==$year)//'Graduated in the given semester'
						{
							if($x>$grad_max_cgpa)
								$grad_max_cgpa=$x;
						}
					}
				}
				return (number_format($grad_max_cgpa, 2).'-');
			}
			else
			{
				return '0.00-';
			}
		}
		
		//end of function
		
		$student_cgpa_from=$_REQUEST['student_cgpa_from'];
		$student_cgpa_to=$_REQUEST['student_cgpa_to'];
		
		$first_semester="";
		for($i=0;$i<strlen($student_cgpa_from);$i++)
		{
			if($student_cgpa_from[$i]=='-') break;
			else
				$first_semester=$first_semester.$student_cgpa_from[$i];
		}
		$first_year=$student_cgpa_from[strlen($student_cgpa_from)-4].$student_cgpa_from[strlen($student_cgpa_from)-3].$student_cgpa_from[strlen($student_cgpa_from)-2].$student_cgpa_from[strlen($student_cgpa_from)-1];
		

		
		$last_semester="";
		for($i=0;$i<strlen($student_cgpa_to);$i++)
		{
			if($student_cgpa_to[$i]=='-') break;
			else
				$last_semester=$last_semester.$student_cgpa_to[$i];
		}
		$last_year=$student_cgpa_to[strlen($student_cgpa_to)-4].$student_cgpa_to[strlen($student_cgpa_to)-3].$student_cgpa_to[strlen($student_cgpa_to)-2].$student_cgpa_to[strlen($student_cgpa_to)-1];
		/*
		echo $student_cgpa_from.' - '.$student_cgpa_to.' - ';
		echo $first_semester.'-'.$first_year;
		echo $last_semester.'-'.$last_year;
		*/
		//fetching
		$cou=0;
		$cgpa="";
		$g_cgpa="";
		for($q=$first_year;$q<=$last_year;$q++)
		{
			
			if($q==$first_year)
			{
				if($first_semester=='Spring')
				{
					$cou+=3;
					if(('Spring-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Spring-'.$q).'@';
			
						$cgpa=$cgpa.fetch_student_cgpa_data('Spring',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Spring',$q);
					}
					else
					{
						$store_semester=$store_semester.('Spring-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Spring',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Spring',$q);
						break;
					}
					
					if(('Summer-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Summer',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Summer',$q);
					}
					else 
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Summer',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Summer',$q);
						break;
					}
						
					if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
					}
					else
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
						break;
					}
				}
				else if($first_semester=='Summer')
				{
					$cou+=2;
					if(('Summer-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Summer',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Summer',$q);
					}
					else 
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Summer',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Summer',$q);
						break;
					}
					if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
					}
					else
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
						break;
					}
				}
				else if($first_semester=='Fall')
				{
					$cou+=1;							
					if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
					}
					else
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
						$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
						break;
					}
				}
			}
			else
			{
				$cou+=3;
				if(('Spring-'.$q)!=($last_semester.'-'.$last_year))
				{
					$store_semester=$store_semester.('Spring-'.$q).'@';
					$cgpa=$cgpa.fetch_student_cgpa_data('Spring',$q);
					$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Spring',$q);
				}
				else
				{
					$store_semester=$store_semester.('Spring-'.$q).'@';
					$cgpa=$cgpa.fetch_student_cgpa_data('Spring',$q);
					$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Spring',$q);
					break;
				}
				if(('Summer-'.$q)!=($last_semester.'-'.$last_year))
				{
					
					$store_semester=$store_semester.('Summer-'.$q).'@';
					$cgpa=$cgpa.fetch_student_cgpa_data('Summer',$q);
					$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Summer',$q);
				}
				else
				{
					$store_semester=$store_semester.('Summer-'.$q).'@';
					$cgpa=$cgpa.fetch_student_cgpa_data('Summer',$q);
					$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Summer',$q);
					break;
				}
				if(('Fall-'.$q)!=($last_semester.'-'.$last_year))
				{
					$store_semester=$store_semester.('Fall-'.$q).'@';
					$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
					$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
				}
				else
				{
					$store_semester=$store_semester.('Fall-'.$q).'@';
					$cgpa=$cgpa.fetch_student_cgpa_data('Fall',$q);
					$g_cgpa=$g_cgpa.fetch_student_g_cgpa_data('Fall',$q);
					break;
				}
			}
		}
		$cgpa[strlen($cgpa)-1]='@';
		$g_cgpa[strlen($g_cgpa)-1]='@';
		echo $cgpa.$g_cgpa.$cou.$store_semester.'%';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>