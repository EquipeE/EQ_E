<?php
require_once 'crud_post.php';
$index_path = "../../index.html";
include __DIR__ . '/../check_admin.php';
if (!isset($_POST['id']))
	die("Dados insuficientes\n");

echo delete_post($_POST['id']);
?>
