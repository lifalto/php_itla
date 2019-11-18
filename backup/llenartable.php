<?php
//ini_set('Display Errors',1);

$host="localhost";
$user="root";
$password="password";
$dbname="escuela";

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
    echo 'conectado......';
$stm = $pdo->query("SELECT VERSION()");
$version = $stm->fetch();

echo $version[0] . PHP_EOL;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

echo "HOLA";











// $Nombre = $_REQUEST['Nombre'];
// $Matricula = $_REQUEST['Matricula'];
// $Edad = $_REQUEST['Edad'];




?>