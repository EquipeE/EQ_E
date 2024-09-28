<?php
require_once __DIR__ . '/../db.php';

function update_placeholders() {
	$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if (!$conexao)
		die("Erro ao abrir o banco.");

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

	$template = file_get_contents(__DIR__ . "/../../html/templates/index_template.php");
	$final = str_replace("!!!CARROSSEL", $carrosselText, str_replace("!!!CARDS", $cardsText, $template));

	if (!file_put_contents(__DIR__ . "/../../index.php", $final))
		die("Erro gerando index.php");

	chown(__DIR__ . "/../../index.php", "apache");

	$template = file_get_contents(__DIR__ . "/../../html/templates/blog_template.php");
	$final = str_replace("!!!BLOG", $blogText, $template);

	if (!file_put_contents(__DIR__ . "/../../html/blog.php", $final))
		die("Erro gerando blog.php");

	chown(__DIR__ . "/../../html/blog.php", "apache");
}

function add_post($titulo, $img, $conteudo) {
	$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if (!$conexao)
		die("Erro ao abrir o banco.");

	if (strlen($titulo) > MAX_TITLE_LENGTH || strlen($img) > MAX_IMAGE_PATH_LENGTH)
		die("Seu titulo ou caminho da imagem são muito longos. O limite é de {MAX_TITLE_LENGTH} caracteres.\n");
	if (!file_exists(__DIR__ . "/../../img/posts/{$img}"))
		die("A imagem {$img} não existe.\n");
	if (!file_exists($conteudo))
		die("O arquivo de conteudo {$argv[3]} não existe.\n");

	$cont = file_get_contents($conteudo);
	if (!$conteudo)
		die("Erro lendo o arquivo de counteúdo {$conteudo}.\n");

	$cont = str_replace("\n", "<br>", $cont);

	$res = $conexao->execute_query("INSERT INTO Posts VALUES (?, ?, ?, ?)", [NULL, $titulo, $img, $cont]); 

	if (!$res)
		die($conexao->error);

	update_placeholders();	

	$conexao->close();
}

function update_post($id, $titulo, $img, $conteudo) {
	$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if (!$conexao)
		die("Erro ao abrir o banco.");

	if (strlen($titulo) > MAX_TITLE_LENGTH || strlen($img) > MAX_IMAGE_PATH_LENGTH)
		die("Seu titulo ou caminho da imagem são muito longos. O limite é de {MAX_TITLE_LENGTH} caracteres.\n");
	if (!file_exists(__DIR__ . "/../../img/posts/{$img}"))
		die("A imagem {$img} não existe.\n");
	if (!file_exists($conteudo))
		die("O arquivo de conteudo {$conteudo} não existe.\n");

	$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$id]);

	if (!$res)
		die($conexao->error);
	if (!$res->fetch_assoc())
		die("Não há post com esse id.\n");

	$cont = file_get_contents($conteudo);
	if (!$cont)
		die("Erro lendo o arquivo de counteúdo {$conteudo}.\n");

	$cont = str_replace("\n", "<br>", $cont);

	$res = $conexao->execute_query("UPDATE Posts SET titulo = ?, imagem = ?, conteudo = ? WHERE id = ?", [$titulo, $img, $cont, $id]); 

	if (!$res)
		die($conexao->error);

	update_placeholders();
	$conexao->close();
}

function delete_post($id) {
	$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if (!$conexao)
		die("Erro ao abrir o banco.");

	$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$id]);

	if (!$res)
		die($conexao->error);
	if (!$res->fetch_assoc())
		die("Não há post com esse id.\n");

	$res = $conexao->execute_query("DELETE FROM Comentarios WHERE id_post = ?", [$id]);

	if (!$res)
		die($conexao->error);

	$res = $conexao->execute_query("DELETE FROM Posts WHERE id = ?", [$id]);

	if (!$res)
		die($conexao->error);

	update_placeholders();

	$conexao->close();
}
?>
