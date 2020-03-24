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
	if(isset($_REQUEST['student_graph_to']) && isset($_REQUEST['student_graph_from']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		//Data transfer format
		//echo '86-36-19-67-35-25@20-15-25-10-18-12@2-5-7-12-3-1@';
		$store_semester="@";
		
		function fetch_student_graph_data_admission($semester,$year)
		{
			require("../db_connection.php");
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id)  and nr_stud_status='Active' ");
			$stmt->bindParam(':f_d_id', $_REQUEST['faculty_dept_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$sz=count($result);
			$ac=0;
			for($data=0;$data<$sz;$data++)
			{
				$s_id=$result[$data][0];
				if(get_session($s_id)==($semester.'-'.$year))
					$ac++;
			}
			return $ac.'-';
		}
		
		function fetch_student_graph_data_graduates($semester,$year)
		{
			return '10-';
		}
		
		function fetch_student_graph_data_dropouts($semester,$year)
		{
			return '15-';
		}
		
		$student_graph_from=$_REQUEST['student_graph_from'];
		$student_graph_to=$_REQUEST['student_graph_to'];
		
		$first_semester="";
		for($i=0;$i<strlen($student_graph_from);$i++)
		{
			if($student_graph_from[$i]=='-') break;
			else
				$first_semester=$first_semester.$student_graph_from[$i];
		}
		$first_year=$student_graph_from[strlen($student_graph_from)-4].$student_graph_from[strlen($student_graph_from)-3].$student_graph_from[strlen($student_graph_from)-2].$student_graph_from[strlen($student_graph_from)-1];
		

		
		$last_semester="";
		for($i=0;$i<strlen($student_graph_to);$i++)
		{
			if($student_graph_to[$i]=='-') break;
			else
				$last_semester=$last_semester.$student_graph_to[$i];
		}
		$last_year=$student_graph_to[strlen($student_graph_to)-4].$student_graph_to[strlen($student_graph_to)-3].$student_graph_to[strlen($student_graph_to)-2].$student_graph_to[strlen($student_graph_to)-1];
		/*
		echo $student_graph_from.' - '.$student_graph_to.' - ';
		echo $first_semester.'-'.$first_year;
		echo $last_semester.'-'.$last_year;
		*/
		//fetching
		$cou=0;
		$admission="";
		$graduates="";
		$dropouts="";
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
			
						$admission=$admission.fetch_student_graph_data_admission('Spring',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Spring',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Spring',$q);
					}
					else
					{
						$store_semester=$store_semester.('Spring-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Spring',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Spring',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Spring',$q);
						break;
					}
					
					if(('Summer-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Summer',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Summer',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Summer',$q);
					}
					else 
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Summer',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Summer',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Summer',$q);
						break;
					}
						
					if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
					}
					else
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
						break;
					}
				}
				else if($first_semester=='Summer')
				{
					$cou+=2;
					if(('Summer-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Summer',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Summer',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Summer',$q);
					}
					else 
					{
						$store_semester=$store_semester.('Summer-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Summer',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Summer',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Summer',$q);
						break;
					}
					if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
					}
					else
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
						break;
					}
				}
				else if($first_semester=='Fall')
				{
					$cou+=1;							
					if(('Fall-'.$first_year)!=($last_semester.'-'.$last_year))
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
					}
					else
					{
						$store_semester=$store_semester.('Fall-'.$q).'@';
						$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
						$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
						$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
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
					$admission=$admission.fetch_student_graph_data_admission('Spring',$q);
					$graduates=$graduates.fetch_student_graph_data_graduates('Spring',$q);
					$dropouts=$dropouts.fetch_student_graph_data_dropouts('Spring',$q);
				}
				else
				{
					$store_semester=$store_semester.('Spring-'.$q).'@';
					$admission=$admission.fetch_student_graph_data_admission('Spring',$q);
					$graduates=$graduates.fetch_student_graph_data_graduates('Spring',$q);
					$dropouts=$dropouts.fetch_student_graph_data_dropouts('Spring',$q);
					break;
				}
				if(('Summer-'.$q)!=($last_semester.'-'.$last_year))
				{
					
					$store_semester=$store_semester.('Summer-'.$q).'@';
					$admission=$admission.fetch_student_graph_data_admission('Summer',$q);
					$graduates=$graduates.fetch_student_graph_data_graduates('Summer',$q);
					$dropouts=$dropouts.fetch_student_graph_data_dropouts('Summer',$q);
				}
				else
				{
					$store_semester=$store_semester.('Summer-'.$q).'@';
					$admission=$admission.fetch_student_graph_data_admission('Summer',$q);
					$graduates=$graduates.fetch_student_graph_data_graduates('Summer',$q);
					$dropouts=$dropouts.fetch_student_graph_data_dropouts('Summer',$q);
					break;
				}
				if(('Fall-'.$q)!=($last_semester.'-'.$last_year))
				{
					$store_semester=$store_semester.('Fall-'.$q).'@';
					$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
					$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
					$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
				}
				else
				{
					$store_semester=$store_semester.('Fall-'.$q).'@';
					$admission=$admission.fetch_student_graph_data_admission('Fall',$q);
					$graduates=$graduates.fetch_student_graph_data_graduates('Fall',$q);
					$dropouts=$dropouts.fetch_student_graph_data_dropouts('Fall',$q);
					break;
				}
			}
		}
		$admission[strlen($admission)-1]='@';
		$graduates[strlen($graduates)-1]='@';
		$dropouts[strlen($dropouts)-1]='@';
		echo $admission.$graduates.$dropouts.$cou.$store_semester.'%';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>