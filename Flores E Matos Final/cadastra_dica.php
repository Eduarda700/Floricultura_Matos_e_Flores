<?php session_start(); ?>

<h1 align='center'>Cadastro Dica</h1>

<div>
    <form class="form-login" action="processa_cadastro_dica.php" method="POST">
        <div class="form-group">
            <label for="titulo">Título da Dica</label>
            <input class="form-control" type="text" name="titulo" id="titulo" required>
        </div>
        <div class="form-group">
            <label for="conteudo">Conteúdo da Dica</label>
            <textarea class="form-control" name="conteudo" id="conteudo" required></textarea>
        </div>
        <br>
        <button class="btn btn-dark" type="submit">Cadastrar</button>
        <button class="btn btn-dark" type="reset">Limpar</button>
        <button class="btn btn-dark" type="button" onclick="window.location='lista_dica.php'">Cancelar</button>
    </form>
</div>
