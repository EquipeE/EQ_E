<?php
$index_path = "./../index.php";
session_start();

require_once 'db.php';

$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$conexao)
	die("Erro ao abrir o banco.");

$res = $conexao->query("SELECT senha FROM Usuarios WHERE id = 1")->fetch_assoc(); 

$admin_path = (basename($_SERVER['PHP_SELF']) === "index.php") ? './html/admin.php' : 'admin.php';

if ($_SESSION['senha'] === $res['senha'] &&  $_SESSION['id'] === 1)
	echo "<li><a href='{$admin_path}'>Admin</a></li>";

$conexao->close();

?>
