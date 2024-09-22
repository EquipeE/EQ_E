<?php
if (!isset($_GET['id']))
	die();
include('../php/db.php');
$res = $conexao->query("SELECT titulo, imagem, id FROM Posts ORDER BY id DESC LIMIT 2");

if (!$res)
	die($conexao->error);
$res = $res->fetch_all(MYSQLI_BOTH);

foreach($res as $r)
	echo "<a href='./post.php?id={$r['id']}'><div class='card'><img src='../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>";

$conexao->close();
?>
