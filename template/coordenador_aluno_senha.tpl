<div id="corpo">
<div id="left">
</div>
<div id="center">
	<h1 id="titulo">Alterar Senha de Aluno</h1>
	<div>
		<form id="form_coordenador_aluno_senha" method="post" onkeypress="return event.keyCode != 13;">
			<div class="field">
				<label>Matrícula</label>
				<input type="text" id="matricula" class="validate[required]" name="matricula">
			</div>
			<div class="invisivel field">
				<label>Nome: </label>
				<span id="nome_aluno"></span>
				<div class="clear"></div>
			</div>
			<div class="invisivel field">
				<label>Nova Senha</label>
				<input type="password" id="nova_senha" class="validate[required] senha_valor" name="nova_senha">
			</div>
			<div class="invisivel field">
				<label>Confirme Nova Senha</label>
				<input type="password" id="nova_senha_2" class="validate[required,equals[nova_senha]] senha_valor" name="nova_senha_2">
			</div>
			<div class="div_action invisivel">
				<input type="submit" value="Salvar">
			</div>
		</form>
	</div>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_aluno_senha.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />


<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/coordenador_aluno_senha.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>