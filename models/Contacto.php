<?php 
    /**
     * Gonzalo José Salmerón Robles
     */

    require_once("./libs/Database.php");

    class Contacto {

        private $id;
        private $nombre;
        private $apellidos;
        private $telefono;
        private $email;
        private $foto;
        private $observaciones;
        private $idUsu;
        
        public function __set($prop, $valor){
            return $this->$prop = $valor;
        }

        public function __get($property){
            return $this->$property;
        }

        /**
         * Guarda un contacto en la bd
         */
        public function save(){
            
            $db = Database::getDatabase();
            
            $resultado = $db->escape($_POST);

            $sql = "INSERT INTO contacto 
                VALUES (null, 
                    '{$resultado["nombre"]}',
                    '{$resultado["apellidos"]}',
                    '{$resultado["telefono"]}',
                    '{$resultado["email"]}',
                    '{$resultado["foto"]}',
                    '{$resultado["observaciones"]}',
                    '{$resultado["idUsu"]}')";
            $db->query($sql);
        }

        public function update(){
            $db = Database::getDatabase();
        
            $resultado = $db->escape($_POST);
            
            $db->query("UPDATE contacto SET
                nombre = '{$resultado["nombre"]}',
                apellidos = '{$resultado["apellidos"]}',
                telefono = '{$resultado["telefono"]}',
                email = '{$resultado["email"]}',
                foto = '{$resultado["foto"]}',
                observaciones = '{$resultado["observaciones"]}'
            WHERE id = '{$resultado["id"]}'");
        }

        public function delete(){
            $db = Database::getDatabase();

            $db->query("DELETE FROM contacto WHERE id = '{$this->id}';");
        }

        public static function getById(int $idCon): ?Contacto {
            $db = Database::getDatabase();

            $sql = "SELECT * FROM contacto WHERE id = '{$idCon};'";

            return $db->query($sql)->getData("Contacto");
        }

        public static function getAllByUser(int $idUsu) {
            $db = Database::getDatabase();

            $sql = "SELECT * FROM contacto where idUsuario = {$idUsu};";

            return $db->query($sql)->getAll("Contacto");
        }
    }
?>