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
        <a href='./../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
        <ul class="menu">
            <li><a id="" href="./../index.php">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a id="current-page" href="./blog.php">Blog</a></li>
            <li><a href="./calc.php">Calculadora</a></li>
            <li class="drop">
                <a href="#">Conta</a>
		<ul class="conteudo">
		    <?php include '../php/dynamic_login_logout.php' ?>
                    <li><a href="cadastro.php">Cadastro</a></li>
		    <?php include '../php/admin_screen_button.php' ?>
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
		<?php include("../php/posts/get_last_posts.php") ?>
	</div>
    </section>
    <section id="comentarios-container">
	<h3>Comentários</h3>
	<form action="../php/comentarios/add_comment.php" method="POST">
	<textarea cols="40" rows="12" name="comment" placeholder="Escreva aqui seu comentário."></textarea>
	<input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
	<input type="submit" value="Comentar">
	</form>
	<div id="comentarios">
		<?php include("../php/comentarios/get_post_comments.php") ?>
	</div>
    </section>
</body>
</html>
