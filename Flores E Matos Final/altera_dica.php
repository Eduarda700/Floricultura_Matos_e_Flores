<?php 
include_once("conexao.php"); // ajuste se estiver em subpasta
include_once("usuarioFuncionario.php");
session_start();


// Verifica se o funcionário está logado
if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: index.php");
    exit;
}


$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;
$iddica_plantio = intval($_GET['id']);

// Busca a dica no banco de dados
$sql = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) == 0) {
    header("location: lista_dica.php");
    exit;
}

$row = mysqli_fetch_assoc($res);
?>

<h1 align='center'>Editar Dica de Plantio</h1>

<div>
    <form class="form-login" action="processa_altera_dica.php" method="POST">
        <input type="hidden" name="iddica_plantio" value="<?= $row['iddica_plantio']; ?>">
        
        <div class="form-group">
            <label for="titulo_dica">Título da Dica</label>
            <input class="form-control" type="text" name="titulo_dica" id="titulo_dica" value="<?= htmlspecialchars($row['titulo_dica']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="conteudo_dica">Conteúdo da Dica</label>
            <textarea class="form-control" name="conteudo_dica" id="conteudo_dica" required><?= htmlspecialchars($row['conteudo_dica']); ?></textarea>
        </div>
        <br>
        <button class="btn btn-dark" type="submit">Alterar</button>
        <button class="btn btn-dark" type="reset">Limpar</button>
        <button class="btn btn-dark" type="button" onclick="window.location='lista_dica.php'">Cancelar</button>
    </form>
</div>
