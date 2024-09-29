<?php include '../php/check_cookie_support.php' ?>
<?php $msg = include '../php/login.php' ?>
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
	<a href='./../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
        <ul class="menu">
            <li><a href="./../index.php">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a href="./blog.php">Blog</a></li>
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
    <div id="container">
        <form class="form-group" action="login.php" method="POST">   
            <h1>Login</h1>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
            <div class="password-container">
            <input type="password" name="senha" id="senha" pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Deve conter ao menos: Um caracter especial, oito digitos, uma letra maiúscula e um número" placeholder="Senha" required> 
            <span id="togglesenha" class="eye">👁</span>
            </div>
	    <a href="" id="esq">Esqueceu a senha?</a>
            <br>
            <br>
            <input type="submit" value="Login">
        </form>
    </div>
    <?php include '../php/show_message_box.php'  ?>
    <script src="./../js/login.js"></script>
</body>
</html>
