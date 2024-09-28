<?php
if ($_GET['cookie'] == 1 || $_SERVER['REQUEST_METHOD'] === "POST") {
	$cookie_support = isset($_COOKIE['test']);
} else {
	setcookie("test", "test", time() + 120);
	header("Location: {$_SERVER['PHP_SELF']}?cookie=1");
	die();
}
?>
