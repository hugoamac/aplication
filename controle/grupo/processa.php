<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php"); 

$request = Helper::PostGet();
$sOP = $request["sOP"];

$bPermissao = $oAcl->isAllowed($role, "Grupos", $sOP);
if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oGrupo = new Grupo();

switch ($sOP) {

    case "Adicionar":

        $id = $oGrupo->insert($request);

        if ($id) {

            Session::getInstance()->flashMessenger(array("msg" => "Operação registrada com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {
            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível registrar a operação, tente novamente!"));
            $sHeader = "form.php?sOP={$sOP}&sAlerta=erro";
        }

        break;
    case "Editar":
        $id = (INT) $request["id"];
        $vsGrupo = $oGrupo->find(array("id" => $id));

        if ($vsGrupo) {

            $bResultado = $oGrupo->update($request, array("id" => $id));
        }

        if ($bResultado) {
            Session::getInstance()->flashMessenger(array("msg" => "Registro editado com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {

            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível editar o registro, tente novamente!"));
            $sHeader = "form.php?sOP={$sOP}&id={$id}&sAlerta=erro";
        }


        break;
    case "Apagar":

        $id = (INT) $request["id"];
        $vsGrupo = $oGrupo->find(array("id" => $id));

        if ($vsGrupo) {

            $bResultado = $oGrupo->delete(array("id" => $id));
            
          
        }

        if ($bResultado) {
            Session::getInstance()->flashMessenger(array("msg" => "Registro apagado com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {

            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível apagar o registro, tente novamente!"));
            $sHeader = "index.php?sAlerta=erro";
        }

        break;
}

header("location:" . $sHeader);
?>
