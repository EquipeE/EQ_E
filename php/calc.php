<?php
if (!isset($_POST['consumo']) || !isset($_POST['moradia']))
    die ("Dados Insuficientes");

$consumo = $_POST['consumo'] * 1000;
echo "<br>Se a sua rede for de 220V, considere uma bateria de " . number_format($consumo/220, 0, '.', '') . "A.<br>Se a rede for de 127V. considere uma bateria de " . number_format($consumo/127, 0, '.', '') . "A<br>";
if (!isset($_POST['local']) && $_POST['moradia'] != 'casa_rural')
    die("Não há opções no seu local");

$local = $_POST['local'];
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