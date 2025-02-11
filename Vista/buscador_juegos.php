<body class="menuAmigos">
    <h1 class="text-center">Buscar Juego</h1>

<div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-50">
        <form action="" method="post">
            <label for="busqueda">Titulo del juego / Plataforma</label><br>
            <input type="search" name="busqueda" id=""><br>
            <input type="hidden" name="tipoBusq" value="juegos">

            <input type="submit" value="Buscar" name="action" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
        </form>

        <?php
        if (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
            if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
                echo "<table><tr><th>Juego</th><th>Título</th><th>Plataforma</th><th>Año de lanzamiento</th></tr>";
                
                foreach ($resultadosBusqueda as $key => $value) {
                    echo "<tr><td><img src='".$value[0]."'/></td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td><td><a href='../Controlador/index_usuarios.php?action=insertarjuego&id=".urldecode($key)."'>Modificar</a></tr>";
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