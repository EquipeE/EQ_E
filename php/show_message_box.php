<?php
# Espera que $msg esteja setada
# Espera que $success esteja setada
if ($_SERVER['REQUEST_METHOD'] !== "POST" || !isset($success))
	return;
echo ($success) ? "<div id='resultado'>$msg</div>" : "<div id='resultado-erro'>$msg</div>";
?>
