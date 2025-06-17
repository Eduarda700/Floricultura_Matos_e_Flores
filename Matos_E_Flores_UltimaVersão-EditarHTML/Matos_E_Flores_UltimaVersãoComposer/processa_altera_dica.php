<?php
include_once("conexao.php"); // ajuste se estiver em subpasta
include_once("usuarioFuncionario.php");
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: index.php");
    exit;
}

include_once("conexao.php");

// Recupera os dados do formulário
$iddica_plantio = intval($_POST['iddica_plantio']);
$titulo_dica = mysqli_real_escape_string($conn, $_POST['titulo_dica']);
$conteudo_dica = mysqli_real_escape_string($conn, $_POST['conteudo_dica']);
$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;

// Verifica se a dica pertence ao funcionário logado
$sql_verifica = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res_verifica = mysqli_query($conn, $sql_verifica);

if (mysqli_num_rows($res_verifica) == 0) {
    echo "<script>alert('Permissão negada para alterar esta dica.'); window.location='lista_dica.php';</script>";
    exit;
}

// Atualiza os dados da dica
$sql_update = "UPDATE dicas_plantio 
               SET titulo_dica = '$titulo_dica', conteudo_dica = '$conteudo_dica'
               WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";

if (mysqli_query($conn, $sql_update)) {
    echo "<script>alert('Dica atualizada com sucesso!'); window.location='lista_dica.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar dica: " . mysqli_error($conn) . "'); window.location='lista_dica.php';</script>";
}
?>
