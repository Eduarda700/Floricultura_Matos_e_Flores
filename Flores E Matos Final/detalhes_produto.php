<?php
include 'conexao.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) exit;

$q = mysqli_query($conn, "SELECT * FROM produto WHERE cod_produto = $id");
$p = mysqli_fetch_assoc($q) ?? exit;

?>

<img src="img/plantas.jpg" alt="<?php echo htmlspecialchars($p['nome_produto']); ?>">
<h3><?php echo htmlspecialchars($p['nome_produto']); ?></h3>
<p><strong>R$ <?php echo number_format($p['valor_produto'], 2, ',', '.'); ?></strong></p>
<p><?php echo nl2br(htmlspecialchars($p['descricao_produto'])); ?></p>

<form method="post" action="adicionar_carrinho.php">
    <input type="hidden" name="idproduto" value="<?php echo $p['idproduto']; ?>">
    <label>Quantidade:
        <input type="number" name="quantidade" value="1" min="1">
    </label><br><br>
    <button type="submit" class="btn btn-primary">Adicionar ao Carrinho</button>
</form>
