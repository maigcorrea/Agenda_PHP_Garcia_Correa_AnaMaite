<?php
    require_once("class_bd.php");

    class Juego{
        private $conn;
        private $id;
        private $titulo;
        private $plataforma;
        private $lanzamiento;
        private $img;
        private $usuario;

        public function __construct(){
            $this->conn = new bd();
            $this->id = "";
            $this->titulo = "";
            $this->plataforma = "";
            $this->lanzamiento = "";
            $this->img = "";
            $this->usuario = "";
        }

        public function get_juegos($usuario){
            $sentencia="SELECT id,img,titulo,plataforma,lanzamiento FROM juego WHERE usuario=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$usuario);
            $consulta->bind_result($id,$img,$titulo,$plataforma,$lanzamiento);
            $consulta->execute();

            $juegos=[];

            while($consulta->fetch()){
                $juegos[$id]=[$img,$titulo,$plataforma,$lanzamiento];
            }

            $consulta->close();
            return $juegos;
        }

        public function insertar_Juego($titulo,$plataforma,$lanzamiento,$img,$usuario){
            $sentencia="INSERT INTO juego (titulo,plataforma,lanzamiento,img,usuario) VALUES(?,?,?,?,?)";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ssisi",$titulo,$plataforma,$lanzamiento,$img,$usuario);
            $consulta->execute();

            $exito=false;
            if($consulta->affected_rows==1){
                $exito=true;
            }

            $consulta->close();
            return $exito;
        }

    }
?>