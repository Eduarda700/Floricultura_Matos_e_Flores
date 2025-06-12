google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(desenharTodos);

function desenharTodos() {
  desenharGrafico('graficoProdutos', 'graficoProdutosMaisVendidos.php', 'Produtos Mais Vendidos');
  desenharGrafico('graficoEstoque', 'graficoBaixoEstoque.php', 'Produtos com Baixo Estoque');
  desenharGrafico('graficoFuncionarios', 'graficoProdutividadeFuncionarios.php', 'Produtividade de Funcionários');
  desenharGrafico('graficoVendas', 'graficoVendasPorMes.php', 'Vendas por Mês');
}

function desenharGrafico(divId, url, titulo) {
  fetch(url)
    .then(res => res.json())
    .then(dados => {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Categoria');
      data.addColumn('number', 'Quantidade');
      data.addRows(dados);

      var options = { title: titulo, width: 600, height: 400 };
      var chart = new google.visualization.PieChart(document.getElementById(divId));
      chart.draw(data, options);
    });
}