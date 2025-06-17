<?php
include_once("conexao.php");
include_once("usuarioFuncionario.php");
session_start();

if (!isset($_SESSION['user']) || $_SESSION['tipo'] !== 'funcionario') {
    header("location: index.php");
    exit;
}

if (!isset($_GET['iddica_plantio'])) {
    echo "<script>alert('Dica não especificada.'); window.location='lista_dica.php';</script>";
    exit;
}

$idusuario_funcionario = $_SESSION['user']->idusuario_funcionario;
$iddica_plantio = intval($_GET['iddica_plantio']);

$sql = "SELECT * FROM dicas_plantio WHERE iddica_plantio = $iddica_plantio AND idusuario_funcionario = $idusuario_funcionario";
$res = mysqli_query($conn, $sql) or die("Erro na consulta: " . mysqli_error($conn));

if (mysqli_num_rows($res) == 0) {
    echo "<script>alert('Dica não encontrada ou sem permissão para visualizar.'); window.location='lista_dica.php';</script>";
    exit;
}

$dica = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Detalhes da Dica de Plantio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4ecff;
      font-family: 'Segoe UI', sans-serif;
      padding: 2rem;
    }
    .titulo {
      color: #57396d;
      font-family: 'Italiana', serif;
      text-align: center;
      margin-bottom: 2rem;
    }
    .form-control:disabled {
      background-color: #fff;
      color: #333;
    }
    .container-dica {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 2rem;
      max-width: 800px;
      margin: auto;
    }
    .btn-voltar {
      background-color: #57396d;
      color: #fff;
      border: none;
    }
    .btn-voltar:hover {
      background-color: #3c1361;
    }
  </style>
</head>
<body>

  <h1 class="titulo">Detalhes da Dica de Plantio</h1>

  <div class="container-dica">
    <div class="mb-3">
      <label for="titulo" class="form-label"><strong>Título da Dica</strong></label>
      <input class="form-control" type="text" id="titulo" value="<?= htmlspecialchars($dica['titulo_dica']) ?>" disabled>
    </div>
    <div class="mb-3">
      <label for="conteudo" class="form-label"><strong>Conteúdo da Dica</strong></label>
      <textarea class="form-control" id="conteudo" rows="8" disabled><?= htmlspecialchars($dica['conteudo_dica']) ?></textarea>
    </div>
    <div class="text-end">
      <button class="btn btn-voltar" type="button" onclick="window.location='lista_dica.php'">Voltar</button>
    </div>
  </div>

</body>
</html>
