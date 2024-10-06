<?php
require_once 'crud_post.php';
$index_path = "../../index.html";
include __DIR__ . '/../check_admin.php';

$success = false;

if (!isset($_POST['id']))
	return "Dados insuficientes";


$success = true;
return delete_post($_POST['id']);
?>
