<?php
if (!isset($_POST['id']))
	die("Dados insuficientes\n");

$out = null;
exec(__DIR__ . "/delete_post.php {$_POST['id']}", $out);

echo $out[0];

$conexao->close();
?>
