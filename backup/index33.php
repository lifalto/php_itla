<?php

//echo "Hola";

function sumarNumeros($num1, $num2)
{ return $num1+$num2;}
   
 function restarNumeros($num1, $num2)
 {return $num1-$num2;}

    
 function multiplicaNumeros($num1, $num2)
  { return $num1*$num2;}


 function divideNumeros ($num1, $num2)
  { return $num1/$num2;  }


print_r($_GET["operation"]);
$valor1 = $_GET["valor1"];
$valor2 = $_GET["valor2"];
$operacion= $_GET ["operation"];

switch($operacion)
{case "sumar":
    $resultado=sumarNumeros($valor1, $valor2); 
    break;

case "restar":
  $resultado=restarNumeros($valor1, $valor2); 
  break;

case "multiplicar":
    $resultado=multiplicaNumeros($valor1, $valor2); 
    break;

case "dividir":
    $resultado=divideNumeros($valor1, $valor2); 
    break;

}

echo "<br> <br> El resultado de $operacion $valor1 y $valor2 = $resultado";


// if($_GET ["operation"] == "sumar") {
//  $resultado=sumarNumeros($valor1, $valor2);
// }


// // elseif ($_GET["operation"] == "restar")
//  { echo "<br> <br> La resta de $valor1 - $valor2 es igual a ".restarNumeros($valor1, $valor2); }
//  elseif ($_GET["operation"] == "multiplicar")
//  { echo "<br> <br> La multiplicacion de $valor1 * $valor2 es igual a ".multiplicaNumeros($valor1, $valor2); }
//  elseif ($_GET["operation"] == "dividir")
//  { echo "<br> <br> La division de $valor1 / $valor2 es igual a ".divideNumeros($valor1, $valor2); }

 //echo "<br> <br> El resultado de $operacion $valor1 y $valor2 es igual a " .$resultado;

//   $suma=SumarNumeros(5,10);
//   echo "<br> <br> La suma de 5 y 10 es igual a ".$suma;

//   $resta= RestarNumeros(10,5);
//   echo "<br> <br> La resta de 10 menos 5 es igual a ".$resta;

//   $mult= MultiplicaNumeros (5,10);
//   echo "<br> <br> La multiplicacion de 5 por 10 es igual a ".$mult;

//   $divide= DivideNumeros (5,10);
//   echo "<br> <br> La division de 5 / 10 es igual a ".$divide;
