<?php

require_once $ROOT_PATH."lib/linkBO.php";
require_once $ROOT_PATH."lib/phpmailer.inc.php";
require_once dirname(__FILE__)."/seguranca.php";

class EmailBO
{
	private function enviar($subject, $text, $from, $from_name, $to)
	{
		global $SMTP;

		$to_validado = seg_validar_email($to);
		$from_validado = seg_validar_email($from);
		if ($to_validado === false || $from_validado === false) {
			return false;
		}

		// Evita injeção de cabeçalhos em assunto e nome do remetente.
		$subject = preg_replace('/[\r\n\0]+/', ' ', (string) $subject);
		$from_name = preg_replace('/[\r\n\0]+/', ' ', (string) $from_name);

		$mail = new phpmailer();
		$mail->MailerDebug = false;
		$mail->AddAddress($to_validado);

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = $SMTP["host"];  // specify main and backup server
		$mail->WordWrap = $SMTP["wordWrap"];    // set word wrap

		$mail->IsHTML(true);    // set email format to HTML
		$mail->Subject = $subject;
		$mail->From = $from_validado;
		$mail->FromName = $from_name;
		$mail->Body = $text;

		return $mail->Send();
	}


	public function enviarValidacao($pessoa)
	{
		global $EMAIL_VALIDACAO_ORIGEM, $SITE, $SITEM;

		$linkBO = new LinkBO();

		$from = $EMAIL_VALIDACAO_ORIGEM;
		$from_name = "E-mural";
		$to = $pessoa->email;
		$subject = "Confirmação de email";
		$link_confirmacao = h($linkBO->getEmailConfirmacaoExterno($pessoa));
		$text = 'Prezado '.h($pessoa->nome).'<br><br>Para confirmar esse email como o email de acesso da matricula: '.h($pessoa->usuario).' ao <a href="'.h($SITE).'" target="_blank">E-mural</a> e ao <a href="'.h($SITEM).'" target="_blank">MoodleMat</a>, entre neste <a href="'.$link_confirmacao.'" target="_blank">'.$link_confirmacao.'</a>';

		$this->enviar($subject, $text, $from, $from_name, $to);
	}


	public function enviarEsqueciSenha($pessoa, $tipo = null)
	{
		global $EMAIL_VALIDACAO_ORIGEM, $SITE;

		$linkBO = new LinkBO();

		$from = $EMAIL_VALIDACAO_ORIGEM;
		$from_name = "E-mural";
		$to = $pessoa->email;
		$subject = "Esqueci a senha";

		$link_esqueci = h($linkBO->getEsqueciSenhaFormularioMudarSenhaExterno($pessoa, $tipo));
		$text  = 'Prezado '.h($pessoa->nome).'<br><br>Foi feito um pedido de mudança de senha na sua conta no mat.unb.br.<br>';
		$text .= 'Para redefinir a senha, entre neste link:  <a href="'.$link_esqueci.'" target="_blank">'.$link_esqueci.'</a><br><br>';
		$text .= 'Caso não tenha pedido a mudança de senha ignore esse email.';

		$this->enviar($subject, $text, $from, $from_name, $to);
	}
}
