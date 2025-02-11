<body class="menuAmigos">
    <h1 class="text-center">Buscar Prestamo</h1>

    <div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-50">
    <form action="" method="post">
        <label for="busqueda">Nombre del amigo / Titulo del juego</label><br>
        <input type="search" name="busqueda" id=""><br>
        <input type="hidden" name="tipoBusq" value="prestamos">

        <input type="submit" class="mb-5" value="Buscar" name="action" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
    </form>

    <?php
    if (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
        if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
            echo "<table><tr><th>Usuario</th><th>Amigo</th><th>Juego</th><th>Fecha</th><th>Devuelto</th></tr>";
            
            foreach ($resultadosBusqueda as $key => $value) {
                $disponible;
                if($value[4]==1){
                    $disponible="SI";
                }else{
                    $disponible="NO";
                }
                
                echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td><td>$disponible</td>";
                echo "<td><a href='"."../Controlador/index_usuarios.php?action=devolverPrestamo&id=". $key ."'";
                if($value[4]==1) echo "onclick='return false'";
                echo ">Devolver</a></td></tr>";
            }

            echo "</table>";
        }else{
            echo "<p>No hay resultados compatibles con tu búsqueda</p>";
        }
    }

        if(isset($msj)){
            echo $msj;
        }
    ?>
    </div>
    </div>
</body>