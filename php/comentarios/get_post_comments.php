<?php
if (!isset($_GET['id']))
	die();

include(__DIR__ . '/../db.php');
$res = $conexao->execute_query("SELECT Comentarios.conteudo as conteudo, Usuarios.nome as nome FROM Comentarios JOIN Usuarios ON Usuarios.id = Comentarios.id_usuario WHERE id_post = ? ORDER BY Comentarios.id DESC", [$_GET['id']]);

if (!$res)
	die($conexao->error);
$res = $res->fetch_all(MYSQLI_BOTH);

foreach($res as $r)
	echo '<div class="comentario"><h4>' . htmlspecialchars($r['nome']) . ' disse:</h4>' . htmlspecialchars($r['conteudo']) . '</div>';

$conexao->close();
?>
