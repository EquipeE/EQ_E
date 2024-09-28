<?php
require_once 'crud_post.php';
if (!isset($_POST['titulo']) || !isset($_POST['conteudo']) || !isset($_FILES['imagem']))
	die("Dados insuficientes\n");

if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK)
	die("Erro enviando imagem.");

$image_filename = __DIR__ . "/../../img/posts/" . basename($_FILES['imagem']['name']);

if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $image_filename))
	die("Erro enviando imagem");

$content_filename = __DIR__ . "/../../txt/" . hash('sha256', $_POST['titulo']) . ".txt";
	
if (!file_put_contents($content_filename, $_POST['conteudo']))
	die("Erro criando arquivo de conteudo");

echo add_post($_POST['titulo'], basename($_FILES['imagem']['name']), $content_filename);
?>
