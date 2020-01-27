<?php

include("includes/function.php");

$s_id=140203020002;
$marks=75;
$gpa=3.75;
$g='A';

echo marks_encrypt($s_id,$marks).'</br>';
echo marks_decrypt($s_id,marks_encrypt($s_id,$marks)).'</br>';
echo grade_encrypt($s_id,$g).'</br>';
echo grade_decrypt($s_id,grade_encrypt($s_id,$g)).'</br>';
echo grade_point_encrypt($s_id,$gpa).'</br>';
echo grade_point_decrypt($s_id,grade_point_encrypt($s_id,$gpa)).'</br>';

echo '-------------------------------------</br>';

$k=array();
for($i=1;$i<=10;$i++)
{
	$j=array('a'=>10,'b'=>20,'c'=>30,'d'=>40);
	$k[$i]=$j;
}

echo count($k[1]).'</br>';
$k[1][4]=50;
echo count($k[1]).'</br>';



foreach($k as $a)
{
	echo $a['a'].' --- '.$a['b'].'</br>';
}

$a=array();
$a['h'][0]=10;
//echo $a['h'][0];
//echo array_key_exists('i',$a);




?>