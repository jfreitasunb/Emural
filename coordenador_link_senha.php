<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$pessoasBO = new PessoasBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

$link_mudanca_senha = null;
$nome = null;
$email = null;
if($_POST) {
	
	$email = strtolower(trim($_POST['email']));

    try
    {
        $PDO = new PDO( 'pgsql:host=' . $BANCO['host'] . ';dbname=' . $BANCO['dbname'] .';user=' . $BANCO['user']. ';password=' . $BANCO['password'] );
    }
    catch ( PDOException $e )
    {
        echo 'Erro ao conectar com o Postgres: ' . $e->getMessage();
    }

    $stm = $PDO->prepare("SELECT pes_cpes, pes_nome, pes_smud, pes_eval, pes_econ FROM pessoas WHERE pes_emai = :email");

    $stm->bindParam( ':email', $email );
    
    $stm->execute();
    
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        

        if (!$rows[0]['pes_eval']) {

            $update_link = $PDO->prepare("UPDATE pessoas SET pes_eval = TRUE, pes_econ = NULL WHERE pes_emai = :email");

            $update_link->bindParam(':email', $email, PDO::PARAM_STR );

            $pessoa = $pessoasBO->retornaPorCodigo($codigo);

            $moodleBO = new MoodleBO();

            $moodleBO->usuarioAtualizar($pessoa);

            $update_link->execute();
        }

        $nome = $rows[0]['pes_nome'];
        
        $codigo = $rows[0]['pes_cpes'];

        $confirmacao = $CONCATENACAO_VALIDACAO_EMAIL.$codigo.date("d-m-Y H:i:s:u");

        $senha_mudanca = md5($confirmacao);

        $update_link = $PDO->prepare("UPDATE pessoas SET pes_smud = :senha_mudanca WHERE pes_emai = :email");

        $update_link->bindParam(':email', $email, PDO::PARAM_STR );

        $update_link->bindParam(':senha_mudanca', $senha_mudanca, PDO::PARAM_STR );
    
        $update_link->execute();

        $pessoa = $pessoasBO->retornaPorCodigo($codigo);

        $moodleBO = new MoodleBO();

        $moodleBO->usuarioAtualizar($pessoa);

        $link_mudanca_senha = $SITE."esqueci_senha?esqueci=".$senha_mudanca.$rows[0]['pes_cpes'];
    }else{
        $ALERTAS['EMNC'] = "";
    }
}

$tpl_main = $templateBO->carregarPaginaCoordenadorLinkSenha();

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('coordenador_link_senha.tpl');
$tpl->setVariable(array(
    "link_mudanca_senha"  => $link_mudanca_senha,
    "nome" => $nome,
    "email" => $email,
));


$templateBO->iniciarCoordenadorSenha($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get(),
));

$templateBO->fechar($tpl_main);
?>
