<?php
include_once './conexao.php';
include_once './usuarioProprietaria.php';
session_start();


if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "É necessário logar antes de acessar a página de menu!!";
    header("Location: index.php");
    exit;   
}


if (isset($_SESSION['user']->idusuario_proprietaria)) {
    $idusuario_proprietaria = $_SESSION['user']->idusuario_proprietaria;
    echo "ID do Usuário Proprietário: " . $idusuario_proprietaria;

}

header('Content-Type: application/json');

if ( isset($_POST['idfornecedor']) && isset($_POST['fornecedor'])  && isset($_POST['telefone'])&& isset($_POST['email_fornecedor']) && isset($_POST['cnpj_fornecedor']) && isset($_POST['rua_fornecedor']) && isset($_POST['numero_fornecedor']) && isset($_POST['complemento_fornecedor']) && isset($_POST['bairro_fornecedor']) && isset($_POST['cidade_fornecedor']) && isset($_POST['estado_fornecedor']) && isset($_POST['cep_fornecedor'])) {
    
    $idfornecedor = intval($_POST['idfornecedor']);
    $fornecedor = $conn->real_escape_string($_POST['fornecedor']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $email = $conn->real_escape_string($_POST['email_fornecedor']);
    $cnpj = $conn->real_escape_string($_POST['cnpj_fornecedor']);
    $rua = $conn->real_escape_string($_POST['rua_fornecedor']);
    $numero = $conn->real_escape_string($_POST['numero_fornecedor']);
    $complemento = $conn->real_escape_string($_POST['complemento_fornecedor']);
    $bairro = $conn->real_escape_string($_POST['bairro_fornecedor']);
    $cidade = $conn->real_escape_string($_POST['cidade_fornecedor']);
    $estado = $conn->real_escape_string($_POST['estado_fornecedor']);
    $cep = $conn->real_escape_string($_POST['cep_fornecedor']);

    $stmt = $conn->prepare("UPDATE fornecedor SET fornecedor = ?,  telefone = ?, email_fornecedor = ?, cnpj_fornecedor = ?,  rua_fornecedor = ?, numero_fornecedor = ?, complemento_fornecedor = ?, bairro_fornecedor = ?,  cidade_fornecedor = ?, estado_fornecedor = ?, cep_fornecedor = ? WHERE idfornecedor = ?");

    
    $stmt->bind_param("ssssssssssii", $fornecedor, $telefone, $email, $cnpj, $rua, $numero, $complemento, $bairro, $cidade, $estado, $cep, $idfornecedor);

    if ($stmt->execute()) {
        http_response_code(200);
        $msg = "Fornecedor atualizado com sucesso!";
    } else {
        http_response_code(400);
        $msg = "Erro ao atualizar fornecedor: " . $stmt->error;
    }

    $stmt->close();
} else {
    http_response_code(400);
    $msg = "Erro: Dados insuficientes para atualizar o fornecedor.";
}

$conn->close();

echo json_encode(['msg' => $msg]);
?>