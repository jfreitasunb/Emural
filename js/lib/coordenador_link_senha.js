$(function(){
	jQuery("#form_coordenador_link_senha").validationEngine();


	$('#busca').keydown(function(e) {
		var RETURN = 13;
		var TAB = 9;
		var ESC = 27;

		switch(e.keyCode)
		{
			case RETURN:
				verificarMatricula(this.value);
				break;
		}
	});


	$('#busca').focusout(function() {
		verificarMatricula(this.value);
	});


	var busca = "";
	var aluno = null;

	function verificarMatricula(value) {
		if (aluno === null || (aluno !== null && (aluno.email === value || aluno.matricula === value))) {
			if(value.length == 0) {
				esconder();
			} else {
				$('#tipo').addClass('load');
				$.post(ROOT+"ajax/busca_aluno.php", {busca: ""+value+""}, function(data){
					if(data.length > 0 && data != "null") {
						//window.alert(data);
						aluno = JSON.parse(data);
						$('#nome_aluno').html(aluno.nome);
						$('#matricula_aluno').html(aluno.matricula);

						$('#codigo').val(aluno.codigo);
						$('#email').val(aluno.email);
						mostrar();
					} else {
						esconder();
					}
				});
			}
		}
		
		
		
		
		/*if(value != busca) {
			busca = value;
			if(value.length == 0) {
				esconder();
			} else {
				$('#tipo').addClass('load');
				$.post(ROOT+"ajax/busca_aluno.php", {busca: ""+value+""}, function(data){
					if(data.length > 0 && data != "null") {
						window.alert(data);
						//$('#nome_aluno').html(data);

						mostrar();
					} else {
						esconder();
					}
				});
			}
		}*/
	}


	function mostrar()
	{
		$('.invisivel').addClass('visivel').removeClass('invisivel');
	}


	function esconder()
	{
		$('.visivel').addClass('invisivel').removeClass('visivel');
		$('.senha_valor').val('');
	}
});