<?php
session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

if ($_SESSION['id'] === 1)
	echo "<li><a href='{$admin_path}'>Admin</a></li>";
?>
