<div id="corpo">
<div id="left">
	<form method="post" id="form_relatorio">
		<div>
			<label>Ano/Semestre</label>
			<select name="ano_semestre" id="combo_ano_semestre" class="validate[required]">
				<option value=""></option>
				<!-- BEGIN adicionar_ano_semestre -->
					<option value="{ano_semestre_codigo}" {ano_semestre_selected}>{ano_semestre_descricao}</option>
				<!-- END adicionar_ano_semestre -->
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
			<label>Turma</label>
			<select name="turma" id="combo_turma">
				<option value="0"></option>
				<!-- BEGIN adicionar_combo_turma -->
					<option value="{combo_turma_codigo}" {combo_turma_selected}>{combo_turma_descricao}</option>
				<!-- END adicionar_combo_turma -->
			</select>
		</div>
		<div>
			<label>Somente Aprovados</label>
			<input name="aprovados" type="checkbox" {aprovados_checked}>
		</div>
		<div class="div_action">
			<input type="submit" value="Selecionar">
		</div>
	</form>
</div>
<div id="center">
	<h1 id="titulo">Lista de Alunos</h1>
	<!-- BEGIN existe_relatorio_1 --><h2>Disciplina - {relatorio_disciplina_descricao}<!-- BEGIN existe_relatorio_2 --> - {relatorio_turma_descricao}<!-- END existe_relatorio_2 --></h2><!-- END existe_relatorio_1 -->
	<!-- BEGIN existe_relatorio_3 --><h2>{relatorio_ano_semestre}</h2><!-- END existe_relatorio_3 -->
	<!-- BEGIN existe_relatorio_4 -->
	<div class="ultima_div">
		{relatorio}
		<div class="div_action">
			<form action="{link_relatorio_coordenador_lista_alunos_csv}" method="post" target="_blank">
				<input type="hidden" name="ano_semestre" value="{relatorio_ano_semestre_codigo}">
				<input type="hidden" name="disciplina" value="{relatorio_disciplina_codigo}">
				<!-- BEGIN existe_turma --><input type="hidden" name="turma" value="{relatorio_turma_codigo}"><!-- END existe_turma -->
				<!-- BEGIN existe_relatorio_aprovados --><input type="hidden" name="aprovados" value="{relatorio_aprovados}"><!-- END existe_relatorio_aprovados -->
				<input type="submit" value="Gerar CSV" />
			</form>
		</div>
	</div>
	<!-- END existe_relatorio_4 -->
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_lista_alunos.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/relatorio.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/relatorio.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>