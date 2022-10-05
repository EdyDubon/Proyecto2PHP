<?php
   include('session.php');
   require ('conexion.php');

   if(isset($_GET['id_item'] )){
      echo 'id_item recibido:' . $_GET['id_item'];
      $id_item = $_GET['id_item'];
      $mode = $_GET['mode'];

      switch ($mode){
         case 'a':
            $sql = "update tb_usuarios set is_look = 'activa' where id_usuario = '$id_item' ";
            if ($db->query($sql)) {
               echo "(activo)query ejecutado OK";
            } else {
               echo "Error en ejecución del query: " . $sql . "<br>" . $conn->error;
            }
            break;
         case 'b':
            $sql = "update tb_usuarios set is_look = 'bloq' where id_usuario = '$id_item' ";
            if ($db->query($sql)) {
               echo "(bloq)query ejecutado OK";
            } else {
               echo "Error en ejecución del query: " . $sql . "<br>" . $conn->error;
            }
            break;
      }
   }

   if(isset($_POST['usuario'] )){
      echo 'id_item recibido:' . $_POST['usuario'];
      $usuario = $_POST['usuario'];
      $pwd = $_POST['passwd'];
      $nombre_persona = $_POST['nombre'];
      $sql = "insert into tb_usuarios (nombre_usuario, passwd_usuario, nombre_persona) values ('$usuario', '$pwd', '$nombre_persona');";
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
      <title>ADM Panel </title>
      <style type="text/css">
           table{
        width: 500px;
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
   </head>
   
   <body>
   <br><br>
      <h1>PANEL DE ADMINISTRACION [<?php echo $_SESSION['login_user']; ?>] </h1> 
      <?php include ('cabecera.php'); ?>

      <form action="#" method="POST">
         <strong>AGREGAR NUEVO USUARIO DE ATM:</strong><br>
         <br>Nombre Completo: <br><input type="text" name="nombre"/> 
         <br>usuario: <br><input type="text" name="usuario" required/> 
         <br>Contraseña: <br><input type="password" id="pwd_1" name="passwd" required/> 
         <br>Confirmar Contraseña: <br><input type="password" id="confirmar_pwd"/> 
         <input type="submit" id="btn_submit" value="Registrar nuevo usuario"/>
         <br><div id="msg_pwd">Contraseña no coincide!</div>
      </form>
      <br>
      <h2>Lista de perfiles de ATM registrados en el sistema:</h2>

   <?php
   require ('conexion.php');
   $query = "select * from tb_usuarios";   

      	if($result=$db->query($query))
         {
            echo '<table style="border:solid">';
            printf ("<tr><th> %s </th> <th> %s </th> <th>%s</th>  <th> %s </th> <th> %s </th> <th> %s </th>  </tr>","ESTADO","ID", "USUARIO", "NOMBRE CLIENTE" , "BLOQUEAR", "DESBLOQUEAR");
            while($row = $result->fetch_array())
               $rows[]=$row;
      
            if (isset($rows))
            {
               foreach($rows as $row)
               printf ("<tr><td> %s </td> <td> %s </td> <td>%s</td>  <td> %s </td> <td> %s </td> <td> %s </td>  </tr>",$row["is_look"] ,$row["id_usuario"], $row["nombre_usuario"], $row["nombre_persona"], "<a href=panel_adm_admin.php?mode=b&id_item=" . $row['id_usuario'] . "> BLOQ <a/>", "<a href=panel_adm_admin.php?mode=a&id_item=" . $row['id_usuario'] . "> DESBLOQ <a/>");
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

<div id="grafica_barras">
        <br>
        <br>
          <div>
            <br>

         <?php
         $query = "call contar_24hrs;";   
         
      	if($result=$db->query($query))
         {
            $rows=null;
            while($row = $result->fetch_array()) {$rows[]=$row;}
            if (isset($rows)){
               foreach($rows as $row){
                  $conteo = $row["str"];
                  $conteo_usuarios_trx = $row['conteo_usuarios_trx'];
                  $monto_trx_dia = $row['monto_trx_dia'];
                  echo "<input type='hidden' id='num' value=\"$conteo\" > ";
                  echo "<input type='hidden' id='conteo_usuarios_trx' value=\"$conteo_usuarios_trx\" > ";
                  echo "<input type='hidden' id='monto_trx_dia' value=\"$monto_trx_dia\" > ";
               }
            } else{
               echo 'No hay datos.';
            }
            /* Liberar memoria */
            $result->close();		
         } else {
            printf("Error: $db->error");
         }
   ?>


            <br>
            <canvas id="myCanvas" width="1180px" height="350px" style="border:1px solid #c3c3c3;"></canvas>
          </div>
    </div>


   </body>
   <script type="text/javascript">
         window.document.body.onload = inicializar();

         function inicializar(){
            document.getElementById('confirmar_pwd').addEventListener('input',validar);
            document.getElementById('btn_submit').disabled = true;
         }

         function validar(){
            //alert('validate');
            let pwd_1 = document.getElementById('pwd_1').value;
            let pwd_2 = document.getElementById('confirmar_pwd').value;

            if (pwd_1 == pwd_2){
               document.getElementById('msg_pwd').hidden = true;
               document.getElementById('btn_submit').disabled = false;
               //alert('coincide');
            } else {
               document.getElementById('msg_pwd').hidden = false;
               document.getElementById('btn_submit').disabled = true;
            }
         }
      </script>
      <script>

window.onload=draw();

    function reset(){

        // Clearing the input field 
        var inputs = document.getElementsByTagName("input");
        for(var i=0;i<inputs.length;i++)
        inputs[i].value = '';

        // Clearing the Canvas
        var canvas = document.getElementById('myCanvas');
        var ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        window.location.reload();

    }

    function draw(){

        // crear array
        var n = document.getElementById("num").value.split(/\s/);
        console.log(n);
         
        var canvas = document.getElementById('myCanvas');
        var ctx = canvas.getContext('2d');
        var width= 30; // bar width
        var X = 60; // first bar position 
        var base = 200;
        console.log(Math.max(...n));
        var scale_y = canvas.height/(Math.max(...n)+4);
        var space_h_titles = 30;
        var conteo_usuarios_trx = document.getElementById('conteo_usuarios_trx').getAttribute('value');
        var monto_trx_dia = document.getElementById('monto_trx_dia').getAttribute('value');
                
            // líneas
        for (var i =0; i<n.length; i++) {
            ctx.fillStyle = '#555'; 
            var h = n[i];
            X +=  width+15;

          
            if (h != 0){
            // Dashed horizontal line 
            ctx.strokeStyle = '#DDD';
            ctx.lineWidth = 1;
            ctx.beginPath();
            //ctx.setLineDash([5, 20]);
            ctx.moveTo(50, canvas.height - h*scale_y - space_h_titles );
            ctx.lineTo(canvas.width - 60, canvas.height - h*scale_y - space_h_titles);
            ctx.stroke();
            }
         }

               //barras
            var X = 60; // first bar position 
            for (var i =0; i<n.length-1; i++) {
            ctx.fillStyle = '#555'; 
            var h = n[i];
            ctx.fillRect(X,canvas.height - h*scale_y-space_h_titles,width,(h*scale_y));
            X +=  width+15;
            // Texto de escala vertical
            if (h != 0){
            ctx.fillStyle = '#000';
            ctx.fillText(h+' trx',10,canvas.height - h*scale_y - space_h_titles);
            // Text to display Bar number
            ctx.fillStyle = '#00F';
            ctx.fillText(h+' trx',X-40,canvas.height - h*scale_y - space_h_titles - 20);
            }
            
            

            ctx.fillStyle = '#000000';
            ctx.fillText(i.toString().padStart(2, '0')+':00',X-40,canvas.height - (space_h_titles - 20));
        }

            // Titulo
            ctx.font = "bold 24px verdana, sans-serif ";
            ctx.fillStyle = '#000';
            var fecha = new Date();
            ctx.fillText('Gráfico de transacciones por hora: '+fecha.toDateString(),canvas.width/6,20);
            
            ctx.font = "bold 14px verdana, sans-serif ";
            ctx.fillText('Monto de TRX Hoy: Q.'+monto_trx_dia,canvas.width-500,40);         
            ctx.fillText('Usuarios que han realizado trx: '+conteo_usuarios_trx, 20,40);
  
    }
    
</script>

</html>