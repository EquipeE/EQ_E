<?php
echo "<p>{$consumo}kWh</p>";
echo "<p>R$" . $orcamento . "</p>";
/*
if ($autonomia === 'negativo')
	echo "<p>Nenhuma</p>";
else
	echo "<p>$autonomia dias</p>";
 */
echo ($autonomia === 'negativo' ? "<p>Nenhuma</p>" : "<p>$autonomia dias</p>");
echo "<p>" . implode(', ', $local) . "</p>";
?>
