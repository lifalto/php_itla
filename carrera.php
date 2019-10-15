<?php
require ('conexion.php');

function buscarCarrera(){
    echo 'buscar carrera';
};

function guardarCarrera(){
    //echo 'guardar carrera1';
$postdata = file_get_contents ("php://input");
//aqui esta como un mapa, arreglo
$data = json_decode($postdata, true);
//echo ' La carrera '.$data[nombre];

$cn = getConexion();

$stm = $cn->prepare("INSERT INTO carrera (nombre) VALUES (:nombre)");
$stm->bindParam(":nombre", $data[nombre]);
$data = $stm->execute();
echo 'guardar carrera';
};

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'POST':
        guardarCarrera();
        break;
    case 'GET':
        buscarCarrera();
        break;
    case 'DELETE':

    case 'PUT':

    default: 
    echo 'TO BE IMPLEMENTED';

}