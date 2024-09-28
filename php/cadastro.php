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
if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha']))
	err_wrapper("Preencha todos os campos");

if (strlen($_POST['nome']) > MAX_NAME_LENGTH || strlen($_POST['email']) > MAX_EMAIL_LENGTH)
	err_wrapper("Dados muito longos");

$res = $conexao->execute_query("SELECT * FROM Usuarios WHERE email = ?", [$_POST['email']]);

if ($res->num_rows > 0) 
	err_wrapper("Email já cadastrado");  

$senha = hash('sha256', $_POST['senha']);
$res = $conexao->execute_query("INSERT INTO Usuarios VALUE (?, ?, ?, ?)", [NULL, $_POST['nome'], $_POST['email'], $senha]);

if (!$res)
	err_wrapper($conexao->error);

if (!session_start())
	err_wrapper("Erro ao inicializar a sessão");

$res = $conexao->execute_query("SELECT * FROM Usuarios WHERE email = ?", [$_POST['email']]);

if (!$res)
	err_wrapper($conexao->error);

$_SESSION['id'] = $res->fetch_assoc()['id'];
$_SESSION['senha'] = $senha;

echo "<div id='resultado'><strong>Cadastrado com sucesso!</strong></div>";

$conexao->close();
?>
