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


        public function get_Amigos($idUsuario){
            $sentencia="SELECT amigo.id,amigo.nombre,amigo.apellidos,amigo.f_nac,amigo.verificado FROM amigo,usuario WHERE amigo.usuario=usuario.id AND usuario.id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idUsuario);
            $consulta->bind_result($idAmigo,$nombre,$apellidos,$f_nac,$ver);

            $consulta->execute();

            $datosAmigos=[];

            while($consulta->fetch()){
                $datosAmigos[$idAmigo]=[$nombre,$apellidos,$f_nac,$ver];
            }

            $consulta->close();
            return $datosAmigos;
        }

        //Función para contar los amigos de un usuario
        public function contarAmigos($idUsuario){
            $sentencia="SELECT count(amigo.id) FROM amigo, usuario where amigo.usuario = usuario.id AND usuario.id=?";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idUsuario);
            $consulta->bind_result($numAmigos);
            
            $consulta->execute();
            $consulta->fetch();

            return $numAmigos;

        }

        public function get_AllAmigos(){
            $sentencia="SELECT amigo.id,amigo.nombre,amigo.apellidos,amigo.f_nac,usuario.nombre FROM amigo,usuario WHERE amigo.usuario=usuario.id;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_result($idAmigo,$nombre,$apellidos,$f_nac,$duenio);

            $consulta->execute();

            $datosAmigos=[];

            while($consulta->fetch()){
                $datosAmigos[$idAmigo]=[$nombre,$apellidos,$f_nac,$duenio];
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


        public function modificar_amigo($nom,$ape,$f_nac,$idAmigo){
            $sentencia="UPDATE amigo SET nombre=?, apellidos=?, f_nac=? WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("sssi",$nom,$ape,$f_nac,$idAmigo);
            $consulta->execute();
            
            $modificado=false;
            if($consulta->affected_rows==1){
                $modificado=true;
            }

            $consulta->close();
            return $modificado;
        }


        //Función para obtener los datos de 1 amigo según su id, esto nos sirve para, a la hora de modificar amigos, rellenar el formulario sin tener que pasarle los parámetros por la url, así es más seguro
        public function obtenerAmigoSegunId($idAmigo){
            $sentencia="SELECT nombre,apellidos,f_nac FROM amigo WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idAmigo);
            $consulta->bind_result($nombre,$apeliidos,$fecha);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos=[$nombre,$apeliidos,$fecha];
            }

            $consulta->close();
            return $datos;
        }


        public function ordenarNombre($idAmigo){
            $sentencia="SELECT id,nombre,apellidos,f_nac FROM amigo WHERE usuario=? ORDER BY nombre ASC;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idAmigo);
            $consulta->bind_result($id,$nombre,$apeliidos,$fecha);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$nombre,$apeliidos,$fecha];
            }

            $consulta->close();
            return $datos;
        }

        public function ordenarFecha($idAmigo){
            $sentencia="SELECT id,nombre,apellidos,f_nac FROM amigo WHERE usuario=? ORDER BY f_nac ASC;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idAmigo);
            $consulta->bind_result($id,$nombre,$apeliidos,$fecha);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$nombre,$apeliidos,$fecha];
            }

            $consulta->close();
            return $datos;
        }


        // public function insertar_Contactos($nom,$ape,$f_nac,$usuario){
        //     $sentencia=""
        // }

        //Función para averiguar el dueño de un amigo en función del id
        public function encontrarDuenio($id){
            $sentencia="SELECT usuario FROM amigo WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i", $id);
            $consulta->bind_result($duenio);
            
            $consulta->execute();
            $consulta->fetch();

            $consulta->close();
            return $duenio;

        }

        public function modificarAmigoAdmin($nom,$ape,$f_nac,$duenio,$idAmigo){
            $sentencia="UPDATE amigo SET nombre=?, apellidos=?, f_nac=?, usuario=? WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("sssii", $nom,$ape,$f_nac,$duenio,$idAmigo);
            
            $consulta->execute();
            
            $modificado=false;
            if($consulta->affected_rows==1){
                $modificado=true;
            }

            $consulta->close();
            return $modificado;
        }


        public function buscarAmigo($idUsuario, $busqueda){
            $sentencia="SELECT id, nombre, apellidos, f_nac FROM amigo WHERE (nombre LIKE ? OR apellidos LIKE ?) AND usuario=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $param=$busqueda."%";
            $consulta->bind_param("ssi", $param, $param, $idUsuario);
            $consulta->bind_result($id,$nom,$ape,$f_nac);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$nom,$ape,$f_nac];
            }

            $consulta->close();
            return $datos;
        }

        public function buscarContacto($busqueda){
            $sentencia="SELECT amigo.id, amigo.nombre, apellidos, f_nac, usuario.nombre FROM amigo,usuario WHERE (amigo.nombre LIKE ? OR apellidos LIKE ?) AND amigo.usuario=usuario.id;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $param=$busqueda."%";
            $consulta->bind_param("ss", $param, $param);
            $consulta->bind_result($id, $nom,$ape,$f_nac,$usuario);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$nom,$ape,$f_nac,$usuario];
            }

            $consulta->close();
            return $datos;
        }
    }
?>