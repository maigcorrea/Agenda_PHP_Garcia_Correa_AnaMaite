<body>
    <h1>Buscar Prestamo</h1>

    <form action="" method="post">
        <label for="busqueda">Nombre del amigo / Titulo del juego</label><br>
        <input type="search" name="busqueda" id=""><br>
        <input type="hidden" name="tipoBusq" value="prestamos">

        <input type="submit" value="Buscar" name="action">
    </form>

    <?php
        if(isset($resultadosBusqueda)){
            echo "<table><tr><th>Usuario</th><th>Amigo</th><th>Juego</th><th>Fecha</th><th>Devuelto</th></tr>";
            
            foreach ($resultadosBusqueda as $key => $value) {
                //MODIFICA ESTO
                echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td></tr>";
            }

            echo "</table>";
        }

        if(isset($msj)){
            echo $msj;
        }
    ?>
</body>