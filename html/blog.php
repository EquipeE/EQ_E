<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="./../css/nav.css">
    <link rel="stylesheet" href="./../css/blog.css">
    <link rel="website icon" type="img" href="./../img/logo.png">
</head>
<body>
    <nav>
        <a href='./../index.html'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
        <ul class="menu">
            <li><a href="./../index.html">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a id="current-page" href="./blog.php">Blog</a></li>
            <li class="drop">
                <a href="#">Conta</a>
                <ul class="conteudo">
                    <li><a href="./login.html">Login</a></li>
                    <li><a href="./cadastro.html">Cadastro</a></li>
                </ul>    
            </li>
        </ul>
    </nav><br>
    <h1>Todas as postagens</h1>
    <main>
	<!--
	<a href="./post.php?id=2"><div class="card"><img src="./../img/posts/art2.png"><div class="card-text">Eis aqui um titulo de tamanho normal.</div></div></a>
	<a href="./post.php?id=3"><div class="card"><img src="./../img/posts/art3.png"><div class="card-text">Top 10 melhores opções de micro-redes atualmente.</div></div></a>
	-->
	<?php include("../php/posts/get_all_posts.php") ?>
    </main>
</body>
</html>
