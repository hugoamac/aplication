<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];
$id = isset($request["id"]) ? (INT) $request["id"] : "";

$bPermissao = $oAcl->isAllowed($role, "Permissão", $sOP);

if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oRecurso = new Recurso();
$oRecursoTransacao = new RecursoTransacao();
$vvRecurso = $oRecurso->findAll();
?>
<!DOCTYPE html>
<html>
    <head>
        <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/anexos.inc.php"); ?>
    </head>
    <body>
        <div id="main">
            <!-- DIV HEADER -->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/topo.inc.php"); ?>
            <!-- DIV CONTAINER -->
            <div id="container">
                <!-- DIV MENU_LEFT-->
                <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/menu.inc.php"); ?>
                <!-- DIV CONTENT-->
                <div id="content">
                    <ul id="breadcrumbs">
                        <li><a href="/controle/grupo/">Grupos</a></li>
                        <li><a href="#">Permissões</a></li>
                    </ul>

                    <h1>Permissões</h1>

                    <br/>
                    <? if (count(Session::getInstance()->getFlashMessenger()) > 0): ?>
                        <p class="<?= isset($request["sAlerta"]) ? $request["sAlerta"] : "" ?>"><?= Session::getInstance()->getFlashMessenger()->msg ?></p>
                    <? endif; ?>
                    <p class="alerta" style="display: none;"></p>
                    <form method="post" action="processa.php" class="Form">
                        <h3>Privilégios Para <?= Grupo::getInstance()->getGrupo($id) ?></h3>

                        <? foreach ($vvRecurso as $vsRecurso): ?>                                              
                            <? $vvTransacao = $oRecursoTransacao->findAll(array('id_recurso' => $vsRecurso["id"])); ?>
                            <table>
                                <tr>
                                    <th colspan="2"><?= $vsRecurso["recurso"] ?></th>
                                </tr>
                                <? foreach ($vvTransacao as $vsTransacao): ?>
                                    <tr>
                                        <td><input type="checkbox" name="id_transacao[<?= $vsTransacao["id"] ?>]" value="<?= $vsTransacao["id"] ?>" <?= Privilegio::getInstance()->isGrupoHasPermission($id, $vsTransacao["id"]) ? "checked" : "" ?>/></td>
                                        <td><?= $vsTransacao["transacao"] ?></td>
                                    </tr>
                                <? endforeach; ?>

                            </table>
                        <? endforeach; ?>


                        <table>
                            <tr>
                                <th> &nbsp;</th>
                                <td> &nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" name="id_grupo" value="<?= $id ?>"/>
                                    <input type="hidden" name="sOP" value="<?= $sOP ?>"/>
                                </td>
                                <td>
                                    <button type="submit"><?= $sOP ?></button>
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
                <div class="clear"></div>
            </div>
            <!-- DIV FOOTER-->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/footer.inc.php"); ?>

        </div>
    </body>
</html>

