<?php
session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

if (!isset($_SESSION['id']))
	return;

$admin_path = (basename($_SERVER['PHP_SELF']) === 'index.php') ? './html/admin.php' : 'admin.php';

if ($_SESSION['id'] === 1)
	echo "<li><a href='{$admin_path}'>Admin</a></li>";
?>
