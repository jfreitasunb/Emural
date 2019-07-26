<div id="corpo">
<div id="left">
	<table id="tabela_monitores_cadastrados">
		<thead>
			<tr>
				<th class="tit_14">Monitores</th>
				<th class="tit_14 coluna_2">Avaliações</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN adcionar_monitor -->
			<tr>
				<td class="coluna_1"><a href="{monitor_link_editar}">{monitor_nome}</a></td>
				<td class="coluna_2">{monitor_avaiacao_nome}</td>
			</tr>
			<!-- END adcionar_monitor -->
		</tbody>
	</table>
</div>
<div id="center">
	<h1 id="titulo">Cadastro de Monitores - {turma_semestre}º/{turma_ano}</h1>
	<h2 id="titulo">{turma_disciplina_descricao} - {turma_descricao}</h2>
	<p id="ajuda_simplificada">Texto esplicativo de como se deve proceder o cadastro de um monitor.</p>
	<form id="form_monitores" method="post">
	<table id="tabela_cadastrar_monitores">
		<thead>
			<tr>
				<th>Para a avaliação:</th>
				<th>Eu escolho o monitor:</th>
				<th>Lançar</th>
				<th>Editar</th>
				<th>Confiável</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<select name="avaliacao" id="avaliacao" class="validate[required]">
						<option value=""></option>
						<!-- BEGIN adcionar_avaliacao_combo --><option value="{avaliacao_combo_valor}" {avaliacao_combo_selected}>{avaliacao_combo_descricao}</option>
						<!-- END adcionar_avaliacao_combo --></select>
				</td>
				<td>
					<select name="monitor" id="monitor" class="validate[required]">
						<option value=""></option>
						<!-- BEGIN adcionar_monitor_combo --><option value="{monitor_combo_valor}" {monitor_combo_selected}>{monitor_combo_descricao}</option>
						<!-- END adcionar_monitor_combo --></select>
				</td>
				<td class="input_checkbox"><input type="checkbox" name="lancar" id="lancar" {lancar_checked}/></td>
				<td class="input_checkbox"><input type="checkbox" name="editar" id="editar" {editar_checked}/></td>
				<td class="input_checkbox"><input type="checkbox" name="confiar" id="confiar" {confiar_checked}/></td>
			</tr>
		</tbody>
	</table>
	<div class="div_action">
		<a href="{link_monitores}"><input type="button" value="Novo"></a>
		<a href="{link_deletar}"><input type="button" value="Excluir"></a>
		<input type="submit" value="Salvar"></div>
	</form>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/monitores.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/monitores.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>