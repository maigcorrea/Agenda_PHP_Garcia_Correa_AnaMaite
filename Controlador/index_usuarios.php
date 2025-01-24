<?php

    //USUARIOS
    //Iniciar Sesión
    function iniciar(){
        
            require_once("../Modelo/class_user.php");
            $usuario=new Usuario();
            
            //Si al mandar el form, la casilla de recordar está marcada, y ya existe una cookie anterior, se borra la cookie anterior. Esto se hace por si inicia sesión otra persona, para que no se quede con la cookie del aterior usuario y su cookie nueva se genere.
            if(isset($_POST["rec"])){
                require_once("../Modelo/cookies_sesiones.php");
                unset_cookie("usuario");
            }

            //Comprobar si el usuario está en la bd
            if($usuario->comprobarNombre($_POST["nom"])){
                //Comprobar si la contraseña es correcta
                if($usuario->comprobarContr($_POST["nom"],$_POST["contr"])){
                    //Sacar el tipo de usuario
                    $tipo=$usuario->comprobarTipo($_POST["nom"],$_POST["contr"]);
                    //Sacar el id del usuario
                    $id=$usuario->get_id($_POST["nom"],$_POST["contr"]);
                    
                    //Si ha marcado la casilla de "Recordar" se generan la cookie con el nombre del usuario
                    if(isset($_POST["rec"])){
                        require_once("../Modelo/cookies_sesiones.php"); //Está bien poner el require_once 2 veces?
                        set_cookie("usuario",$_POST["nom"]);
                    }

                    //Se abren dos sesiones, una guarda el nombre del usuario y otra el id.
                    require_once("../Modelo/cookies_sesiones.php");
                    set_session("usu",$_POST["nom"],"id",$id);

                    //Se guarda el nombre del usuario, que está en la sesión
                    $nUsu=$_SESSION["usu"];

                    //Se redirige al dashboard en función del tipo de usuario
                    if($tipo=="usuario"){
                        //Mostrar amigos antes de redirigir
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $datosAmigo=$amigo->get_Amigos($nUsu);


                        require_once("../Vista/cabecera.html");
                        require_once("../Vista/menu_amigos.php");
                        require_once("../Vista/pie.html");
                        // irVistaAmigos(); POR QUÉ SI LA FUNCIÓN TIENE LO MISMO, NO FUNCIONA??
                    }
                }else{
                    //Si la contraseña no es correcta mostrar mensaje
                    $mensaje="<p>La contraseña no es correcta</p>";
                    iniSesion();
                }
            }else{
                //Mensaje de que el usuario no está en la bd
                $mensaje="<p>El usuario no se encuentra registrado</p>";
                iniSesion();
            }

            

    }

    //Función para redirigir a la vista de amigos
    function irVistaAmigos(){
        require_once("../Vista/cabecera.html");
        require_once("../Vista/menu_amigos.php");
        require_once("../Vista/pie.html");
    }

    //Función para redirigir al login 
    function iniSesion(){
        // require_once("../Vista/cabecera.html");
        require_once("../Vista/login.php");
        require_once("../Vista/pie.html");
    }


    function salir(){
        require_once("../Modelo/cookies_sesiones.php");
        unset_session();

        iniSesion();
    }


    //AMIGOS
    function vistaInsertAmigos(){
        require_once("../Vista/cabecera.html");
        require_once("../Vista/insertar_amigos.php");
        require_once("../Vista/pie.html");
    }

    function insertar(){
        //Se necesita start_session para abrir una sesión y poder utilizar el valor de la sesión id como parámetro
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();
        if($amigo->insertarAmigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_SESSION["id"])){
            //Si se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
            //Falta mostrar el mensaje
            iniSesion();
        }else{
            //Si no se ha insertado correctamente mostrar un mensaje
            $mensaje="Error. No se ha podido realizar la inserción";
            vistaInsertAmigos();
        }
    }


    //JUEGOS
    function juegos(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        require_once("../Modelo/class_juego.php");
        $juego=new Juego();
        $datosJuegos=$juego->get_juegos($_SESSION["id"]);

        require_once("../Vista/cabecera.html");
        require_once("../Vista/juegos.php");
        require_once("../Vista/pie.html");
    }


    function insertarJuego(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();
        require_once("../Modelo/class_juego.php");
        $juego=new Juego();
        $insertado=$juego->insertar_Juego($_POST["tit"],$_POST["plat"],$_POST["lanz"],"url de imagen",$_SESSION["id"]); //Aquí van los datos del formulario

        //Si se inserta, redireccionar a la vista de juegos
        if($insertado){
            echo "Insertado";
            //Vista de juegos y mensaje de que se ha insertado correctamente
            //Crear carpeta con el nombre del usuario y meter la imagen, luego coger esa ruta para meterla en la bd
        }else{
            echo "Mal";
            //Misma vista y mensaje de error
        }
    }


    function vistaInsertarJuego(){
        require_once("../Vista/cabecera.html");
        require_once("../Vista/insertar_juego.php");
        require_once("../Vista/pie.html");
    }


    if(isset($_REQUEST["action"])){
        $action=strtolower($_REQUEST["action"]);

        //Estos if sirven para que en función del value del input submit, se llame a la función correspondiente si esta tiene otro nombre diferente
        if($action=="insertar amigos") $action="vistaInsertAmigos";
        if($action=="enviar") $action="insertar";
        if($action=="insertar juego") $action="vistaInsertarJuego";
        if($action=="añadir juego") $action="insertarJuego";

        $action();
    }else{
        //Se comprueba si existe ya una sesión
        require_once("../Modelo/cookies_sesiones.php");
        if(is_session("usu")){
            //Si la sesión ya está abierta, se guarda el nombre del usuario, que está en la sesión
            $nUsu=get_session("usu");

            //Se redirige al menú de amigos
            require_once("../Vista/cabecera.html");
            require_once("../Vista/menu_amigos.php");
            require_once("../Vista/pie.html");
        }else{
            //Si no hay sesión, se redirige al login
            iniSesion();
        }


    }
?>