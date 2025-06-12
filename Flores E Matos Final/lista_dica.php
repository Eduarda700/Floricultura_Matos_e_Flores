<?php
include_once("conexao.php");
include_once("usuarioFuncionario.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("location: index.php");
    exit;
}

$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;

$sql = "SELECT * FROM dicas_plantio WHERE idusuario_funcionario = $idusuario_funcionario ORDER BY iddica_plantio DESC";
$res = mysqli_query($conn, $sql);
?>

<h1 align="center">Lista de Dicas de Plantio</h1>

<p>
    <a href="cadastra_dica.php" style="text-decoration:none; padding:8px 12px; background-color:#4CAF50; color:white; border-radius:5px;">Cadastrar Nova Dica</a>
</p>

<table border="1" cellpadding="8" cellspacing="0" style="width: 90%; margin: auto; border-collapse: collapse;">
    <thead style="background-color:#ddd;">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($res) > 0): ?>
        <?php while ($dica = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?= $dica['iddica_plantio'] ?></td>
                <td><?= htmlspecialchars($dica['titulo_dica']) ?></td>
                <td><?= nl2br(htmlspecialchars(substr($dica['conteudo_dica'], 0, 100))) ?>...</td>
                <td>
                    <a href="exibe_dica.php?iddica_plantio=<?= $dica['iddica_plantio'] ?>" style="margin-right:10px;">Exibir</a>
                    <a href="altera_dica.php?id=<?= $dica['iddica_plantio'] ?>" style="margin-right:10px;">Editar</a>
                    <a href="processa_exclui_dica.php?id=<?= $dica['iddica_plantio'] ?>" onclick="return confirm('Deseja realmente excluir esta dica?');" style="color:red;">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4" align="center">Nenhuma dica cadastrada.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
