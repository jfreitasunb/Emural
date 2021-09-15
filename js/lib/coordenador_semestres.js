var disciplinas = {};
var animationDuration = 200;

$(function(){
	$("#inicio").mask("99/99/9999");
	$("#fim").mask("99/99/9999");


	$("#inicio").datepicker();
	$("#fim").datepicker();


	jQuery("#form_coordenador_semestre").validationEngine();
});

$('#ano').change(function() {
	mudouAno();
});

$('#semestre').change(function() {
	mudouSemestre();
});

$('#adicionar').click(function() {
	d1 = {};
	d1.value = $('#disciplina1').val();
	
	if (d1.value.length > 0) {
		d1.text = $('#disciplina1 option:selected').text();
		
		d2 = {};
		d2.value = $('#disciplina2').val();
		if (d2.value > 0) {
			d2.text = $('#disciplina2 option:selected').text();

			if (disciplinas[d1.value] === null || typeof disciplinas[d1.value] !== 'object'){
				disciplinas[d1.value] = {};
			}

			if (disciplinas[d2.value] === null || typeof disciplinas[d2.value] !== 'object'){
				disciplinas[d2.value] = {};
			}

			if (!disciplinas[d1.value][d2.value]) {
				disciplinas[d1.value][d2.value] = true;
				disciplinas[d2.value][d1.value] = true;

				adicionarHTML(d1, d2);
				removerHTML(d1);
				removerHTML(d2);
			}
		} else {
			if (typeof disciplinas[d1.value] === "undefined") {
				disciplinas[d1.value] = true;
				adicionarHTML(d1);
			}
		}
	}
	$('#disciplina1').val("");
	$('#disciplina2').val("");

	//imprimirDisciplinas();
});

function mudouAno() {
	$('#semestre').val("");
	mudouSemestre();
}

function mudouSemestre() {
	$("#inicio").val("");
	$("#fim").val("");

	mostrarConfiguracaoTurmasMoodle()
}

function mostrarConfiguracaoTurmasMoodle() {
	e_semestre = parseInt($('#semestre').val());
	e_ano = parseInt($('#ano').val());
	
	if (e_ano > ano) {
		$('#div_grupos').show(animationDuration);
	} else if (e_ano == ano && e_semestre > semestre) {
		$('#div_grupos').show(animationDuration);
	} else {
		$('#div_grupos').hide(animationDuration);
	}
}

function adicionarHTML(d1, d2) {
	if (d2) {
		$('<div class="'+d1.value+'-'+d2.value+' '+d2.value+'-'+d1.value+' grupo">'+
		  '<label>'+d1.text+' -> '+d2.text+'</label>'+
		  '<input type="hidden" name="dis_junt_'+d1.value+'-'+d2.value+'" value="'+d1.value+'-'+d2.value+'">'+
		  '<button type="button" class="remover">Remover</button>'+
		  '</div>').fadeIn('slow').appendTo('#agrupamento');
		
		$('.'+d1.value+'-'+d2.value).delegate(".remover", "click", function() {
			if(count(disciplinas[d1.value]) == 1) {
				delete disciplinas[d1.value];
			} else {
				delete disciplinas[d1.value][d2.value];
			}

			if(count(disciplinas[d2.value]) == 1) {
				delete disciplinas[d2.value];
			} else {
				delete disciplinas[d2.value][d1.value];
			}

			removerHTML(d1, d2);
			
			//imprimirDisciplinas();
	    });
	} else {
		$('<div class="'+d1.value+' grupo">'+
		  '<label>'+d1.text+'</label>'+
		  '<input type="hidden" name="dis_so_'+d1.value+'" value="'+d1.value+'">'+
		  '<button class="remover" type="button">Remover</button>'+
		  '</div>').fadeIn('slow').appendTo('#agrupamento');
		
		$('.'+d1.value).delegate(".remover", "click", function() {
			delete disciplinas[d1.value];
			removerHTML(d1);
			
			//imprimirDisciplinas();
	    });
	}
}

function removerHTML(d1, d2) {
	if (d2) {
		$("."+d1.value+'-'+d2.value).remove();
	} else {
		$("."+d1.value).remove();
	}
}

function imprimirDisciplinas() {
	console.log("");
	for(var i in disciplinas) {
		if (typeof disciplinas[i] === 'object') {
			for(var j in disciplinas[i]) {
				console.log("["+i+"]["+j+"]");
			}
		} else {
			console.log("["+i+"]");
		}
	}
}

function count(array) {
	var count = 0;
	for(var i in array) {
		count += 1;
	}
	
	return count;
}