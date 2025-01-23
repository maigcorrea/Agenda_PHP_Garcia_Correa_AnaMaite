<body>
    <form action="../Controlador/index_usuarios.php" method="post">
        <label for="nom">Introduce tu nombre:</label><br>
        <input type="text" name="nom" value=<?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"]; ?>><br>

        <label for="contr">Introduce tu contraseña</label><br>
        <input type="text" name="contr"><br>

        <input type="checkbox" name="rec" value=1>Recordar<br>

        <input type="submit" value="iniciar" name="action">
    </form>
    <?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"]; ?>
    <?php
        if(isset($mensaje)) echo $mensaje;
    ?>
</body>
