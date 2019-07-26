<?php

class LinkBO
{
	private $root;


	function __construct()
	{
		GLOBAL $ROOT;

		$this->root = $ROOT;
	}


	public function getTurmaConfiguracao($turma)
	{
		return $this->root."turma_configuracao/".$turma->codigo;
	}


	public function getAvaliacao($avaliacao)
	{
		return $this->root."avaliacao/".$avaliacao->codigo;
	}


	public function getTurma($turma)
	{
		return $this->root."turma/".$turma->codigo;
	}


	public function getMediaMencao($turma)
	{
		return $this->root."medias_mencoes/".$turma->codigo;
	}


	public function getAvisos($turma,$observacao = null,$alertas = null)
	{
		$final = "";
		if($observacao !== null) {
			$final = "/".$observacao->codigo;
		}
		if(count($alertas)) {
			foreach ($alertas as $key => $value) {
				$final .= $key."&";
			}
			$final = "?".substr($final,0,strlen($final)-1);
		}

		return $this->root."avisos/".$turma->codigo.$final;
	}


	public function getDeletarAvisos($turma,$observacao = null)
	{
		$final = "";
		if($observacao !== null) {
			$final = "/".$observacao->codigo."?d";
		}

		return $this->root."avisos/".$turma->codigo.$final;
	}


	public function getMonitores($turma,$responsavel = null,$alertas = null)
	{
		$final = "";
		if($responsavel !== null) {
			$final = "/".$responsavel->codigo;
		}
		if(count($alertas)) {
			foreach ($alertas as $key => $value) {
				$final .= $key."&";
			}
			$final = "?".substr($final,0,strlen($final)-1);
		}

		return $this->root."monitores/".$turma->codigo.$final;
	}


	public function getDeletarMonitores($turma,$responsavel = null)
	{
		$final = "";
		if($responsavel !== null) {
			$final = "/".$responsavel->codigo."?d";
		}

		return $this->root."monitores/".$turma->codigo.$final;
	}


	public function getProfessor()
	{
		return $this->root."professor";
	}


	public function getAluno()
	{
		return $this->root."aluno";
	}


	public function getAlunoNotas()
	{
		return $this->root."notas";
	}


	public function getAlunoSenha()
	{
		return $this->root."alterar_senha";
	}


	public function getAlunoEmail($get = null)
	{
		$final = "";
		if($get){
			$final = "?";

			foreach($get as $key => $value)
			{
				$final .= $key;
				if (strlen($value)) {
					$final .= "=".$value;
				}
				$final .= "&";
			}

			$final = substr($final,0,strlen($final)-1);
		}

		return $this->root."alterar_email".$final;
	}


	public function getEmailConfirmacaoExterno($pessoa)
	{
		global $SITE;

		return $SITE."email_confirma?confirmacao=".$pessoa->email_confirmacao.$pessoa->codigo;
	}


	public function getEsqueciSenha()
	{
		return $this->root."esqueci_senha";
	}


	public function getEsqueciSenhaFormularioMudarSenhaExterno($pessoa, $tipo = null)
	{
		global $SITE;

		if ($tipo !== null && strcmp($tipo, "moodle") == 0) {
			$tipo = "moodle&";
		} else {
			$tipo = "";
		}

		return $SITE."esqueci_senha?".$tipo."esqueci=".$pessoa->senha_mudanca.$pessoa->codigo;
	}


	public function getSair()
	{
		return $this->root."sair";
	}


	public function getIndex($get = null)
	{
		$final = "";
		if($get){
			$final = "?";

			foreach($get as $key => $value)
			{
				$final .= $key;
				if (strlen($value)) {
					$final .= "=".$value;
				}
				$final .= "&";
			}

			$final = substr($final,0,strlen($final)-1);
		}
		return $this->root."index.php".$final;
	}


	public function getCoordenador()
	{
		return $this->root."coordenador";
	}


	public function getCoordenadorSemestre($alertas = null)
	{
		$final = "";
		if(count($alertas)) {
			foreach ($alertas as $key => $value) {
				$final .= $key."&";
			}
			$final = "?".substr($final,0,strlen($final)-1);
		}

		return $this->root."semestres".$final;
	}


	public function getCoordenadorSemestreNovo()
	{
		return $this->root."semestres?n";
	}


	public function getCoordenadorRevisaoMencoes($turma = null)
	{
		$final = "";
		if($turma !== null) {
			$final = "/".$turma->codigo;
		}
		return $this->root."revisao_mencoes".$final;
	}


	public function getCoordenadorSenha()
	{
		return $this->root."senha";
	}


	public function getCoordenadorAlunoSenha()
	{
		return $this->root."aluno_senha";
	}


	public function getCoordenadorAlunoEmail()
	{
		return $this->root."aluno_email";
	}


	public function getCoordenadorRelatorioPorcentagemMencoes()
	{
		return $this->root."relatorios/porcentagem_mencoes";
	}


	public function getCoordenadorRelatorioPorcentagemAprovados()
	{
		return $this->root."relatorios/porcentagem_aprovados";
	}


	public function getCoordenadorRelatorioListaAlunos()
	{
		return $this->root."relatorios/lista_alunos";
	}


	public function getCoordenadorRelatorioReprovadosDisciplina()
	{
		return $this->root."relatorios/reprovados_disciplina";
	}


	public function getRelatorioTurmaCSV($turma)
	{
		return $this->root."relatorios/turmaCSV/".$turma->codigo."/relatorio.csv";
	}


	public function getCoordenadorRelatorioPorcentagemMencoesCSV()
	{
		return $this->root."relatorios/porcentagem_mencoesCSV/relatorio.csv";
	}


	public function getCoordenadorRelatorioPorcentagemAprovadosCSV()
	{
		return $this->root."relatorios/porcentagem_aprovadosCSV/relatorio.csv";
	}


	public function getCoordenadorRelatorioListaAlunosCSV()
	{
		return $this->root."relatorios/lista_alunosCSV/relatorio.csv";
	}


	public function getMoodle()
	{
		GLOBAL $URL_MOODLE;

		return $URL_MOODLE;
	}
}
?>