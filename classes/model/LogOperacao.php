<?php

class LogOperacao extends Crud {

    protected $table = "log_operacao";

    public static function getInstance() {
        return parent::getInstance(__CLASS__);
    }

    public function getOperacao($idoperacao) {
        $idoperacao = (INT) $idoperacao;
        $data = $this->find(array('id' => $idoperacao));

        if ($data) {
            return $data["nome"];
        }
        return "not found";
    }

}

?>
