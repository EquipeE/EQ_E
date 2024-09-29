<?php
require_once 'validar_imagem.php';
require_once 'crud_post.php';
$index_path = "../../index.html";
include __DIR__ . '/../check_admin.php';

if (!isset($_POST['titulo']) || !isset($_POST['conteudo']) || !isset($_FILES['imagem'])
	|| $_POST['titulo'] === '' || $_POST['conteudo'] === '' || $_FILES['imagem']['size'] === 0)
	die("Dados insuficientes. Todos os campos devem ser preenchidos.\n");


if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK)
	die("Erro enviando imagem.\n");

if (!validar_imagem($_FILES['imagem']['tmp_name']))
	die("O arquivo não é uma imagem.\n");

$ext = explode('/', finfo_file(finfo_open(FILEINFO_EXTENSION), $_FILES['imagem']['tmp_name']))[0];
$image_filename = __DIR__ . "/../../img/posts/" . hash_file('sha256', $_FILES['imagem']['tmp_name']) . '.' . $ext;

if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $image_filename))
	die("Erro enviando imagem.\n");

$content_filename = __DIR__ . "/../../txt/" . hash('sha256', $_POST['titulo']) . ".txt";
	
if (!file_put_contents($content_filename, $_POST['conteudo']))
	die("Erro criando arquivo de conteudo.\n");

echo update_post($_POST['id'], $_POST['titulo'], basename($image_filename), $content_filename);
?>
