<!-- pantalla de NUEVA CUENTA -->

<?php
require ('session.php');

if(isset($_POST['id_cuenta'] )){
        $id_cuenta = $_POST['id_cuenta'];
        $id_usuario = $_SESSION['login_user_id'];
        $nombre_cuenta = $_POST['nombre_cuenta'];
        $dpi = $_POST['dpi'];
        $saldo = $_POST['saldo'];
        //echo 'id_item recibido:' . $id_cuenta . $id_usuario . $nombre_cuenta . $dpi . $saldo;
        
        $sql = "insert into tb_cuentas_por_usuario  (id_cuenta, id_usuario, nombre_cuenta, dpi, saldo) values ('$id_cuenta', $id_usuario, '$nombre_cuenta', '$dpi', $saldo) ";
        if ($db->query($sql)) {
           echo "Cuenta creada OK";
        } else {
           echo "Error en ejecución del query: " . $sql . "<br>" . $conn->error;
        }
   }
?>

<h1>:::NUEVA CUENTA:::</h1>
<h2>Por favor ingresa los datos</h2>

<form action="#" method="POST">

    <span>Identificador (No.) de la cuenta:</span><input type="text" name="id_cuenta" placeholder="no.cuenta" required/>
    <span></span><input hidden type="text" name="id_usuario" placeholder="id.usuario"/>
    <br><br>
    <span>Nombre/Alias de la cuenta</span><input type="text" name="nombre_cuenta" placeholder="nombre_cta" required/>
    <br><br>
    <span>DPI (Identificacion)</span><input type="text" name="dpi" placeholder="DPI (identificación)" required/>
    <br><br>
    <span>Saldo Inicial Q.</span><input type="number" min="100" step="100" name="saldo" placeholder="saldo inicial" required/>
    <br><br><br><br>
    <input type="submit" value="REGISTRAR">
</form>
