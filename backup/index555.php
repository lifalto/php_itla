<?php

$postdata = file_get_contents ("php://input");
// echo $postdata;

//aqui esta como un mapa, arreglo
$estudiante = json_decode($postdata, true);
echo ' La estudiante '.$estudiante[nombre].' , matricula: '.$estudiante[matricula];

//print_r($estudiante); 
 ?>