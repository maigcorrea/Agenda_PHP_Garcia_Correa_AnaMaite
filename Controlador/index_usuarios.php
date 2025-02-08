<?php

    function comprobarFechas($fecha){
        $segundosActuales=time();

        $segundosFecha=strtotime($fecha);

        $fechaCorrecta=false;
        if($segundosFecha <= $segundosActuales){
            $fechaCorrecta = true;
        }

        return $fechaCorrecta;
    }

    function comprobarFechasPasadas($fecha){
        $segundosActuales=time();
        $segTresDias=86400*3;

        $segundosLimitePasado=$segundosActuales-$segTresDias;
        $segundosLimiteFuturo=$segundosActuales+$segTresDias;

        $fechaCorrecta=false;
        if(strtotime($fecha) >= $segundosLimitePasado && strtotime($fecha) <= $segundosLimiteFuturo){
            $fechaCorrecta = true;
        }

        return $fechaCorrecta;
    }

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
                    set_session("usu",$_POST["nom"],"id",$id,"tipo",$tipo); 

                    //Se guarda el nombre del usuario, que está en la sesión
                    $nUsu=$_SESSION["usu"]; //NO ME SIRVE DE NADA PORQUE TENDRÍA QUE PASARSELO COMO UN PARÁMETRO A LA FUNCIÓN irVistaAmigos() Y AL ESTAR CONECTADO CON EL ACTION NO LE PUEDO PASAR NINGÚN PARÁMETRO AHÍ, ASI QUE TENGO QUE USAR LA SESIÓN DIRECTAMENTE

                    //Se redirige al dashboard en función del tipo de usuario
                    if($_SESSION["tipo"]=="usuario"){
                        //Mostrar amigos antes de redirigir
                        $tipo="usuario";
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $datosAmigo=$amigo->get_Amigos($_SESSION["id"]);


                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/menu_amigos.php");
                        require_once("../Vista/pie.html");
                        // irVistaAmigos(); 
                    }else{
                        //Redirigir a la vista de admin 
                        $tipo="admin";
                        //Sacar los amigos de todos los usuarios y quién insertó cada amigo
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $datosAmigo=$amigo->get_AllAmigos();


                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/menu_amigos.php");
                        require_once("../Vista/pie.html");

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
    function irVistaAmigos($toast=null){
        //Mostrar amigos antes de redirigir
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Como esta vista también puede ser la de contactos del admin, hay que comprobar el tipo
        if($_SESSION["tipo"]=="admin"){
            //Se muestra la vista de contactos
            $tipo="admin";
            require_once("../Modelo/class_amigo.php");
            $amigo=new Amigo();
            $datosAmigo=$amigo->get_AllAmigos();
    
            require_once("../Vista/cabecera.php");
            require_once("../Vista/menu_amigos.php");
            require_once("../Vista/pie.html");
        }else{
            $tipo="usuario";
            require_once("../Modelo/class_amigo.php");
            $amigo=new Amigo();
            $datosAmigo=$amigo->get_Amigos($_SESSION["id"]);
    
            require_once("../Vista/cabecera.php");
            require_once("../Vista/menu_amigos.php");
            require_once("../Vista/pie.html");
        }
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


    //Función para redirigir a la vista de usuarios
    function vistaBuscarUsuarios(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        if(strcmp($tipo,"admin")==0){
            require_once("../Vista/cabecera.php");
            require_once("../Vista/buscador_usuarios.php");
            require_once("../Vista/pie.html");
        }else{

        }
    }


    //AMIGOS
    function vistaInsertAmigos(String $mensaje=null, $idUsu=null){

        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        //Si el tipo es admin, sacar un array con los nombres de los usuarios dueños
        if(strcmp($tipo,"admin")==0){
            require_once("../Modelo/class_user.php");
            $usuario=new Usuario();
            $usuarios=$usuario->get_usuarios();
        }

        //Para rellenar los campos del formulario si es modificar, es decir, si se le pasa por la url el id del amigo
        //Como se comprueba si la fecha es correcta, si no lo es, se tiene que recargar la página, por lo que se le tiene que volver a pasar por parámetro el id del usuario a modificar, para eso, si el PARÁMETRO $idUsu es diferente a null, significa que ha entrado de nuevo en modificar, y en función del id que exista, si del que se ha pasado por la url o el que se ha pasado por parámetro, se asigna a una variable para luego obtener los datos
        //IMPORTANTE, como primero se le pasa por url el dato del id de usuario y luego por parámetro, hay que hacer un request para que lo pille de ambas maneras
        if(isset($_REQUEST["idAmigo"])){

            $id=$_REQUEST["idAmigo"];
        
            
            require_once("../Modelo/class_amigo.php");
            $amigo=new Amigo();
            
            $datos=$amigo->ObtenerAmigoSegunId($id);

            // Para rellenar el campo select del Dueño, se saca el dueño actual
            if(strcmp($tipo,"admin")==0){
                $duenio=$amigo->encontrarDuenio($id);
            }
        }

        require_once("../Vista/cabecera.php");
        require_once("../Vista/insertar_amigos.php");
        require_once("../Vista/pie.html");
    }

    function insertar(){
        //Se necesita start_session para abrir una sesión y poder utilizar el valor de la sesión id como parámetro
        require_once("../Modelo/cookies_sesiones.php");
        start_session();
        $tipo=$_SESSION["tipo"];

        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();

        //Si el tipo es usuario, el usuario al que se le inserta el amigo es a ese usuario identificado, si es admin, se elige al usuario al que se quiere insertar el amigo
        if(strcmp($tipo,"usuario") == 0){
            //Antes de insertar hay que comprobar que la fecha no sea futura
            if(comprobarFechas($_POST["nac"])){
                if($amigo->insertarAmigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_SESSION["id"])){
                    //Si se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
                    $toast=true;
                    irVistaAmigos($toast);
                }else{
                    //Si no se ha insertado correctamente mostrar un mensaje
                    $mensaje="Error. No se ha podido realizar la inserción";
                    vistaInsertAmigos($mensaje);
                }
            }else{
                //Mensaje de que la fecha es incorrecta al ser futura
                //NO SE MUESTRA EL MENSAJE
                $mensaje="La fecha es incorrecta";
                vistaInsertAmigos($mensaje);
            }
        }else{
            //Antes de insertar hay que comprobar que la fecha no sea futura
            if(comprobarFechas($_POST["nac"])){
                if($amigo->insertarAmigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_POST["duenio"])){
                    //Si se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
                    //Falta mostrar el mensaje
                    irVistaAmigos();
                }else{
                    //Si no se ha insertado correctamente mostrar un mensaje
                    $mensaje="Error. No se ha podido realizar la inserción";
                    vistaInsertAmigos($mensaje);
                }
            }else{
                //Mensaje de que la fecha es incorrecta al ser futura
                //NO SE MUESTRA EL MENSAJE
                $mensaje="La fecha es incorrecta";
                vistaInsertAmigos($mensaje);
            }
        }
        
    }


    function modificarAmigo(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();
        $tipo=$_SESSION["tipo"];

        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();

        //Si el tipo es usuario se modifica sin indicarle el dueño, si es admin hay que indicarle el dueño
        if(strcmp($tipo,"usuario")==0){
            //Antes de modificar hay que comprobar que las fechas no sean futuras
            if(comprobarFechas($_POST["nac"])){
                $modificado=$amigo->modificar_amigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_POST["idAmigo"]);
                if($modificado){
                    //Redirigir al menu de amigos y mostrar toast de Exito
                    irVistaAmigos();
                }else{
                    //Mostrar mensaje de error
                }
            }else{
                $mensaje="La fecha no puede ser futura";
                //Hay que indicar el id del usuario a modificar, porque se pierde?
                vistaInsertAmigos($mensaje, $_POST["idAmigo"]);
            }
        }else{
            //Antes de modificar hay que comprobar que las fechas no sean futuras
            if(comprobarFechas($_POST["nac"])){
                $modificado=$amigo->modificarAmigoAdmin($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_POST["duenio"],$_POST["idAmigo"]);
                if($modificado){
                    //Redirigir al menu de amigos y mostrar toast de Exito
                    irVistaAmigos();
                }else{
                    //Mostrar mensaje de error
                    echo "Error";
                }
            }else{
                $mensaje="La fecha no puede ser futura";
                vistaInsertAmigos($mensaje, $_POST["idAmigo"]);
            }
        }
    }


    function vistaBuscarAmigos(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        //Si el tipo de usuario es usuario, se redirige al buscador de amigos, si es admin, se redirige al buscador de amigos del administrador
        if(strcmp($tipo,"usuario")==0){
            require_once("../Vista/cabecera.php");
            require_once("../Vista/buscador_amigos.php");
            require_once("../Vista/pie.html");
        }else{
            require_once("../Vista/cabecera.php");
            require_once("../Vista/buscador_contactos.php");
            require_once("../Vista/pie.html");
        }
    }



    function buscar(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        //Formatear el valor de búsqueda
        $busqueda=ucfirst(trim($_POST["busqueda"]));


        
        

        //Si el campo no se ha enviado vacío, se muestran los resultados
        if(!empty($busqueda)){
            //En función del valor de un campo oculto, se sabe que datos estamos buscando, si de amigos, juegos o préstamos
            // if($_POST["tipoBusq"]=="amigos"){
            //     require_once("../Modelo/class_amigo.php");
            //     $amigo=new Amigo();
            //     $resultadosBusqueda=$amigo->buscarAmigo($busqueda);
            // }else if($_POST["juegos"]){
            //     require_once("../Modelo/class_juego.php");
            //     $juego=new Juego();
            // }
            if($tipo==="usuario"){
                
                switch ($_POST["tipoBusq"]) {
                    case 'amigos':
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $resultadosBusqueda=$amigo->buscarAmigo($_SESSION["id"],$busqueda);
                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/buscador_amigos.php");
                        require_once("../Vista/pie.html");
                        break;
                    
                    case 'juegos':
                        require_once("../Modelo/class_juego.php");
                        $juego=new Juego();
                        $resultadosBusqueda=$juego->buscarJuego($busqueda);
                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/buscador_juegos.php");
                        require_once("../Vista/pie.html");
                        break;
                    
                    case 'prestamos':
                        require_once("../Modelo/class_prestamo.php");
                        $prestamo=new Prestamo();
                        $resultadosBusqueda=$prestamo->buscarPrestamo($busqueda);
                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/buscador_prestamos.php");
                        require_once("../Vista/pie.html");
                        break;
                }

            }else if($tipo==="admin"){
                switch ($_POST["tipoBusq"]) {
                    case 'amigos':
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $resultadosBusqueda=$amigo->buscarContacto($busqueda);
                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/buscador_contactos.php");
                        require_once("../Vista/pie.html");
                        break;

                    case 'usuarios':
                        require_once("../Modelo/class_user.php");
                        $usuario=new Usuario();
                        $resultadosBusqueda=$usuario->buscarUsuario($busqueda);
                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/buscador_usuarios.php");
                        require_once("../Vista/pie.html");
                        break;
                }
            }
            
        }else{
            $msj="El campo está vacío, rellenalo para buscar";
            //Aqui se redirigiria a la vista en función del campo oculto también
            // require_once("../Vista/cabecera.php");
            // require_once("../Vista/buscador_amigos.php");
            // require_once("../Vista/pie.html");
        }


        
    }


    //JUEGOS
    function juegos(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        require_once("../Modelo/class_juego.php");
        $juego=new Juego();
        $datosJuegos=$juego->get_juegos($_SESSION["id"]);

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        require_once("../Vista/cabecera.php");
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
        //En caso de que se haya modificado la imagen, se sube la nueva img y se borra la antigua, al contrario, se deja la misma imagen que había
        if(!empty($_FILES["img"]['tmp_name'])){
            //Guardar imagen en la carpeta para que luego se pueda subir esa ruta a la bd a la hora de modificar
            $destino=guardarImg();

            require_once("../Modelo/class_juego.php");
            $juego=new Juego();

            //Coger la ruta de la img actual del juego para luego eliminarla
            $rutaImgActual=$juego->obtenerImgActual($_POST["idJuego"]);

            //Actualizar con los nuevos datos
            $modificado=$juego->modificar_juego($_POST["tit"],$_POST["plat"],$_POST["lanz"],$destino,$_POST["idJuego"]);
            
            //Borrar la img anterior de la carpeta
            unlink($rutaImgActual);
            
            if($modificado){
                //Redirigir al menu de juegos y mostrar toast de Exito
                juegos();
                exit;
            }else{
                //Redirigir al menu de juegos
                juegos();
            }
        }else{
            require_once("../Modelo/class_juego.php");
            $juego=new Juego();

            $rutaImgActual=$juego->obtenerImgActual($_POST["idJuego"]);
            $modificado=$juego->modificar_juego($_POST["tit"],$_POST["plat"],$_POST["lanz"],$rutaImgActual,$_POST["idJuego"]);

            if($modificado){
                //Redirigir al menu de juegos y mostrar toast de Exito
                juegos();
                exit;
            }else{
                juegos();
            }

        }
        
    }


    function vistaInsertarJuego(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        if(isset($_GET['id'])){
            require_once("../Modelo/class_juego.php");
            $juego=new Juego();
            
            $datos=$juego->ObtenerJuegoSegunId($_GET["id"]);
        }

        require_once("../Vista/cabecera.php");
        require_once("../Vista/insertar_juego.php");
        require_once("../Vista/pie.html");
    }


    function vistaBuscarJuegos(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        if(strcmp($tipo,"usuario")==0){
            require_once("../Vista/cabecera.php");
            require_once("../Vista/buscador_juegos.php");
            require_once("../Vista/pie.html");
        }else{

        }
    }



    //PRÉSTAMOS

    function vistaPrestamos(){
        //Antes de redirigir a la vista hay que mostrar los préstamos
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        require_once("../Modelo/class_prestamo.php");
        $prestamo=new Prestamo();

        $datosPrestamo=$prestamo->get_prestamos($_SESSION["id"]);

        require_once("../Vista/cabecera.php");
        require_once("../Vista/prestamos.php");
        require_once("../Vista/pie.html");
    }


    function verInsertarPrestamo(String $mensaje=null){
        //Cargar los datos antes de redirigir a la vista
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        //AMIGOS
        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();
        $datosAmigo=$amigo->get_Amigos($_SESSION["id"]);

        //JUEGOS
        require_once("../Modelo/class_juego.php");
        $juego=new Juego();
        $datosJuegos=$juego->get_juegosDisp($_SESSION["id"]);



        require_once("../Vista/cabecera.php");
        require_once("../Vista/insertar_prestamo.php");
        require_once("../Vista/pie.html");
    }


    function insertarPrestamo(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        require_once("../Modelo/class_prestamo.php");
        $prestamo=new Prestamo();

        //Antes de insertar el préstamo hay que comprobar que la fecha no sea PASADA
        // if(comprobarFechasPasadas($_POST["dia"])){
            $insertado=$prestamo->insertar_prestamo($_SESSION["id"],$_POST["amigos"],$_POST["juegos"],$_POST["dia"]);

            if($insertado){
                //Redirigir a la página de préstamos y mostrar toast de Exito
                vistaPrestamos();
            }else{
                //Mensaje de error en la misma página o en la de préstamos? Preguntar a Érica a ella que le parece mejor
            }
        // }else{
        //     //CONTROLAR SOLO UNOS DIAS EN PASADO
        //     $mensaje="La fecha no puede ser pasada";
        //     verInsertarPrestamo($mensaje);
        // }
    }


    function devolverPrestamo(){
        require_once("../Modelo/class_prestamo.php");
        $prestamo=new Prestamo();
        $devuelto=$prestamo->devolver($_GET["id"]);
        if($devuelto){
            vistaPrestamos();
            //Mostrar toast de éxito
        }else{
            //Mostrar error
        }
    }


    function vistaBuscarPrestamos(){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        if(strcmp($tipo,"usuario")==0){
            require_once("../Vista/cabecera.php");
            require_once("../Vista/buscador_prestamos.php");
            require_once("../Vista/pie.html");
        }else{

        }
    }



    //ADMINISTRADOR

    //Función para ir a la vista de usuarios desde el panel de admin
    function irVistaUsuarios(){
        //Cargar los datos antes de redirigir a la vista
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        require_once("../Modelo/class_user.php");
        $usuario=new Usuario();
        $datos=$usuario->get_usuarios();

        require_once("../Vista/cabecera.php");
        require_once("../Vista/usuarios.php");
        require_once("../Vista/pie.html");
    }


    //Función para redirigir a la vista de insertar usuarios
    function insertarUsuarios(String $mensaje=null){

        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];

        //Sacar los datos para autorrellenar los campos si se le pasa por url el id del usuaruio a modificar
        if(isset($_GET["id"])){
            require_once("../Modelo/class_user.php");
            $usuario=new Usuario();
            $datos=$usuario->datosUsuarioModificar($_GET["id"]);
        }


        require_once("../Vista/cabecera.php");
        require_once("../Vista/insertar_usuarios.php");
        require_once("../Vista/pie.html");

    }


    //Función para insertar a un nuevo usuario
    function insertarUsuario(){
        //AQUI2
        require_once("../Modelo/class_user.php");
        $usuario=new Usuario();
       
            $insertado=$usuario->insertar_usuario($_POST["nombre"],$_POST["contr"]);
            if($insertado){
                //Toast de éxito y redirigir al menu de usuarios
                irVistaUsuarios();
            }else{
                //Mensaje de Error
                echo "Error";
            }
    }


    //Función para modificar usuario
    function modificarUsuario(){
        require_once("../Modelo/class_user.php");
        $usuario=new Usuario();

            $modificado=$usuario->modificar_usuario($_POST["nombre"], $_POST["contr"], $_POST["idUsu"]);
            if($modificado){
                //Éxito y redirigir a la vista
                irVistaUsuarios();
            }else{
                //Mensaje de Error
                echo "Error";
            }
    }



    if(isset($_REQUEST["action"])){
        $action=strtolower($_REQUEST["action"]);
        //Para juntar los strings si el valor del action tiene un espacio entre medio
        $action = str_replace(' ', '', $action);

        //Estos if sirven para que en función del value del input submit, se llame a la función correspondiente si esta tiene otro nombre diferente
        if($action=="insertaramigos") $action="vistaInsertAmigos";
        
        if($action=="insertarjuego") $action="vistaInsertarJuego";
        if($action=="añadirjuego") $action="insertarJuego";
        if($action=="modificaramigo") $action="modificarAmigo";
        if($action=="modificarjuego") $action="modificarJuego";
        if($action=="insertarprestamo") $action="verInsertarPrestamo";
        if($action=="insertar") $action="insertarPrestamo";
        if($action=="enviar") $action="insertar";
        if($action=="buscarprestamos") $action="vistaBuscarPrestamos";
        if($action=="buscarjuegos") $action="vistaBuscarJuegos";
        if($action=="buscaramigos") $action="vistaBuscarAmigos";
        if($action=="buscarusuarios") $action="vistaBuscarUsuarios";
        

        $action();
    }else{
        //Se comprueba si existe ya una sesión
        require_once("../Modelo/cookies_sesiones.php");
        if(is_session("usu")){
            //Si la sesión ya está abierta, se guarda el nombre del usuario, que está en la sesión
            irVistaAmigos();
        }else{
            //Si no hay sesión, se redirige al login
            iniSesion();
        }


    }
?>