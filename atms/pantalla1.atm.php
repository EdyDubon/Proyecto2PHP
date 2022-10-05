<!-- pantalla de bienvenida (cuentas y saldos) -->
<?php
include('session.php');

?>

<h1>Bienvenido al sistema ATM</h1>
<h3>Por favor selecciona una opción para continuar</h3>
Usuario: <strong> <?php echo $_SESSION['login_user']; ?> </strong>
| Saldo total en cuentas (Propias): <strong> 
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
<hr>
cuentas y saldos:

<style>
    
    table{
        width: 100%;
        font-size: 9pt;
        border-style:dashed; 
        border-color: #000 #000 #000 #000; 
        border-width: 1px 1px 1px 1px;
    }
    td{ 
        background-color: #FFFEFF; 
        border-style:dotted; 
        border-color: #000 #000 #000 #000; 
        border-width: 0px 0px 1px 1px;"
    }
    input[type=submit] {
      background-color: #04AA6D;
      border: none;
      color: white;
      padding: 16px 32px;
      text-decoration: none;
      margin: 4px 2px;
      cursor: pointer;
    }
</style>

<?php
   $query = "select * from tb_cuentas_por_usuario where id_usuario = " . $_SESSION['login_user_id'] . ";";   

      	if($result=$db->query($query))
         {
            echo '<table >';
            printf ("<tr> <th> %s </th> <th>%s</th> <th> %s </th> <th> %s </th>  </tr>" ,"id_cuenta", "nombre_cuenta", "dpi", 'saldo');
            $rows=null;
            while($row = $result->fetch_array())
               $rows[]=$row;
      
            if (isset($rows))
            {
               foreach($rows as $row)
               printf ("<tr> <td> %s </td> <td>%s</td> <td> %s </td> <td> %s </td>  </tr>" ,$row["id_cuenta"], $row["nombre_cuenta"], $row["dpi"], $row['saldo']);
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

