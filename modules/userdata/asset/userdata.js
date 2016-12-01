$(document).ready(function(){



    // Evento de clique no botão "salvar".
    $("#btn_save").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var botao = $(this);
        botao.attr("disabled", "disabled");

        // Pega formulario.
        var form = $(this).closest('form.module-userdata');

        // Verifica se todos os campos são válidos.
        // VERIFICAR se as senhas estão iguais
        if(
            validateEmptyField("nome_usuario") &&
            validateEmptyField("email_usuario") &&
            validateEmptyField("telefone_usuario") &&
            validateEmptyField("endereco_usuario") &&
            validateEmptyField("senha_usuario") &&
            validateEmptyField("senha2_usuario")
            ){
            // Atualiza user.
            atualizaUsuario($("#id_usuario"), $("#nome_usuario"), $("#email_usuario"), $("#telefone_usuario"), $("#endereco_usuario"), $("#senha_usuario"));
        }
    });

        // Evento de clique no botão "cancelar".
        $(".btn-cancel").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        $("#nome_usuario").val("");
        $("#email_usuario").val("");
        $("#telefone_usuario").val("");
        $("#endereco_usuario").val("");
        $("#senha_usuario").val("");
        $("#senha2_usuario").val("");

        liberaTodosBotoes();
    });


    // Evento de foco no campo nome_raca.
    $("input.nome_raca").on("focus", function(e){
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
function atualizaUsuario(inputUserId, inputUserName, inputUserEmail, inputUserPhone, inputUserAddress, inputUserPassword){

    if ($(".usuario_criado").length ) {
        $(".usuario_criado" ).remove();
    }

    var form = inputUserName.closest("form.form-userdata");
    var botao = form.find(".enviar-formulario");

    alert("Entrou no atualizaUsuario");

    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "registerUser",
        userId : inputUserId.val(),
        userName : inputUserName.val(),
        userEmail : inputUserEmail.val(),
        userPhone : inputUserPhone.val(),
        userAddress : inputUserAddress.val(),
        userPassword : inputUserPassword.val()
    };

    alert("Entrou no atualizaUsuario-2");

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "userdata",
            data: data
        },
        success: function(result) {

            console.log(result);

            botao.removeAttr("disabled");
            $("#glypcnnome_user").remove();

            $("<div class='alert alert-success usuario_criado'>Perfil alterado com sucesso!</div>").insertAfter(form);

        },
    });

    alert("Entrou no atualizaUsuario-3");
}