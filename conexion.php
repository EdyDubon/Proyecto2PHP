<?php
    //$host = "database-1.cs3pe9wko2np.us-east-2.rds.amazonaws.com";
    $host = "localhost";
    //$usuario = "admin";
    $usuario = "id19491079_admin";
    //$clave = "abc12345";
    $clave = '86c75Sp770XX~r?i';
    //$bd = "proyecto2";
    $bd = "id19491079_proyecto2";

    $db = new mysqli($host, $usuario, $clave, $bd);

    if ($db->connect_errno){
        echo "no se pudo conectar<br>";
    } else {
        //echo "conectado con éxito a la base de datos<br>";
    }
?>