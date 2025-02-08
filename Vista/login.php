<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
     <!-- <link rel="stylesheet" href="./style.css"> -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility,visibility_off" />
</head>
<body class="bg-gray-500">
    <div class="flex justify-center items-center min-h-[90vh] font-mono">
        <div class="container w-full min-h-[90vh] flex justify-center items-center text-[45px] flex-wrap">
            <h1 class="w-full text-[75px] mb-[90px] border-b-2 border-green-700">AGENDA</h1>
            <form action="../Controlador/index_usuarios.php" method="post" class="w-full leading-[80px]">
                <label for="nom" class="w-full">Introduce tu nombre:</label><br>
                <input type="text" class="border-b-2 focus:outline-hidden w-full h-[60px] hover:bg-green-700 hover:text-white pb-4" placeholder=">" name="nom" value=<?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"]; ?>><br>
        
                <label for="contr" class="w-full">Introduce tu contraseña:</label><br>
                <div class="password-field relative w-fit w-full ">
                    <input type="text" name="contr" class="border-b-2 w-full h-[60px] focus:outline-hidden hover:bg-green-700 hover:text-white pb-4" placeholder=">"><br>
                    <i class="material-symbols-outlined eye absolute right-[10px] bottom-[0px] cursor-pointer w-fit h-fit z-10 pb-4"></i>
                </div>
        
                <input type="checkbox" name="rec" value=1 class=""> Recordar<br>
        
                <input type="submit" class="border-2 cursor-pointer w-fit capitalize hover:bg-green-700 hover:text-white px-3" value="iniciar" name="action">
            </form>
        </div>
    </div>
    <?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"]; ?>
    <?php
        if(isset($mensaje)) echo $mensaje;
    ?>  

    <script src="../Vista/style.js"></script>
</body>
