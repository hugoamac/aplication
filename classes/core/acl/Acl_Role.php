<?php

class Acl_Role {

    protected $_role;

    public function __construct($role) {
        $this->setRole($role);
    }

    public function __clone() {
        
    }

    public function setRole($role) {

        $this->_role = (string) $role;
    }

    public function getRole() {

        return $this->_role;
    }

    public function __toString() {
        return $this->getRole();
    }

}

?>
