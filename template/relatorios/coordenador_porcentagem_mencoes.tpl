<div id="corpo">
<div id="left">
	<form method="post" id="form_relatorio">
		<div>
			<label>Ano/Semestre Inicio</label>
			<select name="ano_semestre_inicio" class="validate[required]">
				<option value=""></option>
				<!-- BEGIN adicionar_ano_semestre_inicio -->
					<option value="{ano_semestre_inicio_codigo}" {ano_semestre_inicio_selected}>{ano_semestre_inicio_descricao}</option>
				<!-- END adicionar_ano_semestre_inicio -->
			</select>
		</div>
		<div>
			<label>Ano/Semestre Fim</label>
			<select name="ano_semestre_fim" class="validate[required]">
				<option value=""></option>
				<!-- BEGIN adicionar_ano_semestre_fim -->
					<option value="{ano_semestre_fim_codigo}" {ano_semestre_fim_selected}>{ano_semestre_fim_descricao}</option>
				<!-- END adicionar_ano_semestre_fim -->
			</select>
		</div>
		<div>
			<label>Disciplina</label>
			<select name="disciplina" id="combo_disciplina" class="validate[required]">
				<option value=""></option>
				<!-- BEGIN adicionar_combo_disciplina -->
					<option value="{combo_disciplina_codigo}" {combo_disciplina_selected}>{combo_disciplina_descricao}</option>
				<!-- END adicionar_combo_disciplina -->
			</select>
		</div>
		<div>
			<label>Opção de Curso</label>
			<select name="opcao_curso" class="validate[required]">
				<option value=""></option>
				<!-- BEGIN adicionar_combo_opcao_curso -->
					<option value="{combo_opcao_curso_opcao_curso}" {combo_opcao_curso_selected}>{combo_opcao_curso_opcao_curso}</option>
				<!-- END adicionar_combo_opcao_curso -->
			</select>
		</div>
		<div class="div_action">
			<input type="submit" value="Selecionar">
		</div>
	</form>
</div>
<div id="center">
	<h1 id="titulo">Porcentagem de Menções</h1>
	<!-- BEGIN existe_relatorio_2 --><h2>Disciplina - {relatorio_disciplina_descricao}</h2><!-- END existe_relatorio_2 -->
	<!-- BEGIN existe_relatorio_3 --><h2>Periodo - {relatorio_inicio_ano_semestre} a {relatorio_fim_ano_semestre}</h2><!-- END existe_relatorio_3 -->
	<!-- BEGIN existe_relatorio_4 --><h2>Opção de Curso - {relatorio_opcao_curso}</h2><!-- END existe_relatorio_4 -->
	<!-- BEGIN existe_relatorio_5 -->
	<div class="ultima_div">
		{relatorio}
		<div class="div_action">
			<form action="{link_relatorio_coordenador_porcentagem_mencoes}" method="post" target="_blank">
				<input type="hidden" name="ano_semestre_inicio" value="{relatorio_ano_semestre_inicio_codigo}">
				<input type="hidden" name="ano_semestre_fim" value="{relatorio_ano_semestre_fim_codigo}">
				<input type="hidden" name="disciplina" value="{relatorio_disciplina_codigo}">
				<input type="hidden" name="opcao_curso" value="{relatorio_opcao_curso}">
				<input type="submit" value="Gerar CSV" />
			</form>
		</div>
	</div>
	<!-- END existe_relatorio_5 -->
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_porcentagem_mencoes.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/relatorio.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/relatorio.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>