<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="./../css/common.css">
    <link rel="stylesheet" href="./../css/nav.css">
    <link rel="stylesheet" href="./../css/blog.css">
    <link rel="stylesheet" href="./../css/footer.css">
    <link rel="website icon" type="img" href="./../img/logo.png">
</head>
<body>
    <nav>
        <a href='../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
	<form action='search.php' method='GET'><input type='image' src='./../img/ico/search.svg'><input type='text' placeholder='Pesquisar' name='busca'></form>
        <ul class="menu">
            <li><a href="../index.php"><img class='icon' src='../img/ico/home.svg'>Home</a></li>
            <li><a id="current-page" href="../html/blog.php"><img class='icon' src='../img/ico/book.svg'>Blog</a></li>
            <li><a href="../html/calc.php"><img class='icon' src='../img/ico/calc.svg'>Calculadora</a></li>
            <li class="drop">
                <a href="#"><img class='icon' src='../img/ico/user.svg'>Conta</a>
		<ul class='conteudo blurred-card'>
		    <?php include '../php/dynamic_login_logout.php' ?>
                    <li><a href="../html/cadastro.php">Cadastro</a></li>
		    <?php include '../php/admin_screen_button.php' ?>
                </ul>    
            </li>
        </ul>
    </nav><br>
    <main>
	<?php include './../php/search.php' ?>
    </main>
    <footer>
	<p id="titulo-footer">Contato</p>
	<div id="contatos">
		<p><img class='icon' src='../img/ico/phone.svg'>(69) 91234-5678</p>
		<p><img class='icon' src='../img/ico/whatsapp.svg'>(24) 98765-4321</p>
		<p><img class='icon' src='../img/ico/mail.svg'>equipesenae@gmail.com</p>
	</div>
    </footer>
</body>
</html>
