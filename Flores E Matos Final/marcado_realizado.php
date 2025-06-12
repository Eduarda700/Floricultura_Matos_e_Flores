<?php
header('Content-Type: application/json');
include_once("conexao.php");

if (isset($_POST['idvenda'])) {
    $idvenda = intval($_POST['idvenda']);

    // Verificar se já existe na tabela pedidos_realizados (evitar duplicidade)
    $checkSql = "SELECT * FROM pedidos_realizados WHERE idvenda = $idvenda";
    $checkRes = $conn->query($checkSql);
    if ($checkRes && $checkRes->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Pedido já marcado como realizado.']);
        exit;
    }

    // Buscar dados do pedido na tabela venda
    $sql = "SELECT idproduto, idusuario_cliente FROM venda WHERE idvenda = $idvenda LIMIT 1";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        // Buscar o idfornecedor do produto
        $idproduto = $row['idproduto'];
        $idusuario_cliente = $row['idusuario_cliente'];

        $fornecedorSql = "SELECT idfornecedor FROM produto WHERE idproduto = $idproduto LIMIT 1";
        $fornecedorRes = $conn->query($fornecedorSql);
        if ($fornecedorRes && $fornecedorRes->num_rows > 0) {
            $fornecedorRow = $fornecedorRes->fetch_assoc();
            $idfornecedor = $fornecedorRow['idfornecedor'];
        } else {
            $idfornecedor = "NULL";
        }

        // Inserir na tabela pedidos_realizados
        $sqlInsert = "INSERT INTO pedidos_realizados (idproduto, idfornecedor, idusuario_cliente, idvenda) VALUES (
            $idproduto,
            " . ($idfornecedor !== "NULL" ? $idfornecedor : "NULL") . ",
            $idusuario_cliente,
            $idvenda
        )";

        if ($conn->query($sqlInsert)) {
            echo json_encode(['success' => true, 'message' => 'Pedido marcado como realizado com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao inserir pedido realizado: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Pedido não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetro idvenda não enviado.']);
}
?>
