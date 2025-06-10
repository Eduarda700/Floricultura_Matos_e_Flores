<?php
include_once './conexao.php';
include_once './usuarioProprietaria.php';
session_start();

if (!isset($_SESSION['user'])){
    $_SESSION['msg'] = "É necessário logar antes de acessar a página de menu!!";
    header("Location: index.php");
    exit;   
}

$idusuario_proprietaria = $_SESSION['user']->$idusuario_proprietaria;

header('Content-Type: application/json');

if (
    isset($_POST['fornecedor']) &&
    isset($_POST['telefone']) &&
    isset($_POST['email_fornecedor']) &&
    isset($_POST['cnpj_fornecedor']) &&
    isset($_POST['rua_fornecedor']) &&
    isset($_POST['numero_fornecedor']) &&
    isset($_POST['complemento_fornecedor']) &&
    isset($_POST['bairro_fornecedor']) &&
    isset($_POST['cidade_fornecedor']) &&
    isset($_POST['estado_fornecedor']) &&
    isset($_POST['cep_fornecedor'])){ 

 $sql = "INSERT INTO fornecedor (fornecedor, telefone, email_fornecedor, cnpj_fornecedor, rua_fornecedor, numero_fornecedor, complemento_fornecedor, bairro_fornecedor, cidade_fornecedor, estado_fornecedor, cep_fornecedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssssssssi", 
    $_POST['fornecedor'],         
    $_POST['telefone'],            
    $_POST['email_fornecedor'],
    $_POST['cnpj_fornecedor'],  
    $_POST['rua_fornecedor'],      
    $_POST['numero_fornecedor'],  
    $_POST['complemento_fornecedor'], 
    $_POST['bairro_fornecedor'],    
    $_POST['cidade_fornecedor'],   
    $_POST['estado_fornecedor'],   
    $_POST['cep_fornecedor'],                         
);

    if ($stmt->execute()) {
        $msg = "Fornecedor cadastrado com sucesso!";
    } else {
        $msg = "Erro: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    $msg = "Erro: Dados insuficientes para cadastrar o fornecedor.";
}

$conn->close();
echo json_encode(['msg' => $msg]);
?>
