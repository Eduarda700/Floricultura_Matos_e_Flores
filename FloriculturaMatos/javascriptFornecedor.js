$(document).ready(function () {
    var page = 1;
    var current_page = 1;
    var total_page = 0;
    var is_ajax_fire = 0;
    var dataCon;

    createHeadTable();
    createForm();
    createEditForm();
    manageData();

    $("#filtro").on('input', function () {
        page = 1;
        getPageData();
    });

    function manageData() {
        $.ajax({
            dataType: 'json',
            url: 'getFornecedor.php',
            data: { page: page }
        }).done(function (data) {
            total_page = Math.ceil(data.total / 10);
            current_page = page;

            $('#pagination').twbsPagination({
                totalPages: total_page,
                visiblePages: 5,
                onPageClick: function (event, pageL) {
                    page = pageL;
                    getPageData();
                }
            });

            manageRow(data.data);
            is_ajax_fire = 1;
        });
    }

    function getPageData() {
        var filtro = $("#filtro").val();
        $.ajax({
            dataType: 'json',
            url: 'getFornecedor.php',
            data: { page: page, filtro: filtro }
        }).done(function (data) {
            manageRow(data.data);
        });
    }

    function manageRow(data) {
        dataCon = data;
        var rows = '';
        var i = 0;

        $.each(data, function (key, value) {
            rows += '<tr>';
            rows += '<td>' + value.fornecedor + '</td>';
            rows += '<td>' + value.telefone + '</td>';
            rows += '<td>' + value.email_fornecedor + '</td>';
            rows += '<td>' + value.cnpj_fornecedor + '</td>';
            rows += '<td>' + value.rua_fornecedor + '</td>';
            rows += '<td>' + value.numero_fornecedor + '</td>';
            rows += '<td>' + (value.complemento_fornecedor || '') + '</td>';
            rows += '<td>' + value.bairro_fornecedor + '</td>';
            rows += '<td>' + value.cidade_fornecedor + '</td>';
            rows += '<td>' + value.estado_fornecedor + '</td>';
            rows += '<td>' + value.cep_fornecedor + '</td>';
            rows += '<td data-index="' + i + '">';
            rows += '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Editar</button> ';
            rows += '<button class="btn btn-danger remove-item">Deletar</button>';
            rows += '</td>';
            rows += '</tr>';
            i++;
        });

        $("#fornecedores-tbody").html(rows);
    }

    function createHeadTable() {
        var rows = '<tr>';
        rows += '<th>Nome</th>';
        rows += '<th>Telefone</th>';
        rows += '<th>Email Fornecedor</th>';
        rows += '<th>CNPJ</th>';
        rows += '<th>Rua</th>';
        rows += '<th>Número</th>';
        rows += '<th>Complemento</th>';
        rows += '<th>Bairro</th>';
        rows += '<th>Cidade</th>';
        rows += '<th>Estado</th>';
        rows += '<th>CEP</th>';
        rows += '<th>Ação</th>';
        rows += '</tr>';

        $("thead").html(rows);
        $("#filtro").attr("placeholder", "Buscar fornecedor por nome");
    }

    function getPageData() {
        var filtro = $("#filtro").val(); 
        $.ajax({
            dataType: 'json',
            url: 'getFornecedor.php',
            data: { 
                page: page,
                filtro: filtro
            }
        }).done(function(data) {
            manageRow(data.data);
        });
    }

    function createForm() {
        var html = `
        <div class="form-group"><label>Nome</label><input type="text" name="fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Telefone</label><input type="text" name="telefone" class="form-control" required /></div>
        <div class="form-group"><label>Email (fornecedor)</label><input type="email" name="email_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>CNPJ</label><input type="text" name="cnpj_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Rua</label><input type="text" name="rua_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Número</label><input type="text" name="numero_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Complemento</label><input type="text" name="complemento_fornecedor" class="form-control" /></div>
        <div class="form-group"><label>Bairro</label><input type="text" name="bairro_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Cidade</label><input type="text" name="cidade_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Estado</label><input type="text" name="estado_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>CEP</label><input type="number" name="cep_fornecedor" class="form-control" required /></div>
        <div class="form-group"><button type="submit" class="btn crud-submit btn-success">Salvar</button></div>
        `;
        $("#create-item").find("form").html(html);
    }

    function createEditForm() {
        var html = `
        <input type="hidden" name="idfornecedor" class="edit-idfornecedor">
        <div class="form-group"><label>Nome</label><input type="text" name="fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Telefone</label><input type="text" name="telefone" class="form-control" required /></div>
        <div class="form-group"><label>Email (fornecedor)</label><input type="email" name="email_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>CNPJ</label><input type="text" name="cnpj_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Rua</label><input type="text" name="rua_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Número</label><input type="text" name="numero_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Complemento</label><input type="text" name="complemento_fornecedor" class="form-control" /></div>
        <div class="form-group"><label>Bairro</label><input type="text" name="bairro_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Cidade</label><input type="text" name="cidade_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>Estado</label><input type="text" name="estado_fornecedor" class="form-control" required /></div>
        <div class="form-group"><label>CEP</label><input type="number" name="cep_fornecedor" class="form-control" required /></div>
        <div class="form-group"><button type="submit" class="btn crud-submit-edit btn-success">Salvar</button></div>
        `;
        $("#edit-item").find("form").html(html);
    }

    $(".crud-submit").click(function (e) {
        e.preventDefault();
        var form_action = $("#create-item").find("form").attr("action");

        var fornecedor = $("#create-item").find("input[name='fornecedor']").val();
        var telefone = $("#create-item").find("input[name='telefone']").val();
        var email_fornecedor = $("#create-item").find("input[name='email_fornecedor']").val();
        var cnpj_fornecedor = $("#create-item").find("input[name='cnpj_fornecedor']").val();
        var rua_fornecedor = $("#create-item").find("input[name='rua_fornecedor']").val();
        var numero_fornecedor = $("#create-item").find("input[name='numero_fornecedor']").val();
        var complemento_fornecedor = $("#create-item").find("input[name='complemento_fornecedor']").val();
        var bairro_fornecedor = $("#create-item").find("input[name='bairro_fornecedor']").val();
        var cidade_fornecedor = $("#create-item").find("input[name='cidade_fornecedor']").val();
        var estado_fornecedor = $("#create-item").find("input[name='estado_fornecedor']").val();
        var cep_fornecedor = $("#create-item").find("input[name='cep_fornecedor']").val();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: form_action,
            data: { fornecedor: fornecedor, telefone: telefone, email_fornecedor: email_fornecedor, cnpj_fornecedor: cnpj_fornecedor, rua_fornecedor: rua_fornecedor, numero_fornecedor: numero_fornecedor, complemento_fornecedor: complemento_fornecedor, bairro_fornecedor: bairro_fornecedor, cidade_fornecedor: cidade_fornecedor, estado_fornecedor: estado_fornecedor, cep_fornecedor: cep_fornecedor } }).done(function (data) {
                $("#create-item").find("input[name='fornecedor']").val('');
                $("#create-item").find("input[name='telefone']").val('');
                $("#create-item").find("input[name='email_fornecedor']").val('');
                $("#create-item").find("input[name='cnpj_fornecedor']").val('');
                $("#create-item").find("input[name='rua_fornecedor']").val('');
                $("#create-item").find("input[name='numero_fornecedor']").val('');
                $("#create-item").find("input[name='complemento_fornecedor']").val('');
                $("#create-item").find("input[name='bairro_fornecedor']").val('');
                $("#create-item").find("input[name='cidade_fornecedor']").val('');
                $("#create-item").find("input[name='estado_fornecedor']").val('');
                $("#create-item").find("input[name='cep_fornecedor']").val('');
                getPageData();
            $(".modal").modal('hide');
            toastr.success(data.msg, 'Alerta de Sucesso', { timeOut: 5000 });
        });
    });

   $("body").on("click", ".edit-item", function () {
    var index = $(this).closest("td").data('index');

    var idfornecedor = dataCon[index].idfornecedor;
    var fornecedor = dataCon[index].fornecedor;
    var telefone = dataCon[index].telefone;
    var email_fornecedor = dataCon[index].email_fornecedor;
    var cnpj_fornecedor = dataCon[index].cnpj_fornecedor;
    var rua_fornecedor = dataCon[index].rua_fornecedor;
    var numero_fornecedor = dataCon[index].numero_fornecedor;
    var complemento_fornecedor = dataCon[index].complemento_fornecedor;
    var bairro_fornecedor = dataCon[index].bairro_fornecedor;
    var cidade_fornecedor = dataCon[index].cidade_fornecedor;
    var estado_fornecedor = dataCon[index].estado_fornecedor;
    var cep_fornecedor = dataCon[index].cep_fornecedor;

    $("#edit-item").find("input[name='idfornecedor']").val(idfornecedor);
    $("#edit-item").find("input[name='fornecedor']").val(fornecedor);
    $("#edit-item").find("input[name='telefone']").val(telefone);
    $("#edit-item").find("input[name='email_fornecedor']").val(email_fornecedor);
    $("#edit-item").find("input[name='cnpj_fornecedor']").val(cnpj_fornecedor);
    $("#edit-item").find("input[name='rua_fornecedor']").val(rua_fornecedor);
    $("#edit-item").find("input[name='numero_fornecedor']").val(numero_fornecedor);
    $("#edit-item").find("input[name='complemento_fornecedor']").val(complemento_fornecedor);
    $("#edit-item").find("input[name='bairro_fornecedor']").val(bairro_fornecedor);
    $("#edit-item").find("input[name='cidade_fornecedor']").val(cidade_fornecedor);
    $("#edit-item").find("input[name='estado_fornecedor']").val(estado_fornecedor);
    $("#edit-item").find("input[name='cep_fornecedor']").val(cep_fornecedor);
});

    $("body").on("click", ".remove-item", function () {
        var index = $(this).closest("td").data("index");
        var idfornecedor = dataCon[index].idfornecedor;

        if (confirm("Tem certeza que deseja deletar este fornecedor?")) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'deleteFornecedor.php',
                data: { idfornecedor: idfornecedor }
            }).done(function (data) {
                toastr.success(data.msg || "Fornecedor removido com sucesso!", 'Sucesso');
                getPageData();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                toastr.error("Erro ao remover o fornecedor: " + errorThrown, "Erro");
            });
        }
    });

    $(".crud-submit-edit").click(function (e) {
        e.preventDefault();
        var form_action = $("#edit-item").find("form").attr("action");

        var idfornecedor = $("#edit-item").find("input[name='idfornecedor']").val();
        var fornecedor = $("#edit-item").find("input[name='fornecedor']").val();
        var telefone = $("#edit-item").find("input[name='telefone']").val();
        var email_fornecedor = $("#edit-item").find("input[name='email_fornecedor']").val();
        var cnpj_fornecedor = $("#edit-item").find("input[name='cnpj_fornecedor']").val();
        var rua_fornecedor = $("#edit-item").find("input[name='rua_fornecedor']").val();
        var numero_fornecedor = $("#edit-item").find("input[name='numero_fornecedor']").val();
        var complemento_fornecedor = $("#edit-item").find("input[name='complemento_fornecedor']").val();
        var bairro_fornecedor = $("#edit-item").find("input[name='bairro_fornecedor']").val();
        var cidade_fornecedor = $("#edit-item").find("input[name='cidade_fornecedor']").val();
        var estado_fornecedor = $("#edit-item").find("input[name='estado_fornecedor']").val();
        var cep_fornecedor = $("#edit-item").find("input[name='cep_fornecedor']").val();
        
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'updateFornecedor.php',
            data: {
                idfornecedor: idfornecedor,
                fornecedor: fornecedor,
                telefone: telefone,
                email_fornecedor: email_fornecedor,
                cnpj_fornecedor: cnpj_fornecedor,
                rua_fornecedor: rua_fornecedor,
                numero_fornecedor: numero_fornecedor,
                complemento_fornecedor: complemento_fornecedor,
                bairro_fornecedor: bairro_fornecedor,
                cidade_fornecedor: cidade_fornecedor,
                estado_fornecedor: estado_fornecedor,
                cep_fornecedor: cep_fornecedor
            } }).done(function (data) {console.log(data); 
            getPageData();

            $(".modal").modal('hide');
            toastr.success(data.msg, 'Alerta de Sucesso', { timeOut: 5000 });
        });
    });
});