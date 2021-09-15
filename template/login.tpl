<div id="corpo">
	<div id="esquerda">
		<div id="titulo_esquerda"><span>Bem vindo ao E-mural!</span></div>
		<div id="conteudo_esquerda">
			<p>Bem-vindo ao e-mural do Departamento de Matemática!</p>
		</div>
	</div>
	<div id="direita">
		<div id="titulo_direita"><span>Log-in</span></div>
		<div id="conteudo_direita">
			<form method="post">
				<div>
					<label>Usuário</label>
					<input class="input_login" type="text" name="usuario" value="{usuario}">
				</div>
				<div>
					<label>Senha</label>
					<input class="input_login" type="password" name="senha">
				</div>
				<div id="div_submit" class="meio_centralizado">
					<input type="submit" value="Entrar">
				</div>
				<div class="meio_centralizado">
					<a href="{esqueci_minha_senha_url}">Esqueci minha senha</a>
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/login.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>
