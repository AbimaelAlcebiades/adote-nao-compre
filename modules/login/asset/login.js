$(document).ready(function(){
    $("form.module-login").on("click", "button.enviar-formulario", function(e){
        e.preventDefault();

        var form = $(this).closest('form.module-login');
        var moduleName = "login";
        var user = form.find(".email");
        var password = form.find(".senha");
        var data = {
            functionName : "toLogin",
            user : user.val(),
            password : password.val()
        };
        var url = "ajax.php";

        $.post(url,
        {
          moduleName: "login",
          data: data
        },
        function(data,status){
            alert("Data: " + data + "\nStatus: " + status);
        });
    });
});