<body>
    <h1>Buscar Prestamo</h1>

    <form action="" method="post">
        <label for="busqueda">Nombre del amigo / Titulo del juego</label><br>
        <input type="search" name="busqueda" id=""><br>
        <input type="hidden" name="tipoBusq" value="prestamos">

        <input type="submit" value="Buscar" name="action">
    </form>

    <?php
    if (isset($_POST['busqueda'])) {
        if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
            echo "<table><tr><th>Usuario</th><th>Amigo</th><th>Juego</th><th>Fecha</th><th>Devuelto</th></tr>";
            
            foreach ($resultadosBusqueda as $key => $value) {
                $disponible;
                if($value[4]==1){
                    $disponible="SI";
                }else{
                    $disponible="NO";
                }
                
                echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td><td>$disponible</td></tr>";
            }

            echo "</table>";
        }else{
            echo "No hay resultados compatibles con tu búsqueda";
        }
    }

        if(isset($msj)){
            echo $msj;
        }
    ?>
</body>