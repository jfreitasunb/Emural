<div id="corpo">
<div id="left">
<!-- BEGIN existe_algum_prova_checkbox -->
	<div class="div_check_left">
		<div class="tit_14">Exibir Avaliações</div>
		<ul>
			<!-- BEGIN adicionar_prova_checkbox -->
			<li><label>{prova_checkbox_nome}<input type="checkbox" id="{prova_checkbox_id}" class="checkbox_colunas" {prova_checkbox_checked}/></label></li>
			<!-- END adicionar_prova_checkbox -->
		</ul>
	</div>
<!-- END existe_algum_prova_checkbox -->
</div>
<div id="center">
	<h1 id="titulo">Lançamento de notas - {turma_semestre}º/{turma_ano}</h1>
	<h2 id="titulo">{turma_disciplina_descricao} - {turma_descricao} / {avaliacao_nome}</h2>

	<form id="form_avaliacao" method="post">
	<div class="div_inputs">
		<div>
			<label>Data de Realização:<input type="text" name="data_realizacao" class="validate[required]" id="data_realizacao" value="{avaliacao_data_realizacao}" size="19" autocomplete="off"/></label>
		</div>
		<div>
			<label>Data de Divulgação:<input type="text" name="data_divulgacao" class="validate[required]" id="data_divulgacao" value="{avaliacao_data_divulgacao}" size="19" autocomplete="off"/></label>
		</div>
		<div>
			<label>Divulgar:<input type="checkbox" name="divulgacao" id="divulgacao" {avaliacao_divulgar}/></label>
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

<link rel="stylesheet" href="{ROOT}css/lib/avaliacao.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/avaliacao.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_maskedinput.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_core.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_datepicker.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>