<!-- Cambiar título en función de si se le pasa por la url el valor del id del juego a modificar o no -->
<h1><?php if(isset($_GET["id"])){echo "Modificar";}else{echo "Nuevo";}?> Juego</h1>

<form action="../Controlador/index_usuarios.php" method="POST" enctype="multipart/form-data">
    <!-- Si se le pasa el valor de un id de juego a modificar por la url, se almacena en un campo oculto, así al enviar el formulario se podrá utilizar el valor en la función de modificarJuego() -->
    <?php if(isset($_GET["id"])) echo "<input type='hidden' name='idJuego' value='".htmlspecialchars($_GET['id'])."'>";?>
   
    <!-- Establecer los datos del array para rellenar los campos automáticamente-->
    <!-- Utilizo htmlspecialchars como una medida de seguridad para evitar ataques de inyección de código, convierte los caracteres especiales de HTML en su representación segura -->
    <label for="tit">Titulo</label><br>
    <input type="text" name="tit" value="<?php if(isset($datos[0])) echo $datos[0] ?> " required><br>
    <label for="plat">Plataforma</label><br>
    <input type="text" name="plat" value="<?php if(isset($datos[1])) echo $datos[1] ?>" required><br>
    <label for="lanz">Año de lanzamiento</label><br>
    <input type="number" name="lanz" value="<?php if(isset($datos[2])) echo $datos[2] ?>" min="1952" max=<?php echo date("Y",time())?> required><br>
    <label for="img">Imagen:</label><br>
    <input type="file" name="img"><br>


    <!-- Cambiar botón en función de si se le pasa por la url el valor del id del juego a modificar o no -->
    <input type="submit"  value="<?php if(isset($_GET["id"])){echo "Modificar juego";}else{echo "Añadir juego";}?>" name="action">

</form>
<?php

?>