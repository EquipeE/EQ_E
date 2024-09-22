<?php
if (!isset($_GET['id']))
	die();
include('../php/db.php');
$res = $conexao->execute_query("SELECT titulo, imagem FROM Posts WHERE id = ?", [$_GET['id']]);
if (!$res)
	die($conexao->error);
$res = $res->fetch_assoc();
echo '<img src="../img/posts/' . $res['imagem'] . '"><h1>' . $res['titulo'] . '</h1>';

$conexao->close();
?>
