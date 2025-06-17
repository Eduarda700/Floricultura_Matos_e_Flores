<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("location: index.php");
    exit;
}
include_once("conexao.php");

$iddica_plantio = intval($_GET['id']);
$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;

$sql = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res = mysqli_query($conn, $sql);
$dica = mysqli_fetch_assoc($res);

if (!$dica) {
    echo "<script>alert('Dica não encontrada ou sem permissão.'); window.location='listar_dicas.php';</script>";
    exit;
}
?>

<h1 align='center'>Editar Dica</h1>

<div>
    <form class="form-login" action="processa_altera_dica.php" method="POST">
        <input type="hidden" name="iddica_plantio" value="<?= $dica['iddica_plantio'] ?>">
        <div class="form-group">
            <label for="titulo">Título da Dica</label>
            <input class="form-control" type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($dica['titulo']) ?>" required>
        </div>
        <div class="form-group">
            <label for="conteudo">Conteúdo da Dica</label>
            <textarea class="form-control" name="conteudo" id="conteudo"><?= htmlspecialchars($dica['conteudo']) ?></textarea>
        </div>
        <br>
        <button class="btn btn-dark" type="submit">Salvar</button>
        <button class="btn btn-dark" type="button" onclick="window.location='listar_dicas.php'">Cancelar</button>
    </form>
</div>
