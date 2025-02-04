<body>
    <h1>Buscar Juego</h1>

    <form action="" method="post">
        <label for="busqueda">Titulo del juego / Plataforma</label><br>
        <input type="search" name="busqueda" id=""><br>
        <input type="hidden" name="tipoBusq" value="juegos">

        <input type="submit" value="Buscar" name="action">
    </form>

    <?php
        if(isset($resultadosBusqueda)){
            echo "<table><tr><th>Juego</th><th>Título</th><th>Plataforma</th><th>Año de lanzamiento</th></tr>";
            
            foreach ($resultadosBusqueda as $key => $value) {
                echo "<tr><td><img src='".$value[0]."'/></td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td></tr>";
            }

            echo "</table>";
        }

        if(isset($msj)){
            echo $msj;
        }
    ?>
</body>