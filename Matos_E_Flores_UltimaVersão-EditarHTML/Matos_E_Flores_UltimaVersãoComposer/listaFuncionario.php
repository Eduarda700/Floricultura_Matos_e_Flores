<?php
include_once './conexao.php';
include_once './usuarioProprietaria.php';
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "É necessário logar antes de acessar a página de menu!!";
    header("Location: index.php");
    exit;
}

if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    $stmt = $conn->prepare("DELETE FROM usuario_funcionario WHERE idusuario_funcionario = ?");
    $stmt->bind_param("i", $idExcluir);
    $stmt->execute();
    $stmt->close();

    header("Location: listaFuncionario.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Funcionários</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-family: 'Italiana'; color: #3c1361 !important; font-size: 24px; }
        body { background-color: #f1e4ff; }
        .navbar-inverse { background-color: #d3bdf0; border-color: #d3bdf0; }
        .navbar-inverse .navbar-header> li > a  { color: #3c1361 !important; }
        .navbar-inverse .navbar-nav > li > a { font-family: 'Italiana'; color: #3c1361 !important;float: right; margin-top: 20px; }
        .navbar .navbar-text { color: #3c1361 !important; float: right; margin-top: 40px; }
        .page-title-box {
            font-family: 'Italiana';
            background-color: #d3bdf0;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .page-title-box h2 { color: #3c1361; margin: 0; }
        .table-bordered > thead > tr { background-color: #d3bdf0; color: #3c1361; }
        .btn-danger { background-color: #9c27b0; border-color: #8e24aa; }
        .btn-danger:hover { background-color: #7b1fa2; border-color: #6a1b9a; }
        .logo img {  width: 300px; height: auto; margin-top: 100px; }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
           <a class="navbar-brand" href="#">
    <img src="img/logo.png" alt="Logo Matos & Flores" style="height: 60px; display: inline-block; vertical-align: middle; margin-right: 8px;"> Sistema Floricultura </a>
            </a>
        </div>
        
        <ul class="nav navbar-nav">
            <li><a href="homeProprietaria.php">Início</a></li>
            <li><a href="cadastroFuncionario.php">Cadastro Funcionário</a></li>
            <li><a href="listaFornecedores.php">Lista Fornecedores</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
        <span class="navbar-text">Usuário logado: <?php echo $_SESSION['user']->nome_proprietaria; ?></span>
    </div>
</nav>

<div class="container">
    <div class="page-title-box">
        <h2>Funcionários Cadastrados</h2>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta = mysqli_query($conn, "SELECT idusuario_funcionario, nome_funcionario, email_funcionario, senha_funcionario FROM usuario_funcionario");
            while ($dados = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($dados['idusuario_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($dados['nome_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($dados['email_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($dados['senha_funcionario']); ?></td>
                    <td>
                        <a href="listaFuncionario.php?excluir=<?php echo $dados['idusuario_funcionario']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">
                            Deletar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>