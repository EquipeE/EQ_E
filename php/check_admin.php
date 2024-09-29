<?php
# Define $index_path before including as the relative path to index file

session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

if ($_SESSION['id'] !== 1) {
	header("Location: {$index_path}");
	die();
}
?>
