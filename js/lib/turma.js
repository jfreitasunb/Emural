$(function(){
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


	var beforePrint = function() {
		var oTable = $('#tabela_dados').dataTable();
		oTable.css('width', "960px");
		oTable.fnAdjustColumnSizing();
    };
    var afterPrint = function() {
		var oTable = $('#tabela_dados').dataTable();
		oTable.css('width', "100%");
		oTable.fnAdjustColumnSizing();
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;

	/*$('#print_tabela_notas').click(function() {
		w = window.open();
		w.document.write($("html").html());
		w.print();
		w.close();
	});*/
});