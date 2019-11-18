<?php

 $postdata = file_get_contents("php://input");

 echo "------------SERVER: <br>";
//  print_r($_SERVER );

 foreach ( $_SERVER as $k => $v){
     echo '<b>'.$k.'</b>='.$v.'</br>';
 }

 echo "........... POST: ";
 print_r($_POST );

 echo " Param : ".$_GET["param"]."/n";

 echo "--------------------- GET: ";
 print_r($_GET);
$data = json_decode($postdata);


print_r($data->name);