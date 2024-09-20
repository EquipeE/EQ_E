<?php

include("db.php");

if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha']))
	die("Falta informação");

$email = $_POST['email'];
$sql = "SELECT * FROM usuarios WHERE email='$email'";
$resultado = $conexao->execute_query($sql);

if ($resultado->num_rows > 0) 
	die("<script>alert('Email já cadastrado');</script>");  


$senha = hash('sha256', $_POST['senha']);
$result = $conexao->execute_query("INSERT INTO usuarios VALUE (?, ?, ?, ?)", ["NULL", $_POST['nome'], $_POST['email'], $senha]);

if (!$result)
	die($conexao->error);
echo "Sucesso!";


$conexao->close();
?>