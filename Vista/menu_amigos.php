<body>
    <h1>MENÚ AMIGOS</h1>
    <p>Bienvenid@ <?php if(isset($nUsu)) echo $nUsu?></p>

    <!-- Cerrar sesión ¿A qué controlador llamo?¿o llamo al modelo donde está la función para cerrar sesión? ¿O me hago otro controlador aparte para gestionar eso?-->
     <form action="">
        <input type="submit" value="Salir" name="cerrar">
     </form>
</body>