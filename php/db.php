<?php
define("MAX_NAME_LENGTH", 100);
define("MAX_EMAIL_LENGTH", 100);
define("MAX_TITLE_LENGTH", 100);
define("MAX_IMAGE_PATH_LENGTH", 100);

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "mredes");

$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$conexao)
	die("Erro ao abrir o banco.");
?>
