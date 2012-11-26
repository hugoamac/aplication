<?php

if (!Auth::getInstance()->checkLogin()) {

    header("Location:/error/index.php");
    exit;
}

$oAcl = Session::getInstance()->selectSession('oAcl');
$role = Auth::userData()->role;
?>
