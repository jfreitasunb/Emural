<?php

require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/alertasBO.php';
require_once $ROOT_PATH.'lib/urlBO.php';

require_once 'HTML/Template/Sigma.php';

class TemplateBO
{
	private $root_path;
	private $root;

	private $linkBO;

	function __construct()
	{
		GLOBAL $ROOT_PATH, $ROOT;

		$this->linkBO = new LinkBO();

		$this->root_path = $ROOT_PATH;
		$this->root = $ROOT;
	}


	private function carregarCabecalhoERodape()
	{
		$tpl_pagina = new HTML_Template_Sigma($this->root_path.'template');
		$tpl_pagina->loadTemplateFile('cabecalho_rodape.tpl');

		$this->iniciarCabecalhoRodape($tpl_pagina);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('rodape.tpl');

		$tpl->setVariable(array(
			"conteudo"  => " "
		));

		$tpl_pagina->setVariable(array(
			"rodape"  => $tpl->get()
		));

		return $tpl_pagina;
	}


	private function carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre)
	{
		$turmas_BO = new TurmasBO();

		$tpl_pagina = $this->carregarCabecalhoERodape();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('menu_professor.tpl');

		$turmas_BO->preencherMenuProfessor($tpl,$professor,$semestre->ano,$semestre->semestre);
		$this->iniciarMenuProfessor($tpl,$professor);

		$tpl_pagina->setVariable(array(
			"conteudo_topo"  => "<img alt='' src='".$this->root."images/topo_menu2.png'>"
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		$tpl_pagina->setVariable(array(
			"conteudo_topo"  => $tpl->get()
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		return $tpl_pagina;
	}


	private function carregarCabecalhoERodapeDeAlunoComMenu($aluno, $existe_menu = true)
	{
		$turmas_BO = new TurmasBO();

		$tpl_pagina = $this->carregarCabecalhoERodape();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('menu_aluno.tpl');

		$this->iniciarMenuAluno($tpl, $aluno, $existe_menu);


		$tpl_pagina->setVariable(array(
			"conteudo_topo"  => "<img alt='' src='".$this->root."images/topo_menu2.png'>"
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		$tpl_pagina->setVariable(array(
			"conteudo_topo"  => $tpl->get()
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		return $tpl_pagina;
	}


	private function carregarCabecalhoERodapeDeCoordenadorComMenu()
	{
		$turmas_BO = new TurmasBO();

		$tpl_pagina = $this->carregarCabecalhoERodape();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('menu_coordenador.tpl');

		$this->iniciarMenuCoordenador($tpl);

		$tpl_pagina->setVariable(array(
			"conteudo_topo"  => "<img alt='' src='".$this->root."images/topo_menu2.png'>"
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		$tpl_pagina->setVariable(array(
			"conteudo_topo"  => $tpl->get()
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		return $tpl_pagina;
	}


	public function carregarPaginaAvaliacao($professor,$semestre,$turma,$avaliacao)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getProfessor(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getTurma($turma),
			"caminho_link_descricao" => $turma->disciplina_descricao." - ".$turma->descricao,
			"nao_inicio_espaco" => " "
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Avaliações"
		));
		$tpl->parse("caminho_comum");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => $avaliacao->nome
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaMonitores($professor,$semestre,$turma)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getProfessor(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getTurma($turma),
			"caminho_link_descricao" => $turma->disciplina_descricao." - ".$turma->descricao,
			"nao_inicio_espaco" => " "
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Monitores"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaAvisos($professor,$semestre,$turma)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getProfessor(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getTurma($turma),
			"caminho_link_descricao" => $turma->disciplina_descricao." - ".$turma->descricao,
			"nao_inicio_espaco" => " "
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Avisos"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaTurma($professor,$semestre,$turma)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getProfessor(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => $turma->disciplina_descricao." - ".$turma->descricao
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaConfiguracaoTurma($professor,$semestre,$turma)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getProfessor(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getTurma($turma),
			"caminho_link_descricao" => $turma->disciplina_descricao." - ".$turma->descricao,
			"nao_inicio_espaco" => " "
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Configurar Avaliações"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaMediasMencoes($professor,$semestre,$turma)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor,$semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getProfessor(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getTurma($turma),
			"caminho_link_descricao" => $turma->disciplina_descricao." - ".$turma->descricao,
			"nao_inicio_espaco" => " "
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Médias e Menções"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaProfessor($professor,$semestre)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeProfessorComMenu($professor, $semestre);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_inicio_sem_link_descricao" => "Início"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaAluno($aluno)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeAlunoComMenu($aluno);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_inicio_sem_link_descricao" => "Início"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaAlunoNotas($aluno)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeAlunoComMenu($aluno);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getAluno(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Notas"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaAlunoSenha($aluno)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeAlunoComMenu($aluno);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getAluno(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Alteração de Senha"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaAlunoEmail($aluno, $existe_menu)
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeAlunoComMenu($aluno, $existe_menu);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getAluno(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Alteração de Email"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaCoordenador()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_inicio_sem_link_descricao" => "Início"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaCoordenadorSenha()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Alteração de Senha"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaCoordenadorAlunoSenha()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Alterar Senha de Aluno"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaCoordenadorAlunoEmail()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Alterar Email de Aluno"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}

	public function carregarPaginaCoordenadorLinkSenha()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Link para mudança de senha"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}

	public function carregarPaginaCoordenadorSemestres()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Semestres"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaCoordenadorRevisaoMencoes()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");
		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Revisão de Menções"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaRelatorioCoordenadorPorcentagemMencoes()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");

		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Reltórios"
		));
		$tpl->parse("caminho_comum");

		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Porcentagem Menções por Período"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	public function carregarPaginaRelatorioCoordenadorPorcentagemAprovados()
	{
		$tpl_pagina = $this->carregarCabecalhoERodapeDeCoordenadorComMenu();

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('navegacao.tpl');

		$tpl->setVariable(array(
			"caminho_link_url"  => $this->linkBO->getCoordenador(),
			"caminho_link_descricao" => "Início"
		));
		$tpl->parse("caminho_link");

		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Reltórios"
		));
		$tpl->parse("caminho_comum");

		$tpl->setVariable(array(
			"caminho_comum_descricao" => "Porcentagem Aprovados por Período"
		));

		$tpl_pagina->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_pagina->parse("body");

		return $tpl_pagina;
	}


	private function iniciarCabecalhoRodape($tpl)
	{
		GLOBAL $TITULO;

		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'titulo' => $TITULO
		));
	}


	private function iniciarMenuProfessor($tpl,$professor)
	{
		$nome = $professor->nome;
		if(strlen($nome) > 16) {
			$nome = substr($nome,0,16);
		}
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'inicio_link'  => $this->linkBO->getProfessor(),
			'sair_link'  => $this->linkBO->getSair(),
			'professor_nome' => $nome,
			'saldacao' => $this->getSaldacao()
		));
	}


	private function iniciarMenuAluno($tpl, $aluno, $existe_menu)
	{
		if ($existe_menu) {
			$tpl->setVariable(array(
				'inicio_link'  => $this->linkBO->getAluno(),
				'notas_link'  => $this->linkBO->getAlunoNotas(),
				'senha_link' => $this->linkBO->getAlunoSenha(),
				'email_link' => $this->linkBO->getAlunoEmail()
			));
		}

		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'aluno_nome' => $aluno->nome,
			'saldacao' => $this->getSaldacao(),
				'sair_link'  => $this->linkBO->getSair()
		));
	}


	private function iniciarMenuCoordenador($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'inicio_link'  => $this->linkBO->getCoordenador(),
			'semestre_configuracao_link'  => $this->linkBO->getCoordenadorSemestre(),
			'sair_link'  => $this->linkBO->getSair(),
			'revisao_mencoes_link' => $this->linkBO->getCoordenadorRevisaoMencoes(),
			'senha_link' => $this->linkBO->getCoordenadorSenha(),
			'alterar_senha_aluno_link' => $this->linkBO->getCoordenadorAlunoSenha(),
			'alterar_email_aluno_link' => $this->linkBO->getCoordenadorAlunoEmail(),
			'link_mudanca_senha' => $this->linkBO->getCoordenadorLinkMudancaSenha(),
			'relatorio_porcentagem_mencoes_link' => $this->linkBO->getCoordenadorRelatorioPorcentagemMencoes(),
			'relatorio_porcentagem_aprovados_link' => $this->linkBO->getCoordenadorRelatorioPorcentagemAprovados(),
			'relatorio_lista_alunos_link' => $this->linkBO->getCoordenadorRelatorioListaAlunos(),
			'relatorio_reprovados_disciplina' => $this->linkBO->getCoordenadorRelatorioReprovadosDisciplina()
		));
	}


	private function iniciarCabecalhoRodapeMat($tpl)
	{
		$tpl->setVariable(array(
			'ROOT' => $this->root,
			'ano' => date("Y")
		));
	}


	public function iniciarGenerico($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarTurmaConfiguracoes($tpl,$turma)
	{
		if(strlen($turma->compisicao_nota)) {
			$composicao_nota = "true";
		} else {
			$composicao_nota = "false";
		}
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'existe_compisicao_nota' => $composicao_nota
		));
	}


	public function iniciarAvaliacao($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarTurma($tpl,$turma)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'link_gerar_csv' => $this->linkBO->getRelatorioTurmaCSV($turma)
		));
	}


	public function iniciarProfessor($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarAluno($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarAlunoNotas($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarCoordenador($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarCoordenadorSemestres($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'link_novo_coordenador_semestres' => $this->linkBO->getCoordenadorSemestreNovo()
		));
	}


	public function iniciarCoordenadorRevisaoMencoes($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'url_revisao_mencao' => $this->linkBO->getCoordenadorRevisaoMencoes()
		));
	}


	public function iniciarCoordenadorSenha($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarCoordenadorRelatorioPorcentagemMencoes($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarCoordenadorRelatorioPorcentagemAprovados($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarAvisos($tpl,$turma,$observacao)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'link_avisos' => $this->linkBO->getAvisos($turma),
			'link_deletar' => $this->linkBO->getDeletarAvisos($turma,$observacao)
		));
	}


	public function iniciarMonitores($tpl,$turma,$responsavel)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'link_monitores' => $this->linkBO->getMonitores($turma),
			'link_deletar' => $this->linkBO->getDeletarMonitores($turma,$responsavel)
		));
	}


	public function iniciarMediasMencoes($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarLogin($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'esqueci_minha_senha_url' => $this->linkBO->getEsqueciSenha()
		));
	}


	public function iniciarTabela($tpl)
	{
		$tpl->setGlobalVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function iniciarAlunoEmail($tpl)
	{
		$tpl->setVariable(array(
			'ROOT'  => $this->root,
			'url_aluno_email' => $this->linkBO->getAlunoEmail()
		));
	}


	public function iniciarGrafico($tpl)
	{
		$tpl->setGlobalVariable(array(
			'ROOT'  => $this->root
		));
	}


	public function carregarCabecalhoRodapeMat()
	{
		$tpl_pagina = new HTML_Template_Sigma($this->root_path.'template');
		$tpl_pagina->loadTemplateFile('mat_cabecalho_rodape.tpl');

		$this->iniciarCabecalhoRodapeMat($tpl_pagina);

		return $tpl_pagina;
	}


	public function carregarCabecalhoRodapeSomente()
	{
		$tpl_pagina = new HTML_Template_Sigma($this->root_path.'template');
		$tpl_pagina->loadTemplateFile('cabecalho_rodape.tpl');

		$this->iniciarCabecalhoRodape($tpl_pagina);

		$tpl = new HTML_Template_Sigma($this->root_path.'template');
		$tpl->loadTemplateFile('rodape.tpl');

		$tpl->setVariable(array(
			'conteudo'  => " "
		));

		$tpl_pagina->setVariable(array(
			'conteudo_topo' => "<img alt='' src='images/topo_login2.png'>",
			'rodape'  => $tpl->get()
		));
		$tpl_pagina->parse("adicionar_conteudo_topo");

		return $tpl_pagina;
	}


	public function fechar($tpl)
	{
		$alertasBO = new AlertasBO();
		$urlBO = new URLBO();

		$tpl->parse("body");

		$urlBO->receberAlertas();

		$alertasBO->preencheAlertas($tpl);

		$tpl->show();
	}


	private function getSaldacao()
	{
		date_default_timezone_set('America/Sao_Paulo');
		$hora = date('H');
		if( $hora >= 6 && $hora < 12 )
			$return = 'Bom dia';
		else if ( $hora > 12 && $hora < 18 )
			$return = 'Boa tarde';
		else
			$return = 'Boa noite';

		return $return;
	}
}
?>