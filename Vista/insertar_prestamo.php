<body class="menuAmigos">
    <h1 class="text-center">Insertar préstamo</h1>

<div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-25">
        <form action="" method="post">
            <label for="amigos">Amigos</label><br>
            <select class="mb-2" name="amigos" required>
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
            <select class="mb-2" name="juegos" required>
            <option value="" selected disabled>Selecciona un juego</option>
                <?php
                    if(isset($datosJuegos)){
                        foreach ($datosJuegos as $key => $value) {
                            echo "<option value='$key'>$value[0] - $value[1]</option>";
                        }
                    }
                ?>
            </select><br>
            <label for="dia">Dia</label><br>
            <input type="date" class="mb-5" name="dia" min="<?php echo date("Y-m-d",time()-86400*3) ?>" max="<?php echo date("Y-m-d",time()+86400*3) ?>" required><br>
            <?php
                if(isset($mensaje)) echo "<p>$mensaje</p>";
            ?>

            <input type="submit" value="Insertar" name="action">
        </form>
    </div>
</div>
</body>