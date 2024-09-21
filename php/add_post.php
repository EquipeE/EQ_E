#!/usr/bin/env php
<?php
if ($argc != 4)
	die("Uso: ./add_post.php [titulo] [imagem] [conteudo]\n");

include('db.php');

if (strlen($argv[1]) > MAX_TITLE_LENGTH || strlen($argv[2]) > MAX_IMAGE_PATH_LENGTH)
	die("Seu titulo ou caminho da imagem são muito longos. O limite é de {MAX_TITLE_LENGTH} caracteres.\n");
if (!file_exists("../img/{$argv[2]}"))
	die("A imagem {$argv[2]} não existe.\n");
if (!file_exists($argv[3]))
	die("O arquivo de conteudo {$argv[3]} não existe.\n");


$conteudo = file_get_contents($argv[3]);
if (!$conteudo)
	die("Erro lendo o arquivo de counteúdo {$argv[3]}.\n");

$conteudo = str_replace("\n", "<br>", $conteudo);

$res = $conexao->execute_query("INSERT INTO Posts VALUES (?, ?, ?, ?)", [NULL, $argv[1], $argv[2], $conteudo]); 

if (!$res)
	die($conexao->error);

/*
$res = "SELECT * FROM Posts ORDER BY id ASC COUNT 4"->fetch_all(MYSQLI_BOTH);

if (!$res)
	die($conexao.error);

$carrosselText = "";
$cardsText = "";

foreach ($res as $r)
	$carrosselText += '<div class="slide"><img src=' . './posts/' . $r['imagem'] . ' ></div>' . "\n";

foreach ($res as $)
	$cardsText += '<div class="card"><img src="' . './posts' . $r['imagem'] . ' ><div class="card-text">' . $r['titulo'] . '</div></div>' . "\n";

echo $carrosselText;
echo $cardsText;
 */
$conexao->close();
?>
