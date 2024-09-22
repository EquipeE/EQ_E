<?php
if (!isset($_POST['capacidade']) || !isset($_POST['pd']) || !isset($_POST['tensao']) || !isset($_POST['consumo']) || !isset($_POST['moradia']))
    die ("Dados Insuficientes");

$consumoHora = $_POST['consumo'] / 24;
$capacidadeUtil = $_POST['capacidade']*$_POST['tensao']/1000*$_POST['pd']/100;
$horas = $capacidadeUtil/$consumoHora;
echo "Sua bateria sustenta sua casa sem carregar por {$horas} horas.<br>";

if (!isset($_POST['local']) && $_POST['moradia'] != 'casa_rural')
    die("Não há opções no seu local");

$local = (isset($_POST['local'])) ? $_POST['local'] : [];
$moradia = $_POST['moradia'];

$opcoes = [];

if ($moradia == "casa_rural")
    $opcoes[] = "Considere produzir biogás a partir das fezes dos animais.";
if (in_array("rio", $local) && $moradia != "apartamento")
    $opcoes[] = "Considere instalar uma roda d'água.";
if (in_array("rio", $local) && $moradia == "apartamento" && count($local) == 1)
    $opcoes[] = "Não há opções no seu local";
if (in_array("sol", $local))
    $opcoes[] = "Considere utilizar painéis solares fotovoltaicos.";
if (in_array("chuva", $local))
    $opcoes[] = "Considere conferir nosso projeto!";
if (in_array("vento", $local))
    $opcoes[] = "Considere utilizar energia eólica.";

echo "<ul>";
foreach($opcoes as $e)
    echo "<li>$e</li>";
echo "</ul>";
?>
