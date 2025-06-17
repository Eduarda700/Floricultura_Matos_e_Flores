<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Dica - Sistema Floricultura</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        body {
            background-color: #f1e4ff;
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
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
    <h1>Cadastro de Dica</h1>

    <form class="form-login" action="processa_cadastro_dica.php" method="POST">
        <div class="form-group">
            <label for="titulo">Título da Dica</label>
            <input class="form-control" type="text" name="titulo" id="titulo" required>
        </div>
        <div class="form-group">
            <label for="conteudo">Conteúdo da Dica</label>
            <textarea class="form-control" name="conteudo" id="conteudo" rows="5" required></textarea>
        </div>

        <div class="btn-group">
            <button class="btn btn-custom" type="submit">Cadastrar</button>
            <button class="btn btn-default" type="reset">Limpar</button>
            <button class="btn btn-danger" type="button" onclick="window.location='lista_dica.php'">Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>