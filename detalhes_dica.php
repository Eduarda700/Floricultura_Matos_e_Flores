<?php
include 'conexao.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) exit;

$q = mysqli_query($conn, "SELECT * FROM dicas_plantio WHERE iddica_plantio = $id");
$d = mysqli_fetch_assoc($q) ?? exit;
?>

<h3><?= htmlspecialchars($d['titulo_dica']) ?></h3>
<p><?= nl2br(htmlspecialchars($d['conteudo_dica'])) ?></p>
