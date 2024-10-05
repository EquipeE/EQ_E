<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/calc.css">
    <link rel="stylesheet" href="./../css/footer.css">
    <link rel="website icon" type="img" href="../img/logo.png">
</head>
<body>
    <nav>
        <a href='../index.php'><img id="logo" alt="Logo" src="./../img/logo.png"></a>
	<form><input type='image' src='./../img/ico/search.svg'><input type='text' placeholder='Pesquisar'></form>
        <ul class="menu">
            <li><a href="../index.php"><img src='../img/ico/home.svg'>Home</a></li>
            <li><a href="../html/blog.php"><img src='../img/ico/book.svg'>Blog</a></li>
            <li><a id="current-page" href="../html/calc.php"><img id="calc-img" src='../img/ico/calc.svg'>Calculadora</a></li>
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

    <h1>Calculadora </h1>
    <div class="container">
        <form class="calculadora" action="resultado.php" method="POST">
            <div class="dados">
                <label for="consumo"><h3>Consumo diário de energia (kWh):</h3></label>
                <input type="number" name="consumo" id="consumo" placeholder="Energia consumida" required>

                <label for="autonomia"><h3>Autonomia da Bateria (Dias):</h3></label>
                <input type="number" min="1" step="1" name="autonomia" value="positivo" id="positivo" placeholder="Autonomia da Bateria">
		<br><br>
                <input type="radio" name="autonomia" value="negativo" id="negativo">
                <label for="negativo">Não pretendo utilizar bateria</label>
		<br>
		<label for="orcamento"><h3>Orçamento (R$):</h3></label>
                <input type="number" min="1" step="0.1" name="orcamento" id="orcamento" placeholder="Orçamento" required >
		<br>

                <h3>Como é o lugar onde você vive:</h3>
                <input type="checkbox" name="local[]" value="vento" id="vento">
                <label for="vento">Muito vento</label>
                <input type="checkbox" name="local[]" value="sol" id="sol">
                <label for="sol">Ensolarado</label>
                <input type="checkbox" name="local[]" value="rio" id="rio">
                <label for="rio">Proximo a um rio</label>
		<br><br><br>

                <input type="submit" id="botao" value="Calcular">
            </div>
        </form>
    </div>
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
