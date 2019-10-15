<?php

$postdata = file_get_contents("php://input");
//echo $postdata;

$estudiante = json_decode($postdata);

print_r($estudiante); 

//no se puede con echo porque no es un string

 ?>