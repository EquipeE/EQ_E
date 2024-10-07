<?php
require_once 'db.php';

if (!isset($_GET['busca']) || $_GET['busca'] === '')
	return;

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	die("Erro ao abrir o banco.");

if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE MATCH(titulo, conteudo) AGAINST(?)", [$_GET['busca']]))
	die($conexao->error);

$res = $res->fetch_all(MYSQLI_BOTH);

foreach($res as $r)
	echo "<a href='./post.php?id={$r['id']}'><div class='card blurred-card'><img src='./../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>";

$conexao->close();
?>
