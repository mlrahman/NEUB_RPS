<?php

include("includes/function.php");
/*
$last_semester='2018Fall';
$current_semester='2018Summer';
if($last_semester<=$current_semester)
echo 'ok';
*/
$s_id=140203020004;
$marks=70;
$gpa=3.50;
$g='A-';
echo 'Marks:</br>';
echo marks_encrypt($s_id,$marks).'</br>';
echo marks_decrypt($s_id,marks_encrypt($s_id,$marks)).'</br>';
echo 'Grade:</br>';
echo grade_encrypt($s_id,$g).'</br>';
echo grade_decrypt($s_id,'89f276cc01d4af01fa8cee48af8ee962bac42500').'</br>';
echo 'Grade Point:</br>';
echo grade_point_encrypt($s_id,$gpa).'</br>';
echo grade_point_decrypt($s_id,grade_point_encrypt($s_id,$gpa)).'</br>';

/*
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


require_once 'includes/library/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml('<h1>hello world</h1>');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
*/
/*
$arr=array();
$arr['Summer'][0]=10;
$arr['Summer'][1]=20;
$arr['Summer'][2]=30;
$arr['Summer'][3]=40;
$arr['Fall'][0]=100;
$arr['Fall'][1]=200;
$arr['Fall'][2]=300;
$arr['Fall'][3]=400;
foreach($arr as $a=>$b)
{
	echo 'key: '.$a.' '.count($arr[$a]).'</br>';
}
*/
/*
echo 'Password: '.password_encrypt('1234');
if(isset($_REQUEST['y']))
	echo '</br>'.$_REQUEST['x'];
*/
?>
<form action="test.php">
<input type="checkbox" name="x">
<input type="submit" name="y">
</form>