<?php

class Acl_Setup {

    private $_idrole;
    private $_acl;
    private $_model_acl;

    public function __construct($idrole) {

        $this->_idrole = (INT) $idrole;
        $this->_acl = new Acl();
        $this->_model_acl = new AuxAcl();


        $this->initRole();
        $this->initResource();
        $this->roleResource();
    }

    private function initRole() {

        $vsRole = $this->_model_acl->find(array('id_role' => $this->_idrole));
        $sRole = $vsRole['role'];

        $oRole = new Acl_Role($sRole);
        $this->_acl->addRole($oRole);
    }

    private function initResource() {

        $vvResource = $this->_model_acl->findAll(array('id_role' => $this->_idrole));
        if ($vvResource) {
            $resources = array();
            foreach ($vvResource as $vsResource) {
                if (!in_array($vsResource['resource'], $resources)) {
                    array_push($resources, $vsResource['resource']);
                    $oResource = new Acl_Resource($vsResource['resource']);
                    $this->_acl->addResource($oResource);
                }
            }
        }
    }

    private function roleResource() {
        $vvResource = $this->_model_acl->findAll(array('id_role' => $this->_idrole));
        if ($vvResource) {
            $resources = array();
            foreach ($vvResource as $vsResource) {
                if (!in_array($vsResource['resource'], $resources)) {
                    array_push($resources, $vsResource['resource']);
                    $vsPrivileges = $this->getsPrivileges($vsResource['id_resource']);
                    $this->_acl->allow(trim($vsResource['role']), trim($vsResource['resource']), $vsPrivileges);
                }
            }
        }
    }

    private function getsPrivileges($idresource) {
        $idresource = (INT) $idresource;
        $vvTransacao = $this->_model_acl->findAll(array('id_role' => $this->_idrole, 'id_resource' => $idresource));
        $vvPrivileges = array();
        if ($vvTransacao) {

            foreach ($vvTransacao as $vsTransacao) {
                if (!in_array($vsTransacao['privileges'], $vvPrivileges)) {
                    array_push($vvPrivileges, trim($vsTransacao['privileges']));
                }
            }
        }

        return $vvPrivileges;
    }

    public function getAcl() {
        return $this->_acl;
    }

}

?>
