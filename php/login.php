<?php
setcookie("test", "test", time() + 120);
if (count($_COOKIE) === 0)
	die("Habilite os cookies em seu navegador.");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] != "POST")
	die();
if (!isset($_POST['email']) || !isset($_POST['senha']))
	die("Preencha todos os campos.\n");

include_once(__DIR__ . "/db.php");

$res = $conexao->execute_query("SELECT senha, id FROM Usuarios WHERE email = ?", [$_POST['email']])->fetch_assoc();

if (!$res)
	die("Esse email não está cadastrado.\n");
if ($res['senha'] != hash('sha256', $_POST['senha']))
	die("Senha errada.\n");

if (!session_start())
	die("Erro ao inicializar a sessão.\n");

$_SESSION['id'] = $res['id'];
$_SESSION['senha'] = $res['senha'];

echo "Logado com sucesso.";

$conexao->close();
?>
