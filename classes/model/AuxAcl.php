<?php

class AuxAcl extends Crud {

    protected $table = "aux_acl";

    public static function getInstance() {
        return parent::getInstance(__CLASS__);
    }

}

?>
