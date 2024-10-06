<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
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
		<ul class="conteudo">
		    <?php include '../php/dynamic_login_logout.php' ?>
                    <li><a href="../html/cadastro.php">Cadastro</a></li>
		    <?php include '../php/admin_screen_button.php' ?>
                </ul>    
            </li>
        </ul>
    </nav><br>

   <h1>Todas as postagens</h1>
    <main>
	<a href='./post.php?id=5'><div class='card'><img src='./../img/posts/7e9083709e974ec034faf4088e73b08a2f0b47b7373b721cf743a10a08e5d2a6.png'><div class='card-text'>Just as the founding fathers intended.</div></div></a>
<a href='./post.php?id=4'><div class='card'><img src='./../img/posts/74cc5317430c92e8d24407ed1e7ff859d62ef4701e80dd304ad536121cee7afd.png'><div class='card-text'>Post 4</div></div></a>
<a href='./post.php?id=3'><div class='card'><img src='./../img/posts/54bdb54a3b6d87cccd067ff6cc50a2c40767008bdf17d827bb8774e007406d6b.png'><div class='card-text'>O Monólogo</div></div></a>
<a href='./post.php?id=2'><div class='card'><img src='./../img/posts/79972387efe365d9b8ef3a4713d642c5b072d751d66abfe2255a7240db7e1c20.png'><div class='card-text'>História chocante acontece na USP</div></div></a>
<a href='./post.php?id=1'><div class='card'><img src='./../img/posts/7e9083709e974ec034faf4088e73b08a2f0b47b7373b721cf743a10a08e5d2a6.png'><div class='card-text'>Stallman's Momentary Lapse of Reason</div></div></a>

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
