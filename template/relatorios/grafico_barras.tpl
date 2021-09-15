<div id="grafico_relatorio"></div>
<pre class="code brush:js"></pre>

<script type="text/javascript">
	$(document).ready(function(){
		<!-- BEGIN adicionar_variavel -->var {variavel_descricao} = [{variavel_valor}];<!-- END adicionar_variavel -->
		// Can specify a custom tick Array.
		// Ticks should match up one for each y value (category) in the series.
		var ticks = [{grafico_conjunto_descricao}];

		var plot1 = $.jqplot('grafico_relatorio', [{grafico_variaveis_entrada}], {
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
				<!-- BEGIN adicionar_dado_descricao -->{label:'{dado_descricao}'},<!-- END adicionar_dado_descricao -->
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
					label: '{grafico_label_eixo_x}'
				},
				// Pad the y axis just a little so bars can get close to, but
				// not touch, the grid boundaries. 1.2 is the default padding.
				yaxis: {
					label: '{grafico_label_eixo_y}',
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer
				}
			}
		});
	});
</script>

<link rel="stylesheet" href="{ROOT}css/jqplot.css" type="text/css" />

<script type="text/javascript" src="{ROOT}js/jquery_jqplot.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.barRenderer.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.categoryAxisRenderer.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.pointLabels.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.canvasTextRenderer.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{ROOT}js/jqplot/jqplot.canvasAxisLabelRenderer.min.js" charset="utf-8"></script>