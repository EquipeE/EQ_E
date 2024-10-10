<?php
require_once __DIR__ . '/../db.php';

function update_placeholders() {
	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		return "Erro ao abrir o banco.";

	if (!$res = $conexao->query("SELECT * FROM Posts ORDER BY id DESC")->fetch_all(MYSQLI_BOTH))
		die($conexao->error);

	$blogText = "";
	$carrosselText = "";
	$cardsText = "";

	foreach($res as $r)
		$blogText .= "<a href='./post.php?id={$r['id']}'><div class='card blurred-card'><img src='./../img/posts/{$r['imagem']}'><div class='card-text'>{$r['titulo']}</div></div></a>\n";

	foreach($res as &$r)
		$r['conteudo'] = explode("<br>", $r['conteudo'], 2)[0];

	unset($r);

	$res = array_slice($res, 0, 4); /* Cards no index usam os primeiros 4 posts */

	foreach($res as $r)
		$cardsText .= "<div class='card blurred-card'><a href='./html/post.php?id={$r['id']}'><img src='./img/posts/{$r['imagem']}'><div class='card-text'><h3 id='titulo'>{$r['titulo']}</h3><p id='conteudo'>{$r['conteudo']}</p></div></div></a>\n";

	array_pop($res); /* Carrossel usa apenas 3 posts */

	foreach($res as $r)
		$carrosselText .= "<div class='slide'><a href='./html/post.php?id={$r['id']}' title='{$r['titulo']}'><img src='./img/posts/{$r['imagem']}'></a></div>\n";

	$template = file_get_contents(__DIR__ . "/../../html/templates/index_template.php");
	$final = str_replace("!!!CARROSSEL", $carrosselText, str_replace("!!!CARDS", $cardsText, $template));

	if (!file_put_contents(__DIR__ . "/../../index.php", $final))
		return "Erro gerando index.php";

	chown(__DIR__ . "/../../index.php", "apache");

	$template = file_get_contents(__DIR__ . "/../../html/templates/blog_template.php");
	$final = str_replace("!!!BLOG", $blogText, $template);

	if (!file_put_contents(__DIR__ . "/../../html/blog.php", $final))
		return "Erro gerando blog.php";

	chown(__DIR__ . "/../../html/blog.php", "apache");
}

function add_post($titulo, $img, $conteudo) {
	if (strlen($titulo) > MAX_TITLE_LENGTH || strlen($img) > MAX_IMAGE_PATH_LENGTH)
		return "Dados muito longos";
	if (!file_exists(__DIR__ . "/../../img/posts/{$img}"))
		return "A imagem {$img} não existe";
	if (!file_exists($conteudo))
		return "O arquivo {$argv[3]} não existe";

	if (!$cont = file_get_contents($conteudo))
		return "Erro lendo o arquivo {$conteudo}";

	$cont = str_replace("\n", "<br>", $cont);

	if (strlen($cont) > MAX_POST_LENGTH)
		return "Dados muito longos";

	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		return "Erro ao abrir o banco";

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE titulo = ?", [$titulo]))
		die($conexao->error);

	if ($res->num_rows > 0)
		return "Titulo repetido";

	if (!$res = $conexao->execute_query("INSERT INTO Posts VALUES (?, ?, ?, ?)", [NULL, $titulo, $img, $cont]))
		die($conexao->error);

	$conexao->close();
	echo update_placeholders() . "\n";
	unlink($conteudo);

	return "Adicionado com sucesso";
}

function update_post($id, $titulo, $img, $conteudo) {
	if (strlen($titulo) > MAX_TITLE_LENGTH || strlen($img) > MAX_IMAGE_PATH_LENGTH)
		return "Dados muito longos";
	if (!file_exists(__DIR__ . "/../../img/posts/{$img}"))
		return "A imagem {$img} não existe";
	if (!file_exists($conteudo))
		return "O arquivo {$conteudo} não existe";

	if (!$cont = file_get_contents($conteudo))
		return "Erro lendo o arquivo {$conteudo}";

	$cont = str_replace("\n", "<br>", $cont);

	if (strlen($cont) > MAX_POST_LENGTH)
		return "Dados muito longos";

	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		return "Erro ao abrir o banco";

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$id]))
		die($conexao->error);

	if ($res->num_rows === 0)
		return "Não há post com esse id";

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE titulo = ?", [$titulo]))
		die($conexao->error);

	if ($res->num_rows > 0 && $res->fetch_assoc['id'] != $id)
		return "Titulo repetido";

	if (!$res = $conexao->execute_query("UPDATE Posts SET titulo = ?, imagem = ?, conteudo = ? WHERE id = ?", [$titulo, $img, $cont, $id]))
		die($conexao->error);

	$conexao->close();
	echo update_placeholders() . "\n";

	return "Atualizado com sucesso";
}

function delete_post($id) {
	if (!$conexao = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME))
		return "Erro ao abrir o banco";

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE id = ?", [$id]))
		die($conexao->error);
	if (!$res = $res->fetch_assoc())
		return "Não há post com esse id";

	$post_img = $res['imagem'];

	if (!$res = $conexao->execute_query("SELECT * FROM Posts WHERE imagem = ?", [$post_img]))
		die($conexao->error);
	if ($res->num_rows === 1)
		unlink(__DIR__ . "/../../img/posts/{$post_img}");

	if (!$res = $conexao->execute_query("DELETE FROM Comentarios WHERE id_post = ?", [$id]))
		die($conexao->error);
	if (!$res = $conexao->execute_query("DELETE FROM Posts WHERE id = ?", [$id]))
		die($conexao->error);

	$conexao->close();
	echo update_placeholders() . "\n";

	return "Apagado com sucesso";
}
?>
