<?php
include "conexao.php";
$sql = "SELECT nome_produto, quantidade_produto
        FROM produto
        WHERE quantidade_produto < 10";
$result = $conn->query($sql);
$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = [$row['nome_produto'], (int)$row['quantidade_produto']];
}
echo json_encode($dados);
?>