<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];

$bPermissao = $oAcl->isAllowed($role, "Usuários", $sOP);
if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oUsuario = new Usuario();


switch ($sOP) {

    case "Adicionar":

        $id = $oUsuario->insert($request);

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
        $vsUsuario = $oUsuario->find(array("id" => $id));

        if ($vsUsuario) {

            $bResultado = $oUsuario->update($request, array("id" => $id));
        }

        if ($bResultado) {
            Session::getInstance()->flashMessenger(array("msg" => "Registro editado com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {

            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível editar o registro, tente novamente!"));
            $sHeader = "form.php?sOP={$sOP}&id={$id}&sAlerta=erro";
        }


        break;
    case "Desativar":

        $id = (INT) $request["id"];
        $vsUsuario = $oUsuario->find(array("id" => $id));

        if ($vsUsuario) {

            $data = date("Y-m-d H:i:s");
            $bResultado = $oUsuario->update(array("ativo" => 0, "data_inativacao" => $data), array("id" => $id));
        }

        if ($bResultado) {
            Session::getInstance()->flashMessenger(array("msg" => "Usuário desativado com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {

            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível desativar o usuário, tente novamente!"));
            $sHeader = "form.php?sAlerta=erro";
        }

        break;

    case "Ativar":

        $id = (INT) $request["id"];
        $vsUsuario = $oUsuario->find(array("id" => $id));

        if ($vsUsuario) {

            $data = date("Y-m-d H:i:s");
            $bResultado = $oUsuario->update(
                    array("ativo" => 1, "data_criacao" => $data, "data_inativacao" => "NULL"), array("id" => $id)
            );
        }

        if ($bResultado) {
            Session::getInstance()->flashMessenger(array("msg" => "Usuário ativado com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {

            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível ativar o usuário, tente novamente!"));
            $sHeader = "form.php?sAlerta=erro";
        }

        break;
    case "Apagar":

        $id = (INT) $request["id"];
        $vsUsuario = $oUsuario->find(array("id" => $id));

        if ($vsUsuario) {

            $bResultado = $oUsuario->delete(array("id" => $id));
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
