<div id="corpo">
	<h1 class="text-center">Esqueci Minha Senha</h1>
	<!-- BEGIN existe_mensagem --><div id="mensagem" class="text-center">
		<!-- BEGIN adicionar_mensagem --><p>{mensagem}</p><!-- END adicionar_mensagem -->
	</div><!-- END existe_mensagem -->
	<div>
		<form method="post">
			<div class="field">
				<label>Matricula:</label>
				<input name="matricula" value="{matricula}"/>
			</div>
			<div class="field">
				<label>E-mail:</label>
				<input name="email" value="{email}"/>
			</div>
			<div class="div_action submit">
				<input type="submit" value="Enviar E-mail">
			</div>
		</form>
	</div>
</div>
<div class="clear"></div>

<link rel="stylesheet" href="{ROOT}css/validator/validationEngine.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/validator/template.css" type="text/css" />


<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/jquery_validationEngine_pt_BR.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jquery_validationEngine.js" charset="utf-8"></script>