<?php
    require_once("class_bd.php");

    class Prestamo{
        private $conn;
        private $id;
        private $usuario;
        private $amigo;
        private $juego;
        private $f_prestamo;
        private $devuelto;

        public function __construct(){
            $this->conn=new bd();
            $this->id="";
            $this->usuario="";
            $this->amigo="";
            $this->juego="";
            $this->f_prestamo="";
            $this->devuelto="";
        }

        public function get_prestamos($idUsuario){
            $sentencia="SELECT prestamo.id, amigo.nombre, juego.titulo, juego.img, prestamo.f_prestamo, prestamo.devuelto FROM prestamo, amigo, juego where prestamo.amigo=amigo.id AND prestamo.juego=juego.id AND prestamo.usuario=? ORDER BY f_prestamo DESC;";

            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idUsuario);
            $consulta->bind_result($id,$amigo,$titJuego,$imgJuego,$fechaPrest,$devuelto);
            $consulta->execute();

            $datosPrestamo=[];
            while($consulta->fetch()){
                $datosPrestamo[$id]=[$amigo,$titJuego,$imgJuego,$fechaPrest,$devuelto];
            }

            $consulta->close();
            return $datosPrestamo;
        }

        public function insertar_prestamo($usuario,$amigo,$juego,$fecha){
            $sentencia="INSERT INTO prestamo (usuario,amigo,juego,f_prestamo) VALUES (?,?,?,?);";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("iiis",$usuario,$amigo,$juego,$fecha);
            $consulta->execute();

            $insertado=false;
            if($consulta->affected_rows==1){
                $insertado=true;
            }

            $consulta->close();
            return $insertado;
        }


        public function devolver($id){
            $sentencia="UPDATE prestamo SET devuelto=1 WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$id);
            $consulta->execute();

            $devuelto=false;
            if($consulta->affected_rows==1){
                $devuelto=true;
            }

            $consulta->close();
            return $devuelto;
        }


        public function buscarPrestamo($busqueda, $idUser){
            $sentencia="SELECT usuario.nombre, amigo.nombre, juego.titulo, juego.img, prestamo.f_prestamo, prestamo.devuelto, prestamo.id
                        FROM prestamo
                        JOIN usuario ON prestamo.usuario = usuario.id
                        JOIN amigo ON prestamo.amigo = amigo.id
                        JOIN juego ON prestamo.juego = juego.id
                        WHERE (amigo.nombre LIKE ? OR juego.titulo LIKE ?) AND usuario.id=?;";

            $consulta=$this->conn->getConection()->prepare($sentencia);
            $param=$busqueda."%";
            $consulta->bind_param("ssi", $param, $param, $idUser);
            $consulta->bind_result($usu, $amigo, $juego, $img, $f_pres, $dev, $id);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$usu, $amigo, $juego, $img, $f_pres, $dev];
            }

            $consulta->close();
            return $datos;
        }


    }
?>