<?php
	if(isset($_REQUEST['sign_in']) && isset($_REQUEST['faculty_email']) && isset($_REQUEST['faculty_password']))
	{
		try
		{
			ob_start();
			session_start();
			require("../includes/db_connection.php");
			require("../includes/function.php");
			
			$email=trim($_REQUEST['faculty_email']);
			$password=password_encrypt(trim($_REQUEST['faculty_password']));
			
			
			$stmt = $conn->prepare("select * from nr_faculty where nr_faculty_email=:email and nr_faculty_password=:password ");
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $password);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if(count($result)==0)
			{
				$_SESSION['error']='Sorry! invalid email or password.';
				header("location: index.php");
				die();
			}
			else
			{
				if($result[0][11]=='Active')
				{
					if($result[0][4]=='')
					{
						$faculty_id=$result[0][0];
						//Check details will insert into transaction
						$vis_ip = getVisIPAddr();
						$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip));
						if($vis_ip=="")$vis_ip="N/A";
						$country=$ipdat->geoplugin_countryName;
						if($country=="")$country="N/A";
						$city=$ipdat->geoplugin_city;
						if($city=="")$city="N/A";
						$lat=$ipdat->geoplugin_latitude;
						if($lat=="")$lat="N/A";
						$lng=$ipdat->geoplugin_longitude;
						if($lng=="")$lng="N/A";
						$timezone=$ipdat->geoplugin_timezone;
						if($timezone=="")$timezone="N/A";
						$date=get_current_date();
						$time=get_current_time();
						$stmt = $conn->prepare("insert into nr_faculty_login_transaction values(:f_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','Active') ");
						$stmt->bindParam(':f_id', $faculty_id);
						$stmt->execute();
						
						$_SESSION['faculty_id']=$faculty_id;
						$_SESSION['faculty_email']=$result[0][8];
						$_SESSION['faculty_password']=$result[0][7];
						$_SESSION['faculty_two_factor_status']=$result[0][10];
						$_SESSION['faculty_two_factor_check']='N';
						$_SESSION['faculty_time']=$time;
						$_SESSION['faculty_date']=$date;
						$_SESSION['faculty_dept_id']=$result[0][6];
						$_SESSION['done']='Hi! '.$result[0][1].'. Welcome to the faculty panel';
						
						if(isset($_REQUEST['re_faculty']))
						{
							if(!isset($_COOKIE['faculty_login']) || !isset($_COOKIE['faculty_email']) || !isset($_COOKIE['faculty_password']))
							{
								setcookie('faculty_login', 'save', time() + (86400 * 30));
								setcookie('faculty_email', $email, time() + (86400 * 30));
								setcookie('faculty_password', $_REQUEST['faculty_password'], time() + (86400 * 30));
							}
						}
						else
						{
							//echo 'deleted';
							setcookie('faculty_login', "", time() - (86400 * 30));
							setcookie('faculty_email', "", time() - (86400 * 30));
							setcookie('faculty_password', "", time() - (86400 * 30));
						}
						
						//redirecting logged in page
						
						session_write_close();
						header("location: f_index.php");
						die();
						//echo 'ok';
						
					}
					else
					{
						$_SESSION['error']='Sorry! you resigned from NEUB.';
						session_write_close();
						header("location: index.php");
						die();
					}
				}
				else
				{
					$_SESSION['error']='Sorry! your account is inactive.';
					session_write_close();
					header("location: index.php");
					die();
				}
			}
		}
		catch(Exception $e)
		{
			$_SESSION['error']='Sorry! system error occurred.';
			session_write_close();
			header("location: index.php");
			die();
		}
	}
	else
	{
		header("location: index.php");
		die();
	}
?>