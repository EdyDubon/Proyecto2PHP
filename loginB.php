<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
    if(isset($_SESSION['login_user'])){
        header("location:panel_atm1.php");
    } else {
        echo 'no session';
    }
?>

<!DOCTYPE HTML>
<html lang="en">
<meta charset="utf8"/>

<body>
    <center>
        <h1> LOGIN ATM </h1>
        <form action="loginAtm.php" method="POST">
            <fieldset>
                <legend> Credenciales de ATM</legend>

                NOMBRE:
                <input type="text" name="user" placeholder="usuario"/>
                <br><br>
                CONTRASEÑA:
                <input type="password" name="passwd" placeholder="passwd"/>
                <br><br>
                <input type="submit" value="LOGIN"/>
            </fieldset>

        </form>
    </center>
</body>

</html>
<style>
    center{
        width: 100px;
    }

    input[type="text"]{
        font-size: 14pt;
        width: 250px;
        background-color: rgba(129, 197, 194, 0.1);
        text-align: center;
    }
    input[type="password"]{
        font-size: 14pt;
        width: 250px;
        background-color: rgba(129, 197, 194, 0.1);
        text-align: center;
    }
    input[type="submit"]{
        background-color: aqua;
        width: 100px;
        height: 30px;
    }
</style>