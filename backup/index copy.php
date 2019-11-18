<?php


function sumar($v1, $v2){
    return $v1 + $v2; 
}

function restar($v1, $v2){
    return $v1 - $v2; 
}

function multiplicar($v1, $v2){
    return $v1 * $v2; 
}

$operacion = $_GET["operation"];
$valor1 = $_GET["valor1"];
$valor2 = $_GET["valor2"];
$resultado = 0;


switch ($operacion){
    case "sumar":
        $resultado = sumar($valor1, $valor2);
        break;
    case "restar":
        $resultado = restar($valor1, $valor2);
        break;
    case "multiplicar":
        $resultado = multiplicar($valor1, $valor2);
        break;
    default:
        $resultado = 0;
}

echo "El resultado de $operacion $valor1 y $valor2 = $resultado";

// // imprimirSaludo("Juan de los Palotes");
// $resultadoSuma = sumar(1,5);
// echo " el Valor de 1 + 5 = ".$resultadoSuma;









// $variables=[];
// // $variables["key"] = "kjshjs";

// $variables = [    
//     "k1" => "valor", 
//     "k2" => "valor2", 
//     "k3" => "valor3"
// ];




