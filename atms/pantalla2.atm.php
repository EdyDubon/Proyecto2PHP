<!-- pantalla de retiro -->

<?php
require ('session.php');

if(isset($_POST['cuenta_origen'] )){
    $cuenta_origen = $_POST['cuenta_origen'];
    $monto = $_POST['monto'];
    
    $query = "CALL retiro_monetario('$cuenta_origen', $monto, @resultado);";
    $result=$db->query($query);
    
    $query = "select @resultado";

      	if($result=$db->query($query))
         {
            echo '<table >';
            printf ("<tr> <th> %s </th>  </tr>" ,"@resultado");
            $rows=null;
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

<h1>:::RETIRO MONETARIO:::</h1>
<h2>Por favor ingresa los datos</h2>
>>Saldo total en cuentas (Propias): <strong> 
    <?php
   $query = "select sum(saldo) tsaldo from tb_cuentas_por_usuario where id_usuario = " . $_SESSION['login_user_id'] . ";";   

      	if($result=$db->query($query))
         {
            echo '<strong>Q.';
            $row = $result->fetch_array();
            echo $row['tsaldo'];
            echo '</strong>';
            /* Liberar memoria */
            $result->close();		
         } else {
            printf("Error: $db->error");
         }
   ?>
   <br><br>
<form action="#" method="POST">
    
    <span>Cuenta Origen (propias):</span>
    <?php
   $query = "select id_cuenta, nombre_cuenta, saldo from tb_cuentas_por_usuario where id_usuario = " . $_SESSION['login_user_id'] . ";";   

      	if($result=$db->query($query))
         {
            echo "<select name='cuenta_origen'>";
            $rows=null;
            while($row = $result->fetch_array()) {$rows[]=$row;}
            if (isset($rows)){
               foreach($rows as $row)
               printf ("<option value= %s > %s </option>" ,$row["id_cuenta"], $row["id_cuenta"] . " -- " . $row["nombre_cuenta"] . " [Q." . $row['saldo'] . "]" );
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
    <span>Monto:</span>
    <input type="number" min="100" step="100" name="monto" placeholder="MONTO A RETIRAR"/>
    <br><br><br><br>
    <input type="submit" value="PROCESAR">
</form>
