<?php
require_once __DIR__ . '/../db.php';

$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$conexao)
	die("Erro ao abrir o banco.");

$res = $conexao->query("SELECT titulo, imagem, id FROM Posts ORDER BY id DESC LIMIT 2");

if (!$res)
	die($conexao->error);
$res = $res->fetch_all(MYSQLI_BOTH);

foreach($res as $r)
	echo "<a href='./post.php?id={$r['id']}'><div class='card'><img src='../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>";

$conexao->close();
?>
