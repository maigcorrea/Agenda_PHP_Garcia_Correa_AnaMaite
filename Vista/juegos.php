<body class="menuAmigos">
<div class="botonesContainer d-flex justify-content-end mx-5 mt-5">
<form action="../Controlador/index_usuarios.php" method="post">
    <input type="submit" value="Insertar juego" name="action">
    <input type="submit" value="Buscar juegos" name="action">
</form>
</div>

<div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center">
<table>
         <tr><th>JUEGO</th><th>TITULO</th><th>PLATAFORMA</th><th>FECHA DE LANZAMIENTO</th><th> </th></tr>
         <?php
            if(isset($datosJuegos)){
               foreach ($datosJuegos as $key => $value) {
                  echo "<tr><td><img src='".$value[0]."'/></td><td>".$value[1]."</td><td>".$value[2]."</td><td>".$value[3]."</td><td><a href='../Controlador/index_usuarios.php?action=insertarjuego&id=".urldecode($key)."'>Modificar</a></tr>";
               }
            }
         ?>
     </table>
</div>
<?php

?>