<?php
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] != "POST")
	return;

$success = false;

if (!isset($_GET['id']) || !isset($_POST['comment']) || $_POST['comment'] === '' || $_GET['id'] === '')
	return "Dados insuficientes";

session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

if (!isset($_SESSION['id']))
	return "Você não está logado";

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	return "Erro ao abrir o banco";

if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$_GET['id']]))
	die($conexao->error);

if ($res->num_rows === 0)
	return "Não há post com esse id";

if (!$res = $conexao->execute_query("INSERT INTO Comentarios VALUES (?, ?, ?, ?) ", [NULL, $_GET['id'], $_SESSION['id'], $_POST['comment']]))
	die($conexao->error);

$success = true;
$conexao->close();
return "Enviado com sucesso";
?>
