<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8"/>
        <title> INICIO </title>
        <style type="text/css">
             .vidrio{
                height: 30px;
                width: 600px;
                background: rgba(255,250,0,0.1);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(2.5px);
                -webkit-backdrop-filter: blur(2.5px);
                border: 1px solid rgba(255, 255, 255, 0.25);
                z-index: 0;
                position: fixed;
                top: 0;
            }
            .link{
                position: fixed;
                font-size: 8pt;
                top: 0;
                margin: 20px;
                padding: 10px;
                color: white;
                font-weight: 900;
                background-color: rgb(39, 169, 192);
                border-style: solid;
                border-width: 1px;
                position: relative;
            }
            .link:hover{
                box-shadow: 10px 10px #000;
                font-size: 9pt;
            }

            .sign_out{
                background-color: rgb(200, 000, 000);
            }
        </style>
 </head>
    <body>
        <div class="links">
            <div class="vidrio">
            <a href="loginA.php" class="link">ADMINISTRADOR</a>
            
            <a href="loginC.php" class="link">USUARIO</a>
            
            <a href="loginB.php" class="link">ATM</a>

            <a href = "logout.php" class="link sign_out">Sign Out</a>
            </div>
        </div>
    </body>
</html>
