<?php
include 'conexao.php';

// Consulta para listar produtos
$sql = "SELECT * FROM produto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
     <style>
        body {
            background-color: #f1e4ff;
            font-family: Arial, sans-serif;
            padding-top: 80px;
        }

        .navbar {
            background-color: #d3bdf0;
        }

        .navbar-brand {
            font-family: 'Italiana', serif;
            color: #3c1361 !important;
            font-size: 24px;
        }

        .nav-link {
            color: #3c1361 !important;
            font-family: 'Italiana', serif;
        }

        h2 {
            font-family: 'Italiana', serif;
            color: #3c1361;
        }

        .btn-novo {
            background-color: #3c1361;
            color: white;
            border: none;
            border-radius: 6px;
        }

        .btn-novo:hover {
            background-color: #2a0d47;
        }

        .btn-editar {
            background-color: #d3bdf0;
            color: #3c1361;
            border: none;
            border-radius: 4px;
        }

        .btn-editar:hover {
            background-color: #c0aee0;
        }

        .btn-excluir {
            background-color: #3c1361;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .btn-excluir:hover {
            background-color: #2a0d47;
        }

        .table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #d3bdf0;
            color: #3c1361;
            font-weight: bold;
        }

        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <img src="img/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
            Floricultura
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
          </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="homeFuncionario.php">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastraProdutos.php">Lista Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="lista_dica.php">Lista Dicas de Plantio</a></li>
                <li class="nav-item"><a class="nav-link" href="pedidos_andamento.php">Lista de Pedidos </a></li>   
                <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
        </ul>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Produtos</h2>
        <button class="btn btn-novo" data-bs-toggle="modal" data-bs-target="#modalCadastroProduto">Novo Produto</button>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Código</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>ID Fornecedor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nome_produto']) ?></td>
                <td><?= htmlspecialchars($row['cod_produto']) ?></td>
                <td><?= $row['quantidade_produto'] ?></td>
                <td>R$ <?= $row['valor_produto'] ?></td>
                <td><?= $row['idfornecedor'] ?></td>
                <td>
                    <a href="editarProduto.php?id=<?= $row['idproduto'] ?>" class="btn btn-editar btn-sm">Editar</a>
                    <a href="excluirProduto.php?id=<?= $row['idproduto'] ?>" class="btn btn-excluir btn-sm">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<?php include 'modalProduto.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>