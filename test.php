<?php

include("includes/function.php");
include("includes/db_connection.php");
include("includes/library/excel_reader/SimpleXLS.php");

/*
			$student_id=140203020002;
			$group_student='';
			$student_id=$student_id.'';
			$sz=strlen($student_id);
			for($i=0;$i<$sz-3;$i++)
			{
				$group_student=$group_student.$student_id[$i];
			}
			echo $group_student.'</br>';
			$stmt=$conn->prepare("select nr_stud_id,nr_prcr_id from nr_student where nr_stud_id!=:student_id and nr_stud_id like concat(:search_text,'___') order by nr_stud_id asc ");
			$stmt->bindParam(':student_id',$student_id);
			$stmt->bindParam(':search_text',$group_student);
			$stmt->execute();
			$result=$stmt->fetchAll();
			$sz=count($result);
			echo $sz;
			for($i=0;$i<$sz;$i++)
			{
				$s_id=$result[$i][0];
				$p_id=$result[$i][1];
				//updating stud info
				$x=get_student_info($s_id,$p_id);
				$dropout=$x['dropout'];
				$graduated=$x['graduated'];
				$cgpa=$x['cgpa'];
				$last_semester=$x['last_semester'];
				$last_year=$x['last_year'];
				$drop_semester=$x['drop_semester'];
				$drop_year=$x['drop_year'];
				$earned_credit=$x['earned_credit'];
				$waived_credit=$x['waived_credit'];
				echo 'Student ID: '.$s_id.'</br>';
				echo 'Dropout: '.$dropout.'</br>';
				echo 'Graduated: '.$graduated.'</br>';
				echo 'CGPA: '.$cgpa.'</br>';
				echo 'Last semester: '.$last_semester.'</br>';
				echo 'Last Year: '.$last_year.'</br>';
				echo 'Drop semester: '.$drop_semester.'</br>';
				echo 'Drop Year: '.$drop_year.'</br>';
				echo 'Earned Credit: '.$earned_credit.'</br>';
				echo 'Waived Credit: '.$waived_credit.'</br>';
				echo '</br>-------------------------------------------------</br>';
			}
*/
?>
