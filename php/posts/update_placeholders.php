<?php
$res = $conexao->query("SELECT * FROM Posts ORDER BY id DESC")->fetch_all(MYSQLI_BOTH);

if (!$res)
	die($conexao->error);

$blogText = "";
$carrosselText = "";
$cardsText = "";

foreach($res as $r)
	$blogText .= "<a href='./post.php?id={$r['id']}'><div class='card'><img src='./../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>\n";

$res = array_slice($res, 0, 4); /* Cards no index usam os primeiros 4 posts */

foreach($res as $r)
	$cardsText .= "<a href='./html/post.php?id={$r['id']}'><div class='card'><img src='./img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>\n";

array_pop($res); /* Carrossel usa apenas 3 posts */

foreach($res as $r)
	$carrosselText .= "<div class='slide'><a href='./html/post.php?id={$r['id']}'><img src='./img/posts/{$r['imagem']}'></a></div>\n";

$template = file_get_contents(__DIR__ . "/../../html/templates/index_template.html");
$final = str_replace("!!!CARROSSEL", $carrosselText, str_replace("!!!CARDS", $cardsText, $template));

if (!file_put_contents(__DIR__ . "/../../index.html", $final))
	die("Erro gerando index.html");

$template = file_get_contents(__DIR__ . "/../../html/templates/blog_template.html");
$final = str_replace("!!!BLOG", $blogText, $template);

if (!file_put_contents(__DIR__ . "/../../html/blog.html", $final))
	die("Erro gerando blog.html");
?>
