<?php
require ('conexion.php');

function buscarEstudiante(){
    #echo "buscar Estudiante";
       $cn = getConexion();

    $stm = $cn->query("SELECT * FROM estudiante");
    $rows = $stm-> fetchAll(PDO::FETCH_ASSOC);
    $data =[];

    foreach ($rows as $row)
    {$data[] = [
        "id"=> $row["id"],
        "nombre"=> $row["nombre"],
        "matricula" => $row["matricula"],
        "edad" => $row["edad"],
        "carrera_id" => $row["carrera_id"]
        ];
    }
    header("Content-Type: application/json", true);
    $data = json_encode($data);
    echo $data;
};


function guardarEstudiante()
{     //echo 'guardar Materia';
    $postdata = file_get_contents ("php://input");
    //aqui esta como un mapa, arreglo
    $data = json_decode($postdata, true);
    //echo ' La carrera '.$data[nombre];
    $cn = getConexion();
    $stm = $cn->prepare("INSERT INTO estudiante (nombre, matricula, edad, carrera_id) VALUES (:nombre, :matricula, :edad, :carrera_id )");
    $stm->bindParam(":nombre", $data[nombre]);
    $stm->bindParam(":matricula", $data[matricula]);
    $stm->bindParam(":edad", $data[edad]);
    $stm->bindParam(":carrera_id", $data[carrera_id]);
    $data = $stm->execute();
    echo 'guardar estudiante';
};


$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        buscarEstudiante();
        break;
    case 'POST':
        guardarEstudiante();
        break;
        default: 
    echo 'TO BE IMPLEMENTED';

}