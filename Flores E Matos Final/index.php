<?php
include_once 'conexao.php';
include_once 'usuarioCliente.php';
include_once 'usuarioFuncionario.php';
include_once 'usuarioProprietaria.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // ================== CLIENTE ====================
    $query = "SELECT * FROM usuario_cliente WHERE email_cliente = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_assoc($result);
        $user = new usuarioCliente(
            $dados["idusuario_cliente"], $dados["nome_cliente"], $dados["senha_cliente"], $dados["email_cliente"],
            $dados["telefone_cliente"], $dados["cpf_cliente"], $dados["data_nascimento"], $dados["cep_cliente"],
            $dados["rua_cliente"], $dados["numero_cliente"], $dados["complemento_cliente"],
            $dados["bairro_cliente"], $dados["cidade_cliente"], $dados["estado_cliente"]
        );
        if ($user->validaSenha($senha)) {
            $_SESSION["user"] = $user;
            $_SESSION["tipo"] = "cliente";
            header("Location: homeCliente.php");
            exit;
        } else {
            $_SESSION['msg'] = 'Senha incorreta';
            header("Location: index.php");
            exit;
        }
    }

    // ================== FUNCIONÁRIO ====================
    $query = "SELECT * FROM usuario_funcionario WHERE email_funcionario = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_assoc($result);
        $user = new usuarioFuncionario(
            $dados["idusuario_funcionario"], $dados["nome_funcionario"],
            $dados["email_funcionario"], $dados["senha_funcionario"]
        );
        if ($user->validaSenha($senha)) {
            $_SESSION["user"] = $user;
            $_SESSION["tipo"] = "funcionario";
            header("Location: homeFuncionario.php");
            exit;
        } else {
            $_SESSION['msg'] = 'Senha incorreta';
            header("Location: index.php");
            exit;
        }
    }

    // ================== PROPRIETÁRIA ====================
    $query = "SELECT * FROM usuario_proprietaria WHERE email_proprietaria = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_assoc($result);
        $user = new usuarioProprietaria(
            $dados["idusuario_proprietaria"], $dados["nome_proprietaria"],
            $dados["email_proprietaria"], $dados["senha_proprietaria"]
        );
        if ($user->validaSenha($senha)) {
            $_SESSION["user"] = $user;
            $_SESSION["tipo"] = "proprietaria";
            header("Location: homeProprietaria.php");
            exit;
        } else {
            $_SESSION['msg'] = 'Senha incorreta';
            header("Location: index.php");
            exit;
        }
    }

    // ================== NENHUM USUÁRIO ENCONTRADO ====================
    $_SESSION['msg'] = 'Usuário não encontrado';
    header("Location: index.php");
    exit;
}
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login do Sistema</title>
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
            font-family: 'Italiana', serif;
            color: #210857;
        }

        .form-container {
            background-color: #f6efff;
            border-radius: 20px;
            padding: 40px;
            margin-top: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-bottom: -20px;
        }

        .logo img {
            height: 90px;
        }

        h2 {
            font-family: 'Italiana';
            font-size: 30px;
            color: #210857;
            text-align: center;
            margin-top: 40px;
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
            background-color: #3c1361;
            color: white;
            border-radius: 10px;
            padding: 10px 30px;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background-color: #3c1361;
        }

        .alert {
            margin-top: 15px;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer-text a {
            color: #3c1361;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="logo">
    <img src="img/logo.png" alt="Logo Matos & Flores">
</div>

<h2>Bem vindo, à Flores e Matos!</h2>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-container">
                <?php if (isset($_SESSION['msg'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php 
                            echo $_SESSION['msg']; 
                            unset($_SESSION['msg']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail do Usuário</label>
                        <input type="text" id="email" name="email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control" required />
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Entrar" class="btn btn-custom" />
                    </div>
                </form>

                <div class="footer-text">
                    <p>Não tem uma conta? <a href="cadastroCliente.php">Cadastre-se aqui</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php if (isset($_SESSION['msg'])): ?>
    <div class="alert alert-danger" style="margin-top:10px;">
      <?php 
        echo $_SESSION['msg']; 
        unset($_SESSION['msg']);
      ?>
    </div>
  <?php endif; ?>
</body>
</html>