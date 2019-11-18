<?php

$postdata = file_get_contents ("php://input");
// echo $postdata;

//aqui esta como un mapa, arreglo
$estudiante = json_decode($postdata, true);
echo ' La estudiante '.$estudiante[nombre].' , matricula: '.$estudiante[matricula];

try {
    $pdo = new \PDO("mysql:host=localhost;dbname=escuela", "root", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $stm = $pdo->query("SELECT VERSION()");
    // $version = $stm->fetch();
    // echo $version[0] . PHP_EOL;

    $nombre = $estudiante[nombre];
    $matricula = $estudiante[matricula];
    $edad=$estudiante[edad];

    $stm = $pdo->prepare("INSERT INTO Estudiante (Nombre, Matricula, Edad) VALUES (:nombre, :matricula, :edad)");
    $stm->bindParam(":nombre", $nombre);
    $stm->bindParam(":matricula", $matricula);
    $stm->bindParam(":edad", $edad);

    $data = $stm->execute();
    print_r($data);

    echo "working";
} catch (PDOException $e){
    echo $e->getMessage();
}



//print_r($estudiante); 
 ?>