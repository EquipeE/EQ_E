<?php
setcookie("test", "test", time() + 60);
if (count($_COOKIE) === 0)
	die("Habilite os cookies em seu navegador.");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] != "POST")
	die();
if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha']))
	die("Preencha todos os campos.\n");

include(__DIR__ . "/db.php");

if (strlen($_POST['nome']) > MAX_NAME_LENGTH || strlen($_POST['email']) > MAX_EMAIL_LENGTH)
	die("Seu nome e/ou email são muito longos, o limite é de {$MAX_EMAIL_LENGTH} caracteres.");

$res = $conexao->execute_query("SELECT * FROM Usuarios WHERE email = ?", [$_POST['email']]);

if ($res->num_rows > 0) 
	die("Email já cadastrado\n");  

$senha = hash('sha256', $_POST['senha']);
$res = $conexao->execute_query("INSERT INTO Usuarios VALUE (?, ?, ?, ?)", [NULL, $_POST['nome'], $_POST['email'], $senha]);

if (!$res)
	die($conexao->error);

if (!session_start())
	die("Erro ao inicializar a sessão.\n");

$_SESSION['id'] = $res['id'];
if (isset($_SESSION['admin']))
	$_SESSION['admin'] = "";


echo "Cadastrado com sucesso!";

$conexao->close();
?>
