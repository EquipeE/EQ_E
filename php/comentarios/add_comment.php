<?php
require_once __DIR__ . '/../db.php';

if (!isset($_POST['post_id']) || !isset($_POST['comment']) || $_POST['comment'] === '' || $_POST['post_id'] === '')
	die("Dados insuficientes.");

session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

if (!isset($_SESSION['id']))
	die("Você não está logado.");

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	die("Erro ao abrir o banco.");

if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$_POST['id']]))
	die($conexao->error);

if ($res->num_rows === 0)
	die("Não há post com esse id");

if (!$res = $conexao->execute_query("INSERT INTO Comentarios VALUES (?, ?, ?, ?) ", [NULL, $_POST['post_id'], $_SESSION['id'], $_POST['comment']]))
	die($conexao->error);

echo "Comentário enviado com sucesso.";

$conexao->close();
?>
