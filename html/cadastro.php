<?php include '../php/check_cookie_support.php' ?>
<?php $msg = include '../php/cadastro.php' ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-REDES</title>
    <link rel="stylesheet" href="./../css/nav.css">
    <link rel="stylesheet" href="./../css/cadastro.css">
    <link rel="website icon" type="img" href="./../img/logo.png">
</head>
<body> 
    <nav>
        <a href='../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
	<form><input type='image' src='./../img/ico/search.svg'><input type='text' placeholder='Pesquisar'></form>
        <ul class="menu">
            <li><a href="../index.php"><img class='icon' src='../img/ico/home.svg'>Home</a></li>
            <li><a href="../html/blog.php"><img class='icon' src='../img/ico/book.svg'>Blog</a></li>
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

    <div id="container" onsubmit="return validarSenha()">
        <form class="form-group" action="cadastro.php" method="POST">   
            <h1>Cadastro</h1>
            <input type="text" name="nome" id="nome" placeholder="Nome" required>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
            <div class="password-container">
            <input type="password" name="senha" id="senha" pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Deve conter ao menos: Um caracter especial, oito digitos, uma letra maiúscula e um número" placeholder="Senha" required> 
            <span id="togglesenha" class="eye">👁</span>
            </div>
            <div class="password-container">
            <input type="password" name="confsenha" id="confsenha" placeholder="Confirmar Senha" required>
            <span id="toggleconfsenha" class="eye">👁</span>
            </div>
            <br>
            <br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    <?php include './../php/show_message_box.php' ?>
    <script src="./../js/cadastro.js"></script>
</body>
</html>
