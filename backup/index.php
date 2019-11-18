<?php


// foreach ($_SERVER  as $k => $v){
//     echo "${k} => ${v} </br>";
// }

// if ($_SERVER["REQUEST_METHOD"] == "GET"){
    echo $_SERVER["REQUEST_METHOD"];
// }

// $postdata = file_get_contents("php://input");
// $estudiante = json_decode($postdata);

// try {
//     $pdo = new \PDO("mysql:host=localhost;dbname=escuela", "root", "password");
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $stm = $pdo->prepare("INSERT INTO estudiante (nombre, matricula) VALUES (:nombre, :matricula)");
//     $stm->bindParam(":nombre", $estudiante->nombre);
//     $stm->bindParam(":matricula", $estudiante->matricula);

//     $data = $stm->execute();
    
//     echo "working";
// } catch (PDOException $e){
//     echo $e->getMessage();
// }