<body class="menuAmigos">
    <h1 class="text-center mt-5">MENÚ AMIGOS</h1>
    <p class="text-center">Bienvenid@ <?php if(isset($_SESSION["usu"])) echo $_SESSION["usu"]?></p>
    <!-- Cerrar sesión -->
     <!-- <form action="../Controlador/index_usuarios.php">
        <input type="submit" value="salir" name="action">
     </form> -->
   <div class="botonesContainer d-flex justify-content-end mx-5">
      <form action="../Controlador/index_usuarios.php" method="POST">
         <input type="submit" value="Insertar amigos" name="action" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
         <input type="submit" value="Buscar Amigos" name="action" class="btn btn-success btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
      </form>
   </div>

     <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center">
        <table class="bg-white rounded">
            <tr><th>Nombre</th><th>Apellidos</th><th>Fecha de nacimiento</th><th><?php if($tipo=="admin") echo "Dueño";?></th></tr>
            <?php
               if(isset($datosAmigo)){
                  foreach ($datosAmigo as $key => $value) {
                     //Poner fecha en formato Español
                     $timestamp=strtotime($value[2]);
                     $fecha=date("d-m-Y",$timestamp);
                     
   
                     //Utilizo urlencode() para codificar los valores antes de pasarlos a la URL. Esto garantiza que los espacios y otros caracteres especiales sean válidos en la URL.
                     echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$fecha."</td>";
                     if($tipo=="admin" && isset($value[3])) echo "<td>$value[3]</td>";
   
                     // if(isset($value[3]))echo $value[3];
   
                     //EN VEZ DE PASARLE LA URL SE LO PUEDO PASAR POR POST CON UN SUBMIT (INPUT HIDDEN) PARA ASÍ LUEGO NO USAR $_REQUEST EN vistaInsertarAmigos() en el controlador
                     echo "<td><a href='../Controlador/index_usuarios.php?action=Insertar amigos&idAmigo=".urldecode($key)."'>Modificar</a></td></tr>";
                  }
               }
            ?>
        </table>
     </div>

     

   <!-- <script src="../Vista/style.js"></script>  -->
</body>