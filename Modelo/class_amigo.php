<?php
    require_once("class_bd.php");

    class Amigo{
        private $conn;
        private $id;
        private $nombre;
        private $apellidos;
        private $f_nac;
        private $usuario;


        public function __construct(){
            $this->conn = new bd();
            $this->id = "";
            $this->nombre = "";
            $this->apellidos = "";
            $this->f_nac = "";
            $this->usuario = "";
        }


        public function get_Amigos($nomUsuario){
            $sentencia="SELECT amigo.id,amigo.nombre,amigo.apellidos,amigo.f_nac FROM amigo,usuario WHERE amigo.usuario=usuario.id AND usuario.nombre=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("s",$nomUsuario);
            $consulta->bind_result($idAmigo,$nombre,$apellidos,$f_nac);

            $consulta->execute();

            $datosAmigos=[];

            while($consulta->fetch()){
                $datosAmigos[$idAmigo]=[$nombre,$apellidos,$f_nac];
            }

            $consulta->close();
            return $datosAmigos;
        }


        public function insertarAmigo($nom,$ape,$f_nac,$usuario){
            $sentencia="INSERT INTO amigo (nombre, apellidos, f_nac, usuario) VALUES(?,?,?,?);";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("sssi",$nom,$ape,$f_nac,$usuario);
            
            $consulta->execute();

            $insertado=false;
            if($consulta->affected_rows==1){
                $insertado=true;
            }

            $consulta->close();
            return $insertado;
        }
    }
?>