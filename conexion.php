<?php

// error_reporting(E_ALL | E_STRICT);
// ini_set('display_errors', 1);
function getConexion(){

    try {
        $pdo = new \PDO("mysql:host=localhost;dbname=escuela", "root", "password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e){
    return NULL;
    }
}


    // $stm = $pdo->query("SELECT VERSION()");
    // $version = $stm->fetch();
    // echo $version[0] . PHP_EOL;

    // $nombre = "Juan de los palotes";
    // $matricula = "DC-2562";
    // $edad="25";

    // $stm = $pdo->prepare("INSERT INTO Estudiante (Nombre, Matricula, Edad) VALUES (:nombre, :matricula, :edad)");
    // $stm->bindParam(":nombre", $nombre);
    // $stm->bindParam(":matricula", $matricula);
    // $stm->bindParam(":edad", $edad);

    // $data = $stm->execute();
    // print_r($data);

    // echo "working";
