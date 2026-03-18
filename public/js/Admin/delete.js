/*
* Executa apos o carregamento da página esteja completo
* 08/2018
* Vk2 Studio Web
*/
$(window).on("load", function (e) {
    
    /**
     * Desmarca todos os Check box ao iniciar a página
     * 02/2019
     * VK2 - Julio
     */
    $("input[type='checkbox']").prop("checked", false);

    /**
    * Botão Marcar todos da listagem
    * 08/2018
    * Vk2 - Julio
    */
    $("#button-select").click(function(){
        var select = $(this).attr("data-allselect");
        if(select == 'false'){
            $(".selectitemlist").prop("checked", true);
            var qtd = $(".selectitemlist:checked").length;
            $("#button-select").attr("data-allselect", 'true').attr("data-qtdselect", qtd).addClass('all-select-dates');
        } else{
            $(".selectitemlist").prop("checked", false);
            $("#button-select").attr("data-allselect", 'false').attr("data-qtdselect", 0).removeClass('all-select-dates');
        }
    });

    /**
    * Ação para cada click em um select
    * 08/2018
    * Vk2 - Julio
    */
    $(".selectitemlist").click(function(){
        var qtdSelect = $("#button-select").attr("data-qtdselect"),
            qtdtotal = $(".selectitemlist").length;

        /**
         * Adiciona ou remove a quantidade total de itens selecionado
         */
        if($(this).prop("checked") == true) 
            qtdSelect = parseInt(qtdSelect)+1;
        else
            qtdSelect = parseInt(qtdSelect)-1;
        
        //Seta Quantidade de itens selecionados
        $("#button-select").attr("data-qtdselect", qtdSelect);

        //Se a quantidade total de itens for igual a quantidade de itens selecionados seta todos se nao remove todos
        if(qtdSelect == qtdtotal){
            $("#button-select").attr("data-allselect", 'true').attr("data-qtdselect", qtdSelect).addClass('all-select-dates');
        } else{
            $("#button-select").attr("data-allselect", 'false').attr("data-qtdselect", qtdSelect).removeClass('all-select-dates');
        }
    });

    /**
    * Ação do click no botão delete
    * 0/2018
    * Vk2 - Julio
    */
    $("#button-delete").click(function(){
        
        if($(".selectitemlist:checked").length > 0 && $(this).attr("data-execute") == 0){
            showAlert();
            $(this).attr("data-execute", 1);
            var inputSelect = $(".selectitemlist:checked").serializeArray(),
            token = $("input[name='_token']").val(),
            url = url_site + "delete";

            $.ajax({
                url : url,
                type: "POST",
                dataType: "JSON",
                data: { delete: inputSelect, _token: token },
                sync: false,
                success: function(json){
                    result = json;
                    updateAlert(result.status, result.message);
                    
                }
            });
            
        } else {
            showAlert();
            var status = 'error',
                message = 'Você precisa selecionar um (1) item para executar essa tarefa';
            updateAlert(status, message, 'reload');
        }
    });

    $("#button-restore").click(function(){
        
        if($(".selectitemlist:checked").length > 0 && $(this).attr("data-execute") == 0){
            showAlert();
            $(this).attr("data-execute", 1);
            var inputSelect = $(".selectitemlist:checked").serializeArray(),
            token = $("input[name='_token']").val(),
            url = url_site + "lixeira/restore";

            $.ajax({
                url : url,
                type: "POST",
                dataType: "JSON",
                data: { delete: inputSelect, _token: token },
                sync: false,
                success: function(json){
                    result = json;
                    updateAlert(result.status, result.message);
                    
                }
            });
            
        } else {
            showAlert();
            var status = 'error',
                message = 'Você precisa selecionar um (1) item para executar essa tarefa';
            updateAlert(status, message, 'reload');
        }
    });

    $("#button-delete-one").click(function(){
        
        var idRegister = $(this).attr('data-id');
        
            showAlert();
            $(this).attr("data-execute", 1);
            var inputSelect = $(".selectitemlist:checked").serializeArray(),
            token = $("input[name='_token']").val(),
            url = url_site + "delete/" + idRegister;

            $.ajax({
                url : url,
                type: "POST",
                dataType: "JSON",
                data: { _token: token },
                sync: false,
                success: function(json){
                    result = json;
                    updateAlert(result.status, result.message, 'back');
                    
                }
            });
            
        
    });


});