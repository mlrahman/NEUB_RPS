<<<<<<< HEAD
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
						
						$f_name=$result[0][1];
						$_SESSION['faculty_name']=$f_name;
						$_SESSION['faculty_id']=$faculty_id;
						$_SESSION['faculty_email']=$result[0][8];
						$_SESSION['faculty_password']=$result[0][7];
						$_SESSION['faculty_two_factor_status']=$result[0][12];
						$_SESSION['faculty_two_factor_check']='N';
						$_SESSION['faculty_time']=$time;
						$_SESSION['faculty_date']=$date;
						$_SESSION['faculty_dept_id']=$result[0][6];
						$_SESSION['done']='Hi! '.$f_name.'. Welcome to the faculty panel';
						$_SESSION['otp_count']=0;
						
						if(isset($_REQUEST['re_faculty']))
						{
							if(!isset($_COOKIE['faculty_login']) || !isset($_COOKIE['faculty_email']) || !isset($_COOKIE['faculty_password']) || $_COOKIE['faculty_email']!=$email || $_COOKIE['faculty_password']!=$_REQUEST['faculty_password'])
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
						
						//clearing previous OTPs & Forget My Password links
						$stmt = $conn->prepare("delete from nr_faculty_link_token where nr_faculty_id=:f_id");
						$stmt->bindParam(':f_id', $faculty_id);
						$stmt->execute();
						
						//send otp if two factor enabled
						if($_SESSION['faculty_two_factor_status']==1)
						{
							$iotp=get_otp();
							$d=get_current_date();
							$t=get_current_time();
							//Inserting new OTPs
							$stmt = $conn->prepare("insert into nr_faculty_link_token values(:f_id,'$iotp','Two Factor','$d','$t','Active') ");
							$stmt->bindParam(':f_id', $faculty_id);
							$stmt->execute();
							
							
							$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)==0)
							{
								echo 'System not ready';
								die();
							}
							$title=$result[0][2];
							$contact_email=$result[0][9];
							
							//sending new OTP to user
							$msg="Dear ".$f_name.", Your Two Factor Authentication OTP is: ".$iotp;
							$message = '<html><body>';
							$message .= '<h1>Two Factor Authentication OTP From - '.$title.'</h1><p>  </p>';
							$message .= '<p><b>Message Details:</b></p>';
							$message .= '<p>'.$msg.'</p></body></html>';
							
							
							sent_mail($_SESSION['faculty_email'],$title.' - OTP for Two Factor Authentication',$message,$title,$contact_email);
						}
						
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
=======
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
						
						$f_name=$result[0][1];
						$_SESSION['faculty_name']=$f_name;
						$_SESSION['faculty_id']=$faculty_id;
						$_SESSION['faculty_email']=$result[0][8];
						$_SESSION['faculty_password']=$result[0][7];
						$_SESSION['faculty_two_factor_status']=$result[0][12];
						$_SESSION['faculty_two_factor_check']='N';
						$_SESSION['faculty_time']=$time;
						$_SESSION['faculty_date']=$date;
						$_SESSION['faculty_dept_id']=$result[0][6];
						$_SESSION['done']='Hi! '.$f_name.'. Welcome to the faculty panel';
						$_SESSION['otp_count']=0;
						
						if(isset($_REQUEST['re_faculty']))
						{
							if(!isset($_COOKIE['faculty_login']) || !isset($_COOKIE['faculty_email']) || !isset($_COOKIE['faculty_password']) || $_COOKIE['faculty_email']!=$email || $_COOKIE['faculty_password']!=$_REQUEST['faculty_password'])
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
						
						//clearing previous OTPs & Forget My Password links
						$stmt = $conn->prepare("delete from nr_faculty_link_token where nr_faculty_id=:f_id");
						$stmt->bindParam(':f_id', $faculty_id);
						$stmt->execute();
						
						//send otp if two factor enabled
						if($_SESSION['faculty_two_factor_status']==1)
						{
							$iotp=get_otp();
							$d=get_current_date();
							$t=get_current_time();
							//Inserting new OTPs
							$stmt = $conn->prepare("insert into nr_faculty_link_token values(:f_id,'$iotp','Two Factor','$d','$t','Active') ");
							$stmt->bindParam(':f_id', $faculty_id);
							$stmt->execute();
							
							
							$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
							$stmt->execute();
							$result = $stmt->fetchAll();
							if(count($result)==0)
							{
								echo 'System not ready';
								die();
							}
							$title=$result[0][2];
							$contact_email=$result[0][9];
							
							//sending new OTP to user
							$msg="Dear ".$f_name.", Your Two Factor Authentication OTP is: ".$iotp;
							$message = '<html><body>';
							$message .= '<h1>Two Factor Authentication OTP From - '.$title.'</h1><p>  </p>';
							$message .= '<p><b>Message Details:</b></p>';
							$message .= '<p>'.$msg.'</p></body></html>';
							
							
							sent_mail($_SESSION['faculty_email'],$title.' - OTP for Two Factor Authentication',$message,$title,$contact_email);
						}
						
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
>>>>>>> 3cbad3b731067af9672d2b64dd4ddf93db2f86d7
?>