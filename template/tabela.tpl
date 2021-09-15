<div id="div_tabela_notas">
<table cellpadding="0" cellspacing="0" border="0" id="tabela_dados" class="table display">
	<thead>
		<tr>
			<th>Matricula</th>
			<th>Nome</th>
			<!-- BEGIN adicionar_celula_titulo --><th>{celula_titulo}</th><!-- END adicionar_celula_titulo -->
		</tr>
	</thead>
	<!-- BEGIN existe_rodape -->
	<tfoot>
		<tr>
			<!-- BEGIN adicionar_celula_rodape --><td>{celula_rodape}</td><!-- END adicionar_celula_rodape -->
		</tr>
	</tfoot>
	<!-- END existe_rodape -->
	<tbody>
		<!-- BEGIN adicionar_linha -->
		<tr>
			<td>{aluno_matricula}</td>
			<td>{aluno_nome}</td>
			<!-- BEGIN adicionar_celula_corpo --><td id="{celula_id}">{celula_corpo}</td><!-- END adicionar_celula_corpo -->
		</tr>
		<!-- END adicionar_linha -->
	</tbody>
</table>
</div>
<link rel="stylesheet" href="{ROOT}css/table.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/table_custom.css" type="text/css" />

<script type="text/javascript" src="{ROOT}js/jquery_datatables.js" charset="utf-8"></script>

<script type="text/javascript">
	$(function(){
		$('.table').dataTable( {
			"aaSorting": [[ 0, "asc" ]],
			"bJQueryUI": true,
			"bPaginate": false,
	        "bLengthChange": false,
	        "bFilter": false,
	        "bSort": true,
	        "bInfo": false,
	        "bAutoWidth": false,
	        "sScrollX": "100%",
	        "bScrollCollapse": true
		});
	});
</script>