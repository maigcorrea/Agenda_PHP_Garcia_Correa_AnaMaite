<body>
<h1>Buscar Contacto</h1>

    <form action="" method="post">
        <label for="busqueda">Nombre / Apellidos del amigo</label><br>
        <input type="search" name="busqueda" id=""><br>
        <!-- Mediante un campo oculto indico de qué es la busqueda para saber dentro de una función en el controlador a qué clase y método llamar -->
        <input type="hidden" name="tipoBusq" value="amigos">

        <input type="submit" value="Buscar" name="action">
    </form>

<?php
    if (isset($_POST['busqueda'])) {
        if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
            echo "<table><tr><th>Nombre</th><th>Apellidos</th><th>Nacimineto</th><th>Dueño</th></tr>";
            
            foreach ($resultadosBusqueda as $key => $value) {
                echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td><td><a href='../Controlador/index_usuarios.php?action=Insertar amigos&id=".urldecode($key)."'>Modificar</a></td></tr>";
            }

            echo "</table>";
        }else if(empty($resultadosBusqueda)){
            echo "<p>No hay resultados compatibles con tu búsqueda</p>";
        }
    }

    
?>
</body>