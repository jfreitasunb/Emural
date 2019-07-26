<?php

require_once $ROOT_PATH."persistencia/avaliacoesDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';
require_once $ROOT_PATH.'lib/alunosBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';

class AvaliacoesBO extends BO
{
	function __construct()
	{
		$this->DAO = & new AvaliacoesDAO();
	}


	public function preencherTurmaMenu($tpl,$turma)
	{
		$linkBO = & new LinkBO();

		$lista_avaliacoes = & $this->retornaAvaliacoesDeTurma($turma);

		//echo count($lista_avaliacoes)."<br><br>";
		//print_r($lista_avaliacoes);
		if(count($lista_avaliacoes)) {
			foreach($lista_avaliacoes as $avaliacao)
			{
				$avaliacao_preenche->nome = $avaliacao->nome;
				$avaliacao_preenche->link = $linkBO->getAvaliacao($avaliacao);

				$this->preencherObjeto($tpl,$avaliacao_preenche,"avaliacao_","adicionar_avaliacao");
			}
		}
		return count($lista_avaliacoes);
	}


	public function inserirAvaliacoesQuantidade($turma,$avaliacoes_novas,$manter_avaliacoes)
	{
		$inserir["turma"] = $turma->codigo;

		$peso = array();

		if($manter_avaliacoes) {
			$lista_avaliacoes = & $this->retornaAvaliacoesDeTurma($turma);

			foreach($lista_avaliacoes as $avaliacao)
			{
				$avaliacoes_antigas[$avaliacao->nome_resumido] = $avaliacao;
			}
		}

		foreach($avaliacoes_novas as $descricao => $quantidade)
		{
			//print_r($avaliacoes);
			$inserir["tipo"] = substr(mb_strtolower($descricao,mb_detect_encoding($descricao)),0,20);
			if($quantidade > 1) {
				for($i = 1; $i <= $quantidade; $i++)
				{
					$nome_resumido = $descricao."_".$i;
					$inserir["nome"] = $descricao." ".$i;
					$inserir["nome_resumido"] = $nome_resumido;

					if($manter_avaliacoes && isset($avaliacoes_antigas[$nome_resumido])) {
						unset($avaliacoes_antigas[$nome_resumido]);
					} else {
						$this->DAO->inserir($inserir);
					}
					//print_r($inserir);
					$peso[$nome_resumido] = 1;
				}
			} else {
				$nome_resumido = $descricao."_1";
				$inserir["nome"] = $descricao;
				$inserir["nome_resumido"] = $nome_resumido;

				if($manter_avaliacoes && isset($avaliacoes_antigas[$nome_resumido])) {
					unset($avaliacoes_antigas[$nome_resumido]);
				} else {
					$this->DAO->inserir($inserir);
				}
				//print_r($inserir);
				$peso[$nome_resumido] = 1;
			}
		}

		if($manter_avaliacoes) {
			foreach($avaliacoes_antigas as $avaliacao)
			{
				$this->removerAvaliacao($avaliacao);
			}
		}

		return $peso;
	}


	public function inserirAvaliacoesRapido($turma,$datas,$manter_avaliacoes)
	{
		$inserir["turma"] = $turma->codigo;

		$peso = array();

		if($manter_avaliacoes) {
			$lista_avaliacoes = & $this->retornaAvaliacoesDeTurma($turma);

			foreach($lista_avaliacoes as $avaliacao)
			{
				$avaliacoes_antigas[$avaliacao->nome_resumido] = $avaliacao;
			}
		}

		foreach($datas as $descricao => $data)
		{
			$inserir["tipo"] = substr(mb_strtolower(substr($descricao,0,strlen($descricao) - 2),mb_detect_encoding($descricao)),0,20);
			$inserir["nome"] = str_replace('_',' ',$descricao);
			$inserir["nome_resumido"] = $descricao;
			$inserir["data_realizacao"] = $data;

			if($manter_avaliacoes && isset($avaliacoes_antigas[$descricao])) {
				$filtro["codigo"] = $avaliacoes_antigas[$descricao]->codigo;
				$update["data_realizacao"] = $data;

				$this->DAO->updateCamposDeFiltro($update, $filtro);

				unset($avaliacoes_antigas[$descricao]);
			} else {
				$this->DAO->inserir($inserir);
			}
			//print_r($inserir);echo"<br><br><br>";
			$peso[$descricao] = 1;
		}

		if($manter_avaliacoes) {
			foreach($avaliacoes_antigas as $avaliacao)
			{
				removerAvaliacao($avaliacao);
			}
		}

		return $peso;
	}


	public function inserirMediaPonderada($turma,$peso,$manter_avaliacoes)
	{
		$avaliacoes = array();
		foreach($peso as $descricao => $peso_valor)
		{
			$descricao = substr($descricao,0,strrpos($descricao,"_"));

			if (array_key_exists($descricao, $avaliacoes)) {
				$avaliacoes[$descricao] = $avaliacoes[$descricao] + 1;
			} else {
				$avaliacoes[$descricao] = 1;
			}
		}

		$peso2 = array();
		foreach($peso as $descricao => $peso_valor)
		{
			$numero = substr($descricao,strrpos($descricao,"_")+1);
			$descricao = substr($descricao,0,strrpos($descricao,"_"));

			if ($avaliacoes[$descricao] == 1) {
				$peso2[$descricao."_1"] = $peso_valor;
			} else {
				$peso2[$descricao."_".$numero] = $peso_valor;
			}
		}

		$this->inserirAvaliacoesQuantidade($turma,$avaliacoes,$manter_avaliacoes);

		return $peso2;
	}


	public function preencheTabelaAvaliacoes($tpl,$turma,$avaliacao_atual = null,$tipo = "padrao")
	{
		if($turma !== null) {
			$notasBO = & new NotasBO();
			$composicaoTurmasBO = & new ComposicaoTurmasBO();

			$existe_observacao = false;
			$existe_medias_mencoes = false;
			$medias_mencoes_editavel = false;
			$media_notas_provas = false;

			switch ($tipo) {
				case "avaliacao":
					$existe_observacao = true;
					$media_notas_provas = true;
					break;
				case "medias_mencoes":
					$medias_mencoes_editavel = true;
					$media_notas_provas = true;
				case "medias_mencoes_sl":
					$existe_medias_mencoes = true;
					break;
				default:
					$existe_observacao = false;
					$existe_medias_mencoes = false;
					break;
			}

			$filtro["turma"] = $turma->codigo;
			$filtro["status"] = "true";

			$ordem["data_realizacao"] = "ASC";
			$ordem["nome"] = "ASC";

			$lista_avaliacoes = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

			$matriculados = $composicaoTurmasBO->retornaAlunosMatriculados($turma);

			foreach($matriculados as $aluno)
			{
				$id = $aluno->codigo_aluno;
				$lista_alunos->$id = $aluno;
				$lista_alunos->$id->provas = "";
			}

			foreach($lista_avaliacoes as $avaliacao)
			{
				$avaliacao_preenche->titulo = $avaliacao->nome;

				$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");

				$lista_notas = $notasBO->retornaNotasDeAvaliacao($avaliacao);

				$id_avaliacao = $avaliacao->codigo;
				if(count($lista_notas)) {
					foreach($lista_notas as $nota_aluno)
					{
						$id_aluno = $nota_aluno->aluno;
						$lista_alunos->$id_aluno->provas->$id_avaliacao->nota = $nota_aluno->valor;
						$lista_alunos->$id_aluno->provas->$id_avaliacao->observacao = $nota_aluno->observacao;
					}
				}
			}

			if($existe_observacao) {
				$avaliacao_preenche->titulo = "Mensagem para o aluno";

				$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");
			}

			if($existe_medias_mencoes) {
				$avaliacao_preenche->titulo = "Média";
				$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");

				$avaliacao_preenche->titulo = "Menção";
				$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");

				$avaliacao_preenche->titulo = "Faltas";
				$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");

				$avaliacao_preenche->titulo = "Faltas %";
				$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");

				if($medias_mencoes_editavel) {
					$avaliacao_preenche->titulo = "Atualizar Média";
					$this->preencherObjeto($tpl,$avaliacao_preenche,"celula_","adicionar_celula_titulo");
				}

				$tipo_mencao[] = "SR";
				$tipo_mencao[] = "II";
				$tipo_mencao[] = "MI";
				$tipo_mencao[] = "MM";
				$tipo_mencao[] = "MS";
				$tipo_mencao[] = "SS";
			}

			if($media_notas_provas) {
				$soma_notas = array();
				$quantidade_alunos = array();
			}

			foreach($lista_alunos as $aluno)
			{
				$tpl->setVariable(array(
					"aluno_matricula"  => $aluno->matricula,
					"aluno_nome"  => $aluno->nome,
					"aluno_prova_obs_id"  => "obs_".$aluno->codigo_aluno
				));

				foreach($lista_avaliacoes as $avaliacao)
				{
					$id_avaliacao = $avaliacao->codigo;

					if(isset($aluno->provas->$id_avaliacao->nota)) {
						$nota = $aluno->provas->$id_avaliacao->nota;
					} else {
						$nota = "0";
					}

					if($media_notas_provas) {
						if(!isset($soma_notas[$id_avaliacao])) {
							$soma_notas[$id_avaliacao] = 0;
							$quantidade_alunos[$id_avaliacao] = 0;
						}

						$soma_notas[$id_avaliacao] += $nota;
						$quantidade_alunos[$id_avaliacao]++;
					}

					if(isset($avaliacao_atual->codigo) && $avaliacao_atual->codigo == $id_avaliacao) {
						$tpl->setVariable(array(
							"celula_corpo"  => "<input type='text' name='codigo_".$aluno->codigo_aluno."' class='validate[max[10],min[0],custom[number]] nota' id='codigo_".$aluno->codigo_aluno."' value='".$nota."' size='10' autocomplete='off' tabindex=1/>"
						));
					} else {
						if(!strlen($nota)) {
							$nota = "N/L";
						}
						$tpl->setVariable(array(
							"celula_corpo"  => $nota
						));
					}
					$tpl->parse("adicionar_celula_corpo");

					if($existe_observacao) {
						if(isset($avaliacao_atual->codigo) && $avaliacao_atual->codigo == $id_avaliacao) {
							if(isset($aluno->provas->$id_avaliacao->observacao)) {
								$observacao = $aluno->provas->$id_avaliacao->observacao;
							} else {
								$observacao = "";
							}
						}
					}
				}
				if($existe_observacao) {
					$tpl->setVariable(array(
						"celula_corpo"  => "<input type='text' name='obs_".$aluno->codigo_aluno."' id='obs_".$aluno->codigo_aluno."' value='".$observacao."' size='30' autocomplete='off' tabindex=2/>"
					));
					$tpl->parse("adicionar_celula_corpo");
				}

				if($existe_medias_mencoes) {
					if(strlen($aluno->mencao) == 0) {
						$aluno_obj->codigo = $aluno->aluno;
						$nota_final = $notasBO->retornaMediaMencao($turma,$aluno_obj);
						$nota_final["faltas"] = 0;
						$nota_final["porcentagem_faltas"] = 0;
					} else {
						if(strlen($aluno->media)) {
							$nota_final["media"] = $aluno->media;
						} else {
							$nota_final["media"] = 0;
						}

						if(strlen($aluno->mencao)) {
							$nota_final["mencao"] = $aluno->mencao;
						} else {
							$nota_final["mencao"] = "SR";
						}

						if(strlen($aluno->faltas)) {
							$nota_final["faltas"] = $aluno->faltas;
						} else {
							$nota_final["faltas"] = 0;
						}

						if(strlen($aluno->porcentagem_faltas)) {
							$nota_final["porcentagem_faltas"] = $aluno->porcentagem_faltas;
						} else {
							$nota_final["porcentagem_faltas"] = 0;
						}
					}

					if($medias_mencoes_editavel) {
						$tpl->setVariable(array(
							"celula_corpo"  => "<input type='text' name='media_".$aluno->codigo_aluno."' id='media_".$aluno->codigo_aluno."' value='".$nota_final["media"]."' class='validate[required,max[10],min[0],custom[number]] media' size='5' autocomplete='off' tabindex=1/>"
						));
						$tpl->parse("adicionar_celula_corpo");

						$celula_corpo = "<select size='1' name='mencao_".$aluno->codigo_aluno."' id='mencao_".$aluno->codigo_aluno."' tabindex=2>";
						foreach($tipo_mencao as $mencao)
						{
							$celula_corpo .= "<option value='$mencao'";
							if($mencao == $nota_final["mencao"]) {
								$celula_corpo .= " selected='selected'";
							}
							$celula_corpo .= ">$mencao</option>";
						}
						$celula_corpo .= "</select>";

						$tpl->setVariable(array(
							"celula_corpo"  => $celula_corpo
						));
						$tpl->parse("adicionar_celula_corpo");

						$tpl->setVariable(array(
							"celula_corpo"  => "<input type='text' name='faltas_".$aluno->codigo_aluno."' class='custom[integer] faltas' id='faltas_".$aluno->codigo_aluno."' value='".$nota_final["faltas"]."' size='5' autocomplete='off' tabindex=3/>"
						));
						$tpl->parse("adicionar_celula_corpo");

						$tpl->setVariable(array(
							"celula_corpo"  => $nota_final["porcentagem_faltas"]."%",
							"celula_id" => "porcentagem_faltas_".$aluno->codigo_aluno
						));
						$tpl->parse("adicionar_celula_corpo");

						$tpl->setVariable(array(
							"celula_corpo"  => "<button type='button' class='atualizar_mencao' id='".$aluno->codigo_aluno."'>Atualizar Média</button>"
						));
						$tpl->parse("adicionar_celula_corpo");
					} else {
						$tpl->setVariable(array(
							"celula_corpo"  => $nota_final["media"]
						));
						$tpl->parse("adicionar_celula_corpo");

						$tpl->setVariable(array(
							"celula_corpo"  => $nota_final["mencao"]
						));
						$tpl->parse("adicionar_celula_corpo");

						$tpl->setVariable(array(
							"celula_corpo"  => $nota_final["faltas"]
						));
						$tpl->parse("adicionar_celula_corpo");

						$tpl->setVariable(array(
							"celula_corpo"  => $nota_final["porcentagem_faltas"]."%"
						));
						$tpl->parse("adicionar_celula_corpo");
					}

					if($media_notas_provas) {
						if(!isset($soma_notas["media"])) {
							$soma_notas["media"] = 0;
							$quantidade_alunos["media"] = 0;
						}

						$soma_notas["media"] += $nota_final["media"];
						$quantidade_alunos["media"]++;
					}
				}
				$tpl->parse("adicionar_linha");
			}

			if($media_notas_provas) {
				$lista[0]['celula_rodape'] = $lista[1]['celula_rodape'] = "Média Notas";

				$this->preencherLista($tpl, $lista, null, "adicionar_celula_rodape");

				unset($lista);

				foreach($soma_notas as $id => $soma_nota)
				{
					$obj['celula_rodape'] = round($soma_nota/$quantidade_alunos[$id],2);
					$this->preencherObjeto($tpl, $obj, null, "adicionar_celula_rodape");
				}

				if($existe_observacao) {
					$lista[0]['celula_rodape'] = "";
	
					$this->preencherLista($tpl, $lista, null, "adicionar_celula_rodape");
				}

				if($medias_mencoes_editavel) {
					$lista[0]['celula_rodape'] = "";
	
					$this->preencherLista($tpl, $lista, null, "adicionar_celula_rodape");
				}

				if($existe_medias_mencoes) {
					$lista[0]['celula_rodape'] = $lista[1]['celula_rodape'] = $lista[2]['celula_rodape'] = "";
	
					$this->preencherLista($tpl, $lista, null, "adicionar_celula_rodape");
				}
			}
		}
	}


	public function preenchePaginaAvaliacao($tpl,$turma,$avaliacao_atual)
	{
		$filtro["turma"] = $turma->codigo;
		$filtro["status"] = "true";

		$ordem["data_realizacao"] = "ASC";
		$ordem["nome"] = "ASC";

		$lista_avaliacoes = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		$atual = 2;
		$anterior = true;
		//print_r($lista_avaliacoes);
		foreach($lista_avaliacoes as $avaliacao)
		{
			$avaliacao_preenche->nome = $avaliacao->nome;

			$this->preencherObjeto($tpl,$avaliacao_preenche,"tabela_prova_","adicionar_tabela_prova_nome");

			if($avaliacao_atual->codigo != $avaliacao->codigo) {
				$avaliacao_check->nome = $avaliacao->nome;
				$avaliacao_check->id = $atual;
				if($anterior) {
					$avaliacao_check->checked = "checked";
				} else {
					$avaliacao_check->checked = "";
				}
				$this->preencherObjeto($tpl,$avaliacao_check,"prova_checkbox_","adicionar_prova_checkbox");
			} else {
				$anterior = false;
			}
			$atual++;
		}

		$avaluacao_preencher->nome = $avaliacao_atual->nome;
		if(strlen($avaliacao_atual->data_divulgacao)) {
			$avaluacao_preencher->data_divulgacao = $avaliacao_atual->data_divulgacao;
		} else {
			$avaluacao_preencher->data_divulgacao = date("d/m/Y");
		}
		$avaluacao_preencher->data_realizacao = $avaliacao_atual->data_realizacao;

		//echo $avaliacao->divulgacao;
		if(strcmp($avaliacao_atual->divulgacao,"t") == 0) {
			$avaluacao_preencher->divulgar = "checked";
		}

		$this->preencherObjeto($tpl,$avaluacao_preencher,"avaliacao_");
	}


	public function atualizarDatas($avaliacao,$avaliacao_atualizar)
	{
		$campos["data_realizacao"] = $avaliacao_atualizar->data_realizacao;
		$campos["data_divulgacao"] = $avaliacao_atualizar->data_divulgacao;
		$campos["divulgacao"] = $avaliacao_atualizar->divulgacao;

		$filtro["codigo"] = $avaliacao->codigo;

		$this->DAO->updateCamposDeFiltro($campos,$filtro);
	}


	public function preencheCombo($tpl,$turma,$responsavel)
	{
		$filtro["turma"] = $turma->codigo;
		$filtro["status"] = "true";

		$ordem["nome"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		foreach($lista_obj as $obj)
		{
			$preenche->valor = $obj->codigo;
			$preenche->descricao = $obj->nome;

			if($responsavel != null && $responsavel->avaliacao == $obj->codigo) {
				$preenche->selected = "selected";
			} else {
				unset($preenche->selected);
			}
			
			$this->preencherObjeto($tpl,$preenche,"avaliacao_combo_","adcionar_avaliacao_combo");
		}
	}


	public function preencheCheckAvaliacoes($tpl,$turma,$bt_atualizar_media = false)
	{
		$filtro["turma"] = $turma->codigo;
		$filtro["status"] = "true";

		$ordem["data_realizacao"] = "ASC";
		$ordem["nome"] = "ASC";

		$lista_avaliacoes = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		$obj_avaliacao_check->nome = "Matricula";
		$obj_avaliacao_check->id = 0;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;

		unset($obj_avaliacao_check);

		$obj_avaliacao_check->nome = "Nome";
		$obj_avaliacao_check->id = 1;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;

		unset($obj_avaliacao_check);

		$atual = 2;
		//print_r($lista_avaliacoes);
		foreach($lista_avaliacoes as $avaliacao)
		{
			$obj_avaliacao_check->nome = $avaliacao->nome;
			$obj_avaliacao_check->id = $atual;
			$obj_avaliacao_check->checked = "checked";

			$avaliacao_check[] = $obj_avaliacao_check;

			unset($obj_avaliacao_check);

			$atual++;
		}

		$obj_avaliacao_check->nome = "Média";
		$obj_avaliacao_check->id = $atual;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;

		unset($obj_avaliacao_check);

		$atual++;

		$obj_avaliacao_check->nome = "Menção";
		$obj_avaliacao_check->id = $atual;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;

		unset($obj_avaliacao_check);

		$atual++;

		$obj_avaliacao_check->nome = "Faltas";
		$obj_avaliacao_check->id = $atual;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;

		unset($obj_avaliacao_check);

		$atual++;

		$obj_avaliacao_check->nome = "Faltas %";
		$obj_avaliacao_check->id = $atual;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;

		if($bt_atualizar_media) {

		unset($obj_avaliacao_check);

		$atual++;

		$obj_avaliacao_check->nome = "Atualizar Média";
		$obj_avaliacao_check->id = $atual;
		$obj_avaliacao_check->checked = "checked";
		$avaliacao_check[] = $obj_avaliacao_check;
		}
		$this->preencherLista($tpl,$avaliacao_check,"prova_checkbox_","adicionar_prova_checkbox");
	}


	public function retornaArrayAlunosProvasMedia($turma)
	{
		$notasBO = & new NotasBO();
		$composicaoTurmasBO = & new ComposicaoTurmasBO();

		$matriculados = $composicaoTurmasBO->retornaAlunosMatriculados($turma);

		$aluno = null;
		foreach($matriculados as $value)
		{
			unset($aluno);

			$aluno["Matricula"] = $value->matricula;
			$aluno["Nome"] = $value->nome;

			$id_aluno = $value->codigo_aluno;

			$lista_alunos->$id_aluno = $aluno;
		}

		$filtro["turma"] = $turma->codigo;
		$filtro["status"] = "true";

		$ordem["data_realizacao"] = "ASC";
		$ordem["nome"] = "ASC";

		$lista_avaliacoes = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		foreach($lista_avaliacoes as $avaliacao)
		{
			$nome = $avaliacao->nome;

			$lista_notas = $notasBO->retornaNotasDeAvaliacao($avaliacao);

			$id_avaliacao = $avaliacao->codigo;
			if(count($lista_notas)) {
				$aluno = null;
				foreach($lista_notas as $nota_aluno)
				{
					unset($aluno);
					$id_aluno = $nota_aluno->aluno;

					$aluno = $lista_alunos->$id_aluno;
					$aluno[$nome] = $nota_aluno->valor;

					$lista_alunos->$id_aluno = $aluno;
				}
			} else {
				$aluno = null;
				foreach($lista_alunos as $key => $value)
				{
					unset($aluno);
					$aluno = $value;
					$aluno[$nome] = "N/L";

					$lista_alunos->$key = $aluno;
				}
			}
		}

		$aluno = null;
		foreach($matriculados as $value)
		{
			unset($aluno);
			$id_aluno = $value->codigo_aluno;

			$aluno = $lista_alunos->$id_aluno;
			$aluno["Média"] = $value->media;
			$aluno["Menção"] = $value->mencao;
			$aluno["Faltas"] = $value->faltas;
			$aluno["Faltas %"] = $value->porcentagem_faltas;

			$lista_alunos->$id_aluno = $aluno;
		}

		return $lista_alunos;
	}


	private function removerAvaliacao($avaliacao)
	{
		$filtro["codigo"] = $avaliacao->codigo;

		$campos["status"] = "false";

		$this->DAO->updateCamposDeFiltro($campos,$filtro);
	}


	public function removerAvaliacoes($turmas)
	{
		$filtro["turma"] = $turmas->codigo;

		$campos["status"] = "false";

		$this->DAO->updateCamposDeFiltro($campos,$filtro);
	}


	public function retornaAvaliacoesAplicadas($turma)
	{
		$ordem["nome"] = "ASC";

		$lista = & $this->DAO->recuperaAvaliacoesAplicadas($turma,$ordem);
		
		if(count($lista)) {
			return $lista;
		} else {
			return null;
		}
	}


	private function retornaAvaliacoesDeTurma($turma)
	{
		$filtro["turma"] = $turma->codigo;
		$filtro["status"] = "true";

		$ordem["data_realizacao"] = "ASC";
		$ordem["nome"] = "ASC";

		return $this->DAO->recuperaDeFiltro($filtro,$ordem);
	}
}
?>