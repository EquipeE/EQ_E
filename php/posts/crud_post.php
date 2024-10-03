<?php
require_once __DIR__ . '/../db.php';

function update_placeholders() {
	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		die("Erro ao abrir o banco.");

	if (!$res = $conexao->query("SELECT * FROM Posts ORDER BY id DESC")->fetch_all(MYSQLI_BOTH))
		die($conexao->error);

	$blogText = "";
	$carrosselText = "";
	$cardsText = "";

	foreach($res as $r)
		$blogText .= "<a href='./post.php?id={$r['id']}'><div class='card'><img src='./../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>\n";

	foreach($res as &$r) 
		$r['conteudo'] = explode("<br>", $r['conteudo'], 2)[0];

	$res = array_slice($res, 0, 4); /* Cards no index usam os primeiros 4 posts */

	foreach($res as $r)
		$cardsText .= "<div class='card'><a href='./html/post.php?id={$r['id']}'><img src='./img/posts/{$r['imagem']}'><div class='card-text'><h3 id='titulo'>{$r['titulo']}</h3><p id='conteudo'>{$r['conteudo']}</p></div></div></a>\n";

	array_pop($res); /* Carrossel usa apenas 3 posts */

	foreach($res as $r)
		$carrosselText .= "<div class='slide'><a href='./html/post.php?id={$r['id']}' title='{$r['titulo']}'><img src='./img/posts/{$r['imagem']}'></a></div>\n";

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
	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		die("Erro ao abrir o banco.");

	if (strlen($titulo) > MAX_TITLE_LENGTH || strlen($img) > MAX_IMAGE_PATH_LENGTH)
		die("Seu titulo ou caminho da imagem são muito longos. O limite é de {MAX_TITLE_LENGTH} caracteres.\n");
	if (!file_exists(__DIR__ . "/../../img/posts/{$img}"))
		die("A imagem {$img} não existe.\n");
	if (!file_exists($conteudo))
		die("O arquivo de conteudo {$argv[3]} não existe.\n");

	if (!$cont = file_get_contents($conteudo))
		die("Erro lendo o arquivo de counteúdo {$conteudo}.\n");

	$cont = str_replace("\n", "<br>", $cont);

	if (!$res = $conexao->execute_query("INSERT INTO Posts VALUES (?, ?, ?, ?)", [NULL, $titulo, $img, $cont]))
		die($conexao->error);

	update_placeholders();	
	$conexao->close();
	unlink($conteudo);
}

function update_post($id, $titulo, $img, $conteudo) {
	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		die("Erro ao abrir o banco.");

	if (strlen($titulo) > MAX_TITLE_LENGTH || strlen($img) > MAX_IMAGE_PATH_LENGTH)
		die("Seu titulo ou caminho da imagem são muito longos. O limite é de {MAX_TITLE_LENGTH} caracteres.\n");
	if (!file_exists(__DIR__ . "/../../img/posts/{$img}"))
		die("A imagem {$img} não existe.\n");
	if (!file_exists($conteudo))
		die("O arquivo de conteudo {$conteudo} não existe.\n");

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$id]))
		die($conexao->error);
	if ($res->num_rows === 0)
		die("Não há post com esse id.\n");

	if (!$cont = file_get_contents($conteudo))
		die("Erro lendo o arquivo de counteúdo {$conteudo}.\n");

	$cont = str_replace("\n", "<br>", $cont);

	if (!$res = $conexao->execute_query("UPDATE Posts SET titulo = ?, imagem = ?, conteudo = ? WHERE id = ?", [$titulo, $img, $cont, $id]))
		die($conexao->error);

	update_placeholders();
	$conexao->close();
}

function delete_post($id) {
	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		die("Erro ao abrir o banco.");

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$id]))
		die($conexao->error);
	if (!$res = $res->fetch_assoc())
		die("Não há post com esse id.\n");

	$post_img = $res['imagem'];

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE imagem = ?", [$post_img]))
		die($conexao->error);
	if ($res->num_rows === 1)
		unlink(__DIR__ . "/../../img/posts/{$post_img}");

	if (!$res = $conexao->execute_query("DELETE FROM Comentarios WHERE id_post = ?", [$id]))
		die($conexao->error);
	if (!$res = $conexao->execute_query("DELETE FROM Posts WHERE id = ?", [$id]))
		die($conexao->error);

	update_placeholders();
	$conexao->close();
}
?>
