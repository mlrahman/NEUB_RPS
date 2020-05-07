<?php
	if(isset($_REQUEST['sign_in']) && isset($_REQUEST['moderator_email']) && isset($_REQUEST['moderator_password']))
	{
		try
		{
			ob_start();
			session_start();
			require("../includes/db_connection.php");
			require("../includes/function.php");
			
			$email=trim($_REQUEST['moderator_email']);
			$password=password_encrypt(trim($_REQUEST['moderator_password']));
			
			
			$stmt = $conn->prepare("select * from nr_admin where nr_admin_email=:email and nr_admin_password=:password and nr_admin_type='Moderator'  ");
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
				if($result[0][8]=='Active')
				{
					if($result[0][10]=='')
					{
						$moderator_id=$result[0][0];
						$sa_name=$result[0][1];
						$sa_type=$result[0][6];
						//Check details will insert into transaction
						$vis_ip = getVisIPAddr();
						$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$vis_ip));
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
						
						
						
						
						//checking for new login
						$stmt = $conn->prepare("select * from nr_admin_login_transaction where nr_admin_id=:sa_id and nr_suadlotr_country='$country' and nr_suadlotr_city='$city' and nr_suadlotr_lat='$lat' and nr_suadlotr_lng='$lng' and nr_suadlotr_ip_address='$vis_ip' ");
						$stmt->bindParam(':sa_id', $moderator_id);
						$stmt->execute();
						$result2 = $stmt->fetchAll();
						if(count($result2)==0)
						{
							$stmt = $conn->prepare("select * from nr_system_component where nr_syco_status='Active' order by nr_syco_id desc limit 1 ");
							$stmt->execute();
							$result4 = $stmt->fetchAll();
							
							if(count($result4)==0)
							{
								echo 'System not ready';
								die();
							}
							$title=$result4[0][2];
							$email=$result[0][2];
							$contact_email=$result4[0][9];
							//sending new login notification to the user
							$msg="Dear ".$sa_name.", We detect a new login into your account in <b>".$title."</b>. Please check the following details:  <b><p>IP Address: ".$vis_ip."</p><p>Country: ".$country."</p><p>City: ".$city."</p><p>Date: ".get_date($date)."</p><p>Time: ".$time."</p></b><p>Check the session if you don't know about this sign in. </p>";
							$message = '<html><body>';
							$message .= '<h1>New Sign In Notification from - '.$title.'</h1><p>  </p>';
							$message .= '<p><b>Message Details:</b></p>';
							$message .= '<p>'.$msg.'</p></body></html>';
							
							
							sent_mail($email,$title.' - New Sign In Notification',$message,$title,$contact_email);
							
						}							
						
						$status='Inactive';
						$stmt = $conn->prepare("update nr_admin_login_transaction set nr_suadlotr_status=:status where nr_admin_id=:u_id ");
						$stmt->bindParam(':status', $status);
						$stmt->bindParam(':u_id', $moderator_id);
						$stmt->execute();
						
						//inserting login record
						$stmt = $conn->prepare("insert into nr_admin_login_transaction values(:sa_id,'$vis_ip','$country','$city','$lat','$lng','$timezone','$date','$time','Active') ");
						$stmt->bindParam(':sa_id', $moderator_id);
						$stmt->execute();
						
						
						$_SESSION['moderator_name']=$sa_name;
						$_SESSION['moderator_type']=$sa_type;
						$_SESSION['moderator_id']=$moderator_id;
						$_SESSION['moderator_email']=$result[0][2];
						$_SESSION['moderator_password']=$result[0][3];
						$_SESSION['moderator_two_factor_status']=$result[0][9];
						$_SESSION['moderator_two_factor_check']='N';
						$_SESSION['moderator_time']=$time;
						$_SESSION['moderator_date']=$date;
						$_SESSION['done']='Hi! '.$sa_name.'. Welcome to the moderator panel';
						$_SESSION['otp_count3']=0;
						
						if(isset($_REQUEST['re_moderator']))
						{
							if(!isset($_COOKIE['moderator_login']) || !isset($_COOKIE['moderator_email']) || !isset($_COOKIE['moderator_password']) || $_COOKIE['moderator_email']!=$email || $_COOKIE['moderator_password']!=$_REQUEST['moderator_password'])
							{
								setcookie('moderator_login', 'save', time() + (86400 * 30));
								setcookie('moderator_email', $email, time() + (86400 * 30));
								setcookie('moderator_password', $_REQUEST['moderator_password'], time() + (86400 * 30));
							}
						}
						else
						{
							//echo 'deleted';
							setcookie('moderator_login', "", time() - (86400 * 30));
							setcookie('moderator_email', "", time() - (86400 * 30));
							setcookie('moderator_password', "", time() - (86400 * 30));
						}
						
						//redirecting logged in page
						
						session_write_close();
						
						//clearing previous OTPs & Forget My Password links
						$stmt = $conn->prepare("delete from nr_admin_link_token where nr_admin_id=:sa_id");
						$stmt->bindParam(':sa_id', $moderator_id);
						$stmt->execute();
						
						//send otp if two factor enabled
						if($_SESSION['moderator_two_factor_status']==1)
						{
							$iotp=get_otp();
							$d=get_current_date();
							$t=get_current_time();
							//Inserting new OTPs
							$stmt = $conn->prepare("insert into nr_admin_link_token values(:sa_id,'$iotp','Two Factor','$d','$t','Active') ");
							$stmt->bindParam(':sa_id', $moderator_id);
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
							$msg="Dear ".$sa_name.", Your Two Factor Authentication OTP is: ".$iotp;
							$message = '<html><body>';
							$message .= '<h1>Two Factor Authentication OTP From - '.$title.'</h1><p>  </p>';
							$message .= '<p><b>Message Details:</b></p>';
							$message .= '<p>'.$msg.'</p></body></html>';
							
							
							sent_mail($_SESSION['moderator_email'],$title.' - OTP for Two Factor Authentication',$message,$title,$contact_email);
						}
						
						header("location: sa_index.php");
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