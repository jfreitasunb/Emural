$(function(){
	$("#combo_ano_semestre").change(function(){
		recuperaListaTurmas();
	});

	$("#combo_disciplina").change(function(){
		recuperaListaTurmas();
	});

	function recuperaListaTurmas() {
		var semestre = $("#combo_ano_semestre").val();
		var disciplina = $("#combo_disciplina").val();
		
		if(semestre > 0 && disciplina > 0) {
			$.post(ROOT+"ajax/turmas_semestre.php", {codigoSemestre: ""+semestre+"", codigoDisciplina: ""+disciplina+""}, function(data){
				if(data.length > 0) {
					$('#combo_turma').html(data);
				} else {
					$('#combo_turma').html("");
				}
			});
		} else {
			$('#combo_turma').html("");
		}
	}
});