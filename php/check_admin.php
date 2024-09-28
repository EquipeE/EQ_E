<?php
session_start();

require_once 'db.php';

$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$conexao)
	die("Erro ao abrir o banco.");

$res = $conexao->query("SELECT senha FROM Usuarios WHERE id = 1")->fetch_assoc(); 

if ($_SESSION['senha'] !== $res['senha'] || $_SESSION['id'] !== 1) {
	header("Location: ./../index.html");
	die();
}

$conexao->close();
?>
