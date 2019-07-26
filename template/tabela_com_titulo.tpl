<!-- BEGIN adicionar_disciplina -->
<h2>{disciplina_nome}</h2>
<div>
<table cellpadding="0" cellspacing="0" border="0" id="" class="table display">
	<thead>
		<tr>
			<!-- BEGIN adicionar_celula_titulo --><th>{celula_titulo}</th><!-- END adicionar_celula_titulo -->
		</tr>
	</thead>
	<tbody>
		<!-- BEGIN adicionar_linha -->
		<tr>
			<!-- BEGIN adicionar_celula_corpo --><td>{celula_corpo}</td><!-- END adicionar_celula_corpo -->
		</tr>
		<!-- END adicionar_linha -->
	</tbody>
</table>
</div>
<!-- END adicionar_disciplina -->
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