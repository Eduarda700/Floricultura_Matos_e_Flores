<?php
include "conexao.php";
$sql = "SELECT DATE_FORMAT(data_venda, '%Y-%m') as mes, COUNT(*) as total
        FROM venda
        GROUP BY mes
        ORDER BY mes";
$result = $conn->query($sql);
$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = [$row['mes'], (int)$row['total']];
}
echo json_encode($dados);
?>