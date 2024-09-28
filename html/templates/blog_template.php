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
        <a href='./../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
        <ul class="menu">
            <li><a href="./../index.php">Home</a></li>
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
    <h1>Todas as postagens</h1>
    <main>
	!!!BLOG
    </main>
</body>
</html>
