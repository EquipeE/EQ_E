<?php
require_once 'db.php';

session_start();

$login_path = (basename($_SERVER['PHP_SELF']) === "index.php") ? './html/login.php' : 'login.php';
$logout_path = (basename($_SERVER['PHP_SELF']) === "index.php") ? './php/logout.php' : '../php/logout.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['senha'])) {
	echo "<li><a href='{$login_path}'>Login</a></li>";
} else  {
	$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$res = $conexao->execute_query("SELECT senha FROM Usuarios WHERE id = ?", [$_SESSION['id']]);
	if (!$res)
		die($conexao->error);

	$res = $res->fetch_assoc(); 

	if ($_SESSION['senha'] !== $res['senha'])
		echo "<li><a href='{$login_path}'>Login</a></li>";
	else
		echo "<li><a href='{$logout_path}'>Logout</a></li>";

	$conexao->close();
}
?>
