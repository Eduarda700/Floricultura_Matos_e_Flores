<?php
include_once 'conexao.php';
include_once 'usuarioCliente.php';

session_start();

if (!isset($_SESSION["user"]) || $_SESSION["tipo"] !== "cliente") {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];

$query_dicas = "SELECT * FROM dicas_plantio ORDER BY iddica_plantio DESC LIMIT 3";
$result_dicas = mysqli_query($conn, $query_dicas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <title>Dicas de Plantio - Matos e Flores</title>
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

.product-button:hover {
    background-color: #d3bdf0;
}

/* Estilos para seção de dicas */
.tips-section {
    margin-bottom: 40px;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.tip-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    transition: transform 0.3s, box-shadow 0.3s;
}

.tip-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.tip-image {
    flex: 0 0 120px;
    overflow: hidden;
}

.tip-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tip-content {
    flex: 1;
    padding: 15px;
}

.tip-title {
    font-weight: bold;
    margin-bottom: 10px;
    color: #3c1361;
}

.tip-excerpt {
    font-size: 0.9em;
    margin-bottom: 10px;
}

.tip-link {
    color: #3c1361;
    text-decoration: none;
    font-weight: bold;
    font-size: 0.9em;
}

.tip-link:hover {
    text-decoration: underline;
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
 </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Matos e Flores</h1>
                <span>Floricultura</span>
            </div>
            <nav>
                <ul>
                    <li><a href="homeCliente.php">Início</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="carrinho.php">Meus Pedidos</a></li>
                    <li><a href="dicasPlantio.php">Dicas de Plantio</a></li>
             
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

    <div class="container">
  <h2 class="section-title">Dicas de Plantio</h2>
  <div class="tips-grid">
    <?php while($d = mysqli_fetch_assoc($result_dicas)): ?>
      <div class="tip-card">
        <div class="tip-content">
          <div class="tip-title"><?= htmlspecialchars($d['titulo_dica']) ?></div>
          <div class="tip-excerpt"><?= substr($d['conteudo_dica'], 0, 100) ?>...</div>
          <a href="#" class="tip-button" data-id="<?= $d['iddica_plantio'] ?>">Ver Dica</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<div id="dicaModal">
  <div class="modal-content">
    <span class="modal-close">&times;</span>
    <div class="dica-detalhes"></div>
    <div class="text-end" style="margin-top: 15px;">
     
    </div>
  </div>
</div>

<style>
#dicaModal {
  display: none;
  position: fixed;
  z-index: 1050;
  left: 0; top: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
}
#dicaModal .modal-content {
  background: #fff;
  margin: 10% auto;
  padding: 20px;
  width: 80%;
  max-width: 600px;
  border-radius: 8px;
  position: relative;
}
.modal-close {
  cursor: pointer;
  font-size: 20px;
  color: #555;
  position: absolute;
  top: 10px;
  right: 15px;
}
.tip-card {
  background: #f9f9f9;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
.tip-title {
  font-weight: bold;
  margin-bottom: 5px;
}
.tip-button {
  display: inline-block;
  margin-top: 10px;
  color: #fff;
  background-color: #5d3d93;
  padding: 6px 12px;
  text-decoration: none;
  border-radius: 4px;
}
.tip-button:hover {
    background-color: #d3bdf0;
}
</style>

<script>
$('.tip-button').click(function(e){
  e.preventDefault();
  const id = $(this).data('id');
  $.get('detalhes_dica.php', {id: id}, function(data){
    $('.dica-detalhes').html(data);
    $('#dicaModal').fadeIn();
  });
});

$('.modal-close, #dicaModal').click(function(e){
  if(e.target !== this && !$(e.target).hasClass('modal-close')) return;
  $('#dicaModal').fadeOut();
});
</script>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Floricultura Matos e Flores</h3>
                <p>Sua melhor opção em flores e plantas ornamentais.</p>
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
        </div>
    </footer>
</body>
</html>
