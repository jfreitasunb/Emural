<div id="corpo">
<div id="left">
</div>
<div id="center">
	<h1 id="titulo">Alterar Senha</h1>
	<div>
		<form id="form_coordenador_senha" method="post">
			<div class="field">
				<label>Senha Atual</label>
				<input type="password" id="senha_atual" class="validate[required]" name="senha_atual">
			</div>
			<div class="field">
				<label>Nova Senha</label>
				<input type="password" id="nova_senha" class="validate[required]" name="nova_senha">
			</div>
			<div class="field">
				<label>Confirme Nova Senha</label>
				<input type="password" id="nova_senha_2" class="validate[required,equals[nova_senha]]" name="nova_senha_2">
			</div>
			<div class="div_action">
				<input type="submit" value="Salvar">
			</div>
		</form>
	</div>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_senha.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />


<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/coordenador_senha.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>