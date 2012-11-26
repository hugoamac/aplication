<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];
$id = isset($request["id"]) ? (INT) $request["id"] : "";

$bPermissao = $oAcl->isAllowed($role, "Recursos", $sOP);
if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oRecurso = new Recurso();
$vsRecurso = $oRecurso->find(array("id" => $id));
?>
<!DOCTYPE html>
<html>
    <head>
        <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/anexos.inc.php"); ?>
        <script src="/js/controle/recurso.js" type="text/javascript"></script>
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
                        <li><a href="<?= $_SERVER["HTTP_REFERER"] ?>">Recursos</a></li>
                        <li><?= $sOP ?> Recurso</li>
                    </ul>

                    <h1>Recursos</h1>

                    <br/>
                    <? if (count(Session::getInstance()->getFlashMessenger()) > 0): ?>
                        <p class="<?= isset($request["sAlerta"]) ? $request["sAlerta"] : "" ?>"><?= Session::getInstance()->getFlashMessenger()->msg ?></p>
                    <? endif; ?>
                    <p class="alerta" style="display: none;"></p>
                    <form method="post" action="processa.php" class="Form">
                        <h3><?= $sOP ?></h3>

                        <table>
                            <tr>
                                <th>Recurso:</th>
                                <td><input type="text" name="recurso" value="<?= $vsRecurso ? $vsRecurso["recurso"] : "" ?>" class="required"/></td>
                            </tr>
                            <? if (!$id): ?>
                                <tr>
                                    <th>Transação</th>
                                    <td>
                                        <div id="transacoes">
                                            <p>
                                                <input type="text" name="transacao[]" style="margin-top: 5px" class="required"/>
                                                <a href="javascript:void(0);" class="add"><img src="/images/comuns/add.png" width="25" border="0" style="vertical-align:middle"/></a>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            <? else: ?>
                                <tr>
                                    <th>Transação</th>
                                    <td>
                                        <div id="transacoes">
                                            <? foreach (RecursoTransacao::getInstance()->findAll(array('id_recurso' => $id)) as $nIndice => $vsTransacao): ?>
                                                <p>
                                                    <input type="text" name="transacao[<?= $vsTransacao["id"] ?>]" value="<?= $vsTransacao["transacao"] ?> " <?= (($nIndice + 1) == 1) ? 'class="required"' : '' ?> style="margin-top: 5px"/>
                                                    <input type="hidden" name="id_transacao[<?= $vsTransacao["id"] ?>]" value="<?= $vsTransacao["id"] ?>"/>
                                                    <a href="javascript:void(0);" class="add"><img src="/images/comuns/add.png" width="25" border="0" style="vertical-align:middle"/></a>
                                                    <? if (($nIndice + 1) != 1): ?>
                                                        <a href="javascript:void(0);" class="remove"><img src="/images/comuns/remove.png" width="25" border="0" style="vertical-align:middle"/></a>
                                                    <? endif; ?>
                                                </p>
                                            <? endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                            <? endif; ?>
                            <tr>
                                <th> &nbsp;</th>
                                <td> &nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" name="id" value="<?= $id ?>"/>
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

