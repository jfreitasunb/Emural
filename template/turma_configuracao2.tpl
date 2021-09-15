<div id="corpo">
<h1 id="titulo">Configuração de Turma - {turma_semestre}º/{turma_ano}</h1>
<h2 id="titulo">{turma_disciplina_descricao} - {turma_descricao}</h2>

<form id="form_calculo_simples" method="post">
<div id="meio">
<div id="div_esquerda">
	<div id="div_titulos">
	<label id="lbl_tit_avaliacoes" class="t16b">Avaliações</label>
	<label id="lbl_tit_quantidade" class="t16b">Quantidade</label>
	<label id="lbl_tit_acoes" class="t16b">Ações</label>
	</div>
	<div id="div_quantidade">
		<div class="clear"></div>
	</div>
	<div id="tipo_avaliacoes">
		<div>
			<label id="lbl_tipo_avaliacao">Outras Avaliações:</label>
			<input type="text" name="tipo" id="tipo" size="19" autocomplete="off"/>
			<button id="add_tipo_avaliacao" type="button">Adicionar</button>
		</div>
		<div class="suggestionsBox" id="suggestions"> <img class="arrow" src="{ROOT}images/autosuggest/arrow.png" alt="upArrow" />
			<div class="suggestionList" id="suggestionsList"> &nbsp; </div>
		</div>
	</div>
</div>
<div id="tipo_media">
	<h3 class="t16b">Tipo de média</h3>
	<ul>
		<li><label><input type="radio" name="tipo_media" value="simples"  checked/>Aritmética</label></li>
		<li><label><input type="radio" name="tipo_media" value="ponderada" />Ponderada</label></li>
		<li><label><input type="radio" name="tipo_media" value="personalizada" />Personalizada</label></li>
	</ul>
</div>
</div>

<div id="pesos">
	<fieldset id="fs_pesos">
		<legend class="t16b">Pesos</legend>
	</fieldset>
</div>
<div id="formula">
	<label class="t16b">Formula:</label>
	<input type="text" name="formula" id="formula" size="120" autocomplete="off"/>
</div>

<div>
	<input type="submit" value="Configurar">
</div>

</form>
<div class="clear"></div>
</div>


<link rel="stylesheet" href="{ROOT}css/lib/turma_configuracao.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/suggest_tipo_avaliacao.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/idealforms/idealforms.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>
<script type="text/javascript" src="{ROOT}js/lib/turma_configuracao.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_idealforms.js" charset="utf-8"></script>