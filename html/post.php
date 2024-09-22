<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="./../css/nav.css">
    <link rel="stylesheet" href="./../css/post.css">
    <link rel="website icon" type="img" href="./../img/logo.png">
</head>
<body>
    <nav>
        <a href='./../index.html'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
        <ul class="menu">
            <li><a id="" href="./../index.html">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a href="current-page">Blog</a></li>
            <li class="drop">
                <a href="#">Conta</a>
                <ul class="conteudo">
                    <li><a href="./login.html">Login</a></li>
                    <li><a href="./cadastro.html">Cadastro</a></li>
                </ul>    
            </li>
        </ul>
    </nav><br>
    <section id="post-header">
	    <?php include("../php/posts/get_post_header.php") ?>
    </section>
    <main>
	    <?php include("../php/posts/get_post.php") ?>
    </main>
    <section id="ultimas-postagens">
	<h3>Ultimas postagens</h3>
	<div id="cards-container">
		<!--
		<div class="card"><img src="./../img/posts/art2.png"><div class="card-text">Eis aqui um titulo de tamanho normal.</div></div>
		<div class="card"><img src="./../img/posts/art3.png"><div class="card-text">Top 10 melhores opções de micro-redes atualmente.</div></div>
		-->
		<?php include("../php/posts/get_last_posts.php") ?>
	</div>
    </section>
    <section id="comentarios-container">
	<h3>Comentários</h3>
	<div id="comentarios">
		<div class="comentario"><h4>Jonathan disse:</h4>Sei lá cara acho que tu devia se matar namoral, que texto bosta.</div>
		<div class="comentario"><h4>Kaio disse:</h4>Top.</div>
	</div>
    </section>
</body>
</html>
