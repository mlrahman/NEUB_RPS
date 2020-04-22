<?php

function password_encrypt($x)
{
	$x='rps'.$x.'rps';
	$x='rps'.sha1($x).'rps';
	$x='rps'.md5($x).'rps';
	$x='rps'.sha1($x).'rps';
	return $x;
}

function get_filter_grade($id)
{
	if($id==1) return 'A+';
	if($id==2) return 'A';
	if($id==3) return 'A-';
	if($id==4) return 'B+';
	if($id==5) return 'B';
	if($id==6) return 'B-';
	if($id==7) return 'C+';
	if($id==8) return 'C';
	if($id==9) return 'D';
	if($id==10) return 'F';
}

function sent_mail($to,$subject,$msg,$website_title,$website_email)
{
	try
	{
		$headers[]= 'Reply-To: '.$website_title.' <'.$website_email.'>';
		$headers[]= 'Return-Path: '.$website_title.' <'.$website_email.'>';
		$headers[]= 'From: '.$website_title.' <'.$website_email.'>'; 
		//Using for sent email backup
		//$headers[] = 'Cc: '.$website_email.'';
		$headers[]= 'Organization: '.$website_title.'';
		$headers[]= 'MIME-Version: 1.0';
		$headers[]= 'Content-type: text/html; charset=iso-8859-1';
		$headers[]= 'X-Priority: 3';
		$headers[]= 'X-Mailer: PHP'. phpversion();
		
		//smtp_mail($to,$subject,$website_email,$website_title,$msg);
		mail($to, $subject, $msg, implode("\r\n", $headers));
		
		return true;
	}
	catch(Exception $e)
	{
		return false;
	}
}

function get_reference($s_id)
{
	//16 digits
	$ref=$s_id[10].$s_id[11].rand(10,99).DATE("y").DATE("d").DATE("h").DATE("i").DATE("s").rand(10,99);
	return $ref;
}

function sent_mail_personal($to,$from,$name,$subject,$msg)
{
	try
	{
		//$name of from person and $from wmail of from person
		$headers[]= 'Reply-To: '.$name.' <'.$from.'>';
		$headers[]= 'Return-Path: '.$name.' <'.$from.'>';
		$headers[]= 'From: '.$name.' <'.$from.'>'; 
		//$headers[] = 'Cc: '.$from.'';
		//$headers[]= 'Organization: '.$name.'';
		$headers[]= 'MIME-Version: 1.0';
		$headers[]= 'Content-type: text/html; charset=iso-8859-1';
		$headers[]= 'X-Priority: 3';
		$headers[]= 'X-Mailer: PHP'. phpversion();
		
		mail($to, $subject, $msg, implode("\r\n", $headers));
		//smtp_mail($to,$subject,$from,$name,$msg);
		
		
		return true;
	}
	catch(Exception $e)
	{
		return false;
	}
}

function get_otp()
{
	$otp=DATE("y");
	$otp=$otp.rand(10,99);
	$otp=$otp.DATE("s");
	$otp=$otp.rand(10,99);
	$otp=$otp.DATE("d");
	return $otp;
}
function get_link()
{
	return sha1(get_otp());
}

function get_current_date()
{
	$offset=6*60*60; //GMT +6.
	$dateFormat="Y-m-d";
	return gmdate($dateFormat, time()+$offset);
}

function get_current_time()
{
	$offset=6*60*60; //GMT +6.
	$timeFormat="h:i A";
	return gmdate($timeFormat, time()+$offset);
}

function grade_point_encrypt($s_id,$g)
{
	return ($s_id+(((($g*100.0)+255.5)*10.0)+255.5));
}
function grade_point_decrypt($s_id,$g)
{
	return ((((($g-$s_id)-255.5)/10.0)-255.5)/100.0);
}
function marks_encrypt($s_id,$m)
{
	return ($s_id+(((($m*10.0)+255.5)*10.0)+255.5));
}
function marks_decrypt($s_id,$m)
{
	return ((((($m-$s_id)-255.5)/10.0)-255.5)/10.0);
}
function grade_encrypt($s_id,$g)
{
	$g=$s_id.'++'.$g.'++';
	$g=sha1($g);
	$g=md5($g);
	$g=sha1($g);
	return $g;
}
function grade_decrypt($s_id,$g)
{
	if(grade_encrypt($s_id,'I')==$g) return 'I'; //incomplete
	if(grade_encrypt($s_id,'F')==$g) return 'F';
	if(grade_encrypt($s_id,'D')==$g) return 'D';
	if(grade_encrypt($s_id,'C')==$g) return 'C';
	if(grade_encrypt($s_id,'C+')==$g) return 'C+';
	if(grade_encrypt($s_id,'B-')==$g) return 'B-';
	if(grade_encrypt($s_id,'B')==$g) return 'B';
	if(grade_encrypt($s_id,'B+')==$g) return 'B+';
	if(grade_encrypt($s_id,'A-')==$g) return 'A-';
	if(grade_encrypt($s_id,'A')==$g) return 'A';
	if(grade_encrypt($s_id,'A+')==$g) return 'A+';
}

function getVisIpAddr() { 
      
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        return $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } 
    else { 
        return $_SERVER['REMOTE_ADDR']; 
    }	
} 

function get_session($s_id)
{
	$year='20'.$s_id[0].$s_id[1];
	if($s_id[3]=='1')
		$semester='Spring';
	else if($s_id[3]=='2')
		$semester='Summer';
	else if($s_id[3]=='3')
		$semester='Fall';
	return $semester.'-'.$year;
}

function get_session_semester($s_id)
{
	if($s_id[3]=='1')
		$semester='Spring';
	else if($s_id[3]=='2')
		$semester='Summer';
	else if($s_id[3]=='3')
		$semester='Fall';
	return $semester;
}



function get_year($s_id)
{
	$year='20'.$s_id[0].$s_id[1];
	return $year;
}

function get_current_semester()
{
	$date=get_current_date();
	if($date[5]=='0' && $date[6]=='1')
	{
		$semester='Spring';
	}		
	else if($date[5]=='0' && $date[6]=='2')
	{
		$semester='Spring';
	}
	else if($date[5]=='0' && $date[6]=='3')
	{
		$semester='Spring';
	}
	else if($date[5]=='0' && $date[6]=='4')
	{
		$semester='Spring';
	}
	else if($date[5]=='0' && $date[6]=='5')
	{
		$semester='Summer';
	}
	else if($date[5]=='0' && $date[6]=='6')
	{
		$semester='Summer';
	}
	else if($date[5]=='0' && $date[6]=='7')
	{
		$semester='Summer';
	}
	else if($date[5]=='0' && $date[6]=='8')
	{
		$semester='Summer';
	}
	else if($date[5]=='0' && $date[6]=='9')
	{
		$semester='Fall';
	}
	else if($date[5]=='0' && $date[6]=='10')
	{
		$semester='Fall';
	}
	else if($date[5]=='0' && $date[6]=='11')
	{
		$semester='Fall';
	}
	else if($date[5]=='0' && $date[6]=='12')
	{
		$semester='Fall';
	}
	return $semester;
}
function get_current_year()
{
	$date=get_current_date();
	$year=$date[0].$date[1].$date[2].$date[3];
	return $year;
}

function get_date($date)
{
	$day=$date[8].$date[9];
	if($date[5]=='0' && $date[6]=='1')
	{
		$month='Jan';
	}		
	else if($date[5]=='0' && $date[6]=='2')
	{
		$month='Feb';
	}
	else if($date[5]=='0' && $date[6]=='3')
	{
		$month='Mar';
	}
	else if($date[5]=='0' && $date[6]=='4')
	{
		$month='Apr';
	}
	else if($date[5]=='0' && $date[6]=='5')
	{
		$month='May';
	}
	else if($date[5]=='0' && $date[6]=='6')
	{
		$month='Jun';
	}
	else if($date[5]=='0' && $date[6]=='7')
	{
		$month='Jul';
	}
	else if($date[5]=='0' && $date[6]=='8')
	{
		$month='Aug';
	}
	else if($date[5]=='0' && $date[6]=='9')
	{
		$month='Sep';
	}
	else if($date[5]=='1' && $date[6]=='0')
	{
		$month='Oct';
	}
	else if($date[5]=='1' && $date[6]=='1')
	{
		$month='Nov';
	}
	else if($date[5]=='1' && $date[6]=='2')
	{
		$month='Dec';
	}
	$year=$date[0].$date[1].$date[2].$date[3];
	return $day.' '.$month.', '.$year;
}

function photo_upload($file,$i,$max_foto_size,$photo_extention,$folder_name,$path='')
{
		if($file['tmp_name']=="")
		{
			return "1";
		}
		if($file['tmp_name']!="")
		{
				$p=$file['name'];
				$pos=strrpos($p,".");
				$ph=strtolower(substr($p,$pos+1,strlen($p)-$pos));
				$im_size =  round($file['size']/1024,2);

				if($im_size > $max_foto_size)
				   {
						//echo "Image is Too Large";
						return "1";
				   }
				$photo_extention = explode(",",$photo_extention);
				if(!in_array($ph,$photo_extention ))
				   {
						//echo "Upload Correct Image";

						return "1";
				   }
		}
		$ran=date(time());
		$c=$ran.rand(1,10000);
		$ran.=$c.".".$ph;

		if(isset($file['tmp_name']) && is_uploaded_file($file['tmp_name']))
		{
			$ff = $folder_name."/".$ran;
			move_uploaded_file($file['tmp_name'], $ff );
			chmod($ff, 0777);
		}
	   return  $ran;
}

//Image Resize function
function photo_resize($updir, $img, $id, $dir, $sz1, $sz2)
{
	$thumbnail_width = $sz1;
	$thumbnail_height = $sz2;
	$thumb_beforeword = "";
	$arr_image_details = getimagesize("$updir" . $id . '' . "$img"); // pass id to thumb name
	$original_width = $arr_image_details[0];
	$original_height = $arr_image_details[1];
	if ($original_width > $original_height) {
		$new_width = $thumbnail_width;
		$new_height = intval($original_height * $new_width / $original_width);
	} else {
		$new_height = $thumbnail_height;
		$new_width = intval($original_width * $new_height / $original_height);
	}
	$dest_x = intval(($thumbnail_width - $new_width) / 2);
	$dest_y = intval(($thumbnail_height - $new_height) / 2);
	if ($arr_image_details[2] == IMAGETYPE_GIF) {
		$imgt = "ImageGIF";
		$imgcreatefrom = "ImageCreateFromGIF";
	}
	if ($arr_image_details[2] == IMAGETYPE_JPEG) {
		$imgt = "ImageJPEG";
		$imgcreatefrom = "ImageCreateFromJPEG";
	}
	if ($arr_image_details[2] == IMAGETYPE_PNG) {
		$imgt = "ImagePNG";
		$imgcreatefrom = "ImageCreateFromPNG";
	}
	if ($imgt) {
		$old_image = $imgcreatefrom("$updir" . $id . '' . "$img");
		$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
		$imgt($new_image, $dir . $id . '' . "$thumb_beforeword" . "$img");
		return 'done';
	}
	else
	{
		return 'error';
	}
}


function video_upload($file,$i,$max_foto_size,$photo_extention,$folder_name,$path='')
{
		if($file['tmp_name']=="")
		{
			return "1";
		}
		if($file['tmp_name']!="")
		{
				$p=$file['name'];
				$pos=strrpos($p,".");
				$ph=strtolower(substr($p,$pos+1,strlen($p)-$pos));
				$im_size =  round($file['size']/1024,2);

				if($im_size > $max_foto_size)
				   {
						//echo "Image is Too Large";
						return "1";
				   }
				$photo_extention = explode(",",$photo_extention);
				if(!in_array($ph,$photo_extention ))
				   {
						//echo "Upload Correct Image";

						return "1";
				   }
		}
		$ran=date(time());
		$c=$ran.rand(1,10000);
		$ran.=$c.".".$ph;

		if(isset($file['tmp_name']) && is_uploaded_file($file['tmp_name']))
		{
			$ff = $folder_name."/".$ran;
			move_uploaded_file($file['tmp_name'], $ff );
			chmod($ff, 0777);
		}
	   return  $ran;
}
//file upload
function file_upload($file,$i,$max_foto_size,$photo_extention,$folder_name,$path='')
{
		if($file['tmp_name']=="")
		{
			return "1";
		}
		if($file['tmp_name']!="")
		{
				$p=$file['name'];
				$pos=strrpos($p,".");
				$ph=strtolower(substr($p,$pos+1,strlen($p)-$pos));
				$im_size =  round($file['size']/1024,2);

				if($im_size > $max_foto_size)
				   {
						//echo "Image is Too Large";
						return "1";
				   }
				$photo_extention = explode(",",$photo_extention);
				if(!in_array($ph,$photo_extention ))
				   {
						//echo "Upload Correct Image";

						return "1";
				   }
		}
		$ran=date(time());
		$c=$ran.rand(1,10000);
		$ran.=$c.".".$ph;

		if(isset($file['tmp_name']) && is_uploaded_file($file['tmp_name']))
		{
			$ff = $folder_name."/".$ran;
			move_uploaded_file($file['tmp_name'], $ff );
			chmod($ff, 0777);
		}
	   return  $ran;
}


function get_student_info($s_id,$prcr_id)  //will return drop status, grad_status, cgpa, last_semester, last_year
{
	try
	{
		require("db_connection.php");
		
		$st_info=array();
		$st_info['error']=0;
		$st_info['dropout']=0;
		$st_info['graduated']=0;
		$st_info['cgpa']=0.00;
		$st_info['last_semester']='';
		$st_info['last_year']='';
		$st_info['drop_semester']='N/A';
		$st_info['drop_year']='N/A';
		
		
		//Fetching student result
		$stmt = $conn->prepare("select * from nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year asc, nr_result_semester asc"); 
		$stmt->bindParam(':s_id', $s_id);
		$stmt->execute();
		$stud_result=$stmt->fetchAll();
		$cg=array();
		$se_re=array();
		for($i = 0; $i < count($stud_result); $i++) {
			
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
		$earned_gpa=0.0;
		foreach($cg as $cge)
		{
			$earned_credit=$earned_credit+$cge['credit'];
			$earned_gpa=$earned_gpa+($cge['credit']*$cge['gpa']);
		}
		$earned_credit=number_format($earned_credit, 2);
		
		//Calculating cgpa from earned_credit
		if($earned_credit==0)
			$total_cgpa=number_format(0.0,2);
		else
			$total_cgpa=number_format(($earned_gpa/$earned_credit),2);
		
		//fetching waived course credits
		$stmt = $conn->prepare("select * from nr_student_waived_credit where nr_stud_id=:s_id and nr_stwacr_status='Active' "); 
		$stmt->bindParam(':s_id', $s_id);
		$stmt->execute();
		$stud_result=$stmt->fetchAll();
		$waived_credit=0.0;
		$sz=count($stud_result);
		for($i = 0; $i < $sz; $i++) {
			
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
			$st_info['error']=1; //error occured
		}
		$total_credit=$prcr_result[0][2];
		
		$degree_status=$total_credit-($earned_credit+$waived_credit);
		
		$st_info['cgpa']=$total_cgpa;
		
		if($degree_status==0)
		{
			$st_info['graduated']=1;
			
			$stmt = $conn->prepare("SELECT * FROM nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year desc, nr_result_semester desc limit 1");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			if(count($stud_result)!=0)  //check for students who have results in db
			{
				$last_semester=$stud_result[0][6];
				$last_year=$stud_result[0][7];
				$st_info['last_semester']=$last_semester;
				$st_info['last_year']=$last_year;
				
			}
			else
			{
				$st_info['last_semester']='N/A';
				$st_info['last_year']='N/A';
			}
		}
		else
		{
			$stmt = $conn->prepare("SELECT * FROM nr_result where nr_stud_id=:s_id and nr_result_status='Active' order by nr_result_year desc, nr_result_semester desc limit 1");
			$stmt->bindParam(':s_id', $s_id);
			$stmt->execute();
			$stud_result=$stmt->fetchAll();
			if(count($stud_result)!=0)  //check for students who have results in db
			{
				$last_semester=$stud_result[0][6];
				$last_year=$stud_result[0][7];
			}
			else
			{
				$last_semester=get_session_semester($s_id);
				$last_year=get_year($s_id);
				$st_info['last_semester']='N/A';
				$st_info['last_year']='N/A';
			}
			$st_info['last_semester']=$last_semester;
			$st_info['last_year']=$last_year;
			$current_semester=get_current_semester();
			$current_year=get_current_year();
			$gap=0;
			$drop_semester='';
			$drop_year='';
			$allowed_gap=3; //number of drop semester for drop count
			for($y=$last_year;$y<=$current_year;$y++)
			{
				if($y==$last_year)
				{
					if($last_semester=='Spring')
					{
						if(('Spring-'.$last_year)!=($current_semester.'-'.$current_year))
						{
							$drop_semester='Spring';
							$drop_year=$y;
							$gap++;
							//echo $drop_semester.' '.$drop_year.'</br>';
						}
						else
							break;
						
						if($gap>=$allowed_gap)   //no of semester for drop count
						{
							$st_info['dropout']=1;
							$st_info['drop_semester']=$drop_semester;
							$st_info['drop_year']=$drop_year;
							break;
						}
						
						if(('Summer-'.$last_year)!=($current_semester.'-'.$current_year))
						{
							$drop_semester='Summer';
							$drop_year=$y;
							$gap++;
							//echo $drop_semester.' '.$drop_year.'</br>';
						}
						else 
							break;
							
						if($gap>=$allowed_gap)   //no of semester for drop count
						{
							$st_info['dropout']=1;
							$st_info['drop_semester']=$drop_semester;
							$st_info['drop_year']=$drop_year;
							break;
						}	
							
							
						if(('Fall-'.$last_year)!=($current_semester.'-'.$current_year))
						{
							$drop_semester='Fall';
							$drop_year=$y;
							$gap++;
							//echo $drop_semester.' '.$drop_year.'</br>';
						}
						else
							break;
						
						if($gap>=$allowed_gap)   //no of semester for drop count
						{
							$st_info['dropout']=1;
							$st_info['drop_semester']=$drop_semester;
							$st_info['drop_year']=$drop_year;
							break;
						}
					}
					else if($last_semester=='Summer')
					{
						if(('Summer-'.$last_year)!=($current_semester.'-'.$current_year))
						{
							$drop_semester='Summer';
							$drop_year=$y;
							$gap++;
							//echo $drop_semester.' '.$drop_year.'</br>';
						}
						else 
							break;
						
						if($gap>=$allowed_gap)   //no of semester for drop count
						{
							$st_info['dropout']=1;
							$st_info['drop_semester']=$drop_semester;
							$st_info['drop_year']=$drop_year;
							break;
						}
							
						if(('Fall-'.$last_year)!=($current_semester.'-'.$current_year))
						{
							$drop_semester='Fall';
							$drop_year=$y;
							$gap++;
							//echo $drop_semester.' '.$drop_year.'</br>';
						}
						else
							break;
						
						if($gap>=$allowed_gap)   //no of semester for drop count
						{
							$st_info['dropout']=1;
							$st_info['drop_semester']=$drop_semester;
							$st_info['drop_year']=$drop_year;
							break;
						}
					}
					else if($last_semester=='Fall')
					{
																
						if(('Fall-'.$last_year)!=($current_semester.'-'.$current_year))
						{
							$drop_semester='Fall';
							$drop_year=$y;
							$gap++;
							//echo $drop_semester.' '.$drop_year.'</br>';
						}
						else
							break;
						if($gap>=$allowed_gap)   //no of semester for drop count
						{
							$st_info['dropout']=1;
							$st_info['drop_semester']=$drop_semester;
							$st_info['drop_year']=$drop_year;
							break;
						}
					}
				}
				else
				{
					if(('Spring-'.$y)!=($current_semester.'-'.$current_year))
					{
						$drop_semester='Spring';
						$drop_year=$y;
						$gap++;
						//echo $drop_semester.' '.$drop_year.'</br>';
					}
					else
						break;
					
					if($gap>=$allowed_gap)   //no of semester for drop count
					{
						$st_info['dropout']=1;
						$st_info['drop_semester']=$drop_semester;
						$st_info['drop_year']=$drop_year;
						break;
					}
					
					if(('Summer-'.$y)!=($current_semester.'-'.$current_year))
					{
						$drop_semester='Summer';
						$drop_year=$y;
						$gap++;
						//echo $drop_semester.' '.$drop_year.'</br>';
					}
					else 
						break;
					
					if($gap>=$allowed_gap)   //no of semester for drop count
					{
						$st_info['dropout']=1;
						$st_info['drop_semester']=$drop_semester;
						$st_info['drop_year']=$drop_year;
						break;
					}
						
					if(('Fall-'.$y)!=($current_semester.'-'.$current_year))
					{
						$drop_semester='Fall';
						$drop_year=$y;
						$gap++;
						//echo $drop_semester.' '.$drop_year.'</br>';
					}
					else
						break;
					
					if($gap>=$allowed_gap)   //no of semester for drop count
					{
						$st_info['dropout']=1;
						$st_info['drop_semester']=$drop_semester;
						$st_info['drop_year']=$drop_year;
						break;
					}
				}
				
			}
			
			
		}
		
	}catch(Exception $e)
	{
		$st_info['error']=1; //error occured
	}
	return $st_info;
}

function get_student_semester_cgpa($s_id,$semester,$year) //will return semester top cgpa
{
	try
	{
		require("db_connection.php");
		$stmt = $conn->prepare("select * from nr_result a,nr_course b,nr_student c where c.nr_stud_id=a.nr_stud_id and c.nr_stud_status='Active' and nr_result_status='Active' and a.nr_course_id=b.nr_course_id and a.nr_result_semester='$semester' and a.nr_result_year='$year' and a.nr_stud_id='$s_id' ");
		$stmt->execute();
		$result = $stmt->fetchAll();
		if(count($result)>=1)
		{
			$sz=count($result);
			$tc=0;
			$gp=0;
			for($i=0;$i<$sz;$i++)
			{
				
				$gpa=grade_point_decrypt($s_id,$result[$i][5]);
				$credit=$result[$i][16];
				$gp=$gp+($gpa*$credit);
				if($gpa!=0.00)
					$tc=$tc+$credit;
				
				//echo $result[$i][15].' GPA: '.$gpa.' Credit:'.$credit.' Total GP:'.$gp.' Total Credit:'.$tc.'</br>';
				
			}
			if($tc==0.00)
				$cgpa='0.00';
			else
				$cgpa=number_format(($gp/$tc),2);
		}
		else
			$cgpa='N/A';
			
	}catch(Exception $e)
	{
		$cgpa='N/A'; //error occured
	}
	return $cgpa;
}

function smtp_mail($to,$subject,$from,$title,$msg)	
{
	//smtp server using gmail
	require("library/smtp_server/class.phpmailer.php");
	$mailer = new PHPMailer();
	$mailer->IsSMTP();
	$mailer->Host = 'ssl://smtp.gmail.com';
	$mailer->Port = 465; //can be 587
	$mailer->SMTPAuth = TRUE;
	// Change this to your gmail address
	$mailer->Username = '';  
	// Change this to your gmail password
	$mailer->Password = '';  
	// Change this to your gmail address
	$mailer->From = $from;  
	// This will reflect as from name in the email to be sent
	$mailer->IsHTML(true);
	
	$mailer->FromName = $title;
	
	$mailer->Body = $msg;
	$mailer->Subject = $subject;
	// This is where you want your email to be sent
	$mailer->AddAddress($to);  
	if(!$mailer->Send())
	{
		throw new Exception('Email failed to send.');
	}
	else
	{
		return true;
	}
}

//check for valid email
function email_check($email)
{
	return true;
}

?>