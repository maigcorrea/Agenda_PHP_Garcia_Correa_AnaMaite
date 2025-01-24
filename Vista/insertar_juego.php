<form action="../Controlador/index_usuarios.php" method="post">
    <label for="tit">Titulo</label><br>
    <input type="text" name="tit"><br>
    <label for="plat">Plataforma</label><br>
    <input type="text" name="plat"><br>
    <label for="lanz">Año de lanzamiento</label><br>
    <input type="number" name="lanz"><br>
    <label for="img">Imagen:</label><br>
    <input type="file" name="img"><br>

    <input type="submit" value="Insertar juego" name="action">

</form>
<?php

?>