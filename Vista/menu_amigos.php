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
        <input type="submit" value="Buscar amigos" name="action">
     </form>

     <table>
      <!-- RECUERDA QUE TIENES QUE MOSTRAR LA FECHA EN FORMATO ESPAÑOL!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
         <tr><th>Nombre</th><th>Apellidos</th><th>Fecha de nacimiento</th><th> </th></tr>
         <?php
            if(isset($datosAmigo)){
               foreach ($datosAmigo as $key => $value) {
                  //Utilizo urlencode() para codificar los valores antes de pasarlos a la URL. Esto garantiza que los espacios y otros caracteres especiales sean válidos en la URL.
                  echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$value[2]."</td><td><a href='../Controlador/index_usuarios.php?action=Insertar amigos&nombre=". urlencode($value[0])."&apellidos=".urlencode($value[1])."&nacimiento=".urlencode($value[2])."&id=".urldecode($key)."'>Modificar</a></td></tr>";
               }
            }
         ?>
     </table>
</body>