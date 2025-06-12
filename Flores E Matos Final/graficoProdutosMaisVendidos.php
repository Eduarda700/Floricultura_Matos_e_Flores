<?php
include "conexao.php";
$sql = "SELECT p.nome_produto, COUNT(*) as total
        FROM venda v
        JOIN produto p ON v.idproduto = p.idproduto
        GROUP BY p.nome_produto
        ORDER BY total DESC
        LIMIT 10";
$result = $conn->query($sql);
$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = [$row['nome_produto'], (int)$row['total']];
}
echo json_encode($dados);
?>