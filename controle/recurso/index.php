<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();

$bVisualizar = $oAcl->isAllowed($role, "Recursos", "Visualizar");
$bAdicionar = $oAcl->isAllowed($role, "Recursos", "Adicionar");
$bEditar = $oAcl->isAllowed($role, "Recursos", "Editar");
$bApagar = $oAcl->isAllowed($role, "Recursos", "Apagar");

if (!$bVisualizar) {
    header("Location:/error/index.php");
    exit;
}
$oRecurso = new Recurso();

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
                        <li>Recursos</li>
                    </ul>

                    <h1>Recursos</h1>

                    <br/>
                    <? if ($bAdicionar): ?>
                        <a href="form.php?sOP=Adicionar" class="Botao">Adicionar</a>
                    <? endif; ?>
                    <? if (count(Session::getInstance()->getFlashMessenger()) > 0): ?>
                        <p class="<?= isset($request["sAlerta"]) ? $request["sAlerta"] : "" ?>"><?= Session::getInstance()->getFlashMessenger()->msg ?></p>
                    <? endif; ?>

                    <table class="Lista">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Recurso</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? if ($vvRecurso): ?>
                                <? foreach ($vvRecurso as $vsRecurso): ?>
                                    <tr>
                                        <td><?= $vsRecurso["id"] ?></td>
                                        <td><?= $vsRecurso["recurso"] ?></td>
                                        <td>
                                            <? if ($bEditar): ?>
                                                <a href="form.php?id=<?= $vsRecurso["id"] ?>&sOP=Editar" class="Botao">Editar</a>
                                            <? endif; ?>
                                            <? if ($bApagar): ?>
                                                <a href="processa.php?id=<?= $vsRecurso["id"] ?>&sOP=Apagar" class="Apagar Botao">Apagar</a>
                                            <? endif; ?>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                            <? else: ?>
                                <tr>
                                    <td colspan="3">Ops ! nenhum registro encontrado.</td>
                                </tr>
                            <? endif; ?>
                        </tbody>
                    </table>

                </div>
                <div class="clear"></div>
            </div>
            <!-- DIV FOOTER-->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/footer.inc.php"); ?>

        </div>
    </body>
</html>

