<?php include '../php/check_cookie_support.php' ?>
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
	<a href='./../index.html'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
        <ul class="menu">
            <li><a href="./../index.html">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a href="./blog.html">Blog</a></li>
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
    <div id="container" onsubmit="return validarSenha()">
        <form class="form-group" action="cadastro.php" method="POST">   
            <h1>CADASTRO</h1>
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
    <?php include("../php/cadastro.php") ?>
    <script src="./../js/cadastro.js"></script>
</body>
</html>
