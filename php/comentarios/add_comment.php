<?php
if (!isset($_POST['post_id']) || !isset($_POST['comment']))
	die("Dados insuficientes.");

session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['senha']))
	die("Você não está logado.");

include(__DIR__ . '/../db.php');

$res = $conexao->execute_query("SELECT senha FROM Usuarios WHERE id = ?", [$_SESSION['id']]);

if (!$res)
	die($conexao->error);

$res = $res->fetch_assoc();

if ($res['senha'] !== $_SESSION['senha'])
	die("Você não está logado.");

$res = $conexao->execute_query("INSERT INTO Comentarios VALUES (?, ?, ?, ?) ", [NULL, $_POST['post_id'], $_SESSION['id'], $_POST['comment']]);

if (!$res)
	die($conexao->error);

echo "Comentário enviado com sucesso.";

$conexao->close();
?>
