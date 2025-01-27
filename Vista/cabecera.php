<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img{
            width: 150px;
        }
    </style>
</head>
<header>
    <a href="<?php if($tipo=="usuario"){ echo '../Controlador/index_usuarios.php?action=irVistaAmigos';} else{echo '../Controlador/index_usuarios.php?action=irVistaContactos';} ?>"><?php if($tipo=="usuario"){ echo 'Amigos';} else{ echo 'Contactos';} ?></a>
    <a href="../Controlador/index_usuarios.php?action=juegos">Juegos</a>
    <a href="../Controlador/index_usuarios.php?action=vistaPrestamos">Prestamos</a>
    <a href="../Controlador/index_usuarios.php?action=salir">Salir</a>
</header>