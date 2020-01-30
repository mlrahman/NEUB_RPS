<?php


function get_current_date()
{
	return Date("Y-m-d");
}

function get_current_time()
{
	return Date("h:i A");
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

function get_year($s_id)
{
	$year='20'.$s_id[0].$s_id[1];
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
	else if($date[5]=='0' && $date[6]=='10')
	{
		$month='Oct';
	}
	else if($date[5]=='0' && $date[6]=='11')
	{
		$month='Nov';
	}
	else if($date[5]=='0' && $date[6]=='12')
	{
		$month='Dec';
	}
	$year=$date[0].$date[1].$date[2].$date[3];
	return $day.' '.$month.', '.$year;
}

?>