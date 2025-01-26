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
            $sentencia="SELECT prestamo.id, amigo.nombre, juego.titulo, juego.img, prestamo.f_prestamo, prestamo.devuelto FROM prestamo, amigo, juego where prestamo.amigo=amigo.id AND prestamo.juego=juego.id AND prestamo.usuario=?;";

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
    }
?>