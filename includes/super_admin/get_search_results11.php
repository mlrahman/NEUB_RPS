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
	if(isset($_REQUEST['sort']) && isset($_REQUEST['search_results_from']) && isset($_REQUEST['user_type']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['program_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$dept_id=trim($_REQUEST['dept_id']);
		$program_id=trim($_REQUEST['program_id']);
		$user_type=trim($_REQUEST['user_type']);
		$page=trim($_REQUEST['search_results_from']);
		$sort=trim($_REQUEST['sort']);
		
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and d.nr_admin_type!='Super Admin' ";
		}
		
		$data=array();
		
		if($user_type==-1) //All - student,faculty,moderator,admin,super admin
		{
			
			//student 
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b where a.nr_stud_id=b.nr_stud_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][0],'user_type'=>'Student','user_name'=>$result[$i][11],'user_search_date'=>$result[$i][7],'user_search_time'=>$result[$i][8]);
				}
			}
			
			//faculty
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>'Faculty','user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
			
			//moderator admin super_admin
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
			
		}
		else if($user_type==1) //Student
		{
			//student 
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b where a.nr_stud_id=b.nr_stud_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_result_check_transaction a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and (b.nr_stud_id like concat('%',:search_text,'%') or b.nr_stud_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>'Student','user_name'=>$result[$i][11],'user_search_date'=>$result[$i][7],'user_search_time'=>$result[$i][8]);
				}
			}
			
		}
		else if($user_type==2) //Faculty
		{
			//faculty
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_faculty_result_check_transaction a,nr_student b,nr_program c,nr_faculty d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_faculty_id=d.nr_faculty_id and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_faculty_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>'Faculty','user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		else if($user_type==3) //moderator
		{
			$filter=" and d.nr_admin_type=='Moderator' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		else if($user_type==4) //admin
		{
			$filter=" and d.nr_admin_type=='Admin' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		else if($user_type==5 && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$filter=" and d.nr_admin_type=='Super Admin' ";
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%'))");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_admin_result_check_transaction a,nr_student b,nr_program c,nr_admin d where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_admin_id=d.nr_admin_id ".$filter." and (a.nr_stud_id like concat('%',:search_text,'%') or d.nr_admin_name like concat('%',:search_text,'%')) ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':search_text', $search_text); $stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=0)
			{
				$sz=count($result);
				for($i=0;$i<$sz;$i++)
				{
					$data[count($data)-1]=array('student_id'=>$result[$i][0],'user_id'=>$result[$i][1],'user_type'=>$result[$i][32],'user_name'=>$result[$i][27],'user_search_date'=>$result[$i][8],'user_search_time'=>$result[$i][9]);
				}
			}
		}
		if($sort==2)
		{
			function cmp($a, $b)
			{
				if($a["student_id"]<$b["student_id"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==1)
		{
			function cmp($a, $b)
			{
				if($a["student_id"]>$b["student_id"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==4)
		{
			function cmp($a, $b)
			{
				if($a["user_name"]<$b["user_name"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==3)
		{
			function cmp($a, $b)
			{
				if($a["user_name"]>$b["user_name"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==6)
		{
			function cmp($a, $b)
			{
				if($a["user_search_date"]<$b["user_search_date"])
				{
					return true;
				}
				else if($a["user_search_date"]==$b["user_search_date"] && $a["user_search_time"]<$b["user_search_time"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		else if($sort==5)
		{
			function cmp($a, $b)
			{
				if($a["user_search_date"]>$b["user_search_date"])
				{
					return true;
				}
				else if($a["user_search_date"]==$b["user_search_date"] && $a["user_search_time"]>$b["user_search_time"])
				{
					return true;
				}
				return false;
			}
			usort($data, "cmp");
		}
		$count=0;
		$count2=0;
		foreach($data as $r)
		{
			$count++;
			if($count<=$page) continue;
			$count2++;
			if($count2>5) break;
			echo '<tr>
					<td valign="top" class="w3-padding-small w3-border">'.++$page.'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$r['student_id'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$r['user_name'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$r['user_type'].'</td>
					<td valign="top" class="w3-padding-small w3-border">'.get_date($r['user_search_date']).'</td>
					<td valign="top" class="w3-padding-small w3-border">'.$r['user_search_time'].'</td>
					<td valign="top" class="w3-padding-small w3-border"><a class="w3-text-blue w3-cursor w3-decoration-null w3-bold" onclick="view_result11(\''.$r['user_type'].'\',\''.$r['user_id'].'\',\''.$r['student_id'].'\',\''.$r['user_search_date'].'\',\''.$r['user_search_time'].'\')"><i class="fa fa-envelope-open-o"></i> View</a></td>
				</tr>';				
		}
		if($count==0)
			echo '<tr><td colspan="7"><p class="w3-center w3-text-red" style="margin: 10px 0px 10px 0px;"><i class="fa fa-warning"></i> No result available</p> </td></tr>';
		
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>
