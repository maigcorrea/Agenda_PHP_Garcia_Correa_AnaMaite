<form action="../Controlador/index_usuarios.php" method="post">
    <input type="submit" value="Insertar juego" name="action">
    <input type="submit" value="Buscar juego" name="action">
</form>

<table>
         <tr><th>JUEGO</th><th>TITULO</th><th>PLATAFORMA</th><th>FECHA DE LANZAMIENTO</th><th> </th></tr>
         <?php
            if(isset($datosJuegos)){
               foreach ($datosJuegos as $key => $value) {
                  echo "<tr><td><img src='".$value[0]."'/></td><td>".$value[1]."</td><td>".$value[2]."</td><td>".$value[3]."</td><td><a href='../Controlador/index_usuarios.php?action=insertar juego&img=". urlencode($value[0])."&tit=".urlencode($value[1])."&plat=".urlencode($value[2])."&lanz=".urldecode($value[3])."&id=".urldecode($key)."'>Modificar</a></tr>";
               }
            }
         ?>
     </table>
<?php

?>