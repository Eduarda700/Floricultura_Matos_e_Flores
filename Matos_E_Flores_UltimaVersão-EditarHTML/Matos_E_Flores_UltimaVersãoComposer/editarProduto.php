<?php
include_once './conexao.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "SELECT * FROM produto WHERE idproduto = $id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $produto = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit;
    }
} else {
    echo "ID não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_produto'];
    $cod = $_POST['cod_produto'];
    $descricao = $_POST['descricao_produto'];
    $quantidade = $_POST['quantidade_produto'];
    $valor = $_POST['valor_produto'];
    $fornecedor = $_POST['idfornecedor'];

    $update = "UPDATE produto SET nome_produto='$nome', cod_produto='$cod', descricao_produto='$descricao', quantidade_produto='$quantidade', valor_produto='$valor', idfornecedor='$fornecedor' WHERE idproduto=$id";

    if ($conn->query($update)) {
        header("Location: cadastraProdutos.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1e4ff;
            padding: 20px;
        }

        .form-control {
            border: 1px solid #c8aee0;
            box-shadow: none;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #a678cf;
            box-shadow: 0 0 5px rgba(163, 120, 207, 0.5);
        }

        label {
            font-family: 'Italiana', serif;
            color: #3c1361;
            font-size: 16px;
        }

        h3 {
            font-family: 'Italiana', serif;
            color: #3c1361;
            margin-bottom: 25px;
        }

        .btn-salvar {
            background-color: #d3bdf0;
            color: #3c1361;
            border: none;
            border-radius: 6px;
        }

        .btn-salvar:hover {
            background-color: #b89ee0;
            color: #3c1361;
        }

        .btn-cancelar {
            background-color: #3c1361;
            color: white;
            border: none;
            border-radius: 6px;
        }

        .btn-cancelar:hover {
            background-color: #2a0d47;
            color: white;
        }

        .btn-group {
            margin-top: 20px;
        }
    </style>
</head>
<body class="container mt-5">

    <h3>Editar Produto</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nome do Produto</label>
            <input type="text" name="nome_produto" class="form-control" value="<?= htmlspecialchars($produto['nome_produto']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="cod_produto" class="form-control" value="<?= htmlspecialchars($produto['cod_produto']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Descrição</label>
            <textarea name="descricao_produto" class="form-control"><?= htmlspecialchars($produto['descricao_produto']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Quantidade</label>
            <input type="number" name="quantidade_produto" class="form-control" value="<?= $produto['quantidade_produto'] ?>">
        </div>

        <div class="mb-3">
            <label>Valor</label>
            <input type="text" name="valor_produto" class="form-control" value="<?= $produto['valor_produto'] ?>">
        </div>

        <div class="mb-3">
            <label>ID Fornecedor</label>
            <input type="number" name="idfornecedor" class="form-control" value="<?= $produto['idfornecedor'] ?>">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-salvar">Salvar Alterações</button>
            <a href="cadastraProdutos.php" class="btn btn-cancelar">Cancelar</a>
        </div>
    </form>
</body>
</html>
