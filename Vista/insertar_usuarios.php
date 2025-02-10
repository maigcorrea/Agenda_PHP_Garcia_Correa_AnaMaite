<body class="menuAmigos m-auto">
<!-- Cambiar título en función de si se le pasa por la url el valor del id del juego a modificar o no -->
<h1 class="text-center mt-5"><?php if(isset($_GET["id"])){echo "Modificar";}else{echo "Nuevo";}?> Usuario</h1>

<div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-25">
        <form class="lh-lg" action="" method="POST">
            <!-- Si se le pasa el valor de un id de usuario a modificar por la url, se almacena en un campo oculto, así al enviar el formulario se podrá utilizar el valor en la función de modificarUsuario() -->
            <?php if(isset($_GET["id"])) echo "<input type='hidden' name='idUsu' value='".htmlspecialchars($_GET['id'])."'>"; ?>
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" value="<?php if(isset($datos[0])) echo $datos[0] ?>" required><br>
            <label for="contr">Contraseña:</label><br>
            <input type="text" class="mb-5" name="contr" value="<?php if(isset($datos[1])) echo $datos[1] ?>" required><br>
    
            <input type="submit" value="<?php if(isset($_GET["id"])){echo "Modificar usuario";}else{echo "Insertar Usuario";}?>" name="action">
        </form>
    </div>
</div>
</body>