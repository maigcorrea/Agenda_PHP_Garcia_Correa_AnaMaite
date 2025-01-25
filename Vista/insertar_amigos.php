<body>
    <!-- Cambiar título en función de si se le pasa por la url el valor del nombre del amigo a modificar o no -->
    <h1><?php if(isset($_GET["nombre"])){echo "Modificar";}else{echo "Nuevo";}?> Amigo</h1>

    <form action="../Controlador/index_usuarios.php" method="POST">
        <!-- Si se le pasa el valor de un id de amigo a modificar por la url, se almacena en un campo oculto, así al enviar el formulario se podrá utilizar el valor en la función de modificarAmigo() -->
        <?php if(isset($_GET["nombre"])) echo "<input type='hidden' name='idAmigo' value='".htmlspecialchars($_GET['id'])."'>";?>

        <label for="nombre">Nombre</label><br>
        <!-- Si se le pasa el valor por la url, establecerlo como value para que el input se rellene automáticamente -->
        <!-- Utilizo htmlspecialchars como una medida de seguridad para evitar ataques de inyección de código, convierte los caracteres especiales de HTML en su representación segura -->
        <input type="text" name="nombre" value="<?php if(isset($_GET["nombre"])) echo htmlspecialchars($_GET['nombre']);?>" ><br>
        <label for="ape">Apellidos</label><br>
        <input type="text" name="ape" value="<?php if(isset($_GET["apellidos"])) echo htmlspecialchars($_GET['apellidos']);?>" ><br>
        <label for="nac">Fecha Nacimiento</label><br>
        <input type="date" name="nac" value="<?php if(isset($_GET["nacimiento"])) echo htmlspecialchars($_GET['nacimiento']);?>" ><br>

        <!-- Cambiar botón en función de si se le pasa por la url el valor del nombre del amigo a modificar o no -->
        <input type="submit" value="<?php if(isset($_GET["nombre"])){echo "Modificar amigo";}else{echo "Enviar";}?>" name="action">
    </form>
    <?php
        if(isset($mensaje)) echo "<p>$mensaje</p>";
    ?>
</body>