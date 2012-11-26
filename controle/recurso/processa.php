<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];

$bPermissao = $oAcl->isAllowed($role, "Recursos", $sOP);
if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oRecurso = new Recurso();



switch ($sOP) {

    case "Adicionar":

        $id = $oRecurso->insert($request);

        if ($id) {

            $vsTransacao = $request["transacao"];

            foreach ($vsTransacao as $sTransacao) {

                $dataTransacao = array(
                    "id_recurso" => $id,
                    "transacao" => $sTransacao
                );

                RecursoTransacao::getInstance()->insert($dataTransacao);
            }

            Session::getInstance()->flashMessenger(array("msg" => "Operação registrada com sucesso!"));
            $sHeader = "index.php?sAlerta=sucesso";
        } else {
            Session::getInstance()->flashMessenger(array("msg" => "Não foi possível registrar a operação, tente novamente!"));
            $sHeader = "form.php?sOP={$sOP}&sAlerta=erro";
        }

        break;
    case "Editar":

        $vsTransacao = $request["transacao"];
        $vsIdTransacao = $request["id_transacao"];

        $vsDataInsert = array_diff_key($vsTransacao, $vsIdTransacao);
        $vsDataUpdate = array_intersect_key($vsTransacao, $vsIdTransacao);

        $id = (INT) $request["id"];
        $vsRecurso = $oRecurso->find(array("id" => $id));

        if ($vsRecurso) {
            //Atualizando o Recurso
            $bResultado = $oRecurso->update($request, array("id" => $id));
            //Atualizando as transações
            foreach ($vsDataUpdate as $id_transacao => $sTransacao) {

                RecursoTransacao::getInstance()->update(array('transacao' => $sTransacao), array('id' => $id_transacao));
            }
            //Inserindo novas transações
            foreach ($vsDataInsert as $sTransacao) {
                $data = array(
                    'id_recurso' => $id,
                    'transacao' => $sTransacao
                );
                RecursoTransacao::getInstance()->insert($data);
            }
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
        $vsRecurso = $oRecurso->find(array("id" => $id));

        if ($vsRecurso) {

            $bResultado = $oRecurso->delete(array("id" => $id));
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
