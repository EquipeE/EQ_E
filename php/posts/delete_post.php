<?php
if (!isset($_POST['id']))
	die("Dados insuficientes\n");

echo delete_post($_POST['id']);
?>
