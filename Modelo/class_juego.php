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

        
        public function modificar_juego($titulo, $plataforma, $lanzamiento, $img, $idImagen){
            $sentencia="UPDATE juego SET titulo=?, plataforma=?, lanzamiento=?, img=? WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ssisi",$titulo, $plataforma, $lanzamiento, $img, $idImagen);
            $consulta->execute();

            $modificado=false;
            if($consulta->affected_rows==1){
                $modificado=true;
            }

            $consulta->close();
            return $modificado;
        }

// 0 que no se ha devuelto, 1, que se ha devuelto
        public function get_juegosDisp($usuario){
            $sentencia="SELECT juego.id, juego.titulo, juego.plataforma
                        FROM juego
                        LEFT JOIN (
                            SELECT p.juego, MAX(p.id) AS max_id
                            FROM prestamo p
                            WHERE p.usuario = ?  -- Filtramos los préstamos solo del usuario específico
                            GROUP BY p.juego
                        ) ultimos_prestamos ON juego.id = ultimos_prestamos.juego
                        LEFT JOIN prestamo p_final ON ultimos_prestamos.max_id = p_final.id AND p_final.devuelto = 0
                        WHERE p_final.id IS NULL
                        AND juego.usuario = ?;  -- Filtramos los juegos cuyo dueño sea el usuario específico
                        ";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ii",$usuario,$usuario);
            $consulta->bind_result($id,$titulo,$plataforma);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$titulo,$plataforma];
            }

            $consulta->close();
            return $datos;
        }

        //Función para obtener los datos de 1 juego según su id, esto nos sirve para, ala hora de modificar juegos, rellenar el formulario sin tener que pasarle los parámetros por la url, así es más seguro
        public function obtenerJuegoSegunId($idJuego){
            $sentencia="SELECT titulo,plataforma,lanzamiento,img FROM juego WHERE id=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idJuego);
            $consulta->bind_result($titulo,$plataforma,$lanzamiento,$img);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos=[$titulo,$plataforma,$lanzamiento,$img];
            }

            $consulta->close();
            return $datos;
        }


        public function obtenerImgActual($idJuego){
            $sentencia="SELECT img FROM juego WHERE id=?";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("i",$idJuego);
            $consulta->bind_result($img);

            $consulta->execute();

            $consulta->fetch();

            $consulta->close();
            return $img;
        }


        public function buscarJuego($busqueda,$id){
            $sentencia="SELECT id, img, titulo, plataforma, lanzamiento FROM juego WHERE (titulo LIKE ? OR plataforma LIKE ?) AND usuario=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $param=$busqueda."%";
            $consulta->bind_param("ssi", $param, $param,$id);
            $consulta->bind_result($id, $img, $titulo, $plataforma, $lanzamiento);

            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$img, $titulo, $plataforma, $lanzamiento];
            }

            $consulta->close();
            return $datos;
        }

    }
?>