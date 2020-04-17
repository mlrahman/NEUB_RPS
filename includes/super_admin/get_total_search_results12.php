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
	if(isset($_REQUEST['user_type']) && isset($_REQUEST['dept_id']) && isset($_REQUEST['program_id']) && isset($_REQUEST['search_text']) && isset($_REQUEST['admin_id']) &&  $_REQUEST['admin_id']==$_SESSION['admin_id'])
	{
		$admin_id=trim($_REQUEST['admin_id']);
		$search_text=trim($_REQUEST['search_text']);
		$dept_id=trim($_REQUEST['dept_id']);
		$user_type=trim($_REQUEST['user_type']);
		$program_id=trim($_REQUEST['program_id']);
		$filter='';
		if($_SESSION['admin_type']!='Super Admin')
		{
			$filter=" and nr_trprre_printed_by!='Super Admin' ";
		}
		
		if($user_type==-1) //all
		{
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' ".$filter);
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' ".$filter);
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' ".$filter);
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' ".$filter);
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
		}
		else if($user_type==1) //student
		{
			$user_ty='Student';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==2) //Faculty
		{
			$user_ty='Faculty';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==3) //Moderator
		{
			$user_ty='Moderator';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==4) //Admin
		{
			$user_ty='Admin';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		else if($user_type==5  && $_SESSION['admin_type']=='Super Admin') //super admin
		{
			$user_ty='Super Admin';
			if($program_id==-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference where nr_trprre_status='Active' and nr_trprre_printed_by=:user_type ");
			}
			else if($program_id==-1 && $dept_id!=-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
			}
			else if($program_id!=-1 && $dept_id==-1)
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':prog_id', $program_id);
			}
			else
			{
				$stmt = $conn->prepare("select * from nr_transcript_print_reference a,nr_student b,nr_program c where a.nr_stud_id=b.nr_stud_id and c.nr_prog_id=b.nr_prog_id and c.nr_dept_id=:dept_id and c.nr_prog_id=:prog_id and a.nr_trprre_status='Active' and a.nr_trprre_printed_by=:user_type ");
				$stmt->bindParam(':dept_id', $dept_id);
				$stmt->bindParam(':prog_id', $program_id);
			}
			$stmt->bindParam(':user_type', $user_ty);
		}
		
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>0)
		{
			$sz=count($result);
			$count=0;
			for($i=0;$i<$sz;$i++)
			{
				$role=$result[$i][1];
				$ref=$result[$i][11];
				$user_id=$result[$i][2];
				if($role=='Faculty')
				{
					$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_id='$user_id' ");
					$stmt->execute();
					$t_result = $stmt->fetchAll();
					if($search_text!='' && (stripos($t_result[0][1], $search_text) !== false || stripos($ref, $search_text) !== false))
					{
						$count++;
					}
					else if($search_text=='')
					{
						$count++;
					}
				}
				else if($role=='Student')
				{
					$stmt = $conn->prepare("select * from nr_student where nr_stud_id='$user_id' ");
					$stmt->execute();
					$t_result = $stmt->fetchAll();
					if($search_text!='' && (stripos($t_result[0][1], $search_text) !== false || stripos($ref, $search_text) !== false))
					{
						$count++;
					}
					else if($search_text=='')
					{
						$count++;
					}
				}
				else
				{
					$stmt = $conn->prepare("select * from nr_admin where nr_admin_id='$user_id' ");
					$stmt->execute();
					$t_result = $stmt->fetchAll();
					if($search_text!='' && (stripos($t_result[0][1], $search_text) !== false || stripos($ref, $search_text) !== false))
					{
						$count++;
					}
					else if($search_text=='')
					{
						$count++;
					}
				}
			}
			echo $count;
		}
		else
		{
			echo '0';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occurred!!"> Error</i>';
	}
?>
