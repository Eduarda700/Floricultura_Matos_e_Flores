<?php
include "conexao.php";
$sql = "SELECT uf.nome_funcionario, COUNT(*) as total
        FROM venda v
        JOIN usuario_funcionario uf ON v.idusuario_funcionario = uf.idusuario_funcionario
        GROUP BY uf.nome_funcionario
        ORDER BY total DESC";
$result = $conn->query($sql) or die("Erro na SQL: " . $conn->error);
$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = [$row['nome_funcionario'], (int)$row['total']];
}
echo json_encode($dados);
?>