<?php
include_once("conexao.php");
include_once("usuarioFuncionario.php");
session_start();


if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("location: index.php");
    exit;
}

if (!isset($_GET['iddica_plantio'])) {
    echo "<script>alert('Dica não especificada.'); window.location='lista_dica.php';</script>";
    exit;
}

$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;
$iddica_plantio = intval($_GET['iddica_plantio']);

$sql = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res = mysqli_query($conn, $sql) or die("Erro na consulta: " . mysqli_error($conn));

if (mysqli_num_rows($res) == 0) {
    echo "<script>alert('Dica não encontrada ou sem permissão para visualizar.'); window.location='lista_dica.php';</script>";
    exit;
}

$dica = mysqli_fetch_assoc($res);
?>

<h1 align="center">Detalhes da Dica de Plantio</h1>

<div style="width: 80%; margin: auto;">
    <div class="form-group">
        <label for="titulo">Título da Dica</label>
        <input class="form-control" type="text" id="titulo" value="<?= htmlspecialchars($dica['titulo_dica']) ?>" disabled>
    </div>
    <div class="form-group">
        <label for="conteudo">Conteúdo da Dica</label>
        <textarea class="form-control" id="conteudo" rows="8" disabled><?= htmlspecialchars($dica['conteudo_dica']) ?></textarea>
    </div>
    <br>
    <button class="btn btn-dark" type="button" onclick="window.location='lista_dica.php'">Voltar</button>
</div>
