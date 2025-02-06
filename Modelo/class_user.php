<?php
    require_once("class_bd.php");

    class Usuario{
        private $conn;
        private $id;
        private $nombre;
        private $contrasenia;
        private $tipo;

        public function __construct(){
            $this->conn = new bd();
            $this->id="";
            $this->nombre="";
            $this->contrasenia="";
        }

        public function get_id($nom,$contra){
            //Sacar el id del usuario
            $sentencia="SELECT id FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$contra);
            $consulta->bind_result($id);

            $consulta->execute();
            $consulta->fetch();

            $consulta->close();
            return $id;
        }


        public function comprobarTipo($nom,$contra){
            //Comprobar si el usuario es administrador
            $sentencia="SELECT tipo FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$contra);
            $consulta->bind_result($tipo);

            $consulta->execute();
            $consulta->fetch();

            $consulta->close();
            return $tipo;
        }

        // public function comprobarCred(){
        //     $iniciar=false;

        //     //Comprobar que el nombre de usuario es correcto
        //     if($this->comprobarNombre()){
        //         //Si es correcto, se comprueba la contraseña
        //         if($this->comprobarContr()){
        //             $iniciar=true;
        //         }
        //     }

        //     return $iniciar;
            
        // }


        public function comprobarContr($nom,$contra){
            //Comprobar que la contraseña es la correcta
            $sentencia="SELECT count(contrasenia) FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$contra);
            $consulta->bind_result($count);

            $consulta->execute();
            $consulta->fetch();

            $correcto=false;
            
            if($count==1){
                $correcto=true;
            }

            $consulta->close();
            return $correcto;  
        }


        public function comprobarNombre($nom){
            //Comprobar que el usuario está en la bd
            $sentencia="SELECT count(id) FROM usuario WHERE nombre=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("s",$nom);
            $consulta->bind_result($count);
            $consulta->execute();

            $consulta->fetch();
            $existe=false;
            
            if($count==1){
                $existe=true;
            }

            $consulta->close();
            return $existe;           
        }


        public function get_usuarios(){
            $sentencia="SELECT id,nombre,contrasenia FROM usuario WHERE nombre!='admin';";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_result($id,$nombre,$contrasenia);
            $consulta->execute();

            $usuarios=[];
            while($consulta->fetch()){
                $usuarios[$id]=[$nombre,$contrasenia];
            }

            $consulta->close();
            return $usuarios;
        }

        public function insertar_usuario($nom, $contr){
            //ANTES HABRÍA QUE COMPROBAR QUE LA CONTRASEÑA ES SEGURA CON UNOS PREG_MATH Y CIFRARLA A LA HORA DEMETERLA EN LA BD
            $sentencia="INSERT INTO usuario (nombre,contrasenia) VALUES (?,?);";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss",$nom, $contr);
            $consulta->execute();

            $insertado=false;
            if($consulta->affected_rows==1){
                $insertado=true;
            }

            $consulta->close();
            return $insertado;
        }


        //Función para seleccionar nombre y contraseña de un usuario en función de su id(Para modificar un usuario)
        public function datosUsuarioModificar($id){
            $sentencia="SELECT nombre,contrasenia FROM usuario WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$id);
            $consulta->bind_result($nombre,$contrasenia);
            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos=[$nombre,$contrasenia];
            }

            $consulta->close();
            return $datos;
        }



        //Función para modificar un usuario desde el administrador
        public function modificar_usuario($nom, $contr, $id){
            $sentencia="UPDATE usuario SET nombre=?, contrasenia=? WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ssi",$nom,$contr,$id);

            $consulta->execute();
            $modificado=false;
            if($consulta->affected_rows==1){
                $modificado=true;
            }

            $consulta->close();
            return $modificado;
        }


        public function buscarUsuario($busqueda){
            $sentencia="SELECT id, nombre, contrasenia FROM usuario WHERE nombre LIKE ?";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $param=$busqueda."%";
            $consulta->bind_param("s", $param);
            $consulta->bind_result($id,$nom,$contra);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[]=[$id,$nom,$contra];
            }

            $consulta->close();
            return $datos;
        }

        
    }
?>