<table>
         <tr><th>JUEGO</th><th>TITULO</th><th>PLATAFORMA</th><th>FECHA DE LANZAMIENTO</th><th> </th></tr>
         <?php
            if(isset($datosJuegos)){
               foreach ($datosJuegos as $key => $value) {
                  echo "<tr><td><img src='".$value[0]."'/></td><td>".$value[1]."</td><td>".$value[2]."</td><td>".$value[3]."</td><td><a href='#'>Modificar</a></td></tr>";
               }
            }
         ?>
     </table>
<?php

?>