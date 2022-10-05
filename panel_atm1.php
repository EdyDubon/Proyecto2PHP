<?php
include('session.php');
require ('conexion.php');
?>

<style>
    #screen{
        width: 850px;
        border: solid 1px;
        height: 450px;
        background-color: #fcda02;
        box-shadow: 10px 20px 16px #888888;
    }

    #left {
        width: 15%;
        height: 100%;
        background-color: yellow;
        float: left;
        text-align: center;
        border-style: solid;
        border-width: 2px 2px 2px 2px;
    }

    #center {
        width: 67%;
        height: 90%;
        background: rgb(252,255,255);
        background: radial-gradient(circle, rgba(252,255,255,1) 0%, rgba(243,252,255,1) 70%, rgba(218,248,255,1) 100%); 
        display:inline-block;
        border-color: #000 #000 #222 #222;
        border-style: solid;
        border-width: 5px 10px 5px 10px;
        overflow-y: scroll;
    }

    #right{
        width: 14.5%;
        height: 100%;
        background-color: yellow;
        float: right;
        text-align: center;
        border-style: solid;
        border-width: 2px 2px 2px 2px;
    }

    .btn_atm{
        background-color: #e7e7e7; 
        width: 100px;
        border: none;
        color: black;
        padding: 15px 5px;
        text-align: left;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 1px 1px;
        cursor: pointer;
        font-size: 16px;
        border-color: #000 #000 #000 #000;
        border-style: solid;
        border-width: 0.5px 0.5px 0.5px 0.5px;
        box-shadow: 2px 9px #555;
        font-weight: 900;
        border-radius: 15px;
    }

    .btn_atm:hover{
        background-color: #DDD; 
    }
    .btn_atm:active {
        background-color: #EEE;
        box-shadow: 0px 5px #999;
        transform: translateY(6px);
    }

    .btn_atm_red{
        background-color: red; 
        width: 100px;
        color: white;
        padding: 15px 5px;
        text-align: left;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 1px 1px;
        cursor: pointer;
        font-size: 16px;
        border-color: #000 #000 #000 #000;
        border-style: solid;
        box-shadow: 1px 5px #555;
    }
    .btn_atm_red:active {
        background-color: #FF0000;
        box-shadow: 0px 2px #999;
        transform: translateY(6px);
    }
    input[type=submit] {
      background-color: #04AA6D;
      border: none;
      color: white;
      padding: 16px 32px;
      text-decoration: none;
      margin: 4px 2px;
      cursor: pointer;
      position: relative;
      bottom: 0;
      left: 38%;
    }
    input[type=text]{
        float: right;
        width: 300px;
    }
    select{
        float: right;
        width: 300px;
    }
    input[type=number]{
        display:inline;
        float: right;
    }

    span{
        display:inline-block;
    }

    .small_txt{
        font-size: 7.5pt;
    }

    .logo{
        font-size: 36pt;
        font-weight: 900;
        color: white;
        padding: 2px 16px;
        background-color: blue;
        border-radius: 50%;
    }
</style>

<!DOCTYPE html>
<html>
    <head>
      <title>Welcome to ADM Panel </title>
    </head>
   
    <body>
<br><br>
        <h1>ATM:  Bienvenido  <?php echo $_SESSION['login_user']; ?></h1> 
        <?php include ('cabecera.php'); ?>
        <div id="screen">
                <div id="left">
                    <br>
                    <a href="panel_atm1.php?screen=2" class="btn_atm" >RETIRO</a>
                    <br><br><br>
                    <a href="panel_atm1.php?screen=3" class="btn_atm" >DEPÓSITO</a>
                    <br><br><br>
                    <a href="panel_atm1.php?screen=5" class="btn_atm small_txt" >TRANSFERENCIA MONETARIA</a>
                    <br><br><br>
                    <span class="logo">4B</span>
                </div>
                <div id="center">
                    <?php 
                        if(isset($_GET['screen'])){
                            switch ($_GET['screen']){
                                case 1:
                                    include ('atms/pantalla1.atm.php');
                                    break;
                                case 2:
                                    include ('atms/pantalla2.atm.php');
                                    break;
                                case 3:
                                    include ('atms/pantalla3.atm.php');
                                    break;
                                case 4:
                                    include ('atms/pantalla4.atm.php');
                                    break;
                                case 5:
                                    include ('atms/pantalla5.atm.php');
                                    break;
                                case 6:
                                    include ('atms/pantalla6.atm.php');
                                    break;
                            }
                        } else {
                            include ('atms/pantalla1.atm.php');
                        }
                    
                    ?>
                </div>
                <div id="right">
                    <br>
                    <a href="panel_atm1.php?screen=4" class="btn_atm" >NUEVA CUENTA</a>
                    <br><br><br><br>
                    <a href="panel_atm1.php?screen=6" class="btn_atm" >ESTADO DE CUENTA</a>
                    <br><br><br><br>

                    <a href="panel_atm1.php?screen=1" class="btn_atm_red" >CANCELAR</a>
                </div>
        <div>
    </body>
</html>

