<div class="modal fade" id="modalCadastroProduto" tabindex="-1" aria-labelledby="modalCadastroProdutoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background-color: #f1e7fd;">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCadastroProdutoLabel" style="color:#5d3d93;">Cadastro de Produtos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form action="salvarProduto.php" method="POST" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-md-8">
              <label class="form-label">Nome do Produto</label>
              <input type="text" name="nome_produto" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Código</label>
              <input type="text" name="cod_produto" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Descrição do produto</label>
            <textarea name="descricao_produto" class="form-control" rows="3" maxlength="6000"></textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Quantidade em Estoque</label>
              <input type="number" name="quantidade_produto" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Valor Unitário</label>
              <input type="text" name="valor_produto" class="form-control" placeholder="R$ 00.00">
            </div>
            <div class="col-md-4">
              <label class="form-label">ID Fornecedor</label>
              <input type="text" name="idfornecedor" class="form-control">
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Imagem do Produto:</label>
            <input type="file" name="imagem" class="form-control" id="imagem">
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-success">Salvar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
