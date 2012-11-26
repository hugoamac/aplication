<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();


$bVisualizar = $oAcl->isAllowed($role, "Log", "Visualizar");


if (!$bVisualizar) {
    header("Location:/error/index.php");
    exit;
}


$oLogTransacao = new LogTransacao();

$vvLogTransacao = $oLogTransacao->paginator(array(), array(), "data_criacao desc");
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
                        <li>Log do Sistema</li>
                    </ul>

                    <h1>Log do Sistema</h1>

                    <br/>

                    <?= $oLogTransacao->pagination->printPainelResultado() ?>

                    <table class="Lista">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Operação</th>
                                <th>Usuário</th>
                                <th>Tabela</th>
                                <th>Data</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? if ($vvLogTransacao): ?>
                                <? foreach ($vvLogTransacao as $vsLogTransacao): ?>
                                    <tr>
                                        <td><?= $vsLogTransacao["id"] ?></td>
                                        <td><?= LogOperacao::getInstance()->getOperacao($vsLogTransacao["id_log_operacao"]) ?></td>
                                        <td><?= Usuario::getInstance()->getNome($vsLogTransacao["id_usuario"]) ?></td>
                                        <td><?= $vsLogTransacao["tabela"] ?></td>
                                        <td><?= Helper::formatData("d/m/Y à\s H:i:s", $vsLogTransacao["data_criacao"]) ?></td>
                                        <td>
                                            <a href="detalhe.php?id=<?= $vsLogTransacao["id"] ?>" class="Botao">Detalhe</a>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                            <? else: ?>
                                <tr>
                                    <td colspan="6">Ops ! nenhum registro encontrado.</td>
                                </tr>
                            <? endif; ?>
                        </tbody>
                    </table>

                    <?= Helper::viewPaginacao($oLogTransacao->pagination->getPaginators()) ?>

                </div>
                <div class="clear"></div>
            </div>
            <!-- DIV FOOTER-->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/footer.inc.php"); ?>

        </div>
    </body>
</html>


