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
		
      // If result matched $myusername and $mypassword, table row must be 1 row
		echo $active;
      	if($count == 1 && $active == 'activa' ) {
			echo 'login OK';
			//session_register("myusername");
			$_SESSION['login_user'] = $myusername;
			$_SESSION['login_user_id'] = $row['id_usuario'];
			header("location: panel_atm1.php");
			echo 'login OK';
			
		}else {
			//$error = "Your Login Name or Password is invalid";
			echo 'error en login ATM';
			printf(" <br> Desde FORM User: %s  Passwd: %s  <br>", $myusername, $mypassword);
			if ($active == 'bloq'){
				echo '**El usuario se encuentra bloqueado**';
			}
	 	}
  	} else {
		echo 'Get no está definido';
	}

?>