<?php

class RecursoTransacao extends Crud {

    protected $table = "usu_recurso_transacao";

    public static function getInstance() {
        return parent::getInstance(__CLASS__);
    }



}

?>
