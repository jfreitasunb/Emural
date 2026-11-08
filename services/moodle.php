<?php
/**
 * Integração com o Moodle: SOMENTE linha de comando (usado pelo cron).
 *
 * Uso:
 *   php services/moodle.php usuario_cadastrar --usuario=<codigo_pessoa>
 *   php services/moodle.php curso_criar       --turma=<codigo_turma>
 *   php services/moodle.php curso_matricular  --turma=<codigo_turma> --usuario=<codigo_pessoa>
 *
 * Códigos de saída: 0 = sucesso, 1 = uso incorreto, 2 = registro não
 * encontrado, 3 = erro na comunicação com o Moodle.
 */

// Nunca executa pela web.
if (PHP_SAPI !== 'cli') {
	header('HTTP/1.1 404 Not Found');
	exit;
}

$funcoes = array(
	'usuario_cadastrar' => array('usuario'),
	'curso_criar'       => array('turma'),
	'curso_matricular'  => array('turma', 'usuario'),
);

function moodle_cli_uso($funcoes, $mensagem = null)
{
	if ($mensagem !== null) {
		fwrite(STDERR, "Erro: ".$mensagem."\n\n");
	}

	fwrite(STDERR, "Uso: php ".basename(__FILE__)." <funcao> [--parametro=valor ...]\n\nFunções:\n");
	foreach ($funcoes as $nome => $parametros) {
		$lista = array();
		foreach ($parametros as $parametro) {
			$lista[] = "--".$parametro."=<codigo>";
		}
		fwrite(STDERR, "  ".str_pad($nome, 18).implode(" ", $lista)."\n");
	}

	exit(1);
}

// Lê os argumentos: o primeiro é a função; os demais, no formato --nome=valor.
$argumentos = isset($argv) ? array_slice($argv, 1) : array();

if (!count($argumentos)) {
	moodle_cli_uso($funcoes);
}

$funcao = array_shift($argumentos);

if (!isset($funcoes[$funcao])) {
	moodle_cli_uso($funcoes, "função desconhecida: ".$funcao);
}

$parametros = array();
foreach ($argumentos as $argumento) {
	if (!preg_match('/^--([a-z_]+)=(.*)$/', $argumento, $partes)) {
		moodle_cli_uso($funcoes, "argumento inválido: ".$argumento);
	}
	$parametros[$partes[1]] = $partes[2];
}

// Exige exatamente os parâmetros da função, todos inteiros positivos.
foreach ($funcoes[$funcao] as $obrigatorio) {
	if (!isset($parametros[$obrigatorio])) {
		moodle_cli_uso($funcoes, "parâmetro obrigatório ausente: --".$obrigatorio);
	}
	if (!ctype_digit($parametros[$obrigatorio]) || (int) $parametros[$obrigatorio] <= 0) {
		moodle_cli_uso($funcoes, "--".$obrigatorio." deve ser um número inteiro positivo");
	}
	$parametros[$obrigatorio] = (int) $parametros[$obrigatorio];
}

foreach ($parametros as $nome => $valor) {
	if (!in_array($nome, $funcoes[$funcao], true)) {
		moodle_cli_uso($funcoes, "parâmetro não usado por ".$funcao.": --".$nome);
	}
}

// Caminhos absolutos: no CLI, caminhos relativos seriam resolvidos a partir
// do diretório corrente do cron, e não da pasta deste arquivo.
require_once dirname(__FILE__).'/../conf/default.php';
require_once $ROOT_PATH.'lib/moodleBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';

$moodleBO = new MoodleBO();
$pessoasBO = new PessoasBO();
$turmasBO = new TurmasBO();

$pessoa = null;
$turma = null;

if (isset($parametros['usuario'])) {
	$pessoa = $pessoasBO->retornaPorCodigo($parametros['usuario']);
	if ($pessoa === null) {
		fwrite(STDERR, "Erro: pessoa ".$parametros['usuario']." não encontrada.\n");
		exit(2);
	}
}

if (isset($parametros['turma'])) {
	$turma = $turmasBO->retornaPorCodigo($parametros['turma']);
	if ($turma === null) {
		fwrite(STDERR, "Erro: turma ".$parametros['turma']." não encontrada.\n");
		exit(2);
	}
}

try {
	switch ($funcao) {
		case "usuario_cadastrar":
			$moodleBO->usuarioCadastrar($pessoa);
			break;

		case "curso_criar":
			$moodleBO->cursoCriar($turma);
			break;

		case "curso_matricular":
			$moodleBO->cursoMatricular($turma, $pessoa);
			break;
	}
} catch (Exception $e) {
	fwrite(STDERR, "Erro ao executar ".$funcao.": ".$e->getMessage()."\n");
	exit(3);
}

echo date('Y-m-d H:i:s')." ".$funcao." OK ".json_encode($parametros)."\n";
exit(0);
?>
