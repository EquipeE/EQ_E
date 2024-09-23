#!/usr/bin/env php
<?php
if ($argc != 5) 
	die("Uso: ./add_post.php [id] [novo titulo] [nova imagem] [novo conteudo]\n");

include(__DIR__ . '/../db.php');

if (strlen($argv[2]) > MAX_TITLE_LENGTH || strlen($argv[3]) > MAX_IMAGE_PATH_LENGTH)
	die("Seu titulo ou caminho da imagem são muito longos. O limite é de {MAX_TITLE_LENGTH} caracteres.\n");
if (!file_exists(__DIR__ . "/../../img/posts/{$argv[3]}"))
	die("A imagem {$argv[3]} não existe.\n");
if (!file_exists($argv[4]))
	die("O arquivo de conteudo {$argv[4]} não existe.\n");

$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$argv[1]]);

if (!$res)
	die($conexao->error);
if (!$res->fetch_assoc())
	die("Não há post com esse id.\n");

$conteudo = file_get_contents($argv[4]);
if (!$conteudo)
	die("Erro lendo o arquivo de counteúdo {$argv[4]}.\n");

$conteudo = str_replace("\n", "<br>", $conteudo);

$res = $conexao->execute_query("UPDATE Posts SET titulo = ?, imagem = ?, conteudo = ? WHERE id = ?", [$argv[2], $argv[3], $conteudo, $argv[1]]); 

if (!$res)
	die($conexao->error);

include(__DIR__ . "/update_placeholders.php");

$conexao->close();
?>
