<?php //EjemploRequest1
$diametro = $_REQUEST['diam'];
$altura = $_REQUEST['altu'];
$radio = $diametro/2;
$Pi = 3.141593;
$volumen = $Pi*$radio*$radio*$altura;
echo "<br/> &nbsp El volumen del cilindro (Pi x Radio ^2 x Altura) es de: ". $volumen. "metros cúbicos";
?>