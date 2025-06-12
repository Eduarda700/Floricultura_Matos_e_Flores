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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <button type="submit" class="btn btn-success">Salvar Alterações</button>
    <a href="cadastraProdutos.php" class="btn btn-secondary">Cancelar</a>
</form>
</body>
</html>
