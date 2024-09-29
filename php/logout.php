<?php
session_start(["use_strict_mode" => 1, "cookie_httponly" => 1]);

$_SESSION = array();
session_destroy();

header("Location: ./../index.php");
die();
?>
