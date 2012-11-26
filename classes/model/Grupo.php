<?php

class Grupo extends AppModel{

    protected $table = "usu_grupo";

    public static function getInstance() {

        return parent::getInstance(__CLASS__);
    }

    public function getGrupo($id) {
        $id = (INT) $id;
        $dados = $this->find(array('id' => $id));
        return $dados ? $dados["nome"] : "desconhecido";
    }
    

}

?>
