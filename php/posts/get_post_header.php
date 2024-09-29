<?php
require_once __DIR__ . '/../db.php';

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	die("Erro ao abrir o banco.");

if (!isset($_GET['id']))
	die();

if (!$res = $conexao->execute_query("SELECT titulo, imagem FROM Posts WHERE id = ?", [$_GET['id']]))
	die($conexao->error);

$res = $res->fetch_assoc();

echo "<img src='../img/posts/{$res['imagem']}'><h1>{$res['titulo']}</h1>";

$conexao->close();
?>
