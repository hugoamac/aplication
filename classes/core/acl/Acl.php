<?php

class Acl {

    private $_rolecount = 0;
    private $_role = array();
    private $_resourcecount = 0;
    private $_resource = array();
    private $_rule = NULL;

    const ALLOW = "allPrivileges";
    const DENY = "accessDenied";

    public function __construct() {
        
    }

    public function __clone() {
        
    }

    /*
     * Métodos Setters
     *
     */

    private function setRoleCount($rolecount) {
        $this->_rolecount = (int) $rolecount;
    }

    private function setResourceCount($resourcecount) {
        $this->_resourcecount = (int) $resourcecount;
    }

    private function setRule($permission, $role, $resource, $privileges) {

        if ($permission == self::ALLOW) {

            if (!isset($this->_rule[self::ALLOW])) {

                $this->_rule[self::ALLOW][$resource][$role] = $privileges;
            } elseif (is_array($this->_rule[self::ALLOW]) && !key_exists($resource, $this->_rule[self::ALLOW])) {
                $resources = array($role => $privileges);
                $this->_rule[self::ALLOW][$resource] = $resources;
            } elseif (is_array($this->_rule[self::ALLOW]) && key_exists($resource, $this->_rule[self::ALLOW])) {

                if (!key_exists($role, $this->_rule[self::ALLOW][$resource])) {

                    $this->_rule[self::ALLOW][$resource][$role] = $privileges;
                }
            }
        } elseif ($permission == self::DENY) {


            if (isset($this->_rule[self::ALLOW])) {

                $this->_rule[self::DENY][$resource][$role] = $privileges;
            } elseif (is_array($this->_rule[self::DENY]) && !key_exists($resource, $this->_rule[self::DENY])) {
                $resources = array($role => $privileges);
                $this->_rule[self::DENY][$resource] = $resources;
            } elseif (is_array($this->_rule[self::DENY]) && key_exists($resource, $this->_rule[self::DENY])) {

                if (!key_exists($role, $this->_rule[self::DENY][$resource])) {

                    $this->_rule[self::DENY][$resource][$role] = $privileges;
                }
            }
        }
    }

    /*
     * Métodos Getters
     *
     */

    private function getRoleCount() {
        return $this->_rolecount;
    }

    private function getResourceCount() {
        return $this->_resourcecount;
    }

    public function getRole() {

        return $this->_role;
    }

    public function getResource() {

        return $this->_resource;
    }

    public function getRule() {
        return $this->_rule;
    }

    /**
     * Métodos Funcionais
     *
     */
    private function isRoleRegistry($role) {

        if (in_array($role, $this->getRole())) {
            return TRUE;
        }


        throw new Exception("grupo <strong>" . $role . "</strong> não está registrado");
    }

    private function isResourecRegistry($resource) {

        if (in_array($resource, $this->getResource())) {
            return TRUE;
        }
        throw new Exception("recurso <strong>" . $resource . "</strong> não está registrado");
    }

    public function addRole(Acl_Role $role) {

        $this->setRoleCount($this->getRoleCount() + 1);
        $this->_role[$this->getRoleCount()] = $role;
        return $this;
    }

    public function addResource(Acl_Resource $resource) {

        $this->setResourceCount($this->getResourceCount() + 1);
        $this->_resource[$this->getResourceCount()] = $resource;
        return $this;
    }

    public function allow($role, $resource, $privileges = array()) {
        try {
            if ($this->isRoleRegistry($role) && $this->isResourecRegistry($resource)) {
                return $this->setRule(self::ALLOW, $role, $resource, $privileges);
            }
        } catch (Exception $e) {
            return die("<pre>Erro : " . $e->getMessage() . "</pre>");
        }
    }

    public function deny($role, $resource, $privileges = array()) {

        try {
            if ($this->isRoleRegistry($role) && $this->isResourecRegistry($resource)) {
                return $this->setRule(self::DENY, $role, $resource, $privileges);
            }
        } catch (Exception $e) {
            return die("<pre>Erro : " . $e->getMessage() . "</pre>");
        }
    }

    public function isAllowed($role, $resource, $privileges) {
        $rule = $this->getRule();
        if (isset($rule[self::ALLOW][$resource][$role])) {

            if (in_array($privileges, $rule[self::ALLOW][$resource][$role]))
                return TRUE;
        }
        return FALSE;
    }

}

?>