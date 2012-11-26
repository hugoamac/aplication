<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];

$bPermissao = $oAcl->isAllowed($role, "Permissão", $sOP);
if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oPrivilegio = new Privilegio();

switch ($sOP) {

    case "Adicionar":

        $id_grupo = (INT) $request["id_grupo"];
        $vIdTransacao = $request["id_transacao"];

        $oPrivilegio->delete(array('id_grupo' => $id_grupo));

        foreach ($vIdTransacao as $id_transacao) {
            $data = array('id_grupo' => $id_grupo, 'id_transacao' => $id_transacao);
            $oPrivilegio->insert($data);
        }


        Session::getInstance()->flashMessenger(array("msg" => "Operação registrada com sucesso!"));
        $sHeader = "form.php?sOP={$sOP}&id={$id_grupo}&sAlerta=sucesso";


        break;
}

header("location:" . $sHeader);
?>
