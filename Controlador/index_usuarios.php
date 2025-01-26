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
                    $nUsu=$_SESSION["usu"]; //NO ME SIRVE DE NADA PORQUE TENDRÍA QUE PASARSELO COMO UN PARÁMETRO A LA FUNCIÓN irVistaAmigos() Y AL ESTAR CONECTADO CON EL ACTION NO LE PUEDO PASAR NINGÚN PARÁMETRO AHÍ, ASI QUE TENGO QUE USAR LA SESIÓN DIRECTAMENTE

                    //Se redirige al dashboard en función del tipo de usuario
                    if($tipo=="usuario"){
                        //Mostrar amigos antes de redirigir
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $datosAmigo=$amigo->get_Amigos($nUsu);


                        require_once("../Vista/cabecera.html");
                        require_once("../Vista/menu_amigos.php");
                        require_once("../Vista/pie.html");
                        // irVistaAmigos(); 
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
        //Mostrar amigos antes de redirigir
        require_once("../Modelo/cookies_sesiones.php");
        start_session();
        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();
        $datosAmigo=$amigo->get_Amigos($_SESSION["usu"]);

        require_once("../Vista/cabecera.html");
        require_once("../Vista/menu_amigos.php");
        require_once("../Vista/pie.html");
    }

    //Función para redirigir al login 
    function iniSesion(){
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

    function modificarAmigo(){
        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();
        $modificado=$amigo->modificar_amigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_POST["idAmigo"]);
        if($modificado){
            //Redirigir al menu de amigos y mostrar toast de Exito
            irVistaAmigos();
        }else{
            //Mostrar mensaje de error
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


    //Función para guardar la foto seleccionada por el usuario en una carpeta en local
    function guardarImg(){
        //PARA LA FOTO, crear carpeta con el nombre del usuario si todavía no existe y meter la imagen, luego coger esa ruta para meterla en la bd
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        
        $ruta="../img/".$_SESSION["usu"]."/";
        if(!file_exists($ruta)){
            mkdir($ruta,0777,true); //El tercer parámetro "true" permite crear directorios recursivamente, es decir, se crea tanto img cómo la carpeta con el nombre del usuario
        }

        $nomOrig=$_FILES["img"]["name"]; //El nombre original de la imagen

        //COMO NO HAY QUE RENOMBRAR EL ARCHIVO, LO COMENTADO NO HACE FALTA, EN CASO DE QUE HUBIERA QUE RENOMBRARLO, SE HARÍA LO SIGUIENTE:
        //Si el nuevo nombre no tiene la extensión, hay que añadirsela para que el archivo se pueda ver correctamente
        // $extension;
        // if(!preg_match("'^[a-zA-Z0-9]+\.[a-z]+$'",$valorInput)){//Si el nuevo nombre no va seguido de . y la extensión, se le añade la extensión del nombre original
        //     //Se concatena el nombre nuevo que se le va a poner a la imagen con la extensión del nombre original

        //     $pos = strrpos($nomOrig, '.'); // Encuentra la posición del último punto dentro del nombre original
        //     $extension=substr($nomOrig,$pos);//substr devuelve una parte del string a partir de una posición, en este caso devuelve una cadena a partir de la posición del . en el nombre original
        //     $valorInput=$valorInput.$extension;//Se concatena el nuevo nombre con la extensión
        // }

        $origen=$_FILES["img"]["tmp_name"];
        $destino=$ruta.$nomOrig; //Se concatena la ruta donde queremos guardar la imagen con el nuevo nombre (En este caso es el nombre original, no uno nuevo)

        //Se mueve la imagen a la carpeta
        move_uploaded_file($origen,$destino);

        return $destino;
    }



    function insertarJuego(){  

        //Guardar la imagen en una carpeta para que luego se pueda subir esa ruta a la bd a la hora de insertar
        $destino=guardarImg();

        require_once("../Modelo/class_juego.php");
        $juego=new Juego();
        $insertado=$juego->insertar_Juego($_POST["tit"],$_POST["plat"],$_POST["lanz"],$destino,$_SESSION["id"]); //Aquí van los datos del formulario

        //Si se inserta, redireccionar a la vista de juegos
        if($insertado){
            echo "Insertado";
            //Vista de juegos y mensaje de que se ha insertado correctamente
            
        }else{
            echo "Mal";
            //Misma vista y mensaje de error
        }
    }



    function modificarJuego(){

        //Guardar imagen en la carpeta para que luego se pueda subir esa ruta a la bd a la hora de modificar
        $destino=guardarImg();

        require_once("../Modelo/class_juego.php");
        $juego=new Juego();

        $modificado=$juego->modificar_juego($_POST["tit"],$_POST["plat"],$_POST["lanz"],$destino,$_POST["idJuego"]);
        if($modificado){
            //Redirigir al menu de juegos y mostrar toast de Exito
            juegos();
        }else{
            //Mostrar mensaje de error
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
        if($action=="modificar amigo") $action="modificarAmigo";
        if($action=="modificar juego") $action="modificarJuego";

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