<div id="corpo">
<div id="left">
</div>
<div id="center">
	<h1 id="titulo">Link de mudança de senha</h1>
	<div>
		<form id="form_coordenador_link_senha" method="post" onkeypress="return event.keyCode != 13;">
			<div>
				<label>Email</label>
				<input type="text" id="busca" class="validate[required]" name="email">
			</div>
			<div>&nbsp;</div>
			<div>
				<label>Nome: </label>
				<span id="nome">{nome}</span>
				<input type="hidden" id="codigo" class="" name="codigo">
			</div>
			<div>&nbsp;</div>
			<div>
				<label>Email: </label>
				<span id="email">{email}</span>
				<input type="hidden" id="codigo" class="" name="codigo">
			</div>
			<div>&nbsp;</div>
			<div>
				<label>Link para mudança de senha: </label>
				<span id="link_mudanca_senha">{link_mudanca_senha}</span>
				<input type="hidden" id="codigo" class="" name="codigo">
			</div>
			<div>&nbsp;</div>
			<div>
				<input type="submit" value="Procurar">
			</div>
		</form>
	</div>
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/coordenador_aluno_email.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />


<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>