<?php

class Usuario extends AppModel {

    protected $table = "usu_usuario";

    public static function getInstance() {
        return parent::getInstance(__CLASS__);
    }

    public function getNome($idusuario) {
        $idusuario = (INT) $idusuario;

        $data = $this->find(array('id' => $idusuario));
        if ($data) {
            return $data["nome"];
        }

        return "not found";
    }

    public function insert(array $dados) {

        if (isset($dados["senha"]) && !empty($dados["senha"])) {
            $dados["senha"] = md5($dados["senha"]);
        }
        return parent::insert($dados);
    }

    public function update(array $dados, array $where, $operator = array()) {

        if (isset($dados["senha"]) && !empty($dados["senha"])) {
            $dados["senha"] = md5($dados["senha"]);
        }

        return parent::update($dados, $where, $operator);
    }

    public function find(array $where) {
        if (isset($where["senha"])) {
            $where["senha"] = md5($where["senha"]);
        }

        return parent::find($where);
    }

    public function findAll($where = array(), $operator = array(), $order = null, $limit = null, $offset = null) {

        if (isset($where["senha"])) {
            $where["senha"] = md5($where["senha"]);
        }
        return parent::findAll($where, $operator, $order, $limit, $offset);
    }

}

?>
