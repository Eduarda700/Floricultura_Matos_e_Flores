<?php
include_once("conexao.php"); // ajuste se estiver em subpasta
include_once("usuarioFuncionario.php");
session_start();

if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: index.php");
    exit;
}



// Verifica se o objeto do funcionário tem o ID
$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;

$titulo_dica = mysqli_real_escape_string($conn, $_POST['titulo']);
$conteudo_dica = mysqli_real_escape_string($conn, $_POST['conteudo']);

$sql = "INSERT INTO dicas_plantio (titulo_dica, conteudo_dica, idusuario_funcionario)
        VALUES ('$titulo_dica', '$conteudo_dica', $idusuario_funcionario)";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Dica cadastrada com sucesso!'); window.location='lista_dica.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar dica: " . mysqli_error($conn) . "'); window.location='cadastro_dica.php';</script>";
}
?>
