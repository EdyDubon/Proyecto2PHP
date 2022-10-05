<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title> INICIO </title>
        <style type="text/css">
            .links {
                height: 100px;
                align-items: center;
            }
            a{
                position: sticky;
                margin: 20px;
                padding: 10px;
                color: white;
                font-weight: 900;
                background-color: rgb(39, 169, 192);
                border-style: solid;
                border-width: 1px;
                position: relative;
            }
            a:hover{
                box-shadow: 10px 10px #000;
                font-size: large;
            }

            .vidrio{
                height: 200px;
                width: 95%;
                background: rgba(122, 222, 230, 0.28);
                border-radius: 16px;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                backdrop-filter: blur(1.8px);
                -webkit-backdrop-filter: blur(3.8px);
                border: 1px solid rgba(255, 255, 255, 0.25);
                z-index: 0;
            }
            .nombre{
                font-size: 42pt;
            }
            .moneda {
                float:float;
                width: 300px;
                height: 300px;
                background-image: url('img/quetzal.png');
                position: relative;
                animation-name: example;
                animation-duration: 10s;
                animation-timing-function: linear;
                animation-delay: 0s;
                animation-iteration-count: infinite;
                animation-direction: alternate;
            }
            body{
            height: 100%;
            width: 100%;
            }

            @keyframes example {
                0%   {left:0px; top:0px; transform: rotate(0deg);}
                100% {left:50%; top:0px; transform: rotate(360deg);}
            }
        </style>
    </head>
    <body>
        <h1> Portal de Navegación </h1>
        <div class="links">
            <div class="vidrio">
            <a href="loginA.php">Login ADMINISTRADOR</a>
            
            <a href="loginC.php">Login USUARIO</a>
            
            <a href="loginB.php">Login ATM</a>
            <br><br>
            <span class="nombre">Banco UMG</span>
            </div>
        </div>
        <div class="moneda"></div>
    </body>
</html>