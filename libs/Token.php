<?php 
    class Token {

        private string $token;

        public function __construct(){
            $this->token = md5(time());

            $_SESSION["_token"] = $this->token;
        }
        
        public function generar() {
            $_SESSION["_token"] = md5(time());
        }

        public function __toString() {
            return "<input type=\"hidden\" name=\"_token\" value=\"{$this->token}\">";
        }

        /**
         * Comprueba si el token es válido
         */
        public static function check(string $token):bool {
            return ($_SESSION["_token"] == $token);
        }
    }
?>