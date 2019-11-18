<?php

$postdata = file_get_contents ("php://input");
// echo $postdata;


$estudiante = json_decode($postdata);
echo ' El estudiante '.$estudiante->nombre.' , matricula: '.$estudiante->matricula;

//print_r($estudiante); 
 ?>