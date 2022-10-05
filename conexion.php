<?php
    $host = "database-1.cs3pe9wko2np.us-east-2.rds.amazonaws.com";
    $usuario = "admin";
    $clave = "abc12345";
    $bd = "proyecto2";

    $db = new mysqli($host, $usuario, $clave, $bd);

    if ($db->connect_errno){
        echo "no se pudo conectar<br>";
    } else {
        //echo "conectado con éxito a la base de datos<br>";
    }
?>