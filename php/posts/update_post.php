<?php
require_once 'validar_imagem.php';
require_once 'crud_post.php';
$index_path = "../../index.html";
include __DIR__ . '/../check_admin.php';

$success = false;

if (!isset($_POST['titulo']) || !isset($_POST['conteudo']) || !isset($_FILES['imagem'])
	|| $_POST['titulo'] === '' || $_POST['conteudo'] === '' || $_FILES['imagem']['size'] === 0)
	return "Dados insuficientes. Todos os campos devem ser preenchidos";


if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK)
	return "Erro enviando imagem";

if (!validar_imagem($_FILES['imagem']['tmp_name']))
	return "O arquivo não é uma imagem";

$ext = explode('/', finfo_file(finfo_open(FILEINFO_EXTENSION), $_FILES['imagem']['tmp_name']))[0];
$image_filename = __DIR__ . "/../../img/posts/" . hash_file('sha256', $_FILES['imagem']['tmp_name']) . '.' . $ext;

if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $image_filename))
	return "Erro enviando imagem";

$content_filename = __DIR__ . "/../../txt/" . hash('sha256', $_POST['titulo']) . ".txt";
	
if (!file_put_contents($content_filename, $_POST['conteudo']))
	return "Erro criando arquivo de conteudo";

$success = true;

return update_post($_POST['id'], $_POST['titulo'], basename($image_filename), $content_filename);
?>
