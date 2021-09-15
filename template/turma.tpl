<div id="corpo">
<div id="left">
	<!-- BEGIN existe_algum_prova_checkbox -->
	<div class="div_check_left">
		<div class="tit_14">Checkboxes:</div>
		<ul>
			<!-- BEGIN adicionar_prova_checkbox -->
			<li><label>{prova_checkbox_nome}<input type="checkbox" id="{prova_checkbox_id}" class="checkbox_colunas" {prova_checkbox_checked}/></label></li>
			<!-- END adicionar_prova_checkbox -->
		</ul>
	</div>
	<!-- END existe_algum_prova_checkbox -->
</div>
<div id="center">
	<h1 id="titulo">Turma - {turma_semestre}º/{turma_ano}</h1>
	<h2 id="sub_titulo">{turma_disciplina_descricao} - {turma_descricao}</h2>
	<!-- BEGIN existe_acao_monitor -->
	<div id="acao_monitor" class="divisao_botton_clara">
		<div class="tit_14">Informações</div>
		<ul id="lista_tarefas_monitores">
			<!-- BEGIN adicionar_acao_monitor -->
			<li>O monitor <span class="color_azul">{monitor_nome}</span> {monitor_acao} dia {monitor_data} às {monitor_hora}.</li>
			<!-- END adicionar_acao_monitor -->
		</ul>
	</div>
	<!-- END existe_acao_monitor -->
	<div id="tabela" class="divisao_botton_clara">
		<div id="titulo_tabela" class="tit_14">Tabela de Rendimento</div>
		{tabela_notas}
		<div id="relatorios" class="div_action">
			<input type="button" onclick="window.print()" value="Imprimir Tabela" />
			<a href="{link_gerar_csv}"><input type="button" value="Gerar CSV" /></a>
		</div>
	</div>
	<!-- BEGIN existe_grafico_rendimento -->
	<div class="ultima_div" id="grafico_rendimento">
		<div class="tit_14">Grafico de Rendimento</div>
		<div id="grafico_desempenho"></div>
		<pre class="code brush:js"></pre>

		<script class="code" type="text/javascript">
			$(document).ready(function(){
				var s1 = [{quantidade_sr}];
				var s2 = [{quantidade_ii}];
				var s3 = [{quantidade_mi}];
				var s4 = [{quantidade_mm}];
				var s5 = [{quantidade_ms}];
				var s6 = [{quantidade_ss}];
				// Can specify a custom tick Array.
				// Ticks should match up one for each y value (category) in the series.
				var ticks = [{nome_avaliacao}];
	
				var plot1 = $.jqplot('grafico_desempenho', [s1, s2, s3, s4, s5, s6], {
					animate: !$.jqplot.use_excanvas,
					// The "seriesDefaults" option is an options object that will
					// be applied to all series in the chart.
					seriesDefaults:{
						renderer:$.jqplot.BarRenderer,
						rendererOptions: {fillToZero: true},
						pointLabels: { show: true }
					},
					
					// Custom labels for the series are specified with the "label"
					// option on the series option. Here a series option object
					// is specified for each series.
					series:[
						{label:'0'},
						{label:'0 < X < 3'},
						{label:'3 <= X < 5'},
						{label:'5 <= X < 7'},
						{label:'7 <= X < 9'},
						{label:'9 <= X <= 10'}
					],
					// Show the legend and put it outside the grid, but inside the
					// plot container, shrinking the grid to accomodate the legend.
					// A value of "outside" would not shrink the grid and allow
					// the legend to overflow the container.
					legend: {
						show: true,
						placement: 'outsideGrid'
					},
					axes: {
						// Use a category axis on the x axis and use our custom ticks.
						xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer,
							ticks: ticks,
							label: 'Avaliações'
						},
						// Pad the y axis just a little so bars can get close to, but
						// not touch, the grid boundaries. 1.2 is the default padding.
						yaxis: {
							label: 'Número Alunos',
							labelRenderer: $.jqplot.CanvasAxisLabelRenderer
						}
					}
				});
			});
		</script>
	</div>
	<!-- END existe_grafico_rendimento -->
</div>
<div class="clear"></div>
</div>

<link rel="stylesheet" href="{ROOT}css/lib/turma.css" type="text/css" />
<link rel="stylesheet" href="{ROOT}css/lib/turma_print.css" type="text/css" media="print" />
<link rel="stylesheet" href="{ROOT}css/jqplot.css" type="text/css" />

<script type="text/javascript">
	var ROOT = "{ROOT}";
</script>

<script type="text/javascript" src="{ROOT}js/lib/turma.js" charset="utf-8"></script>

<script type="text/javascript" src="{ROOT}js/jquery_jqplot.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.barRenderer.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.categoryAxisRenderer.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.pointLabels.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.canvasTextRenderer.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.canvasAxisLabelRenderer.min.js" charset="utf-8"></script>