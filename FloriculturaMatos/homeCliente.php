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
$query_produtos = "SELECT * FROM produto ORDER BY RAND() LIMIT 4";
$result_produtos = mysqli_query($conn, $query_produtos);

// Consulta para obter dicas de plantio
$query_dicas = "SELECT * FROM dicas_plantio ORDER BY iddica_plantio DESC LIMIT 3";
$result_dicas = mysqli_query($conn, $query_dicas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floricultura Matos e Flores - Página Inicial</title>
    <link rel="stylesheet" href="homeClienteCSS.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
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
                    <li><a href="#">Produtos</a></li>
                    <li><a href="#">Meus Pedidos</a></li>
                    <li><a href="#">Dicas de Plantio</a></li>
                    <li><a href="#">Meu Perfil</a></li>
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
                <?php
                // Verificar se há produtos
                if ($result_produtos && mysqli_num_rows($result_produtos) > 0) {
                    while ($produto = mysqli_fetch_assoc($result_produtos)) {
                        ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="img/plantas.jpg" alt="<?php echo $produto['nome_produto']; ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-title"><?php echo $produto['nome_produto']; ?></div>
                                <div class="product-price">R$ <?php echo $produto['valor_produto']; ?></div>
                                <a href="#" class="product-button">Ver Detalhes</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Se não houver produtos no banco, exibir produtos de exemplo
                    $produtos_exemplo = [
                        ['nome' => 'Orquídea Phalaenopsis', 'preco' => '89,90'],
                        ['nome' => 'Suculenta Echeveria', 'preco' => '29,90'],
                        ['nome' => 'Rosa Vermelha', 'preco' => '15,90'],
                        ['nome' => 'Lírio Branco', 'preco' => '22,50']
                    ];

                    foreach ($produtos_exemplo as $produto) {
                        ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="img/plantas.jpg" alt="<?php echo $produto['nome']; ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-title"><?php echo $produto['nome']; ?></div>
                                <div class="product-price">R$ <?php echo $produto['preco']; ?></div>
                                <a href="#" class="product-button">Ver Detalhes</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="#" class="product-button" style="display: inline-block; padding: 10px 20px;">Ver Todos os Produtos</a>
            </div>
        </section>

        <section class="tips-section">
            <h2 class="section-title">Dicas de Plantio</h2>
            <div class="tips-grid">
                <?php
                // Verificar se há dicas
                if ($result_dicas && mysqli_num_rows($result_dicas) > 0) {
                    while ($dica = mysqli_fetch_assoc($result_dicas)) {
                        ?>
                        <div class="tip-card">
                            <div class="tip-image">
                                <img src="img/dicas.jpg" alt="<?php echo $dica['titulo_dica']; ?>">
                            </div>
                            <div class="tip-content">
                                <div class="tip-title"><?php echo $dica['titulo_dica']; ?></div>
                                <div class="tip-excerpt"><?php echo substr($dica['conteudo_dica'], 0, 100) . '...'; ?></div>
                                <a href="#" class="tip-link">Ler mais</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Se não houver dicas no banco, exibir dicas de exemplo
                    $dicas_exemplo = [
                        ['titulo' => 'Como cuidar de orquídeas', 'conteudo' => 'As orquídeas são plantas delicadas que precisam de cuidados especiais. Para mantê-las saudáveis, é importante controlar a rega e a exposição ao sol...'],
                        ['titulo' => 'Dicas para cultivar suculentas', 'conteudo' => 'As suculentas são plantas resistentes e fáceis de cuidar. Elas precisam de pouca água e bastante luz solar para se desenvolverem adequadamente...'],
                        ['titulo' => 'Preparando o solo para o plantio', 'conteudo' => 'Um bom solo é fundamental para o desenvolvimento saudável das plantas. É importante garantir que ele tenha os nutrientes necessários e uma boa drenagem...']
                    ];

                    foreach ($dicas_exemplo as $dica) {
                        ?>
                        <div class="tip-card">
                            <div class="tip-image">
                                <img src="img/dicas.jpg" alt="<?php echo $dica['titulo']; ?>">
                            </div>
                            <div class="tip-content">
                                <div class="tip-title"><?php echo $dica['titulo']; ?></div>
                                <div class="tip-excerpt"><?php echo substr($dica['conteudo'], 0, 100) . '...'; ?></div>
                                <a href="#" class="tip-link">Ler mais</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </section>

        <section class="categories-section">
            <h2 class="section-title">Categorias</h2>
            <div class="categories-grid">
                <div class="category-card">
                    <img src="img/flores.jpg" alt="Flores">
                    <div class="category-overlay">
                        <div class="category-name">Flores</div>
                    </div>
                </div>
                <div class="category-card">
                    <img src="img/plantas.jpg" alt="Plantas Ornamentais">
                    <div class="category-overlay">
                        <div class="category-name">Plantas Ornamentais</div>
                    </div>
                </div>
                <div class="category-card">
                    <img src="img/dicas.jpg" alt="Vasos e Cachepôs">
                    <div class="category-overlay">
                        <div class="category-name">Vasos e Cachepôs</div>
                    </div>
                </div>
                <div class="category-card">
                    <img src="img/flores.jpg" alt="Acessórios">
                    <div class="category-overlay">
                        <div class="category-name">Acessórios</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
        </div>
    </footer>
</body>
</html>

