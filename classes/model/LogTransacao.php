<?php

class LogTransacao extends Crud {

    protected $table = "log_transacao";

    public function Pesquisar(array $data) {

        $sql = "select * from {$this->table} where 1=1 ";

        if ($data['id_usuario']) {
            $sql .=" and id_usuario = " . (INT) $data["id_usuario"];
        }

        if ($data['data_inicial'] && $data['data_final']) {
            $data_inicial = Helper::converteDataParaBanco($data['data_inicial']);
            $data_final = Helper::converteDataParaBanco($data['data_final']);

            $sql.=" and data_criacao BETWEEN '{$data_inicial}' and '{$data_final}'";
        }
        
        return $this->fetchPaginator($sql);

        
    }

}

?>
