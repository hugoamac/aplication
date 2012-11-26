<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php");

$request = Helper::PostGet();
$sOP = $request["sOP"];


switch ($sOP) {

    case "ApagarTransacao":
        $id = (INT) $request["id"];
        $response = array('status' => 'erro');
        $bResultado = RecursoTransacao::getInstance()->delete(array('id' => $id));
        if ($bResultado) {
            $response = array('status' => 'sucesso');
        }
        header("Content-type:application/json");
        echo json_encode($response);

        break;
}
?>
