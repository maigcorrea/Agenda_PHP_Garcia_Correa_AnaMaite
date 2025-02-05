<body>
    <h1>Buscar Amigo</h1>

    <form action="" method="post">
        <label for="busqueda">Nombre / Apellidos del amigo</label><br>
        <input type="search" name="busqueda" id=""><br>
        <!-- Mediante un campo oculto indico de qué es la busqueda para saber dentro de una función en el controlador a qué clase y método llamar -->
        <input type="hidden" name="tipoBusq" value="amigos">

        <input type="submit" value="Buscar" name="action">
    </form>

    <?php
        if(isset($resultadosBusqueda)&& !empty($resultadosBusqueda)){
            echo "<table><tr><th>Nombre</th><th>Apellidos</th><th>Nacimineto</th></tr>";
            
            foreach ($resultadosBusqueda as $key => $value) {
                echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td></tr>";
            }

            echo "</table>";
        }else{
            echo "No hay resultados compatibles con tu búsqueda";
        }

        if(isset($msj)){
            echo $msj;
        }
    ?>
</body>