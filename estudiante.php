<?php

require('conexion.php');


function buscarEstudiante() {

    $cn = getConexion();
    
    //$stm = $cn->query("SELECT * FROM estudiante");
    $stm = $cn->query("SELECT e.id, e.nombre, e.edad, e.matricula, e.carrera_id, c.nombre AS carrera 
    FROM estudiante AS e INNER JOIN carrera AS c ON e.carrera_id = c.id");
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = json_encode($rows );
    //creamos header, todas las respuestas deben ser json porque es API
    echo $data;
}

function guardarEstudiante() {
    $postdata = file_get_contents("php://input");
    //sucede cuando es un post or put
    $data = json_decode($postdata, true);
//decodifico lo que viene del postman

//HTTP_CODE => 400 BAD REQUEST

    $errors = [];
    if (!$data["nombre"]) {
        $errors[] = "campo nombre es requerido";
    }

    if (!$data["matricula"]) {
        $errors[] = "campo matricula es requerido";
    }

    if (!$data["edad"]) {
        $errors[] = "campo edad es requerido";
    }

    if (!$data["carrera_id"]) {
        $errors[] = "campo carrera_id es requerido";
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
    $stm = $cn->prepare("INSERT INTO estudiante (nombre, matricula, edad, carrera_id) VALUES (:nombre, :matricula, :edad, :carrera_id)");
    $stm->bindParam(":nombre", $data["nombre"]);
    $stm->bindParam(":matricula", $data["matricula"]);
    $stm->bindParam(":edad", $data["edad"]);
    $stm->bindParam(":carrera_id", $data["carrera_id"]);
    
    
    try {
        $data = $stm->execute();
        $response = [ "error" => false ];
        echo json_encode($response);
    } catch(Exception $e){
        $response = [ 
            "error" => true,
            "message" => $e.getMessage()
            // "message" => $e.getMessage() para que me diga cual es el error
        ];
        
        echo json_encode($response);
    }
}

function borrarEstudiante($id) {

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
    $stm = $cn->prepare("DELETE FROM estudiante WHERE id = :id");
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
                    "message" => "Esta Estudiante esta siendo usada"
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

function actualizarEstudiante($id){
    
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

    if (!$data["matricula"]) {
        $errors[] = "campo matricula es requerido";
    }

    if (!$data["edad"]) {
        $errors[] = "campo edad es requerido";
    }

    if (!$data["carrera_id"]) {
        $errors[] = "campo carrera_id es requerido";
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
    $stm = $cn->prepare("UPDATE estudiante SET nombre = :nombre, matricula = :matricula, edad = :edad, carrera_id = :carrera_id WHERE id = :id");
    $stm->bindParam(":nombre", $data["nombre"]);
    $stm->bindParam(":matricula", $data["matricula"]);
    $stm->bindParam(":edad", $data["edad"]);
    $stm->bindParam(":carrera_id", $data["carrera_id"]);
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
        guardarEstudiante();
        break;
    case 'GET':
        $id = $_GET["id"];
        buscarEstudiante($id);
        break;
    case 'DELETE':
        $id = $_GET["id"];
        borrarEstudiante($id);
        break;
    case 'PUT':
        $id = $_GET["id"];
        actualizarEstudiante($id);
        break;
    default: 
        echo '{
            "error": true,
            "message": "Metodo no implementado" 
        }
        ';
}


// // $postdata = file_get_contents("php://input");