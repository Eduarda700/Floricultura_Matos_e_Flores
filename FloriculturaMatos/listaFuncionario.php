<?php
include_once './conexao.php';
include_once './usuarioProprietaria.php';
session_start();

if (!isset($_SESSION['user'])){
    $_SESSION['msg'] = "É necessário logar antes de acessar a página de menu!!";
    header("Location: index.php");
    exit;   
}
?>
   
   
<html>
<head>
    <meta charset="UTF-8">
    <title>Página Proprietária</title>
   
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #B0C4DE;
        }

        .navbar-brand {
            font-family:'Italiana';
            color: #9932CC !important;
            font-size: 24px;
        }

        .navbar .navbar-text {
            color: #fff !important;
        }

        .logo-container {
            text-align: center;
            margin-top: 20px;
        }

        .logo-container img {
            max-width: 200px;
        }

        .title-box {
            background-color: #9932CC;
            border-radius: 10px;
            padding: 15px;
            margin: 20px auto;
            text-align: center;
            max-width: 600px;
        }

        h2 {
             font-family:'Italiana';
            color: #210857;
            margin-left: 550px;
            margin-bottom: -20px;
        }

        .table-container {
            max-width: 900px;
            margin: auto;
        }

        .table-header-custom {
            background-color: #9932CC;
            color: white;
        }

        .table td, .table th {
            color: black;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Página da Proprietária</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="homeProprietaria.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                </ul>
                <span class="navbar-text">
                    Usuário logado: <?php echo $_SESSION['user']->nome_proprietaria; ?></span>
                </span>
            </div>
        </div>
    </nav>

    <div class="logo-container">
        <img src="logo.png" alt="Logo da Floricultura">
    </div>

        <h2>Lista de Funcionários</h2>

    <div class="table-container">
    <table class="table table-striped table-bordered">
        <thead class="table-header-custom">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Senha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once './conexao.php';
            $consulta = mysqli_query($conn, "SELECT idusuario_funcionario, nome_funcionario, email_funcionario, senha_funcionario FROM usuario_funcionario");

            while ($dados = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($dados['idusuario_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($dados['nome_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($dados['email_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($dados['senha_funcionario']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>