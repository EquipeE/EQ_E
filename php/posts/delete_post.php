#!/usr/bin/env php
<?php
if ($argc != 2) 
	die("Uso: ./add_post.php [id]\n");

include(__DIR__ . '/../db.php');

$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$argv[1]]);

if (!$res)
	die($conexao->error);
if (!$res->fetch_assoc())
	die("Não há post com esse id.\n");

$res = $conexao->execute_query("DELETE FROM Comentarios WHERE id_post = ?", [$argv[1]]);

if (!$res)
	die($conexao->error);

$res = $conexao->execute_query("DELETE FROM Posts WHERE id = ?", [$argv[1]]);

if (!$res)
	die($conexao->error);

include(__DIR__ . "/update_placeholders.php");

$conexao->close();
?>
