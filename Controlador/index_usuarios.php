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
                    
                    //Si ha marcado la casilla de "Recordar" se genera la cookie
                    if(isset($_POST["rec"])){
                        require_once("../Modelo/cookies_sesiones.php"); //Está bien poner el require_once 2 veces?
                        set_cookie("usuario",$_POST["nom"]);
                    }

                    //Se abre una sesión. PREGUNTA: Se tendría que iniciar una sesión por cada tipo de  usuario? No, no?
                    require_once("../Modelo/cookies_sesiones.php");
                    set_session("usu",$_POST["nom"]);

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
                    }
                }else{
                    //Si la contraseña no es correcta mostrar mensaje
                    $mensaje="<p>La contraseña no es correcta</p>";

                    require_once("../Vista/cabecera.html");
                    require_once("../Vista/login.php");
                    require_once("../Vista/pie.html");
                }
            }else{
                //Mensaje de que el usuario no está en la bd
                $mensaje="<p>El usuario no se encuentra registrado</p>";
                require_once("../Vista/cabecera.html");
                require_once("../Vista/login.php");
                require_once("../Vista/pie.html");
            }

            

    }

    //Función para redirigir al login 
    function iniSesion(){
        require_once("../Vista/cabecera.html");
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

    // function insertar(){
    //     require_once("../Modelo/class_amigo.php");
    //     $amigo=new Amigo();
    //     if($amigo->insertarAmigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],Aqui iria el id o nombre del usuario)){
    //         //Si se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
    //         echo "Bien";
    //     }else{
    //         //Si no se ha insertado correctamente mostrar un mensaje
    //         echo "Mal";
    //     }
    // }



    if(isset($_REQUEST["action"])){
        $action=$_REQUEST["action"];

        if($action=="Insertar amigos") $action="vistaInsertAmigos";

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