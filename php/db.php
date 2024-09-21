<?php

define("MAX_NAME_LENGTH", 100);
define("MAX_EMAIL_LENGTH", 100);
define("MAX_TITLE_LENGTH", 100);
define("MAX_IMAGE_PATH_LENGTH", 100);

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "mredes";

$conexao = new mysqli($servidor,$usuario,$senha,$dbname);
?>
