<body>
    <!-- Cambiar título en función de si se le pasa por la url el valor del id del juego a modificar o no -->
    <h1>Insertar préstamo</h1>

    <form action="" method="post">
        <label for="amigos">Amigos</label><br>
        <select name="amigos">
        <option value="" selected disabled>Selecciona un nombre</option>
            <?php
                if(isset($datosAmigo)){
                    foreach ($datosAmigo as $key => $value) {
                        echo "<option value='$key'>$value[0]</option>";
                    }
                }
            ?>
        </select><br>
        <label for="juegos">Juegos</label><br>
        <select name="juegos">
        <option value="" selected disabled>Selecciona un juego</option>
            <?php
                if(isset($datosJuegos)){
                    foreach ($datosJuegos as $key => $value) {
                        echo "<option value='$key'>$value[1]</option>";
                    }
                }
            ?>
        </select><br>
        <label for="dia">Dia</label><br>
        <input type="date" name="dia"><br>

        <input type="submit" value="Insertar" name="action">
    </form>
</body>