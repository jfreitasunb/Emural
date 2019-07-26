<div>
	<h1 class="text-center">Cadastro de Novos Alunos</h1>
</div>
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
		<div class="field">
			<label>Confirmar E-mail:</label>
			<input name="email_confirmar" value="{email_confirmar}"/>
		</div>
		<div class="field">
			<label>Senha:</label>
			<input type="password" name="senha"/>
		</div>
		<div class="field">
			<label>Confirmar Senha:</label>
			<input type="password" name="confirmar_senha"/>
		</div>
		<div class="field">
			<label>Disciplina:</label>
			<select name="disciplina" id="combo_disciplina">
				<option value="0"></option>
				<!-- BEGIN adicionar_combo_disciplina -->
				<option value="{combo_disciplina_codigo}" {combo_disciplina_selected}>{combo_disciplina_descricao}</option>
				<!-- END adicionar_combo_disciplina -->
			</select>
		</div>
		<div class="field">
			<label>Turma:</label>
			<select name="turma" id="combo_turma">
				<option value="0"></option>
				<!-- BEGIN adicionar_combo_turma -->
				<option value="{combo_turma_codigo}" {combo_turma_selected}>{combo_turma_descricao}</option>
				<!-- END adicionar_combo_turma -->
			</select>
		</div>
		<div class="submit">
			<input type="submit" value="Salvar"/>
		</div>
		<div class="clear"></div>
	</form>
</div>
<script>
	$("#combo_disciplina").change(function(){
		var disciplina = $(this).val();

		if(disciplina > 0) {
			$.post("{ROOT}ajax/turmas_ultimo_semestre.php", {codigoDisciplina: ""+disciplina+""}, function(data){
				if(data.length > 0) {
					$('#combo_turma').html(data);
				} else {
					$('#combo_turma').html("");
				}
			});
		} else {
			$('#combo_turma').html("");
		}
	});
</script>