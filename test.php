<?php

include("includes/function.php");

echo marks_encrypt(140203020002,95.5).'</br>';
echo marks_decrypt(140203020002,marks_encrypt(140203020002,95.5)).'</br>';
echo grade_encrypt(140203020002,'A+').'</br>';
echo grade_decrypt(140203020002,grade_encrypt(140203020002,'A+')).'</br>';
echo grade_point_encrypt(140203020002,4.00).'</br>';
echo grade_point_decrypt(140203020002,grade_point_encrypt(140203020002,4.00)).'</br>';

?>