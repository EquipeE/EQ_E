<?php
require_once 'calc_consts.php';

$success = false;

if ((!isset($_POST['consumo']) && (!isset($_POST['aparelho']) || !isset($_POST['potencia']))) || !isset($_POST['autonomia']) || !isset($_POST['orcamento'])
	|| (isset($_POST['consumo']) && $_POST['consumo'] != '' && !filter_var($_POST['consumo'], FILTER_VALIDATE_FLOAT)) || ($_POST['consumo'] === '' && !isset($_POST['aparelho']))
	|| !filter_var($_POST['orcamento'], FILTER_VALIDATE_FLOAT) || ($_POST['autonomia'] != 'negativo' && !filter_var($_POST['autonomia'], FILTER_VALIDATE_FLOAT)))
	return "Dados insuficientes";
if ($_POST['consumo'] != '' && ($_POST['consumo'] < 0 || $_POST['orcamento'] < 0 || ($_POST['autonomia'] != 'negativo' && $_POST['autonomia'] < 0)))
	return "Dados inválidos";
if (!isset($_POST['local']))
	return "Não há opções no seu local";
if (isset($_POST['aparelho']) && (count($_POST['aparelho']) != count($_POST['potencia'])))
	return "Dados insuficientes";

foreach ($_POST['local'] as $l)
	if (!in_array($l, ['vento', 'sol', 'rio']))
		return "Dados inválidos";

$consumo = 0;
if (isset($_POST['aparelho']))
	for ($i = 0;$i < count($_POST['aparelho']);$i++)
		$consumo += $_POST['potencia'][$i] / 1000 * 24 * 3 / 100; /* 3% em kWh considerando 24h por dia*/
else 
	$consumo = $_POST['consumo'];

$autonomia = $_POST['autonomia'];
$local = $_POST['local'];
$orcamento = $_POST['orcamento'];

class Bateria {
	public float $autonomia;
	public int $capacidadeAh120;
	public int $capacidadeAh120_reduzido;
	public int $capacidadeAh220;
	public int $capacidadeAh220_reduzido;
	public int $capacidade_kwh;
	public int $capacidade_kwh_reduzido;
	public float $preco;
	public float $preco_reduzido;

	function __construct($consumo, $autonomia) {
		$this->capacidade_kwh = ($autonomia === 'negativo') ? 0 : $consumo * $autonomia;
		$this->autonomia = ($autonomia === 'negativo') ? 0 : $autonomia;
		$this->preco = $this->capacidade_kwh * PRECO_UNITARIO_BATERIA;

		if ($autonomia === 'negativo') {
			$this->capacidadeAh120 = 0;
			$this->capacidadeAh120_reduzido = 0;
			$this->capacidadeAh220 = 0;
			$this->capacidadeAh220_reduzido = 0;
		}
	}

	function calcular_capacidadesAh() {
		$this->capacidadeAh120 = ceil($this->capacidade_kwh * 1000 / 120);
		$this->capacidadeAh120_reduzido= ceil($this->capacidade_kwh_reduzido * 1000 / 120);
		$this->capacidadeAh220 = ceil($this->capacidade_kwh * 1000 / 220);
		$this->capacidadeAh220_reduzido = ceil($this->capacidade_kwh_reduzido * 1000 / 220);
	}

	function reduzir_custo($custo_sistema, $orcamento) {
		if ($custo_sistema > $orcamento) {
			$this->capacidade_kwh_reduzido = 0;
			$this->preco_reduzido = 0;
			$this->autonomia = 0;
		} elseif ($this->preco > ($orcamento - $custo_sistema)) {
			$this->capacidade_kwh_reduzido = floor(($orcamento - $custo_sistema) / PRECO_UNITARIO_BATERIA);
			$this->preco_reduzido = $this->capacidade_kwh_reduzido * PRECO_UNITARIO_BATERIA;
		}

		$this->calcular_capacidadesAh();
	}
}

class Sistema {
	public float $custo_sistema;
	public float $custo_total;
	public float $custo_total_reduzido;
	public string $descricao;

	function __construct($nome, $consumo, $autonomia, $preco_unitario, $kwh_unitario, $bateria_kwh, $preco_bateria, $descricao_placeholder) {
		$this->nome = $nome;
		$this->preco_unitario = $preco_unitario;
		$this->kwh_unitario = $kwh_unitario;
		$this->bateria_kwh = $bateria_kwh;
		$this->preco_bateria = $preco_bateria;
		$this->descricao_placeholder = $descricao_placeholder;
		$this->bateria = new Bateria($consumo, $autonomia);
	}

	function calcular($consumo, $orcamento) {
		$qtd = ceil($consumo / $this->kwh_unitario);
		$this->custo_sistema = $qtd * $this->preco_unitario;
		$this->descricao = str_replace('?', $qtd, $this->descricao_placeholder);

		if (($this->custo_sistema + $this->bateria->preco) < $orcamento) {
			$this->bateria->capacidade_kwh_reduzido = $this->bateria->capacidade_kwh;
			$this->bateria->preco_reduzido = $this->bateria->preco;
		} else {
			$this->bateria->reduzir_custo($this->custo_sistema, $orcamento);
		}

		$this->bateria->calcular_capacidadesAh();
		$this->custo_total = $this->custo_sistema + $this->preco_bateria;
		$this->custo_total_reduzido = $this->custo_sistema + $this->bateria->preco_reduzido;
	}
}


$bateria_kwh_real = ($autonomia === 'negativo') ? 0 : $consumo * $autonomia;
$preco_bateria_real = $bateria_kwh_real * PRECO_UNITARIO_BATERIA;
$sistemas = [];

foreach ($local as $l) {
	$sist = match ($l) {
		'rio' => new Sistema("Hídrico", $consumo, $autonomia, PRECO_UNITARIO_HIDRICO, KWH_UNITARIO_HIDRICO, $bateria_kwh_real, $preco_bateria_real, "Recomendamos um sistema com ? turbinas hídricas."),
		'sol' => new Sistema("Solar", $consumo, $autonomia, PRECO_UNITARIO_SOLAR, KWH_UNITARIO_SOLAR, $bateria_kwh_real, $preco_bateria_real, "Recomendamos um sistema solar com capacidade de ? kWh de painéis solares."),
		'vento' => new Sistema("Eólico", $consumo, $autonomia, PRECO_UNITARIO_EOLICO, KWH_UNITARIO_EOLICO, $bateria_kwh_real, $preco_bateria_real, "Recomendamos um sistema com ? turbinas eólicas.")
	};

	$sist->calcular($consumo, $orcamento);
	$sistemas[] = $sist;
}

foreach ($local as &$l)
	$l = match ($l) {
		'rio' => 'Proximo a um rio',
		'sol' => 'Ensolarado',
		'vento' => 'Muito vento'
	};

$success = true;
return '';
?>
