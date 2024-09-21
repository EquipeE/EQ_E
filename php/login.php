<?php
if ($_SERVER['REQUEST_METHOD'] != "POST")
	die();
if (!isset($_POST['email']) || !isset($_POST['senha']))
	die("Preencha todos os campos.\n");

include("db.php");

$res = $conexao->execute_query("SELECT senha, id FROM Usuarios WHERE email = ?", [$_POST['email']])->fetch_assoc();

if (!$res)
	die("Esse email não está cadastrado.\n");
if ($res['senha'] != hash('sha256', $_POST['senha']))
	die("Senha errada.\n");
/*
if (!session_start())
	die("Erro ao inicializar a sessão.\n");

$_SESSION['id'] = $res['id'];
*/
$conexao->close();
?>
