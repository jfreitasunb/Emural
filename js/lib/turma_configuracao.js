$(function(){
	$('#pesos').hide();
	$('#formula').hide();
	$("#tipo").watermark("Outra Avaliação");

	adicionarQuantidadeAvaliacao("Prova","div_quantidade");

	$('#add_tipo_avaliacao').click(function() {
		if($('#tipo').val().length > 0) {
			$.post(ROOT+"ajax/inserir_tipo_avaliacao.php", {insertString: ""+$('#tipo').val()+""}, function(data){
				if(data.length >0) {
					$('#tipo').val(data);
				}
				adicionarQuantidadeAvaliacao($('#tipo').val(),"div_quantidade");
				$('#tipo').val("");
				$('#tipo').focus();
			});
			sugestionsHide();
		} else {
			generate('alert', 'Escolha o nome do tipo de avaliação antes de adicionar.', '');
		}
	});

	$('#tipo').focus(function() {
		this.select();
	});

	$('#tipo').keydown(function(e) {
		var RETURN = 13;
		var TAB = 9;
		var ESC = 27;

		switch(e.keyCode)
		{
			case RETURN:
				if($('.selected').length == 1) {
					$('#tipo').val($('.selected').text());
				}
				$('#add_tipo_avaliacao').click();
				break;

			case ESC:
				sugestionsHide();
				break;
		}
	});

	$('#tipo').keyup(function(e) {
		var ARRUP = 38;
		var ARRDN = 40;
		
		var bubble = 1;

		switch(e.keyCode)
		{
			case ARRUP:
				changeSelected(e.keyCode);
				bubble = 0;
				break;

			case ARRDN:
				changeSelected(e.keyCode);
				bubble = 0;
				break;

			default:
				suggestions(this.value);
		}
	});

	$('#tipo').blur(function() {
		sugestionsHide();
	});

	$('input[name="tipo_media"]').change(function() {
		mudouTipo();
	});

	function mudouTipo()
	{
		input = $('input[name="tipo_media"]:checked');
		switch(input.val())
		{
			case "simples":
				$('[name=formula]').val('');
				$('.lbl_selecionar').hide();
				$('#formula').hide();
				$('#pesos').hide();
				$('.peso_class').remove();
				$('.descricao_simples').show();
				$('.descricao_ponderada').hide();
				break;

			case "ponderada":
				$('[name=formula]').val('');
				$('.lbl_selecionar').show();
				$('#formula').hide();
				$('#pesos').show();
				$('.descricao_simples').hide();
				$('.descricao_ponderada').show();
				break;

			case "personalizada":
				$('[name=formula]').val('');
				$('.lbl_selecionar').hide();
				$('#formula').show();
				$('#pesos').hide();
				$('.peso_class').remove();
				break;

		}
		//alert(input.val());
	}

	function adicionarQuantidadeAvaliacao(tipo, div) {
		if($('#'+tipo).length == 0) {
			$("#form_calculo_simples").validationEngine('attach');
			$('<div id="'+tipo+'" class="quantidade"><div class="lbl_titulo">'+tipo+':</div>'+
			  '<div class="lbl_quantidade"><input type="text" class="validate[required,custom[integer],min[1]] field_quantidade" name="quantidade_'+tipo+'" onkeydown="return event.keyCode!=13"/></div>'+
			  '<div class="lbl_selecionar"><button id="bt_selecionar_'+tipo+'" class="bt_selecionar" type="button">Ok</button></div>'+
			  '<div class="lbl_deletar"><button id="bt_deletar_'+tipo+'" class="bt_deletar" type="button">X</button></div></div>').fadeIn('slow').appendTo('#'+div);
			$("#form_calculo_simples").validationEngine('attach');

			//$('input[name="tipo_media"]').change();

			$('#bt_selecionar_'+tipo).click(function() {
				var tipo = $(this).parent().parent().attr('id');
				var quantidade_atual = $('.peso_'+tipo+'_class').length;
				var quantidade = $('input[name="quantidade_'+tipo+'"]').val();

				if(quantidade.length > 0 && quantidade > 0) {
					if(quantidade_atual == 0) {
						$('<div id="peso_'+tipo+'" class="peso_class"></div>').fadeIn().appendTo('#fs_pesos');
					}

					if(quantidade > quantidade_atual) {
						for (var i = (quantidade_atual + 1); i <= quantidade; i++)
						{
							$("#form_calculo_simples").validationEngine('attach');
							$('<div id="'+tipo+'_'+i+'" class="peso_'+tipo+'_class peso_class_filho"><div>'+tipo+' '+i+':</div><div><input type="text" class="validate[required,custom[integer],min[1]] field" name="peso_'+tipo+'_'+i+'"/></div></div>').fadeIn('slow').appendTo('#peso_'+tipo);
							$("#form_calculo_simples").validationEngine('attach');
						}
					} else if (quantidade < quantidade_atual) {
						for (var i = 0; i < (quantidade_atual - quantidade); i++)
						{
							$('.peso_'+tipo+'_class:last').remove();
						}
						//window.alert("tem que deletar "+(quantidade_atual - quantidade));
					}
				} else {
					$('#peso_'+tipo).remove();
				}
			});

			$('#bt_deletar_'+tipo).click(function() {
				var tipo = $(this).parent().parent().attr('id');

				$('#'+tipo).remove();
				$('#peso_'+tipo).remove();
			});
			mudouTipo();
		} else {
			generate('warning', "Em quantidade já existe "+tipo+".", '');
		}
	}

	function changeSelected(key) {
		var ARRUP = 38;
		var ARRDN = 40;

		var tamanho = $('.suggest_item').length;

		if( tamanho> 0) {
			var fieldChild  = $('.suggest_box');
			if($('.selected').length == 1) {
				var sel = fieldChild.find(".selected");
				(key==ARRDN) ? sel.next().addClass("selected") : sel.prev().addClass("selected");
				sel.removeClass("selected");
			} else {
				$('.selected').removeClass("selected");
				//alert("Nao tem selecionado");
				(key==ARRDN) ? fieldChild.find("li:first").addClass("selected") : fieldChild.find("li:last").addClass("selected");
			}
		}
	}

	var busca = "";

	function suggestions(value) {
		//window.alert(busca+' - '+value);
		if(value != busca) {
			busca = value;
			if(value.length == 0) {
				$('#suggestions').fadeOut();
			} else {
				$('#tipo').addClass('load');
				$.post(ROOT+"ajax/suggest_tipo_avaliacao.php", {queryString: ""+value+""}, function(data){
					if(data.length > 0) {
						//window.alert(data);
						$('#suggestionsList').html(data);
	
						$('.suggest_item').click(function() {
							var index = $(".suggest_item").index(this);
							$('#tipo').val($(this).text());
							$('#add_tipo_avaliacao').click();
						});
	
						$('.suggest_item').mouseover(function() {
							$('.selected').removeClass("selected");
							$(this).addClass("selected");
						});
	
						$('.suggest_item').mouseout(function() {
							$(this).removeClass("selected");
						});
						if($('.suggest_item').length == 1 && $('.suggest_item').text() == $('#tipo').val()) {
							$('#suggestions').fadeOut();
						} else {
							$('#suggestions').fadeIn();
						}
					} else {
						$('#suggestions').fadeOut();
					}
					$('#tipo').removeClass('load');
				});
				//if($('.suggest_item').length == 1 && $('.suggest_item').text() == $('#tipo').value) {
			}
		}
	}

	/*$("#form_calculo_simples").bind("jqv.form.result", function(event , errorFound){
		if(errorFound) 
			generate('error', "erro", '');
		else
			generate('warning', "foi", '');
	})*/


	$('#bt_enviar').click(function(e) {
		confirmarReconfiguracao("#form_calculo_simples");
	});


	$('#bt_enviar_2').click(function(e) {
		confirmarReconfiguracao("#form_configuracao_rapida");
	});


	function confirmarReconfiguracao(form_id)
	{
		if(existe_compisicao_nota) {
			var n = noty({
				text: 'A turma já foi configurada anteriormente. Se ela for reconfigurada perderá as informações da configuração anterior como calculo de notas e notas lançadas.<br><br>Deseja reconfigurar?',
				type: 'alert',
				dismissQueue: true,
				layout: 'topCenter',
				theme: 'default',
				buttons: [
					{addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
							$noty.close();
							$(form_id).submit();
						}
					},
					{addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
							$noty.close();
						}
					}
				]
			});
		} else {
			$(form_id).submit();
		}
	}

	function sugestionsHide() {
		setTimeout("$('#suggestions').fadeOut();", 100);
	}

	$('#btn_configuracao_rapida').click(function(e) {
		$("#configuracao_rapida").lightbox_me({centered: true, onLoad: function() {
		}});
	});


	$('#avaliacoes_anteriores').change(function(e) {
		var $this = $(this);

	    if ($this.is(':checked')) {
	    	$('#avaliacoes_anteriores_2').val("v");
	    } else {
	    	$('#avaliacoes_anteriores_2').val("");
	    }
	});


	$("#form_configuracao_rapida").validationEngine();
	$("#form_calculo_simples").validationEngine();

	$("#data_prova_1").mask("99/99/9999");
	$("#data_prova_2").mask("99/99/9999");
	$("#data_prova_3").mask("99/99/9999");


	$("#data_prova_1").datepicker({onSelect: function (dateText, inst){this.focus(); this.blur(); this.focus();}});
	$("#data_prova_2").datepicker({onSelect: function (dateText, inst){this.focus(); this.blur(); this.focus();}});
	$("#data_prova_3").datepicker({onSelect: function (dateText, inst){this.focus(); this.blur(); this.focus();}});
});