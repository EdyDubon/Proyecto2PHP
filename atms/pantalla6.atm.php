<!-- pantalla de Estado de cuenta -->
<?php
include('session.php');

?>

<h1>:::Estado de Cuenta:::</h1>
<h3>Transacciones detalladas</h3>
Usuario: <strong> <?php echo $_SESSION['login_user']; ?> </strong>
| Saldo total en cuentas: <strong> 
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
</strong>
<hr>
Movimientos realizados:

<style>
    
    table{
        width: 100%;
        border-style:dashed; 
        border-color: #000 #000 #000 #000; 
        border-width: 1px 1px 1px 1px;
        font-size: 8pt;
    }
    td{ 
        background-color: #FFFEFF; 
        border-style:dotted; 
        border-color: #000 #000 #000 #000; 
        border-width: 0px 0px 1px 1px;"
    }
</style>

<?php
   $id_usuario = $_SESSION['login_user_id'];
   $query = "select trl.hora, trl.cuenta_origen, trl.cuenta_destino, trl.monto, rsp.descripcion from tr_log trl inner join tb_resp_codes rsp on trl.resp_code = rsp.resp_code where trl.cuenta_origen  in (select id_cuenta from tb_cuentas_por_usuario where id_usuario = $id_usuario ) or trl.cuenta_destino  in (select id_cuenta from tb_cuentas_por_usuario where id_usuario = $id_usuario ) order by trl.hora desc; ";   

      	if($result=$db->query($query))
         {
            echo '<table >';
            printf ("<tr> <th> %s </th> <th>%s</th> <th> %s </th> <th> %s </th> <th> %s </th>  </tr>" ,"Fecha TRX", "CUENTA ORIGEN", "CUENTA DESTINO", 'MONTO', 'TIPO TRX');
            $rows=null;
            while($row = $result->fetch_array())
               $rows[]=$row;
      
            if (isset($rows))
            {
               foreach($rows as $row)
               printf ("<tr> <td> %s </td> <td>%s</td> <td> %s </td> <td> %s </td>  <td> %s </td>  </tr>" ,$row["hora"], $row["cuenta_origen"], $row["cuenta_destino"], $row['monto'], $row['descripcion'] );
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
   ?>

