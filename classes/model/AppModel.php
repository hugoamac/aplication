<?php

abstract class AppModel extends Crud {

    protected $table;
    protected $model_transacao;
    protected $id_usuario;

    public function __construct() {
        $this->model_transacao = new LogTransacao();
        $this->id_usuario = Auth::userData()->id;
        parent::__construct($conexao);
    }

    public function insert(array $dados) {

        $rs = parent::insert($dados);

        if ($rs) {

            $descricao = "Dados Inserido:\n";
            $descricao.="id:{$rs}\n";

            foreach ($dados as $col => $val) {
                if (trim($col) != "id" && trim($col) != "sOP" && trim($col) != "senha" && trim() != "senha_2") {
                    if (!is_array($val)) {
                        $descricao.="{$col} : {$val}\n";
                    }
                }
            }

            $data = array(
                'id_log_operacao' => 1,
                'id_usuario' => $this->id_usuario,
                'tabela' => $this->table,
                'descricao' => $descricao
            );

            $this->model_transacao->insert($data);
        }


        return $rs;
    }

    public function update(array $dados, array $where, $operator = array()) {

        $data_atual = $this->find(array('id' => $where['id']));
        $rs = parent::update($dados, $where, $operator);

        if ($rs) {

            $descricao = "Dados Editado:\n";
            if ($data_atual) {
                foreach ($data_atual as $col => $val) {

                    if (!empty($dados[$col])) {
                        $descricao.="{$col}: $val <b>para</b> {$dados[$col]}\n";
                    } else {
                        $descricao.="{$col}: $val <b>para</b> {$val}\n";
                    }
                }
            }
            $data = array(
                'id_log_operacao' => 2,
                'id_usuario' => $this->id_usuario,
                'tabela' => $this->table,
                'descricao' => $descricao
            );
            $this->model_transacao->insert($data);
        }

        return $rs;
    }

    public function delete(array $where, $operator = array()) {
        $rs = parent::delete($where, $operator);

        if ($rs) {

            $descricao = "Dados Apagados:\n";
            foreach ($where as $col => $val) {
                $descricao.="{$col}:{$val}\n";
            }
            $data = array(
                'id_log_operacao' => 3,
                'id_usuario' => $this->id_usuario,
                'tabela' => $this->table,
                'descricao' => $descricao
            );

            $this->model_transacao->insert($data);
        }

        return $rs;
    }

}

