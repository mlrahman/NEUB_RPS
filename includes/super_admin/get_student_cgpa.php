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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['student_cgpa_to']) && isset($_REQUEST['student_cgpa_from']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		//Data transfer format
		//echo '3.15-3.40-3.65@3@Spring-2015@Summer-2015@Fall-2015@%';
		$store_semester="@";
		
		
		function fetch_student_cgpa_data($semester,$year)
		{
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			$dept_id=trim($_REQUEST['dept_id']);
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select max(a.nr_studsc_cgpa) from nr_student_semester_cgpa a,nr_student b where b.nr_stud_status='Active' and a.nr_stud_id=b.nr_stud_id and a.nr_studsc_semester='$semester' and a.nr_studsc_year='$year' ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select max(a.nr_studsc_cgpa) from nr_student_semester_cgpa a,nr_student b where b.nr_stud_status='Active' and a.nr_stud_id=b.nr_stud_id and b.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_studsc_semester='$semester' and a.nr_studsc_year='$year' ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select max(a.nr_studsc_cgpa) from nr_student_semester_cgpa a,nr_student b where b.nr_stud_status='Active' and a.nr_stud_id=b.nr_stud_id and b.nr_prog_id=:prog_id and a.nr_studsc_semester='$semester' and a.nr_studsc_year='$year' ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select max(a.nr_studsc_cgpa) from nr_student_semester_cgpa a,nr_student b where b.nr_stud_status='Active' and a.nr_stud_id=b.nr_stud_id and b.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and b.nr_prog_id=:prog_id and a.nr_studsc_semester='$semester' and a.nr_studsc_year='$year' ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				if($result[0][0]=='')
					return '0.00-';
				else
					return number_format($result[0][0],2).'-';
			}
			else
				return '0.00-';
			
		}
		
		function fetch_student_g_cgpa_data($semester,$year)
		{
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			$dept_id=trim($_REQUEST['dept_id']);
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select max(b.nr_studi_cgpa) from nr_student a,nr_student_info b where a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id  and b.nr_studi_last_semester='$semester' and b.nr_studi_last_year='$year' ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select max(b.nr_studi_cgpa) from nr_student a,nr_student_info b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id  and b.nr_studi_last_semester='$semester' and b.nr_studi_last_year='$year' ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select max(b.nr_studi_cgpa) from nr_student a,nr_student_info b where a.nr_prog_id=:prog_id and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id  and b.nr_studi_last_semester='$semester' and b.nr_studi_last_year='$year' ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select max(b.nr_studi_cgpa) from nr_student a,nr_student_info b where a.nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and a.nr_prog_id=:prog_id and a.nr_stud_status='Active' and b.nr_studi_graduated=1 and a.nr_stud_id=b.nr_stud_id  and b.nr_studi_last_semester='$semester' and b.nr_studi_last_year='$year' ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				if($result[0][0]=='')
					return '0.00-';
				else
					return number_format($result[0][0],2).'-';
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