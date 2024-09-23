<?php include("./../php/check_admin.php") ?>
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
            <li><a id="current-page" href="./blog.html">Blog</a></li>
            <li><a href="./calc.html">Calculadora</a></li>
            <li class="drop">
                <a href="#">Conta</a>
                <ul class="conteudo">
                    <li><a href="./login.html">Login</a></li>
                    <li><a href="./cadastro.html">Cadastro</a></li>
                </ul>    
            </li>
        </ul>
    </nav><br>
    <h1>Criar post</h1>
    <form action="../php/posts/add_post_wrapper.php" method="POST" enctype="multipart/form-data">
	<input type="text" name="titulo" placeholder="titulo"><br>
	<input type="file" name="imagem"><br>
	<textarea name="conteudo" rows="24" cols="80">Escreva aqui o conteudo</textarea><br>
	<input type="submit" value="Criar">
    </form>
    <h1>Atualizar post</h1>
    <form action="../php/posts/update_post_wrapper.php" method="POST" enctype="multipart/form-data">
	<input type="number" name="id" placeholder="id"><br>
	<input type="text" name="titulo" placeholder="titulo"><br>
	<input type="file" name="imagem"><br>
	<textarea name="conteudo" rows="24" cols="80">Escreva aqui o conteudo</textarea><br>
	<input type="submit" value="Atualizar">
    </form>
    <h1>Deletar post</h1>
    <form action="../php/posts/delete_post_wrapper.php" method="POST">
	<input type="number" name="id" placeholder="id"><br>
	<input type="submit" value="Deletar">
    </form>
</body>
</html>
