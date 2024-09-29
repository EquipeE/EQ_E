<?php
session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

$login_path = (basename($_SERVER['PHP_SELF']) === "index.php") ? './html/login.php' : 'login.php';
$logout_path = (basename($_SERVER['PHP_SELF']) === "index.php") ? './php/logout.php' : '../php/logout.php';

if (!isset($_SESSION['id']))
	echo "<li><a href='{$login_path}'>Login</a></li>";
else
	echo "<li><a href='{$logout_path}'>Logout</a></li>";
?>
