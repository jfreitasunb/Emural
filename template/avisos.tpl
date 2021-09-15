<div id="corpo">
<div id="left">
	<!-- BEGIN existe_observacoes_validas -->
	<div class="tit_14 titulo_left">Avisos Cadastrados</div>
	<!-- BEGIN adcionar_observacao -->
	<div class="aviso_cadastrado">
		<div class="titulo"><a href="{observacao_link_editar}">{observacao_titulo}</a></div>
		<p>{observacao_descricao}</p>
		<!-- BEGIN existe_publicado_futuro --><div class="data_divulgacao">Será publicado em {observacao_data_publicado_futuro}</div><!-- END existe_publicado_futuro -->
		<!-- BEGIN existe_publicado_passado --><div class="data_divulgacao">Publicado em {observacao_data_publicado_passado}</div><!-- END existe_publicado_passado -->
	</div>
	<!-- END adcionar_observacao -->
	<!-- END existe_observacoes_validas -->
</div>
<div id="center">
	<h1 id="titulo">Cadastro de Avisos - {turma_semestre}º/{turma_ano}</h1>
	<h2 id="sub_titulo">{turma_disciplina_descricao} - {turma_descricao}</h2>
	<p id="ajuda_simplificada">Insira aqui os avisos para a turma e especifique uma data de divulgação.<br>
	Para editar ou apagar um aviso cadastrado anteriormente, selecione-o na barra lateral esquerda.</p>
	<form id="form_avisos" method="post">
	<div id="formulario">
		<div><label>Título</label><input type="text" id="titulo" class="validate[required]" name="titulo" value="{observacao_ativa_titulo}"></div>
		<textarea rows="" cols="" id="descricao" class="validate[required]" name="descricao">{observacao_ativa_descricao}</textarea>
		<div id="div_data"><label>Data de Divulgação</label><input type="text" id="data_divulgacao" name="data_divulgacao" value="{observacao_ativa_data_divulgacao}"></div>
		<div class="clear"></div>
	</div>
	<div class="div_action">
		<a href="{link_avisos}"><input type="button" value="Novo"></a>
		<a href="{link_deletar}"><input type="button" value="Excluir"></a>
		<input type="submit" value="Salvar"></div>
	</form>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/avisos.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/table_custom.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/avisos.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_idealforms.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_maskedinput.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_widget.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_core.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_datepicker.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>