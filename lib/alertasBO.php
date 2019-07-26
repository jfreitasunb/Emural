<?php

require_once 'HTML/Template/Sigma.php';

class AlertasBO
{
	private $lista;


	function __construct()
	{
		$alerta['tipo'] = "error";
		$alerta['mensagem'] = "Nova senha e confirmação de nova senha não conferem.";
		$this->lista['SNI'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "error";
		$alerta['mensagem'] = "Senha não confere.";
		$this->lista['SNC'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Senha alterada com sucesso.";
		$this->lista['SAS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "error";
		$alerta['mensagem'] = "Login e senha não conferem.";
		$this->lista['LSNC'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Avaliação salva com sucesso.";
		$this->lista['AVASS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Aviso inserido com sucesso.";
		$this->lista['AVIIS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Aviso salvo com sucesso.";
		$this->lista['AVISS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Aviso excluido com sucesso.";
		$this->lista['AVIES'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Médias, menções e faltas atualizadas com sucesso.";
		$this->lista['MMFAS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Novo semestre cadastrado com sucesso.";
		$this->lista['SEMIS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Semestre atualizado com sucesso.";
		$this->lista['SEMAS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "error";
		$alerta['mensagem'] = "Não podem ser cadastrados semestres mais antigos que o atual.";
		$this->lista['SEMMAA'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "error";
		$alerta['mensagem'] = "Erro ao enviar arquivo.";
		$this->lista['SEMAEE'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Monitor cadastrado com sucesso.";
		$this->lista['MONIS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Monitor atualizado com sucesso.";
		$this->lista['MONAS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Monitor excluido com sucesso.";
		$this->lista['MONES'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Turma configurada com sucesso.";
		$this->lista['TCS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Turma reconfigurada com sucesso.";
		$this->lista['TRS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Email cadastrado com sucesso. Um email de confirmação foi enviado.";
		$this->lista['ECAC'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Email confirmado com sucesso.";
		$this->lista['ECS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "error";
		$alerta['mensagem'] = "Link para confirmação de email inválido";
		$this->lista['ECE'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Realize o login para usar o E-mural";
		$this->lista['UNL'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Email não confirmado, confirme o email ou reenvie o email de confirmação.";
		$this->lista['ENCON'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Não possui email cadastrado, favor cadastrar email para acessar o emural e o moodle.";
		$this->lista['ENCAD'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Email já está sendo usado, cadastre outro ou procure o coordenador.";
		$this->lista['EJU'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Este email já está cadastrado e confirmado como o seu email de contato.";
		$this->lista['EJCC'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "O campo \"Matricula\" não pode ficar vazio.";
		$this->lista['ESMV'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "O campo \"E-mail\" não pode ficar vazio.";
		$this->lista['ESEV'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Matricula e E-mail não conferem.";
		$this->lista['ESMENC'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "Para usuários que não são alunos, mudar a senha pelo SI.";
		$this->lista['ESUNA'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "success";
		$alerta['mensagem'] = "Enviado e-mail para mudança de senha.";
		$this->lista['ESEEMS'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "O campo \"Senha\" não pode ficar vazio.";
		$this->lista['ESSV'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "O campo \"Confirmar Senha\" não pode ficar vazio.";
		$this->lista['ESCSV'] = $alerta;
		unset($alerta);

		$alerta['tipo'] = "warning";
		$alerta['mensagem'] = "O Senha e o Confirmar Senha devem ser iguais.";
		$this->lista['ESSD'] = $alerta;
		unset($alerta);
	}


	public function preencheAlertas($tpl_main)
	{
		GLOBAL $ROOT_PATH, $ROOT, $ALERTAS;

		$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
		$tpl->loadTemplateFile('alertas.tpl');

		if($ALERTAS !== null && count($ALERTAS)) {
			foreach($ALERTAS as $key => $dados)
			{
				if(isset($dados->link)) {
					$tpl->setVariable(array(
						'link'  => $dados->link,
					));
				}
				$tpl->setVariable(array(
					'tipo'  => $this->lista[$key]['tipo'],
					'mensagem' => $this->lista[$key]['mensagem']
				));
				$tpl->parse("adcionar_alerta");
			}
		}

		$tpl->setVariable(array(
			'ROOT'  => $ROOT
		));

		$tpl_main->setVariable(array(
			"conteudo"  => $tpl->get()
		));
		$tpl_main->parse("body");
	}


	public function getAlertas()
	{
		return $this->lista;
	}
}
?>