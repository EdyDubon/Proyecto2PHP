<?php
session_start();

    if(isset($_SESSION['login_user'])){
        header("location:panel_user.php");
    } else {
        echo 'no session';
    }
?>

<!DOCTYPE HTML>
<html lang="en">
<meta charset="utf8"/>

<body>
<h1>Welcome <?php echo $_SESSION['login_user']; ?></h1> 
    <center>
        <h1> LOGIN USER </h1>
        <form action="loginUser.php" method="POST">
            <fieldset>
                <legend> Credenciales de Usuario</legend>

                NOMBRE:
                <input type="text" name="user" placeholder="usuario"/>
                <br>
                CONTRASEÑA:
                <input type="password" name="passwd" placeholder="passwd"/>
                <input type="submit" value="LOGIN"/>
            </fieldset>

        </form>
    </center>
</body>

</html>