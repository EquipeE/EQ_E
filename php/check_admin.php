<?php
session_start();

include_once(__DIR__ . "/db.php");

$res = $conexao->query("SELECT senha FROM Usuarios WHERE id = 1")->fetch_assoc(); 
if ($_SESSION['senha'] !== $res['senha'] || $_SESSION['id'] !== 1)
	header("Location: ./../index.html");
$conexao->close();
?>
