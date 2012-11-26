<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");

$oAuth = new Auth();
$oSession = new Session();


$request = Helper::PostGet();
$sOP = $request["sOP"];

switch ($sOP) {

    case "logar":
        $sHeader = "index.php";

        if (!empty($_POST["login"]) && !empty($_POST["senha"])) {

            $oAuth->setTableName("usu_usuario")
                    ->setUserCollum("login")
                    ->setPassCollum("senha")
                    ->setUser($_POST["login"])
                    ->setPass($_POST["senha"]);

            if ($oAuth->login()) {
                $idrole = $oAuth->userData()->id_grupo;
                $oAclSetup = new Acl_Setup($idrole);
                $oSession->createSession("oAcl", $oAclSetup->getAcl());
                $sHeader = "/controle/inicio.php";
            } else {
                Session::getInstance()->flashMessenger(array("erro" => "Não foi possível autenticar o usuário, login e senha inválidos!"));
            }
        } else {
            Session::getInstance()->flashMessenger(array("erro" => "Preencha os campos corretamente!"));
        }
        break;
    case "logout":
        $sHeader = "/controle/index.php";
        Session::getInstance()->deleteSession("oAcl");
        $oAuth->logout();
        break;
}

header("location:" . $sHeader);
?>
