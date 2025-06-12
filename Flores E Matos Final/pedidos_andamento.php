<?php
include_once("conexao.php");

// Consulta pedidos em andamento da tabela venda
$sql = "SELECT 
    v.idvenda,
    p.nome_produto, 
    p.descricao_produto, 
    p.valor_produto, 
    u.nome_cliente, u.rua_cliente, u.numero_cliente, u.bairro_cliente, u.cidade_cliente,
    mp.cartao, mp.pix, mp.dinheiro
 
FROM venda v
INNER JOIN produto p ON v.idproduto = p.idproduto
INNER JOIN modo_de_pagamento mp ON v.idmodo_de_pagamento = mp.idmodo_de_pagamento
INNER JOIN usuario_cliente u ON v.idusuario_cliente = u.idusuario_cliente
LEFT JOIN pedidos_realizados prr ON prr.idvenda = v.idvenda
LEFT JOIN pedidos_realizados pr ON pr.idproduto = p.idproduto -- para pegar a imagem
WHERE prr.idvenda IS NULL"; // Seleciona só pedidos NÃO realizados

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Pedidos em Andamento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f4ecff; padding: 2rem; font-family: 'Segoe UI', sans-serif; }
    .titulo { color:#57396d; margin-bottom: 1.5rem; }
    .card-pedido {
      background: #fff; border-radius: 10px; box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      padding: 1.5rem; position: relative; height: 100%;
    }
    .preco {
      position: absolute; top: 0; right: 0; background-color: #f3eaff;
      color: #2c135f; font-weight: bold; padding: 0.8rem 1.5rem;
      border-radius: 0 10px 0 20px;
    }
    .imagem-produto {
      max-height: 100px; border-radius: 5px; margin-top: 1rem;
    }
    .btn-marcar-realizado {
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <h2 class="titulo">Pedidos em andamento</h2>

  <div class="container">
    <div class="row g-4">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="col-md-6">
            <div class="card-pedido shadow rounded d-flex flex-column justify-content-between">
              <div>
                <div class="preco">R$ <?= number_format($row['valor_produto'], 2, ',', '.') ?></div>
                <h5 class="fw-bold"><?= htmlspecialchars($row['nome_produto']) ?> – 500ml</h5>
                <p><?= nl2br(htmlspecialchars($row['descricao_produto'])) ?></p>
                <p><strong>Método de Pagamento:</strong> 
                  <span style="color: #57396d;">
                    <?= $row['pix'] ? 'Pix' : ($row['cartao'] ? 'Cartão' : 'Dinheiro') ?>
                  </span>
                </p>
                <p><strong>Endereço:</strong> Rua <?= htmlspecialchars($row['rua_cliente']) ?>, <?= htmlspecialchars($row['numero_cliente']) ?> – <?= htmlspecialchars($row['bairro_cliente']) ?>, <?= htmlspecialchars($row['cidade_cliente']) ?></p>
                <?php if (!empty($row['imagem'])): ?>
                  <img src="uploads/<?= htmlspecialchars($row['imagem']) ?>" alt="Produto" class="imagem-produto" />
                <?php endif; ?>
              </div>
              <button class="btn btn-success btn-marcar-realizado" data-id="<?= $row['idvenda'] ?>">Marcar como realizado</button>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">Nenhum pedido em andamento.</p>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function() {
      $('.btn-marcar-realizado').click(function() {
        const idvenda = $(this).data('id');
        const botao = $(this);
        botao.prop('disabled', true).text('Processando...');

        $.post('marcado_realizado.php', { idvenda }, function(response) {
          if (response.success) {
            alert(response.message);
            botao.closest('.col-md-6').fadeOut();
          } else {
            alert('Erro: ' + response.message);
            botao.prop('disabled', false).text('Marcar como realizado');
          }
        }, 'json').fail(() => {
          alert('Erro na requisição');
          botao.prop('disabled', false).text('Marcar como realizado');
        });
      });
    });
  </script>

</body>
</html>
