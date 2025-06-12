<?php
include_once './conexao.php';
include_once './usuarioFuncionario.php';

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "INSERT INTO usuario_funcionario (nome_funcionario, email_funcionario, senha_funcionario) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senha);

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Funcionário cadastrado com sucesso!";
        $tipoMensagem = "success";
    } else {
        $mensagem = "Erro ao cadastrar funcionário.";
        $tipoMensagem = "danger";
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3e8ff;
            font-family: 'Italiana';
            color: #210857;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 40px;
            margin-top: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo img {
            height: 100px;
        }

        h2 {
            font-family: 'Italiana';
            font-size: 30px;
            color: #210857;
            margin-left: 600px;
            margin-bottom: -40px;
        }

        label {
            color: #3c1361;
            margin-bottom: 5px;
            font-size: 16px;
        }

        input.form-control {
            background-color: #f1e4ff;
            border: 1px solid #d3bdf0;
            border-radius: 10px;
            height: 45px;
            font-size: 15px;
        }

        .btn-custom {
            background-color: #7b2cbf;
            color: white;
            border-radius: 10px;
            padding: 10px 30px;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background-color: #5a189a;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }

        .footer-text a {
            color: #210857;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

 <div class="logo">
      <img src="img/logo.png" alt="Logo Matos & Flores" style="height: 90px; display: inline-block; vertical-align: middle; margin-right: 8px;">  
 </div>

 <h2>Cadastro de Funcionário</h2>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">

                    <?php if (!empty($mensagem)): ?>
                        <div class="alert alert-<?php echo $tipoMensagem; ?> text-center" role="alert">
                            <?php echo $mensagem; ?>
                        </div>
                    <?php endif; ?>

                   <form method="POST" action="">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Funcionário</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email do Funcionário</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" id="senha" name="senha" class="form-control" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-custom">Cadastrar</button>
    </div>
</form>

                    <div class="footer-text">
                     <p>Já concluiu os cadastros?</p>
                     <div class="link-linha">
                     <a href="homeProprietaria.php">Volte para home</a> |
                     <a href="listaFuncionario.php">Lista de Funcionários</a> |
                     <a href="listaFornecedores.php">Lista de Fornecedores</a>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>