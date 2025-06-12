<?php
include_once './conexao.php';
header('Content-Type: application/json'); 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idfornecedor'])) {
    $idfornecedor = $_POST['idfornecedor'];

    $stmt = $conn->prepare("DELETE FROM fornecedor WHERE idfornecedor = ?");
    $stmt->bind_param("i", $idfornecedor);
    if ($stmt->execute()) {
        echo json_encode(["msg" => "Fornecedor deletado com sucesso!"]);
    } else {
        echo json_encode(["msg" => "Erro ao deletar o fornecedor."]);
    }
} else {
    echo json_encode(["msg" => "ID do fornecedor não enviado."]);
}
?>
