<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] != "POST")
	return;

$success = false;

if (!$cookie_support)
	return "Habilite os cookies";

if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha'])
	|| $_POST['nome'] === '' || $_POST['email'] === '' || $_POST['senha'] === '')
	return "Preencha todos os campos";

if (strlen($_POST['nome']) > MAX_NAME_LENGTH || strlen($_POST['email']) > MAX_EMAIL_LENGTH)
	return "Dados muito longos";

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	return "Email invalido";

if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
	return "Erro no banco de dados";

if (!$res = $conexao->execute_query("SELECT * FROM Usuarios WHERE email = ?", [$_POST['email']]))
	return $conexao->error;

if ($res->num_rows > 0) 
	return "Email já cadastrado";

$senha = hash('sha256', $_POST['senha']);
if (!$res = $conexao->execute_query("INSERT INTO Usuarios VALUE (?, ?, ?, ?)", [NULL, $_POST['nome'], $_POST['email'], $senha]))
	return $conexao->error;

if (!session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]))
	return "Erro ao inicializar a sessão";

if (!$res = $conexao->execute_query("SELECT * FROM Usuarios WHERE email = ?", [$_POST['email']]))
	return $conexao->error;

$_SESSION['id'] = $res->fetch_assoc()['id'];

$success = true;
return "Cadastrado com sucesso!";

$conexao->close();
?>
