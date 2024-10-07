<?php
foreach ($sistemas as $s) {
	echo "<h2>{$s->nome}:</h2>";
	echo "<p>{$s->descricao}</p>";
	if ($s->custo_total != $s->custo_total_reduzido) 
		echo "<p id='resultado-erro'>Infelizmente, seu orçamento não é suficiente para atender seus requisitos.</p>";
	echo "<p class='custo'>Custo total: R$" . number_format($s->custo_total, 2, ',', '.') . "</p>";

	if ($s->bateria->autonomia === 0)
		continue;

	echo "<p>Capacidade da bateria, se sua rede elétrica for de 120V: {$s->bateria->capacidadeAh120}Ah</p>";
	echo "<p>Capacidade da bateria, se sua rede elétrica for de 220V: {$s->bateria->capacidadeAh220}Ah</p>";
	echo "<p class='custo'>Preço da bateria: R$" . number_format($s->bateria->preco, 2, ',', '.') . "</p>";

	if ($s->bateria->preco === $s->bateria->preco_reduzido)
		continue;

	echo "<p>É possível economizar na bateria para adequa-la a seu orçamento, entretanto, isso implica em reduzir a sua capacidade. Confira abaixo:</p>";
	echo "<p>Capacidade da bateria, se sua rede elétrica for de 120V: {$s->bateria->capacidadeAh120_reduzido}Ah</p>";
	echo "<p>Capacidade da bateria, se sua rede elétrica for de 220V: {$s->bateria->capacidadeAh220_reduzido}Ah</p>";
	echo "<p class='custo'>Preço da bateria: R$" . number_format($s->bateria->preco_reduzido, 2, ',', '.') . "</p>";
	echo "<p class='custo'>Preço do sistema com bateria mais fraca: R$" . number_format($s->custo_total_reduzido, 2, ',', '.') . "</p>";
}
?>
