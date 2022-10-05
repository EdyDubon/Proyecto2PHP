<?php
   include('session.php');
   require ('conexion.php');

   if(isset($_POST['id_cuenta'] )){
      echo 'id_item recibido:' . $_POST['usuario'];
      $id_usuario = $_SESSION['login_user_id'];
      $id_cuenta_tercero = $_POST['id_cuenta'];
      $monto_max = $_POST['monto_max'];
      $trx_max_xdia = $_POST['trx_max_xdia'];
      $alias = $_POST['alias'];
      
      $sql = "insert into tb_cuentas_autorizadas_terceros (id_usuario, id_cuenta_tercero , monto_max, trx_max_xdia, alias) values ($id_usuario, '$id_cuenta_tercero' , $monto_max, $trx_max_xdia, '$alias')";
      //echo $sql;
      
      if ($db->query($sql)) {
         echo "query ejecutado OK";
      } else {
         echo "Error en ejecución del query: " . $sql . "<br>" . $conn->error;
      }
   }
?>


<!DOCTYPE html>
<html>
   <head>
      <title>Welcome to USER Panel </title>
   </head>
   <style>
    
    table{
        width: 40%;
        border-style:dashed; 
        border-color: #000 #000 #000 #000; 
        border-width: 1px 1px 1px 1px;"
    }
    td{ 
        background-color: #FFFEFF; 
        border-style:dotted; 
        border-color: #000 #000 #000 #000; 
        border-width: 0px 0px 1px 1px;"
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

    #estado_cuenta{
      width: 60%;
    }

    details > summary {
  padding: 4px;
  width: 200px;
  background-color: #eeeeee;
  border: none;
  box-shadow: 1px 1px 2px #bbbbbb;
  cursor: pointer;
}

details > p {
  background-color: #eeeeee;
  padding: 4px;
  margin: 0;
  box-shadow: 1px 1px 2px #bbbbbb;
}
</style>



   <body>
   <br><br>
      <h1>Bienvenido, usuario: <?php echo $_SESSION['login_user']; ?></h1> 
      <?php include ('cabecera.php'); ?> 

<div id="estado_cuenta">
<table><tr><td>
      <form action="#" method="POST">
         <strong>AGREGAR/AUTORIZAR NUEVA CUENTA DE TERCEROS:</strong><br>
         <br>Numero de Cuenta:
         <?php
   $user_login_id = $_SESSION['login_user_id'];
   $query = "select tcu.id_cuenta, tcu.nombre_cuenta, us.nombre_persona  from tb_cuentas_por_usuario tcu inner join tb_usuarios us on tcu.id_usuario = us.id_usuario where tcu.id_usuario <> '$user_login_id'";   

      	if($result=$db->query($query))
         {
            echo "<select name='id_cuenta' required>";
            while($row = $result->fetch_array()) {$rows[]=$row;}
            if (isset($rows)){
               foreach($rows as $row)
               printf ("<option value= %s > %s </option>" ,$row["id_cuenta"], $row["id_cuenta"] . " -- " . $row["nombre_cuenta"] . " [" . $row['nombre_persona'] . "]" );
            } else{
               echo 'No hay datos.';
            }
            echo '</select>';

            /* Liberar memoria */
            $result->close();		
         } else {
            printf("Error: $db->error");
         }
   ?>
<br>
         <br>Alias: <input type="text" name="alias" required/> 
<br>
         <br>Monto máximo por Trx: <input type="number" min="100" name="monto_max" required/> 
<br>
         <br>Máximo de trx por día: <input type="number" min="0" step="1" name="trx_max_xdia" required/> 
<br><br><br><br><br><br>
         <input type="submit" id="btn_submit" value="Adicionar cuenta de tercero"/>
      </form>
   </td>
   <td>
      <?php include ('atms/pantalla5.atm.php') ?>
   </td>
   <tr>
</table>
      <hr>
      <h2>Lista de cuentas de terceros autorizadas: </h2>
         
   <details>
         <summary>Desplegar listado de Cuentas Autorizadas</summary>
   <p>   
   <?php
   require ('conexion.php');
   $id_login = $_SESSION['login_user_id'];
   $query = "select cat.id_usuario,  cat.alias, cat.id_cuenta_tercero, tu.nombre_persona  ,cat.monto_max, cat.trx_max_xdia from tb_cuentas_autorizadas_terceros cat inner join tb_cuentas_por_usuario cpu on cat.id_cuenta_tercero = cpu.id_cuenta inner join tb_usuarios tu on cpu.id_usuario = tu.id_usuario where cat.id_usuario = '$id_login'";

      	if($result=$db->query($query))
         {
            echo 'OK';
            echo '<table style="border:solid">';
            $rows = null;
            while($row = $result->fetch_array()) {$rows[]=$row;}
            printf ("<tr> <th> %s </th> <th>%s</th> <th> %s </th> <th> %s </th> <th> %s </th>  </tr>" ,"alias", "id_cuenta_tercero", "nombre", 'monto máximo por trx', 'máximo de trx por día');
            if (isset($rows)) {
               foreach($rows as $row)
               printf ("<tr><td> %s </td> <td> %s </td> <td> %s </td>  <td> %s </td>  <td> %s </td>  </tr>",$row["alias"] , $row["id_cuenta_tercero"], $row["nombre_persona"], $row["monto_max"], $row["trx_max_xdia"] );
            }else{
               echo 'No hay datos.';
            }
            echo '</table>';
            /* Liberar memoria */
            $result->close();		
         }else{
            printf("Error: $db->error");
         }
   ?>
   </p>
</details>
   <hr>
   <details>
      <summary> Desplegar Estado de Cuenta</summary>
      <p>
      <?php include ('atms/pantalla6.atm.php') ?>
      </p>
   </details>
   </div>
   </body>   
</html>