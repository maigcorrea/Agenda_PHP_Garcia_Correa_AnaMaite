<body>
    <h1>USUARIOS</h1>
    <form action="" method="POST">
        <input type="submit" value="Insertar Usuarios" name="action">
        <input type="submit" value="Buscar usuarios" name="action">
    </form>
    <table>
         <tr><th>ID</th><th>Nombre</th><th>Contraseña</th></tr>
    <?php
    
        if(isset($datos)){
            
            foreach ($datos as $key => $value) {
                //Pasar la contraseña a asteriscos
                $long=strlen($value[1]);
                $ast=str_repeat("*",$long);
                echo "<tr><td>".$key."</td><td>".$value[0]."</td><td>".$ast."</td><td><a href='../Controlador/index_usuarios.php?action=Insertar amigos&id=".urldecode($key)."'>Modificar</a></td></tr>";
            }
        }
    ?>

    </table>
</body>