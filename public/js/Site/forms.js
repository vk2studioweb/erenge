/*
* Lista de Funções JS
* Vk2 Studio Web
* 08/2019
*/

$(window).on("load", function (e) {
    // Aplica mascaras dos telefones
    $('.mask-phone-ddd').trigger('focusout');
});

$(document).ready(function () {

    //---Traduçao Das mensagens para Validate---//
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
        min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}."),
        greaterThan: jQuery.validator.format("Nº acima do dispon&iacute;vel")
    });
    //---Funções adicionais de validator---//
    jQuery.validator.addMethod("notEqual", function (value, element, param) {
        return this.optional(element) || value != param;
    }, "Selecione um valor");

    $('body').on('focus', '.weight', function () {$(this).mask('#.##0,00');});
    $('body').on('focus', '.mask-date-iso', function () {$(this).mask('00-00-0000');});
    $('body').on('focus', '.mask-date', function () {$(this).mask('00/00/0000');});
    $('body').on('focus', '.mask-time', function () {$(this).mask('00:00:00');});
    $('body').on('focus', '.mask-date-time', function () {$(this).mask('00/00/0000 00:00:00');});
    $('body').on('focus', '.mask-cep', function () {$(this).mask('00000-000');});
    $('body').on('focus', '.mask-cpf', function () {$(this).mask('000.000.000-00');});
    $('body').on('focus', '.mask-cardNumber', function () {$(this).mask('0000 0000 0000 0000');});
    $('body').on('focus', '.mask-expirationDate', function () {$(this).mask('00/00');});
    $('body').on('focus', '.mask-securityCode', function () {$(this).mask('000');});
    $('body').on('focus', '.mask-cnpj', function () {$(this).mask('00.000.000/0000-00');});
    $('body').on('focus', '.weight', function () {$(this).mask('#.##0,00', {reverse: true});});
    $('.money').mask('#.##0,00', {reverse: true});
    $('body').on('focusout', '.mask-phone-ddd', function () {
        var telefone, element;
        element = $(this);
        element.unmask();
        telefone = element.val().replace(/\D/g, '');
        if (telefone.length > 10) {
            element.mask('(99) 9 9999-9999');
        } else {
            element.mask('(99) 9999-99999');
        }
    }).trigger('focusout');
    jQuery.validator.addMethod("greaterThan", function (value, element, params) {}, 'Must be greater than {1}.');
    jQuery.validator.addMethod("dateFormat", function (value, element) {
        var check;
        var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
        if (value.match(reg)) {
            var check = true;
        } else {
            var check = false;
        }
        return this.optional(element) || check;
    }, "Insira uma data válida!");

    jQuery.validator.addMethod("notEqual", function (value, element, param) { return this.optional(element) || value != param; }, "Selecione um valor");
    $('form').on('change','.inputfile' , function(){
        var $input	 = $(this),
        $label	 = $input.prev('label'),
        labelVal = $label.html(),
        fileName = '';
        filename = $input[0].files[0].name;
        $label.html(filename);
    });

    $("#form-register").validate({
        debug: false,
        errorClass: 'error-message',
        errorElement: 'span',
        ignore: [],
        rules: {
            'name': { required: true },
            'phone': { required: true, rangelength: [14, 16] },
            'phone2': { equalTo: "#phone" }
        },
        messages: {
            'phone': "Forneça um telefone válido",
            'phone2': "Os telefones devem ser iguais"
        },
        highlight: function (element) { 
            $(element).parent().addClass("main-error");
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("main-error");
        },
        // SOLUÇÃO: Comente ou remova o submitHandler antigo.
        // Se quiser apenas que o form siga o fluxo normal, use:
        submitHandler: function (form) {
            form.submit(); // Isso faz o POST nativo do HTML
        }
    });

    $('#paymentParcel').change(function(){
        let parcel = $(this).val(),
            price = $('.parcel-information').data('price');

        if (parcel > 0) {
            let result = price / parcel;
    
            // Exibe no console com 2 casas decimais
            console.log("Valor da parcela: R$ " + result.toFixed(2));
            $('.parcel-information').text('de R$ ' + result.toLocaleString('pt-br', {minimumFractionDigits: 2}));
        }
    });

    $("#form-payment").validate({
        debug: false,
        errorClass: 'error-message',
        errorElement: 'span',
        ignore: [],
        rules: {
            'cardNumber': { required: true },
            'cardholderName': { required: true },
            'expirationDate': { required: true },
            'securityCode': { required: true, number: true },
            'cpf': { required: true }
        },
        messages: {
            'cardNumber': "Número do cartão obrigatório",
            'cardholderName': "Nome do titular obrigatório",
            'expirationDate': "Obrigatório informar a data de expiração",
            'securityCode': "Forneça um código de segurança",
            'cpf': "CPF obrigatório"
        },
        highlight: function (element) { 
            $(element).parent().addClass("main-error");
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("main-error");
        },
        // SOLUÇÃO: Comente ou remova o submitHandler antigo.
        // Se quiser apenas que o form siga o fluxo normal, use:
        submitHandler: function (form) {
            form.submit(); // Isso faz o POST nativo do HTML
        }
    });

    if($('#contact-form')){ sendContact(); }
    
    function sendContact(){
        var options = {
            beforeSubmit: showRequest,
            data: { secure: 'vk2' },
            success: showResponse
        },
        button = $('.contact-formButton'),
        message = $('.form-message');

        function showRequest(formData, jqForm, options) {
            message.html("Enviando sua mensagem...");
            button.css({'pointer-events': 'none'});
        }

        function showResponse(data,jqForm) {
            data = JSON.parse(data);
            if(data['status'] == 'success'){
                message.html("Mensagem enviada com sucesso!");
                button.css({'pointer-events': 'all'});
                setTimeout(function(){
                    message.html('');
                    $("#contact-form")[0].reset();
                },4000);
            } else {
                message.html(data['message']);
                setTimeout(function(){
                    message.html('');
                },4000);
            }
        }
        $("#contact-form").validate({
            debug: false,
            errorClass: 'error-message',
            errorElement: 'span',
            ignore: [],
            rules: {
                'name':		{ required:true },
                'phone':	{ required:true, rangelength:[14,15] },
                'description':	{ required:true, minlength: 10 }
            },
            messages:{
                'phone': "Forneça um telefone válido"
            },
            highlight: function (element) { $(element).parent().addClass("main-error");},
            unhighlight: function (element) {$(element).parent().removeClass("main-error");},
            submitHandler: function (form) {$(form).ajaxSubmit(options);},
            errorLabelContainer: $()
        });
    }
});
