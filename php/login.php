<?php
function err_wrapper($str) {
	die("<div id='resultado-erro'><strong>{$str}</strong></div>");
}
?>

<?php
setcookie("test", "test", time() + 120);
if (!isset($_COOKIE['test']) && $_SERVER['REQUEST_METHOD'] === "POST")
	err_wrapper("Habilite os cookies");
?>

<?php
require_once 'db.php';

$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$conexao)
	die("Erro ao abrir o banco.");

if ($_SERVER['REQUEST_METHOD'] != "POST")
	die();
if (!isset($_POST['email']) || !isset($_POST['senha']))
	err_wrapper("Preencha todos os campos\n");

$res = $conexao->execute_query("SELECT senha, id FROM Usuarios WHERE email = ?", [$_POST['email']])->fetch_assoc();

if (!$res)
	err_wrapper("Email não cadastrado\n");
if ($res['senha'] != hash('sha256', $_POST['senha']))
	err_wrapper("Senha errada\n");

if (!session_start())
	err_wrapper("Erro inicializando sessão\n");

$_SESSION['id'] = $res['id'];
$_SESSION['senha'] = $res['senha'];

echo "<div id='resultado'><strong>Logado com sucesso</strong></div>";

$conexao->close();
?>
