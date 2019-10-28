<?php
$valor1;
$valor2;
$resultado;
namespace calculadora;

class calculadora
{
    function suma($valor1, $valor2){
        $resultado = $valor1 + $valor2;
        echo ("La suma de " . $valor1 . " + " . $valor2 . " es: ");
        return $resultado . PHP_EOL;
    }
    function resta($valor1, $valor2){
        $resultado = $valor1 - $valor2;
        echo ("La resta de " . $valor1 . " - " . $valor2 . " es: ");
        return $resultado . PHP_EOL;
    }
    function multiplica($valor1, $valor2){
        $resultado = $valor1 * $valor2;
        echo ("La multiplicacion de " . $valor1 . " X " . $valor2 . " es: ");
        return $resultado . PHP_EOL;
    }
    function divide($valor1, $valor2){
        if($valor2 == 0){
            echo ("Dividir por cero da un valor indefinido..." . PHP_EOL);
        }else{
            $resultado = $valor1 / $valor2;
            echo ("La division de " . $valor1 . " / " . $valor2 . " es: ");
            return $resultado . PHP_EOL;
        }
    }
}

?>
