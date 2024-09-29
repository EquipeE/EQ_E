<?php
require_once __DIR__ . '/../db.php';

if (!isset($_GET['id']))
	die();

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	die("Erro ao abrir o banco.");

if (!$res = $conexao->execute_query("SELECT conteudo FROM Posts WHERE id = ?", [$_GET['id']]))
	die($conexao->error);

$res = $res->fetch_assoc();

echo $res['conteudo'];

$conexao->close();
?>
