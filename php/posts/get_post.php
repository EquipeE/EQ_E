<?php
require_once __DIR__ . '/../db.php';

$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$conexao)
	die("Erro ao abrir o banco.");

if (!isset($_GET['id']))
	die();

$res = $conexao->execute_query("SELECT conteudo FROM Posts WHERE id = ?", [$_GET['id']]);

if (!$res)
	die($conexao->error);
$res = $res->fetch_assoc();

echo $res['conteudo'];

$conexao->close();
?>
