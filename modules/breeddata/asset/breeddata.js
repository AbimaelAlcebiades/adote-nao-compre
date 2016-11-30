$(document).ready(function(){

    carregaListagemRacas();

    // Evento de clique no botão "salvar".
    $("#btn_save").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var botao = $(this);
        botao.attr("disabled", "disabled");

        // Pega formulario.
        var form = $(this).closest('form.module-breeddata');

        // Verifica se todos os campos são válidos.
        if(
            validateEmptyField("nome_raca")
        ){
            // Cadastra nova raca.
            cadastraRaca($("#nome_raca"));
        }
    });

    // Evento de clique no botão "cancelar".
    $(".btn-cancel").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        $("#nome_raca").val("");

        $(".titulo_cadastro").removeClass("hidden");
        $(".titulo_edicao").addClass('hidden');

        liberaTodosBotoes();
    });

     // Evento de clique no botão "excluir".
    $("div.listagem-racas").on("click", "a.excluir-raca", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var botao = $(this);
        if(botao.attr("disabled") == "disabled"){
            return
        }else{
            excluirRaca(botao);
        }
    });

    // Evento de clique no botão "alterar".
    $("div.listagem-racas").on("click", ".alterar-raca", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        $("#nome_raca").val($(this).parent().prev().text());
        $("#nome_raca").attr("data-id-raca", $(this).attr("data-id"));

        $(this).attr("disabled", "disabled");
        $(this).next().attr("disabled", "disabled");

        $("#btn_save").addClass('raca-edit');
        $(".btn-cancel").addClass('raca-edit');

        $(".titulo_cadastro").addClass("hidden");
        $(".titulo_edicao").removeClass('hidden');

    });

    // Evento de foco no campo nome_raca.
    $("input.nome_raca").on("focus", function(e){
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
function cadastraRaca(inputBreedName){

    if ($(".usuario_criado").length ) {
        $(".usuario_criado" ).remove();
    }

    var form = inputBreedName.closest("form.form-breeddata");
    var botao = form.find(".enviar-formulario");
    var breedId = 0;
    var editMode = $(".enviar-formulario");

    if(editMode.hasClass('breed-edit')){
        breedId =  $("#nome_raca").attr("data-id-raca");

        $(".titulo_cadastro").removeClass("hidden");
        $(".titulo_edicao").addClass('hidden');
    }

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "registerBreed",
        breedName : inputBreedName.val(),
        breedId : breedId
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "breeddata",
            data: data
        },
        success: function(result) {

            inputBreedName.val("");
            inputBreedName.css('border',' 1px solid #ccc');
            botao.removeAttr("disabled");
            $("#glypcnnome_raca").remove();

            $("<div class='alert alert-success usuario_criado'>Raça criada com sucesso!</div>").insertAfter(form);

            carregaListagemRacas();

        },
    });
}


/* Função deleta uma raça. */
function excluirRaca(buttonDeleteBreed){

    var idBreed = buttonDeleteBreed.attr("data-id");

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "deleteBreed",
        idBreed : idBreed
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "breeddata",
            data: data
        },
        success: function(result) {
            console.log(result);
            location.reload(); 
        },
    });
}


/* Função carrega listagem de raças */
function carregaListagemRacas(){

    if ($(".listagem-racas").length ) {
        $(".listagem-racas" ).empty();
    }

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "loadBreedList",
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "breeddata",
            data: data
        },
        success: function(result) {
            $("div.listagem-racas").append(result);
        },
    });
}