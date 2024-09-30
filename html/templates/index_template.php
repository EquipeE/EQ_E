<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/carrossel.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="website icon" type="img" href="./img/logo.png">
</head>
<body>
    <nav>
        <a href='./index.php'><img id="logo" alt="Logo" src="img/logo.png"></a>
        <ul class="menu">
            <li><a id="current-page" href="./index.php">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a href="./html/blog.php">Blog</a></li>
            <li><a href="./html/calc.php">Calculadora</a></li>
            <li class="drop">
                <a href="#">Conta</a>
		<ul class="conteudo">
		    <?php include 'php/dynamic_login_logout.php' ?>
                    <li><a href="./html/cadastro.php">Cadastro</a></li>
		    <?php include 'php/admin_screen_button.php' ?>
                </ul>    
            </li>
        </ul>
    </nav><br>

    <div id="carrossel">
	<div class="slides">
            <div class="slide"><a href="./html/calc.php"><img src="./img/TESTE_CARROSSEL.png" alt="Artwork 1"></a></div>
	    !!!CARROSSEL
    	</div>
    </div>

    <main id="cards_container">
	    !!!CARDS
    </main>
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
