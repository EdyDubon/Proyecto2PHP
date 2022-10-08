<?php 	
require 'conexion.php';
   session_start();
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// username and password sent from form 
		$myusername = mysqli_real_escape_string($db,$_POST['user']);
		$mypassword = mysqli_real_escape_string($db,$_POST['passwd']); 
		$sql = "SELECT id_usuario, is_look FROM tb_usuarios WHERE nombre_usuario = '$myusername' and passwd_usuario = '$mypassword'";
		$result = mysqli_query($db,$sql);
		//$mysqli->close();
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$active = $row['is_look'];
		$count = mysqli_num_rows($result);
      	if($count == 1 && $active == 'activa' ) {
			//session_register("myusername");
			$_SESSION['login_user'] = $myusername;
			$_SESSION['login_user_id'] = $row['id_usuario'];
			header("location: panel_user.php");
		}else {
			//printf(" <br> Desde FORM UserLogin: %s  Passwd: %s  <br>", $myusername, $mypassword);
			if ($active == 'bloq'){
				echo '<h1>**El usuario se encuentra bloqueado**</h1>';
			} else {
			    echo '<h1>**El usuario o contraseña no son válidos**</h1>';
			}
	 	}
  	} else {
		echo 'Get no está definido';
	}
?>