<?php
if (!isset($_POST['aparelho']) || count($_POST['aparelho']) === 0)
	return;
echo "<section id='aparelhos-grid' class='blurred-card'>";
echo "<p>Aparelho</p><p>Potência</p>";
for ($i = 0;$i < count($_POST['aparelho']);$i++)
	echo "<p>{$_POST['aparelho'][$i]}</p><p>{$_POST['potencia'][$i]}W</p>";
echo "</section>";
?>
