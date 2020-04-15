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
	if(isset($_REQUEST['id']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'] && $_SESSION['admin_type']=='Super Admin')
	{
		$stmt = $conn->prepare("select * from nr_system_component a, nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_syco_status='Active' order by a.nr_syco_id desc limit 1 ");
		$stmt->execute();
		$result = $stmt->fetchAll();
			
		if(count($result)!=0) 
		{
			if(trim($_REQUEST['id'])==1)
			{
				$logo=$result[0][13];
				echo 'Ok@'.$logo.'@';
			}
			else if(trim($_REQUEST['id'])==2)
			{
				$video_alt=$result[0][14];
				echo 'Ok@'.$video_alt.'@';
			}
			else if(trim($_REQUEST['id'])==3)
			{
				$video=$result[0][15];
				echo 'Ok@'.$video.'@';
			}
		}
		else
		{
			echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
		}
	
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>
	