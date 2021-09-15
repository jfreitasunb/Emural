$(function(){
	jQuery("#form_media_mencoes").validationEngine();

	$('.media').change(function() {
		var codigo = this.name.substr(6);
		var valor = this.value.replace(",",".");
		this.value = this.value.replace(",",".");
		
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

		var porcentagem = Math.round((valor/(creditos*15))*10000*2)/100;

		$("#porcentagem_faltas_"+codigo).html(porcentagem+'%');
	});

	$('.atualizar_mencao').click(function() {
		var aluno = $(this).attr('id');

		var location = window.location.pathname.split("/");

		var turma = location[location.length - 1];

		$.post(ROOT+"ajax/recalcular_media.php", {aluno_id: ""+aluno+"", turma_id: ""+turma+""}, function(data){
			if(data.length >0) {
				$("#media_"+aluno).val(data);
				$("#media_"+aluno).change();
				generate('alert', 'Média e Menção recalculadas, porém ainda não salvas.', '');
			} else {
				generate('error', "Erro ao recalcular média.", '');
			}
		});
	});

	$('.checkbox_colunas').change(function() {
		fnShowHide(this.id, this.checked);
	});

	$(".checkbox_colunas").each(function (i) {
		fnShowHide(this.id, this.checked);
	});

	function fnShowHide(col, visible)
	{
		/* Get the DataTables object again - this is not a recreation, just a get of the object */
		var oTable = $('#tabela_dados').dataTable();

		oTable.fnSetColumnVis( col, visible);
		oTable.css('width', "100%");
		oTable.fnAdjustColumnSizing();
	}
});