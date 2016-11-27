$(document).ready(function(){
    // Evento de clique no botão "entrar".
    $("#btn_save").on("click", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        var form = $(this).closest('form');

        // Verifica se todos os campos são válidos.
        if(
            validateEmptyField("nome") &
            validateEmail("email") &
            validatePassword("senha", "senha-confirmar")
        ){
            // Tenta criar o usuário.
            createUser($("#nome"), $("#email"), $("#senha"));

            form.submit();
        }
    });

    // Evento ao alterar valor de e-mail.
    $("#email").on("change", function(e){
        // Evita comportamento padrão do botão.
        e.preventDefault();

        // Pega input de e-mail.
        var inputEmail = $(this);

        // Verifica se usuário existe.
        verifyUserExists(inputEmail);

    });
});

/* Função que valida se um campo tem um e-mail válido. */
function validateEmail(id){

    if($("#"+id).hasClass('invalid')){
        return false;
    }

    var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
    if(!email_regex.test($("#"+id).val())){
        var div = $("#"+id).closest("div");
        div.removeClass("has-success");
        $("#glypcn"+id).remove();
        div.addClass("has-error has-feedback");
        div.append('<span id="glypcn'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
        return false;
    }else{
        var div = $("#"+id).closest("div");
        div.removeClass("has-error");
        $("#glypcn"+id).remove();
        div.addClass("has-success has-feedback");
        div.append('<span id="glypcn'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
        return true;
    }
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

/* Função que valida campo de senha e confirmar senha. */
function validatePassword(idPassword, idConfirmPassword){

    var fieldPassword           = $("#"+idPassword);
    var fieldConfirmPassword    = $("#"+idConfirmPassword);
    var valuePassword           = fieldPassword.val();
    var valueConfirmPassword    = fieldConfirmPassword.val();

    // Verifica se o campo de senha ou confirmar senha não são vazios.
    if(!validateEmptyField(idPassword) && !validateEmptyField(idConfirmPassword)){
        return false;
    }

    // Verificar se o campo senha e confirmar senha são iguais.
    if(valuePassword != valueConfirmPassword){
        var divPassword = fieldPassword.closest("div");
        var divConfirmPassword = fieldConfirmPassword.closest("div");
        divPassword.removeClass("has-success");
        divConfirmPassword.removeClass("has-success");
        $("#glypcn"+idPassword).remove();
        $("#glypcn"+idConfirmPassword).remove();
        divPassword.addClass("has-error has-feedback");
        divConfirmPassword.addClass("has-error has-feedback");
        divPassword.append('<span id="glypcn'+idPassword+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
        divConfirmPassword.append('<span id="glypcn'+idConfirmPassword+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
        return false;
    }else{
        var divPassword = fieldPassword.closest("div");
        var divConfirmPassword = fieldConfirmPassword.closest("div");
        divPassword.removeClass("has-error");
        divConfirmPassword.removeClass("has-error");
        $("#glypcn"+idPassword).remove();
        $("#glypcn"+idConfirmPassword).remove();
        divPassword.addClass("has-success has-feedback");
        divConfirmPassword.addClass("has-success has-feedback");
        divPassword.append('<span id="glypcn'+idPassword+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
        divConfirmPassword.append('<span id="glypcn'+idConfirmPassword+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
        return true;
    }
}

/* Função cria usuário. */
function createUser(inputName, inputUser, inputPassword){
    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "createUser",
        name : inputName.val(),
        user : inputUser.val(),
        password : inputPassword.val()
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "login",
            data: data
        },
        async: false,
        success: function(result) {
            result = $.parseJSON(result);

            $("#retorno-codigo").val(result.codigo);
            $("#retorno-mensagem").val(result.mensagem);

        },
    });
}

/* Função verifica se usuário já existe. */
function verifyUserExists(inputEmail){
    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "verifyUserExists",
        email : inputEmail.val()
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        async : false,
        data: {
            moduleName: "login",
            data: data
        },
        success: function(result) {
            $(".alerta-email").remove();
            $("#email").removeClass("invalid");
            if(result == 1){
                $("#email").addClass("invalid");
                $("<div class='form-group alerta-email'><div class='col-sm-2'></div><div class='col-sm-10' style='color:red;'>Este e-mail já está em uso</div>").insertBefore('.div-email');
                return true;
            }else{
                return false;
            }
        },
    });
}