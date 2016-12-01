$(document).ready(function(){

    carregaListagemEspecies();

    // Evento de clique no botão "salvar".
    $("#btn_save").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var botao = $(this);
        botao.attr("disabled", "disabled");

        // Pega formulario.
        var form = $(this).closest('form.module-speciedata');

        // Verifica se todos os campos são válidos.
        if(
            validateEmptyField("nome_especie")
        ){
            // Cadastra nova especie.
            cadastraEspecie($("#nome_especie"));
        }
    });

    // Evento de clique no botão "cancelar".
    $(".btn-cancel").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        $("#nome_especie").val("");

        $(".titulo_cadastro").removeClass("hidden");
        $(".titulo_edicao").addClass('hidden');

        liberaTodosBotoes();
    });

     // Evento de clique no botão "excluir".
    $("div.listagem-especies").on("click", "a.excluir-especie", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var botao = $(this);
        if(botao.attr("disabled") == "disabled"){
            return
        }else{
            excluirEspecie(botao);
        }
    });

    // Evento de clique no botão "alterar".
    $("div.listagem-especies").on("click", ".alterar-especie", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        liberaTodosBotoes();

        $("#nome_especie").val($(this).parent().prev().text());
        $("#nome_especie").attr("data-id-especie", $(this).attr("data-id"));

        $(this).attr("disabled", "disabled");
        $(this).next().attr("disabled", "disabled");

        $("#btn_save").addClass('specie-edit');
        $(".btn-cancel").addClass('specie-edit');

        $(".titulo_cadastro").addClass("hidden");
        $(".titulo_edicao").removeClass('hidden');

    });

    // Evento de foco no campo nome_especie.
    $("input.nome_especie").on("focus", function(e){
        if ($(".usuario_criado").length ) {
            $(".usuario_criado" ).remove();
        }
    });


});

function liberaTodosBotoes() {
    $(".btn").each(function( i ) {
            $(this).removeAttr('disabled');
    });
}

/* Função que valida se um campo é vazio. */
function validateEmptyField(id){

    var fieldValidate = $("#"+id);
    var valueField = fieldValidate.val();

    // Verificar se o campo não é vazio.
    if(valueField === ""){
        var div = fieldValidate.closest("div");
        div.removeClass("has-success");
        $("#glypcn"+id).remove();
        div.addClass("has-error has-feedback");
        div.append('<span id="glypcn'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
        return false;
    }else{
        var div = fieldValidate.closest("div");
        div.removeClass("has-error");
        $("#glypcn"+id).remove();
        div.addClass("has-success has-feedback");
        div.append('<span id="glypcn'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
        return true;
    }
}

/* Função cria usuário. */
function cadastraEspecie(inputSpecieName){

    if ($(".usuario_criado").length ) {
        $(".usuario_criado" ).remove();
    }

    var form = inputSpecieName.closest("form.form-speciedata");
    var botao = form.find(".enviar-formulario");
    var specieId = 0;
    var editMode = $(".enviar-formulario");

    if(editMode.hasClass('specie-edit')){
        specieId =  $("#nome_especie").attr("data-id-especie");

        $(".titulo_cadastro").removeClass("hidden");
        $(".titulo_edicao").addClass('hidden');
    }

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "registerSpecie",
        specieName : inputSpecieName.val(),
        specieId : specieId
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "speciedata",
            data: data
        },
        success: function(result) {

            inputSpecieName.val("");
            inputSpecieName.css('border',' 1px solid #ccc');
            botao.removeAttr("disabled");
            $("#glypcnnome_especie").remove();

            $("<div class='alert alert-success usuario_criado'>Especie criada com sucesso!</div>").insertAfter(form);

            carregaListagemEspecies();

        },
    });
}


/* Função deleta uma especie. */
function excluirEspecie(buttonDeleteSpecie){

    var idSpecie = buttonDeleteSpecie.attr("data-id");

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "deleteSpecie",
        idSpecie : idSpecie
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "speciedata",
            data: data
        },
        success: function(result) {
            
            location.reload(); 
        },
    });
}


/* Função carrega listagem de especies */
function carregaListagemEspecies(){

    if ($(".listagem-especies").length ) {
        $(".listagem-especies" ).empty();
    }

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "loadSpecieList",
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "speciedata",
            data: data
        },
        success: function(result) {
            $("div.listagem-especies").append(result);
        },
    });
}