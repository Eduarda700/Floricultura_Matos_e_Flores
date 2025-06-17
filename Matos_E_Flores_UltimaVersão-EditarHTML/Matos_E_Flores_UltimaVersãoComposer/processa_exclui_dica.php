<?php
include_once("conexao.php");
include_once("usuarioFuncionario.php");
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: index.php");
    exit;
}




$iddica_plantio = intval($_GET['id']);
$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;

// Verifica se a dica pertence ao funcionário logado
$sql_verifica = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res_verifica = mysqli_query($conn, $sql_verifica);

if (mysqli_num_rows($res_verifica) == 0) {
    echo "<script>alert('Permissão negada ou dica não encontrada.'); window.location='lista_dica.php';</script>";
    exit;
}

// Deleta a dica
$sql_delete = "DELETE FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res_delete = mysqli_query($conn, $sql_delete);

if (mysqli_affected_rows($conn) == 1) {
    echo "<script>alert('Dica excluída com sucesso!'); window.location='lista_dica.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir a dica.'); window.location='lista_dica.php';</script>";
}
?>
