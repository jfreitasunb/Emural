<div id="menuh-container">
	<div id="menuh">
		<ul class="ul_top_parent_inicio">
			<li><a href="{inicio_link}" class="top_parent top_parent_inicio">Início</a></li>
		</ul>
		<!-- BEGIN adicionar_turma -->
		<ul class="ul_top_parent">
			<li><a href="{turma_index_link}" class="top_parent top_parent_avaliacao">{turma_disciplina_descricao} - {turma_descricao}</a>
				<ul>
					<!-- BEGIN existe_configurar_avaliacoes --><li><a href="{turma_configuracao_link}">Configurar Avaliações</a></li><!-- END existe_configurar_avaliacoes -->
					<!-- BEGIN existe_avaliacoes -->
					<li><a href="#" class="parent">Lançar/Atualizar Notas</a>
						<ul>
							<!-- BEGIN adicionar_avaliacao --><li><a href="{avaliacao_link}">{avaliacao_nome}</a></li><!-- END adicionar_avaliacao -->
						</ul>
					</li>
					<li><a href="{turma_medias_mencoes_link}">Médias e Menções</a></li>
					<!-- <li><a href="{turma_monitores_link}">Monitores</a></li> -->
					<!-- END existe_avaliacoes -->
					<li><a href="{turma_avisos_link}">Avisos</a></li>
					<!-- BEGIN existe_reconfigurar_avaliacoes --><li><a href="{turma_reconfiguracao_link}">Reconfig. Avaliações</a></li><!-- END existe_reconfigurar_avaliacoes -->
				</ul>
			</li>
		</ul>
		<!-- END adicionar_turma -->
		<ul class="ul_top_parent_fim ul_top_parent_sair">
			<li><a href="{sair_link}" class="top_parent">Sair</a></li>
		</ul>
		<div class="ul_top_parent_fim ul_top_parent_saudacao">{saldacao}, {professor_nome}</div>
	</div>
</div>

<link rel="stylesheet" href="{ROOT}css/menu_topo.css" type="text/css" />