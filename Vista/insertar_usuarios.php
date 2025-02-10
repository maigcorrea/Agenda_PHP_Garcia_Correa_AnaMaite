<!-- Cambiar título en función de si se le pasa por la url el valor del id del juego a modificar o no -->
<h1><?php if(isset($_GET["id"])){echo "Modificar";}else{echo "Nuevo";}?> Usuario</h1>

<body>
    <form action="" method="POST">
        <!-- Si se le pasa el valor de un id de usuario a modificar por la url, se almacena en un campo oculto, así al enviar el formulario se podrá utilizar el valor en la función de modificarUsuario() -->
        <?php if(isset($_GET["id"])) echo "<input type='hidden' name='idUsu' value='".htmlspecialchars($_GET['id'])."'>"; ?>
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" value="<?php if(isset($datos[0])) echo $datos[0] ?>" required><br>
        <label for="contr">Contraseña:</label><br>
        <input type="text" name="contr" value="<?php if(isset($datos[1])) echo $datos[1] ?>" required><br>

        <input type="submit" value="<?php if(isset($_GET["id"])){echo "Modificar usuario";}else{echo "Insertar Usuario";}?>" name="action">
    </form>
</body>