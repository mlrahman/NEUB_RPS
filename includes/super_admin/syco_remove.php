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
	if(isset($_REQUEST['pass']) && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']==$_SESSION['admin_id'] && $_SESSION['admin_type']=='Super Admin')
	{
		if(password_encrypt(trim($_REQUEST['pass']))==$_SESSION['admin_password'])
		{
			$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:admin_id");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$admin_name=$result[0][1];
			$admin_designation=$result[0][7];
			//file delete server info required to update if needed
			$base_directory = '../../images/system/';
			
			
			$stmt = $conn->prepare("select * from nr_system_component a, nr_admin b where a.nr_admin_id=b.nr_admin_id and a.nr_syco_status='Active' order by a.nr_syco_id desc limit 1 ");
			$stmt->execute();
			$result = $stmt->fetchAll();
				
			if(count($result)!=0) 
			{
				$syco_id=$result[0][0];
				$old_video=$result[0][15];
				if($old_video!="")
				{
					unlink($base_directory.$old_video);
					$date=get_current_date();
					$stmt = $conn->prepare("update nr_system_component set nr_syco_video='', nr_admin_id=:admin_id where nr_syco_id=1 ");
					$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
					$stmt->execute();
					$return_msg='Ok@'.get_date($date).'@'.$admin_name.'@'.$admin_designation.'@';
					echo $return_msg;
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
		}
		else
		{
			echo 'Error@-@-@-@-@';
		}
	}
	else
	{
		echo '<i class="fa fa-warning w3-text-red" title="Error occured!!"> Error</i>';
	}
?>