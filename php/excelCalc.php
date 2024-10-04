<?php
if (!isset($_POST['consumo']) || !isset($_POST['autonomia']) || !isset($_POST['orcamento']))
	die("Dados insuficientes");
if (!isset($_POST['local']) || in_array('nada', $_POST['local']))
	die("Não há opções no seu local");

$consumo = $_POST['consumo'];
$autonomia = $_POST['autonomia'];
$local = $_POST['local'];
$orcamento = $_POST['orcamento'];

$fator_solar = 5;
$fator_eolico = 2.5;
$fator_hidrico = 3.5;

$preco_painel = 5000;
$preco_eolica = 15000;
$preco_hidrica = 10000;
$preco_unitario_bateria = 3000;

$bateria_kwh = ($autonomia === 'negativo') ? 0 : $consumo * $autonomia;
$preco_bateria = $bateria_kwh * $preco_unitario_bateria;
$opcoes = [];
$sistema = [];
$custo_sistema = [];
$custo = [];

if (in_array("rio", $local)) { 
    $opcoes[] = "Considere utilizar turbinas hídricas.";
    $num_turbinas = ceil($consumo / $fator_hidrico); 
    $custo_sistema['hidrico'] = $num_turbinas * $preco_hidrica; 
    $sistema[] = "Recomendamos um sistema hídrico com " . $num_turbinas . " turbinas hídricas.";
} 
if (in_array("sol", $local)) {
    $opcoes[] = "Considere utilizar painéis solares fotovoltaicos.";
    $potencia = ceil($consumo / $fator_solar);
    $custo_sistema['solar'] = $potencia * $preco_painel; 
    $sistema[] = "Recomendamos um sistema solar com capacidade de " . round($potencia, 2) . " kWh de painéis solares.";
}
if (in_array("vento", $local)) {
    $opcoes[] = "Considere utilizar energia eólica.";
    $num_turbinas = ceil($consumo / $fator_eolico); 
    $custo_sistema['eolico'] = $num_turbinas * $preco_eolica; 
    $sistema[] = "Recomendamos um sistema eólico com " . $num_turbinas . " turbinas eolicas.";
}

if ($preco_bateria > ($orcamento - $custo_sistema)) {
	$bateria_kwh = floor(($orcamento - $custo_sistema) / $preco_unitario_bateria);
	$preco_bateria = $bateria_kwh * $preco_unitario_bateria;
}

$custo['eolico'] = $custo_sistema['eolico'] + $preco_bateria; 
$custo['hidrico'] = $custo_sistema['hidrico'] + $preco_bateria; 
$custo['solar'] = $custo_sistema['solar'] + $preco_bateria; 

if ($autonomia == "negativo") {
    $bateriaAh120 = "";
    $bateriaAh220 = "";
    $sugest_bat120 = "Usuário não pretende usar bateria";
    $sugest_bat220 = "";
} else {
    $bateriaAh120 = (($bateria_kwh * 1000) / 120);
    $bateriaAh220 = (($bateria_kwh * 1000) / 220);
    $sugest_bat220 = "Devido ao seu orçamento, se sua rede for de 220V recomendamos uma bateria com capacidade de até " . round($bateriaAh220, 2) . " Ah.";
    $sugest_bat120 = "Devido ao seu orçamento, se sua rede for de 120V recomendamos uma bateria com capacidade de até " . round($bateriaAh120, 2) . " Ah.";
}

if (in_array("sol", $local)) {
    $local = "Muito sol"; 
} elseif (in_array("rio", $local)) {
    $local = "Perto de um rio"; 
} elseif (in_array("vento", $local)) {
    $local = "Muito vento";
} 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/resultados.css">
    <link rel="website icon" type="img" href="../img/logo.png">
</head>
<body>
    <nav>
        <a href='../index.html'><img id="logo" alt="Logo" src="../img/logo.png"></a>
        <ul class="menu">
        <li><a href="">Sobre</a></li>
            <li><a href="">Blog</a></li>
            <li class="drop">
            <a href="#">Conta</a>
                <ul class="conteudo">
                    <li><a href="../html/login.html">Login</a></li>
                    <li><a href="../html/cadastro.html">Cadastro</a></li>
                </ul>
            </li>
        </ul>
    </nav><br>
        <div class="container">
            <div class="group-container">
                <h1>Resultados</h1>
                <table>
                    <tr>
                        <th><strong>Consumo Diário:</strong></th> 
                        <th><strong>Característica da localização:</strong></th> 
                        <th><strong>Orçamento:</strong></th>
                    </tr>
                    <tr>
                        <td><?php echo $consumo; ?> kWh</td>
                        <td><?php echo $local; ?></td>
                        <td>R$<?php echo number_format($orcamento, 2, ',', '.'); ?></td>
                    </tr>
                </table>

                <h2>Sugestão de Sistema:</h2>
                <p><?php echo implode($opcoes); ?></p>
                <p><?php echo implode($sistema); ?></p>

                <h2>Sugestão de Bateria:</h2>
                <p><?php echo $sugest_bat120; ?></p>
                <p><?php echo $sugest_bat220; ?></p>

                <h2>Custo Estimado:</h2>
                <p>Custo estimado do sistema: R$<?php foreach($custo as $c) echo number_format($c, 2, ',', '.'); ?></p>

                <button id="pdf">Baixar PDF</button>
                <a href="../html/calc.html"><button>Fazer Nova Simulação</button></a>
            </div>
        </div>
    

    <script>
        document.getElementById('pdf').addEventListener('click', function() {
            window.location.href = `pdf.php?consumo=<?php echo $consumo; ?>&local=<?php echo $local; ?>&orcamento=<?php echo $orcamento; ?>&autonomia=<?php echo $autonomia; ?>&sistema=<?php echo $sistema; ?>&bateria120=<?php echo $sugest_bat120; ?>&bateria220=<?php echo $sugest_bat220; ?>&bateriaAh220=<?php echo $bateriaAh220; ?>&bateriaAh120=<?php echo $bateriaAh120; ?>&custo=<?php echo $custo; ?>`;
        });
    </script>

</body>
</html>







