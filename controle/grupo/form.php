<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];
$id = isset($request["id"]) ? (INT) $request["id"] : "";

$bPermissao = $oAcl->isAllowed($role, "Grupos", $sOP);

if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oGrupo = new Grupo();
$vsGrupo = $oGrupo->find(array("id" => $id));
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
                        <li><a href="<?= $_SERVER["HTTP_REFERER"] ?>">Grupos</a></li>
                        <li><?= $sOP ?> Grupo</li>   
                    </ul>

                    <h1>Grupos</h1>

                    <br/>
                    <? if (count(Session::getInstance()->getFlashMessenger()) > 0): ?>
                        <p class="<?= isset($request["sAlerta"]) ? $request["sAlerta"] : "" ?>"><?= Session::getInstance()->getFlashMessenger()->msg ?></p>
                    <? endif; ?>
                    <p class="alerta" style="display: none;"></p>
                    <form method="post" action="processa.php" class="Form">
                        <h3><?= $sOP ?></h3>

                        <table>
                            <tr>
                                <th>Nome:</th>
                                <td><input type="text" name="nome" value="<?= $vsGrupo ? $vsGrupo["nome"] : "" ?>" class="required"/></td>
                            </tr>
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

