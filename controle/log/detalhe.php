<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();

$id = isset($request["id"]) ? (INT) $request["id"] : "";

$bPermissao = $oAcl->isAllowed($role, "Log", "Visualizar");

if (!$bPermissao) {
    header("Location:/error/index.php");
    exit;
}

$oLogTransacao = new LogTransacao();
$vsLogTransacao = $oLogTransacao->find(array("id" => $id));
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
                        <li><a href="<?= $_SERVER["HTTP_REFERER"] ?>">Log do Sistema</a></li>
                        <li><?= $sOP ?> Log</li>   
                    </ul>

                    <h1>Log do Sistema</h1>

                    <br/>
                    <form class="Form">
                        <table>

                            <tr>
                                <th>Operação</th>
                                <td><?= LogOperacao::getInstance()->getOperacao($vsLogTransacao["id_log_operacao"]) ?></td>
                            </tr>
                            <tr>
                                <th>Usuário</th>
                                <td><?= Usuario::getInstance()->getNome($vsLogTransacao["id_usuario"]) ?></td>
                            </tr>
                            <tr>
                                <th>Tabela</th>
                                <td><?= $vsLogTransacao["tabela"] ?></td>
                            </tr>
                            <tr>
                                <th>Descrição</th>
                                <td><?= nl2br($vsLogTransacao["descricao"]) ?></td>
                            </tr>
                            <tr>
                                <th>Data de Criação</th>
                                <td><?= Helper::formatData("d/m/Y H:i:s", $vsLogTransacao["data_criacao"]) ?></td>
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


