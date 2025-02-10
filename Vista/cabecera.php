<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> -->
     <!-- <link rel="stylesheet" href="./style.css"> -->
    <style>
        body{
            background-color:white;
        }

        img{
            width: 150px;
        }

        table td, th{
            border: solid 1px black;
        }

        table a{
            text-decoration:none;
            color:black;
        }

        table{
            background:rgba(240, 255, 240, 0.8);
        }

        .menuAmigos{
            background-image: url("https://i.pinimg.com/736x/95/6d/09/956d09dc3fd30be91c0984689157ca06.jpg");
            background-size:cover;
        }

        .tableContainer{
            background: rgba( 255, 255, 255, 0.25 );
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 10px );
            -webkit-backdrop-filter: blur( 10px );
            border-radius: 10px;
            border: 1px solid rgba( 255, 255, 255, 0.18 );
        }
    </style>
</head>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-success-subtle">
  <a class="navbar-brand" href=""><img src="../Vista/assets/logo.png" alt=""></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="<?php if(strcmp($tipo,"usuario")==0){ echo '../Controlador/index_usuarios.php?action=irVistaAmigos';} else{echo '../Controlador/index_usuarios.php?action=irVistaAmigos';} ?>"><?php if(strcmp($tipo,"usuario") == 0){ echo 'Amigos';} else{ echo 'Contactos';} ?></a>
      </li>
      <?php if(strcmp($tipo,"usuario")==0) echo '
        <li class="nav-item">
            <a class="nav-link" href="../Controlador/index_usuarios.php?action=juegos">Juegos</a>
        </li>
      '?>
      <li class="nav-item">
        <a class="nav-link" href="<?php if(strcmp($tipo,"usuario")==0){ echo '../Controlador/index_usuarios.php?action=vistaPrestamos';} else{echo '../Controlador/index_usuarios.php?action=irVistaUsuarios';} ?>"><?php if(strcmp($tipo,"usuario") == 0){ echo 'Prestamos';} else{ echo 'Usuarios';} ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../Controlador/index_usuarios.php?action=salir">Salir</a>
      </li>      
    </ul>
  </div>
</nav>
</header>