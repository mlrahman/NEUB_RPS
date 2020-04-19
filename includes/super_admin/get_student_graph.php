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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['student_graph_to']) && isset($_REQUEST['student_graph_from']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		//Data transfer format
		//echo '86-36-19-67-35-25@20-15-25-10-18-12@2-5-7-12-3-1@';
		$store_semester="@";
		
		function fetch_student_graph_data_admission($semester,$year)
		{
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			$dept_id=trim($_REQUEST['dept_id']);
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_stud_status='Active' ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_stud_status='Active' ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
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
			//fetching given semester graduates
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			$dept_id=trim($_REQUEST['dept_id']);
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_stud_status='Active' ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_stud_status='Active' ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$y=count($result);
				$grad=0;
				for($index=0;$index<$y;$index++) //per student
				{
					$s_id=$result[$index][0];
					$prcr_id = $result[$index][8];
					
					if(check_graduate($s_id,$prcr_id)==true)
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
						if($last_semester==$semester && $last_year==$year)
							$grad++;  //'Graduated'
					}
				}
				return ($grad.'-');
			}
			else
			{
				return '0-';
			}
			
		}
		
		function fetch_student_graph_data_dropouts($semester,$year)
		{
			//fetching given semester dropouts
			require("../db_connection.php");
			$program_id=trim($_REQUEST['program_id']);
			$dept_id=trim($_REQUEST['dept_id']);
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_stud_status='Active' ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_stud_status='Active' ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:dept_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>=1)
			{
				$c_y=count($result);
				$drop=0;
				for($index=0;$index<$c_y;$index++)
				{
					$s_id=$result[$index][0];
					$prcr_id = $result[$index][8];
					
					if(check_graduate($s_id,$prcr_id)==false)
					{
						$stmt = $conn->prepare("SELECT * FROM nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year desc, nr_result_semester desc");
						$stmt->bindParam(':s_id', $s_id);
						$stmt->execute();
						$stud_result=$stmt->fetchAll();
						if(count($stud_result)!=0)  //check for students who have results in db
						{
							$last_semester=$stud_result[0][6];
							$last_year=$stud_result[0][7];
							$current_semester=$semester;
							$current_year=$year;
							if($last_year<=$current_year && ((($current_semester="Spring" || $current_semester="Fall" || $current_semester="Summer") && $last_semester="Fall") || (($current_semester="Spring" || $current_semester="Summer") && $last_semester="Summer") || (($current_semester="Spring") && $last_semester="Spring")))
							{
								$gap=0;
								for($y=$last_year;$y<=$current_year;$y++)
								{
									if($y==$last_year)
									{
										if($last_semester=='Spring')
										{
											if(('Spring-'.$last_year)!=($current_semester.'-'.$current_year))
												$gap++;
											else
												break;
											
											if(('Summer-'.$last_year)!=($current_semester.'-'.$current_year))
												$gap++;
											else 
												break;
												
											if(('Fall-'.$last_year)!=($current_semester.'-'.$current_year))
												$gap++;
											else
												break;
										}
										else if($last_semester=='Summer')
										{
											if(('Summer-'.$last_year)!=($current_semester.'-'.$current_year))
												$gap++;
											else 
												break;
												
											if(('Fall-'.$last_year)!=($current_semester.'-'.$current_year))
												$gap++;
											else
												break;
										}
										else if($last_semester=='Fall')
										{
																					
											if(('Fall-'.$last_year)!=($current_semester.'-'.$current_year))
												$gap++;
											else
												break;
										}
									}
									else
									{
										if(('Spring-'.$y)!=($current_semester.'-'.$current_year))
												$gap++;
										else
											break;
										
										if(('Summer-'.$y)!=($current_semester.'-'.$current_year))
											$gap++;
										else 
											break;
											
										if(('Fall-'.$y)!=($current_semester.'-'.$current_year))
											$gap++;
										else
											break;
									}
								}
								
								if($gap==2)  //last available semester result and student available semester result difference 
								{
									$drop++;
								}
							}
						}
						
					}
				}
				return $drop.'-';
			}
			else
			{
				return '0-';
			}
		}
		//end of function
		
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