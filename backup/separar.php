<?php

$word = $_REQUEST['word'];
$number = $_REQUEST['number'];
$chunks = ceil(strlen($word) / $number);
echo "Cantidad de Palabras = {$chunks} <br /> \n";

echo "Los {$number}-Pedazos de letras de la palabra '{$word}' son:<br />\n";

for ($i = 0; $i < $chunks; $i++) {
$chunk = substr($word, $i * $number, $number);
printf("%d: %s<br />\n", $i + 1, $chunk);
}