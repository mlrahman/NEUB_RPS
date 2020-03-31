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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['program_id2']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id2=trim($_REQUEST['program_id2']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		if($sort>4)
		{
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id)  and nr_stud_status='Active'");
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active'");
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>0)
			{
				$stu=array();
				$szz=count($result);
				for($kk=0;$kk<$szz;$kk++)
				{
					//individual student result
					$s_id=$result[$kk][0];
					$prcr_id = $result[$kk][8];
					$s_name=$result[$kk][1];
					
					//Fetching student result
					$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc"); 
					$stmt->bindParam(':s_id', $s_id);
					$stmt->execute();
					$stud_result=$stmt->fetchAll();
					$cg=array();
					$se_re=array();
					$szzzz=count($stud_result);
					for($i = 0; $i < $szzzz; $i++) {
						
						$stud_course_id=$stud_result[$i][2];
						$stud_grade_point=grade_point_decrypt($s_id,$stud_result[$i][5]);
						$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
						$stmt->execute();
						$course_result=$stmt->fetchAll();
						$stud_course_code=$course_result[0][1];
						$stud_course_credit=$course_result[0][3];
											
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
					
					//calculating earned credit
					$earned_credit=0.0;
					$earned_gpa=0.0;
					foreach($cg as $cge)
					{
						$earned_credit=$earned_credit+$cge['credit'];
						$earned_gpa=$earned_gpa+($cge['credit']*$cge['gpa']);
					}
					$earned_credit=number_format($earned_credit, 2);
					
					//Calculating cgpa from earned_credit
					if($earned_credit==0)
						$total_cgpa=number_format(0.0,2);
					else
						$total_cgpa=number_format(($earned_gpa/$earned_credit),2);
					
					//fetching waived course credits
					$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id and nr_stwacr_status='Active' "); 
					$stmt->bindParam(':s_id', $s_id);
					$stmt->execute();
					$stud_result=$stmt->fetchAll();
					$waived_credit=0.0;
					$sz5=count($stud_result);
					for($i = 0; $i < $sz5; $i++) {
						
						$stud_course_id=$stud_result[$i][2];
						$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
						$stmt->execute();
						$course_result=$stmt->fetchAll();
						$stud_course_credit=$course_result[0][3];
						
						$waived_credit=$waived_credit+$stud_course_credit;
					}
					$waived_credit=number_format($waived_credit, 2);
					
					
					//Search for student program credit
					$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
					$stmt->execute();
					$prcr_result = $stmt->fetchAll();
					if(count($prcr_result)==0)
					{
						echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
						die();
					}
					$total_credit=$prcr_result[0][2];
					
					$stu[$s_id]=array('s_id'=>$s_id,'name'=>$s_name,'earned_credit'=>$earned_credit,'total_credit'=>$total_credit,'waived_credit'=>$waived_credit,'cgpa'=>$total_cgpa);
				}
				if($sort==5)
				{
					function cmp($a, $b)
					{
						return ($a["earned_credit"]>$b["earned_credit"]);
					}
					usort($stu, "cmp");
					$count=0;
					$count2=0;
					foreach($stu as $st)
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						if($st['waived_credit']==0.00) $st['waived_credit']='N/A';
					
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['s_id'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['name'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($st['s_id']).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['earned_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['waived_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['total_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['cgpa'].'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$st['s_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else if($sort==6)
				{
					function cmp($a, $b)
					{
						return ($a["earned_credit"]<$b["earned_credit"]);
					}
					usort($stu, "cmp");
					$count=0;
					$count2=0;
					foreach($stu as $st)
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						if($st['waived_credit']==0.00) $st['waived_credit']='N/A';
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['s_id'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['name'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($st['s_id']).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['earned_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['waived_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['total_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['cgpa'].'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$st['s_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else if($sort==7)
				{
					function cmp($a, $b)
					{
						return ($a["waived_credit"]>$b["waived_credit"]);
					}
					usort($stu, "cmp");
					$count=0;
					$count2=0;
					foreach($stu as $st)
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						if($st['waived_credit']==0.00) $st['waived_credit']='N/A';
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['s_id'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['name'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($st['s_id']).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['earned_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['waived_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['total_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['cgpa'].'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$st['s_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else if($sort==8)
				{
					function cmp($a, $b)
					{
						return ($a["waived_credit"]< $b["waived_credit"]);
					}
					usort($stu, "cmp");
					$count=0;
					$count2=0;
					foreach($stu as $st)
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						if($st['waived_credit']==0.00) $st['waived_credit']='N/A';
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['s_id'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['name'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($st['s_id']).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['earned_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['waived_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['total_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['cgpa'].'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$st['s_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else if($sort==9)
				{
					function cmp($a, $b)
					{
						return ($a["cgpa"]> $b["cgpa"]);
					}
					usort($stu, "cmp");
					$count=0;
					$count2=0;
					foreach($stu as $st)
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						if($st['waived_credit']==0.00) $st['waived_credit']='N/A';
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['s_id'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['name'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($st['s_id']).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['earned_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['waived_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['total_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['cgpa'].'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$st['s_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				else if($sort==10)
				{
					function cmp($a, $b)
					{
						return ($a["cgpa"]< $b["cgpa"]);
					}
					usort($stu, "cmp");
					$count=0;
					$count2=0;
					foreach($stu as $st)
					{
						$count++;
						if($count<=$page) continue;
						$count2++;
						if($count2>5) break;
						if($st['waived_credit']==0.00) $st['waived_credit']='N/A';
						echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['s_id'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['name'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($st['s_id']).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['earned_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['waived_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['total_credit'].'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$st['cgpa'].'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$st['s_id'].')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
					}
				}
				
				
			}
		}
		else
		{
			if($sort==1)
			{
				$order_by='nr_stud_id';
				$order='asc';
			}
			else if($sort==2)
			{
				$order_by='nr_stud_id';
				$order='desc';
			}
			else if($sort==3)
			{
				$order_by='nr_stud_name';
				$order='asc';
			}
			else if($sort==4)
			{
				$order_by='nr_stud_name';
				$order='desc';
			}
			if($program_id2==-1)
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id)  and nr_stud_status='Active' order by ".$order_by." ".$order." limit $page,5");
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active' order by ".$order_by." ".$order." limit $page,5");
				$stmt->bindParam(':prog_id', $program_id2);
			}
			$stmt->bindParam(':f_d_id', $faculty_dept_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)>0)
			{
				$sz10=count($result);
				for($kk=0;$kk<$sz10;$kk++)
				{
					//individual student result
					$s_id=$result[$kk][0];
					$prcr_id = $result[$kk][8];
					$s_name=$result[$kk][1];
					
					//Fetching student result
					$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc"); 
					$stmt->bindParam(':s_id', $s_id);
					$stmt->execute();
					$stud_result=$stmt->fetchAll();
					$cg=array();
					$se_re=array();
					$sz7=count($stud_result);
					for($i = 0; $i < $sz7; $i++) {
						
						$stud_course_id=$stud_result[$i][2];
						$stud_grade_point=grade_point_decrypt($s_id,$stud_result[$i][5]);
						$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
						$stmt->execute();
						$course_result=$stmt->fetchAll();
						$stud_course_code=$course_result[0][1];
						$stud_course_credit=$course_result[0][3];
											
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
					
					//calculating earned credit
					$earned_credit=0.0;
					$earned_gpa=0.0;
					foreach($cg as $cge)
					{
						$earned_credit=$earned_credit+$cge['credit'];
						$earned_gpa=$earned_gpa+($cge['credit']*$cge['gpa']);
					}
					$earned_credit=number_format($earned_credit, 2);
					
					//Calculating cgpa from earned_credit
					if($earned_credit==0)
						$total_cgpa=number_format(0.0,2);
					else
						$total_cgpa=number_format(($earned_gpa/$earned_credit),2);
					
					//fetching waived course credits
					$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id and nr_stwacr_status='Active' "); 
					$stmt->bindParam(':s_id', $s_id);
					$stmt->execute();
					$stud_result=$stmt->fetchAll();
					$waived_credit=0.0;
					$sz6=count($stud_result);
					for($i = 0; $i < $sz6; $i++) {
						
						$stud_course_id=$stud_result[$i][2];
						$stmt = $conn->prepare("select * from nr_course where nr_course_id='$stud_course_id'"); 
						$stmt->execute();
						$course_result=$stmt->fetchAll();
						$stud_course_credit=$course_result[0][3];
						
						$waived_credit=$waived_credit+$stud_course_credit;
					}
					$waived_credit=number_format($waived_credit, 2);
					
					
					//Search for student program credit
					$stmt = $conn->prepare("select * from nr_program_credit where nr_prcr_id=$prcr_id");
					$stmt->execute();
					$prcr_result = $stmt->fetchAll();
					if(count($prcr_result)==0)
					{
						echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
						die();
					}
					$total_credit=$prcr_result[0][2];
					if($waived_credit==0.00) $waived_credit='N/A';
					echo '<tr>
							<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$s_id.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$s_name.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.get_session($s_id).'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$earned_credit.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$waived_credit.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$total_credit.'</td>
							<td valign="top" class="w3-padding-small w3-border">'.$total_cgpa.'</td>
							<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result('.$s_id.')"><i class="fa fa-envelope-open-o"></i> View</a></td>
						</tr>';
				}
			}
			
		}
		
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>