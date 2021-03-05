<?php

// TODO: Colocar links relativos a essa variável
$ROOT = "/";
$ROOT_PATH = "/var/www/emural/";

$SITE = "http://192.168.122.62/";
$SITEM = "http://192.168.122.69/";
//$SITE = "http://127.0.0.1:8083/";

$CHARSET = "utf-8";

$BANCO["user"]     = "emural";
$BANCO["password"] = "estudos";
$BANCO["host"]     = "127.0.0.1";
$BANCO["dbname"]   = "emural";
$BANCO["dbport"]   = "5432";

$BANCOSI["user"]     = "si";
$BANCOSI["password"] = "estudos";
$BANCOSI["host"]     = "192.168.122.36";
$BANCOSI["dbname"]   = "si";
$BANCOSI["dbport"]   = "5432";

$SMTP ["host"] = "127.0.0.1";
$SMTP ["wordWrap"] = "70";

$EMAIL_VALIDACAO_ORIGEM = "informatica@mat.unb.br";

$CONCATENACAO_VALIDACAO_EMAIL = "string para concatenacao para geracao do codigo de validacao do email, essa string deve ser muito grande para garantir que o hast gerado não seja reversível.";

$SENHAS_CODIFICADAS = true;

$ALERTAS = null;

$TITULO = "E-mural - Mural Eletrônico de Notas do Departamento de Matemática - UnB";

$DEPARTAMENTO = "matematica";

$URL_MOODLE = "http://192.168.122.69";
$TOKEN_MOODLE = '412521a258356bd2f1acb1e2aa3c25cf';

$SERVICOS_MOODLE = array();
$SERVICOS_MOODLE["usuario_cadastrar"] = "core_user_create_users";
$SERVICOS_MOODLE["usuario_atualizar"] = "core_user_update_users";
$SERVICOS_MOODLE["curso_criar"] = "core_course_create_courses";
$SERVICOS_MOODLE["curso_matricular"] = "enrol_manual_enrol_users";
$SERVICOS_MOODLE["grupo_criar"] = "core_group_create_groups";
$SERVICOS_MOODLE["grupo_matricular"] = "core_group_add_group_members";
$SERVICOS_MOODLE["grupo_desmatricular"] = "core_group_delete_group_members";

?>
