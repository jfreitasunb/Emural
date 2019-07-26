<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">

<head>
	<title>{titulo}</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

	<link rel="stylesheet" href="{ROOT}css/mat_cabecalho_rodape.css" type="text/css" />
	<!-- <link rel="stylesheet" href="{ROOT}css/form.css" type="text/css" /> -->

	<script type="text/javascript" src="{ROOT}js/jquery.js"></script>

	<link rel="shortcut icon" href="{ROOT}images/logo_mat_unb.png"/>
</head>

<body>
	<div class="container">
		<div class="left">
			<div class="logo">
				<a href="{link_mat_unb}" title=""><img src="{ROOT}images/logo_mat_unb.png" alt=""/></a>
			</div>
		</div>
		<div class="right">
			<div class="row row-title" style="width: 550px">
				<h1 class="text-center font1 blue">Departamento de Matemática</h1>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="corpo_conteudo">
		<div class="container">
			<!-- BEGIN adicionar_conteudo -->{conteudo}<!-- END adicionar_conteudo -->
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<div class="left">
				<p class="grey">Copyright © {ano} - Departamento de Matemática</p>
			</div>
		</div>
	</div>
</body>
</html>