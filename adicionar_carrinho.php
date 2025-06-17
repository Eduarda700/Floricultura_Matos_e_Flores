<?php
session_start();

if (!isset($_POST['idproduto'], $_POST['quantidade'])) {
    die("Dados incompletos.");
}

$idproduto = intval($_POST['idproduto']);
$quantidade = intval($_POST['quantidade']);

if ($idproduto <= 0 || $quantidade <= 0) {
    die("Dados inválidos.");
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_SESSION['carrinho'][$idproduto])) {
    $_SESSION['carrinho'][$idproduto] += $quantidade;
} else {
    $_SESSION['carrinho'][$idproduto] = $quantidade;
}

header("Location: carrinho.php");
exit;
?>
