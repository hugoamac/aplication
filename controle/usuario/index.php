<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/verifica_usuario.php");

$request = Helper::PostGet();

$bVisualizar = $oAcl->isAllowed($role, "Usuários", "Visualizar");
$bAdicionar = $oAcl->isAllowed($role, "Usuários", "Adicionar");
$bEditar = $oAcl->isAllowed($role, "Usuários", "Editar");
$bApagar = $oAcl->isAllowed($role, "Usuários", "Apagar");

if (!$bVisualizar) {
    header("Location:/error/index.php");
    exit;
}


$oUsuario = new Usuario();

$vvUsuario = $oUsuario->findAll();
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
                        <li>Usuários</li>
                    </ul>

                    <h1>Usuários</h1>

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
                                <th>Grupo</th>
                                <th>Usuário</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? if ($vvUsuario): ?>
                                <? foreach ($vvUsuario as $vsUsuario): ?>
                                    <tr>
                                        <td><?= $vsUsuario["id"] ?></td>
                                        <td><?= Grupo::getInstance()->getGrupo($vsUsuario["id_grupo"]) ?></td>
                                        <td><?= $vsUsuario["nome"] ?></td>
                                        <td><?= $vsUsuario["email"] ?></td>
                                        <td><?= $vsUsuario["login"] ?></td>
                                        <td><img src="/images/comuns/<?= $vsUsuario["ativo"] ? "status_ok.png" : "status_error.png" ?>"/></td>
                                        <td>
                                            <? if ($bEditar): ?>
                                                <a href="form.php?id=<?= $vsUsuario["id"] ?>&sOP=Editar" class="Botao">Editar</a>
                                                <a href="processa.php?id=<?= $vsUsuario["id"] ?>&sOP=<?= $vsUsuario["ativo"] ? "Desativar" : "Ativar" ?>" class="Botao"><?= $vsUsuario["ativo"] ? "Desativar" : "Ativar" ?></a>
                                            <? endif; ?>
                                            <? if ($bApagar): ?>
                                                <a href="processa.php?id=<?= $vsUsuario["id"] ?>&sOP=Apagar" class="Apagar Botao">Apagar</a>
                                            <? endif; ?>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                            <? else: ?>
                                <tr>
                                    <td colspan="7">Ops ! nenhum registro encontrado.</td>
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

