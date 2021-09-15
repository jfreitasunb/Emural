<script type="text/javascript" src="{ROOT}js/jquery_noty.js"></script>
<script type="text/javascript" src="{ROOT}js/noty/topCenter.js"></script>
<script type="text/javascript" src="{ROOT}js/noty/theme.js"></script>

<script type="text/javascript">
	function generate(type, text, link) {
		var n = noty({
			text: text,
			type: type,
			dismissQueue: true,
			modal: true,
			layout: 'topCenter',
			theme: 'default',
			callback: {
				afterClose: function() {
					if(link.length > 0) {
						location.href = link;
					}
				}
			}
		});
	}
	$(document).ready(function() {
		<!-- BEGIN adcionar_alerta -->
			generate('{tipo}', '{mensagem}', '{link}');
		<!-- END adcionar_alerta -->
	});
</script>