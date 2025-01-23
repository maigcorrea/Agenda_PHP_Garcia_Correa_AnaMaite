<body>
    <h1>MENÚ AMIGOS</h1>
    <p>Bienvenid@ <?php if(isset($nUsu)) echo $nUsu?></p>

    <?php echo $_COOKIE['usuario']; ?>

    <!-- Cerrar sesión ¿A qué controlador llamo?¿o llamo al modelo donde está la función para cerrar sesión? ¿O me hago otro controlador aparte para gestionar eso?-->
     <form action="../Controlador/index_usuarios.php">
        <input type="submit" value="salir" name="action">
     </form>
</body>