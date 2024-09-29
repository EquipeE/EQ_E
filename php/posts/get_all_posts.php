<?php
require_once __DIR__ . '/../db.php';

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	die("Erro ao abrir o banco.");

if (!$res = $conexao->query("SELECT titulo, imagem, id FROM Posts ORDER BY id DESC"));
	die($conexao->error);

$res = $res->fetch_all(MYSQLI_BOTH);

foreach($res as $r)
	echo "<a href='./post.php?id={$r['id']}'><div class='card'><img src='../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>";

$conexao->close();
?>
