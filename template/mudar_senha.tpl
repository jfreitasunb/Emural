<div id="corpo">
	<div>
		<h1 class="text-center">Mudar Senha de {nome}({matricula})</h1>
	</div>
	<!-- BEGIN existe_mensagem --><div id="mensagem" class="text-center">
		<!-- BEGIN adicionar_mensagem --><p>{mensagem}</p><!-- END adicionar_mensagem -->
	</div><!-- END existe_mensagem -->
	<div>
		<form method="post">
			<div class="field">
				<label>Senha:</label>
				<input type="password" name="senha"/>
			</div>
			<div class="field">
				<label>Confirmar Senha:</label>
				<input type="password" name="confirmar_senha"/>
			</div>
			<div class="div_action submit">
				<input type="submit" value="Alterar Senha"/>
			</div>
			<div class="clear"></div>
		</form>
	</div>
</div>
<div class="clear"></div>