<body>
<h1>Buscar Usuario</h1>

<form action="" method="post">
    <label for="busqueda">Nombre del usuario</label><br>
    <input type="search" name="busqueda" id=""><br>
    <!-- Mediante un campo oculto indico de qué es la busqueda para saber dentro de una función en el controlador a qué clase y método llamar -->
    <input type="hidden" name="tipoBusq" value="usuarios">

    <input type="submit" value="Buscar" name="action">
</form>

<?php
if (isset($_POST['busqueda'])) {
    if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Contraseña</th></tr>";
        
        foreach ($resultadosBusqueda as $key => $value) {
            //Pasar la contraseña a asteriscos
            $long=strlen($value[2]);
            $ast=str_repeat("*",$long);
            echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$ast</td></tr>";
        }

        echo "</table>";
    }else if(empty($resultadosBusqueda)){
        echo "<p>No hay resultados compatibles con tu búsqueda</p>";
    }
}


?>
</body>