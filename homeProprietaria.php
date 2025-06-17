<?php
include_once './conexao.php';
include_once './usuarioProprietaria.php';
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "É necessário logar antes de acessar a página de menu!!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home Proprietária - Sistema Floricultura</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f1e4ff; }
        .navbar-inverse { background-color: #d3bdf0; border-color: #d3bdf0; }
        .navbar-inverse .navbar-header > li > a { color: #3c1361 !important; }
        .navbar-inverse .navbar-nav > li > a {
            font-family: 'Italiana';
            color: #3c1361 !important;
            float: right;
            margin-top: 20px;
        }
        .navbar-text {
            color: #3c1361 !important;
            float: right;
            margin-top: 40px;
        }
        .navbar-brand {
            font-family: 'Italiana', serif;
            color: #3c1361 !important;
            font-size: 24px;
        }
        .page-title-box {
            font-family: 'Italiana';
            background-color: #d3bdf0;
            padding: 15px;
            border-radius: 10px;
            margin: 40px auto 20px auto;
            text-align: center;
            max-width: 600px;
        }
        .page-title-box h2 {
            color: #3c1361;
            margin: 0;
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
            <li><a href="homeProprietaria.php">Início</a></li>
            <li><a href="cadastroFuncionario.php">Cadastro Funcionário</a></li>
            <li><a href="listaFuncionario.php">Lista Funcionários</a></li>
            <li><a href="listaFornecedores.php">Lista Fornecedores</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
        <span class="navbar-text">Usuário logado: <?php echo $_SESSION['user']->nome_proprietaria; ?></span>
    </div>
</nav>

<div class="container">
    <div class="page-title-box">
        <h2>Bem-vinda, Margarida Matos!</h2>
    </div>
</div>

</body>
</html>