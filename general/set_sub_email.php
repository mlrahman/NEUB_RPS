<?php
	if(isset($_GET['s_id']) && isset($_GET['dob']) && isset($_GET['email']))
	{
		$s_id=$_GET['s_id'];
		$dob=$_GET['dob'];
		$email=$_GET['email'];
		require("../includes/db_connection.php");
		require("../includes/function.php");
		$stmt = $conn->prepare("select * from nr_student where nr_stud_id=:s_id and nr_stud_dob=:dob and nr_stud_status='Active' limit 1 ");
		$stmt->bindParam(':s_id', $s_id);
		$stmt->bindParam(':dob', $dob);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if(count($result)==0)
		{
			echo 'not_done';
			die();
		}
		else
		{
			$stmt = $conn->prepare("update nr_student set nr_stud_email=:email where nr_stud_id=:s_id and nr_stud_dob=:dob ");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->bindParam(':dob', $dob);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			echo 'done';
		}
	}
	else
		header("location: index.php");
?>
		
