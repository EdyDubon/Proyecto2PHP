<!-- pantalla de TRANSFERENCIAS -->

<?php

if(isset($_POST['cuenta_destino'] )){
        $cuenta_origen = $_POST['cuenta_origen'];
        $cuenta_destino_y_aut = $_POST['cuenta_destino'];
        $autorizacion = preg_replace('/.*\?/', "", $cuenta_destino_y_aut);
        $cuenta_destino = preg_replace('/\?.*/', "", $cuenta_destino_y_aut);
        //echo 'id_item recibido:' . $cuenta_destino . " - a:" . $autorizacion;
        $monto = $_POST['monto'];
    
    $query = "CALL transferencia_monetaria('$cuenta_origen', '$cuenta_destino', $monto, $autorizacion, @resultado);";
   
    $result=$db->query($query);
    
    $query = "select @resultado";

      	if($result=$db->query($query))
         {
            echo '<table >';
            printf ("<tr> <th> %s </th>  </tr>" ,"@resultado");
            $rows = null;
            while($row = $result->fetch_array())
               $rows[]=$row;
      
            if (isset($rows))
            {
               foreach($rows as $row)
               printf ("<tr> <td> %s </td>  </tr>" ,$row["@resultado"]);
               //printf ("%s (%s)<br /n>", $row[0], $row[1]);
            }
            else
            {
               echo 'No hay datos.';
            }

            echo '</table>';

            /* Liberar memoria */
            $result->close();		
         }
         else
         {
            printf("Error: $db->error");
         }
}

   
?>

<h1>TRANSFERENCIA MONETARIA</h1>
<h2>Por favor ingresa los datos</h2>

<form action="#" method="POST">
    <span>Cuenta Origen:</span>
    <?php
      $query = "select id_cuenta, nombre_cuenta, saldo from tb_cuentas_por_usuario where id_usuario = " . $_SESSION['login_user_id'] . ";";   

      	if($result=$db->query($query))
         {
            echo "<select name='cuenta_origen'>";
            $rows=null;
            while($row = $result->fetch_array()) {$rows[]=$row;}
            if (isset($rows)){
               foreach($rows as $row)
               printf ("<option value= %s > %s </option>" ,$row["id_cuenta"], $row["id_cuenta"] . " -- " . $row["nombre_cuenta"] . " [Saldo= Q." . $row['saldo'] . "]" );
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

    <br><br>
    <span>Cuenta Destino:</span>
    <?php
      $id_login = $_SESSION['login_user_id'];
      $query = "select cat.id_autorizacion, cat.id_usuario,  cat.alias, cat.id_cuenta_tercero, tu.nombre_persona  ,cat.monto_max, cat.trx_max_xdia from tb_cuentas_autorizadas_terceros cat inner join tb_cuentas_por_usuario cpu on cat.id_cuenta_tercero = cpu.id_cuenta inner join tb_usuarios tu on cpu.id_usuario = tu.id_usuario where cat.id_usuario = '$id_login'";

      	if($result=$db->query($query))
         {
            echo "<select name='cuenta_destino'>";
            $rows=null;
            while($row = $result->fetch_array()) {$rows[]=$row;}
            if (isset($rows)){
               foreach($rows as $row)
               printf ("<option value= %s > %s </option>" ,$row["id_cuenta_tercero"] . "?" .$row["id_autorizacion"], $row["id_cuenta_tercero"] . " -- " . $row["nombre_persona"] . " [Max.Transf= Q." . $row['monto_max'] . "]" );
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


    <br><br>
    <span>MONTO Q:</span>
    <input type="number" min="1" step="0.01" name="monto"/>
    <br><br><br><br>
    <input type="submit" value="PROCESAR">
</form>
