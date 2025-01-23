<body>
    <h1>Nuevo Amigo</h1>

    <form action="../Controlador/index_usuarios.php" method="POST">
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre"><br>
        <label for="ape">Apellidos</label><br>
        <input type="text" name="ape"><br>
        <label for="nac">Fecha Nacimiento</label><br>
        <input type="date" name="nac"><br>

        <input type="submit" value="Enviar" name="action">
    </form>
    <?php
        if(isset($mensaje)) echo "<p>$mensaje</p>";
    ?>
</body>