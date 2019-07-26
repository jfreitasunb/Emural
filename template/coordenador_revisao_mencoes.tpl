<div id="corpo">
<div id="left">
	<div>
		<label>Ano/Semestre</label>
		<select id="ano_semestre">
			<option value="0"></option>
			<!-- BEGIN adicionar_ano_semestre -->
				<option value="{ano_semestre_codigo}" {ano_semestre_selected}>{ano_semestre_descricao}</option>
			<!-- END adicionar_ano_semestre -->
		</select>
	</div>
	<div>
		<label>Turma</label>
		<select id="turmas">
			<!-- BEGIN existe_combo_turma -->
				<option value="0"></option>
				<!-- BEGIN adicionar_combo_turma -->
					<option value="{combo_turma_codigo}" {combo_turma_selected}>{combo_turma_descricao}</option>
				<!-- END adicionar_combo_turma -->
			<!-- END existe_combo_turma -->
		</select>
	</div>
	<div class="div_action">
		<input type="button" id="bt_selecionar_turma" value="Selecionar">
	</div>
</div>
<div id="center">
	<h1 id="titulo">Revisão de Menções<!-- BEGIN existe_turma_selecionada --> - {turma_semestre}º/{turma_ano}<!-- END existe_turma_selecionada --></h1>
	<!-- BEGIN existe_turma_selecionada_2 --><h2>{turma_disciplina_descricao} - {turma_descricao}</h2><!-- END existe_turma_selecionada_2 -->
	<!-- BEGIN existe_turma_selecionada_3 -->
	<div class="ultima_div">
		<form id="form_revisao_mencoes" method="post">
			{tabela_notas}
			<div>
				<input type="submit" value="Salvar">
			</div>
		</form>
	</div>
	<!-- END existe_turma_selecionada_3 -->
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_revisao_mencoes.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
	var creditos = "{turma_creditos}";
	var url_revisao_mencao = "{url_revisao_mencao}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/coordenador_revisao_mencoes.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>