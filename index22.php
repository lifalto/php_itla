<?php

echo "------SERVER: <br>";
foreach ($_SERVER as $k => $v){
    echo '<b>' .$k. '</b>=' .$v. '</br>';
}
echo "............. POST: ";
print_r($_POST);

echo "Param : ".$_GET["param"]. "/n";

echo ".......................................GET :";
print_r($_GET);
