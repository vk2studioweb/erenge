function showAlert() {
    $('#main-alert').fadeIn();
    $('#main-message-alert').show().animate({
        top: '50%'
    }, 500, function () {
        $(".button-alert").show().animate({
            width: "140px",
            height: "140px",
            top: "-70px",
            opacity: 1,
            marginLeft: "-70px"
        }, 200);
    });
}

function initiAnimateButtonAlert(classAdd) {
    $(".button-alert").animate({
        width: "80px",
        height: "80px",
        top: "-40px",
        opacity: 0.5,
        marginLeft: "-40px"
    }, 200, function () {
        $(".button-alert").removeAttr('style');
        $('.button-alert').removeClass('button-alert-load').removeClass('ui-admin-circles-loader').addClass(classAdd);
        $(".button-alert").show().animate({
            width: "140px",
            height: "140px",
            top: "-70px",
            opacity: 1,
            marginLeft: "-70px"
        }, 200);
    });
}

function initiCloseAlert(classAdd, action) {
    $(".button-alert").animate({
        width: "80px",
        height: "80px",
        top: "-40px",
        opacity: 0,
        marginLeft: "-40px"
    }, 200, function () {
        $('.button-alert').removeAttr('class').addClass(classAdd);
        $('#main-message-alert').animate({
            top: '0'
        }, 200, function () {
            $('#main-message-alert').removeAttr('style');
            $(".button-alert").removeAttr('style');
            $('.setFechamentoAutomatico').removeAttr('style');
            $('.button-close-alert').removeAttr('style').html('Fechar Notificação');
            $('#main-alert').removeAttr('style');
            $('#button-insert').removeAttr("disabled");
            $('#button-goBack').removeAttr("disabled");
            if (action == 'reload') {
                location.reload();
            } else if (action == 'back') {
                var url_back = document.referrer;;
                if (url_back == '' || url_back == null) url_back == url_site;
                window.location = url_back;
            }
        });
    });
}

function startCountdown(tempo) {
    tempo = tempo / 1000;
    // Se o tempo não for zerado
    if ((tempo - 1) >= 0) {
        if (tempo < 10) tempo = '0' + tempo;
        horaImprimivel = '00:00:' + tempo; // Cria a variável para formatar no estilo hora/cronômetro

        $(".setFechamentoAutomatico strong").html(horaImprimivel); // Imprime hora na tela

        tempo--;
        tempoms = tempo * 1000; //Diminui 1 seg do tempo e multiplica por mill para repassar valor para função
        setTimeout(function () {
            startCountdown(tempoms)
        }, 1000); //Reinicia a Função em 1 seg
    }
}

function updateAlert(status, message, action) {
    var originalTitle = $('.title-status-alert').html(),
        originalMessage = $('.message-status-alert').html();

    if (action == null || action == '') action = 'reload';

    if (status == 'true') {
        initiAnimateButtonAlert('ui-admin-like button-alert-confirm');
        $('.title-status-alert').html('Sucesso');
        $('.message-status-alert').html(message);
        $('#main-message-alert').css({
            height: '300',
            marginTop: '-150'
        });
        $('.setFechamentoAutomatico').css({
            display: "block"
        });
        $('.button-close-alert').css({
            display: "block",
            marginTop: '10px'
        }).html('Fechar já').attr('data-action', action);
        startCountdown(10000);
        setTimeout(function () {
            initiCloseAlert('button-alert button-alert-load ui-admin-circles-loader', action);
            $('.title-status-alert').html(originalTitle);
            $('.message-status-alert').html(originalMessage);
        }, 10000);
    } else if (status == 'error') {
        initiAnimateButtonAlert('ui-admin-dislike-social-gesture button-alert-error');
        $('.title-status-alert').html('Erro ao executar');
        $('.message-status-alert').html(message);
        $('.title-status-alert').attr('originalTitle', originalTitle),
            $('.message-status-alert').attr('originalMessage', originalMessage);
        $('.button-close-alert').css({
            display: "block"
        });
    } else {
        initiAnimateButtonAlert('ui-admin-dislike-social-gesture button-alert-error');
        $('.title-status-alert').html('Retorno Incoerente');
        $('.message-status-alert').html('Sistema retornou uma mensagem não identificada, ela pode ser positiva ou negativa, contate o administrador do sistema para verificar o que está acontecendo');
        $('.title-status-alert').attr('originalTitle', originalTitle),
            $('.message-status-alert').attr('originalMessage', originalMessage);
        $('.button-close-alert').css({
            display: "block"
        });
    }
}

function updateAlertCollumn(status, message, idStyle) {
    var originalTitle = $('.title-status-alert').html(),
        originalMessage = $('.message-status-alert').html();

    initiAnimateButtonAlert('ui-admin-like button-alert-confirm');
    $('.title-status-alert').html('Sucesso');
    $('.message-status-alert').html(message);
    $('#main-message-alert').css({
        height: '300',
        marginTop: '-150'
    });
    $('.setFechamentoAutomatico').css({
        display: "block"
    });
    $('.button-close-alert').css({
        display: "block",
        marginTop: '10px'
    }).html('Fechar já');
    startCountdown(10000);
    setTimeout(function () {
        initiCloseAlertCollumn('button-alert button-alert-load ui-admin-circles-loader', idStyle);
        $('.title-status-alert').html(originalTitle);
        $('.message-status-alert').html(originalMessage);
    }, 10000);
}

/**
 * Executa fechamamento de alerta para true pagina de style collumn
 * 
 */
function initiCloseAlertCollumn(classAdd, idStyle) {
    $(".button-alert").animate({
        width: "80px",
        height: "80px",
        top: "-40px",
        opacity: 0,
        marginLeft: "-40px"
    }, 200, function () {
        $('.button-alert').removeAttr('class').addClass(classAdd);
        $('#main-message-alert').animate({
            top: '0'
        }, 200, function () {
            $('#main-message-alert').removeAttr('style');
            $(".button-alert").removeAttr('style');
            $('.setFechamentoAutomatico').removeAttr('style');
            $('.button-close-alert').removeAttr('style').html('Fechar Notificação');
            $('#main-alert').removeAttr('style');
            $('#button-insert').removeAttr("disabled");
            $('#button-goBack').removeAttr("disabled");
            window.location.replace(url_site + idStyle);
        });
    });
}


/**
 * Executa as funçoes da pagina de clonagem de permissões
 * 
 */
function showClone() {
    $('#main-clone-permission').fadeIn();
    $('#main-user-list-clone').show().animate({
        top: '50%'
    }, 500, function () {
        $(".button-alert").show().animate({
            width: "140px",
            height: "140px",
            top: "-70px",
            opacity: 1,
            marginLeft: "-70px"
        }, 200);
    });
}

function updateClone(status, usuarios) {
    var originalTitle = $('.title-status-alert').html(),
        originalMessage = $('.message-status-alert').html(),
        quantLines = Math.ceil(usuarios.length / 2),
        sizeHeight = (quantLines * 60) + 220,
        sizeMargin = sizeHeight / 2;



    if (usuarios.length >= 1) {
        initiAnimateButtonAlert('ui-admin-like button-alert-confirm');
        $('.title-status-alert').hide();
        $('.message-status-alert').css({
            marginTop: '50px',
            height: '25px'
        }).html('Selecione um usuário para conar suas permissões');
        $('#main-user-list-clone').css({
            height: sizeHeight + 'px',
            marginTop: '-' + sizeMargin + 'px'
        });
        $('.button-close-clone').css({
            display: "block",
            marginTop: '35px'
        }).html('Canselar');
        $('#main-list-user-clone').show();

        for (var key = 0; key < usuarios.length; key++) {
            var li = "<li class='ui-admin-copy-interface-outlined-sign' data-userId='" + usuarios[key].id_login_user + "'><span>" + usuarios[key].name + "</span><strong>" + usuarios[key].type_user + "</strong></li>"
            $('#main-list-user-clone').append(li);
        }


        // $('.setFechamentoAutomatico').css({ display: "block" });
        //startCountdown(10000);
        setTimeout(function () {
            // initiCloseAlert('button-alert button-alert-load ui-admin-circles-loader');
            // $('.title-status-alert').html(originalTitle);
            // $('.message-status-alert').html(originalMessage);
        }, 10000);
    } else {
        initiAnimateButtonAlert('ui-admin-dislike-social-gesture button-alert-error');
        $('.title-status-alert').html('Erro');
        $('.message-status-alert').html('Não Foi possivel encontrar usuários para clonar as permissões.');
        $('.title-status-alert').attr('originalTitle', originalTitle),
            $('.message-status-alert').attr('originalMessage', originalMessage);
        $('.button-close-clone').css({
            display: "block",
            marginTop: '35px'
        }).html('Fechar');
    }
}

function updateCloneFinish(status, message, menus) {
    var originalTitle = $('.title-status-alert').html(),
        originalMessage = $('.message-status-alert').html(),
        quantLines = Math.ceil(menus.length / 2),
        sizeHeight = (quantLines * 40) + 280,
        sizeMargin = sizeHeight / 2;

    if (status == 'true') {
        initiAnimateButtonAlert('ui-admin-like button-alert-confirm');
        $('.title-status-alert').html('Sucesso');
        $('.message-status-alert').html(message);
        $('.button-close-clone').css({
            display: "block",
            marginTop: '35px'
        }).html('Fechar já');
        $('#main-user-list-clone').css({
            height: '320px',
            marginTop: '-140px'
        });

        $('.setFechamentoAutomatico').css({
            display: "block"
        });
        startCountdown(10000);
        setTimeout(function () {
            initiCloseClone('button-alert button-alert-load ui-admin-circles-loader');
            $('.title-status-alert').html(originalTitle);
            $('.message-status-alert').html(originalMessage);
        }, 10000);
    } else if (status == 'false') {
        initiAnimateButtonAlert('ui-admin-dislike-social-gesture button-alert-error');
        $('.title-status-alert').html('Erro ao executar');
        $('.message-status-alert').html(message);
        $('.title-status-alert').attr('originalTitle', originalTitle),
            $('.message-status-alert').attr('originalMessage', originalMessage);
        $('.button-close-clone').css({
            display: "block"
        }).html('Fechar');
        $('#main-user-list-clone').css({
            height: sizeHeight + 'px',
            marginTop: '-' + sizeMargin + 'px'
        });
        $('#main-list-user-clone').html('').show();

        for (var key = 0; key < menus.length; key++) {
            var li = "<li class='item-list-user-error'><span>" + menus[key].name + " - " + menus[key].status + "</span></li>"
            $('#main-list-user-clone').append(li);
        }

    } else {
        initiAnimateButtonAlert('ui-admin-dislike-social-gesture button-alert-error');
        $('.title-status-alert').html('Retorno Incoerente');
        $('#main-user-list-clone').css({
            height: sizeHeight + 'px',
            marginTop: '-' + sizeMargin + 'px'
        });
        $('.message-status-alert').html('Houve um erro desconhecido na hora de adicionar permissões');
        $('.title-status-alert').attr('originalTitle', originalTitle),
            $('.message-status-alert').attr('originalMessage', originalMessage);
        $('.button-close-clone').css({
            display: "block"
        }).html('Fechar');
        $('#main-list-user-clone').html('').show();

        for (var key = 0; key < menus.length; key++) {
            var li = "<li class='item-list-user-error'><span>" + menus[key].name + " - " + menus[key].status + "</span></li>"
            $('#main-list-user-clone').append(li);
        }
    }
}

function updateMessageClone(userName) {
    initiCloseAlert('button-alert button-alert-load ui-admin-circles-loader');
    $(".button-alert").show().animate({
        width: "140px",
        height: "140px",
        top: "-70px",
        opacity: 1,
        marginLeft: "-70px"
    }, 200);
    $('.title-status-alert').show().html('Clonando');
    $('.message-status-alert').removeAttr('style').html('Estamos clonando as permissões de ' + userName + ', aguarde...');
    $('#main-user-list-clone').css({
        height: '200px',
        marginTop: '-100px'
    });
    $('#main-list-user-clone').removeAttr('style');
    $('.button-close-clone').removeAttr('style');

}

function initiCloseClone(classAdd) {
    $(".button-alert").animate({
        width: "80px",
        height: "80px",
        top: "-40px",
        opacity: 0,
        marginLeft: "-40px"
    }, 200, function () {
        $('.button-alert').removeAttr('class').addClass(classAdd);
        $('#main-user-list-clone').animate({
            top: '0'
        }, 200, function () {
            $('#main-user-list-clone').removeAttr('style');
            $(".button-alert").removeAttr('style');
            $('.setFechamentoAutomatico').removeAttr('style');
            $('.button-close-alert').removeAttr('style').html('Fechar Notificação');
            $('#main-alert').removeAttr('style');
            location.reload();
        });
    });
}



/*
 * Executa apos o carregamento da página esteja completo
 * 08/2018
 * Vk2 Studio Web
 */
$(window).on("load", function (e) {

    /**
     * Traduçao Das mensagens para Validate
     */
    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo &eacute; obrigatório.",
        remote: "Por favor, corrija este campo.",
        email: "Por favor, forne&ccedil;a um e-mail v&aacute;lido.",
        url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
        date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
        dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
        number: "Forne&ccedil;a um n&uacute;mero",
        cnpj: "Esse CNPJ/CPF j&aacute; est&aacute; sendo utilizado.",
        digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
        creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
        equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
        accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
        maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
        range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
        max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
        min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
    });
});



/*
 * Execução enquanto pag. estiver carregando
 * 12/2018
 * Vk2 Studio Web
 */
$(document).ready(function () {
    newCreate();
    newCreateCustom();
    mainFormCollumnStyle();
    sendPasswordReset();
    passwordReset();

    /**
     * Lista de Mascaras pre-criadas
     */
    $('.date').mask('00/00/0000');
    $('.date_dmy').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.phone_with_ddd').mask('(00) 0 0000-00000');
    $('.cpf').mask('000.000.000-00', {
        reverse: true
    });
    $('.cnpj').mask('00.000.000/0000-00', {
        reverse: true
    });
    $('.money').mask('#.##0,00', {
        reverse: true
    });
    $('.weight').mask('#.##0,00', {
        reverse: true
    });

    /**
     * Funçao padrão salvar dados
     */
    function newCreate() {
        var options = {
            beforeSubmit: showRequest,
            success: showResponse
        };
        function showRequest(formData, jqForm, options) {
            $('#button-insert').attr("disabled", true);
            $('#button-goBack').attr("disabled", true);
            showAlert();
        }
        function showResponse(responseText, statusText, xhr) {
            var obj = jQuery.parseJSON(responseText);

            if (obj.status == 'true') {
                updateAlert(obj.status, obj.message);
                $('#mainFormInsert')[0].reset();
            } else {
                updateAlert(obj.status, obj.message);
            }
        }
        $("#mainFormInsert").validate({
            debug: false,
            errorClass: 'error-message',
            errorElement: 'span',
            ignore: [],
            highlight: function (element) {
                $(element).parent().addClass("main-error");
            },
            unhighlight: function (element) {
                $(element).parent().removeClass("main-error");
            },
            rules: {},
            submitHandler: function (form) {
                $(form).ajaxSubmit(options);
            },
            errorLabelContainer: $()
        });
    }
    function newCreateCustom() {
        var options = {
            beforeSubmit: showRequest,
            success: showResponse
        };
        function showRequest(formData, jqForm, options) {
            $('#custom-button-insert').attr("disabled", true);
            $('#button-goBack').attr("disabled", true);
            showAlert();
        }
        function showResponse(responseText, statusText, xhr) {
            var obj = jQuery.parseJSON(responseText);

            if (obj.status == 'true') {
                updateAlert(obj.status, obj.message);
                $('#mainFormInsertCustom')[0].reset();
            } else {
                updateAlert(obj.status, obj.message);
            }
        }
        $("#mainFormInsertCustom").validate({
            debug: false,
            errorClass: 'error-message',
            errorElement: 'span',
            highlight: function (element) {
                $(element).parent().addClass("main-error");
            },
            unhighlight: function (element) {
                $(element).parent().removeClass("main-error");
            },
            rules: {},
            submitHandler: function (form) {
                $(form).ajaxSubmit(options);
            },
            errorLabelContainer: $()
        });
    }

    /**
     * Formulário Salvar dados da Configuração de Estilos 
     */
    function mainFormCollumnStyle() {
        var options = {
            beforeSubmit: showRequest,
            success: showResponse
        };

        function showRequest(formData, jqForm, options) {
            $('.button-delete-register-collumnstyle').attr("disabled", true);
            $('.button-update-register-collumnstyle').attr("disabled", true);
            showAlert();

        }

        function showResponse(responseText, statusText, xhr) {
            var obj = jQuery.parseJSON(responseText);

            if (obj.status == 'true') {
                updateAlertCollumn(obj.status, obj.message, obj.idStyle);
                $('#mainFormCollumnStyle')[0].reset();
            } else {
                updateAlert(obj.status, obj.message);
            }
        }

        $("#mainFormCollumnStyle").validate({
            debug: false,
            errorClass: 'error-message',
            errorElement: 'span',
            ignore: [],
            highlight: function (element) {
                $(element).parent().addClass("main-error");
            },
            unhighlight: function (element) {
                $(element).parent().removeClass("main-error");
            },
            rules: {},
            submitHandler: function (form) {
                $(form).ajaxSubmit(options);
            },
            errorLabelContainer: $()
        });
    }

    /**
     * Formulário enviar solicitação de nova senha 
     */
    function sendPasswordReset() {
        var options = {
            beforeSubmit: showRequest,
            success: showResponse
        };

        function showRequest(formData, jqForm, options) {
            $('#sendPasswordReset button.btn').attr("disabled", true);
            $('#sendPasswordReset button.btn').html("REALIZANDO ENVIO...");
            $('#sendPasswordReset button.btn').addClass("btn-info");
            showAlert();
        }

        function showResponse(responseText, statusText, xhr) {
            $('#sendPasswordReset button.btn').removeClass("btn-info");
            $('#sendPasswordReset button.btn').attr("disabled", false);
            if (responseText == 'false') {
                $("#sendPasswordReset button.btn").html("CONTA NÃO ENCONTRADA");
                $("#sendPasswordReset button.btn").addClass("btn-warning");
                setTimeout(function() {
                    $("#sendPasswordReset button.btn").html("SOLICITAR NOVA SENHA");
                    $("#sendPasswordReset button.btn").removeClass("btn-warning");
                    $('#sendPasswordReset #submit').attr("disabled", false);
                }, 4000);
            } else if (responseText == 'failed'){
                $('#sendPasswordReset button.btn').html('ERRO NO ENVIO, ENTRE EM CONTATO');
                $('#sendPasswordReset button.btn').addClass("btn-danger");
            } else {
                $("#sendPasswordReset button.btn").addClass("btn-success");
                $("#sendPasswordReset button.btn").html("SUCESSO");
                var origin = window.location.origin;
                // setTimeout(function() {
                //     window.location.replace(origin + "/login");
                // }, 2000);
            }
        }

        $("#sendPasswordReset").validate({
            debug: false,
            errorClass: 'error-message',
            errorElement: 'span',
            highlight: function (element) {
                $(element).parent().addClass("main-error");
            },
            unhighlight: function (element) {
                $(element).parent().removeClass("main-error");
            },
            rules: {
                "type": {
                    required: true,
                    min: 1,
                    max: 3,
                },
                "email": {
                    required: true,
                    email: true,
                },
            },
            submitHandler: function (form) {
                console.log(form);
                console.log(options);
                $(form).ajaxSubmit(options);
            },
            errorLabelContainer: $()
        });
    }


    /**
     * Formulário efetura alteração de senha
     */
    function passwordReset() {
        var options = {
            beforeSubmit: showRequest,
            success: showResponse
        };

        function showRequest(formData, jqForm, options) {
            $("#passwordReset button.btn").attr("disabled", true);
            $("#passwordReset button.btn").html("Preparando envio...");
        }

        function showResponse(responseText, statusText, xhr) {
            if(responseText == "success"){
                $("#passwordReset button.btn").addClass("btn-success");
                $("#passwordReset button.btn").html("SUCESSO");
                var origin = window.location.origin;
                setTimeout(function() {
                    window.location.replace(origin + "/login");
                }, 2000);
            }
            else {
                $("#passwordReset button.btn").addClass("btn-warning");
                $("#passwordReset button.btn").html("Ocorreu um problema ao salvar sua senha");
            }
        }

        $("#passwordReset").validate({
            debug: false,
            errorClass: 'error-message',
            errorElement: 'span',
            highlight: function (element) {
                $(element).parent().addClass("main-error");
            },
            unhighlight: function (element) {
                $(element).parent().removeClass("main-error");
            },
            rules: {
                "password": {
                    required: true
                },
                "password_confirmation": {
                    required: true,
                    equalTo: "#password"
                },
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit(options);
            },
            errorLabelContainer: $()
        });
    }
    


    /**
     * Collumns Style deletar dados
     */

    $('.button-delete-register-collumnstyle').click(function () {
        var idCollumnStyle = $(this).attr('data-idStyle'),
            token = $("input[name='_token']").val();

        $('.button-delete-register-collumnstyle').attr("disabled", true);
        $('.button-update-register-collumnstyle').attr("disabled", true);
        showAlert();

        $.ajax({
            url: url_site + 'remove',
            type: "POST",
            dataType: "JSON",
            data: {
                idCollumnStyle: idCollumnStyle,
                _token: token
            },
            sync: false,
            success: function (responseText) {
                if (responseText.status == 'true') {
                    $('#collumnstyle-item-' + idCollumnStyle).slideUp();
                    updateAlert(responseText.status, responseText.message);

                } else {
                    updateAlert(responseText.status, responseText.message);
                }
            }
        });

    });

    //Fecha div de alerta para usuario
    $('.button-close-alert').click(function () {
        var action = $(this).attr('data-action');
        if (action == null || action == '') action = 'reload';
        initiCloseAlert('button-alert button-alert-load ui-admin-circles-loader', action);
    });

    //Fecha div de clone de usuário
    $('.button-close-clone').click(function () {
        initiCloseClone('button-alert button-alert-load ui-admin-circles-loader');
    });

    /* #region Aceitar/Recusar Solicitações de alterações*/

    // Aceitar
    $('#main-button-list').on('click', '.main-button-list.main-button-aprove-solititation', function ()  {
        
        showAlert();
        $(this).attr("data-execute", 1);

        $id = $(this).attr("data-id");
        token = $('meta[name="csrf-token"]').attr('content');

        url = url_site + "aprove/" + $id;

        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            data: {
                _token: token
            },
            sync: false,
            success: function (json) {
                result = json;
                updateAlert(result.status, result.message, 'back');
            }
        });
    });

    // Recusar
    $('#main-button-list').on('click', '.main-button-list.main-button-reprove-solititation', function ()  {
        showAlert();
        $(this).attr("data-execute", 1);

        $id = $(this).attr("data-id");
        $status = 0;
        token = $('meta[name="csrf-token"]').attr('content');

        url = url_site + "reject/" + $id + "/" + $status;

        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            data: {
                _token: token
            },
            sync: false,
            success: function (json) {
                result = json;
                updateAlert(result.status, result.message, 'back');
            }
        });
    });
    /* #endregion */


    //Trabalha As permissões
    $(".permission-select").click(function () {
        /**
         *  Testa açoes possiveis e executa a opçao correta
         * 
         * 0 Para marcar ou desmarcar todas as opções
         * 1 So visualiza
         * outros marca como possivel
         */
        var pageName = $(this).closest('.page-permission').attr('id'),
            pageId = $(this).closest('.page-permission').attr('data-page'),
            active = $(this).attr('data-active'),
            quantSelect = parseInt($(this).closest('.page-permission').attr('data-quantSelect')),
            userId = $("#main-permission-list").attr('data-user'),
            action = $(this).attr('data-action'),
            token = $("input[name='_token']").val();

        $.ajax({
            url: url_site + 'update',
            type: "POST",
            dataType: "JSON",
            data: {
                user: userId,
                page: pageId,
                action: action,
                active: active,
                _token: token
            },
            sync: false,
            success: function (json) {
                valores = json;
            }
        });


        if (action == 0) {

            if (active == 0) {
                $("#" + pageName).children(".permission-select").attr('data-active', 1);
                $("#" + pageName).attr('data-quantSelect', 6);
                $("#" + pageName + " .marker-permission").addClass('marker-permission-true').html('Sim');
            } else {
                $("#" + pageName).children(".permission-select").attr('data-active', 0);
                $("#" + pageName).attr('data-quantSelect', 0);
                $("#" + pageName + " .marker-permission").removeClass('marker-permission-true').html('Não');
            }

        } else if (action == 1) {

            if (active == 0) {
                $(this).attr('data-active', 1);
                $(this).children(".marker-permission").addClass('marker-permission-true').html('Sim');
                $("#" + pageName).attr('data-quantSelect', 1);
            } else {
                $(this).attr('data-active', 0);
                $("#" + pageName).attr('data-quantSelect', 0);
                $("#" + pageName + " .marker-permission").removeClass('marker-permission-true').html('Não');
            }

        } else {

            if (active == 0) {

                /**
                 * Verifica se o item de visualizar está ativo 
                 * Caso nao esteja ativa o mesmo
                 */
                var activeView = $(this).prevAll().filter(function (index) {
                    return $(this).attr("data-action") === "1";
                }).attr('data-active');
                if (activeView == 0) {
                    $(this).prevAll().filter(function (index) {
                        return $(this).attr("data-action") === "1";
                    }).attr('data-active', 1).children(".marker-permission").addClass('marker-permission-true').html('Sim');
                    quantSelect = quantSelect + 1
                }

                /**
                 * Verifica se todos os iten marcados
                 * ativa botão de todos marcados
                 */
                if (quantSelect >= 5) {
                    $(this).prevAll().filter(function (index) {
                        return $(this).attr("data-action") === "0";
                    }).attr('data-active', 1).children(".marker-permission").addClass('marker-permission-true').html('Sim');
                }

                /**
                 * Ativa botão precionado */
                $(this).attr('data-active', 1);
                $(this).children(".marker-permission").addClass('marker-permission-true').html('Sim');
                $("#" + pageName).attr('data-quantSelect', quantSelect + 1);
            } else {
                $(this).attr('data-active', 0);
                $("#" + pageName).attr('data-quantSelect', quantSelect - 1);
                $(this).children(".marker-permission").removeClass('marker-permission-true').html('Não');
                /**
                 * Verifica se todos os iten marcados
                 * ativa botão de todos marcados
                 */
                if (quantSelect == 6) {
                    $(this).prevAll().filter(function (index) {
                        return $(this).attr("data-action") === "0";
                    }).attr('data-active', 0).children(".marker-permission").removeClass('marker-permission-true').html('Não');
                }
            }

        }

    });

    $('.button-permission-clone').click(function () {

        var idUser = $(this).attr('data-idUser'),
            idPermission = $(this).attr('data-idPermission'),
            token = $("input[name='_token']").val();

        //Inicia Exibiçao da pagina do clone
        showClone();

        $.ajax({
            url: url_site + 'getUserClone',
            type: "POST",
            dataType: "JSON",
            data: {
                user: idUser,
                permission: idPermission,
                _token: token
            },
            sync: false,
            success: function (json) {
                updateClone(json.success, json.usuarios);
            }
        });
    });

    $('#main-list-user-clone').on('click', 'li', function (event) {
        var idUserClone = $(this).attr('data-userid'),
            idUserUpdate = $('.button-permission-clone').attr('data-idUser'),
            nameUser = $(this).find('span').html(),
            token = $("input[name='_token']").val();

        updateMessageClone(nameUser);
        $.ajax({
            url: url_site + 'cloneUser',
            type: "POST",
            dataType: "JSON",
            data: {
                idUserClone: idUserClone,
                idUserUpdate: idUserUpdate,
                _token: token
            },
            sync: false,
            success: function (json) {
                updateCloneFinish(json.status, json.message, json.updates);
            }
        });

    });

});