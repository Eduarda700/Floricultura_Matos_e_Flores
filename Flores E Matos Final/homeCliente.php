<?php
include_once 'conexao.php';
include_once 'usuarioCliente.php';

session_start();

// Verificar se o usuário está logado e é um cliente
if (!isset($_SESSION["user"]) || $_SESSION["tipo"] !== "cliente") {
    header("Location: index.php");
    exit;
}

// Obter o usuário da sessão
$user = $_SESSION["user"];

// Consulta para obter produtos em destaque


$total = intval(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM produto"))['total']);


$res = mysqli_query($conn, "SELECT * FROM produto ORDER BY RAND() LIMIT 4");
?>

<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floricultura Matos e Flores - Página Inicial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="javascriptFornecedor.js"></script>
    <link rel="stylesheet" href="homeClienteCSS.css">
    <style>
    body {
    background-color: #F3EDFF;
    font-family: 'Italiana';
    margin: 0;
    padding: 0;
    color: #333;
}

/* Estilos do cabeçalho */
header {
    background-color: #3c1361;
    color: white;
    padding: 15px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.logo h1 {
    font-family: 'Italiana';
    margin: 0;
    font-size: 2.5em;
}

.logo span {
    font-size: 0.5em;
    display: block;
    text-align: center;
}

nav ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}

nav ul li a:hover {
    color: #d3bdf0;
}

.user-actions {
    display: flex;
    align-items: center;
}

.user-greeting {
    margin-right: 20px;
}

.logout-btn {
    background-color: #d3bdf0;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

.logout-btn:hover {
    background-color: #d3bdf0;
}

/* Estilos do banner */
.banner {
    width: 100%;
    max-height: 400px;
    overflow: hidden;
    margin-bottom: 30px;
}

.banner img {
    width: 100%;
    height: auto;
    display: block;
}

/* Estilos do conteúdo principal */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-title {
    font-family: 'Great Vibes', cursive;
    color: #3c1361;
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
}

/* Estilos para seções de produtos */
.products-section {
    margin-bottom: 40px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.product-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.product-image {
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    padding: 15px;
}

.product-title {
    font-weight: bold;
    margin-bottom: 5px;
}

.product-price {
    color: #3c1361;
    font-weight: bold;
    font-size: 1.2em;
}

.product-button {
    display: block;
    background-color: #3c1361;
    color: white;
    text-align: center;
    padding: 8px 0;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.product-button1 {
    display: block;
    background-color: #3c1361;
    color: white;
    text-align: center;
    padding: 8px 0;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.product-button:hover {
    background-color: #d3bdf0;
}
.product-button1:hover {
    background-color: #d3bdf0;
}


/* Estilos para categorias */
.categories-section {
    margin-bottom: 40px;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.category-card {
    position: relative;
    height: 150px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.category-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color:0 2px 5px rgba(216, 147, 223, 0.4); 
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s;
}

.category-card:hover .category-overlay {
    background-color: rgba(95, 0, 100, 0.8);
}

.category-name {
    color: white;
    font-weight: bold;
    font-size: 1.2em;
    text-align: center;
}

/* Estilos do rodapé */
footer {
    background-color: #3c1361;
    color: white;
    padding: 30px 0;
    margin-top: 40px;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.footer-section h3 {
    font-family: 'Great Vibes', cursive;
    font-size: 1.5em;
    margin-bottom: 15px;
}

.footer-section p {
    margin-bottom: 10px;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-links a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    margin-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

/* Responsividade */
@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        text-align: center;
    }
    
    nav ul {
        margin-top: 15px;
        justify-content: center;
    }
    
    nav ul li {
        margin: 0 10px;
    }
    
    .user-actions {
        margin-top: 15px;
        flex-direction: column;
    }
    
    .user-greeting {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .products-grid,
    .tips-grid,
    .categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
    }
    
    .tip-card {
        flex-direction: column;
    }
    
    .tip-image {
        flex: 0 0 150px;
    }
}
/* Estilos do modal do produto*/
#produtoModal {
  display: none;
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.6); z-index: 1000;
}
.modal-content {
  background: white; padding: 20px; border-radius: 8px;
  max-width: 500px; margin: 100px auto; position: relative;
}
.modal-close { position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 20px; }
.product-detalhes img { width: 100%; max-height: 300px; object-fit: cover; margin-bottom: 10px; }
 </style>
 

    
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Matos e Flores</h1>
                <span>Loja de Plantas Ornamenteis</span>
            </div>
            <nav>
                <ul>
                    <li><a href="homeCliente.php">Início</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="carrinho.php">Meus Pedidos</a></li>
                    <li><a href="dicas_plantio.php">Dicas de Plantio</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <div class="user-greeting">
                    Olá, <?php echo $user->nome_cliente; ?>!
                </div>
                <a href="logout.php" class="logout-btn">Sair</a>
            </div>
        </div>
    </header>

    <div class="banner">
        <img src="img/banner.png" alt="Banner Floricultura Matos e Flores">
    </div>

    <div class="container">
  <section class="products-section">
    <h2 class="section-title">Produtos em Destaque</h2>
    <div class="products-grid">
      <?php while($p = mysqli_fetch_assoc($res)): ?>
        <?php
          // Caminho base da imagem
          $caminhoBase = "imagens/" . $p['cod_produto'];
          $extensoes = ['jpg', 'jpeg', 'png', 'webp'];
          $imagemFinal = 'imagens/default.png'; // fallback

          foreach ($extensoes as $ext) {
              if (file_exists("$caminhoBase.$ext")) {
                  $imagemFinal = "$caminhoBase.$ext";
                  break;
              }
          }
        ?>
        <div class="product-card">
          <div class="product-image">
            <img src="<?= $imagemFinal ?>" alt="<?= htmlspecialchars($p['nome_produto']) ?>">
          </div>
          <div class="product-info">
            <div class="product-title"><?= htmlspecialchars($p['nome_produto']) ?></div>
            <div class="product-price">R$ <?= number_format($p['valor_produto'], 2, ',', '.') ?></div>
            <a href="#" class="product-button1" data-id="<?= $p['cod_produto'] ?>">Ver Detalhes</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>
</div>
            <div style="text-align: center; margin-top: 20px;">
            <a href="produtos.php" class="product-button" style="display: inline-block; padding: 10px 20px;">Ver Todos os Produtos</a>

            </div>
        </section>
        
<div id="produtoModal">
  <div class="modal-content">
    <span class="modal-close">&times;</span>
    <div class="product-detalhes"></div>
  </div>
</div>
        <script>
$('.product-button1').click(function(e){
  e.preventDefault();
  $.get('detalhes_produto.php', {id: $(this).data('id')}, function(data){
    $('.product-detalhes').html(data);
    $('#produtoModal').fadeIn();
  });
});
$('.modal-close, #produtoModal').click(function(e){
  if(e.target !== this) return;
  $('#produtoModal').fadeOut();
});
</script>

<footer>        
    <div class="footer-container">
            <div class="footer-section">
                <h3>Floricultura Matos e Flores</h3>
                <p>Sua melhor opção em flores e plantas ornamentais.</p>
                <p>Desde 2010 trazendo beleza e vida para sua casa.</p>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <p>Endereço: Rua das Flores, 123</p>
                <p>Telefone: (11) 1234-5678</p>
                <p>Email: contato@matoseflores.com.br</p>
            </div>
            <div class="footer-section">
                <h3>Redes Sociais</h3>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">WhatsApp</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Floricultura Matos e Flores. Todos os direitos reservados.</p>
        </div></footer>
</body>
</html>