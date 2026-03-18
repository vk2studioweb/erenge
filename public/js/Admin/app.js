/*
* Lista de Funções JS
* Vk2 Studio Web
* 08/2018
*/

function setHeightAndWidthAsside()
{
	var bodyHeight = $( document ).height() - 40,
	mainHeight = $('#main-content').height(),
	bodyWidth = $( window ).width();

	if(bodyWidth > 1000){
		if(bodyHeight > mainHeight) $('#main-sidebar').height(bodyHeight);
		else $('#main-sidebar').height(mainHeight);
	} else{
		$('#main-sidebar').attr('data-open', 0);
		$('#main-sidebar').height(mainHeight);
	}
}

function setWidthContent()
{
	var bodyWidth = $( window ).width(),
	assideWidth = $('#main-sidebar').width(),
	contentWidth = 0;
	if(bodyWidth > 1000){
		if(assideWidth > 400){
			setTimeout(function(){
				assideWidth = $('#main-sidebar').width(),

				contentWidth = bodyWidth - assideWidth - 80;
				$('#main-content').width(contentWidth).css({ marginLeft : assideWidth+"px"});
			}, 200);
		} else {
			contentWidth = bodyWidth - assideWidth - 80;

			$('#main-content').width(contentWidth).css({ marginLeft : assideWidth+"px"});

		}
	} else if (bodyWidth <= 1000 && bodyWidth > 515) {
		contentWidth = bodyWidth - 80;
		$('#main-content').width(contentWidth).css({ margin : "0 auto"});
	} else {
		contentWidth = bodyWidth - 20;
		$('#main-content').width(contentWidth);

	}
	$('table.logTable').width(contentWidth - 20 + "px");
	$('table.logTable').css({'padding': '10px'});
	setSizeListCollumns();
}

/**
* Função que seta o tamanho dos campos de listagem
* 16/2018
* Vk2 - Julio
*/
function setSizeListCollumns()
{
	var listWidth = $('#title-list-data').width();                              // Tamanho total da UL
	sizeSelectColllumn = $('.size-item-select').width() + 11,               //Tamanho da coluna Select + 11px do padding que o jQuery ignora
	sizeStatusCollumn = $('.size-item-status').width() + 11,                 //Tamanho da coluna Status + 11px do padding que o jQuery ignora
	sizeUlAvailable = listWidth-(sizeSelectColllumn+sizeStatusCollumn);    //Tamanho total disponivel para divisão de collunas

	// Caso html não tenha carregado completamente listWidth vai retornar numero menor que 400, para retornar valor correto espera 200ms para retestar os tamanhos

	if(sizeUlAvailable < 60){
		setTimeout(function(){
			listWidth = $('#title-list-data').width();
			sizeSelectColllumn = $('.size-item-select').width() + 11,
			sizeStatusCollumn = $('.size-item-status').width() + 11,
			sizeUlAvailable = listWidth-(sizeSelectColllumn+sizeStatusCollumn);
			setSizeListCollums(sizeUlAvailable);
		}, 300);
	} else{
		setSizeListCollums(sizeUlAvailable);
	}
}

function setSizeListCollums(sizeUlAvailable){
	// Percorre array de collunas e faz calculo de tamanhos para a listagem
	$.each( $( ".item-set-size" ), function() {
		var collumnSize = $(this).attr('data-size'),
		collumnName = $(this).attr('data-collumn'),
		setSize = (((sizeUlAvailable*collumnSize)/100) - 10.1).toFixed(2);

		//seta tamanho adequado a colluna especifica
		$('.size-'+collumnName+'-'+collumnSize).width(setSize);
	});
}

//--------------------------------//
// Custom combobox with Jquery-ui //
//--------------------------------//
$(function () {
  $.widget("custom.combobox", {
    // Combobox constructor
    _create: function () {
      // Creates caontainer for search input and button
      this.wrapper = $("<span>")
        .addClass("custom-combobox")
        .insertAfter(this.element);
      // Hides original selectbox
      this.element.hide();
      // Call next functions
      this._createAutocomplete();
      this._createShowAllButton();
    },

    // Create autocomplete input, that will filter results
    _createAutocomplete: function () {
      // Select -> Select element
      // Value -> default/select value
      // disabled -> Disabled check
      let $select = this.element;
      let selected = this.element.children(":selected");
      let value = selected.val() ? selected.text() : "";
      let disabled = $($select).attr('data-disabled');
      // If data-disabled = true, add input in disabled mode
      if (typeof disabled !== typeof undefined && disabled !== false && disabled == "true") {
        this.input = $("<input>")
        .appendTo(this.wrapper)
        .val(value)
        .attr("title", "")
        .prop("disabled", true)
        .addClass(
          "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ")
        .autocomplete({
          delay: 0,
          minLength: 0,
          source: $.proxy(this, "_source")
        })
        .tooltip({
          classes: {
            "ui-tooltip": "ui-state-highlight"
          }
        });
      }
      // Else keep enabled
      else{
        this.input = $("<input>")
        .appendTo(this.wrapper)
        .val(value)
        .attr("title", "")
        .addClass(
          "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ")
        .autocomplete({
          delay: 0,
          minLength: 0,
          source: $.proxy(this, "_source")
        })
        .tooltip({
          classes: {
            "ui-tooltip": "ui-state-highlight"
          }
        });
      }
      // Bind input to on autocompleteselect event
      this._on(this.input, {
        autocompleteselect: function (event, ui, select = $select) {
          // $child = Name of child select
          // clear_targets = Aray of names of to empty and disable selects
          let $child = $(select).attr('data-child');
          let clear_targets = $(select).attr('data-clear');
          // If has child, do ajax and load child values
          if (typeof $child !== typeof undefined && $child !== false) {
            // Retrieve the child
            $child = jQuery("[name='" + $child + "']");
            // Autocomplete function and path
            let autocomplete_name = $child.attr('data-autocomplete');
            // Retrieve topmost container, from all the selects
            let $parent = $child.parent().parent().parent();
            let area = (window.location.pathname.split('/'))[2];
            console.log( "/admin/" + area + "/" + autocomplete_name + "/" + $(ui.item.option).val());
            $.ajax({
              url: "/admin/" + area + "/" + autocomplete_name + "/" + $(ui.item.option).val(),
              dataType: "json",
              type: 'get',
              data: {},
              beforeSend: function () {
                // Before sending empty and disable the targets
                if (typeof clear_targets !== typeof undefined && clear_targets !== false) {
                  clear_targets = clear_targets.split(',');
                  clear_targets.forEach(element => {
                    $parent.find("select[name*='" + element + "']").empty();
                    $parent.find("select[name*='" + element + "']").next().find('input').prop('disabled', true).val('');
                  });
                }
              },
              success: function (response) {
                // Change focus to the child and enable it
                $child.parent().find('.custom-combobox input').prop('disabled', false).focus();
                $child.prop("disabled", false);
                // For each value received append them to the child select
                $.each(response, function (key, value) {
                  $child.append($('<option>', {
                      value: key,
                      text: value,
                  }));
                });
              }
            });

          }

          // Set the selected value from the input to the select
          ui.item.option.selected = true;
          this._trigger("select", event, {
            item: ui.item.option
          });
        },
        // Verify if select was sucessfull
        autocompletechange: "_removeIfInvalid"
      });
    },

    // Create show all button
    _createShowAllButton: function () {
      let input = this.input;
      let wasOpen = false;

      $("<a>")
        .attr("tabIndex", -1)
        .attr("title", "Mostrar todos itens")
        .tooltip()
        .appendTo(this.wrapper)
        .button({
          icons: {
            primary: "ui-icon-triangle-1-s"
          },
          text: false
        })
        .removeClass("ui-corner-all")
        .addClass("custom-combobox-toggle ui-corner-right")
        .on("mousedown", function () {
          wasOpen = input.autocomplete("widget").is(":visible");
        })
        .on("click", function () {
          input.trigger("focus");

          // Close if already visible
          if (wasOpen) {
            return;
          }

          // Pass empty string as value to search for, displaying all results
          input.autocomplete("search", "");
        });
    },

    // Autocomplete source
    _source: function (request, response) {
      // Regex to filter options inside of the <select> container
      var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
      response(this.element.children("option").map(function () {
        var text = $(this).text();
        if (this.value && (!request.term || matcher.test(text)))
          return {
            label: text,
            value: text,
            option: this
          };
      }));
    },

    // Verification of valid selection
    _removeIfInvalid: function (event, ui) {

      // Selected an item, nothing to do
      if (ui.item) {
        return;
      }

      // Search for a match (case-insensitive)
      var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
      this.element.children("option").each(function () {
        if ($(this).text().toLowerCase() === valueLowerCase) {
          this.selected = valid = true;
          return false;
        }
      });

      // Found a match, nothing to do
      if (valid) {
        return;
      }

      // Remove invalid value
      this.input
        .val("")
        .attr("title", value + " Não encontrado")
        .tooltip("open");
      this.element.val("");
      this._delay(function () {
        this.input.tooltip("close").attr("title", "");
      }, 2500);
      this.input.autocomplete("instance").term = "";
    },

    _destroy: function () {
      this.wrapper.remove();
      this.element.show();
    }
  });

  $(".combobox").combobox();
  $("#toggle").on("click", function () {
    $(".combobox").toggle();
  });
});
//------------------------------------//
// END Custom combobox with Jquery-ui //
//------------------------------------//


//------------------------------------//
// Masked input for CPF/CNPJ          //
//------------------------------------//
// $('form').on('keyup', '[name="input_name"]', function(){
//   var masks = ['000.000.000-000', '00.000.000/0000-00'];
//   $(this).mask((this.value.length > 14) ? masks[1] : masks[0]);
// });
//------------------------------------//
// Masked input for CPF/CNPJ          //
//------------------------------------//


/*
* Executa apos o carregamento da página esteja completo
* 08/2018
* Vk2 Studio Web
*/
$(window).on("load", function (e) {



});

/*
* Execução enquanto pag. estiver carregando
* 08/2018
* Vk2 Studio Web
*/
$(document).ready(function() {

    /*
    * Sortable for lista de imagens
    * 06/2023
    * Vk2 Studio Web
    */
    $("#main-list-files").sortable({
        stop: function() {
                var order = {},
                    ordem =  [],
                    pos = 0;

                //configura objeto com valores para atualizar as posições
                $("#main-list-files li").each(function() {

                    var id = $(this).attr("id");
                    // Zera objeto para adicionar novos registros
                    order = {};

                    // Objeto adiciona valor de posição e Dados para update
                    order['order'] = pos;
                    order['id_upload'] = id;

                    // Adiciona objeto ao array
                    ordem.push(order);

                    //Adiciona mais indice para posição
                    pos++;
                });

                //faz o update de posições
                $.ajax({
                    url: url_raiz + "upload/sortable",
                    headers: {
                        'X-CSRF-TOKEN': $("#main-list-files").attr('data-csrf')
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: { ordem,  },
                    cache: false,
                    beforeSend: function () {
                        $("#main-list-files").sortable('disable');
                        //Adicionar efeito visual de atualização
                    },
                    success: function (response) {
                        if(response == true){
                            $("#main-list-files").sortable('enable');
                        }
                    }
            });
       }
    });

	/**
	* Seta o tamanho e posição do body e menu
	* 08/2018
	* Vk2 - Julio
	*/
	setHeightAndWidthAsside();
	setWidthContent();

	/**
	* Abre menu quando clicar
	* Se for dispositivo mobile
	*/
	$('#menu-responsive').click(function () {
		var sidebarStatus = $('#main-sidebar').attr('data-open');
		if (sidebarStatus == 1){
			$('#main-sidebar').attr('data-open', 0).slideUp();
		} else {
			$('#main-sidebar').attr('data-open', 1).slideDown();
		}
	});


	/**
	* Controlador de <select> dinamico em formularios
	* Ao selecionar opção, verifica se existe select filho com valores para ser carregados
	*
	* #var child = elemento select filho que recebe dados
	* #var method = metodo que recolhe dados do filho
	* #var id = id do pai para query
	* #response.value = valor do option
	* #response.text = texto do option
	*/
	$('#main-form').on('change', '.form-select-father', function () {
		var child_name = $(this).attr('select-child');
		var filter = $(this).attr('select-filter');
		var id =$(this).val();

		// Verifica se foi configurado/existe metodo e filho no elemento
		if (typeof child_name !== typeof undefined && child_name !== false && child_name != "" && typeof filter !== typeof undefined && filter !== false && filter != "" ) {

			$.ajax({
				url: url_site + "get-select-data/" + filter + "/" + id,
				type: 'GET',
				dataType: 'json',
				data: { },
				cache: false,
				beforeSend: function () {
					// Desativa select filho e exibe mensagem de carregamento
					child = $("select[name='" + child_name + "']");
					child.attr("disabled", "disabled");
					child.empty();
					child.append($('<option>', { value: "", text: "carregando..." }));
				},
				success: function (response) {
					// Reativa select filho
					$("select[name='" + child_name + "']").empty();
					$("select[name='" + child_name + "']").prop("disabled", false);

                    //adicione o texto de selecione no select
                    $("select[name='" + child_name + "']").append($('<option>', {
                        value: '',
                        text: 'Selecione',
                    }));

					// Loop que insere as opções recebidas
					$(response).each(function(){
						$("select[name='" + child_name + "']").append($('<option>', {
							value: this.value,
							text: this.text,
						}));
					});
				}
			});
		}
	});

	/**
	* Controlador de <select> dinamico em formularios
	* Ao selecionar opção, verifica se existe select filho com valores para ser carregados
	*
	* #var child = elemento select filho que recebe dados
	* #var method = metodo que recolhe dados do filho
	* #var id = id do pai para query
	* #response.value = valor do option
	* #response.text = texto do option
	*/
	$('#main-form').on('change', '.formSelectOther', function () {

		var child_name = $(this).attr('select-child'),
			getSelects = child_name.split(",");
			id =$(this).val();

		$.each(getSelects, function( index, value ) {
			// Verifica se foi configurado/existe metodo e filho no elemento
			if (typeof value !== typeof undefined && value !== false && value != "")
			{
				var thisMethod = value,
					thisSelect = 'id_' + value;

				$.ajax({
					url: url_site + "get-select-data/" + thisMethod +  "/" + id,
					type: 'GET',
					dataType: 'json',
					data: { },
					cache: false,
					beforeSend: function () {
						// Desativa select filho e exibe mensagem de carregamento
						child = $("select[name='" + thisSelect + "']");
						child.attr("disabled", "disabled");
						child.empty();
						child.append($('<option>', { value: "", text: "carregando..." }));
					},
					success: function (response) {
						// Reativa select filho
						$("select[name='" + thisSelect + "']").empty();
						$("select[name='" + thisSelect + "']").prop("disabled", false);
	
						//adicione o texto de selecione no select
						$("select[name='" + thisSelect + "']").append($('<option>', {
							value: '',
							text: 'Selecione',
						}));
	
						// Loop que insere as opções recebidas
						$(response).each(function(){
							$("select[name='" + thisSelect + "']").append($('<option>', {
								value: this.value,
								text: this.text,
							}));
						});
					}
				});
			}
		});
		
	});


	/**
	* Inicia função que seta o tamanho dos campos de listagem
	* 16/2018
	* Vk2 - Julio
	*/
	setSizeListCollumns();

	tinymce.init({
		selector: '.textarea-control',
		entity_encoding: 'raw',
		setup: function (editor) {
			editor.on('change', function () {
				editor.save();
			});
		},
		min_height: 100,
		max_height: 300,
		menubar: false,
		plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount autoresize',
		toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image code',
		resize: false,
		language : 'pt_BR'
	});
	tinymce.init({
		selector: '.editor-input',
		entity_encoding: 'raw',
		min_height: 100,
		max_height: 1200,
        resize: false,
		image_class_list: [
			{title: 'Imagem Pequena', value: 'smallImg'},
			{title: 'Imagem Média', value: 'mediumImg'},
			{title: 'Imagem Grande', value: 'bigImg'}
		  ],
		image_caption: true,
		relative_urls : false,
		content_css: urlCssAdmin,
  		importcss_append: true,
		setup: function (editor) {

			editor.on('change', function (e) {
				editor.save();
			});

            editor.on('NodeChange', function (e) {
                if (e.element.tagName === "FIGURE") {
                    if(e.element.childNodes.length >= 1){
                        if(e.element.childNodes[0].classList.length >= 1){
                            e.element.classList.remove('main-smallImg', 'main-mediumImg', 'main-bigImg');
                            e.element.classList.add('main-' + e.element.childNodes[0].className);

                            e.element.style.removeProperty('height');
                            e.element.style.removeProperty('width');

                        }
                    }
                }
            });

		},
		paste_postprocess: (plugin, args) => {

			let node = args.node;

			// We try to find an img element
			let img = node.querySelector('img')

			if (img) {

				node.removeChild(img)

				let figure = document.createElement('figure')

				figure.className += ' ' + 'image main-bigImg'
				figure.style.height = 600 + 'px'
				figure.style.width = 900 + 'px'
				figure.style.overflow = 'hidden'
				figure.contentEditable = 'false'

                figure.appendChild(img)
				node.appendChild(figure)
			}
		},
		menubar: true,
		plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount autoresize',
		toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image code',
		language : 'pt_BR'
	});


	$('table.logTable').DataTable({
		reponsive: true,
		paging: false,
		autoWidth: true,
		language: {
			url: dataTableLang
		},
		order: [[2, 'desc']],
		initComplete: function() {
			var api = this.api();
			$('#user', this.api().table().header()).each(function(i) {
				var column = api.column($(this));
				console.log(column)
				var select = $(
						'<select class="form-control form-control-sm"><option value=""></option></select>'
					)
					.appendTo($(this).empty())
					.on('change', function() {
						var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
						);

						column
							.search(val ? '^' + val + '$' : '', true, false)
							.draw();
					});

				column.data().unique().sort().each(function(d, j) {
					select.append('<option value="' + d + '">' + d +
						'</option>');
				});
			});
		},
		"stateSaveCallback": function(settings, data) {
			window.localStorage.setItem("datatable", JSON.stringify(data));
		},
		"stateLoadCallback": function(settings) {
			var data = JSON.parse(window.localStorage.getItem("datatable"));
			if (data) data.start = 0;
			return data;
		}
	});

	/**
	* Menu lateral efeitos e mudanças de click
	**/
	$('.main-name-group').click(function () {

		if( $(this).attr('data-slide') == 'open')
		{
			$(this).next('.treeview-menu').slideUp().removeClass('treeview-show');
			$(this).attr('data-slide', 'close');
			$(this).find('.icon-open-sidebar-menu').addClass('ui-admin-left-angle-arrow').removeClass('ui-admin-down-arrow-angle');

		} else {
			$(this).next('.treeview-menu').slideDown().addClass('treeview-show');
			$(this).attr('data-slide', 'open');
			$(this).find('.icon-open-sidebar-menu').addClass('ui-admin-down-arrow-angle').removeClass('ui-admin-left-angle-arrow');
		}

	});

	/**
	* Abre e fecha menu lateral
	* 08/2018
	* Vk2 - Julio
	*/
	$('.icon-collect-menu').click(function () {
		var checkStatus = $('#main-sidebar').attr('data-open'); //Checa status atual do menu 0=fechado 1=aberto
		if(checkStatus == 1){
			$('#main-sidebar').addClass('main-sidebar-little').attr('data-open', '0'); //Seta clase do min-menu e muda status para fechado

			setWidthContent(); //chama funçao que define o tamanho do content
		} else {
			$('#main-sidebar').removeClass('main-sidebar-little').attr('data-open', '1'); //Remove clase do min-menu e muda status para aberto

			setWidthContent(); //chama funçao que define o tamanho do content
		}
	});


	// /**
	// * Botão Marcar todos da listagem
	// * 08/2018
	// * Vk2 - Julio
	// */
	// $('#button-select span').click(function () {
	//     if($(this).attr('data-allselect') == 'false') {
	//         $(this).attr('data-allselect', 'true')
	//         $('#button-select').addClass('all-select-dates');
	//     } else {
	//         $(this).attr('data-allselect', 'false')
	//         $('#button-select').removeClass('all-select-dates');
	//     }
	// });

	/**
	* Botão Mudar Status
	* 11/2018
	* Vk2 - Julio
	*/
	$('.button-status').click(function () {
		var idRegister = $(this).attr('data-id'),
		status = $(this).attr('data-status'),
		URL = url_site + 'updatestatus/' + idRegister + '/' + status;

		$.ajax({
			url: URL,
			type: 'GET',
			dataType: 'json',
			data: { },
			cache: false,
			async: false,
			beforeSend: function () {
				$('#button-status-'+idRegister).addClass('button-status-load').addClass('ui-admin-arrows-circle-of-two-rotating-in-clockwise-direction').html('&nbsp;');
			},
			complete: function () {

			},
			success: function (response) {
				if(response.success == "true")
				{
					$('#button-status-'+idRegister).removeClass('button-status-load').removeClass('ui-admin-arrows-circle-of-two-rotating-in-clockwise-direction');
					if(response.status == 1)
					{
						$('#button-status-'+idRegister).addClass('button-status-active').removeClass('button-status-inactive').attr('data-status', response.status).html('Ativo');
					}

					if(response.status == 0)
					{
						$('#button-status-'+idRegister).addClass('button-status-inactive').removeClass('button-status-active').attr('data-status', response.status).html('Inativo');
					}
				}
				if(response.success == 'false')
				{
					$('#button-status-'+idRegister).removeClass('button-status-load').removeClass('ui-admin-arrows-circle-of-two-rotating-in-clockwise-direction');
				}
			}
		});

	});

	/**
	* Verificar Status Pagamento Manual Julio
	* 02/2026
	* Vk2 - Julio
	*/
	$('.button-payment').click(function () {
		var idRegister = $(this).attr('data-id'),
		status = $(this).attr('data-payment'),
		idPayment = $(this).attr('data-paymentId'),
		URL = url_site + 'consultarPagamento/' + idRegister + '/' + status + '/' + idPayment;
		
		if(status == 'SENDING'){
			$.ajax({
				url: URL,
				type: 'GET',
				dataType: 'json',
				data: { },
				cache: false,
				async: false,
				beforeSend: function () {
					$('#button-payment-'+idRegister).addClass('button-status-load').addClass('ui-admin-arrows-circle-of-two-rotating-in-clockwise-direction').html('&nbsp;');
				},
				complete: function () {	},
				success: function (response) {
					if(response.success == "true")
					{
						$('#button-payment-'+idRegister).removeClass('button-status-load').removeClass('ui-admin-arrows-circle-of-two-rotating-in-clockwise-direction');
						if(response.status == 'CONFIRMED')
						{
							$('#button-payment-'+idRegister).addClass('button-payment-Recebido').removeClass('button-payment-Enviado').attr('data-status', response.status).html('Recebido');
						}

						if(response.status == 'ATIVA')
						{
							$('#button-status-'+idRegister).html('Enviado');
						} else {
							$('#button-payment-'+idRegister).addClass('button-payment-Erro').removeClass('button-payment-Enviado').attr('data-status', response.status).html('Erro');
						}
					}
					if(response.success == 'false')
					{
						$('#button-payment-'+idRegister).addClass('button-payment-Erro').removeClass('button-payment-Enviado').attr('data-status', response.status).html('Erro');
					}
				}
			});
		}
	});

	/**
	* Radio Button
	* 12/2018
	* Vk2 - Julio
	*/
	$('.label-radio').click(function(){
		var numberRadio = $(this).attr('data-radio'),
		groupRadio = $(this).attr('name');
		$(this).parent().parent().find('.label-radio').addClass('ui-admin-circle').removeClass('ui-admin-rec-circular-button');
		$(this).parent().parent().find('.form-control-radio').attr('checked',false);
		$(this).addClass('ui-admin-rec-circular-button');
		$('#radio'+numberRadio).attr('checked', true);
	});

	timeout_inner = null;
	$(".item-list-date").on("mouseover", function(){
		var $this = $(this).find("a");
		var interval_val = 1;
		timeout_outer = setTimeout(function() {
			timeout_inner = setInterval(function(){
				$($this).scrollLeft(interval_val);
				interval_val += 1;
			}, 25);

		}, 1000);

	});

	$(".item-list-date").on("mouseout", function(){
		clearTimeout(timeout_outer);
		clearInterval(timeout_inner);
		timeout_inner = null;

		$(this).find("a").scrollLeft(0);
	});

	/** Sessão upload */

	$('#main-list-files li').on('mouseleave', function(){
		$("#main-list-files li").attr('data-select', false).find('.menu-image').hide();
	});

	$("#main-list-files li").contextmenu(function(e) {

		$("#main-list-files li").attr('data-select', false).find('.menu-image').hide();

		var left = e.pageX -50,
		top = e.pageY - 220;

		$(this).attr('data-select', true).find('.menu-image').show();
		$(this).find('.menu-image').show().css({top: top, left: left});
		return false;
	});

	//Opem image in new tab
	$('.new-image').click(function(){
		var link = $(this).parent().attr('data-link');
		window.open(link, '_blank');
	});
	//Gera copy link
	$('.link-image').click(function(){
		var link = $(this).parent().attr('data-link'),
		$temp = $("<input>");
		$("body").append($temp);
		$temp.val(link).select();
		document.execCommand("copy");
		$temp.remove();
		document.execCommand("copy");

		$(this).html('Link Copiado').css({ background: '#62ee8d', color: '#292929' });
		setTimeout(function(){
			$('.link-image').html('Gerar Link').removeAttr('style');
		}, 1300);
	});

	//Deleta imagem
	$('.delete-image').click(function(){
		var id = $(this).parent().attr('data-id'),
		urlDelete = url_raiz + 'upload/delete/' + id,
		$dirFather = $(this).parent().parent();
		
		$.ajax({
			url: urlDelete,
			type: 'GET',
			dataType: 'json',
			cache: false,
			beforeSend: function () {
				// Desativa botão
				$(this).attr('data-active', false);
				var top = $dirFather.position().top - 40;
				var left = $dirFather.position().left + 10;
				var divMessage = "<div class='main-message-delete'><span class='message-delete'>Estamos deletando esse arquivo!</span></div>";
				$dirFather.append(divMessage).find('.main-message-delete').css({top: top, left: left});

			},
			success: function (response) {
				// console.log('here');
				if(response.status == "true")
				{
					// console.log('here true');
					$dirFather.find('.main-message-delete').addClass('message-delete-success').find('.message-delete').html(response.message);

					setTimeout(function(){
						$dirFather.find('.main-message-delete').hide();
						$dirFather.fadeOut();
					}, 1200);

				} else{
					// console.log('here false');
					$dirFather.find('.main-message-delete').addClass('message-delete-error').find('.message-delete').html(response.message);
				}
			}
		});
	});

	$(".icon-alert").on("click", function () {
    if (
      $(".notificationMenu").length &&
      $(".notificationList .notification").length
    ) {
      if (!$(".notificationMenu").is(":visible")) {
        $(".notificationMenu").show();
      } else {
        $(".notificationMenu").hide();
      }
    }
  });

  $(".notificationClose").on("click", function () {
    notificationId = $(this).data("notification");
    postUrl = url_raiz + "notifications/delete/";
    notification = $(this).parent();
    $.ajax({
      url: postUrl,
      type: "POST",
      dataType: "JSON",
      data: {
        id: notificationId,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (json) {
        result = json;
        if (result.status == "success") {
          if (result.notificationCount > 0) {
			if(result.notificationCount > 9){
				$(".notificationBubble").text('9+');
			} else {	
				$(".notificationBubble").text(result.notificationCount);
			}
            notification.remove();
          } else {
			notification.remove();
            $(".notificationBubble").text("").css({ display: "none" });
            $(".notificationMenu").hide();
          }
        }
      },
    });
  });

  $("#notificationReadAll").on("click", function () {
    postUrl = url_raiz + "notifications/delete/";
    $.ajax({
      url: postUrl,
      type: "POST",
      dataType: "JSON",
      data: {
        readAll: true,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (json) {
        result = json;
        if (result.status == "success") {
          $(".notificationList .notification").each(function () {
            $(this).fadeOut("fast", function () {
              $(this).remove();
            });
          });

          $(".notificationBubble").text("").css({ display: "none" });
          $(".notificationMenu").hide();
        }
      },
    });
  });

  $("#notificationCloseOption").on("click", function () {
    $(".icon-alert").trigger("click");
  });

});

/*
* Execução enquanto pag. estiver em resize
* 08/2018
* Vk2 Studio Web
*/
$(window).resize(function(){

	/**
	* Seta o tamanho e posição do body e menu
	* 08/2018
	* Vk2 - Julio
	*/
	setHeightAndWidthAsside();
	setWidthContent();

	/**
	* Inicia função que seta o tamanho dos campos de listagem
	* 16/2018
	* Vk2 - Julio
	*/
	setSizeListCollumns();
});
