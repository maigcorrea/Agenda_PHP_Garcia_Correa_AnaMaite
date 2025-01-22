<?php

    //Generar una cookie
    function set_cookie(String $nom, $val){
        setcookie($nom,$val,time()+(86400*30));
    }


    //Eliminar una cookie
    function unset_cookie(String $nom){
        $comp=false;

        if(isset($_COOKIE[$nom])){
            setcookie($nom,"",time()-(86400*30));
            $comp=true;
        }

        return $comp;
    }


    //Generar una sesión
    function start_session(){
        //Se comprueba si la sesión existe, si no está, se crea
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }


    //Abrir una sesión
    function set_session(String $nom, $val){
        start_session();
        $_SESSION[$nom]=$val;
    }


    //Devolver los datos de una sesión
    function get_session(String $nom){
        start_session();
        return $_SESSION[$nom];
    }


    //Borrar una sesión
    function unset_session(){
        start_session();
        session_unset();
        session_destroy();
    }


    //Comprobar si la sesión existe
    function is_session(String $nom){
        start_session();
        $isset=isset($_SESSION[$nom]);

        return $isset;
    }
?>