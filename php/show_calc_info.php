<?php
echo "<p>{$consumo}kWh</p>";
echo "<p>R$" . $orcamento . "</p>";

echo ($autonomia === 'negativo' ? "<p>Nenhuma</p>" : "<p>$autonomia dias</p>");
echo "<p>" . implode(', ', $local) . "</p>";
?>
