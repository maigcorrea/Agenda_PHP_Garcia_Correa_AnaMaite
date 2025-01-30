<body>
    <!-- Cambiar título en función de si se le pasa por la url el valor del nombre del amigo a modificar o no -->
    <h1><?php if(isset($_GET["id"])){echo "Modificar";}else{echo "Nuevo";}?> Amigo</h1>

    <form action="../Controlador/index_usuarios.php" method="POST">
        <!-- Si se le pasa el valor de un id de amigo a modificar por la url, se almacena en un campo oculto, así al enviar el formulario se podrá utilizar el valor en la función de modificarAmigo() -->
        <?php if(isset($_GET["id"])) echo "<input type='hidden' name='idAmigo' value='".htmlspecialchars($_GET['id'])."'>";?>

        <label for="nombre">Nombre</label><br>
       <!-- Establecer los datos del array para rellenar los campos automáticamente-->
        <!-- Utilizo htmlspecialchars como una medida de seguridad para evitar ataques de inyección de código, convierte los caracteres especiales de HTML en su representación segura -->
        <input type="text" name="nombre" value="<?php if(isset($datos[0])) echo $datos[0];?>" ><br>
        <label for="ape">Apellidos</label><br>
        <input type="text" name="ape" value="<?php if(isset($datos[1])) echo $datos[1];?>" ><br>
        <label for="nac">Fecha Nacimiento</label><br>
        <input type="date" name="nac" value="<?php if(isset($datos[2])) echo $datos[2];?>" ><br>
        <!-- Añadir un campo más en caso de que el usuario sea administrador -->
        <?php if($tipo=="admin") {
            echo "
                 <label for='duenio'>Dueño</label><br>
                <select name='duenio'>
                    <option>faerf</option>
                    <option>faerf</option>
                    <option>faerf</option>
                </select><br>
            
            ";
        }?>

        <!-- Cambiar botón en función de si se le pasa por la url el valor del nombre del amigo a modificar o no -->
        <input type="submit" value="<?php if(isset($_GET["nombre"])){echo "Modificar amigo";}else{echo "Enviar";}?>" name="action">
    </form>
    <?php
        if(isset($mensaje)) echo "<p>$mensaje</p>";
    ?>
</body>