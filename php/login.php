<?php
# Espera que uma variável cookie_support estará setada.
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] != "POST")
	return;

$success = false;

if (!$cookie_support)
	return "Habilite os cookies";

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	return "Erro ao abrir o banco.";

if (!isset($_POST['email']) || !isset($_POST['senha']))
	return "Preencha todos os campos";

if (!$res = $conexao->execute_query("SELECT senha, id FROM Usuarios WHERE email = ?", [$_POST['email']]))
	return $conexao->error;

if ($res->num_rows === 0)
	return "Email não cadastrado";

$res = $res->fetch_assoc();

if ($res['senha'] != hash('sha256', $_POST['senha']))
	return "Senha errada";

if (!session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]))
	return "Erro inicializando sessão";

$_SESSION['id'] = $res['id'];

$success = true;
return  "Logado com sucesso";

$conexao->close();
?>
