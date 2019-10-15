<?php

$database_username = 'root';
$database_password = 'password';

   try {
     
   $pdo_conn = new PDO( 'mysql:host=localhost;dbname=escuela', $database_username, $database_password );   
   $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Conexión realizada Satisfactoriamente";

      $sql = "INSERT INTO Estudiante (Nombre,Matricula,Edad)  VALUES ('Juan', 'Inf1014578', '28')";
      $pdo_statement = $pdo_conn->prepare( $sql );
           if($result = $pdo_statement->execute()){
      echo "1";
            }else{
    echo "2";
             }
    }
    catch(PDOException $e)
       {
       echo "La conexión ha fallado: " . $e->getMessage();
       }
       

       ?>