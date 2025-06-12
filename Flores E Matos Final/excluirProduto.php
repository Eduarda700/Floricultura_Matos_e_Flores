<?php
include_once './conexao.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Verifica se há vendas com esse produto
    $verifica = $conn->query("SELECT 1 FROM venda WHERE idproduto = $id LIMIT 1");

    if ($verifica && $verifica->num_rows > 0) {
        echo "Erro: Este produto está associado a uma ou mais vendas e não pode ser excluído.";
    } else {
        $sql = "DELETE FROM produto WHERE idproduto = $id";
        if ($conn->query($sql)) {
            header("Location: cadastraProdutos.php");
            exit;
        } else {
            echo "Erro ao excluir: " . $conn->error;
        }
    }
} else {
    echo "ID não fornecido.";
}

?>
