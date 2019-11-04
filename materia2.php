<?php
require ('servidor/conexion.php');
function guardarMateria(){
    $postdata = file_get_contents("php://input");
    $data = json_decode($postdata, true);    
    $cn = getConexion();
    $stm = $cn->prepare("INSERT INTO materia (nombre, credito) VALUES (:nombre, :credito)");
    $stm->bindParam(":nombre", $data["nombre"]);
    $stm->bindParam(":creditos", $data["creditos"]);
    try{
        $data = $stm->execute();
        echo "Materia guardada...";
    }catch(Exception $e){
        echo "guardar";
    }
};

function buscarMateria(){
    $cn = getConexion();
    $stm = $cn->query("SELECT * FROM materia");
    $lista = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = [];
    foreach ($lista as $fila){
        $data [] = [
            "id"        => $fila["id"],
            "nombre"    => $fila["nombre"],
            "creditos"    => $fila["creditos"]
        ];
    }
    header("Content-Type: application/json,", true);
    $data = json_encode($data);
    echo $data;
    echo "buscar materia";
};


$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case 'POST':
        guardarMateria();
        break;
    case 'GET':
        buscarMateria();
        break;
    case 'DELETE':
    case 'PUT':
    default:
        echo "TO BE IMPLEMENTED";
    }


    