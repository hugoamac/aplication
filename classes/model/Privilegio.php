<?php

class Privilegio extends Crud {

    protected $table = "usu_privilegio";

    public static function getInstance() {

        return parent::getInstance(__CLASS__);
    }

    public function isGrupoHasPermission($id_grupo, $id_transacao) {

        $id_grupo = (INT) $id_grupo;
        $id_transacao = (INT) $id_transacao;
        $data = $this->find(array('id_grupo' => $id_grupo, 'id_transacao' => $id_transacao));
        if ($data) {
            return TRUE;
        }
        return FALSE;
    }

}

?>
