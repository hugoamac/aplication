<?php

class Acl_Resource {

    protected $_resource;

    public function __construct($resource) {
        $this->setResource($resource);
    }

    public function __clone() {
        
    }

    public function setResource($resource) {

        $this->_resource = (string) $resource;
    }

    public function getResource() {

        return $this->_resource;
    }

    public function __toString() {
        return $this->getResource();
    }

}

?>
