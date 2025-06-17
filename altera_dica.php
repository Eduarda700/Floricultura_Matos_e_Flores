<?php 
include_once("conexao.php"); // ajuste se estiver em subpasta
include_once("usuarioFuncionario.php");
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: index.php");
    exit;
}

$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;
$iddica_plantio = intval($_GET['id']);

// Busca a dica no banco de dados
$sql = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) == 0) {
    header("location: lista_dica.php");
    exit;
}

$row = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Dica - Sistema Floricultura</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f1e4ff;
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            background-color: #fff;
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        h1 {
            text-align: center;
            font-family: 'Italiana', serif;
            color: #3c1361;
            margin-bottom: 30px;
        }
        label {
            color: #3c1361;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5931a9;
        }
        .btn-group {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Editar Dica de Plantio</h1>

    <form class="form-login" action="processa_altera_dica.php" method="POST">
        <input type="hidden" name="iddica_plantio" value="<?= $row['iddica_plantio']; ?>">
        
        <div class="form-group">
            <label for="titulo_dica">Título da Dica</label>
            <input class="form-control" type="text" name="titulo_dica" id="titulo_dica" value="<?= htmlspecialchars($row['titulo_dica']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="conteudo_dica">Conteúdo da Dica</label>
            <textarea class="form-control" name="conteudo_dica" id="conteudo_dica" rows="5" required><?= htmlspecialchars($row['conteudo_dica']); ?></textarea>
        </div>

        <div class="btn-group">
            <button class="btn btn-custom" type="submit">Alterar</button>
            <button class="btn btn-default" type="reset">Limpar</button>
            <button class="btn btn-danger" type="button" onclick="window.location='lista_dica.php'">Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>