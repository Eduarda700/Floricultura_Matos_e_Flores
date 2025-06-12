<?php
include 'conexao.php';
session_start();

$data_venda = date('Y-m-d');
$idmodo_de_pagamento = $_POST['idmodo_de_pagamento'] ?? null;
$idusuario_funcionario = $_POST['idusuario_funcionario'] ?? null;
$idusuario_proprietaria = $_POST['idusuario_proprietaria'] ?? null;
$idusuario_cliente = $_POST['idusuario_cliente'] ?? null;

$idprodutos = $_POST['idproduto'] ?? [];
$quantidades = $_POST['quantidade'] ?? [];

// Verificações iniciais
if (empty($idprodutos) || empty($quantidades) || count($idprodutos) !== count($quantidades)) {
    die("Erro: nenhum produto enviado para processar ou dados inconsistentes.");
}

// Preparar a query de inserção
$stmt = $conn->prepare("INSERT INTO venda (
    data_venda,
    idmodo_de_pagamento,
    idproduto,
    idusuario_funcionario,
    idusuario_proprietaria,
    idusuario_cliente
) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Erro ao preparar statement: " . $conn->error);
}

// Inserir os produtos
foreach ($idprodutos as $index => $idproduto) {
    $quantidade = intval($quantidades[$index]);

    // Inserir múltiplas linhas conforme a quantidade
    for ($i = 0; $i < $quantidade; $i++) {
        $stmt->bind_param(
            "siiiii",
            $data_venda,
            $idmodo_de_pagamento,
            $idproduto,
            $idusuario_funcionario,
            $idusuario_proprietaria,
            $idusuario_cliente
        );

        if (!$stmt->execute()) {
            echo "Erro ao inserir produto ID $idproduto: " . $stmt->error . "<br>";
        }
    }
}

$stmt->close();
$conn->close();

// Limpar carrinho
unset($_SESSION['carrinho']);

echo "<script>
    alert('Compra realizada com sucesso!');
    window.location.href = 'homeCliente.php';
</script>";
?>
