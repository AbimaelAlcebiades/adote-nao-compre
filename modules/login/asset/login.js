$(document).ready(function(){
    
    // Evento de clique no botão "entrar".
    $("form.module-login").on("click", "button.enviar-formulario", function(e){
        
        // Evita comportamento padrão do botão.
        e.preventDefault();

        // Pega o "formulário de login".
        var form = $(this).closest('form.module-login');
        // Configura nome do módulo.
        var moduleName = "login";
        // Pega e-mail digitado.
        var user = form.find(".email");
        // Pega senha digitada.
        var password = form.find(".senha");

        // Dados.
        var data = {
            // Nome da função que será executada.
            functionName : "toLogin",
            user : user.val(),
            password : password.val()
        };

        // Url da requisição.
        var url = "ajax.php";

        // Requisição ajax.
        $.post(url,
        {
          moduleName: "login",
          data: data
        },
        function(data,status){
            location.reload();
        });
    });

    // Evento de clique no link "sair".
    $("a.module-login.link-sair").on("click", function(e){

        // Evita comportamento padrão do botão.
        e.preventDefault();

        // Configura nome do módulo.
        var moduleName = "login";

        // Dados.
        var data = {
            // Nome da função que será executada.
            functionName : "toExit"
        };

        // Url da requisição.
        var url = "ajax.php";

        // Requisição ajax.
        $.post(url,
        {
          moduleName: "login",
          data: data
        },
        function(data,status){
            location.reload();
        });
    });
});