<?php

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