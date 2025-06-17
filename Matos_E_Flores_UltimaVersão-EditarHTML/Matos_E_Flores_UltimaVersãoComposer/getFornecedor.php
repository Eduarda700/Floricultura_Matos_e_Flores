<?php
include_once './conexao.php';
include_once './usuarioProprietaria.php';
session_start();

if (!isset($_SESSION['user'])){
    $_SESSION['msg'] = "É necessário logar antes de acessar a página de menu!!";
    header("Location: index.php");
    exit;   
}

$ini = isset($_GET['page']) ? ($_GET['page'] - 1) * 10 : 0;


$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';


$totalResult = $conn->query("SELECT COUNT(*) FROM fornecedor WHERE fornecedor LIKE '%" . $filtro . "%'");


$total = mysqli_fetch_array($totalResult);


$sql = "SELECT idfornecedor, fornecedor, telefone, email_fornecedor, cnpj_fornecedor, rua_fornecedor,  numero_fornecedor, complemento_fornecedor, bairro_fornecedor, cidade_fornecedor, estado_fornecedor, cep_fornecedor FROM fornecedor  WHERE fornecedor LIKE '%$filtro%' ORDER BY idfornecedor ASC LIMIT $ini, 10";
    
$result = $conn->query($sql);


$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);


$conn->close();


header('Content-type: application/json');
echo json_encode(['data' => $rows, "total" => $total[0]]);