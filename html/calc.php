<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-redes</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/calc.css">
    <link rel="website icon" type="img" href="../img/logo.png">
</head>
<body>
    <nav>
        <a href='../index.php'><img id="logo" alt="Logo" src="../img/logo.png"></a>
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

    <h1>Calculadora </h1>
    <div class="container">
        <form class="calculadora" action="../php/calc.php" method="POST">
            <div class="dados">
                <h3>Capacidade da bateria em Ah:</h3>
                <input type="number" name="capacidade" placeholder="Capacidade">
                <h3>Profundidade de descarga da bateria (em porcentagem):</h3>
                <input type="number" name="pd" placeholder="Profundidade de descarga">
                <h3>Tensão da bateria:</h3>
                <input type="number" name="tensao" placeholder="Tensão">
                <h3>Consumo médio de energia por dia em kWh:</h3>
                <input type="number" name="consumo" placeholder="Energia consumida">

		<h3>Como é o lugar onde vives?</h3>
                <input type="checkbox" name="local[]" value="vento" id="vento">
                <label for="vento">Muito vento</label>
                <input type="checkbox" name="local[]" value="sol" id="sol">
                <label for="sol">Muito sol</label>
                <input type="checkbox" name="local[]" value="chuva" id="chuva">
                <label for="chuva">Muita chuva</label>
                <input type="checkbox" name="local[]" value="rio" id="rio">
                <label for="rio">Proximo a um rio</label>

                <h3>Como é a sua moradia?</h3>
                <input type="radio" name="moradia" value="casa_urbana" id="urbana">
                <label for="urbana">Casa urbana</label>
                <input type="radio" name="moradia" value="casa_rural" id="rural">
                <label for="rural">Casa rural</label>
                <input type="radio" name="moradia" value="apartamento" id="apartamento">
                <label for="apartamento">Apartamento</label>
                <br>
                <br>

                <input type="submit" id="botao" value="Calcular">
            </div>
        </form>
    </div>
</body>

</html>
