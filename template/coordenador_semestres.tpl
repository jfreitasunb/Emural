<div id="corpo">
<div id="left">
</div>
<div id="center">
	<h1 id="titulo">Configuração Semestres</h1>
	<div>
		<form id="form_coordenador_semestre" method="post" enctype="multipart/form-data">
			<div class="field"><label>Ano:</label><input type="text" id="ano" class="validate[required,custom[integer],minSize[4],maxSize[4]]" name="ano" value="{semestre_ano}"></div>
			<div class="field"><label>Semestre:</label><input type="text" id="semestre" class="validate[required,custom[integer]]" name="semestre" value="{semestre_semestre}"></div>
			<div class="field"><label>Início das Aulas:</label><input type="text" id="inicio" class="validate[required]" name="inicio" value="{semestre_inicio}"></div>
			<div class="field"><label>Fim das Aulas:</label><input type="text" id="fim" class="validate[required]" name="fim" value="{semestre_fim}"></div>
			<div class="field" style="color: #FF0000;">Atualizar a lista de ofertas no SI antes de carregar o arquivo de composição de turmas do SIGRA.</div>
			<div><label>Arquivo de Alunos do SIGRA: </label><input type="file" name="arquivo_sigra"></div>
			<!-- BEG IN existe_divisao_grupos -->
			<div id="div_grupos">
				<h2>Disciplinas Agrupadas no Moodle</h2>
				<div class="select left">
					<label>Disciplina</label>
					<select id="disciplina1">
						<option value=""></option>
						<!-- BEGIN adicionar_combo_disciplina1 -->
						<option value="{combo_disciplina1_codigo_cpd}">{combo_disciplina1_descricao}</option>
						<!-- END adicionar_combo_disciplina1 -->
					</select>
				</div>
				<h4 class="left">Agrupada com</h4>
				<div class="select left">
					<label>Disciplina</label>
					<select id="disciplina2">
						<option value=""></option>
						<!-- BEGIN adicionar_combo_disciplina2 -->
						<option value="{combo_disciplina2_codigo_cpd}">{combo_disciplina2_descricao}</option>
						<!-- END adicionar_combo_disciplina2 -->
					</select>
				</div>
				<div id="div_select_action" class="left">
					<button id="adicionar" type="button">Adicionar</button>
				</div>
				<div id="agrupamento">
				</div>
				<div class="clear"></div>
			</div>
			<div class="div_action">
				<input type="submit" value="Salvar">
			</div>
		</form>
	</div>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_semestres.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/table_custom.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
	var ano = parseInt("{semestre_ano}");
	var semestre = parseInt("{semestre_semestre}");
</script>

<script type="text/javascript" src="{ROOT}js/lib/coordenador_semestres.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_maskedinput.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_core.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_datepicker.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>