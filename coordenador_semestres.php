<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/monitoresBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';

require_once 'HTML/Template/Sigma.php';

define('CAMINHO_UPLOAD_ARQUIVO', $ROOT_PATH."upload/");

$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();


$coordenador = $autenticacaoBO->verificarCoordenador();

$semestre = $semestresBO->retornaUltimoSemestre();

$novo = false;

if($_POST) {
	$semestre_alterar = new stdClass();
	$semestre_alterar->ano = $_POST['ano'];
	$semestre_alterar->semestre = $_POST['semestre'];
	$semestre_alterar->inicio = $_POST['inicio'];
	$semestre_alterar->fim = $_POST['fim'];

	$novo = $semestresBO->inserirAtualizar($semestre, $semestre_alterar);

	$disciplinas_juntas = Array();

	foreach($_POST as $key => $value) {
		if(strpos($key, "dis_junt_") !== false && strpos($key, "dis_junt_") == 0) {
			$array_disc = explode("-", $value);

			if (!isset($disciplinas_juntas[$array_disc[0]]) || !is_array($disciplinas_juntas[$array_disc[0]])) {
				$disciplinas_juntas[$array_disc[0]] = Array();
			}
			$disciplinas_juntas[$array_disc[0]][$array_disc[1]] = 0;

			if (!isset($disciplinas_juntas[$array_disc[1]]) || !is_array($disciplinas_juntas[$array_disc[1]])) {
				$disciplinas_juntas[$array_disc[1]] = Array();
			}
			$disciplinas_juntas[$array_disc[1]][$array_disc[0]] = 0;
		} else if(strpos($key, "dis_so_") !== false && strpos($key, "dis_so_") == 0) {
			$disciplinas_juntas[$value] = TRUE;
		}
	}

	if(isset($_FILES["arquivo_sigra"]) && strlen($_FILES["arquivo_sigra"]["tmp_name"])) {
		$caminho_origem = $_FILES["arquivo_sigra"]["tmp_name"];
		$caminho_destino = CAMINHO_UPLOAD_ARQUIVO.str_replace(' ','_',$_FILES["arquivo_sigra"]["name"]);
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$caminho_origem = str_replace('/','\\',$caminho_origem);
			$caminho_destino = str_replace('/','\\',$caminho_destino);
		}
		if (!move_uploaded_file($caminho_origem, $caminho_destino)) {
			$ALERTAS["SEMAEE"] = "";
		}
	}

	$semestre = $semestresBO->retornaUltimoSemestre();

	$turmasBO = new TurmasBO();

	if($novo) {
		$pessoasBO = new PessoasBO();
		$pessoasBO->zerarCodigoMoodle();

		$monitoresBO = new MonitoresBO();
		$monitoresBO->desativarMonitores();

		$turmasBO->atualizacaoTurmasInicioSemestre($semestre, $disciplinas_juntas);
	} else {
		$turmasBO->atualizacaoTurmasInicioSemestre($semestre);
	}
}

$templateBO = new TemplateBO();
$tpl_main = $templateBO->carregarPaginaCoordenadorSemestres();

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('coordenador_semestres.tpl');

$templateBO->iniciarCoordenadorSemestres($tpl);

$semestresBO->preencheFormularioCoordenadorSemestres($tpl, $semestre);

$disciplinasBO = new DisciplinasBO();
$disciplinasBO->preencheCombosCoordenadorSemestre($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>