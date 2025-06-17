<?php
include_once 'conexao.php';

$nome = $_POST['nome_produto'];
$codigo = $_POST['cod_produto'];
$descricao = $_POST['descricao_produto'];
$quantidade = $_POST['quantidade_produto'];
$valor = $_POST['valor_produto'];
$idfornecedor = $_POST['idfornecedor'];

// Verificar se o código já existe
$verifica = $conn->prepare("SELECT cod_produto FROM produto WHERE cod_produto = ?");
$verifica->bind_param("s", $codigo);
$verifica->execute();
$verifica->store_result();

if ($verifica->num_rows > 0) {
    echo "<script>alert('Erro: Código de produto já existente!'); window.location.href='index.php';</script>";
    exit;
}

// Inserir o novo produto
$stmt = $conn->prepare("INSERT INTO produto (nome_produto, cod_produto, descricao_produto, quantidade_produto, valor_produto, idfornecedor) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssisi", $nome, $codigo, $descricao, $quantidade, $valor, $idfornecedor);
$stmt->execute();

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION); // Pega a extensão do arquivo
    $nomeImagem = $codigo . '.' . $extensao; // Usa o código do produto como nome da imagem
    $caminhoTemporario = $_FILES['imagem']['tmp_name'];

    // Caminho onde a imagem será salva
    $destino = 'imagens/' . $nomeImagem;

    // Move o arquivo para a pasta destino
    move_uploaded_file($caminhoTemporario, $destino);
}

header("Location: cadastraProdutos.php");
exit;
?>
