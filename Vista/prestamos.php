
<body>
    <h1>Prestamos</h1>
    <form action="../Controlador/index_usuarios.php" method="post">
        <input type="submit" value="Insertar prestamo" name="action">
        <input type="submit" value="Buscar prestamos" name="action">
    </form>

    <table>
        <tr><th>Amigo</th><th>Juego</th><th> </th><th>Fecha</th><th>Devuelto</th></tr>
        <?php
            if(isset($datosPrestamo)){
                foreach ($datosPrestamo as $key => $value) {
                    //Poner fecha en formato Español
                    $timestamp=strtotime($value[3]);
                    $fecha=date("d-m-Y",$timestamp);
                    echo "<tr><td>$value[0]</td><td>$value[1]</td><td><img src='$value[2]' /></td><td>$fecha</td><td>";
                    if($value[4]==1) {echo "SI</td>";} else {echo "NO</td>";};
            ?>

                <td><a href="../Controlador/index_usuarios.php?action=devolverPrestamo&id=<?php echo $key ?>" <?php if($value[4]==1) echo "onclick='return false'" ?>>Devolver</a></td></tr>

        <?php
                }
            }
        ?>
    </table>
</body>