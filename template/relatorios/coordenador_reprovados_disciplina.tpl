<div id="corpo">
<div id="left">
	<form method="post" id="form_relatorio">
		<div>
			<label>Disciplina</label>
			<select name="disciplina" id="combo_disciplina" class="validate[required]">
				<option value=""></option>
				<!-- BEGIN adicionar_combo_disciplina -->
					<option value="{combo_disciplina_codigo}" {combo_disciplina_selected}>{combo_disciplina_descricao}</option>
				<!-- END adicionar_combo_disciplina -->
			</select>
		</div>
		<div class="div_action">
			<input type="submit" value="Selecionar">
		</div>
	</form>
</div>
<div id="center">
	<h1 id="titulo">Quantidade Possiveis Reprovados</h1>
	<!-- BEGIN existe_relatorio_1 --><h2>Disciplina - {relatorio_disciplina_descricao}</h2><!-- END existe_relatorio_1 -->
	<!-- BEGIN existe_relatorio_2 -->
	<div class="ultima_div">
		{relatorio}
		<!-- BEGIN nao_existe_relatorio_2 --><h3>{sem_dados}</h3><!-- END nao_existe_relatorio_2 -->
		
		<!-- <div class="div_action">
			<form action="{link_relatorio_coordenador_lista_alunos_csv}" method="post" target="_blank">
				<input type="hidden" name="ano_semestre" value="{relatorio_ano_semestre_codigo}">
				<input type="hidden" name="disciplina" value="{relatorio_disciplina_codigo}">
				<!-- BEGIN existe_turma -- ><input type="hidden" name="turma" value="{relatorio_turma_codigo}"><!-- END existe_turma - ->
				<!-- BEGIN existe_relatorio_aprovados -- ><input type="hidden" name="aprovados" value="{relatorio_aprovados}"><!-- END existe_relatorio_aprovados - ->
				<input type="submit" value="Gerar CSV" />
			</form>
		</div> -->
	</div>
	<!-- END existe_relatorio_2 -->
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_reprovados_disciplina.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/relatorio.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/relatorio.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>