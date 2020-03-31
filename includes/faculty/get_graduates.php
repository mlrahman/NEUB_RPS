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
	if(isset($_REQUEST['program_id']) && isset($_REQUEST['faculty_dept_id']) && isset($_REQUEST['faculty_id']) && $_REQUEST['faculty_dept_id']==$_SESSION['faculty_dept_id'] && $_REQUEST['faculty_id']==$_SESSION['faculty_id'])
	{
		$program_id=trim($_REQUEST['program_id']);
		$faculty_id=trim($_REQUEST['faculty_id']);
		$faculty_dept_id=trim($_REQUEST['faculty_dept_id']);
		if($program_id==-1)
		{
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_stud_status='Active' ");
		}
		else
		{
			$stmt = $conn->prepare("select * from nr_student where nr_prog_id in (select nr_prog_id from nr_program where nr_dept_id=:f_d_id) and nr_prog_id=:prog_id and nr_stud_status='Active' ");
			$stmt->bindParam(':prog_id', $program_id);
		}
		$stmt->bindParam(':f_d_id', $faculty_dept_id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$y=count($result);
			$grad=0;
			for($index=0;$index<$y;$index++)
			{
				$s_id=$result[$index][0];
				$prcr_id = $result[$index][8];
				
				//Fetching student result
				$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc"); 
				$stmt->bindParam(':s_id', $s_id);
				$stmt->execute();
				$stud_result=$stmt->fetchAll();
				$cg=array();
				$se_re=array();
				$sz1=count($stud_result);
				for($i = 0; $i < $sz1; $i++) {
					
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
				foreach($cg as $cge)
				{
					$earned_credit=$earned_credit+$cge['credit'];
				}
				$earned_credit=number_format($earned_credit, 2);
				
				//fetching waived course credits
				$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id and nr_stwacr_status='Active' "); 
				$stmt->bindParam(':s_id', $s_id);
				$stmt->execute();
				$stud_result=$stmt->fetchAll();
				$waived_credit=0.0;
				$sz2=count($stud_result);
				for($i = 0; $i < $sz2; $i++) {
					
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
				
				
				
				$degree_status=$total_credit-($earned_credit+$waived_credit);
				if($degree_status==0)
					$grad++;  //'Graduated'
			}
			echo $grad;
		}
		else
		{
			echo 'N/A';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>