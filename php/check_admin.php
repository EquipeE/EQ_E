<?php
session_start();

include_once(__DIR__ . "/db.php");

$res = $conexao->query("SELECT senha FROM Usuarios WHERE id = 1")->fetch_assoc(); 
if ($_SESSION['admin'] !== $res['senha'])
	header("Location: ./../index.html");
$conexao->close();
?>
