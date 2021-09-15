$(function(){
	jQuery("#form_revisao_mencoes").validationEngine();

	$("#ano_semestre").change(function(){
		$.post(ROOT+"ajax/turmas_semestre.php", {codigoSemestre: ""+this.value+""}, function(data){
			if(data.length > 0) {
				$('#turmas').html(data);
			}
		});
	});

	$("#bt_selecionar_turma").click(function(){
		var codigo_turma = $('#turmas').val();

		if(codigo_turma.length > 0 && codigo_turma > 0) {
			window.location.replace(url_revisao_mencao+"/"+codigo_turma);
		}
	});

	$('.media').change(function() {
		var codigo = this.name.substr(6);
		var valor = this.value.replace(",",".");

		if(valor == 0) {
			$("#mencao_"+codigo).val('SR');
		} else if(valor > 0 && valor < 3) {
			$("#mencao_"+codigo).val('II');
		} else if(valor >= 3 && valor < 5) {
			$("#mencao_"+codigo).val('MI');
		} else if(valor >= 5 && valor < 7) {
			$("#mencao_"+codigo).val('MM');
		} else if(valor >= 7 && valor < 9) {
			$("#mencao_"+codigo).val('MS');
		} else if(valor >= 9 && valor <= 10) {
			$("#mencao_"+codigo).val('SS');
		}
	});

	$('.faltas').change(function() {
		var codigo = this.name.substr(7);
		var valor = this.value;

		var porcentagem = Math.round((valor/(creditos*15))*10000)/100;

		$("#porcentagem_faltas_"+codigo).html(porcentagem+'%');;
	});
});