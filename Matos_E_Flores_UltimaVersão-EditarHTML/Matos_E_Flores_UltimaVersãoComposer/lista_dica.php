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

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Dicas - Sistema Floricultura</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        body { background-color: #f1e4ff; }
        .navbar-inverse { background-color: #d3bdf0; border-color: #d3bdf0; }
        .navbar-inverse .navbar-nav > li > a,
        .navbar-inverse .navbar-text,
        .navbar-brand {
            font-family: 'Italiana', serif;
            color: #3c1361 !important;
        }
        .navbar-text { float: right; margin-top: 40px; }
        .navbar-nav > li > a { margin-top: 20px; }
        .navbar-brand { font-size: 24px; }
        .container-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .page-title {
            font-family: 'Italiana';
            color: #3c1361;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5931a9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background-color: #d3bdf0;
            color: #3c1361;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        a.action-link {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo Matos & Flores" style="height: 60px; display: inline-block; vertical-align: middle; margin-right: 8px;">
                Sistema Floricultura
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="homeFuncionario.php">Início</a></li>
            <li><a href="cadastraProdutos.php">Lista Produtos</a></li>
            <li><a href="lista_dica.php">Lista Dicas de Plantio</a></li>
            <li><a href="pedidos_andamento.php">Lista de Pedidos</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
        <span class="navbar-text">Usuário logado: <?php echo $_SESSION['user']->nome_funcionario; ?></span>
    </div>
</nav>

<div class="container">
    <div class="container-box">
        <h2 class="page-title">Lista de Dicas de Plantio</h2>

        <p>
            <a href="cadastra_dica.php" class="btn btn-custom">Cadastrar Nova Dica</a>
        </p>

        <table class="table table-bordered table-hover">
            <thead>
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
                            <a class="action-link" href="exibe_dica.php?iddica_plantio=<?= $dica['iddica_plantio'] ?>">Exibir</a>
                            <a class="action-link" href="altera_dica.php?id=<?= $dica['iddica_plantio'] ?>">Editar</a>
                            <a class="action-link" href="processa_exclui_dica.php?id=<?= $dica['iddica_plantio'] ?>" onclick="return confirm('Deseja realmente excluir esta dica?');" style="color:red;">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">Nenhuma dica cadastrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
