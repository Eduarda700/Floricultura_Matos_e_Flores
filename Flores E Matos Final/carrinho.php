<?php
include 'conexao.php';
include_once 'usuarioCliente.php';
session_start();

// Verifica se o usuário está logado e é cliente
if (!isset($_SESSION["user"]) || $_SESSION["tipo"] !== "cliente") {
    header("Location: index.php");
    exit;
}
$user = $_SESSION["user"];
$idusuario_cliente = $user->idusuario_cliente ?? null;

// Inicializa carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar produto ao carrinho
if (isset($_GET['acao']) && $_GET['acao'] === 'adicionar' && isset($_GET['id'])) {
    $idAdicionar = intval($_GET['id']);
    if (!isset($_SESSION['carrinho'][$idAdicionar])) {
        $_SESSION['carrinho'][$idAdicionar] = 1;
    } else {
        $_SESSION['carrinho'][$idAdicionar]++;
    }
    header("Location: carrinho.php");
    exit;
}

// Excluir produto do carrinho
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $idExcluir = intval($_GET['id']);
    if (isset($_SESSION['carrinho'][$idExcluir])) {
        unset($_SESSION['carrinho'][$idExcluir]);
    }
    header("Location: carrinho.php");
    exit;
}

// Limpar carrinho
if (isset($_GET['acao']) && $_GET['acao'] === 'limpar') {
    $_SESSION['carrinho'] = [];
    header("Location: carrinho.php");
    exit;
}

// Buscar dados dos usuários funcionária e proprietária
$query_funcionario = "SELECT idusuario_funcionario FROM usuario_funcionario LIMIT 1";
$result_funcionario = mysqli_query($conn, $query_funcionario);
$idusuario_funcionario = ($row = mysqli_fetch_assoc($result_funcionario)) ? $row['idusuario_funcionario'] : null;

$query_proprietaria = "SELECT idusuario_proprietaria FROM usuario_proprietaria LIMIT 1";
$result_proprietaria = mysqli_query($conn, $query_proprietaria);
$idusuario_proprietaria = ($row = mysqli_fetch_assoc($result_proprietaria)) ? $row['idusuario_proprietaria'] : null;

// Carregar todos os produtos
function carregarProdutos($conn) {
    $sql = "SELECT * FROM produto";
    $res = mysqli_query($conn, $sql);
    $produtos = [];
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $produtos[$row['idproduto']] = $row;
        }
    }
    return $produtos;
}

$produtosNoCarrinho = carregarProdutos($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Compra</title>
    <link rel="stylesheet" href="styleCarrinho.css">
    <style>
        .item { margin-bottom: 15px; }
        .item img { vertical-align: middle; margin-right: 10px; }
        .btn-link {
            text-decoration: none; padding: 8px 15px; background-color: #888;
            color: white; border-radius: 5px; margin-right: 10px;
        }
        .btn-link:hover { background-color: #555; }
        .buttons { margin-top: 20px; }
    </style>
    <script>
        function confirmarCompra() {
            return confirm("Deseja finalizar a compra?");
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Confirmação de Compra</h2>

    <?php if (empty($_SESSION['carrinho'])): ?>
        <p>Seu carrinho está vazio.</p>
        <a href="homeCliente.php" class="btn-link">Voltar para Produtos</a>
    <?php else: ?>
        <form action="processa_venda.php" method="post" onsubmit="return confirmarCompra();">
            <?php foreach ($_SESSION['carrinho'] as $idproduto => $quantidade):
    if (!isset($produtosNoCarrinho[$idproduto])) continue;
    $produto = $produtosNoCarrinho[$idproduto];
                $caminhoImagem = "imagens/" . $produto['cod_produto'];
                $extensoes = ['jpg', 'jpeg', 'png', 'webp'];
                $imagemFinal = 'imagens/default.png';
                foreach ($extensoes as $ext) {
                    if (file_exists("$caminhoImagem.$ext")) {
                        $imagemFinal = "$caminhoImagem.$ext";
                        break;
                    }
                }
            ?>
                <div class="item">
                    <img src="<?php echo $imagemFinal; ?>" width="100">
                    <strong><?php echo htmlspecialchars($produto['nome_produto']); ?></strong><br>
                    Valor unitário: R$ <?php echo number_format($produto['valor_produto'], 2, ',', '.'); ?><br>

                    <label>Quantidade:</label>
                    <input type="number" name="quantidade[]" value="<?php echo $quantidade; ?>" min="1" required>
                    <input type="hidden" name="idproduto[]" value="<?php echo $idproduto; ?>">

                    <a href="carrinho.php?acao=excluir&id=<?php echo $idproduto; ?>" 
                       onclick="return confirm('Deseja remover este produto do carrinho?');"
                       style="color: red; margin-left: 15px;">Excluir</a>
                </div>
                <hr>
            <?php endforeach; ?>

            <label for="modo_pagamento">Modo de Pagamento:</label>
            <select name="idmodo_de_pagamento" id="modo_pagamento" required>
                <option value="">Selecione...</option>
                <option value="1">Pix</option>
                <option value="2">Cartão</option>
                <option value="3">Dinheiro</option>
            </select>

            <input type="hidden" name="idusuario_funcionario" value="<?php echo $idusuario_funcionario; ?>">
            <input type="hidden" name="idusuario_proprietaria" value="<?php echo $idusuario_proprietaria; ?>">
            <input type="hidden" name="idusuario_cliente" value="<?php echo $idusuario_cliente; ?>">

            <div class="buttons">
                <a href="homeCliente.php" class="btn-link">Adicionar mais produtos</a>
                <a href="carrinho.php?acao=limpar" onclick="return confirm('Deseja limpar todo o carrinho?');" class="btn-link" style="background-color: #c0392b;">Limpar Carrinho</a>
                <button type="submit">Finalizar Compra</button>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
