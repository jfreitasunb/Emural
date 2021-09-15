<div id="corpo">
<form id="form_calculo_simples" method="post" onkeypress="return event.keyCode != 13;">
<div id="left">
	<div id="tipo_media">
		<h3 class="tit_14">Tipo de média</h3>
		<ul>
			<li><label>Aritmética<input type="radio" name="tipo_media" value="simples"  checked/></label></li>
			<li><label>Ponderada<input type="radio" name="tipo_media" value="ponderada" /></label></li>
			<!-- <li><label>Personalizada<input type="radio" name="tipo_media" value="personalizada" /></label></li> -->
		</ul>
	</div>

	<div class="div_action">
		<input type="button" value="Configuração Rápida" id="btn_configuracao_rapida">
	</div>

	<!-- BEGIN existe_avaliacoes_anteriores -->
	<div class="div_action">
		<label>Usar Avaliações Anteriores<input type="checkbox" id="avaliacoes_anteriores" name="{avaliacoes_anteriores}"></label>
	</div>
	<!-- END existe_avaliacoes_anteriores -->
</div>
<div id="center">
	<h1 id="titulo">Configurar Avaliações - {turma_semestre}º/{turma_ano}</h1>
	<h2 id="sub_titulo">{turma_disciplina_descricao} - {turma_descricao}</h2>

	<div id="configuracao_centro">
		<div id="div_titulos">
			<div class="lbl_cabecalho lbl_titulo">Avaliações</div>
			<div class="lbl_quantidade">Quantidade</div>
			<div class="lbl_selecionar">Selecionar</div>
			<div class="lbl_deletar">Excluir</div>
		</div>
		<div id="div_quantidade">
			<div class="clear"></div>
		</div>
		<div id="tipo_avaliacoes">
			<div>
				<input type="text" name="tipo" id="tipo" autocomplete="off"/>
				<button id="add_tipo_avaliacao" type="button">Criar</button>
			</div>
			<div class="suggestionsBox" id="suggestions">
				<img class="arrow" src="{ROOT}images/autosuggest/arrow.png" alt="upArrow" />
				<div class="suggestionList" id="suggestionsList"></div>
			</div>
		</div>
	</div>
	<div id="pesos">
		<div id="fs_pesos">
			<div id="fs_pesos_tit">Pesos</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="formula">
		<label class="t16b">Formula:</label>
		<input type="text" name="formula" id="formula" size="120" autocomplete="off"/>
	</div>

	<div class="div_action">
		<input type="button" id="bt_enviar" value="Configurar">
	</div>

	<div class="clear"></div>
</div>
<div id="right">
	<p class="descricao_simples">Crie os tipos de avaliação (Criar) e determine a quantidade para cada um.</p>
	<p class="descricao_simples">Feito isso, clique em configurar para finalizar o processo.</p>

	<p class="descricao_ponderada">Crie os tipos de avaliação (Criar) e determine a quantidade para cada um.</p>
	<p class="descricao_ponderada">Assim que as avaliações forem criadas (Selecionar), determine o peso de cada uma.</p>
	<p class="descricao_ponderada">Clique em Configurar para finalizar o processo.</p>
</div>
</form>
<div class="clear"></div>
</div>
<div id="configuracao_rapida">
	<form method="post" id="form_configuracao_rapida">
		<div class="div_input">
			<label>Data Prova 1</label>
			<input type="text" name="data_prova_1" id="data_prova_1" class="validate[required]" value="{data_prova_1}">
		</div>
		<div class="div_input">
			<label>Data Prova 2</label>
			<input type="text" name="data_prova_2" id="data_prova_2" class="validate[required]" value="{data_prova_2}">
		</div>
		<div class="div_input" style="float: none !important">
			<label>Data Prova 3</label>
			<input type="text" name="data_prova_3" id="data_prova_3" class="validate[required]" value="{data_prova_3}">
		</div>
		<input type="hidden" name="tipo_media" value="rapida"/>
		<input type="hidden" name="avaliacoes_anteriores" id="avaliacoes_anteriores_2" value=""/>
		<div class="div_action">
			<input type="button" value="Configurar" id="bt_enviar_2">
		</div>
		<div class="clear"></div>
	</form>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/turma_configuracao.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/suggest_tipo_avaliacao.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/table_custom.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
	var existe_compisicao_nota = {existe_compisicao_nota};
</script>
<script type="text/javascript" src="{ROOT}js/lib/turma_configuracao.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_watermark.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_lightbox.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_maskedinput.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_core.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_datepicker.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>