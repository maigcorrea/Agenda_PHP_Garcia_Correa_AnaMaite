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
?>