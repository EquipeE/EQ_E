<?php
function validar_imagem($img) {
	$tipo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $img);
	$permitidos = ['image/jpeg', 'image/png', 'image/webp'];

	return in_array($tipo, $permitidos);
}
?>
