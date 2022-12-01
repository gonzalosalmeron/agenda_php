<?php 
    /**
     * Gonzalo José Salmerón Robles
     */

    class Usuario {

        private $id;
        private $nombre;
        private $apellidos;
        private $email;
        private $password;


        /**
         * Se invoca automáticamente cuando se realiza una serialización.
         * Devuelve un array con el nombre de aquellas propiedades que queremos
         * que se serialicen
         */
        public function __sleep()
        {
            return ["id", "email", "nombre", "apellidos"];
        }

        /**
         * Se invoca automáticamente cuando se hace una deserialización.
         * Lo utilizamos para realizar acciones necesarias de recuperación
         * del objecto (establecer una conexión, abrir un archivo, etc.)
         */
        public function __wakeup(){}

        public function __get(string $property){
            return $this->$property;
        }
    }
?>