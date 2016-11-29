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

     // Evento de clique no botão "excluir".
    $("div.listagem-especies").on("click", "a.excluir-especie", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var botao = $(this);

        excluirEspecie(botao);
    });

    // Evento de foco no campo nome_especie.
    $("input.nome_especie").on("focus", function(e){
        if ($(".usuario_criado").length ) {
            $(".usuario_criado" ).remove();
        }
    });


});

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

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "registerSpecie",
        specieName : inputSpecieName.val()
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
            console.log(result);
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