<body class="menuAmigos">
<h1 class="text-center">Buscar Usuario</h1>

<div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-50">
<form action="" method="post">
    <label for="busqueda">Nombre del usuario</label><br>
    <input type="search" name="busqueda" id=""><br>
    <!-- Mediante un campo oculto indico de qué es la busqueda para saber dentro de una función en el controlador a qué clase y método llamar -->
    <input type="hidden" name="tipoBusq" value="usuarios">

    <input type="submit" value="Buscar" name="action" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
</form>

<?php
if (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
    if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Contraseña</th></tr>";
        
        foreach ($resultadosBusqueda as $key => $value) {
            //Pasar la contraseña a asteriscos
            $long=strlen($value[1]);
            $ast=str_repeat("*",$long);
            //Me falta meter lo de modificar, que también hay que hacerlo
            echo "<tr><td>$key</td><td>$value[0]</td><td>$ast</td><td><a href='../Controlador/index_usuarios.php?action=Insertar usuarios&id=".urldecode($key)."'>Modificar</a></td></tr>";
        }

        echo "</table>";
    }else if(empty($resultadosBusqueda)){
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