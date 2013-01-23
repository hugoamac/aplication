<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();


$bVisualizar = $oAcl->isAllowed($role, "Log", "Visualizar");


if (!$bVisualizar) {
    header("Location:/error/index.php");
    exit;
}

$onde = $request ? $request : array();
$oLogTransacao = new LogTransacao();

//$vvLogTransacao = $oLogTransacao->paginator(array(), array(), "data_criacao desc");
$vvLogTransacao = $oLogTransacao->Pesquisar($onde);
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

                    <form method="get" action="" class="Filtro">
                        <h3>Pesquisar</h3>
                        <table>
                            <tr>
                                <th>Usuário:</th>
                                <td>
                                    <select name="id_usuario">
                                        <? if ($usuarios = Usuario::getInstance()->findAll(array(), array(), 'nome')): ?>
                                            <option value="">Selecione</option>
                                            <? foreach ($usuarios as $usuario): ?>
                                                <option value="<?= $usuario['id'] ?>" <?= Helper::selected($usuario['id'], $request['id_usuario']) ?>><?= $usuario['nome'] ?></option>
                                            <? endforeach; ?>
                                        <? else: ?>
                                            <option value="">Nenhum usuário registrado</option>
                                        <? endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Período:</th>
                                <td>
                                    <input type="text" name="data_inicial" value="<?= $request['data_inicial'] ? $request['data_inicial'] : "" ?>" class="data"/><br/>
                                    <input type="text" name="data_final" value="<?= $request['data_final'] ? $request['data_final'] : "" ?>" class="data"/><br/>
                                </td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td>&nbsp;</td>                                    
                            </tr>
                            <tr>
                                <th><input type="hidden" name="sOP" value="Pesquisar"/></th>
                                <td><button type="submit">Pesquisar</button></td>                                    
                            </tr>
                        </table>                        
                    </form>

                    <br/>
                    <? if ($request["sOP"]): ?>
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
                    <? endif; ?>

                </div>
                <div class="clear"></div>
            </div>
            <!-- DIV FOOTER-->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/footer.inc.php"); ?>

        </div>
    </body>
</html>


