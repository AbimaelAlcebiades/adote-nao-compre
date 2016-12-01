$(document).ready(function(){

    carregaListagemRacas();

    // Evento de foco no campo nome_especie.
    $("#id_especie").on("change", function(e){
        carregaListagemRacas();
    });

});

/* Função carrega listagem de raças */
function carregaListagemRacas(){
    // Dados.
    var data = {
        // Nome da função que será executada.
        functionName : "loadRacaList",
        idEspecie : $("#id_especie").val()
    };

    // Url da requisição.
    var url = "../../../../ajax.php";

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            moduleName: "animaldata",
            data: data
        },
        success: function(result) {

            result = $.parseJSON(result);

            $("#id_raca").empty();

            var selectSpecies = $('#id_raca');
            $.each(result, function(index, item) {
                selectSpecies.append(
                    $('<option></option>').val(item.id).html(item.nome)
                );
            });


        },
    });
}