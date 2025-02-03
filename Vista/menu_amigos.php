<body>
    <h1>MENÚ AMIGOS</h1>
    <p>Bienvenid@ <?php if(isset($_SESSION["usu"])) echo $_SESSION["usu"]?></p>
      <?php echo $tipo?>
    <!-- Cerrar sesión -->
     <!-- <form action="../Controlador/index_usuarios.php">
        <input type="submit" value="salir" name="action">
     </form> -->

     <form action="../Controlador/index_usuarios.php" method="POST">
        <input type="submit" value="Insertar amigos" name="action">
        <input type="submit" value="Buscar Amigos" name="action">
     </form>

     <table>
         <tr><th>Nombre</th><th>Apellidos</th><th>Fecha de nacimiento</th><th><?php if($tipo=="admin") echo "Dueño";?></th><th> </th></tr>
         <?php
            if(isset($datosAmigo)){
               foreach ($datosAmigo as $key => $value) {
                  //Poner fecha en formato Español
                  $timestamp=strtotime($value[2]);
                  $fecha=date("d-m-Y",$timestamp);
                  

                  //Utilizo urlencode() para codificar los valores antes de pasarlos a la URL. Esto garantiza que los espacios y otros caracteres especiales sean válidos en la URL.
                  echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$fecha."</td><td>";

                  if(isset($value[3]))echo $value[3];

                  echo "</td><td><a href='../Controlador/index_usuarios.php?action=Insertar amigos&id=".urldecode($key)."'>Modificar</a></td></tr>";
               }
            }
         ?>
     </table>
</body>