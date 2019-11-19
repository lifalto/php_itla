<?php

require('conexion.php');


function buscarCarrera() {

    $cn = getConexion();
    
    $stm = $cn->query("SELECT * FROM carrera");
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = json_encode($rows );
    //creamos header, todas las respuestas deben ser json porque es API
    echo $data;
}

function guardarCarrera() {
    $postdata = file_get_contents("php://input");
    //sucede cuando es un post or put
    $data = json_decode($postdata, true);
//decodifico lo que viene del postman

//HTTP_CODE => 400 BAD REQUEST

    $errors = [];
    if (!$data["nombre"]) {
        $errors[] = "campo nombre es requerido";
    }

    
//CONTAMOS EL ERROR Y MANDAMOS EL 400

    if (count($errors)>0){
        header("HTTP/1.1 400 Bad Request");
        //RESPONSE ES UN ARREGLO, Y MANDAR ESE ARREGLO DECODIFICADO AL CLIENTE
        //SI HAY ERROR SE DEVUELVE DE AHI Y CONTINUA
        //SI HAY EXCEPCION, DA ERROR DESCONOCIDO
        $response = [ 
            "error" => true,
            "message" => "Campos requeridos",
            "errors" =>  $errors
        ];
        
        echo json_encode($response);
        return;
    }

    $cn = getConexion();
    $stm = $cn->prepare("INSERT INTO carrera (nombre) VALUES (:nombre)");
    $stm->bindParam(":nombre", $data["nombre"]);
    
    
    try {
        $data = $stm->execute();
        $response = [ "error" => false ];
        echo json_encode($response);
    } catch(Exception $e){
        $response = [ 
            "error" => true,
            "message" => "Error desconocido"
            // "message" => $e.getMessage() para que me diga cual es el error
        ];
        
        echo json_encode($response);
    }
}

function borrarCarrera($id) {

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
    $stm = $cn->prepare("DELETE FROM carrera WHERE id = :id");
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
                    "message" => "Esta Carrera esta siendo usada"
                ];
            
                echo json_encode($response);
    
                break;
            default:
                $response = [ 
                    "error" => true,
                    "message" => $e->getMessage()
                ];
                
                echo json_encode($response);
        }   
    } 
}

function actualizarCarrera($id){
    
    if ($id == null) {
        header("HTTP/1.1 400 Bad Request");
        $response = [ 
            "error" => true,
            "message" => "Campos id es requerido"
        ];
        
        echo json_encode($response);
       
        return;
        // no continuamos
    } 

    $postdata = file_get_contents("php://input");
    $data = json_decode($postdata, true);

    $errors = [];
    if (!$data["nombre"]) {
        $errors[] = "campo nombre es requerido";
    }

    
    if (count($errors)>0){
        //le hace un count al arreglo, los rows de un arreglo de php, >0 al menos 1 error
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
    $stm = $cn->prepare("UPDATE carrera SET nombre = :nombre WHERE id = :id");
    $stm->bindParam(":nombre", $data["nombre"]);
    $stm->bindParam(":id", $id);

    try {
        $data = $stm->execute();
        //si falla salta y se va a la excepcion, es un tipo de error que se captura

        $response = [ 
            "error" => false,
        ];
        
        echo json_encode($response);
    } catch(Exception $e){

        $response = [ 
            "error" => true,
            "message" => $e->getMessage()
        ];
        
        echo json_encode($response);
    }

}


$method = $_SERVER["REQUEST_METHOD"];

// Establecer este header ya que todas las respuestan serán JSON
header("Content-Type: application/json", true);

switch ($method){
    case 'POST': 
        guardarCarrera();
        break;
    case 'GET':
        $id = $_GET["id"];
        buscarCarrera($id);
        break;
    case 'DELETE':
        $id = $_GET["id"];
        borrarCarrera($id);
        break;
    case 'PUT':
        $id = $_GET["id"];
        actualizarCarrera($id);
        break;
    default: 
        echo '{
            "error": true,
            "message": "Metodo no implementado" 
        }
        ';
}


// // $postdata = file_get_contents("php://input");