<!-- Cambiar título en función de si se le pasa por la url el valor del id del juego a modificar o no -->
<h1><?php if(isset($_GET["id"])){echo "Modificar";}else{echo "Nuevo";}?> Usuario</h1>

<body>
    <form action="" method="POST">
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre"><br>
        <label for="contr">Contraseña:</label><br>
        <input type="text" name="contr" id=""><br>

        <input type="submit" value="Insertar usuario" name="action">
    </form>
</body>