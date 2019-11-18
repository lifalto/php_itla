<?php
require ('conexion.php');

function buscarMateria(){
    //echo "buscar Materia";
       $cn = getConexion();

    $stm = $cn->query("SELECT * FROM materia");
    $rows = $stm-> fetchAll(PDO::FETCH_ASSOC);
   $data =[];
   // $data= $rows;

    foreach ($rows as $row)
    {$data[] = [
        "id"=> $row["id"],
        "nombre"=> $row["nombre"],
        "creditos" => $row["creditos"]
        ];
    }
    header("Content-Type: application/json", true);
    $data = json_encode($data);
    echo $data;
};


function guardarMateria()
{     //echo 'guardar Materia';
    $postdata = file_get_contents ("php://input");
    //aqui esta como un mapa, arreglo
    $data = json_decode($postdata, true);
    //echo ' La materia '.$data[nombre];
    $cn = getConexion();
    $stm = $cn->prepare("INSERT INTO materia (nombre, creditos) VALUES (:nombre, :creditos)");
    $stm->bindParam(":nombre", $data[nombre]);
    $stm->bindParam(":creditos", $data[creditos]);
    $data = $stm->execute();
   //echo 'guardar materia';
};


$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        buscarMateria();
        break;
    case 'POST':
        guardarMateria();
        break;
    default: 
    //echo 'TO BE IMPLEMENTED';

}