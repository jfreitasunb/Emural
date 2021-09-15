$(function(){
	$("#data_realizacao").mask("99/99/9999");
	$("#data_divulgacao").mask("99/99/9999");


	$("#data_realizacao").datepicker();
	$("#data_divulgacao").datepicker();

	$('.checkbox_colunas').change(function() {
		fnShowHide(this.id, this.checked);
	});

	$(".checkbox_colunas").each(function (i) {
		fnShowHide(this.id, this.checked);
	});

	function fnShowHide(col, visible)
	{
		/* Get the DataTables object again - this is not a recreation, just a get of the object */
		var oTable = $('#tabela_dados').dataTable();

		oTable.fnSetColumnVis( col, visible);
		oTable.css('width', "100%");
		oTable.fnAdjustColumnSizing();
	}

	jQuery("#form_avaliacao").validationEngine();
});
