<div id="corpo">
<div id="left">
	<!-- BEGIN existe_algum_prova_checkbox -->
	<div class="div_check_left">
		<div class="tit_14">Checkboxes:</div>
		<ul>
			<!-- BEGIN adicionar_prova_checkbox -->
			<li><label>{prova_checkbox_nome}<input type="checkbox" id="{prova_checkbox_id}" class="checkbox_colunas" {prova_checkbox_checked}/></label></li>
			<!-- END adicionar_prova_checkbox -->
		</ul>
	</div>
	<!-- END existe_algum_prova_checkbox -->
</div>
<div id="center">
	<h1 id="titulo">Médias e Menções - {turma_semestre}º/{turma_ano}</h1>
	<h2 id="titulo">{turma_disciplina_descricao} - {turma_descricao}</h2>

	<form id="form_media_mencoes" method="post">
		<div class="div_inputs">
			<div>
				<label>Exibir Médias<input type="checkbox" name="exibir_medias" {turma_exibe_medias}></label>
			</div>
			<div>
				<label>Exibir Menções<input type="checkbox" name="exibir_mencoes" {turma_exibe_mencoes}></label>
			</div>
		</div>
		{tabela_notas}
		<div class="div_action">
			<input type="submit" value="Salvar">
		</div>
	</form>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/medias_mencoes.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
	var creditos = "{turma_creditos}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/media_mencoes.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>