<div id="corpo">
<div id="left">
</div>
<div id="center">
	<h1 id="titulo">Email</h1>
	<div>
		<form id="form_aluno_email" method="post" action="{url_aluno_email}">
			<div class="field">
				<label>Alterar Email:</label>
				<input type="text" id="senha_atual" class="validate[required,custom[email]]" name="email" value="{email}">
			</div>
			<div class="div_action">
				<input type="submit" value="Salvar">
			</div>
		</form>
	</div>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/aluno_email.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />


<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/aluno_email.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>