<?php
if (!isset($_GET['id']))
	die();

include('../php/db.php');
$res = $conexao->execute_query("SELECT conteudo FROM Posts WHERE id = ?", [$_GET['id']]);
if (!$res)
	die($conexao->error);
$res = $res->fetch_assoc();
echo $res['conteudo'];
$conexao->close();
?>
