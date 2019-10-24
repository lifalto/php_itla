<?php
require ('conexion.php');

function buscarCarrera(){
    #echo "buscar carrera";
       $cn = getConexion();

    $stm = $cn->query("SELECT * FROM carrera");

    $rows = $stm-> fetchAll(PDO::FETCH_ASSOC);

    $data =[];

    foreach ($rows as $row)
    {$data[] = [
        "id"=> $row["id"],
        "nombre"=> $row["nombre"]
         ];
    }
    header("Content-Type: application/json", true);
    $data = json_encode($data);
    echo $data;
};


function buscarMateria(){
    #echo "buscar Materia";
       $cn = getConexion();

    $stm = $cn->query("SELECT * FROM materia");
    $rows = $stm-> fetchAll(PDO::FETCH_ASSOC);
    $data =[];

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





function guardarCarrera()
{     //echo 'guardar carrera1';
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


function guardarMateria()
{     //echo 'guardar Materia';
    $postdata = file_get_contents ("php://input");
    //aqui esta como un mapa, arreglo
    $data = json_decode($postdata, true);
    //echo ' La carrera '.$data[nombre];
    $cn = getConexion();
    $stm = $cn->prepare("INSERT INTO materia (nombre, creditos) VALUES (:nombre, :creditos)");
    $stm->bindParam(":nombre", $data[nombre]);
    $stm->bindParam(":creditos", $data[creditos]);
    $data = $stm->execute();
    echo 'guardar materia';
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
    case 'POST':
        guardarCarrera();
        break;
    case 'GET':
        buscarCarrera();
        break;
    case 'DELETE':
        buscarMateria();
        break;
    case 'PUT':
        guardarMateria();
        break;
    case 'COPY':
        buscarEstudiante();
        break;
    case 'PATCH':
        guardarEstudiante();
        break;
    default: 
    echo 'TO BE IMPLEMENTED';

}