$(function(){
	jQuery("#form_coordenador_aluno_senha").validationEngine();


	$('#matricula').keydown(function(e) {
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


	$('#matricula').focusout(function() {
		verificarMatricula(this.value);
	});


	var busca = "";

	function verificarMatricula(value) {
		if(value != busca) {
			busca = value;
			if(value.length == 0) {
				esconder();
			} else {
				$('#tipo').addClass('load');
				$.post(ROOT+"ajax/verificar_matricula.php", {matricula: ""+value+""}, function(data){
					if(data.length > 0) {
						//window.alert(data);
						$('#nome_aluno').html(data);

						mostrar();
					} else {
						esconder();
					}
				});
			}
		}
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