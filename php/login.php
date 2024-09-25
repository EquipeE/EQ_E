<?php
function err_wrapper($str) {
	die("<div id='resultado-erro'><strong>{$str}</strong></div>");
}
?>

<?php
setcookie("test", "test", time() + 120);
if (count($_COOKIE) === 0)
	err_wrapper("Habilite os cookies");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] != "POST")
	die();
if (!isset($_POST['email']) || !isset($_POST['senha']))
	err_wrapper("Preencha todos os campos\n");

include_once(__DIR__ . "/db.php");

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
