<?php

require('conexion.php');


function buscarMateria() {

    $cn = getConexion();
    
    $stm = $cn->query("SELECT * FROM materia");
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = json_encode($rows );
    echo $data;
}

function guardarMateria() {
    $postdata = file_get_contents("php://input");
    $data = json_decode($postdata, true);

    $errors = [];
    if (!$data["nombre"]) {
        $errors[] = "campo nombre es requerido";
    }

    if (!$data["creditos"]) {
        $errors[] = "campo creditos es requerido";
    }

    if (count($errors)>0){
        header("HTTP/1.1 400 Bad Request");
        $response = [ 
            "error" => true,
            "message" => "Campos requeridos",
            "errors" =>  $errors
        ];
        
        echo json_encode($response);
        return;
    }

    $cn = getConexion();
    $stm = $cn->prepare("INSERT INTO materia (nombre, creditos) VALUES (:nombre, :creditos)");
    $stm->bindParam(":nombre", $data["nombre"]);
    $stm->bindParam(":creditos", $data["creditos"]);

    try {
        $data = $stm->execute();
        $response = [ "error" => false ];
        echo json_encode($response);
    } catch(Exception $e){
        $response = [ 
            "error" => true,
            "message" => "Error desconocido"
        ];
        
        echo json_encode($response);
    }
}

function borrarMateria($id) {

    if ($id == null) {
        header("HTTP/1.1 400 Bad Request");
        $response = [ 
            "error" => true,
            "message" => "Campos id es requerido"
        ];
        
        echo json_encode($response);
       
        return;
    } 

    $cn = getConexion();
    $stm = $cn->prepare("DELETE FROM materia WHERE id = :id");
    $stm->bindParam(":id", $id);

    try {
        $data = $stm->execute();
        $response = [ "error" => false ];
        echo json_encode($response);
    } catch(Exception $e){
        switch($e->getCode()){
            case 23000:
                $response = [ 
                    "error" => true,
                    "message" => "Esta materia esta siendo usada"
                ];
            
                echo json_encode($response);
    
                break;
            default:
                $response = [ 
                    "error" => true,
                    "message" => "Error desconocido"
                ];
                
                echo json_encode($response);
        }   
    } 
}

function actualizarMateria($id){
    
    if ($id == null) {
        header("HTTP/1.1 400 Bad Request");
        $response = [ 
            "error" => true,
            "message" => "Campos id es requerido"
        ];
        
        echo json_encode($response);
       
        return;
    } 

    $postdata = file_get_contents("php://input");
    $data = json_decode($postdata, true);

    $errors = [];
    if (!$data["nombre"]) {
        $errors[] = "campo nombre es requerido";
    }

    if (!$data["creditos"]) {
        $errors[] = "campo creditos es requerido";
    }

    if (count($errors)>0){
        header("HTTP/1.1 400 Bad Request");
        $response = [ 
            "error" => true,
            "message" => "Campos requeridos",
            "errors" =>  $errors
        ];
        
        echo json_encode($response);
        return;
    }

    $cn = getConexion();
    $stm = $cn->prepare("UPDATE materia SET nombre = :nombre, creditos = :creditos WHERE id = :id");
    $stm->bindParam(":nombre", $data["nombre"]);
    $stm->bindParam(":creditos", $data["creditos"]);
    $stm->bindParam(":id", $id);

    try {
        $data = $stm->execute();

        $response = [ 
            "error" => false,
        ];
        
        echo json_encode($response);
    } catch(Exception $e){

        $response = [ 
            "error" => true,
            "message" => "Error desconocido"
        ];
        
        echo json_encode($response);
    }

}


$method = $_SERVER["REQUEST_METHOD"];

// Establecer este header ya que todas las respuestan serán JSON
header("Content-Type: application/json", true);

switch ($method){
    case 'POST': 
        guardarMateria();
        break;
    case 'GET':
        $id = $_GET["id"];
        buscarMateria($id);
        break;
    case 'DELETE':
        $id = $_GET["id"];
        borrarMateria($id);
        break;
    case 'PUT':
        $id = $_GET["id"];
        actualizarMateria($id);
        break;
    default: 
        echo '{
            "error": true,
            "message": "Metodo no implementado" 
        }
        ';
}


// // $postdata = file_get_contents("php://input");