<?php 
    /**
     * Gonzalo José Salmerón Robles
     */

    class Database {

        private static $instancia = null;
        private $con;       // guarda la conexión con el motor de bd
        private $resultado; // guarda el resultado de las querys

        private function __clone() {}

        /**
         * Creamos la conexión con el motor e la base de datos
         */
        private function __construct() 
        {   
            try {
                $this->con = new mysqli("webapp-database.cdqfwivyxexs.us-east-1.rds.amazonaws.com", "admin", "Malaga00", "agenda");
            } catch (mysqli_sql_exception $e) {
                die("******** Error con la base de datos: {$e} ********");
            }
        }

        public function query(String $sql)
        {
            $this->resultado = $this->con->query($sql);
            return $this;
        }

        /**
         * Recupera un registro de la base de datos en forma de objeto
         * y lo devuelve.
         */
        public function getData($clase = "StdClass")
        {
            return $this->resultado->fetch_object($clase);
        }

        public function getAll($clase = "StdClass")
        {
            $salida = [];
            while ($item = $this->getData($clase)):
                $salida[] = $item;
            endwhile;

            return $salida;
        }

        /**
         * Escapa las cadenas que se pasan como parámetro
         * (Evita que se pueda modificar la consulta sql cuando 
         *  el usuario introduce parámetros en los input)
         * Ej. El usuario introduce hola" se convierte a hola\"
         */
        public function escape(array $cadenas): array
        {
            $salida = [];
            foreach($cadenas as $key => $value):
                $salida[$key] = $this->con->real_escape_string($value);
            endforeach;

            return $salida;
        }

        
        /**
         * Devuelve la base de datos
         */
        public static function getDatabase()
        {
            return self::$instancia ?? self::$instancia = new Database;
        }


    }
?>