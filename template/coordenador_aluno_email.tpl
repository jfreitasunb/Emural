<div id="corpo">
<div id="left">
</div>
<div id="center">
	<h1 id="titulo">Alterar Email de Aluno</h1>
	<div>
		<form id="form_coordenador_aluno_email" method="post" onkeypress="return event.keyCode != 13;">
			<div>
				<label>Matrícula/Email</label>
				<input type="text" id="busca" class="validate[required]" name="matricula">
			</div>
			<div class="invisivel">
				<label>Matricula: </label>
				<span id="matricula_aluno"></span>
				<input type="hidden" id="codigo" class="" name="codigo">
			</div>
			<div class="invisivel">
				<label>Nome: </label>
				<span id="nome_aluno"></span>
			</div>
			<div class="invisivel">
				<label>Email</label>
				<input type="text" id="email" class="validate[required,custom[email]]" name="email">
			</div>
			<div class="div_action invisivel">
				<input type="submit" value="Salvar">
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

<script type="text/javascript" src="{ROOT}js/lib/coordenador_aluno_email.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>