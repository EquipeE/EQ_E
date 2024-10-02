<?php $index_path = "../index.php"; include "./../php/check_admin.php" ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="./../css/nav.css">
    <link rel="stylesheet" href="./../css/footer.css">
    <link rel="website icon" type="img" href="./../img/logo.png">
</head>
<body>
    <nav>
        <a href='../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
	<form><input type='image' src='./../img/ico/search.svg'><input type='text' placeholder='Pesquisar'></form>
        <ul class="menu">
            <li><a href="../index.php"><img src='../img/ico/home.svg'>Home</a></li>
            <li><a href="../html/blog.php"><img src='../img/ico/book.svg'>Blog</a></li>
            <li><a href="../html/calc.php"><img src='../img/ico/calc.svg'>Calculadora</a></li>
            <li class="drop">
                <a href="#"><img src='../img/ico/user.svg'>Conta</a>
		<ul class="conteudo">
		    <?php include '../php/dynamic_login_logout.php' ?>
                    <li><a href="../html/cadastro.php">Cadastro</a></li>
		    <?php include '../php/admin_screen_button.php' ?>
                </ul>    
            </li>
        </ul>
    </nav><br>

    <h1>Criar post</h1>
    <form action="../php/posts/add_post.php" method="POST" enctype="multipart/form-data">
	<input type="text" name="titulo" placeholder="titulo"><br>
	<input type="file" name="imagem"><br>
	<textarea name="conteudo" rows="24" cols="80">Escreva aqui o conteudo</textarea><br>
	<input type="submit" value="Criar">
    </form>
    <h1>Atualizar post</h1>
    <form action="../php/posts/update_post.php" method="POST" enctype="multipart/form-data">
	<input type="number" name="id" placeholder="id"><br>
	<input type="text" name="titulo" placeholder="titulo"><br>
	<input type="file" name="imagem"><br>
	<textarea name="conteudo" rows="24" cols="80">Escreva aqui o conteudo</textarea><br>
	<input type="submit" value="Atualizar">
    </form>
    <h1>Deletar post</h1>
    <form action="../php/posts/delete_post.php" method="POST">
	<input type="number" name="id" placeholder="id"><br>
	<input type="submit" value="Deletar">
    </form><br>
    <footer>
	<p id="titulo-footer">Contato</p>
	<div id="contatos">
		<p>Telefone: (69) 91234-5678</p>
		<p>Whatsapp: (24) 98765-4321</p>
		<p>Email: equipesenae@gmail.com</p>
	</div>
    </footer>
</body>
</html>
