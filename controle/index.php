<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Area de Acesso</title>
        <link href="/css/controle/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="BodyLogin">
            <? if (Session::getInstance()->getFlashMessenger()): ?>
            <p class="erro"><?= Session::getInstance()->getFlashMessenger()->erro; ?></p>
            <? endif; ?>

            <form method = "post" action = "processa.php" id = "form" class = "Form login">
                <h2 style = "text-align: center">Login</h2>
                <dl style = "text-align: center">
                    <dt><label for = "login">Login:</label></dt>
                    <dd><input type = "text" name = "login" value = ""/></dd>

                    <dt><label for = "senha">Senha:</label></dt>
                    <dd><input type = "password" name = "senha" value = ""/></dd>

                    <dt><input type = "hidden" name = "sOP" value = "logar"/><br/></dt>
                    <dd>
                        <button type = "submit">Logar</button>
                    </dd>
                </dl>
            </form>
        </div>
    </body>
</html>





