<body>
    <form action="../Controlador/index_usuarios.php" method="post">
        <label for="nom">Introduce tu nombre:</label><br>
        <input type="text" name="nom"><br>

        <label for="contr">Introduce tu contraseña</label><br>
        <input type="text" name="contr" value=<?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"]?>><br>

        <input type="checkbox" name="rec">Recordar<br>

        <input type="submit" value="iniciar" name="action">
    </form>
    <?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"]?>
    <?php
        if(isset($mensaje)) echo $mensaje;
    ?>
</body>
