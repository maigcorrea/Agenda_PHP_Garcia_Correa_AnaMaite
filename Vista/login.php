<body>
    <form action="../Controlador/index_usuarios.php" method="post">
        <label for="nom">Introduce tu nombre:</label><br>
        <input type="text" name="nom"><br>

        <label for="contr">Introduce tu contraseña</label><br>
        <input type="text" name="contr"><br>

        <input type="checkbox" name="">Recordar

        <input type="submit" value="iniciar" name="action">
    </form>
    <?php
        if(isset($mensaje)) echo $mensaje;
    ?>
</body>
