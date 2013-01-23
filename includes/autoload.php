<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);

session_start();

define("BANCO", "LOCAL");
define("HOST", "localhost");
define("DATABASE", "paulo");
define("USER", "root");
define("PASS", "lordswxp");



function __autoload($class) {

    $path = $_SERVER["DOCUMENT_ROOT"] . "/classes";
    $recursive = new RecursiveDirectoryIterator($path);
    $iterator = new RecursiveIteratorIterator($recursive);

    foreach ($iterator as $i) {

        if ($i->isFile()) {
            $dir = dirname($i->getFileinfo());
            if (is_file($dir . "/" . $class . ".php")) {

                require_once($dir . "/" . $class . ".php");
            }
        }
    }
}

$excessao = array();
$_POST = Helper::filtroHTTP($_POST, $excessao);
$_GET = Helper::filtroHTTP($_GET, $excessao);


?>
