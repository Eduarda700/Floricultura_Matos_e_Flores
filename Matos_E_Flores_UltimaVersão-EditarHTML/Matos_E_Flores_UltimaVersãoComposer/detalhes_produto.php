<?php
include 'conexao.php';

$idproduto = $_GET['id'] ?? '';
if (!$idproduto) exit;

// Prevenir SQL Injection
$idproduto = mysqli_real_escape_string($conn, $idproduto);

$q = mysqli_query($conn, "SELECT * FROM produto WHERE idproduto = '$idproduto'");
$p = mysqli_fetch_assoc($q) ?? exit;

// Lógica para determinar a imagem do produto
$caminhoImagem = "imagens/" . $p['cod_produto'];
$extensoes = ['jpg', 'jpeg', 'png', 'webp'];
$imagemFinal = 'imagens/default.png'; // imagem padrão

foreach ($extensoes as $ext) {
    if (file_exists("$caminhoImagem.$ext")) {
        $imagemFinal = "$caminhoImagem.$ext";
        break;
    }
}
?>

<img src="<?= htmlspecialchars($imagemFinal) ?>" alt="<?= htmlspecialchars($p['nome_produto']) ?>">
<h3><?= htmlspecialchars($p['nome_produto']) ?></h3>
<p><strong>R$ <?= number_format($p['valor_produto'], 2, ',', '.') ?></strong></p>
<p><?= nl2br(htmlspecialchars($p['descricao_produto'])) ?></p>

<form method="post" action="adicionar_carrinho.php">
    <input type="hidden" name="idproduto" value="<?= htmlspecialchars($p['idproduto']) ?>">

    <label>Quantidade:
        <input type="number" name="quantidade" value="1" min="1">
    </label><br><br>
    <button type="submit" class="btn btn-primary">Adicionar ao Carrinho</button>
</form>
