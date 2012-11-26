<?php

class Session {

    private static $_instance;
    private $_flashMessenger;

    public static function getInstance() {

        if (NULL === self::$_instance) {

            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function createSession($name, $val) {

        $_SESSION[$name] = $val;
        return $this;
    }

    public function selectSession($name) {

        return $_SESSION[$name];
    }

    public function checkSession($name) {

        return isset($_SESSION[$name]);
    }

    public function deleteSession($name) {

        unset($_SESSION[$name]);
        return $this;
    }

    public function flashMessenger(array $array) {

        if (is_array($array)) {
            if ($this->checkSession("messenger"))
                $this->deleteSession("messenger");
            $this->createSession("messenger", $array);
        }
    }

    public function getFlashMessenger() {

        if (NULL === $this->_flashMessenger) {

            if ($this->checkSession("messenger")) {

                $this->_flashMessenger = $this->convertObj($this->selectSession("messenger"));
                $this->deleteSession("messenger");
            }
        }

        return $this->_flashMessenger;
    }

    private function convertObj($array) {

        if (is_array($array)) {

            $obj = new stdClass();

            foreach ($array as $key => $val) {

                $obj->$key = $val;
            }

            return $obj;
        }
    }

}

?>