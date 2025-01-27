
<body>
    <h1>Prestamos</h1>
    <form action="../Controlador/index_usuarios.php" method="post">
        <input type="submit" value="Insertar prestamo" name="action">
        <input type="submit" value="Buscar préstamo" name="action">
    </form>

    <table>
        <tr><th>Amigo</th><th>Juego</th><th> </th><th>Fecha</th><th>Devuelto</th></tr>
        <?php
        //RECUERDA QUE TIENES QUE PONER LA FECHA EN FORMATO ESPAÑOL
            if(isset($datosPrestamo)){
                foreach ($datosPrestamo as $key => $value) {
                    echo "<tr><td>$value[0]</td><td>$value[1]</td><td><img src='$value[2]' /></td><td>$value[3]</td><td>";
                    if($value[4]==1) {echo "SI</td>";} else {echo "NO</td>";};
            ?>

                <td><a href="#" <?php if($value[4]==1) echo "onclick='return false'" ?>>Devolver</a></td></tr>

        <?php
                }
            }
        ?>
    </table>
</body>