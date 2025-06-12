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
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Produtos</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroProduto">Novo Produto</button>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
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
                    <a href="editarProduto.php?id=<?= $row['idproduto'] ?>" class="btn btn-sm">Editar</a>
                    <a href="excluirProduto.php?id=<?= $row['idproduto'] ?>" class="btn btn-sm">Excluir</a>
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
