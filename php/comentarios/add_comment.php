<?php
session_start();
if (!isset($_SESSION['id']))
	die("Você não está logado.");
if (!isset($_POST['post_id']) || !isset($_POST['comment']))
	die("Dados insuficientes.");

include(__DIR__ . '/../db.php');
$res = $conexao->execute_query("INSERT INTO Comentarios VALUES (?, ?, ?, ?) ", [NULL, $_POST['post_id'], $_SESSION['id'], $_POST['comment']]);

if (!$res)
	die($conexao->error);

echo "Comentário enviado com sucesso.";

$conexao->close();
?>
