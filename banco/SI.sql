
SET statement_timeout = 0;
SET client_encoding = 'LATIN1';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;


CREATE TABLE disciplinas_mat (
    codigo integer NOT NULL,
    nome character varying(200),
    creditos integer,
    status character varying(5)
);


ALTER TABLE public.disciplinas_mat OWNER TO si;

CREATE TABLE disciplinas_mat_bibliografia (
    codigo integer,
    autor character varying(300),
    cidade character varying(50),
    edicao integer,
    titulo character varying(200),
    editora character varying(100),
    ano integer,
    item integer
);


ALTER TABLE public.disciplinas_mat_bibliografia OWNER TO si;


CREATE TABLE disciplinas_mat_programas (
    codigo integer NOT NULL,
    programa text,
    item integer
);


ALTER TABLE public.disciplinas_mat_programas OWNER TO si;


CREATE SEQUENCE disciplinas_mat_codigo_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.disciplinas_mat_codigo_seq OWNER TO si;


ALTER SEQUENCE disciplinas_mat_codigo_seq OWNED BY disciplinas_mat_programas.codigo;



SELECT pg_catalog.setval('disciplinas_mat_codigo_seq', 3, true);



CREATE TABLE disciplinas_mat_ementas (
    codigo integer,
    ementa text,
    item integer
);


ALTER TABLE public.disciplinas_mat_ementas OWNER TO si;


CREATE TABLE fonctionnaire (
    coduser integer NOT NULL,
    contract_date date,
    contract_type character(30),
    statut character varying(30),
    contract_end date
);


ALTER TABLE public.fonctionnaire OWNER TO si;




CREATE TABLE oferta_lista_de_ofertas (
    disciplina integer,
    turma character varying(2),
    turno character varying(7),
    professor integer,
    semestre integer,
    ano integer,
    horarios character varying(11)
);


ALTER TABLE public.oferta_lista_de_ofertas OWNER TO si;


CREATE TABLE profs (
    coduser integer NOT NULL,
    orientateur boolean,
    area_atuacao character varying(20),
    niveau_fonctionnel character varying(30),
    bolsista character varying(30),
    situacao character varying(15)
);


ALTER TABLE public.profs OWNER TO si;


CREATE TABLE student (
    coduser integer NOT NULL,
    coming_date date,
    depart_date1 date,
    speciality character varying(40),
    orientateur character varying(40),
    status character varying(20),
    formation character varying(40),
    bolsista character varying(30),
    matricul integer NOT NULL
);


ALTER TABLE public.student OWNER TO si;


CREATE TABLE unix (
    login character varying NOT NULL,
    passwd character varying,
    uid integer,
    gid integer,
    class character varying,
    gecos character varying,
    homedir character varying,
    shell character varying,
    coduser integer,
    cota_impressao character varying(10),
    cota_disco character varying(10),
    cota_mail character varying(10),
    tabela_user character varying(20),
    ssh character(3),
    erro_data bigint,
    erro smallint
);


ALTER TABLE public.unix OWNER TO si;


CREATE TABLE users (
    coduser integer NOT NULL,
    name character varying(60),
    firstname character varying(60),
    matricul character varying(15),
    cpf character varying(15),
    identity character varying(40),
    phone_work character varying(15),
    phone_home character varying(15),
    adresse character varying(100),
    cp character varying(10),
    city character varying(20),
    is_actif boolean,
    tipo_users character varying(40)
);


ALTER TABLE public.users OWNER TO si;


CREATE SEQUENCE users_coduser_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.users_coduser_seq OWNER TO si;


ALTER SEQUENCE users_coduser_seq OWNED BY users.coduser;


SELECT pg_catalog.setval('users_coduser_seq', 793, true);


ALTER TABLE users ALTER COLUMN coduser SET DEFAULT nextval('users_coduser_seq'::regclass);



COPY disciplinas_mat (codigo, nome, creditos, status) FROM stdin;
113107	ALGEBRA 1	4	grad
113131	ALGEBRA 2	4	grad
117145	ALGEBRA 3	4	grad
113123	ALGEBRA LINEAR	6	grad
113204	ANALISE 1	6	grad
113212	ANALISE 2	4	grad
117137	ANALISE 3	4	grad
113859	ANALISE DE ALGORITMOS	4	grad
113034	CALCULO 1	6	grad
113042	CALCULO 2	6	grad
113051	CALCULO 3	6	grad
113824	CALCULO DE PROBABILIDADE 1	6	grad
113417	CALCULO NUMERICO	4	grad
113301	EQUACOES DIFERENCIAIS 1	4	grad
113328	GEOMETRIA DIFERENCIAL 1	4	grad
113913	INTRODUCAO A CIEN COMPUTACAO	4	grad
113522	METODOS MATEMATICOS FISICA 1	6	grad
113069	VARIAVEL COMPLEXA 1	6	grad
113611	ALGEBRA PARA ENSINO 1 E 2	6	grad
117421	ÁLGEBRA PARA O ENSINO 1	6	grad
117501	ÁLGEBRA PARA O ENSINO 2	6	grad
113972	ANALISE COMBINATORIA	4	grad
113506	ANALISE NUMERICA 1	4	grad
113832	CALCULO DE PROBABILIDADE 2	4	grad
117293	EST ESP ENS REG EM MATEMATICA	10	grad
117030	EST PESQ BIBLIOGR S/ ENS MAT	4	grad
117056	EST SUP DE REGENCIA EM MAT	4	grad
117111	FUNDAMENTOS GEOM RELATIVIDADE	4	grad
113808	FUNDAMENTOS MATEMATICA 1	4	grad
117161	GEOMETRIA 1	4	grad
117170	GEOMETRIA 2	4	grad
117471	GEOMETRIA PARA O ENSINO 1	6	grad
117480	GEOMETRIA PARA O ENSINO 2	6	grad
113603	HISTORIA DA MATEMATICA	4	grad
113841	INTRO A AUT PROBABILISTICOS	4	grad
117129	INTRO A COMPUTACAO ALGEBRICA	4	grad
113433	INTRO A PROGRAMACAO LINEAR	4	grad
117072	INTRO AS EQUACOES DIF PARCI	4	grad
117463	INTROD ALG LIN GEOM ANALITICA	6	grad
117412	INTROD TEO DE MED E INTEGRAÇÃO	4	grad
113093	INTRODUCAO A ALGEBRA LINEAR	4	grad
113964	INTRODUCAO A COMPILACAO	6	grad
113158	INTRODUCAO A OTIMIZACAO	4	grad
113930	INTRODUCAO A TEORIA DOS GRAFOS	4	grad
113948	LINGUAGENS FORMAIS E AUTOMATOS	4	grad
117358	LÓGICA MAT E COMPUTACIONAL	4	grad
117102	MET MATEMATICOS DA FISICA 2	4	grad
117064	PROGRAMACAO INTEIRA E DINAMICA	4	grad
117498	PROGRAMAÇÃO MATEMÁTICA	4	grad
117081	PROGRAMACAO NAO LINEAR	4	grad
113956	PROGRAMACAO SISTEMATICA	4	grad
117510	REGÊNCIA 1	10	grad
117439	REGÊNCIA 2	10	grad
113689	SEMINARIO DE TOP EM ALGEBRA	4	grad
113671	SEMINARIO DE TOP EM ANALISE	4	grad
113697	SEMINARIO DE TOP EM GEOMETRIA	4	grad
117307	SEMINARIO DE TOP MAT APLICADA	4	grad
117013	SEMINARIO TOPICOS ESPECIAIS	2	grad
113115	TEORIA DOS NUMEROS	4	grad
117323	TEORIA DOS NÚMEROS 2	4	grad
113263	TOPOLOGIA DOS ESPACOS METRICOS	4	grad
117447	TRABALHO FINAL 1	1	grad
117455	TRABALHO FINAL 2	1	grad
313980	ALGEBRA 4	3	pgrad
314544	ÁLGEBRA COMUTATIVA	5	pgrad
313165	ALGEBRA LINEAR 2	5	pgrad
313572	ALGEBRAS DE LIE 	5	pgrad
313467	AN DE ALGOR E ESTRUT DADOS	5	pgrad
313246	ANÁLISE 3 	5	pgrad
313173	ANÁLISE DE FOURIER	5	pgrad
313751	ANÁLISE FUNCIONAL 	5	pgrad
313041	ANÁLISE FUNCIONAL NÃO-LINEAR	5	pgrad
313581	ANÁLISE HARMÔNICA 1 	5	pgrad
313424	ANÁLISE HARMÔNICA 2 	5	pgrad
313513	ANÁLISE NUMÉRICA 2 	5	pgrad
313629	APRES GRUP MET COMPUTACIONAIS	5	pgrad
313181	CALCULO DAS VARIAÇÕES 	5	pgrad
313017	CO-HOMOLOGIA DE GRUPOS	5	pgrad
313475	COMPLEX COMPUT COMPUTABILIDAD	5	pgrad
313408	EQUA DIFERENCIAIS ORDINÁRIAS 2	5	pgrad
313548	EQUAÇ DIFERN ORDINÁR APLICADAS	5	pgrad
313556	EQUAÇÕES DIFEREN PARCIAIS 1	5	pgrad
313564	EQUAÇÕES DIFEREN PARCIAIS 2	5	pgrad
313203	EQUAÇÕES INTEGRAIS	5	pgrad
318230	EQUAÇÕES SOBRE CORPOS FINITOS	5	pgrad
318108	EST DOC ENS GRAD MATEMÁTICA 2	4	pgrad
318141	EST PESQ EM ÁLGEBRA	1	pgrad
318175	EST PESQUISA EM ANÁLISE	1	pgrad
318094	ESTÁGIO DOC ENS GRAD MATEMÁT 1	4	pgrad
313823	FUNDAMENTOS DA MATEMÁTICA 2 	5	pgrad
313343	GEOMETRIA DIFERENCIAL 	5	pgrad
313955	GEOMETRIA FINITA 	5	pgrad
313033	GEOMETRIA RIEMANNIANA 	5	pgrad
313211	GRUPOS ALGEBRICOS 	5	pgrad
313912	GRUPOS DE LIE 	5	pgrad
313084	GRUPOS DE PERMUTAÇÕES 	5	pgrad
318124	GRUPOS PROFINITOS 	5	pgrad
318159	INTROD EQUAÇÕES DIFERENCIAIS 	5	pgrad
313157	INTROD PROBABILIDAD APLICAÇÕES\t	5	pgrad
313114	INTRODUÇÃO A ALGEBRA 	6	pgrad
313491	INTRODUÇÃO A ANÁLISE 	6	pgrad
313432	INTRODUÇÃO À COMPUTAÇÃO 	5	pgrad
313998	INTRODUÇÃO A LÓGICA FORMAL 	5	pgrad
313254	INTRODUÇÃO A TOPOLOGIA 	5	pgrad
318078	INTRODUÇÃO TEORIA DOS NÚMEROS 	5	pgrad
313483	LINGUAGENS FORM AUTOMATA 2 	5	pgrad
313785	LÓGICA ALGEBRICA 	3	pgrad
313122	MECÂNICA ANALÍTICA 	3	pgrad
313220	MEDIDA E INTEGRAÇÃO 	5	pgrad
313530	MÉTODOS MATEMÁTICOS FÍSICA 2 	5	pgrad
313891	NÚMEROS ALGÉBRICOS 	5	pgrad
313807	OTIMIZ COMBINAT E ALGOR 	5	pgrad
318027	PRATICA DE ENSINO MATEMÁTICA 	4	pgrad
313793	PRINC SIS GERE BAN DADOS 	5	pgrad
318167	PROBABILIDADE E TEO DA MEDIDA	5	pgrad
318086	PROCESSOS ESTOCÁSTICOS 1 	5	pgrad
313378	PROGRAMAÇÃO DINÂMICA 	5	pgrad
313441	PROGRAMAÇÃO MATEMÁTICA 	5	pgrad
313050	REPRESENTAÇÃO DE GRUPOS 1	5	pgrad
313068	REPRESENTAÇÃO DE GRUPOS 2	5	pgrad
313904	SEMIN DE GEOM FIN GRUP FINITOS\t	1	pgrad
318302	SEMINÁRIO D SISTEMAS DINÂMICOS\t	1	pgrad
313840	SEMINÁRIO DE ALGEBRA 	1	pgrad
313963	SEMINÁRIO DE ANÁLISE NUMÉRICA 	1	pgrad
313769	SEMINÁRIO DE FUNÇÕES ELIPTICAS\t	1	pgrad
313777	SEMINÁRIO DE LÓGICA 	1	pgrad
318060	SEMINÁRIO TEORIA DOS NÚMEROS 	1	pgrad
313602	TEO DAS FORMAS AUTOMORF	5	pgrad
313131	TEORIA DE GRUPOS FINITOS 	5	pgrad
313718	TEORIA DE PROBABILIDADES 1 	5	pgrad
313092	TEORIA DO CONTROLE 	5	pgrad
313726	TEORIA DOS CORPOS 	5	pgrad
313386	TEORIA DOS GRUPOS FINITOS 2 	5	pgrad
313106	TEORIA DOS MODELOS 	5	pgrad
313190	TEORIA SEMIGRUPOS E APLICAÇÕES\t	5	pgrad
318043	TÓP AVAN DE GEOMET DIFERENCIAL\t	5	pgrad
318116	TÓP DE PROCESSOS ESTOCÁSTICOS 	5	pgrad
313611	TÓP DE PROGRAMAÇÃO MATEMÁTICA 	5	pgrad
313416	TÓP EM COMBINAÇÃO MATEMÁTICA 	5	pgrad
318035	TÓP EQUAÇÕES DIFERE ORDINÁRIAS\t	3	pgrad
313025	TÓPICOS AVANÇADOS DE ANÁLISE 	5	pgrad
313742	TOPICOS DE AN NUMERICA 	5	pgrad
313521	TÓPICOS DE FÍSICA MATEMÁTICA 	5	pgrad
313335	TÓPICOS DE PROGRAMAÇÃO LINEAR 	5	pgrad
318221	TÓPICOS DE TOPOLOGIA 	4	pgrad
313734	TÓPICOS EM ALGEBRA 	5	pgrad
314536	TÓPICOS EM ÁLGEBRA APLICADA 	5	pgrad
318132	TÓPICOS EM COMPUTAÇÃO 	5	pgrad
313921	TÓPICOS EM ESTAT MATEMÁTICA 	5	pgrad
313637	TÓPICOS EM LEIS DE CONSERVAÇÃO\t	5	pgrad
318019	TÓPICOS EM PROBABILIDADE 	5	pgrad
318256	TÓPICOS EM SISTEMAS DINÂMICOS 	5	pgrad
318051	TÓPICOS EM TEORIA DOS NÚMEROS 	5	pgrad
318248	TÓPICOS ESPECIAIS DE ANÁLISE 	3	pgrad
313319	TÓPICOS GEOMETRIA DIFERÊNCIAL 	5	pgrad
313394	TOPOLOGIA ALGÉBRICA 	5	pgrad
313815	TOPOLOGIA DIFERENCIAL 	5	pgrad
313238	TOPOLOGIA GERAL 	5	pgrad
313076	VARIÁVEIS COMPLEXAS 2 	5	pgrad
313351	VARIEDADE DIFERÊNCIÁVEIS 	5	pgrad
318001	VARIEDADES COMPLEXAS 	5	pgrad
113018	MATEMATICA 1	4	grad
113026	MATEMATICA 2	4	grad
113701	INTR. MATEMATICA SUPERIOR	6	grad
117153	ESTAGIO EM LABORATORIO DE ENSINO DE MATEMATICA	6	grad
200107	CALCULO 1 SEMIPRESENCIAL	6	grad
313831	SEMINARIO DE ANALISE	1	pgrad
\.


COPY fonctionnaire (coduser, contract_date, contract_type, statut, contract_end) FROM stdin;
599	2008-07-08	dedicacao exclusiva           	administrativo	2011-01-08
651	2009-05-13	estagiario grad               	administrativo	2010-11-13
664	2009-06-10	dedicacao exclusiva           	professor	2044-06-10
497	1981-07-07	dedicacao exclusiva           	administrativo	2016-07-07
43	2006-07-22	estagiario tec                	administrativo	2009-08-22
401	2002-07-25	dedicacao exclusiva           	professor	2037-07-25
566	1978-08-14	dedicacao exclusiva           	professor	2013-08-14
549	1979-03-01	dedicacao exclusiva           	professor	2014-03-01
411	2007-04-25	substituto ms40               	professor	2010-04-25
531	2007-04-26	substituto ms40               	professor	2009-04-26
528	2000-04-04	prestador servico             	administrativo	2009-03-04
524	1983-04-04	dedicacao exclusiva           	professor	2018-04-04
525	2003-03-16	dedicacao exclusiva           	professor	2038-03-16
404	1982-03-01	dedicacao exclusiva           	professor	2017-03-01
659	2009-06-02	estagiario grad               	administrativo	2010-06-01
592	2008-03-01	estagiario grad               	administrativo	2010-09-01
522	1976-05-14	dedicacao exclusiva           	administrativo	2011-05-14
516	1987-02-05	dedicacao exclusiva           	professor	2022-02-05
400	2006-01-03	dedicacao exclusiva           	professor	2041-01-03
496	1985-02-20	dedicacao exclusiva           	professor	2020-02-20
493	2005-12-08	dedicacao exclusiva           	professor	2040-12-08
520	1987-04-01	dedicacao exclusiva           	professor	2022-04-01
494	1978-08-30	dedicacao exclusiva           	professor	2013-08-30
484	1993-01-11	dedicacao exclusiva           	professor	2028-01-11
402	1981-01-02	dedicacao exclusiva           	professor	2016-01-02
580	2006-02-01	dedicacao exclusiva           	professor	2041-02-01
521	1979-08-06	dedicacao exclusiva           	professor	2014-08-06
495	2000-07-30	dedicacao exclusiva           	professor	2035-07-30
500	1981-03-20	dedicacao exclusiva           	professor	2016-03-20
420	2008-03-15	substituto ms40               	professor	2010-03-15
499	2000-06-16	dedicacao exclusiva           	professor	2035-06-16
425	2008-07-10	substituto ms40               	professor	2010-07-10
501	1993-07-09	dedicacao exclusiva           	professor	2028-07-09
492	1973-02-27	dedicacao exclusiva           	professor	2020-02-27
530	2006-06-06	substituto gr40               	professor	2008-06-06
490	2005-12-01	dedicacao exclusiva           	professor	2040-12-01
504	1998-09-08	dedicacao exclusiva           	professor	2008-09-08
406	1995-02-28	dedicacao exclusiva           	professor	2030-02-28
405	2006-09-01	dedicacao exclusiva           	professor	2041-09-01
505	1985-04-09	dedicacao exclusiva           	professor	2020-04-09
534	2007-09-19	substituto ms40               	professor	2009-09-19
506	1998-03-05	dedicacao exclusiva           	professor	2033-03-05
488	2001-03-06	dedicacao exclusiva           	professor	2036-03-06
508	1997-05-16	dedicacao exclusiva           	professor	2032-05-16
407	2004-04-20	dedicacao exclusiva           	professor	2039-04-20
509	2000-06-30	dedicacao exclusiva           	professor	2035-06-30
408	1993-08-01	dedicacao exclusiva           	professor	2028-08-01
514	1985-09-01	dedicacao exclusiva           	professor	2020-09-01
527	2005-11-24	dedicacao exclusiva           	professor	2040-11-24
515	1998-12-18	dedicacao exclusiva           	professor	2033-12-18
403	1982-03-01	dedicacao exclusiva           	professor	2017-03-01
409	1971-04-03	professor associado           	professor	2020-04-03
532	2005-12-01	substituto ms40               	professor	2007-12-01
631	1987-02-12	dedicacao exclusiva           	administrativo	2022-02-12
529	2006-06-14	substituto gr40               	professor	2008-06-14
582	1985-03-01	dedicacao exclusiva           	administrativo	2020-03-01
523	1994-01-13	dedicacao exclusiva           	administrativo	2029-01-13
498	1974-03-01	dedicacao exclusiva           	professor	2015-03-01
615	2009-05-18	dedicacao exclusiva           	professor	2044-05-18
620	2009-07-21	dedicacao exclusiva           	professor	2044-07-21
679	2009-12-15	sem_vinculo                   	professor	2009-12-15
680	2010-02-01	dedicacao exclusiva           	professor	2045-02-01
683	2010-03-01	dedicacao exclusiva           	professor	2045-03-01
519	1980-12-31	dedicacao exclusiva           	professor	2016-01-01
682	2010-03-10	sem_vinculo                   	professor	2011-02-10
675	2009-10-21	estagiario grad               	administrativo	2010-08-21
654	2009-05-19	dedicacao exclusiva           	professor	2044-05-19
526	2005-02-10	dedicacao exclusiva           	professor	2040-02-10
700	2010-07-21	sem_vinculo                   	professor	2010-07-21
470	2010-07-12	dedicacao exclusiva           	professor	2045-07-11
513	1975-08-28	dedicacao exclusiva           	professor	2012-08-28
703	2010-03-01	dedicacao exclusiva           	administrativo	2045-03-01
677	2009-09-14	estagiario tec                	administrativo	2014-09-14
706	2010-09-27	mestrado                      	professor	2010-09-27
722	2010-10-01	dedicacao exclusiva           	professor	2045-10-01
616	2008-07-18	dedicacao exclusiva           	administrativo	2043-07-18
662	2009-06-12	dedicacao exclusiva           	administrativo	2044-06-12
702	2010-03-01	dedicacao exclusiva           	administrativo	2045-04-01
727	2011-01-17	sem_vinculo                   	professor	2011-01-17
512	1976-02-20	dedicacao exclusiva           	professor	2016-02-20
728	2011-02-04	dedicacao exclusiva           	professor	2046-02-04
412	2011-03-01	dedicacao exclusiva           	professor	2046-03-01
630	2009-04-01	prestador servico             	administrativo	2012-04-01
469	2011-04-13	dedicacao exclusiva           	professor	2046-04-13
747	2011-04-18	dedicacao exclusiva           	professor	2046-04-18
415	2011-04-07	dedicacao exclusiva           	professor	2046-04-07
464	2011-05-03	dedicacao exclusiva           	professor	2046-05-03
750	2010-03-21	sem_vinculo                   	administrativo	2012-03-21
724	2010-02-05	prestador servico             	administrativo	2012-02-05
753	2011-05-23	dedicacao exclusiva           	administrativo	2046-05-23
754	2011-05-09	dedicacao exclusiva           	professor	2046-05-09
417	2011-04-07	dedicacao exclusiva           	professor	2046-04-07
517	1998-08-12	dedicacao exclusiva           	professor	2033-08-12
507	1976-07-01	dedicacao exclusiva           	professor	2021-07-01
633	2009-11-25	dedicacao exclusiva           	professor	2044-11-25
578	2011-03-29	substituto ms40               	professor	2013-03-29
764	2012-11-09	sem_vinculo                   	professor	2012-11-09
655	2009-05-28	dedicacao exclusiva           	professor	2044-05-28
603	2008-07-31	dedicacao exclusiva           	professor	2043-08-01
586	1978-06-15	dedicacao exclusiva           	administrativo	2013-06-15
491	2005-12-29	dedicacao exclusiva           	professor	2040-12-29
474	1982-01-01	dedicacao exclusiva           	professor	2017-01-01
608	2011-03-15	substituto ms40               	professor	2013-03-15
767	2011-12-19	dedicacao exclusiva           	administrativo	2046-12-19
548	1978-03-07	dedicacao exclusiva           	professor	2013-03-07
489	1982-03-12	dedicacao exclusiva           	professor	2017-03-12
628	2011-08-30	substituto ms40               	professor	2013-08-30
410	1995-11-11	dedicacao exclusiva           	professor	2030-11-11
785	2012-03-14	dedicacao exclusiva           	administrativo	2047-03-14
454	2010-06-04	dedicacao exclusiva           	professor	2045-06-04
463	2010-06-04	dedicacao exclusiva           	professor	2045-06-04
766	2011-12-15	dedicacao exclusiva           	administrativo	2012-05-15
657	2009-05-28	dedicacao exclusiva           	professor	2044-05-28
786	2012-05-28	estagiario tec                	administrativo	2013-05-28
661	2009-06-04	dedicacao exclusiva           	professor	2044-06-04
518	1975-07-15	dedicacao exclusiva           	professor	2022-07-15
788	2012-08-21	estagiario tec                	administrativo	2013-08-21
678	2012-08-10	substituto ms40               	professor	2014-08-10
618	2012-08-10	substituto ms40               	professor	2014-08-10
658	2009-06-01	dedicacao exclusiva           	professor	2044-06-01
567	2006-09-05	prestador servico             	administrativo	2013-01-20
503	1986-07-01	dedicacao exclusiva           	professor	2021-07-01
576	1996-05-18	prestador servico             	administrativo	2015-05-18
\.



COPY oferta_lista_de_ofertas (disciplina, turma, turno, professor, semestre, ano, horarios) FROM stdin;
113018	B	Diurno	454	1	2012	216-416
113018	C	Diurno	526	1	2012	308-508
113018	E	Ambos	417	1	2012	219-419
113018	G	Noturno	655	1	2012	419-619
113018	H	Diurno	470	1	2012	308-508
113018	I	Noturno	514	1	2012	419-619
113018	K	Ambos	608	1	2012	312-512
113018	L	Noturno	658	1	2012	219-419
113026	A	Diurno	400	1	2012	414-614
113034	A	Diurno	513	1	2012	210-310-510
113034	B	Diurno	603	1	2012	214-414-614
113034	C	Diurno	513	1	2012	308-508-608
113034	D	Diurno	747	1	2012	210-310-510
113034	E	Diurno	417	1	2012	214-414-614
113034	F	Diurno	513	1	2012	210-310-510
113034	G	Noturno	608	1	2012	219-321-521
113034	H	Diurno	513	1	2012	308-508-608
113034	I	Noturno	655	1	2012	219-321-521
113034	J	Diurno	454	1	2012	214-414-614
113034	K	Noturno	722	1	2012	321-521-619
113034	L	Noturno	525	1	2012	321-521-619
113034	M	Diurno	491	1	2012	210-310-510
113034	N	Diurno	407	1	2012	210-310-410
113034	O	Diurno	499	1	2012	308-508-608
113034	P	Noturno	412	1	2012	219-321-521
113034	S	Diurno	728	1	2012	208-408-608
113034	T	Noturno	490	1	2012	219-419-619
113034	Y	Diurno	493	1	2012	208-408-608
113034	Z	Diurno	608	1	2012	214-414-614
113042	A	Diurno	405	1	2012	208-308-508
113042	B	Diurno	509	1	2012	210-310-510
113042	C	Diurno	516	1	2012	210-310-510
113042	D	Diurno	509	1	2012	214-414-614
113042	E	Noturno	405	1	2012	219-321-521
113042	F	Diurno	463	1	2012	308-508-608
113042	G	Diurno	680	1	2012	208-308-508
113042	H	Noturno	657	1	2012	219-321-521
113042	I	Diurno	657	1	2012	210-310-510
113042	J	Noturno	516	1	2012	321-519-619
113042	K	Diurno	661	1	2012	214-414-614
113042	L	Diurno	683	1	2012	208-308-508
113042	M	Diurno	526	1	2012	210-310-510
113051	A	Diurno	501	1	2012	214-414-614
113051	B	Diurno	496	1	2012	308-508-608
113051	C	Diurno	494	1	2012	210-310-510
113051	D	Noturno	501	1	2012	321-521-619
113051	E	Diurno	524	1	2012	210-310-510
113051	F	Diurno	407	1	2012	214-414-614
113051	G	Diurno	503	1	2012	308-508-608
113051	H	Noturno	464	1	2012	321-521-619
113051	I	Diurno	494	1	2012	308-508-608
113069	A	Diurno	469	1	2012	214-314-514
113069	B	Diurno	658	1	2012	214-314-514
113069	C	Noturno	469	1	2012	219-321-521
113093	A	Diurno	484	1	2012	216-416
113093	B	Diurno	401	1	2012	316-516
113093	C	Diurno	408	1	2012	216-416
113093	D	Diurno	527	1	2012	216-416
113093	E	Noturno	520	1	2012	319-519
113093	F	Diurno	664	1	2012	216-416
113093	G	Noturno	464	1	2012	319-519
113093	H	Diurno	620	1	2012	410-610
113093	I	Diurno	484	1	2012	316-516
113093	J	Diurno	661	1	2012	216-416
113107	A	Diurno	507	1	2012	308-508
113107	B	Noturno	412	1	2012	319-619
113115	A	Diurno	633	1	2012	310-510
113115	B	Noturno	499	1	2012	319-519
113123	A	Diurno	508	1	2012	216-316-516
113131	A	Ambos	491	1	2012	308-508
113204	A	Ambos	506	1	2012	208-408-608
113301	A	Diurno	515	1	2012	310-510
113301	B	Diurno	463	1	2012	414-614
113301	C	Diurno	519	1	2012	310-510
113301	D	Noturno	654	1	2012	319-621
113301	E	Diurno	521	1	2012	414-614
113301	F	Diurno	603	1	2012	316-516
113301	G	Diurno	496	1	2012	310-510
113301	H	Diurno	524	1	2012	208-408
113328	A	Diurno	527	1	2012	314-514
113417	A	Diurno	628	1	2012	316-516
113417	B	Diurno	628	1	2012	314-514
113417	C	Diurno	493	1	2012	314-514
113417	D	Diurno	525	1	2012	314-514
113417	E	Diurno	628	1	2012	208-408
113417	F	Noturno	410	1	2012	321-519
113522	A	Diurno	654	1	2012	210-410-610
113522	B	Diurno	521	1	2012	210-410-610
113611	A	Ambos	408	1	2012	210-410-610
113701	A	Diurno	520	1	2012	216-416-516
113701	B	Diurno	754	1	2012	216-416-516
113824	A	Diurno	470	1	2012	210-310-510
113832	A	Diurno	518	1	2012	210-410
113930	A	Diurno	754	1	2012	314-514
113972	A	Noturno	580	1	2012	419-619
117056	A	Ambos	514	1	2012	708
117056	B	Diurno	722	1	2012	708
117137	A	Diurno	747	1	2012	208-408
117153	B	Ambos	548	1	2012	216-414-416
117161	A	Ambos	505	1	2012	208-408
117170	A	Noturno	548	1	2012	221-419
117307	A	Diurno	505	1	2012	312-512
200107	A	Ambos	454	1	2012	212-412-612
200107	B	Ambos	454	1	2012	212-412-612
200107	C	Ambos	454	1	2012	212-412-612
200107	D	Ambos	503	1	2012	212-412-612
200107	E	Ambos	454	1	2012	212-412-612
113018	B	Diurno	519	2	2012	216-416
113018	C	Diurno	494	2	2012	308-508
113018	E	Ambos	655	2	2012	219-419
113018	G	Noturno	417	2	2012	419-619
113018	H	Diurno	400	2	2012	308-508
113018	I	Noturno	608	2	2012	419-619
113018	K	Noturno	655	2	2012	321-521
113018	L	Noturno	655	2	2012	321-521
113026	A	Diurno	603	2	2012	414-614
113034	A	Diurno	490	2	2012	210-310-510
113034	B	Diurno	525	2	2012	214-414-614
113034	C	Diurno	490	2	2012	308-508-608
113034	D	Diurno	415	2	2012	210-310-510
113034	E	Diurno	722	2	2012	214-414-614
113034	F	Diurno	410	2	2012	210-310-510
113034	G	Noturno	608	2	2012	219-321-521
113034	H	Diurno	490	2	2012	308-508-608
113034	I	Noturno	519	2	2012	219-321-521
113034	J	Diurno	747	2	2012	214-414-614
113034	K	Noturno	722	2	2012	321-521-619
113034	M	Diurno	678	2	2012	210-310-510
113034	N	Diurno	728	2	2012	210-310-410
113034	O	Diurno	415	2	2012	308-508-608
113034	P	Noturno	417	2	2012	219-321-521
113034	S	Diurno	470	2	2012	208-408-608
113034	T	Noturno	490	2	2012	219-419-619
113034	Y	Diurno	664	2	2012	208-408-608
113034	Z	Diurno	454	2	2012	214-414-614
113042	A	Diurno	680	2	2012	208-308-508
113042	B	Diurno	657	2	2012	210-310-510
113042	C	Diurno	683	2	2012	210-310-510
113042	D	Diurno	618	2	2012	214-414-614
113042	E	Noturno	509	2	2012	219-321-521
113042	F	Diurno	520	2	2012	308-508-608
113042	G	Diurno	463	2	2012	208-308-508
113042	H	Noturno	405	2	2012	219-321-521
113042	I	Diurno	516	2	2012	210-310-510
113042	J	Noturno	657	2	2012	321-519-619
113042	K	Diurno	680	2	2012	214-414-614
113042	L	Diurno	683	2	2012	208-308-508
113042	M	Diurno	405	2	2012	210-310-510
113051	A	Diurno	400	2	2012	214-414-614
113051	B	Diurno	464	2	2012	308-508-608
113051	C	Diurno	524	2	2012	210-310-510
113051	D	Noturno	501	2	2012	321-521-619
113051	E	Diurno	494	2	2012	210-310-510
113051	F	Diurno	469	2	2012	214-414-614
113051	G	Diurno	469	2	2012	308-508-608
113051	I	Diurno	499	2	2012	308-508-608
113069	A	Diurno	521	2	2012	214-314-514
113069	B	Diurno	499	2	2012	214-314-514
113069	C	Noturno	658	2	2012	219-321-521
113093	A	Diurno	484	2	2012	216-416
113093	B	Diurno	508	2	2012	316-516
113093	C	Diurno	514	2	2012	216-416
113093	D	Diurno	620	2	2012	216-416
113093	E	Noturno	408	2	2012	319-519
113093	F	Diurno	407	2	2012	216-416
113093	G	Noturno	509	2	2012	319-519
113093	H	Diurno	754	2	2012	410-610
113093	I	Diurno	488	2	2012	316-516
113093	J	Diurno	661	2	2012	216-416
113093	K	Diurno	484	2	2012	316-516
113093	L	Ambos	516	2	2012	414-614
113107	A	Diurno	491	2	2012	308-508
113107	B	Noturno	488	2	2012	319-619
113115	A	Diurno	633	2	2012	310-510
113115	B	Noturno	633	2	2012	319-519
113123	A	Diurno	520	2	2012	216-316-516
113204	A	Noturno	496	2	2012	219-321-619
113212	A	Diurno	403	2	2012	310-510
113263	A	Noturno	493	2	2012	319-519
113301	D	Noturno	464	2	2012	319-621
113301	E	Diurno	521	2	2012	414-614
113301	F	Diurno	496	2	2012	316-516
113301	G	Diurno	526	2	2012	310-510
113301	H	Diurno	524	2	2012	208-408
113417	A	Diurno	412	2	2012	316-516
113417	B	Diurno	525	2	2012	314-514
113417	C	Diurno	678	2	2012	314-514
113417	D	Diurno	412	2	2012	314-514
113417	E	Diurno	654	2	2012	208-408
113522	A	Diurno	501	2	2012	210-410-610
113522	B	Diurno	654	2	2012	210-410-610
113603	A	Ambos	474	2	2012	316-516
113611	A	Noturno	408	2	2012	419-421-708
113697	A	Ambos	505	2	2012	312-512
113701	A	Diurno	754	2	2012	216-416-516
113701	B	Diurno	491	2	2012	216-416-516
113824	A	Diurno	470	2	2012	210-310-510
113832	A	Diurno	517	2	2012	210-410
113859	A	Diurno	493	2	2012	214-414
117056	A	Ambos	514	2	2012	708
117145	A	Diurno	507	2	2012	308-508
117153	A	Noturno	548	2	2012	319-321-519
117161	A	Noturno	505	2	2012	221-419
117170	B	Diurno	548	2	2012	208-408
117323	A	Ambos	506	2	2012	314-514
200107	A	Ambos	454	2	2012	212-412-612
200107	B	Ambos	454	2	2012	212-412-612
200107	C	Ambos	454	2	2012	212-412-612
200107	D	Ambos	503	2	2012	212-412-612
200107	E	Ambos	454	2	2012	212-412-612
\.


COPY profs (coduser, orientateur, area_atuacao, niveau_fonctionnel, bolsista, situacao) FROM stdin;
404	t	algebra	assistente 4		ativo
566	t	analise	assistente 4	sem bolsa	aposentado
516	t	probabilidade	adjunto 4	sem bolsa	ativo
525	t	geometria	adjunto 2	sem bolsa	ativo
524	t	analise	adjunto 4	sem bolsa	ativo
400	t	analise	adjunto 3		ativo
531	f	analise	indefinido	sem bolsa	desligado
496	t	analise	adjunto 4	sem bolsa	ativo
493	t	computacao	adjunto 1	sem bolsa	ativo
411	f	esp. indefinido	indefinido	outros	ativo
549	f	computacao	adjunto 4	sem bolsa	aposentado
401	t	algebra	titular	sem bolsa	ativo
530	f	esp. indefinido	indefinido	sem bolsa	desligado
425	f	esp. indefinido	indefinido	outros	ativo
580	t	probabilidade	adjunto 3	sem bolsa	ativo
532	f	esp. indefinido	indeterminado	sem bolsa	desligado
529	f	algebra	indefinido	sem bolsa	desligado
679	f	geometria	adjunto 2	outros	ativo
520	t	algebra	adjunto 4	sem bolsa	ativo
620	t	esp. indefinido	adjunto 2	sem bolsa	ativo
494	t	analise	adjunto 4	sem bolsa	ativo
664	f	esp. indefinido	adjunto 1	sem bolsa	ativo
484	t	teoria dos numeros	adjunto 4	sem bolsa	ativo
521	t	analise	adjunto 4	sem bolsa	ativo
495	t	computacao	adjunto 4	sem bolsa	ativo
499	t	teoria dos numeros	assistente 4	sem bolsa	ativo
501	t	geometria	assistente 4	sem bolsa	ativo
490	t	analise	adjunto 1	sem bolsa	ativo
406	t	computacao	adjunto 4	sem bolsa	ativo
405	t	analise	adjunto 1	sem bolsa	ativo
505	t	geometria	adjunto 4	sem bolsa	ativo
534	f	analise	indefinido	sem bolsa	ativo
506	t	teoria dos numeros	adjunto 3	sem bolsa	ativo
488	t	algebra	titular	sem bolsa	ativo
508	t	algebra	titular	sem bolsa	ativo
407	t	geometria	adjunto 2	sem bolsa	ativo
509	t	analise	adjunto 3	sem bolsa	ativo
408	t	computacao	adjunto 3	sem bolsa	ativo
513	t	analise	adjunto 4	sem bolsa	ativo
514	t	teoria dos numeros	adjunto 4	sem bolsa	ativo
527	t	geometria	adjunto 2	sem bolsa	ativo
515	t	geometria	titular	sem bolsa	ativo
403	t	analise	adjunto 4	sem bolsa	ativo
409	t	algebra	titular	sem bolsa	ativo
504	t	fisica matematica	adjunto 4	sem bolsa	redistribuido
680	t	analise	titular	sem bolsa	ativo
420	f	esp. indefinido	indefinido	outros	ativo
683	t	algebra	adjunto 1	sem bolsa	ativo
519	t	analise	titular	sem bolsa	ativo
682	f	teoria dos numeros	indefinido	sem bolsa	ativo
654	t	fisica matematica	adjunto 1	sem bolsa	ativo
526	t	probabilidade	adjunto 1	sem bolsa	ativo
700	f	algebra	indefinido	sem bolsa	ativo
518	t	probabilidade	titular	sem bolsa	ativo
470	t	probabilidade	adjunto 1	cnpq	ativo
706	f	algebra	indefinido	capes	ativo
722	t	analise	adjunto 4	sem bolsa	ativo
727	f	esp. indefinido	indefinido	sem bolsa	desligado
728	t	algebra	ajunto 1	sem bolsa	ativo
412	t	algebra	ajunto 1	sem bolsa	ativo
747	t	analise	adjunto 1	sem bolsa	ativo
469	t	geometria	adjunto 1	sem bolsa	ativo
415	f	analise	indefinido	sem bolsa	ativo
464	t	analise	adjunto 1	sem bolsa	ativo
754	t	algebra	adjunto 1	sem bolsa	ativo
417	t	analise	adjunto 1	sem bolsa	ativo
517	t	probabilidade	adjunto 3	sem bolsa	ativo
507	t	algebra	titular	sem bolsa	ativo
633	t	teoria dos numeros	adjunto 1	sem bolsa	ativo
578	f	analise	indefinido	sem bolsa	ativo
764	f	geometria	indefinido	cnpq	ativo
655	t	geometria	adjunto 1	sem bolsa	ativo
603	t	geometria	adjunto 2	sem bolsa	ativo
491	t	algebra	adjunto 1	sem bolsa	ativo
608	t	esp. indefinido	Indeterminado	sem bolsa	ativo
548	t	analise	assistente 4	sem bolsa	ativo
489	t	teoria dos numeros	titular	sem bolsa	ativo
628	t	esp. indefinido	Indeterminado	sem bolsa	ativo
410	t	fisica matematica	adjunto 4	sem bolsa	ativo
454	t	geometria	adjunto 1	sem bolsa	ativo
463	t	analise	adjunto 1	sem bolsa	ativo
615	t	esp. indefinido	titular	sem bolsa	aposentado
498	t	analise	titular	sem bolsa	aposentado
402	t	analise	adjunto 3		aposentado
500	t	analise	adjunto 4	sem bolsa	aposentado
512	t	algebra	titular	sem bolsa	aposentado
492	t	geometria	titular	sem bolsa	colaborador
474	t	historia matematica	adjunto 2	sem bolsa	colaborador
657	t	esp. indefinido	adjunto 1	sem bolsa	ativo
661	t	algebra	adjunto 2	sem bolsa	ativo
678	t	esp. indefinido	Indeterminado	sem bolsa	ativo
618	t	esp. indefinido	Indeterminado	cnpq	ativo
658	t	fisica matematica	adjunto 1	sem bolsa	ativo
503	t	teoria dos numeros	adjunto 4	sem bolsa	ativo
\.


COPY student (coduser, coming_date, depart_date1, speciality, orientateur, status, formation, bolsista, matricul) FROM stdin;
668	2009-08-10	2013-08-10			ativo	doutorado		123456
583	2006-03-15	2010-03-15	algebra	488	ativo	doutorado	cnpq	652059
632	2009-04-03	2009-10-03	esp. indefinido	0	ativo	graduacao	sem bolsa	690520
577	2008-01-14	2008-02-14	esp. indefinido	0	desligado	verao	cnpq	737326
598	2007-03-10	2008-08-10	esp. indefinido	513	ativo	especializacao	sem bolsa	784435
639	2009-03-10	2011-03-10	esp. indefinido	518	ativo	mestrado	cnpq	90071875
647	2008-03-15	2010-09-15	esp. indefinido	0	ativo	graduacao	outros	909645
665	2008-03-15	2010-03-15	analise	0	ativo	mestrado	outros	961108
610	2009-03-15	2013-03-15	esp. indefinido	492	ativo	doutorado	capes	90019474
606	2008-08-11	2010-08-11	esp. indefinido	518	ativo	mestrado	sem bolsa	1027646
666	2007-08-15	2009-12-15	algebra	401	ativo	mestrado	sem bolsa	843792
673	2008-08-10	2009-02-10	esp. indefinido	505	ativo	graduacao	sem bolsa	1008200
591	2007-08-10	2011-08-10	geometria	515	ativo	doutorado	capes	847780
637	2009-03-10	2011-03-10	esp. indefinido	518	ativo	mestrado	cnpq	90071057
449	2004-04-15	2009-05-30	geometria	492	ativo	doutorado	cnpq	455806
447	2003-03-15	2007-03-15	algebra	488	titulado	doutorado	cnpq	389901
607	2008-08-11	2010-08-11	esp. indefinido	0	ativo	mestrado	cnpq	1027620
451	2005-03-15	2010-03-15	probabilidade	518	ativo	doutorado	cnpq	548553
425	2006-04-04	2009-12-12	geometria	407	titulado	mestrado	cnpq	651699
420	2005-02-13	2007-12-13	analise	495	titulado	mestrado	cnpq	599638
596	2002-03-01	2004-03-01	esp. indefinido	0	titulado	mestrado	sem bolsa	256242
423	2006-04-04	2008-04-04	esp. indefinido	0	desligado	mestrado	cnpq	654671
629	2005-03-10	2005-09-10	esp. indefinido	0	ativo	graduacao	sem bolsa	531481
578	2008-01-07	2008-02-07	esp. indefinido	0	desligado	verao	cnpq	4568781
422	2006-04-04	2008-10-04	analise	490	ativo	mestrado	cnpq	651583
650	2007-03-15	2012-09-15	esp. indefinido	0	ativo	graduacao	outros	737186
426	2006-04-04	2008-12-15	algebra	512	ativo	mestrado	cnpq	651711
584	2007-03-15	2010-03-15	computacao	406	ativo	mestrado	sem bolsa	845906
448	2004-04-15	2008-04-15	algebra	512	titulado	doutorado	capes	455741
450	2004-04-15	2008-04-15	geometria	492	titulado	doutorado	cnpq	497347
602	2008-08-11	2010-08-11	esp. indefinido	0	ativo	mestrado	sem bolsa	1027590
642	2009-03-16	2011-03-16	esp. indefinido	518	ativo	mestrado	capes	90071921
645	2009-03-16	2011-03-16	esp. indefinido	0	ativo	mestrado	cnpq	90071476
588	2009-03-15	2013-03-15	algebra	401	ativo	doutorado	cnpq	973921
652	2007-08-10	2010-08-10	esp. indefinido	401	ativo	mestrado	cnpq	847763
613	2005-03-01	2009-12-10	esp. indefinido	0	ativo	graduacao	sem bolsa	540099
436	2007-03-15	2009-12-15	esp. indefinido	0	ativo	mestrado	cnpq	739570
674	2008-08-10	2009-02-10	esp. indefinido	0	ativo	graduacao	sem bolsa	1003640
419	2007-03-17	2011-03-17	algebra	488	ativo	doutorado	capes	761745
465	2006-04-15	2010-04-15	analise	519	ativo	doutorado	sem bolsa	652440
435	2007-04-04	2009-04-04	esp. indefinido	0	ativo	mestrado	cnpq	762822
466	2006-04-15	2010-04-15	geometria	515	ativo	doutorado	sem bolsa	652415
467	2006-04-15	2010-04-15	geometria	492	ativo	doutorado	cnpq	652474
452	2005-03-15	2009-03-15	analise	498	ativo	doutorado	cnpq	548561
470	2007-03-15	2011-03-15	probabilidade	518	ativo	doutorado	cnpq	717070
441	2007-08-02	2009-08-02	esp. indefinido	0	ativo	mestrado	cnpq	843717
622	2005-03-01	2005-03-01	esp. indefinido	0	ativo	sem_vinculo	sem bolsa	531642
413	2007-03-03	2011-03-03	analise	490	ativo	doutorado	capes	761591
569	2008-03-10	2010-03-10	esp. indefinido	0	ativo	mestrado	cnpq	961116
430	2006-09-04	2008-08-25	analise	519	titulado	mestrado	cnpq	715549
625	2009-03-01	2013-03-01	teoria dos numeros	0	ativo	doutorado	sem bolsa	762717
431	2007-04-04	2010-04-04	esp. indefinido	0	ativo	mestrado	cnpq	762466
634	2006-08-02	2007-02-02	esp. indefinido	0	ativo	graduacao	sem bolsa	677558
461	2006-04-15	2010-04-15	analise	519	ativo	doutorado	cnpq	652237
589	2008-03-10	2012-03-10	analise	498	ativo	doutorado	capes	960985
597	2007-08-01	2009-08-01	esp. indefinido	0	ativo	mestrado	cnpq	843776
585	2007-03-15	2009-03-15	computacao	406	ativo	mestrado	sem bolsa	422827
429	2006-09-04	2008-09-04	analise	403	titulado	mestrado	cnpq	715522
427	2006-09-04	2008-09-04	algebra	484	titulado	mestrado	cnpq	715484
399	2005-05-18	2005-05-18	esp. indefinido		desligado	estagiario grad	outros	745294
445	2003-03-15	2007-03-15	algebra	401	titulado	doutorado	cnpq	389722
428	2006-09-04	2008-09-04	teoria dos numeros	484	titulado	mestrado	monitoria	715514
571	2009-03-10	2011-03-10	esp. indefinido	518	ativo	mestrado	capes	90076133
453	2005-03-15	2011-08-15	algebra	508	ativo	doutorado	cnpq	596019
638	2008-08-10	2010-08-10	esp. indefinido	518	ativo	mestrado	cnpq	1027671
649	2008-03-10	2010-03-10	esp. indefinido	517	ativo	mestrado	cnpq	960951
643	2009-03-16	2012-03-16	esp. indefinido	0	ativo	mestrado	cnpq	90071468
653	2009-03-15	2009-09-15	esp. indefinido	0	ativo	graduacao	sem bolsa	90014278
660	2007-08-08	2009-12-08	algebra	491	ativo	mestrado	cnpq	843784
663	2009-03-15	2011-03-15	esp. indefinido	0	ativo	mestrado	sem bolsa	90072103
443	2007-08-02	2009-12-31	esp. indefinido	0	ativo	mestrado	cnpq	843831
670	2009-08-10	2013-08-10	probabilidade	518	ativo	doutorado	capes	90140907
672	2009-08-10	2010-02-10	esp. indefinido	505	ativo	graduacao	sem bolsa	1005821
667	2009-08-05	2013-08-05	algebra	401	ativo	doutorado	sem bolsa	90140877
595	2009-08-17	2013-08-17	esp. indefinido	405	ativo	doutorado	capes	90140842
687	2010-03-08	2014-03-08	esp. indefinido	508	ativo	doutorado	sem bolsa	100061460
547	2010-03-01	2014-03-01	esp. indefinido	508	ativo	doutorado	monitoria	100061478
424	2009-03-16	2013-03-16	analise	495	ativo	doutorado	capes	111111111
534	2008-08-01	2012-08-01	analise	0	ativo	doutorado	sem bolsa	1028227
681	2010-03-08	2014-03-08	esp. indefinido	401	ativo	doutorado	capes	100061494
442	2009-08-01	2013-08-01	esp. indefinido	406	ativo	doutorado	cnpq	90150015
433	2009-03-01	2013-03-01	esp. indefinido	400	ativo	doutorado	capes	90085981
625	2009-03-15	2013-03-15	teoria dos numeros	484	ativo	doutorado	capes	90020103
594	2010-03-01	2014-03-01	computacao	406	ativo	doutorado	capes	100067115
418	2007-09-02	2011-09-02	teoria dos numeros	484	ativo	doutorado	sem bolsa	761699
648	2008-03-08	2010-05-08	esp. indefinido	507	ativo	mestrado	sem bolsa	961078
572	2009-03-10	2011-03-10	esp. indefinido	518	ativo	mestrado	capes	90019989
627	2008-03-10	2010-05-10	esp. indefinido	603	ativo	mestrado	capes	961019
604	2008-08-08	2012-12-08	probabilidade	518	ativo	doutorado	cnpq	717088
684	2010-03-08	2012-03-08		406	ativo	mestrado	cnpq	100060897
444	2009-08-04	2013-08-04	probabilidade	518	ativo	doutorado	capes	90157761
462	2006-04-15	2011-04-15	algebra	507	ativo	doutorado	cnpq	652253
457	2006-04-15	2011-04-15	algebra	507	ativo	doutorado	capes	652164
570	2010-03-08	2014-03-08	computacao	406	ativo	doutorado	capes	100068600
609	2009-03-01	2013-03-01	analise	519	ativo	doutorado	cnpq	90085957
619	2010-03-08	2012-03-08	esp. indefinido	0	ativo	mestrado	cnpq	100061338
593	2008-03-10	2010-06-22	esp. indefinido	400	ativo	mestrado	sem bolsa	961043
595	2007-03-10	2009-03-10	esp. indefinido	405	titulado	mestrado	cnpq	762555
609	2007-08-01	2009-08-01	analise	519	titulado	mestrado	cnpq	843806
547	2007-03-15	2010-03-15	esp. indefinido	0	titulado	mestrado	monitoria	762709
588	2006-03-15	2008-03-15	algebra	401	titulado	mestrado	cnpq	651672
424	2006-04-05	2008-04-05	analise	494	titulado	mestrado	cnpq	651681
610	2007-03-12	2009-05-12	esp. indefinido	492	titulado	mestrado	cnpq	762695
433	2007-03-15	2010-03-15	esp. indefinido	0	titulado	mestrado	cnpq	762750
668	2009-08-10	2011-08-10			titulado	mestrado		1234560
412	2005-02-23	2007-02-23	algebra	409	titulado	mestrado	capes	548171
411	2005-02-27	2007-02-27	geometria	492	titulado	mestrado	cnpq	548154
442	2007-08-08	2009-08-08	esp. indefinido	406	titulado	mestrado	cnpq	843733
444	2007-08-02	2013-08-02	esp. indefinido	0	titulado	mestrado	cnpq	843849
594	2008-03-10	2010-06-10	esp. indefinido	518	titulado	mestrado	sem bolsa	961086
570	2008-03-10	2010-04-15	esp. indefinido	518	titulado	mestrado	sem bolsa	960993
612	2007-08-01	2009-12-31	esp. indefinido	521	titulado	graduacao	outros	638684
618	2006-03-15	2009-09-15	esp. indefinido	0	titulado	graduacao	sem bolsa	622877
619	2006-03-16	2006-09-16	esp. indefinido	0	titulado	graduacao	sem bolsa	622761
671	2009-08-10	2013-08-10	algebra	508	ativo	doutorado	capes	90140893
627	2010-03-08	2014-03-08	esp. indefinido	492	ativo	doutorado	capes	100072941
414	2007-03-03	2011-03-03	algebra	508	ativo	doutorado	capes	761605
648	2010-05-19	2014-05-19	algebra	409	ativo	doutorado	sem bolsa	100072968
695	2010-03-10	2014-03-10	analise	403	ativo	doutorado	sem bolsa	100061516
593	2010-03-08	2014-03-08	analise	495	ativo	doutorado	capes	100075517
458	2006-06-15	2010-09-20	algebra	401	ativo	doutorado	cnpq	652181
416	2007-05-09	2011-05-09	analise	400	ativo	doutorado	capes	795291
712	2010-09-27	2014-09-27	analise	490	ativo	doutorado	capes	100128246
713	2010-09-27	2014-09-27	teoria dos numeros	484	ativo	doutorado	sem bolsa	100128262
714	2010-09-27	2012-09-27	analise	0	ativo	mestrado	capes	100128475
716	2008-03-17	2012-03-17	algebra	409	ativo	doutorado	capes	961051
717	2010-09-27	2012-09-27	analise	484	ativo	mestrado	capes	100061427
720	2010-03-08	2014-03-08	probabilidade	518	ativo	doutorado	sem bolsa	100061443
704	2010-09-24	2014-09-24	algebra	508	ativo	doutorado	capes	100128220
711	2010-09-27	2012-09-27	teoria dos numeros		ativo	mestrado	cnpq	100128467
707	2010-09-27	2012-09-27			ativo	mestrado		100128386
456	2006-04-15	2011-10-15	computacao	406	ativo	doutorado	cnpq	652130
590	2010-09-27	2014-10-27	probabilidade	518	ativo	doutorado	cnpq	100128289
590	2008-03-10	2010-03-10	probabilidade	0	titulado	mestrado	cnpq	960977
646	2008-03-15	2010-03-15	analise	490	titulado	mestrado	cnpq	960896
646	2010-03-08	2014-03-08	analise	490	ativo	doutorado	capes	100072950
626	2007-03-01	2011-05-01	algebra	508	ativo	doutorado	sem bolsa	761711
710	2010-10-01	2012-10-01		0	ativo	mestrado	capes	100132219
611	2008-03-10	2014-03-15	esp. indefinido	409	ativo	doutorado	capes	961651
708	2010-08-01	2012-08-01			ativo	mestrado		100132227
460	2007-03-15	2051-03-15	esp. indefinido	0	ativo	mestrado	sem bolsa	762776
412	2007-07-08	2011-07-08	algebra	409	titulado	doutorado	cnpq	761583
412	2011-03-01	2011-03-01	algebra	0	ativo	dedicacao exclusiva	sem bolsa	1048554
730	2011-03-20	2015-03-20	analise	403	ativo	doutorado	cnpq	110023161
636	2009-03-10	2011-05-10	esp. indefinido	507	ativo	mestrado	capes	90071956
731	2011-03-21	2015-03-21	geometria	492	ativo	doutorado	capes	110023145
732	2010-03-01	2012-03-01	algebra	661	ativo	mestrado	sem bolsa	100061095
733	2011-03-21	2015-03-21	algebra	508	ativo	doutorado	cnpq	110023170
736	2011-03-21	2013-03-21			ativo	mestrado		110081684
738	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	sem bolsa	110078985
739	2011-03-21	2013-03-21	esp. indefinido	484	ativo	mestrado	cnpq	110075111
740	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	cnpq	110076061
743	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	cnpq	110081668
744	2010-03-08	2012-03-08	algebra	661	ativo	mestrado	cnpq	100064370
745	2010-10-01	2012-10-01	esp. indefinido	0	ativo	mestrado	cnpq	100128416
628	2009-03-16	2011-08-16	esp. indefinido	518	ativo	mestrado	cnpq	90771883
469	2007-03-15	2011-03-15	geometria	527	titulado	doutorado	cnpq	717274
748	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	cnpq	110075137
415	2007-03-15	2011-05-15	analise	498	titulado	doutorado	capes	761648
464	2006-04-15	2011-06-15	analise	498	ativo	doutorado	capes	652407
578	2008-08-05	2011-11-05	analise	509	titulado	mestrado	cnpq	1055411
635	2009-04-15	2011-10-15	esp. indefinido	0	ativo	mestrado	sem bolsa	90072146
751	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	sem bolsa	110081781
737	2010-03-21	2012-03-21	esp. indefinido	0	ativo	mestrado	sem bolsa	100065287
742	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	cnpq	110057112
752	2011-03-21	2013-03-21	esp. indefinido	0	ativo	mestrado	cnpq	110078977
734	2011-03-21	2013-03-21	esp. indefinido	484	ativo	mestrado	cnpq	110079141
417	2007-08-16	2011-08-16	analise	403	titulado	doutorado	capes	843873
755	2011-07-07	2012-01-07	fisica matematica	654	ativo	graduacao	pibic	90131037
756	2011-08-03	2013-08-03	esp. indefinido	484	ativo	mestrado	cnpq	110105508
757	2011-08-04	2013-08-04	esp. indefinido	484	ativo	mestrado	cnpq	110105451
759	2011-08-15	2013-08-15	esp. indefinido	484	ativo	mestrado	cnpq	110105524
760	2011-08-15	2015-08-15	esp. indefinido	492	ativo	doutorado	capes	110105541
641	2009-03-15	2011-03-15	probabilidade	518	desligado	mestrado	cnpq	971905
641	2010-08-15	2012-08-15	analise	657	ativo	mestrado	capes	100128394
741	2011-03-21	2013-03-21	esp. indefinido	0	desligado	mestrado	capes	110057104
761	2011-08-15	2015-08-15	esp. indefinido	401	ativo	doutorado	capes	110105559
762	2011-08-15	2013-08-15	esp. indefinido	484	ativo	mestrado	cnpq	100105460
763	2011-08-15	2013-08-15	esp. indefinido	484	ativo	mestrado	capes	110105516
633	2009-04-07	2011-04-07	teoria dos numeros	484	titulado	doutorado	cnpq	9072618
765	2011-08-15	2013-08-15	esp. indefinido	484	ativo	mestrado	capes	110105532
471	2007-09-04	2012-03-04	analise	519	ativo	doutorado	sem bolsa	843857
574	2008-03-10	2012-05-21	esp. indefinido	658	ativo	mestrado	sem bolsa	960918
715	2010-09-27	2012-09-27	algebra		ativo	mestrado	cnpq	100133738
608	2008-08-11	2012-12-31	esp. indefinido	0	titulado	mestrado	sem bolsa	1027573
705	2010-09-28	2012-09-28	esp. indefinido	0	ativo	mestrado	capes	100132189
768	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	capes	120005671
770	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	capes	120005646
612	2010-03-01	2012-07-01	esp. indefinido	0	ativo	mestrado	outros	1010101010
669	2009-08-10	2013-08-10	esp. indefinido	518	ativo	doutorado	cnpq	90140885
685	2012-03-08	2014-03-08			ativo	mestrado	sem bolsa	120005620
685	2010-03-08	2012-03-08			desligado	mestrado	cnpq	100061192
772	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	capes	120005719
472	2007-09-04	2012-08-30	probabilidade	518	ativo	doutorado	capes	847771
686	2010-03-08	2014-03-08	teoria dos numeros	633	ativo	doutorado		100064400
776	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	capes	120072475
718	2010-09-27	2011-08-01	esp. indefinido	0	desligado	mestrado	capes	100128360
718	2012-03-23	2014-03-23	esp. indefinido	0	ativo	mestrado	capes	120024152
644	2007-03-15	2012-09-15	esp. indefinido	0	titulado	graduacao	sem bolsa	736325
644	2011-01-01	2013-01-01	teoria dos numeros	633	ativo	mestrado	cnpq	110075129
774	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	cnpq	120072416
775	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	cnpq	120072441
777	2012-03-12	2016-03-12	esp. indefinido	403	ativo	doutorado	capes	120005603
779	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	cnpq	120072394
780	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	capes	120005697
781	2012-04-04	2012-10-04	fisica matematica	654	ativo	graduacao	pibic	100093817
411	2008-03-01	2013-03-15	geometria	492	ativo	doutorado	cnpq	960870
782	2012-03-12	2016-03-12	esp. indefinido	0	ativo	doutorado	capes	120065207
737	2012-03-12	2016-03-12	esp. indefinido	0	ativo	doutorado	capes	120082632
783	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	cnpq	120005654
769	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	cnpq	120005662
784	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	outros	120089238
587	2005-03-10	2010-03-10	algebra	508	titulado	doutorado	cnpq	548545
581	2004-03-01	2008-12-10	computacao	406	titulado	doutorado	sem bolsa	455695
773	2012-03-12	2014-03-12	esp. indefinido	403	ativo	mestrado	cnpq	120072351
468	2007-03-15	2015-03-15	algebra	484	titulado	doutorado	cnpq	718777
455	2006-04-15	2010-04-15	geometria	492	titulado	doutorado	cnpq	652075
689	2008-08-01	2010-08-01	analise	490	titulado	mestrado	cnpq	1027603
463	2006-04-15	2010-04-15	analise	403	titulado	doutorado	cnpq	652270
454	2006-04-15	2010-07-15	geometria	515	titulado	doutorado	cnpq	652024
421	2007-08-12	2012-06-01	probabilidade	518	ativo	doutorado	capes	847798
638	2012-03-12	2016-03-12	esp. indefinido	633	ativo	doutorado	capes	12005590
473	2007-09-04	2013-06-04	algebra	488	ativo	doutorado	cnpq	843865
601	2008-08-11	2013-08-11	esp. indefinido	0	ativo	doutorado	sem bolsa	1028219
641	2012-03-15	2016-03-15	analise	657	ativo	doutorado	capes	120088649
678	2009-08-17	2011-08-17	esp. indefinido	0	titulado	mestrado	capes	90140974
618	2010-03-08	2012-03-08	esp. indefinido	0	titulado	mestrado	cnpq	100061303
778	2012-03-12	2014-03-12	esp. indefinido	0	desligado	mestrado	capes	120072289
746	2010-10-01	2012-10-01	esp. indefinido	633	ativo	mestrado	capes	100128483
793	2012-10-08	2014-10-08	esp. indefinido	0	ativo	mestrado	cnpq	120149460
735	2012-03-12	2014-03-12	esp. indefinido	0	ativo	mestrado	capes	120005727
735	2011-03-21	2013-03-21	esp. indefinido	0	desligado	mestrado	sem bolsa	110079035
\.



COPY unix (login, passwd, uid, gid, class, gecos, homedir, shell, coduser, cota_impressao, cota_disco, cota_mail, tabela_user, ssh, erro_data, erro) FROM stdin;
levi	v2IH0fE91ZYj2	344	10001	1		/home/levi	bash	466	200	500Mb	1000Mb	student	nao	\N	\N
roncalli	$1$nbv/7pfW$xzHbrHLhwr0JaO5UTCEOy0	2518	10002	1		/home/roncalli	bash	621	100	100Mb	1000Mb	visitor	nao	\N	\N
wesley	$1$R9cRk9dV$pFcBe6809OTU9q9/YqiTa0	2511	10001	1		/home/wesley	bash	613	100	300Mb	1000Mb	student	nao	\N	\N
lorena	$1$W.8TO3W2$Rs19ZPa6LdNQSka1Kuv40.	2497	10003	1		/home/lorena	bash	599	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
borisenk	$1$JjPsSPh6$9iI7WF1dyt6KGHED2pkuJ/	2514	10002	1		/home/borisenk	bash	617	300	100Mb	1000Mb	visitor	nao	\N	\N
alberto	$1$kIEcaiPA$QRsV6jE.xSR5iLkIILqUO0	2470	10001	1		/home/alberto	bash	569	100	100Mb	1000Mb	student	nao	\N	\N
ander	$1$37eLTdrp$pA/SNUQIISN8eT0Xcsd5T/	2241	10001	1		/home/ander	bash	583	200	500Mb	1000Mb	student	nao	\N	\N
manoelmat	$1$hQ1my7lp$15COu1XD4gRRkt6/DlYnU0	2529	10001	1		/home/manoelmat	bash	632	100	300Mb	1000Mb	student	nao	\N	\N
sergiomate	$1$WAJLfz8a$afy1O.rIIPoYfDVcYnxcK1	2560	10001	1		/home/sergiomate	bash	663	100	300Mb	1000Mb	student	nao	\N	\N
victor	$1$/0lb7j1m$G9IGvpgp.gpCO4zxDpLbh.	2569	10001	1		/home/victor	bash	673	100	300Mb	1000Mb	student	nao	\N	\N
natan	$1$Byx7X98n$lYVcp7ztgPZn6FfPxU4oS1	2565	10001	1		/home/natan	bash	668	100	300Mb	1000Mb	student	nao	\N	\N
olivier	$1$y3Ub.hSk$oiNVCTguZi5/HubPiuwMl1	2498	10002	1		/home/olivier	bash	600	100	100Mb	1000Mb	visitor	nao	\N	\N
francisco	$1$bKMOTQze$hA.mQhMAuYzV1ENErbXr51	2556	10002	1		/home/francisco	bash	659	100	100Mb	1000Mb	fonctionnaire	sim	\N	\N
paula	$1$HhyuCmz2$dfAr4l1/EYFGNiPlhmWQ01	2570	10001	1		/home/paula	bash	674	100	300Mb	1000Mb	student	nao	\N	\N
rmiranda	$1$5pP.1wGl$BMLgYTqjLDG1n7un47/X51	2485	10001	1		/home/rmiranda	bash	585	100	300Mb	1000Mb	student	sim	\N	\N
adrianapac	$1$3l4kg2SD$rMNJCfq66KoAFoCoh8qqT/	2531	10001	1		/home/adrianapac	bash	634	100	300Mb	1000Mb	student	nao	\N	\N
jvgalmeida	$1$zN104uHA$LjFTnHMyG.jRcSUe64ci6/	2557	10001	1		/home/jvgalmeida	bash	660	100	300Mb	1000Mb	student	nao	\N	\N
ganassoli	$1$TmPgdSGG$FDYYSwI21FRJBhh4LWGCD.	2562	10001	1		/home/ganassoli	bash	665	100	300Mb	1000Mb	student	nao	\N	\N
brunobon	$1$2dtjtRTy$4LfBUhRNBbv2IOTZ08DCU0	2526	10001	1		/home/brunobon	bash	629	100	300Mb	1000Mb	student	nao	\N	\N
mesquita	$1$a.a/mkxc$Gan8UOEWZeWleBm4OzWrl0	2563	10001	1		/home/mesquita	bash	666	100	300Mb	1000Mb	student	nao	\N	\N
gracekelly	$1$XQnr4Qik$8.9.SysvjlO9jusrKXAce/	2500	10001	1		/home/gracekelly	bash	602	100	300Mb	1000Mb	student	nao	\N	\N
henrique	$1$BK/3Mghj$8EqBUiSeiBsnpGXbtgV810	2474	10002	1		/home/henrique	bash	573	100	100Mb	1000Mb	visitor	nao	\N	\N
cesarpavao	$1$6P3nU/UC$K92sN/O8ofTwad6SW3SJD1	2476	10002	1		/home/cesarpavao	bash	575	100	100Mb	1000Mb	visitor	nao	\N	\N
pjsantos	$1$FetJU36q$BjfuuHB/3gh3k54iAwve50	2193	10001	1		/home/pjsantos	bash	447	200	500Mb	1000Mb	student	nao	\N	\N
fabio	$1$SdQLIkzt$yULUrvIqWkZvgApGoI4zh0	2536	10001	1		/home/fabio	bash	639	100	300Mb	1000Mb	student	nao	\N	\N
silvia	$1$qvyI/RH4$gC/QNxjN8B3SjrQAK3Cai.	2537	10002	1		/home/silvia	bash	640	100	100Mb	1000Mb	visitor	nao	\N	\N
thaisy	$1$9QryLmJw$1QUm5ag9GaqenIEnP.kn0.	2478	10001	1		/home/thaisy	bash	577	100	300Mb	1000Mb	student	nao	\N	\N
rmsrib	$1$Zu.GnJHR$J4VuYRDPkiaP1qeNI/l6h0	2281	10001	1		/home/rmsrib	bash	450	200	500Mb	1000Mb	student	nao	\N	\N
thiagowsr	$1$ygaE6GvP$E6dFq5wzg7Gfvky7h6rsk0	2503	10001	1		/home/thiagowsr	bash	606	100	300Mb	1000Mb	student	nao	\N	\N
tcarval	h1LdZjXpGE.i2	2244	10001	1		/home/tcarval	bash	449	200	500Mb	1000Mb	student	nao	\N	\N
goalberto	$1$h3P1yun0$Smvrl5mjPrRw72Bq5uhjT1	2490	10003	1		/home/goalberto	bash	592	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
leonardobn	$1$LXeaoRET$.hkNgH/987a2zyUfSd71x/	2504	10001	1		/home/leonardobn	bash	607	100	300Mb	1000Mb	student	nao	\N	\N
fernando	$1$PW9eNKlw$muQy/6NldB3DsY9QIYhb9/	2539	10001	1		/home/fernando	bash	642	100	300Mb	1000Mb	student	nao	\N	\N
isabel	$1$SLvrRDzu$pFsh0xyqzGj6jiJuyCpt80	2208	10003	1		/home/isabel	bash	43	300	500Mb	1000Mb	fonctionnaire	sim	\N	\N
vagner	$1$73wjfdeO$.7Uo7o2aDatIHKYEi1Mbs1	2306	10001	1		/home/vagner	bash	419	200	500Mb	1000Mb	student	nao	\N	\N
adriana	$1$Dmsk//ms$CJ8m/vpPN95GVfWchRjXX/	2540	10001	1		/home/adriana	bash	643	130	300Mb	1000Mb	student	nao	\N	\N
amanda	$1$qOUg2j4F$8thdU4BoOR9vULHHbPPy//	2542	10001	1		/home/amanda	bash	645	100	300Mb	1000Mb	student	nao	\N	\N
valnei	$1$D5L4DROQ$ZNyHqL9Yzgz0VTy3cZ1jW0	2494	10001	1		/home/valnei	bash	596	100	300Mb	1000Mb	student	nao	\N	\N
hugonoleto	$1$aW/EceM8$V0M3a.KlRrumIWuQ7C9v6/	2495	10001	1		/home/hugonoleto	bash	597	130	300Mb	1000Mb	student	nao	\N	\N
anapaula	$1$2WuKXss2$8eNsXQntgYM0.yrDqD9.p0	2496	10001	1		/home/anapaula	bash	598			1000Mb	student	nao	\N	\N
gscarvalho	$1$rInEYoXA$K/zZN2ZcCdT3gCHvCEj5E/	2544	10001	1		/home/gscarvalho	bash	647	100	300Mb	1000Mb	student	nao	\N	\N
weslley	$1$9phrQlZf$1ipz2bVcG8doPijBxY7Cj1	2546	10001	1		/home/weslley	bash	649	100	300Mb	1000Mb	student	nao	\N	\N
taniapg	s6ip5Mg1x8WCc	83	10003	1		/home/taniapg	bash	497	300	500Mb	1000Mb	fonctionnaire	nao	\N	\N
flavia	$1$5BLZWk0T$ZLBZFCVBO8g8Z35WVswiN.	2548	10003	1		/home/flavia	bash	651	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
jmgalmeida	$1$Q424H8T7$mz5Hw4iFa6sS6aJhmYY08/	2549	10001	1		/home/jmgalmeida	bash	652	100	300Mb	1000Mb	student	nao	\N	\N
vargas	$1$sbObW77U$kh8aOTw1.HVghVg7G/lva1	2330	10001	1		/home/vargas	bash	420	200	300	1000Mb	fonctionnaire	nao	\N	\N
igor	$1$w97JMkmx$lz00yyaZcIIRFmedDX2Lg.	2321	10001	1		/home/igor	bash	427	130	300	1000Mb	student	nao	\N	\N
sergionn	FZVMLFiR6pImY	2261	10001	1		/home/sergionn	bash	430	100	300	1000Mb	student	nao	\N	\N
michael	$1$YQ7iyYZP$6aUoX7nwojiV3iOG52YqN0	2263	10001	1		/home/michael	bash	429	100	300	1000Mb	student	nao	\N	\N
cristian	$1$20dB.2Td$frGXzdnLzn8ZybmpjxPfo/	2316	10001	1		/home/cristian	bash	399	100	300	1000Mb	student	nao	\N	\N
riani	$1$0vwXkkIQ$n5a9VdRnyblLSs043IwHo1	2336	10001	1		/home/riani	bash	428	100	300	1000Mb	student	nao	\N	\N
cesar	$1$2p3JN/rX$v.ExadLOYEYqdb4GIxkTY0	2371	10001	1		/home/cesar	bash	422	100	300	1000Mb	student	nao	\N	\N
fernanda	oAGIJDR.OmVig	2373	10001	1		/home/fernanda	bash	423	100	300	1000Mb	student	nao	\N	\N
massa	$1$DTy2GXxo$GXf3xBRawOWff4FzNMA9T1	2378	10001	1		/home/massa	bash	425	100	300	1000Mb	student	nao	\N	\N
marcus	$1$hwaEu/C4$6cVAz1WoFBin6BkZnfkuj/	2379	10001	1		/home/marcus	bash	426	100	300	1000Mb	student	nao	\N	\N
smacedo	QBhBAddNlP.M6	2396	10001	1		/home/smacedo	bash	435	130	300	1000Mb	student	nao	\N	\N
jhone	3LTaQKQI4fpJg	2161	10001	1		/home/jhone	bash	453	200	500Mb	1000Mb	student	nao	\N	\N
elida	$1$ZRDks.Ul$zAmSVyZ3kGNztpjlnDRXh1	2192	10001	1		/home/elida	bash	445	200	500Mb	1000Mb	student	nao	\N	\N
teofilo	$1$TIRovK57$aOIte2KnTb8MBTsY/sK3c/	2550	10001	1		/home/teofilo	bash	653	100	300Mb	1000Mb	student	nao	\N	\N
gomes	M9l/7pggFb5uM	2383	10001	1		/home/gomes	bash	467	200	500Mb	1000Mb	student	nao	\N	\N
thiagog	$1$C7vuj1nX$sUN7r1j.UcsA9opKCunb81	2404	10001	1		/home/thiagog	bash	436	100	300	1000Mb	student	nao	\N	\N
renatocn	tgp4nlP8BlGHc	2406	10001	1		/home/renatocn	bash	443	100	300Mb	1000Mb	student	nao	\N	\N
andrey	$1$PGsyUmd8$Up92Du/fhv98DofhqrK7B.	2407	10001	1		/home/andrey	bash	441	100	300	1000Mb	student	nao	\N	\N
debora	$1$KP9nShjB$onQy3M6rgWB6sEedmUUvJ1	2292	10001	1		/home/debora	bash	451	200	500Mb	1000Mb	student	nao	\N	\N
eunice	$1$U1RIclsN$2CRTZTBUaIV3r/lNpAUfV/	2367	10001	1		/home/eunice	bash	457	200	500Mb	1000Mb	student	nao	\N	\N
fks	/u1iWW83fUzFk	2184	10001	1		/home/fks	bash	452	200	500Mb	1000Mb	student	nao	\N	\N
reis	$1$DRW6oxek$iPwCWW8qbyyvtnavFB1N40	2029	10003	1		/home/reis	bash	528	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
jpablo	$1$r4eZfE9H$Alutpq/ZRKaKbJ2LZNyH0.	2302	10001	1		/home/jpablo	bash	413	200	500Mb	1000Mb	student	nao	\N	\N
camila	$1$ktyRAmTB$w4DEwWWVaMiiPusSph1IK1	2519	10001	1		/home/camila	bash	622			1000Mb	student	nao	\N	\N
arianny	$1$49cvvL0O$FL/rk//QimWh1WLcjNCSK.	2469	10002	1		/home/arianny	bash	568	100	100Mb	1000Mb	visitor	nao	\N	\N
behs	$1$f8GQDe6W$V9.ouLopQSuHNSKDyQhhF1	2024	10001	1		/home/behs	bash	448	200	500Mb	1000Mb	student	nao	\N	\N
marcia	$1$IikyQ.zf$2SODPPve0riZS5bP/dB5h/	2567	10001	1		/home/marcia	bash	670	200	500Mb	1000Mb	student	nao	\N	\N
jcesarfe	$1$D0iuw6nc$5Z3jmWBOQnSZ.ZqGSyhCl.	2572	10001	1		/home/jcesarfe	bash	676	100	300Mb	1000Mb	student	nao	\N	\N
maxwell	ZSWuZgV3mXDXM	292	10001	1		/home/maxwell	bash	465	200	500Mb	1000Mb	student	nao	\N	\N
gari	$1$0aZk9NSP$QHWLdCV81Y7gA8UOnDIKe/	122	10003	1		/home/gari	bash	522	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
mario	$1$YwxwtOyA$h.e8Cf5s.HXv/hMKVm0PT0	2553	10002	1		/home/mario	bash	656	100	100Mb	1000Mb	visitor	nao	\N	\N
rodolpho	$1$wMuSUAwb$vnB7TSGEuQ/KD0cG9xRAw0	2568	10001	1		/home/rodolpho	bash	672	100	300Mb	1000Mb	student	nao	\N	\N
thales	$1$vpkWSxkB$kstMBlw9TLbfTPqze.KaL1	2571	10003	1		/home/thales	bash	675	9999	500Mb	1000Mb	fonctionnaire	sim	\N	\N
gilberto	$1$DRW6oxek$iPwCWW8qbyyvtnavFB1N401	2368	10001	1		/home/gilberto	bash	461	200	500Mb	1000Mb	student	nao	\N	\N
leon	$1$DMO1H9bw$VhRNxC2CCh6jmHgEVDUpx.	2484	10001	1		/home/leon	bash	584	100	300Mb	1000Mb	student	sim	\N	\N
lappicy	$1$DMO1H9bw$VhRNxC2CCh6jmHgEVDUpx.	2547	10001	1		/home/lappicy	bash	650	100	300Mb	1000Mb	student	nao	\N	\N
jfreitas	$1$KMXoz2aw$tPcgFHAV82t/wbyRsJ0VV0	900003	1004	1		/home/jfreitas	bash	683	300	500Mb	1000Mb	fonctionnaire	nao	\N	\N
didi	$1$E8NAGZmf$Gy/SHpkfwftumOzo3a2pf1	2366	10001	1		/home/didi	bash	462	200	500Mb	1000Mb	student	nao	\N	\N
fabiano	$1$cE8GSVh4$Lh.SxAVhD6aoI3Mftze8M/	2502	10001	1		/home/fabiano	bash	604	200	500Mb	1000Mb	student	nao	\N	\N
gardel	$1$ntrCXrm1$0IyDLMK9J4dgc233w4dXs.	2473	10002	1		/home/gardel	bash	572	100	100Mb	1000Mb	visitor	nao	\N	\N
adrianaf	$1$9sV46dO3$euiB1CEyNg6C58S2nzkXl1	2402	10001	1		/home/adrianaf	bash	431	130	300	1000Mb	student	nao	\N	\N
amedino	OmmSynFhlgErc	2037	10004	1		/home/amedino	bash	580	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
emersonb	QBkV8QF51E3Zs	2399	10004	1		/home/emersonb	bash	531	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
xia	yrsJq4QuKZMjQ	255	10004	1		/home/xia	bash	515	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
furtado	$1$5lTfMwhT$Dz4lG/urMhPb7twpyDWAl1	180	10004	1		/home/furtado	bash	490	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
helmar	$1$GgqBZF7f$Zzoeg2BRqXwXSzUQ/zpON.	165	10004	1		/home/helmar	bash	494	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
lineu	x22jNGcgGqx2c	249	10004	1		/home/lineu	bash	499	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
pitt	$1$Ml7ZF9Zn$eD1qJoMGyXK6aiJaxrSe4/	166	10004	1		/home/pitt	bash	506	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
jpadua	oHoFrTHavScOU	163	10004	1		/home/jpadua	bash	521	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
haydee	FmGGEJhEAtQ6g	26	10004	1		/home/haydee	bash	549	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
hemar	ZP8XoJlA9sIOU	43	10004	1		/home/hemar	bash	484	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
mjlima	$1$ckQsOMJL$QQapUZr09lSp8mx.9AxUY0	2403	10004	1		/home/mjlima	bash	532	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
pz	gmlmV.jIWgJ8o	287	10004	1		/home/pz	bash	488	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
keti	$1$YCsUFZik$DlgZjjNWXP/sBWykfF9AE0	18	10004	1		/home/keti	tcsh	492	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
roitman	MLvBdk.zn5WP6	204	10004	1		/home/roitman	bash	407	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
crsantos	8e1M9Zvxdngw.	205	10004	1		/home/crsantos	bash	400	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
llazarte	$1$NdICoLBU$YlXv6sKI.Kk/uM3XfHvus1	1012	10004	1		/home/llazarte	tcsh	404	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
alexei	O0laP8qYl.VOw	2030	10004	1		/home/alexei	bash	401	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
jander	$1$z49Y3Jf.$u9e4KHM8rxxfNNbd4mL6u/	2242	10004	1		/home/jander	bash	529	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
luverci	$1$F.2tj3GD$WxkHCeaqu1TlQSA0QisRD.	2254	10004	1		/home/luverci	bash	530	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
carlos	rfD.mqGgANxL2	169	10004	1		/home/carlos		525	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
clausahm	$1$B0AKFZth$EsT11ttEg9eoV3R.RUMYO0	2361	10004	1		/home/clausahm	bash	493	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
rad	$1$A21vz6KR$dtQaNFXxoCalNw9lhhlCu/	2000	10004	1		/home/rad	bash	509	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
wang	$1$z5XhuUZp$uj.Z5yX/d3Cm0PXAWN20h1	2142	10004	1		/home/wang	bash	527	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
arthur	$1$NNyHPuSK$Gf0wiXYmdvl315dmTjkna0	1013	10004	1		/home/arthur	tcsh	524	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
rseimetz	Cvi4chkX/Twxo	256	10004	1		/home/rseimetz	bash	514	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
emilia	RstatMV/avono	294	10004	1		/home/emilia	bash	504	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
jalfredo	9LhKcXb32Zmdc	351	10004	1		/home/jalfredo	bash	500	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
pavel	AwUDBC6/aQkg6	152	10004	1		/home/pavel	bash	508	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
liliane	.HD7TpiMdU6mY	19	10004	1		/home/liliane	bash	403	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
jairo	$1$utpH8bVF$hmpDEkKxdhbPI/fA8XrBF1	28	10004	1		/home/jairo	bash	402	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
raquel	fiX/q94kqL8Ik	62	10004	1		/home/raquel	bash	408	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
jv	$1$XpcbisEW$2dM3kkVcq/dZEtx7LCKD51	25	10004	1		/home/jv	bash	498	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
gandulfo	6eUSzGpR0fVZw	32	10004	1		/home/gandulfo	bash	513	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
baig	$1$CaW/VvC9$kh1WflYCCRm7a3Mgdvt1p/	15	10004	1		/home/baig	bash	516	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
tania	WOb1vOcX6jk9Y	316	10004	1		/home/tania	bash	566	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
celius	mG7iI0p./3CoY	65	10004	1		/home/celius	bash	496	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
maxlemes	$1$3SqkFKc7$zFdDiVrW4EaZSyFJLEVi20	2576	10004	1		/home/maxlemes	bash	679	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
sheila	$1$0dhwhbQs$Yl/PVBqyVrN4YVDzGjH75/	2517	10004	1		/home/sheila	bash	620	300	500Mb	2000Mb	fonctionnaire	sim	1255114385	1
lucero	$1$Sthp3ysv$tIM.tZKc4ixOJBVQ3yMY40	257	10004	1		/home/lucero	bash	495	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
pauloh	$1$mchzr2bl$O8qmtSQ.zx83UqPXW61eG/	900002	10004	1		/home/pauloh	bash	682	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
kenneth	$1$VIaGCNvp$1PWhZqUHL8Vb8tpL83SI./	2512	10004	1		/home/kenneth	bash	615	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
helder	$1$Ej.A0j86$pNUOyKUogIbOWC/RMFyVk1	75	10004	1		/home/helder	bash	520	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
elves	8jHrHqYd8cwNo	190	10004	1		/home/elves	bash	519	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
gcabade	$1$dRLyGsa0$vP.r/AllQ6QjUZD/dhDHP.	900010	1002	1		/home/gcabade	bash	690	100	1000Mb	1000Mb	visitor	sim	\N	\N
ayala	$1$FMNNIO3O$vSqZk/VdYBatMm.l18fEf0	1067	10004	1		/home/ayala	bash	406	300	1000Mb	2000Mb	fonctionnaire	sim	\N	\N
selma	$1$//ciUGsX$JvAQT.srdSrtdjPXaXO7N1	2573	1001	1		/home/selma	bash	671	200	500Mb	1000Mb	student	nao	\N	\N
karise	$1$IVdqEhek$iB/GaGpW08RTU.ia8v1rb1	2315	10001	1		/home/karise	bash	414	200	500Mb	1000Mb	student	nao	\N	\N
daniele	$1$bg0PG3Pf$utft5uVjsfNS6SP1LyeRj.	333	10004	1		/home/daniele	bash	526	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
reyes	$1$Vs0Vc0dQ$zMYfQwK4zOj3hov3JvPnU1	2520	10002	1		/home/reyes	bash	623	100	100Mb	1000Mb	visitor	nao	\N	\N
evander	$1$RzuKr6yT$yVAzbUCPn8a2A.pqtyICS0	2252	10001	1		/home/evander	bash	458	200	500Mb	1000Mb	student	nao	\N	\N
jnewport	$1$LDqfB9vE$kNo4KRetnisxlyUZIe/5i/	900008	1002	1		/home/jnewport	bash	688	200	500Mb	1000Mb	visitor	sim	\N	\N
psymonds	$6$O3a/qa0j$zihrnCVxLdAAXFvVlqdz5BleBfi4Mk6yoay5teSGhvS.D00VkzKENiPtvZjAKItHoKdhuva4LyyVhIO.6VYkI0	900011	10002	1		/home/psymonds	bash	691	100	1000Mb	1000Mb	visitor	sim	\N	\N
cdorea	fCzN6AWT9kHbw	2506	10004	1		/home/cdorea	bash	518	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
knapp	$1$YEBxFawF$495mRnbjMVYUGV/IgOv8W0	900012	10002	1		/home/knapp	bash	693	100	100Mb	1000Mb	visitor	sim	\N	\N
jomene	$1$vG9snp34$lT1sVmmdaB0XBMNVdxk2u0	900038	10004	1		/home/jomene	bash	722	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
ecataldo	$1$3LHQQH.N$ACFox/dHUet/o2kLGxNJM.	900015	10002	1		/home/ecataldo	bash	696	100	100Mb	1000Mb	visitor	nao	\N	\N
eromano	$1$7ruhY2MX$meqbVxocOJeopkZGRzFrv/	900013	10002	1		/home/eromano	bash	694	100	100Mb	1000Mb	visitor	nao	\N	\N
hdc	$1$M8rDdw/s$sVzch8OhEpi2cuTUbPATZ0	900017	10002	1		/home/hdc	bash	701	100	100Mb	1000Mb	visitor	nao	\N	\N
martaadri	$1$HsV98cGP$2jhQ4G32IxlQYX4oz.U130	900019	10003	1		/home/martaadri	bash	703	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
weigel	$1$mdIlGPCH$Y.aBU8BxopdVud8F8K/5a1	900016	10004	1		/home/weigel	bash	700	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
ventura	YNCxR0oDJ9.9I	2259	10001	1		/home/ventura	bash	456	200	500Mb	1000Mb	student	sim	\N	\N
walter	$1$pehjbYMd$Pht11tb32J2QbRryHFpt0.	2249	10004	1		/home/walter	bash	470	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
barbozamb	$1$CCnbJkgu$3GInBn9B7OQ8NOuUbwfLJ/	2509	10001	1		/home/barbozamb	bash	611	200	300Mb	1000Mb	student	sim	\N	\N
horacio	$1$L2kyCc0W$R5K8iCswAp2i3McGzz8ce.	900035	10002	1		/home/horacio	bash	719	100	100Mb	1000Mb	visitor	sim	\N	\N
portaria	$1$VBeRgiVQ$.z6zvRQx5WQOLFK6rXIEU0	2360	10000	1		/home/portaria	tcsh	0	0	0Mb	1000Mb	contas_especiais	\N	\N	\N
nagios	$1$VBeRgiVQ$.z6zvRQx5WQOLFK6rXIEU0	2159	10000	1		/home/nagios	bash	0	0	0Mb	1000Mb	contas_especiais	\N	\N	\N
chefia	VxPOjoy4c5cHc	2324	10000	1		/home/chefia	tcsh	0	300	500Mb	1000Mb	contas_especiais	nao	\N	\N
samac	tpY3XH6WKG9oQ	2317	10000	1		/home/samac	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
iiiebrem	khybEzSFnu7rQ	2355	10000	1		/home/iiiebrem	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
camat	AF5kxehPJ9Nqo	2389	10000	1		/home/camat	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
admin	$1$QcVYRNst$XAvqYTEufFsF9.o/uVCR/0	2311	10000	1		/home/admin	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
chefe	dkbNTBcp3bJxM	2054	10000	1		/home/chefe	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
oficinas	zb/2bYNVgG0vM	2207	10000	1		/home/oficinas	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
bib	BtAiybJwZa3Qo	136	10000	1		/home/bib	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
femat	LAU2JFKh6U1IA	268	10000	1		/home/femat	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
sematre	1lYf0EZj6indI	2211	10000	1		/home/sematre	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
pos	$1$8SvBNyX5$piCa0mecAUG/3ytyTPpTC.	2390	10000	1		/home/pos	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
bibiteca	g5Z6E03ZElmEs	2280	10000	1		/home/bibiteca	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
matcont	$1$sLeXYmPE$GSzmt9B7RIE/wqrqPq52R0	96	10000	1		/home/matcont	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
coordmat	$1$e0E48XiE$d2nhZiOD.OYv.5TW7Ym521	2353	10000	1		/home/coordmat	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
secretaria	$1$zDGqj2r4$nJjRPR7wkXnOqFYzvntv5.	100000	10000	1		/home/secretaria	bash	0	99999	500Mb	1000Mb	contas_especiais	\N	\N	\N
posgrad	$1$zw7yKhug$3pxZYUL3rU4dSk23FxOhd1	250101	10000	1		/home/posgrad	bash	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
pet	$1$DMO1H9bw$VhRNxC2CCh6jmHgEVDUpx.	2188	10000	1		/home/pet	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
sbemdf	$1$DMO1H9bw$VhRNxC2CCh6jmHgEVDUpx.	2382	10000	1		/home/sbemdf	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
geompde	$1$EytlK2P3$0jgVXex1DwSfQa9.LtQbn1	250100	10000	1		/home/geompde	tcsh	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
verao	$1$w/5lq2os$UnNb2yYCDPKrxavFfgvJm1	900000	10000	1		/home/verao	bash	0	0	500Mb	1000Mb	contas_especiais	\N	\N	\N
said70	$1$RFDTdsMM$6yAP4tGuGTueS8gKZ0ej50	900041	10000	1		/home/said70	tcsh	0	0	500Mb	100Mb	contas_especiais	nao	0	0
irina	$1$WD2fsn.b$BIKaZ3KkAANY2G1RIytjw/	2561	10004	1		/home/irina	bash	664	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
1026313	$1$mUnUux.f$nCVptGKs7IKBCryko.RUe.	2513	10003	1		/home/1026313	bash	616	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
marta	$1$OEjLMf3k$U/nJLLpkxf8FgGljLQsz4.	900018	10003	1		/home/marta	bash	702	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
cecilia	$1$jMJkeF3v$8x6QMY7DOk6zBygSB2u6j/	900043	10002	1		/home/cecilia	bash	726	100	100Mb	1000Mb	visitor	sim	\N	\N
desi	$1$cQw0HkUL$hs4kqDME5LIuFLqxletx1.	900044	10004	1		/home/desi	bash	727	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
boggi	$1$xXLHV6kI$LUhYVHn1LmYSt.Hy5ONja/	900046	10002	1		/home/boggi	bash	729	100	100Mb	1000Mb	visitor	nao	\N	\N
alonso	$1$etGEax44$08BdRsFe1ZJ7WHnfzbsVF1	900042	10002	1		/home/alonso	bash	725	150	100Mb	1000Mb	visitor	sim	\N	\N
mpatrao	$1$SWrGTATg$GJiNI6b4Cb9ccPB3p7Oha1	2032	10004	1		/home/mpatrao	bash	405	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
maierr	zrg0KF5X79.Pc	211	10004	1		/home/maierr	bash	512	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
elson	$1$.gw1mp4M$yXK.qC.qdgnUjKSewj5L81	900047	10001	1		/home/elson	bash	730	200	500Mb	1000Mb	student	sim	\N	\N
monica	$1$xbBZX3hH$uhgX8hfcZyUIUp6.wUOWl0	2533	10001	1		/home/monica	bash	636	130	300Mb	1000Mb	student	sim	\N	\N
lucimar	$1$7sMN98uA$tbzk4PDs8G64BqLXmH/LY/	121	10003	1		/home/lucimar	bash	523	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
borri	$1$pRJqUYk7$RVyUhMmAVgKSYsWLMl6cD0	900060	10001	1		/home/borri	bash	743	100	300Mb	1000Mb	student	nao	\N	\N
mariacelia	$1$RMQbYNiV$VA.YFDQlVEAmnYr7MQp2P1	2527	10003	1		/home/mariacelia	bash	630	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
ilir	$1$zKX9aBYu$3e70x8oFPZAqULxfCo2xb1	900039	10002	1		/home/ilir	bash	723	250	100Mb	1000Mb	visitor	nao	\N	\N
sidki	$1$wudo1KhT$cwGxvQL9ysDGFzdq1eicY0	1055	10004	1		/home/sidki	bash	409	300	1000Mb	2000Mb	fonctionnaire	nao	\N	\N
laura	$1$GXNHZTvC$EMG3bTWe5e0JNfSzWk9KW/	2507	10001	1		/home/laura	bash	609	200	300Mb	1000Mb	student	nao	\N	\N
brunonunes	$1$UlixU6JX$xRNi89nW/f5De7c.Tb8f50	2543	10001	1		/home/brunonunes	bash	646	200	300Mb	1000Mb	student	sim	\N	\N
marina	$1$cJhuTfpa$8nmMmbucd/589K5dI1Dwb1	2516	10001	1		/home/marina	bash	619	100	300Mb	1000Mb	student	nao	\N	\N
henriquer	$1$1Kf5kD0T$mix6wGUKUfIx0BWp4dYJZ0	900058	10001	1		/home/henriquer	bash	741	100	300Mb	1000Mb	student	nao	\N	\N
saieny	$1$VULIPDPW$QXzkgJb2poHRziEFexq84.	900022	10004	1		/home/saieny	bash	706	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
keidna	$1$W/IdwdUh$Ni8YeIc.QVmsSVt5h.gzr1	900023	10001	1		/home/keidna	bash	707	100	300Mb	1000Mb	student	sim	\N	\N
luizmhm	$1$yZNm14Qy$/N/RL.H6Zz0vhPRO3HOOu0	900062	10001	1		/home/luizmhm	bash	745	100	300Mb	1000Mb	student	nao	\N	\N
diana	$1$whWCX6I9$0EroJEQZNtjp33etR8Naj0	900030	10001	1		/home/diana	bash	714	100	300Mb	1000Mb	student	nao	\N	\N
mca	$1$JfBr829p$zbM1GB4tcJ4luTN22seIK/	900024	10001	1		/home/mca	bash	708	100	300Mb	1000Mb	student	sim	\N	\N
luisedu	$1$2dCaiPo0$YAYwtbYqhLgk1d.kvPfrK1	900025	10001	1		/home/luisedu	bash	709	100	300Mb	1000Mb	student	nao	\N	\N
rafaela	$1$wFNa4cjL$UtpGvwcsBp24u/7kn5yZe/	2534	10001	1		/home/rafaela	bash	637	100	300Mb	1000Mb	student	nao	\N	\N
hudsonmat	$1$dws4lPwu$4RCPit5ZANoO.kIMYbNsd/	2472	10002	1		/home/hudsonmat	bash	571	100	100Mb	1000Mb	visitor	nao	\N	\N
anacris	$1$.VA/I4ax$.n.dWYwJYnQBpFs3.4.u/0	900004	10001	1		/home/anacris	bash	684	100	300Mb	1000Mb	student	nao	\N	\N
rmarchi	$1$50ltfo55$iwzuTehvAzhP6FQKP/ewu1	900028	10001	1		/home/rmarchi	bash	712	200	500Mb	1000Mb	student	sim	\N	\N
luis	$1$4GCB0k0u$4igxGpSdTn0.CQaIxjvDU0	900001	10001	1		/home/luis	bash	681	200	500Mb	1000Mb	student	nao	\N	\N
wembesom	$1$zc2N2Y2j$AIUMr2iBrRH5fop13COrL/	2488	10001	1		/home/wembesom	bash	590	200	300Mb	1000Mb	student	sim	\N	\N
pa	$1$WwC5fHM8$DHFHCA2vTA8ilHYf/ArU70	2158	10001	1		/home/pa	bash	460	130	300	1000Mb	student	sim	1286648283	2
adri	$1$z7VrvOwo$tLWOYD/bcBDeXPxdrr0fD.	900036	10001	1		/home/adri	bash	720	200	500Mb	1000Mb	student	nao	\N	\N
leogomes	$1$irsFGajK$JD3FaSEIt0z9215pIELsR/	2489	10001	1		/home/leogomes	bash	591	200	500Mb	1000Mb	student	nao	\N	\N
cezana	$1$DiEq6QAt$KWCUyCjUKuYVvcRX7bO4z.	2338	10001	1		/home/cezana	bash	534	200	500Mb	2000Mb	fonctionnaire	sim	\N	\N
tporto	$1$37Z8skyu$lNcY.q675O/s1ZYZHIe4/1	900029	10001	1		/home/tporto	bash	713	200	500Mb	1000Mb	student	sim	\N	\N
limaventur	$1$o10kyTf0$wIzd5CmsfNRQzmuMDwji10	2522	10001	1		/home/limaventur	bash	625	200	500Mb	1000Mb	student	nao	\N	\N
mrreis	$1$gyOCZLY7$NZV9HW1S1x8ZsBPcQKuIU/	2398	10001	1		/home/mrreis	bash	433	200	300	1000Mb	student	nao	\N	\N
andrec	$1$NfJn65k7$VR5QRvB2G9Vq.Ap9ORxRd.	2493	10001	1		/home/andrec	bash	595	100	300Mb	1000Mb	student	sim	\N	\N
brunocesar	$1$HIbVtrnn$AvYf.3CIacfyeeo6/0LY60	2545	10001	1		/home/brunocesar	bash	648	100	300Mb	1000Mb	student	nao	\N	\N
tertu	$1$HWSxUaqk$Z1VZSZBz0Fubm096N//zZ0	2307	10001	1		/home/tertu	bash	418	200	500Mb	1000Mb	student	nao	\N	\N
jbrito	$1$3IQGi5C9$KmU0jGtGLSJE3bwOzC0L/1	2376	10001	1		/home/jbrito	bash	588	300	300Mb	1000Mb	student	nao	\N	\N
claudwag	$1$bolEbxYT$9PgXy.Ir1hENUwHNGpx261	900049	10001	1		/home/claudwag	bash	732	100	300Mb	1000Mb	student	nao	\N	\N
sunamita	$1$JPbcg2IL$ygv9YbgLUd6T4bWRe/eJr1	2491	10001	1		/home/sunamita	bash	593	200	300Mb	1000Mb	student	nao	\N	\N
rangel	$1$SvxkPVjT$4QJbLO69GFl000IGvNSqW/	2203	10001	1		/home/rangel	bash	416	200	500Mb	1000Mb	student	sim	\N	\N
martins	$1$0ZJMuaSP$spcZymbU/RcPlZ.yaf8rb/	900056	10001	1		/home/martins	bash	739	100	300Mb	1000Mb	student	nao	\N	\N
vinielias	$1$9pnRofZH$GoLQqImhU788DkUZF/Acy/	900053	10001	1		/home/vinielias	bash	736	100	300Mb	1000Mb	student	nao	\N	\N
dnantes	$1$MTZW1jh4$XZjpWPFomIieN.ttgLb9N1	2409	10001	1		/home/dnantes	bash	442	130	300	1000Mb	student	nao	\N	\N
limamat	$1$ztRiQH.m$CL0vfJMTiDqZvTm0Laf/Q.	900007	1001	1		/home/limamat	bash	687	200	500Mb	1000Mb	student	nao	\N	\N
jefferson	$1$GUnSDZdb$2E0bwexCnrkJn/CH77S2K0	2487	10001	1		/home/jefferson	bash	589	200	500Mb	1000Mb	student	nao	\N	\N
joaopaulo	$1$eP2GgE8p$bo8IH1ZtgEHX.ncZBWetr.	2508	10001	1		/home/joaopaulo	bash	610	200	300Mb	1000Mb	student	nao	\N	\N
lehrer	$1$KBtDpcUK$T1.hZcBHifZ7XwZGjq74d1	900014	10001	1		/home/lehrer	bash	695	200	500Mb	1000Mb	student	nao	\N	\N
simones	$1$VWvusrJf$vkkzCWsaSZhvJ5rl4Ro3q0	2339	10001	1		/home/simones	bash	444	100	300	1000Mb	student	nao	\N	\N
tonires	$1$76VcUq5/$HAFOi9ATg3cfO/WbeHw4c0	2523	10001	1		/home/tonires	bash	626	200	500Mb	1000Mb	student	sim	\N	\N
otto	$1$r4T5VLxo$ANxeOX0RLIS3QNH9VC7Jm.	900057	10001	1		/home/otto	bash	740	100	300Mb	1000Mb	student	nao	\N	\N
blourenco	$1$6ktZuAtC$4VSubo0IrL/SqNMsN.kAP1	900065	10001	1		/home/blourenco	bash	748	100	300Mb	1000Mb	student	sim	\N	\N
fabio3	$1$AXH0dlE1$k50V/PxYvRrkCO2k/mEmy0	900051	10001	1		/home/fabio3	bash	734	100	300Mb	1000Mb	student	nao	\N	\N
lmaycon	$1$GHaJpX/Z$SsRd9WnkT2tWjruZzbIio.	900055	10001	1		/home/lmaycon	bash	738	100	300Mb	1000Mb	student	nao	\N	\N
thay	$1$gT7vBEP/$ChMAH.o.I9orDSIT2.hnW0	2471	10001	1		/home/thay	bash	570	200	100Mb	1000Mb	student	nao	\N	\N
vivian	$1$/XnOvhiQ$/QZ1d61T5Wt/V7KzQs3pm0	900040	10003	1		/home/vivian	bash	724	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
valdircs	$1$czxt2pv1$O4uNz17by6PTlrf6piwdV/	2483	10003	1		/home/valdircs	bash	582	300	500Mb	1000Mb	fonctionnaire	sim	\N	\N
jean	$1$e47USFNZ$WZLMNFkUvVEmz2BQXK.4Q0	2559	10003	1		/home/jean	bash	662	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
cida	$1$e8WO8rik$B6.sC1ALbVeIQoR6ezjJJ0	900067	1003	1		/home/cida	bash	749	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
aparecida	$1$e8WO8rik$B6.sC1ALbVeIQoR6ezjJJ0	900068	1003	1		/home/aparecida	bash	749	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
diogo	$1$LNeuSI7X$LlA56uAanMfsMmX2j.6kt/	900070	10001	1		/home/diogo	bash	752	100	300Mb	1000Mb	student	nao	\N	\N
manuela	$1$h8sso8BK$3zdroI0Z2weamn3rkhFe5.	2408	10001	1		/home/manuela	bash	415	300	100Mb	2000Mb	fonctionnaire	sim	\N	\N
thiago	$1$fLUjU6kw$Q0BfkgcfCp6drY9xENxVd/	2532	10001	1		/home/thiago	bash	635	130	300Mb	1000Mb	student	nao	\N	\N
barroso	$1$I.kHNjLC$D7VTAgmw.R3NrP5rRjHKg.	2277	10001	1		/home/barroso	bash	469	300	500Mb	1000Mb	student	sim	\N	\N
edsilva87	$1$v57BoQX0$PJhp3qnkp.GdoZCZAfCeg.	900061	10001	1		/home/edsilva87	bash	744	100	300Mb	1000Mb	student	nao	\N	\N
catia	t3ir3XXUPIOQI	74	10004	1		/home/catia	bash	517	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
rovig161	$1$n9mwBY2A$qz1FmmivHPpNfzgY/LMm91	900074	10001	1		/home/rovig161	bash	756	100	300Mb	1000Mb	student	nao	\N	\N
norai	47ljKho3I4JPg	64	10004	1		/home/norai	bash	507	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
caroflower	$1$E0PosFdf$kLiDfoILWSycz/BLWw2aV.	900077	10001	1		/home/caroflower	bash	759	100	300Mb	1000Mb	student	nao	\N	\N
benedito	$1$vFJ22zQj$a0L5TveIKGH/ROo25urL01	900078	10001	1		/home/benedito	bash	760	200	500Mb	1000Mb	student	nao	\N	\N
ruviaro	$1$LH3ZdjGg$zZgmvJft5XtPFw.9GXBEK0	2309	10001	1		/home/ruviaro	bash	417	200	500Mb	1000Mb	fonctionnaire	nao	\N	\N
renata	$1$J9IjpP9x$Zu1C9hFgTgGaCjggcBte41	900033	10001	1		/home/renata	bash	717	100	300Mb	1000Mb	student	sim	\N	\N
diego	$1$mjuzFwEw$rC2QOmB5u7pdTPMYskYSE/	2530	1001	1		/home/diego	bash	633	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
bezerra	$1$B9ggRFoV$qvsgctzoNU/fOWdyxL6s9/	900032	10001	1		/home/bezerra	bash	716	200	500Mb	1000Mb	student	sim	1306506561	0
ricardojd	$1$tP/xVxPX$SzNA4fWq.oZ5NJHG1Lidn/	900073	10001	1		/home/ricardojd	bash	755	100	300Mb	1000Mb	student	sim	\N	\N
poch312	$1$EfRct5lf$H0q7BJrOY4msKJvXcoWsI.	900080	10001	1		/home/poch312	bash	762	100	300Mb	1000Mb	student	nao	\N	\N
prodrigo	$1$hwPsuu/5$aBcmHCTVnYeSnYnDV7UYk1	900076	10001	1		/home/prodrigo	bash	758	100	300Mb	1000Mb	student	nao	\N	\N
eduardo	$1$2LyK89di$piNFKjS1jcqQvpY9se37P0	2479	10001	1		/home/eduardo	bash	578	300	1000Mb	1000Mb	fonctionnaire	sim	\N	\N
edivaldo	$1$pO78A2rg$1IffKStGzEKDkMjOKSLTf0	900081	10001	1		/home/edivaldo	bash	763	100	300Mb	1000Mb	student	nao	\N	\N
ningweicui	$1$h0NyzwNK$/Yk4F8hQOetiPFM9aBXG6/	900082	10004	1		/home/ningweicui	bash	764	300	500Mb	2000Mb	visitor	nao	\N	\N
kellcio	$1$o6YQwD7F$36.Z4DBVkN82Fe9ExdArs1	2552	10004	1		/home/kellcio	bash	655	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
emerson	$1$LtyE1xsC$mLWDq4.X62ucGKrijkb.9.	900050	10001	1		/home/emerson	bash	733	200	1000Mb	1000Mb	student	nao	\N	\N
getulio	$1$hIkDodp6$y91JmKezL9Tu4XUgFJL4a1	900083	10001	1		/home/getulio	bash	765	100	300Mb	1000Mb	student	nao	\N	\N
yuri	$1$NdEH3S/q$poqP4pgjCgTYWmLFvXkeG/	2551	10002	1		/home/yuri	bash	654	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
lsantana	$1$ESsMJlAb$lFfn//7.iGF6dWuDNp9IG/	2528	10003	1		/home/lsantana	bash	631	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
manuel	$1$lXjVXnHM$/wYdOxAcUkaKZAQ8L4Hqs/	2486	10003	1		/home/manuel	bash	586	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
goulart	$1$GN2Aytfo$GU8ifYIsMI9tsP7u4GEfV/	305	10001	1		/home/goulart	bash	471	200	500Mb	1000Mb	student	sim	\N	\N
Ilana	$1$IHMvQmhk$4chUE2tCIbnF/tub6UNTx.	900031	10001	1		/home/Ilana	bash	715	100	300Mb	1000Mb	student	nao	\N	\N
acciarri	$1$jt9vRcO0$fMtaEbOPQfJnoK0aKkVQt.	900037	10002	1		/home/acciarri	bash	721	100	100Mb	1000Mb	visitor	sim	\N	\N
zhou	$1$F1honGT7$32Sa/kTm9g5.a/KVXaFZc/	2240	10001	1		/home/zhou	bash	464	300	1000Mb	2000Mb	fonctionnaire	nao	1305639877	1
luavila	$1$LWxJGEHW$KYNNpqNuLD1kdXQn3imBC1	2501	10004	1		/home/luavila	bash	603	300	500Mb	2000Mb	fonctionnaire	nao	1323102184	3
mtgaspar	$1$clp86hrq$iFtQb5vAFEkKnVqjeQGQY1	157	10004	1		/home/mtgaspar	bash	474	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
felipe	$1$fC57vbkM$8WTK.57uheCP5iG151HlM/	2505	10001	1		/home/felipe	bash	608	100	300Mb	1000Mb	fonctionnaire	nao	\N	\N
brunotreis	$1$6SM5h5wj$2hfmtCrInZYxXKdHqz0IO0	900079	10001	1		/home/brunotreis	bash	761	200	500Mb	1000Mb	student	nao	1324492649	1
eudes	$1$5zFKOf80$va2L7bOAL7nncYYX0lX3./	2564	1001	1		/home/eudes	bash	667	200	500Mb	1000Mb	student	nao	\N	\N
kelem	$1$CjtxT4Kq$Nuh3EmKku/YoHen8HWPmI.	2377	10001	1		/home/kelem	bash	424	200	300	1000Mb	student	nao	\N	\N
anamaria	lq/G69sPsmISI	206	10004	1		/home/anamaria	bash	548	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
sash	$1$bqjQLt4D$30wT18fjiZgOY29vwS9sD0	41	10004	1		/home/sash	bash	489	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
jairogiant	$1$nSoj.mkr$9KTy2aV8U1iaN5PlXKRSV/	2525	10001	1		/home/jairogiant	bash	628	100	300Mb	1000Mb	fonctionnaire	nao	\N	\N
alexandre2	$1$VesPrqaA$ikLRrUpXDUF3QBxh2t0bR.	900085	10003	1		/home/alexandre2	bash	767	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
guy	$1$9e0fjOc7$P2.nZ9cwYa5VIrg9TxRrb.	1133	10004	1		/home/guy	bash	410	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
ricardon	$1$fnHb4P5b$Y0D5P8c6RbFL.S0CENB2l1	2521	10002	1		/home/ricardon	bash	624	200	100Mb	1000Mb	visitor	nao	\N	\N
livia	$1$d1wsMX1a$MWAu87QXjKqPi0tKxKaC//	900066	10003	1		/home/livia	bash	750	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
jaime702	$1$kGeEEb6.$RmeuGBY9zl4/yDdaOmVPh1	900088	10001	1		/home/jaime702	bash	770	100	300Mb	1000Mb	student	nao	\N	\N
phelippe	$1$q8eT14cj$mN6.tdtlIsuZzZtapj18F.	900089	10002	1		/home/phelippe	bash	771	100	100Mb	1000Mb	visitor	sim	\N	\N
cauchy	$1$NGlwomrX$3fGxtHtF1dC8bOrVPHQyo1	2475	10001	1		/home/cauchy	bash	574	100	100Mb	1000Mb	student	nao	\N	\N
amorim	$1$8RIhTW6T$vAOczBD2zKHxtvnIAr64q.	1022	10004	1		/home/amorim	bash	501	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
rfilho	$1$Cun35NYM$cjNZzmt2uwGI0Adzm.cN//	2510	10001	1		/home/rfilho	bash	612	100	300Mb	1000Mb	student	nao	\N	\N
ismael	$1$GHeENIQp$w2FCKSIUAVO6uqpWWc2sX1	2566	10001	1		/home/ismael	bash	669	100	300Mb	1000Mb	student	nao	\N	\N
dhiego	$1$oTK84aiE$p73C5.csEIMcfnsW6RybA.	900005	10001	1		/home/dhiego	bash	685	100	300Mb	1000Mb	student	nao	\N	\N
uelison	$1$vvAMkYew$R0PK7quw8Qo6ueYgigwWH0	900090	10001	1		/home/uelison	bash	772	100	300Mb	1000Mb	student	nao	\N	\N
apchaves	$1$NRoieua8$tyHj0ABBmH8gaJrjymbJv.	900006	1001	1		/home/apchaves	bash	686	200	500Mb	1000Mb	student	nao	\N	\N
alfamath	$1$VpOQpeTG$hhNrp35Vh.uPmoYQL0gCB/	900075	10001	1		/home/alfamath	bash	757	100	300Mb	1000Mb	student	nao	\N	\N
tiago	$1$NugI1Crq$TxFoEfIOG/rxhD65fnlHS0	900034	10001	1		/home/tiago	bash	718	100	300Mb	1000Mb	student	nao	\N	\N
amatodani	$1$uwVjCcs0$XgW/3Ogledenu/7r8imph.	900072	10004	1		/home/amatodani	bash	754	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
matheus	$1$ii0k665t$UYGFaCaSXuhg2VRhN3TAa/	2541	10001	1		/home/matheus	bash	644	100	300Mb	1000Mb	student	nao	\N	\N
junior	$1$ND/SZmO0$6Pah6seTcAFVTuZBaS8Gn0	900095	10001	1		/home/junior	bash	777	200	500Mb	1000Mb	student	nao	\N	\N
bruno	$1$yrYbXveB$hVM4SwKrlch98iw028Lmv1	900097	10001	1		/home/bruno	bash	779	100	300Mb	1000Mb	student	nao	\N	\N
saulo	$1$NZoX5.XC$OgkaqLfkfP6deNlOsBlby/	900098	10001	1		/home/saulo	bash	780	100	300Mb	1000Mb	student	nao	\N	\N
alexsoares	$1$xLM37lh5$tdd7hbS6vqL8f7CoVraWV0	900059	10001	1		/home/alexsoares	bash	742	100	300Mb	1000Mb	student	nao	1302213720	1
tarcisio	$1$6JBXo8G2$kebYG1I18ajBWTfSY8gvI/	2524	10001	1		/home/tarcisio	bash	627	200	300Mb	1000Mb	student	nao	\N	\N
ataias	$1$TqvPAWa/$4fFlcIU.Vfwnur9SE/EGl1	900099	10001	1		/home/ataias	bash	781	100	300Mb	1000Mb	student	nao	\N	\N
nmayer	$1$IPI2SB2Y$xPSZ6CM76RHOv4cLO51UI/	900048	10001	1		/home/nmayer	bash	731	200	500Mb	1000Mb	student	nao	\N	\N
alex	$1$qHKu0aVD$Z9uwL96qxQAHViRVXuuQd1	900100	10001	1		/home/alex	bash	782	200	500Mb	1000Mb	student	nao	\N	\N
sonia	$1$8NwewEe8$FPjjwuXiiEfbjwJVNUn/i1	900101	10001	1		/home/sonia	bash	783	100	300Mb	1000Mb	student	nao	\N	\N
ederbrito	$1$H1F.9LjT$JOfTD4Op1/HSQ6fDh06IY0	900102	10001	1		/home/ederbrito	bash	784	100	300Mb	1000Mb	student	nao	\N	\N
selminha	$1$AEMPnjVj$/H3dZn5h6m6sqWP3d2fuC0	2574	10003	1		/home/selminha	bash	677	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
anyelle	$1$v7k7JtZa$jIBIuhh8Iaox4rql57TIS0	2303	10004	1		/home/anyelle	bash	411	200	500Mb	2000Mb	student	nao	\N	\N
norabuena	$1$DhQ5MHYQ$s5G2h1.ApNyfe8iJHwFhh1	900087	10001	1		/home/norabuena	bash	769	100	300Mb	100Mb	student	nao	\N	\N
julian	$1$5KMQ3Wog$XQGLcioZH1QJ/3ADhFm.z1	900086	10001	1		/home/julian	bash	768	100	300Mb	1000Mb	student	nao	\N	\N
andreia	$1$QLg3FTPX$xxGXzGmzMuW5g5D8Nf/w5/	2354	10001	1		/home/andreia	bash	594	200	300Mb	1000Mb	student	sim	\N	\N
eliana	$1$S5kTw1T4$ITJjwA9961padWX2g38fh1	900103	10003	1		/home/eliana	bash	785	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
pedroeloy	$1$RMmm4KHK$Di6rohyKDlsGXE8t1ghDl.	900069	10001	1		/home/pedroeloy	bash	751	100	300Mb	1000Mb	student	nao	\N	\N
linniker	$1$zJ4INOwt$uVjd.CHEMD83VX45llzBm0	900054	10001	1		/home/linniker	bash	737	200	500Mb	1000Mb	student	nao	\N	\N
alinef	$1$D0l/NLM8$HS4E6OPPxXc/F4wPLa6MG.	2181	10001	1		/home/alinef	bash	587	200	500Mb	1000Mb	student	sim	\N	\N
galdino	$1$PDIgTzec$.zdOtA3hoVlkKx.PsEUUf0	2245	10001	1		/home/galdino	bash	581	200	500Mb	1000Mb	student	nao	\N	\N
marias	$1$ph0qol9e$yIzOn6N/sX/qHM.UhDgrt/	900021	10001	1		/home/marias	bash	705	100	300Mb	1000Mb	student	nao	\N	\N
tiago02	$1$vs4fsRg2$yjhfKNwdUuVNeCbWEpCNy/	900091	10001	1		/home/tiago02	bash	773	100	300Mb	1000Mb	student	nao	\N	\N
lemos	$1$rzT1C8fa$0ztmS1blIfiONaNHp4AeR.	2275	10001	1		/home/lemos	bash	468	200	500Mb	1000Mb	student	nao	\N	\N
bianka	hYP06CYO/yHJc	2251	10001	1		/home/bianka	bash	455	200	500Mb	1000Mb	student	nao	\N	\N
janete	$1$MdRZYf.G$PdU60A3zqcVmJJycCdPaS1	2369	10001	1		/home/janete	bash	463	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
henriquerz	$1$2wdFXWth$BRVuxEEqzOdocWga96QGw/	900009	1001	1		/home/henriquerz	bash	689	100	300Mb	1000Mb	student	nao	\N	\N
demiranda	$1$69b/7XL0$I7bBxBbZe..CUvGxTK89D.	900064	10004	1		/home/demiranda	bash	747	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
rabelo	$1$Sdsn0T2s$a63Ay/eGs/WV/UlOyqnS3/	27	10004	1		/home/rabelo	bash	505	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
flaviaf	$1$4lD5zpCM$ZsBM7wUa0uP8NztR3oSj2.	2304	10001	1		/home/flaviaf	bash	412	300	2000Mb	2000Mb	fonctionnaire	nao	\N	\N
luciene	UdQ3PrdkMk2/U	2343	10001	1		/home/luciene	bash	421	200	500Mb	1000Mb	student	nao	\N	\N
alexandre	$1$LkoWX6qS$6tPkTYMZAi/hS4wfsVVIE.	900084	10003	1		/home/alexandre	bash	766	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
vinicius	$1$pkm7FyW8$rZcCVIu/kk2FYqRazYKH..	2535	10001	1		/home/vinicius	bash	638	100	300Mb	1000Mb	student	nao	\N	\N
lseco	$1$P61C4bmp$5C9/labYDSCZLDBQeXWEf/	2554	10004	1		/home/lseco	bash	657	350	500Mb	2000Mb	fonctionnaire	nao	\N	\N
solange	$1$ASu9iQJx$Gdh3G/lZKwpf6MYsDYjmW/	900104	1003	1		/home/solange	bash	786	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
zapata	$1$h4f7M2iE$cNDomIivzzxGiagJzncLl.	2247	10001	1		/home/zapata	bash	473	200	500Mb	1000Mb	student	nao	\N	\N
magno	$1$YPe/yh8/$oJBJslVaQusJod08GVZDy1	2331	10001	1		/home/magno	bash	472	200	500Mb	1000Mb	student	nao	\N	\N
dimas	$1$eOC.30nE$qzbR4k96kgpC0UVJ2bmek/	2558	10004	1		/home/dimas	bash	661	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
pellegrini	$1$8O/m3pvq$xDbcNjW.Js7c27YnNeKuh1	900045	10002	1		/home/pellegrini	bash	728	300	1000Mb	2000Mb	fonctionnaire	sim	\N	\N
kaliana	$1$v25SrwkW$QNRXYNWmwy0AsbfoSNMsr.	2400	10001	1		/home/kaliana	bash	547	200	300	1000Mb	student	nao	\N	\N
clodomir	$1$9CKgONBU$41byjv.xZDtvrkcueAf830	900027	10001	1		/home/clodomir	bash	711	100	300Mb	1000Mb	student	sim	1288207283	2
wilson	$1$xHKosTKr$Vdj.kPYx6hj2m0XagAeT10	900094	10001	1		/home/wilson	bash	776	100	300Mb	1000Mb	student	nao	\N	\N
moxh	$1$FWvYikZT$yHK7xOgcwzSQs6AA2CxK2/	900105	10002	1		/home/moxh	bash	787	100	100Mb	1000Mb	visitor	nao	\N	\N
josimar	$1$3VXg1I1/$eSv6euC39J6OSlugkxbWH.	900092	10001	1		/home/josimar	bash	774	100	100Mb	1000Mb	student	nao	\N	\N
george	$1$lZjFy6P8$DuR6FrSnL6rrMOzm0W6g21	900071	10003	1		/home/george	bash	753	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
claudiano	$1$.Z19mAai$FRrbeCZCRXohuWn2rZsJz1	2499	10001	1		/home/claudiano	bash	601	200	500Mb	1000Mb	student	nao	\N	\N
jhoel	$1$qbTjx74W$rLn5scA8NMFNTvW8vNsyz0	900093	10001	1		/home/jhoel	bash	775	100	100Mb	1000Mb	student	nao	\N	\N
joaby	$1$ranrhx7h$iLQYR85JxdomN1H9ND0c20	2538	10001	1		/home/joaby	bash	641	100	300Mb	1000Mb	student	sim	\N	\N
bruna	$1$w.n6G2tE$07WPnh0RE25UCC1TZfq/U.	900106	10003	1		/home/bruna	bash	788	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
allan	$1$uzVogCXh$oNUwGznF6ZwHiXa/d43h5/	900026	10001	1		/home/allan	bash	710	100	300Mb	1000Mb	student	sim	\N	\N
tote88	$1$.Uc1Jb2W$z0wfUHBx9Jo.I0d6QgCk/.	2575	10001	1		/home/tote88	bash	678	100	300Mb	1000Mb	fonctionnaire	nao	\N	\N
mayra	$1$HfbQMMM7$siwgL5/7Jft23HuwkYotI/	2515	10001	1		/home/mayra	bash	618	100	300Mb	1000Mb	fonctionnaire	nao	\N	\N
adail	$1$a48dbInz$yv/sN66VqUjn4tvCoKZz71	2265	10004	1		/home/adail	bash	454	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
alineg	$1$MEll1v1M$0XA.OmEtE1Ap8MTAav6Xr.	300	10004	1		/home/alineg	bash	491	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
cioletti	$1$eQfqKJVb$QDydtDpavqHbjDVfchFgt1	2555	10004	1		/home/cioletti	bash	658	300	500Mb	2000Mb	fonctionnaire	sim	\N	\N
eveline	$1$1zphrVk/$r0bzAHu0sjnpuBgNOWcc.0	2468	10003	1		/home/eveline	bash	567	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
addan	$1$4GU3SjuL$vWNSWrtBXb1gOLJbDnfg21	900096	10001	1		/home/addan	bash	778	100	300Mb	1000Mb	student	nao	\N	\N
msoares	Ob0TreVY8bsXQ	147	10004	1		/home/msoares	bash	503	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
batista	$1$Ff6lLLz8$Fm46oupDtsx7gYhhnI0qf1	900108	10001	1		/home/batista	bash	790	200	500Mb	1000Mb	student	nao	\N	\N
hellysson	$1$ukXO700f$zQmXijViP4jW0koHg.2m90	900063	10001	1		/home/hellysson	bash	746	100	300Mb	1000Mb	student	nao	\N	\N
jurandir	$1$z2mXGlK1$cAJnjUhexmWMSoNBct20x0	900109	10002	1		/home/jurandir	bash	791	100	100Mb	1000Mb	visitor	nao	\N	\N
alysson	$1$J076o0Aa$jUmkcMtbb76JDikI5WLFG0	900107	10002	1		/home/alysson	bash	789	100	100Mb	1000Mb	visitor	sim	\N	\N
rejane	$1$3Az6C6xX$605KWQkKFrmG4cOyN7UHJ.	2477	10003	1		/home/rejane	bash	576	9999	500Mb	1000Mb	fonctionnaire	nao	\N	\N
bastos	$1$30Lleb0l$LF73roMuXr5JWC66Vp/Ci1	900020	10001	1		/home/bastos	bash	704	200	500Mb	1000Mb	student	nao	1348852920	1
jamer	$1$eOuvu9H4$.Kbh7IiUGIXjTWzV1U6ge.	900110	10001	1		/home/jamer	bash	793	100	300Mb	1000Mb	student	nao	\N	\N
valdiego	$1$FvVrcMmn$NfRqtTN2iRyF3UJPTkXKx.	900052	10001	1		/home/valdiego	bash	735	100	300Mb	1000Mb	student	nao	\N	\N
sbruschi	$1$5PBrZM.t$ImLuwiYuApc260QME9sXc1	2577	10004	1		/home/sbruschi	bash	680	300	500Mb	2000Mb	fonctionnaire	nao	\N	\N
\.


COPY users (coduser, name, firstname, matricul, cpf, identity, phone_work, phone_home, adresse, cp, city, is_actif, tipo_users) FROM stdin;
583	Anderson Luiz	Pedrosa Porto	0652059	033.215.556-03	MG 10157751	32733356	35561486	Quadra 56 lote 08 Ed Roma Apt 411 Setor Central - Gama	72450060	Brasilia	t	student
532	Mara Jane 	Neves Lima Freire	1020561	076.208.927-02	013909046 MDF/RJ	32733356	32736889	SQN 411 BL b APT 309	0000000	Brasilia	t	professor
617	Oleksandr	Borisenko		159.357.654-98	9852360	32733356	32733356	Universidade Kharkov Ucrania	709109000	Brasilia	t	visitor
647	Gabriel 	Silva Carvalho	0909645	036.859.821-76	2594168	32733356	35610076	QND 25 bl A apt 304	72120250	Brasilia	t	student
598	Ana Paula 	Dias Oliveira	0784435	890.290.891-72	310392 SSP/TO		6184032598	QI  03 lt. 280 Apto 202	72445030	Gama	t	student
0	root		023456	01674055153	0933187	-----	33072442	France : 465 chemin des terriers	83470	Saint Maximin	t	\N
599	Lorena Even Nazareth	Brandizzi Carvalho	1025790	730.437.961-87	2231314	33072442	96530077	QS 6 CONJ 240A CASA 10	71966360	TAGUATINGA SUL	t	administrativo
447	Porfirio	Azevedo dos Santos	0389901	590.745.741-49	3169011 DGPC/GO	32733356	33404916	SQN 411 bl A apt 108	70866010	Brasilia	t	student
621	Angelo 	Roncalli Furtado de Iolanda	2318390	529.650.904-87	1146140	32733356	87097353	Rua José Aranha, 456 Campina Grande	58103500	João Pessoa-PB	t	visitor
632	Manoel	De Oliveira Nogueira Neto	0690520	958.211.301-04	1978706		333948205	QR 117 Conj. X Casa 05	72547423	Santa Maria - DF	t	student
402	Jairo	Athayde Cavalcante	115126	059.980.691-53	409966 SSP/DF	32733356	32458312	SQS 414 bl K apt 101	70297110	Brasilia	t	professor
663	Sergio Luis	Soares Almeida	090072103	516.206.851-91	1146960 	32733356	33582978	QR 122 conj. 11 casa 07 Samambaia Sul	72304211	Brasilia	t	student
668	Natanael	Martins Neves	1234560	092.568.902-59	4365019-SSP-PA		32634216	410N Bloco I ap. 305	70865090	Brasília	t	student
613	Wesley 	Ferreira Lopes	0540099	017.457.681-14	2303341 SSP/DF		33725343	QNN 19 CONJUNTO M CASA 40	72225203	CEILÂNDIA	t	student
505	Mauro Luiz	Rabelo	662984	222.761.901-59	M-1393787 SSP/MG	32733356	33682600	SHIN QL 10 conjunto 01 casa 03	72525015	Brasilia	t	professor
673	Victor 	Barbosa Jatobá	1008200	031.977.641-70	2463515 SSP/DF	38773048	81866154	EPTG QE 04 Bloco AIS Apto 103 Lúcio Costa	71100165	Guará	t	student
584	Leon	Solon	0845906	890.655.491-53	1957083 SSP/DF	32733356	81140234	Sobradinho/DF	70900010	Brasília	t	student
600	Olivier	Siegenthaler		000.000.000-00	0000000	33072442	33072441	Colina UnB	70910900	Brasília	t	visitor
492	Keti	Tenenblat	049182	269.717.127-49	2118553 IFP/RJ	32733356	33641754	SHIS QI 16 conjunto 01 casa 05	71640210	Brasilia	t	professor
577	Thaisy	Oliveira espindula	737326	013.428.551-40	737326 ssp/to		6234512061	rua c 9 quadra 17 lote 16	73840000	Campos belo goias	t	student
448	Raul	Moreira Behs	0455741	075.594.677-41	1520470 SSP/DF	32733356	32257984	HIGS 703 bl E casa 15	70331705	Brasilia	t	student
659	Francisco	Gondim Andrade Júnior	1589265	006.552.631-79	6758134-MMAR/DF		33071330	UnB Colina Bloca H Ap. 607	70904108	Brasília	t	administrativo
520	Helder 	De Carvalho Matos	739286	226.348.601-10	333884 SSP/DF	32733356	00000000	SQS 302 bl H apt 201	70380080	Brasilia	t	professor
674	Paula 	Macedo Liv de Araújo	1003640	012.446.141-73	2747042 SSP/DF	98316579	32537060	SQB Bloco N Apto 601 Guará I	71009000	Guará I	t	student
664	Irina	Sviridova	123456	752.933.401-82	Passaporte 63 N� 0150487		6181724365	STN - Setor Terminal Norte, Lote K Ed. Montreal Apto 31 - Asa Norte	70770100	Brasilia	t	professor
506	Nigel John	Edward Pitt	151688	699.867.381-72	V 173686-Z	32733356	34477049	SQN 215 bl J apt 607	70874100	Brasilia	t	professor
585	Rodrigo	De Castro Miranda	0422827	645.600.661-91	139859 SSP/DF	32733356	99645360	Asa Norte	70900010	Brasilia	t	student
665	Ana Paula	Ganassoli	0961108	060.620.419-97	90925849	32733356	37977823	SQN 412 Bl A apt 104	7000000	Brasília	t	student
634	Adriana	De Albuquerque Pacheco	0677558	000.180.961-07	2467561 SSP/DF	32733356	30347424	SQSW Q. 101 bl D ap 607	70670104	Brasília	t	student
404	Leonardo	Lazarte	118371	507.324.807-44	819896 SSP/DF	32733356	33071649	Colina bl I apt 401	70904109	Brasilia	t	professor
493	Claus	Akira Matsushigue	1013840	115.560.778-31	5130271 SSP/SP	32733356	33497513	SQN 410 bl A apt 203	70865010	Brasilia	t	professor
549	Haydee	Werneck Poubel	102610	434.842.397-00	243350 SSP/ES	32733356	0000000	SQN 307 bl I apt 601	70746000	Brasilia	t	professor
419	Vagner	Rodrigues de Bessa	0761745	053.486.896-70	11946651 SSP/MG	32733356	00000000	SCLN 406 bl B sub solo 40	0000000	Brasilia	t	student
449	Tania Maria	Machado Carvalho	0455806	294.387.018-85	274432687 SSP/SP	32733356	00000000	UnB Colina K apt 303	70910900	Brasilia	t	student
521	Joao Carlos	Nascimento de Padua	146633	491.835.837-34	M-18236 SSP/MG	32733356	32733476	SQN 210 bl G apt 307	70862070	Brasilia	t	professor
649	Weslley	Pinheiro Barreto	0960951	014.231.521-40	3971055 SSP/GO		6296118198	CLN 411 Bl. C Sala 221	7200000000	Asa Norte	t	student
660	Joao Vitor	Goncalves de Almeida	0843784	006.784.191-08	2235984 SSP/DF	32733356	33563313	SQS 215 Bl K Apto. 202	70294110	Brasilia	t	student
615	Kenneth	McLaughlin	01034839	058.678.937-58	206117376	32733356	30341228	Chacara 5, Sitio das Oliveiras	7000000	Brasilia	t	professor
629	Bruno 	De Oliveira Nogueira	0531481	726.477.521-68	2243337 SSP/DF	93011932	39631418	QI 07 Conj. M Casa 15 - Guará I	71020136	Guará I	t	student
450	Rosangela  Maria	Da Silva	0497347	761.643.651-04	3112668589454 SSP/GO	32733356	34478480	SQN 405 bl A  06	70846510	Brasilia	t	student
420	Elenilson	De Vargas Fortes	1024132	078.304.587-58	1507107 SSP/ES	32733356	00000000	SCLN 406 bl B sub solo 40	70847520	Brasilia	t	professor
650	Phillipo 	Lappicy 	0737186	029.011.131-50	2701389 SSPDF	32733356	34439079	SQS  106 Bloco D apt 204	70345040	Brasilia	t	student
494	Helmar	Nunes Moreira	701301	077.783.412-04	085527059 SEPC/RJ	32733356	33407829	SQN 108 bl H apt 103	70744080	Brasilia	t	professor
602	Grace Kelly 	Souza Carmo Goulart	1027590	945.058.961-53	4286316 DGPC/GO	33072442	81036169	SQN 410 Bloco O Apto 213	70865150	Brasília	t	student
522	Jose 	Pereira dos Santos	079464	102.446.621-34	003717 SSP/DF	32733356	33847896	Q 30 casa 12 Setor Oeste Residencial 	7000000	Brasilia	t	administrativo
666	Marcos	Mesquista Resende	0843792	014.909.921-54	2347589 SSP/DF	32733356	33479038	SQN 208 Bl H apt 408	70853080	Brasilia	t	student
405	Mauro	Moraes Alves Patrao	1017195	004.058.449-64	1632136 SSP/DF	32733356	34477004	SQS 307 bl A apt 304	70354010	Brasilia	t	professor
465	Maxwell	Lizete da Silva	0652440	665.846.047-87	1539640 SSP/DF	32733356	35914611	Quadra 08 bl 18 loja 13	73005080	Brasilia	t	student
508	Pavel	Shumyatsky	149926	693.857.421-91	2035752 SSP/DF	32733356	33073555	Colina bl G apt 305	70910900	Brasilia	t	professor
435	Shirley	Da Silva Macedo	0762822	299.980.338-96	303976913 SSP/SP	32733356	33499216	SHGN 706 bl G apt 308	70740707	Brasilia	t	student
451	Debora	Borges Ferreira	0548553	711.014.971-49	1603033 SSP/DF	32733356	72415060	Quadra 06 conjunto M casa 09	72415060	Brasilia	t	student
436	Thiago	Gonalves Dias	0739570	004.077.531-33	4761724 DGPC/GO	32733356	00000000	SQN 411 bl C apt 104	0000000	Brasilia	t	student
523	Lucimar	Oliveira do Nascimento	138665	561.424.471-91	1364589 SSP/DF	32733356	33753787	QNO 11 conjunto C casa 09 Setor O	72255103	Brasilia	t	administrativo
651	Flavia	Roberta Vieira	010203	025.312.291-08	1546825 SSP/DF	32733356	91910462	DF 280 KM 09 CH DAMACENO SAMAMBAIA NORTE	7200000	Brasilia	t	administrativo
43	Isabel Cristina	Pereira dos Santos	9999991	871.826.451-49	1844942 SSP/DF	32733357	92752406	Colonia Agricola Vicente Pires ch 89 lote 01 rua 03 Residencial Via Nobre	71095000	Taguatinga Norte	t	administrativo
495	Jorge Carlos	Lucero	989118	015.882.329-05	V 140690-3	32733356	32723878	SQN 206 bl A apt 505	70844010	Brasilia	t	professor
466	Levi	Rosa Mariano	0652415	626.328.171-53	1964840SSP/GO	32733356	00000000	SQN 410 bl H apt 108	70865080	Brasilia	t	student
406	Mauricio	Ayala Rincon	143448	688.627.171-72	1933655	32733356	33495102	SQN 315 bl C apt 604	70774030	Brasilia	t	professor
509	Raderson	Rodrigues da Silva	989070	610.056.651-68	1482631 SSP/DF	32733356	00000000	Residencial Parque ch 03 casa 17 Colonia Agricola Vicente Pires 	7095000	Brasilia	t	professor
422	Cesar Klayson 	Soares dos Santos	0651583	901.009.561-49	881971 SSP/MS	32733356	00000000	Colina bl K apt 306 UnB	70910900	Brasilia	t	student
637	Rafaela	Fernandes do Prado	090071057	020.235.281-19	2364449 SSP/DF		33400072	SQN 211 Bl C  Apto 406	70863030	Asa Norte	t	student
566	Tania	Schmitt	100307	152.342.311-00	349663 SSP/DF	81728234	38795630	Condominio Jardim America Modulo J casa 18, Setor Habitacional Contagem,	73092904	Sobradinho	t	professor
524	Arthur	Vicentini Ferreira de Azevedo	655503	151.762.661-72	260496 SSP/DF	32733356	33670831	SHIS QI 27 Conjunto 20 Casa 20	71675200	Brasilia	t	professor
588	Jorge Augusto	Gonçalo de Brito	0973921	001.450.581-90	338569911 SSP/SP	32733356	33071383	UnB Colina bl K  apt 305	70910900	Brasília	t	student
496	Celius Antonio	Magalhaes	123803	092.925.351-53	315444 SSP/DF	32733356	33281586	SQN 202 bl D apt 204	70832040	Brasilia	t	professor
652	João	Marcelo Gonçalves de Almeida	0847763	006.784.281-07	2236046 DF		33563313	SQS 215 Bl K Apto. 202	70294110	Brasilia	t	student
467	Verissimo	Pereira Gomes Neto	0652474	867.199.981-53	3516342 SSP/GO	32733356	00000000	SQN 405 bl N apt 301	0000000	Brasilia	t	student
452	Fernando Kennedy	Da Silva	0548561	937.766.911-15	4151544 DGPC/GO	32733356	00000000	UnB Colina K apt 105	70910900	Brasilia	t	student
407	Pedro	Roitman	731951	512.543.101-00	1222666 SSP/DF	32733356	33681739	SHIN QI 14 conjunto 10 casa 23	71510120	Brasilia	t	professor
589	Jefferson 	Abrantes dos Santos	0960985	039.375.414-62	2636467 SSP/PB		6199867701	SQSW 301 Bl. E Apto 411 Ed. Porto Rico	72000000	Brasília	t	student
423	Fernanda	Lima Silva	0654671	015.786.511-82	4365798 DGPC/GO	32733356	00000000	XXXXXXXX	0000000	Brasilia	t	student
408	Raquel	Carneiro Dorr	137332	545.992.456-15	M2750400 SSP/MG	32733356	33443171	SQSW 504 bl F apt 514	70673506	Brasilia	t	professor
653	Teofilo	Alberto LIma da Silva	090014278	036.232.781-57	2801573	32733356	92490995	QNG 32 casa 65	72130320	Brasilia	t	student
497	Tânia Maria	 de Santana Sertão	116637	146.031.011-04	361094 SSP/DF	32733356	30365536	Colonia Agricola Vicente Pires ch 231 casa 22 Rua 05	72110800	Brasilia	t	administrativo
606	Thiago William 	Siqueira Ramos	1027646	006.995.761-48	2271959 SSP/DF		34582907	QR 506 Conj. 12 Casa 08	72312112	Samambaia	t	student
484	Hemar	Teixeira Godinho	135062	221.957.421-00	532957 SSP/DF	32733356	33071072	SQN 107 bl H apt 104	70743090	Brasilia	t	professor
409	Said	Najati Sidki	995266	076.189.801-87	264049 SRE/DF	32733356	33681831	SHIN QL 03 Lote 08/10	71505285	Brasilia	t	professor
639	Fábio Henrique 	Da Silva	090071875	707.693.461-20	2095936 SSP/DF	39659527	84744215	QNL 20 Conj D casa 18	72161004	Taguatinga Norte	t	student
525	Carlos	Maber Carrion Riveros	993212	697.119.501-97	V 173687 X	32733356	33449359	QRSW 08 bl A6 apt 103 Sudoeste	70675806	Brasilia	t	professor
607	Leonardo 	Bernardes Nogueira	1027620	982.114.121-87	2286158 SSP/DF		32335512	AOS 01 Bl F Apto 102	70660016	Octogonal	t	student
591	Leonardo	Gomes	0847780	062.330.836-30	11885553 SSP/MG	99517230	33072442	SQN 308 Bl A Apto 508	70747010	Brasília	t	student
640	Silvia	Lopes	200200	292.325.890-87	6017184497	5133086214	5133303947	Avenida Bento Gonçalves 9500  	91509900	Porto Alegr	t	visitor
498	Jose Valdo	Abreu Goncalves	055816	068.110.001-10	282118 SSP/DF	32733356	33276796	SQN 402 bl T apt 104	70834200	Brasilia	t	professor
569	Alberto 	Santos dos Reis	0961116	930.136.471-91	40813512 DGPC/GO		6291248748	Colina UnB Bloco K Apto 202	70910900	Asa Norte	t	student
425	Lindemberg	Sousa Massa	1028375	940.803.131-87	4371477 SPTC/GO	32733356	33470653	CLN 406 bl B apt 204	70841520	Brasilia	t	professor
592	Marcos 	Pereira Goalberto	2060302	914.738.371-20	2060302 SSP/DF	81577880	32733356	Rua 73 Qd. 121 Casa 20	72000800	Luziânia	t	administrativo
426	Marcus Vinicius	 de Andrade Neves	0651711	004.648.501-50	4299378  SPTC/GO	32733356	33470653	CLN 406 BL b apt 204	70847520	Brasilia	t	student
441	Andrey 	Barbosa Guimaraes	0843717	700.061.051-49	12682497 SJMT/MT	32733356	00000000	CLN 411 bl A apt 114	70866510	Brasilia	t	student
499	Lineu	Da Costa Araujo Neto	988740	665.076.421-34	1467199	32733356	33450341	SQS 313 bl F apt 403	70382060	Brasilia	t	professor
513	Roberto Oscar	Gandulfo	072508	116.152.811-34	1510982 SSP/DF	32733356	32730918	SQN 107 bl H apt 502	71743080	Brasilia	t	professor
527	Wang	Qiaoling	1013858	711.333.481-49	2555821	32733356	32740925	SQN 206 bl A apt 405	70844010	Brasilia	t	professor
571	Hudson	Pina de Oliveira	090076133	004.405.791-12	4306896		6285244120	SCLN 411 Bl C27 Sala 225		Brasília	t	student
427	Igor	Dos Santos Lima	0715484	000.297.661-76	2142473 SSP/DF	32733356	34757409	QNJ 23 casa 17	72140230	Brasilia	t	student
642	Luiz Fernando	Frozza	090071921	654.046.101-15	603960	92579316		casa do estudante bloco b apartamento 220 unb	70910900	Brasilia	t	student
528	Hailton	Gloria Reis	999992	610.205.081-91	1425901 SSP/DF	32733356	34852909	AR 12 conjunto 05 casa 04 Sobradinho II	73060100	Brasilia	t	administrativo
500	Jose Alfredo	Silva	115428	336.873.907-72	1710611 SSP/DF	32733356	33471988	SQN 206 bl J apt 105	70844100	Brasilia	t	professor
514	Rui	Seimetz	713546	232.463.240-34	632415 SSP/DF	32733356	33071268	Colina UnB bl G apt 302	70910900	Brasilia	t	professor
610	Joao Paulo 	Dos Santos	090019474	005.475.911-01	4303571DGPC/GO	81110388	0000000	UnB Colina Bloco K Apto 102	70910900	Asa Norte	t	student
529	Jander	Amorim Silva	1016059	040.544.686-16	3700871 SSP/GO	32733356	33611201	QRO 254 SMU 7	70630000	Brasilia	t	professor
443	Renato	Ferreira da Cruz	0843831	848.959.501-15	11589051 SJMT	32733356	00000000	SQN 405 bl H apt 303	708460800	Brasilia	t	student
428	Juliana Paula	Riani Motinha	0715514	064.134.626-39	9130387 SSP/MG	32733356	33861923	Quadra 01 conjunto 03 lote 02 casa E SMPW	70735103	Brasilia	t	student
643	Adriana	Carvalho Rosa	090071468	972.307.231-91	3954538			Pça. João Pessoa, n:745		Corumbaíba - go	t	student
413	Joao Pablo	Pinheiro da Silva	0761591	713.960.392-87	3271117 PC/PA	32733356	35818976	QNM 06 conjunto I casa 03	72210060	Brasilia	t	student
501	Luiz	De Oliveira Amorim	136999	128.347.002-06	1669867 SSP/DF	32733356	33490566	QI 27 lotes 7/9 bl C apt 614 Guara	71060270	Brasilia	t	professor
515	Xia	Changyu	152871	053.781.057-90	V 187595-C	32733356	32740925	SQN 206 bl A apt 405	70844010	Brasilia	t	professor
595	André 	Caldas de Souza	090140842	539.612.931-04	1719709 SSP/DF		6134682052	SHIN CA 08 lote 03 Casa 15	71503508	Brasília	t	student
530	Luverci	Do Nascimento Ferreira	1015915	709.806.241-34	1895663 SSP/DF	32733356	32843292	Quadra 06 casa 25 Setor Leste	72450060	Brasilia	t	professor
429	Michael	Marcondes de Freitas	0715522	008.728.581-97	2182601 SSP/DF	32733356	35673896	QI 22 conjunto B casa 54	71015028	Brasilia	t	student
399	Cristiano	Oliveira	0745294	716.740.551-53	1933187 SSP/DF		33766357	Qnp 32 Conj u casa 23	72235320	Ceilandia	t	student
573	Jose Henrique	Rodrigues	042994	306.591.808-04	417234077 SSP/SP		1791382898	Rua Amilcar Roveri, 260	15828000	Palmares Paulista	t	visitor
516	Angel Rodolfo	Baigorri	126624	462.631.101-63	V 000203 Y 	32733356	33071664	Colina UnB bl I apt 102	70910900	Brasilia	t	professor
488	Pavel	Zalesski	487066	706.436.101-97	2607322 SSP/DF	32733356	33500027	Cond. Prive de Monaco, Quadra 07 casa 14	71680601	Brasilia	t	professor
445	Elida	Alves da Silva	0389722	664.120.721-87	22361000 SSP/GO	32733356	33404916	SQN 411 bl A apt 108	70866010	Brasilia	t	student
430	Sergio Leandro	Nascimento Neves	0715549	704.395.081-34	2058614 SSP/DF	32733356	33586170	Quadra 310 conjunto 06 lote 03	72306807	Brasilia	t	student
596	Valnei 	Alves Fernandes	0256242	034.546.867-84	1386403 SSP/ES		6133990520	ADE Águas Claras	71700000	Brasília	t	student
645	Amanda	Patrícia Rosa Pena	090071476	003.926.741-57	4360779		06434413307	av. josé Marcelino		Catalão	t	student
453	Jhone	Caldeira Silva	0596019	032.035.926-30	7670038 SSP/MG	32733356	00000000	SCLN 211 bl D apt 218	70863500	Brasilia	t	student
400	Carlos Alberto 	Pereira dos Santos	1013971	520.486.831-34	2865529 SSP/DF	32733356	34475642	SQN 411 bl F apt 102	70866060	Brasilia	t	professor
401	Alexei	Krassilnikov	991147	729.050.851-34	V314682-N	32733356	00000000	UnB Colina bl G apt 402	70910900	Brasilia	t	professor
580	Ary 	Vasconcelos Medino	1014579	807.604.654-87	1261760 SSP/ITEP RN		33271511	SCLN 404 Bloco D Ap. 215	70845540	Brasilia	t	professor
597	Hugo 	Silva Noleto	0843776	006.693.992-75	2200654 SSP/DF		96159851	QNM 34 Conj E Casa 17	72145405	Taguatinga Norte	t	student
620	Sheila	Campos Chagas	2177682	445.104.972-53	10594744 SSP/AM	32733356	9236474400	Av. General Rodrigo Otavio 3000 	69077000	Manaus	t	professor
461	Gilberto	Fernandes Vieira	0652237	042.583.264-37	2489133 SSP/PB	32733356	00000000	XXXXXXXX	0000000	Brasilia	t	student
490	Marcelo	Fernandes Furtado	203211	645.913.101-59	1472001 SSP/DF	32733356	32736889	SQN 411 bl A apt 110	70866010	Brasilia	t	professor
575	Cesar 	Garcia Pavo	01112862	007.304.685-00	1392289 SSP/SE		7981184408	Av. Hermes Fontes, 1631	49027000	Aracaju	t	visitor
504	Maria Emilia	Xavier Guimaraes	152722	858.989.497-00	069954824 IFP/RJ	32733356	00000000	Colina UnB bl J apt 305	70910900	Brasilia	t	professor
679	Max lemes 	Lemes		931.524.506-72	7770409	6235211153	6232943335	UFG		Goiania	t	professor
531	Emerson	Bastos	1020552	034.989.357-35	1075425 SSO/ES	32733356	30372153	Avenida Parque Aguas Claras 2675	710906500	Brasilia	t	professor
582	Valdir	Da Cruz Silva	1023314	449.723.004-00	1046727 SSP/PB	32733356	32037642	SQS 412 Bloco J Apt. 304	70287100	Brasília	t	administrativo
622	Camila 	Gonçalves de Araújo	0531642	024.410.721-10	2483620	92749913	35677247	QI 25 Lote 12/14 Bloco E Apto 431	71060250	Brasilia-DF	t	student
670	Márcia do Socorro	Borges de Araújo	090140907	873.841.241-15	3733901 SSP/GO	6284178480	34473121	SQN 209 Bl. I Apto 503 Ed. Gênesis	7200000000	Asa Norte	t	student
631	Luiz	Santana	126373	31689701153	897590 SSP/DF			Departamento de Matematica	7091000	Brasília	t	administrativo
431	Adriana	Flores de Almeida	0762466	693.695.771-49	1008435 SSP/MS	32733356	00000000	EQN 410/411 Quadra 01 Ed Studios Center apt 409	70865500	Brasilia	t	student
656	Mário	José de Souza	2529266	023.790.218-48	10914936 SSP/SP	6132733356	6232557479	Rua S 2 numero 642 apt 402 Ed. Cancun Setor Bela Vista	74823430	Goiânia	t	visitor
672	Rodolpho	Pinheiro D´Azevedo	1005821	746.767.251-91	2863650 SSP/DF		33061409	Av. JK Casa 08	70802020	Vila Planalto	t	student
667	Eudes  	A ntonio da Costa	090140877	532.385.161-91	1971966	6296693522		qn 115 bloco p apto 206		Brasilia	t	student
676	Julio Cesar da Fonsceca 	Evangelista	09007	017.222.061-01	890464			Asa Sul 505 Bloco A, Apto 10	70350510	Brasilia	t	student
680	Simone 	Mazzini Bruschi	0000000	167.945.878-74	23.827.620-X	31076477	33267440	SQN 304 Bloco A Apto 505	70736010	Asa Norte 	t	professor
683	Jose Antonio	Oliveira de Freitas	21212121	042.025.166-99	7.470-350 SSP/MG		32545166	SGAN 911 Módulo G Apto 217 Bloc F Ed. Garden Park	70790110	Asa Norte	t	professor
687	Francisco Enio do	Nascimento Lima	100061460	413.871.983-00	90002068732	99473207		Quadra 02 Conjunto B1 Bloco A Apto 111	7300000	Sobradinho	t	student
460	Paulo Angelo	Alves  Resende	0762776	724.980.721-87	2081878	32733356	33519484	SMT conjunto 08 lote 01 casa 01	72023440	Brasilia	t	student
547	Kaliana	Dos Santos Dias 	100061478	008.583.725-33	0924220716 SSP/BA	3273356	0000000	EQN 410/411Nbl A Quadra 01 Studios Center apt 49	70865500	Brasilia	t	student
424	Kelem	Gomes Lourenço	111111111	008.912.221-62	4297139 SPTC/GO		85773595	CLN 40 6Bl B Ent. 32 Sala 206	70000000	Brasilia	t	student
534	Miguel Junior	Cezana	1028227	100.921.687-28	1755220 SSP/ES	32733356	00000000	SCLN 406 bl B apt 40 subsolo	70847520	Brasilia	t	student
681	Luis Felipe	Gonçalves Fonseca	100061494	069.697.786-90	MG 9307431	6182212147		SQN 408		Brasilia	t	student
442	Daniele	Nantes Sobrinho	090150015	011.000.541-46	001294143 SSP/MS		81214689	SQN 411 BLOCO F APTO 206	70866060	Brasilia	t	student
433	Mariana	Ramos Reis	090085981	076.899.066-13	M-19119935 SSP/MG	81866443	30456219	SQN 410 BLOCO H APTO 109	70865080	Brasilia	t	student
625	LUCIANA LIMA	VENTURA	090020103	004.802.541-09	2394194	99459283	30450698	SQN 411 BLOCO F APT 203	70866060	BRASÍLIA	t	student
594	Andreia	Borges Avelar	100067115	707.453.901-53	474296 COMAER/DF	84491382	35638346	CNC 02 Lote 15 Apto 201	72115525	Taguatinga Norte	t	student
418	Tertuliano	Carneiro de Souza Neto	0761699	011.401.805-76	0863168426 SSP/BA	91110814	35322714	QI 18 Bloco G Apto 206	71015074	Guará I	t	student
519	Elves	Alves de Barros e Silva	1484822	189.068.504-68	1306211 SSP/PE	31076449	32221369	SQN 206 bl H apt 505	70844080	Brasilia	t	professor
572	Elis Gardel 	Da Costa Mesquita	090019989	928.422.081-53	912969989 SSP/MA		6291394946	SCLN 411 Bl C27 Sala 225		Brasília	t	student
682	Paulo Henrique 	De Azevedo Rodrigues		792.110.031-72	2226884 DGPC/GO		6235211208	UFG	6300000000	Goiania	t	professor
604	Fabiano 	Fortunato Teixeira dos Santos	0717088	011.675.256-47	6963008 SSP/MG		92027499	SQN 410 Bloco H Apto 108	70865080	Brasília	t	student
684	Ana Cristina 	Rocha Oliveira	100060897	986.081.261-68	2292402 SSP/DF	92945994	33875954	Quadra 10 Conjunto H Casa 41	73005108	Sobradinho	t	student
444	Simone	Vasconcelos da Silva	090157761	664.460.231-20	2086380 SSP/GO	84053133	33552853	QNE 15 casa 11	72125150	Brasilia	t	student
462	Ivolnides	Ribeiro Martins	0652253	961.058.951-00	3833901 SSP/GO	91459066	33465155	Rua 18 casa 40	70210110	Vila Telebrasília	t	student
457	Eunice Candida	Pereira Rodrigues	0652164	468.790.641-91	683622 SSP/MT	32733356	33475097	SQN 405 bl A apt 06	70846510	Brasilia	t	student
570	Thaynara	Arielly de Lima	100068600	015.369.871-31	4653246 DGPC	81714930	30446651	SQN 410 Bloco N Apto 110	70000000	Asa Norte	t	student
609	LAURA CRISTINA LOBATO 	DE OLIVINDO	090085957	008.326.191-59	2031021 SSP/DF	92077978	35320026	QUADRA 10 BLOCO K CASA 20	70645110	CRUZEIRO VELHO	t	student
619	Marina 	Gabriella Ribeiro Bardella	100061338	024.852.481-09	2564068 SSP/DF	32733356	33388884	SMPW Q 26 conjunto 07 lotes 11/12 casa E 	71745067	Brasilia	t	student
690	Gustavo	Coelho Abade		704.952.891-91	1950091 ssp/df	81318134	35677889	Departamento de Engenharia Mecânica	70910900	Brasília	t	visitor
675	Thales 	Dias Braga		023.526.951-47	2574509		6133938963	Qr  Conj A casa 16	72501501	Santa Maria	t	administrativo
568	Arianny 	Baiço Malaquias	043134	018.528.811-19	4919652		6291537793	Rua 20 n. 238 Ed. Friburgo	74020170	Goiania	t	visitor
654	Yuri	Dumaresq Sobral	1034090	695.298.841-68	1801312 SSP-DF	81318141	33681879	SHIN QI 13 Conjunto 02 Casa 09	71535020	Brasília	t	professor
671	Luciene 	Viana Guedes	090140893	961.111.001-49	4085804 DGPC/GO	82027686	33716311	QNM 21 Conj. K Casa 24	72215210	Ceilândia Sul	t	student
627	Tarcísio 	Castro Silva	100072941	008.872.391-70	4717302 DGPC GO	6292012716	81011374	SQN 411 BLOCO G APTO 108	70866070	Asa Norte	t	student
414	Karise	Gonçalves Oliveira	0761605	976.283.871-87	4169346 DGPC/GO		6292480604	Rua Padre José Maurício Q. 5 Lt 29, Vila Adélia	74323065	Goiânia	t	student
648	Bruno	Cesar Rodrigues Lima	100072968	969.161.171-68	4257025		6281256080	Rua 22 Qd 48 Lt16		Alexander	t	student
526	Daniele	Da Silva Baratela Martins Neto	1014536	123.621.458-75	22296112 SSP/SP	32733356	33447996	CCSW 04 lote 03 apt 407 Ed Renoir Sudoeste	70675126	Brasilia	t	professor
623	Enrique	Reyes						Departamento de Matemática		Brasília	t	visitor
695	Raquel 	Lehrer	100061516	035.251.229-69	70897598 SSP/PR		33471485	SHCGN 709 Bl. L Casa 21	70750712	Asa Norte 	t	student
696	Edson Luiz	Ferreira		060.546.710	1913184	31076478		Departamento de matemÃ¡tica		BrasÃ­lia	t	visitor
593	Sunamita	Souza Silva	100075517	009.228.821-93	4797915 SSP/GO		81029477	SQN 410 Bloco I Apto 305	70000000	Asa Norte	t	student
458	Evander	Pereira de Rezende	0652181	820.612.031-91	3028070 SSP/GO	32733356	33063195	Rua 03 casa 06 Vila Planalto	70802040	Brasilia	t	student
694	Emanuella	Romano			AA5951437		81976088	Colina UnB Bloco G Apto 208			t	visitor
688	Jason Paul	Newport			AA5951437		81976088	Colina UnB Bloco G Apto 208			t	visitor
691	Peter A.	Symonds			AA5951437		81976088	Colina UnB Bloco G Apto 208			t	visitor
700	Thomas	Weigel	0000001	000.000.000-01	0000001			Colina Bloco G	70910900	Asa Norte 	t	professor
701	Hector Daniel	Ceniceros			451536764		99756862	SQSW 303 Bloco J Apto 303	70000000	BrasÃ­lia	t	visitor
518	Chang Chung	Yu Dorea	071102	770.435.378-00	3191213 SSP/SP	32733356	33683575	SHIN QI 08 conjunto 1 casa 09	71520210	Brasilia	t	professor
470	Walter	Batista dos Santos	1044699	838.417.331-15	3825125 DGPC/GO	31076566	82095827	CLN 209 BLOCO D APTO 202	70854540	Brasilia	t	professor
693	Michael	Knapp			AA5951437		81976088	Colina UnB Bloco G Apto 208			t	visitor
703	Marta Adriana de	Moraes	1041797	657972131-68	1436938 SSP-DF	31076184	35912440	Q. 6 Conj. H Casa 27 - Sobradinho-DF		Sobradinho-DF	t	administrativo
416	Rangel	Pinheiro da Silva	0795291	938.190.561-49	1879148 SSP/DF	85316073	34531076	Qd 2 Conjunto B2 Bloco A Apto 307	73202015	Sobradinho	t	student
677	Selma	Santos 	123456	111.111.111-11	1671148	31076479	32738104	SQN 216 Bl I Apto. 605	70875090	Brasília	t	administrativo
709	Luis Eduardo sousa	BrandÃ£o	10/013711	02793549320	021324012002-6			Cond. B Sol CH 20/22C CJ A C 14		CeilÃ¢ndia	t	student
712	Reinaldo 	Marchi	100128246	194.486.548-98	285201207	6584716450	6530230834	CLN, qd 405, bloco A, ap 6, Asa Norte		BrasÃ­lia 	t	student
713	Thiago	Porto de Almeida Freitas	100128262	982.308.241-34	3996909		82145678	SCLN 209 Bl. D Sl. 102 Asa Norte	70854540	BrasÃ­lia	t	student
714	Diana	Dorgam	100128475	926.531.462-15	18350950			SQN 410 BLOCO N AP.110		BrasÃ­lia	t	student
716	marcelo 	bezerra barboza	0961051	72800984104	4511539	(62)96195171	----	sqn 411 bl g ap 108	70866-070	brasilia	t	student
717	Renata	Alves da Silva	100061427	021.145.191-63	5114128		6296954895	Av: Bahia qd: 02 lt: 01		Campos Belos	t	student
720	Adriana	Barbosa de Souza	100061443	623.574.412-91	3499527	84090098	81550576	CNB 5 Lote 2 Apto 1102	72115055	Taguatinga	t	student
704	Raimundo	De Araújo Bastos Junior	100128220	012.530.613-00	2000097121232		81862126	A informar			t	student
711	Clodomir Silva	Lima Neto	100128467	64965619315	2000015035388		61-8235-4893	SQN 109 Bloco I Apartamento 604		BrasÃ­lia	t	student
707	Keidna	Cristiane Oliveira Souza	100128386	01751558100	771550	06299720274		QNM 04, cj f, lt 19, cs 03	72210046	CeilÃ¢ndia	t	student
706	Saieny	Hauak Cardoso	10128386	803044191-68	3452375	81518584	32737202	SGAN- W5 , Q 915 S/N	70790-150	BrasÃ­lia	t	professor
722	Josinalva	Estacio Menezes	1045687	194.535.744-49	1354830 SSP/PE		98151050	Quadra Central, Bl 6 Apto 201	73010516	Sobradinho	t	professor
456	Daniel 	Lima Ventura	0652130	895.319.061-49	1976561 SSP/DF	32733356	32733721	SQN 209  bl G apt 307	70854070	Brasilia	t	student
590	Wembesom 	Mendes Soares	100128289	074.778.346-27	13116685 SSP/MG	81104185	81104185	Condominio Jardim Europa II, CL 12/13, Bairro Grande Colorado	73105904	Sobradinho	t	student
646	Bruno	Nunes de Souza	100072950	073.789.456-33	MG-9026217	32733356	81327302	SQN 411 BLOCO G APTO 108	7000000	Brasília	t	student
723	Ilir	Snopce			G0143919						t	visitor
626	Tonires	Sales de Melo	0761711	893.885.184-20	1654184 SSP/PB		6181894010	SQN 308 Bloco A Apto 508	70710010	Brasilia	t	student
719	Horácio	Ibrahim		046.295.894-90	5725042 SDS PE	20219608	32547090	SQN 210, BLOCO A APT 614	70862-010	BrasÃ­lia	t	visitor
710	Allan Kardec	Messias da Silva	100132219	01381098185	1597928-8		81824204	QSE 04, casa 44	70000000	Taguatinga sul	t	student
611	Marcelo 	Bezerra Barboza	0961651	728.009.841-04	4511539 DGPC/GO		6296195171	SQN 411 BLOCO G APTO 108	70866070	Asa Norte	t	student
725	Alonso	Sepúlveda Castellanos		228.929.348-26	V346990L	3496797712	3432100109	Rua Nordal Gonçalves de Melo, 1304, Apto 301	38408218	Uberlândia	t	visitor
616	Leonardo	Pessoa Gomes de Queiroz	1026313	000.110.281-81	2032754 SSP/DF	33072441	33952600	QR 316 CONJUNTO I CASA 17	72546609	SANTA MARIA	t	administrativo
662	Jean 	Paulo Santana Gonzaga	998651	858.668.901-78	1596493 SSP/DF		61 9140-9176	Colonia Agricola Samambaia Ch.152 Lt.04B 	72.110-600	Taguatinga Norte	t	administrativo
708	Melissa	Campos Alves	100132227	11735290718	213298375		(61)32572836	SQN 406, Bloco A AptÂº 306		Brasilia	t	student
702	Marta Adriana	Moraes Sousa	1041797	65797213168	1436938 SSP/DF	31076480	35912440	Qd. 06 Conj. H Casa 27	73025068	Sobradinho	t	administrativo
726	Cecilia	Candida Frasao Vieira		964.934.961-87	2163714 SSPDF	6181114357	6130424357	CNB 11 Lt. 01 Apto 407	72115115	Taguatinga Norte	t	visitor
727	Dessislava 	Kochloukova		216.193.168-70	522134117		1932893661	Universidade Estadual de Campinas - IME Campinas SP	13083-000	Campinas	t	professor
729	Marco	Boggi			AA 3243543-Italy			Colina Boloco G	70910900	BrasÃ­lia	t	visitor
512	Rudolf Richard	Maier	077518	143.543.221-53	RNE 1720503 DF	32733356	32739422	SQN 116 bl F apt 312	70773060	Brasilia	t	professor
728	Marco Antonio	Pellegrini	1047841	701.235.161-61			82470973	Universidade de Brasília	70910900	Brasilia	t	professor
730	Elson Leal 	De Moura	110023161	007.898.716-45	M9082182	3891105197		Colina Bloco G	72000000	Brasi­lia	t	student
412	Flavia	Ferreira Ramos Zapata	1048554	728.381.401-91	4295012 SSP/GO	84434603	35368553	CLN 407 Bloco E Apto 215	70855550	Brasilia	t	professor
636	Mônica 	Aparecida Cruvinel Valadão	090071956	009.786.881-71	16412028 SSP/MT		96066119	CLN 411 Bl C Apto 225	7200000000	Asa Norte	t	student
731	Newton Mayer	Solorzano Chavez	110023145	753.074.561-15	V572918H		6192441053	UnB Colina	70910900	Brasilia	t	student
732	Claud Wagner 	GonÃ§alves Dias Junior	100061095	659.716.041-04	2994869	6192613729	6133264215	Rua Sergipe n8 Vila Planalto	70910900	Brasilia	t	student
733	Emerson 	Ferreira de Melo	110023170	342.036.828-35	5011633		6281413627	Campus Univeritario	70910900	Brasilia	t	student
736	Vinicius Elias	Da Costa	110081684	731.494.111-49	14436647		6681017770	SQN 405 Bloco J Apto 108	70846100	Brasilia	t	student
738	Lauro Maycon	Fernandes Ferreira	110078985	008.180.241-27	1303944		6792620594	Campus Universitario	70910900	Brasilia	t	student
739	Vinicius Martins	Teodosio Rocha	110075111	048.395.984-79	3062513		6182393981	QD.34 CONJ.C LT.06 APTO 302 PARANOA	71573403	PARANOA	t	student
740	Otto Augusto	De Morais Costa	110076061	084.147.544-06	002149181	6182065694		Campus Universitario	70910900	Brasilia	t	student
741	Henrique	Costa dos Reis	110057104	030.701.561-00	2580889	6191337383	6130473325	QNC 13 Casa 23	72115630	Taguatinga Norte	t	student
743	Camila	Borri Picciuto	110081668	065.199.939-13	96570570		6181939092	SQN 415 Bloco F Apto 303	70878060	Brasilia	t	student
630	Maria Celia	Ramos dos Santos	645	645.988.961-91	1513991 SSP/DF		95528853	Rua 09 Quadra 19 lote 05 casa 03 Morada Nobre 	72870333	Valparaiso	t	administrativo
744	Edimilson	Dos Santos da Silva	100064370	025.502.805-98	32494084		6182211968	Colina Bl K Apto 301	70910900	Brasilia	t	student
745	Luiz Mateus	Santana Santos	100128416	033.784.685-56	1446078833		6784030325	SLN 405 Bloco A Apto 04	 70239-500	Brasilia	t	student
469	Nilton	Moura Barroso Neto	1049453	704.040.462-15	3796594 SSP/PA	81642933	32029690	SQN 216 Bloco K Apto 402	70000000	Brasilia	t	professor
747	Luis  Henrique	De Miranda	1049721	991.385.061-49	1988985 SSP/DF		6130336579	QI 05 cj D casa 95	71020044	Guará 1	t	professor
748	Bruno	Figueira Lourenco	110075137	032.001.511-45	2666974 SSP/DF	6196751893	6135774486	SHIN QL 9 Conjunto 1 Casa 11	71515215	Brasi­lia	t	student
415	Manuela	Caetano Martins de Rezende 	1049399	532.393.851-04	3582057 SPTC/GO	6196491128	6132260086	SQN 105 BLOCO A APTO 101	70734010	Brasilia	t	professor
464	Jiazheng	Zhou	1049941	057.968.097-50	V342662 CIMCRE/CGPMAF/RJ	84533039	30636188	SQN 314 Bloco B Apto 103	70765000	Brasilia	t	professor
635	Thiago	De Lima Macedo	090072146	907.612.601-10	1838432 SSPDF	32733356	35361037	Rua 05 Sul LOte 05 apt 605 Aguas Claras	71937180	Brasilia	t	student
751	Pedro Ernesto	Araujo Eloy	110081781	021.343.831-35	4964403	6196315409	6136311772	Rua 09 n.231 St. Ferroviario	73805020	Formosa GO	t	student
749	Maria Aparecida	Rocha	125067	223.151.361-72	527480	31076480	33995756	QS 4 Conj. 5 Casa 13	71810040	Riacho Fundo	t	administrativo
742	Alexandre	De Miranda Soares	110057112	024.674.053-11	1042587997		6182547088	CQD Conj. 21 Lt 7 Apto 103	71989600	Brasilia	t	student
752	Diogo Pelas	Franco Pereira	110078977	305.402.448-07	343824620	6181203272	6130391577	SHIN CA 05 Bloco H Apto 217 Lago Norte	71503505	Brasilia	t	student
734	Fabio	Nunes da Silva	110079141	025.345.561-85	938773		6184214887	Campus Univeritario	70910900	Brasilia	t	student
750	Livia Fernanda	De Alencar Carvalho		865.777.512-34	0937883049	6181100908		SQN 305 Bloco E Apto 501	70737051	Brasilia	t	administrativo
724	Vivian Claudia	Pereira	1041568	712.365.971-68	3127127	91530236	33341701	QN12 D Conjunto 1 Casa 21	71881646	Riacho Fundo 2	t	administrativo
753	George Hideyuki	Kuroki Junior	1050907	967.150.901-06	1925772 SSP/DF	6191771304	6133515776	CNB 2 Lote 14 Apto 501	72115025	Taguatinga	t	administrativo
754	Daniela	Amorim Amato	1050338	789.010.901-63	1685489 SSP/DF	6181128298	6135229087	SQN 214 Bloco F Apto 107	70873060	Brasilia	t	professor
417	Ricardo	Ruviaro	1049348	030.216.779-08	3815766 SSP/SC		6181457580	SQN 411 Bloco Q Apto 103	7000000	Brasilia	t	professor
755	Ricardo	Jensen Didonet	090131037	003.305.551-57	2298066 SSP/DF	98432005	34683769	SHIN QL 2 Conjunto 8 Casa 1	71510085	BrasÃ­lia	t	student
517	Cátia Regina	Gonçalves	152641	045.078.748-66	144761109 SSP/SP	32733356	32742463	SQN 307 bl I apt 512	70746090	Brasilia	t	professor
756	Roberto	Vila Gabriel	110105508	111.111.111-12	0102020222			CEU BL A APTO 113	72910900	Brasilia	t	student
757	Pedro Manuel	Sanchez Aguilar	110105451	121.111.111-12	06200000			Campus Universitario	70910900	Brasilia	t	student
758	Paulo Rodrigo 	Pasquetti	110105494	017.810.800-62	5095459318			Campus Universitario	70910900	Brasilia	t	student
507	Norai Romeu	Rocco	503355	590.653.208-09	458019 SSP/DF	32733356	32736559	SQN 215 bl J apt 201	70874100	Brasilia	t	professor
759	Diana Carolina	Flores Puentes	110105524	220.000.000-00	00120121		6181079485	SCLN 407, asa norte, apto 211	70910900	Brasilia	t	student
760	Benedito Leandro	Neto	110105541	734.276.081-15	4712372		6293176856	SCLN 402, Bloco C, Apto 9	70910900	Brasilia	t	student
715	Ilana Zuila	Monteiro Alves	100133738	000.410.352-16	20275552			SQN 410 BLOCO N AP.110		Brasilia	t	student
761	Bruno Trindade	Reis	110105559	980.414.281-34	4047103		6284493730	SCLN 402, Bloco C, Apto 9	70910900	Brasilia	t	student
633	Diego	Marques Ferreira	1038931	004.743.943-28	2001002132434 	32733356	8532816097	Rua Raimundo Arruda n. 553 Parquelandia	60450500	Fortaleza	t	professor
762	Oscar Ernesto	Gonzalez Osorio	100105460	701.869.801-40	11112222		6182743079	Av Central 5 Conj 15 kitnet 01 sobradinho 2	79000000	Sobradinho	t	student
763	Edivaldo	Fernandes da Silva	110105516	000.701.531-32	3875944		6296622564	Campus Universitario	70910900	Brasilia	t	student
578	Eduardo 	Antonio da Silva	1050141	012.733.111-59	456871ssp/tc		6181711062	SCLN 708 Bloco H Apto 7	70000000	Brasilia	t	professor
764	Ningwei	Cui		701.975.571-20	000001254	6131076482		Campus Universitario	70910900	Brasilia	t	visitor
765	Getulio	Lins Gomes	110105532	024.830.471-22	2528020	99722387	6139672609	QR 122 Cj 9 Casa 12, 	72304209	Brasilia	t	student
603	Luciana	Maria Dias de Avila Rodrigues	222111	911.138.306-20	6894953 SSP/MG	81064881	32570637	SQN 212 bl E apt 501	70264050	Brasília	t	professor
471	Claudiney	Goulart	0843857	006.206.786-90	8545561 SSP/MG	32733356	00000000	SQN 410 bl O apt 213	0000000	Brasilia	t	student
586	Manuel	Vieira Neto	093325	150.203.711-49	347018 SSP/DF	32733356	33848973	Praça 04 bl A lote 12 apt 102 Setor Sul - Gama	72415100	Brasilia	t	administrativo
491	Aline	Gomes da Silva Pinto	1013921	812.945.731-87	1605358 SSP/DF	32733356	32736889	SQN 411 bl A apt 110	70866010	Brasilia	t	professor
574	Elias 	Da Costa	0960918	003.867.301-05	4300321 SSP/GO		6291045863	Rua 15, 496 Centro	74030030	Goiania	t	student
721	Cristina	Acciarri			A151297			Colina UnB Bloco G Apto 108	71910900	Brasilia	t	visitor
474	Maria Terezinha	Jesus Gaspar	118044	107.217.465-00	97283681 SSP/BA	31076429	30378871	SQN 216 bl G apt 124	70844020	Brasilia	t	professor
608	Felipe 	Batista da Silva	1049852	731.650.691-15	2359980 SSP/DF		32020417	QNM 36 Conj. E Casa 01	72145605	Taguatinga Norte	t	professor
767	Alexandre Magno 	Rodrigues	000000	005.632.361-16	2139476DGPCGO	99540248		CA2; ED. Silco Practical Spaces; ap. 315A	71503502	BrasÃ­lia	t	administrativo
705	Maria	De Sousa Leite Filha	100132189	054.331.634-31	2848347		81565266	SCLN 411 Bloco C Apto 225	70866530	Brasilia	t	student
548	Ana Maria	Redolfi de Gandulfo	096652	184.996.001-15	1511527 SSP/DF	32733356	32730918	SQN 107 bl H apt 502	71743080	Brasilia	t	professor
489	Salahoodin	Shokranian	118524	296.491.101-00	RNE 104312 SPMAF/DF	32733356	35773710	SHIN QI 11 conjunto 03 casa 11	71515230	Brasilia	t	professor
628	Jairo 	Gomes da Silva	1053116	992.906.181-91	15026205 SSP/MT		91992025	Guará II Conjunto T, QE 28 Casa 10	70060202	Guará II	t	professor
624	Ricardo	Nunes de Oliveira		835.265.281-87	31789.39		32640489	SQN 215 Bloco F apt. 204	70000000	Brasilia-DF	t	visitor
410	Guy	Grebot	146731	351.717.401-78	894040 SSP/DF	32733356	33674831	SHIS QL 26 conjunto 04 casa 11	71665145	Brasilia	t	professor
768	Julian Lazaro	Aguirre	120005671	702.454.331-04	08280001159/2012-4		6131076482	UnB	70910900	Brasilia	t	student
770	Jaime Rolando	Rojas Huacanca	120005646	702.454.351-58	AC9A.7237.E712.0E5A			UnB	70910900	Brasilia	t	student
771	Phelippe Augusto	Amorim		018.790.271-27	2485213 SSP DF		84491213	Q. 01 Cj. G casa 301 Setor Norte 	72000000	Gama - DF	t	visitor
612	Robson	Alves do Nascimento	1010101010	022.125.153-75	2400537		91225074	CEU BL A APTO 113	72910900	BRASILIA	t	student
669	Ismael 	Rangel Ferreira Lins	090140885	522.707.502-68	1658933-5 SSP/AM		92183921	SQN 411 Bloco Q Apto 103		Asa Norte	t	student
685	Dhiego	Loiola de Araújo	120005620	010.545.331-56	2369541	86299038	30327322	QNM 19 Conjunto E Casa 12	72215195	Brasília	t	student
772	Uelison Menezes 	Da Silva	120005719	006.319.019-37	222932892			Rua Felix AntÃ´nio nÂº 184, Vila Felizaredo Itaumbim		CearÃ¡	t	student
472	Magno 	Alves de Oliveira	0847771	031.532.786-36	10947411 SSP/MG	32733356	00000000	STN lote K Ed Montreal II apt 15	70770100	Brasilia	t	student
686	Ana Paula de 	Araújo Chaves	100064400	017.810.793-07	2000010499548		82630407	SCLN 708 Bloco F Entrada 54	70000000	Brasília	t	student
776	Wilson Domingos Sidinei Alves	Miranda	120072475	008.696.221-37	2158912 - SSP/DF	99956626	34885476	Estancia Mestre D'Armas IV  Modulo 06 Casa 15	73380400	Planaltina	t	student
718	Tiago	De Lima Bento Pereira	120024152	030.291.441-27	5190704		6292619803	SCLN 208 Bl B Sl 110 Asa Norte		BrasÃ­lia	t	student
644	Matheus	Bernandini de Souza 	110075129	032.014.011-37	2364770	32733356	33674452	SMDB conjunto 27 Casa 03	71680270	Brasilia	t	student
774	Josimar JoÃ£o  Aguirre	Ramirez	120072416	702.633.931-19	45556863			Vila Planalto , Rua BrasÃ­lia  casa 6		BrasÃ­lia	t	student
775	Jhoel Estebany Sandoval 	Gutierrez	120072441	702.634.141-32	DNI-45502818			Vila Planalto , Rua BrasÃ­lia  casa 6		BrasÃ­lia	t	student
777	JosÃ© Carlos de Oliveira	Junior	120005603	109.770.477-76	2009463	6181959572		Rua do AÃ§ougue Lote 3 Apt: 206, Vila Planalto - BrasÃ­lia	70802120	BrasÃ­lia	t	student
779	Bruno Henrique	Guadanhin	120072394	341.176.138-55	40942360/9 -SSP	1896226782		SQN 410 - bloco - E - Apt: 303		BrasÃ­lia	t	student
780	Saulo Carvalho de Souza 	Timoteo	120005697	015.535.511-25	773265 -SSP/TO	6392733909		Rua 28 Quadra 59 Lote 06, Aureny III - Palmas	77270000	Palmas	t	student
781	Ataias Pereira	Reis	100093817	038.378.501-45	3221716 SSP/DF	6191714759	6136191501	Q. 25 Casa 23, rua 21, Ãguas Bonitas I	7000000	Ãguas Lindas	t	student
411	Anyelle	Nogueira de Souza	0960870	997.006.031-72	4143180 DGPC-GO	31077236	31077236	SQN 709 Bloco R casa 5	70888888	Brasilia	t	student
782	Alex Carrazedo	Dantas	120065207	043.619.939-47	86481723SSP	6183132011		Rua Dom Pedro I, 291, Parque Manela, CambÃ©	86185450	ParanÃ¡	t	student
737	Linniker	Monteiro Lourenco	120082632	017.464.291-19	1507203			Campus Universitario	70910900	Brasilia	t	student
783	Sonia Silva Torre 	Tinoco	120005654	702.475.611-00	DNI. 41269250	51943784503		SQN 411 -  Bloco Q  Apt: 103	70866170	BrasÃ­lia	t	student
769	Javier Ruben Sabino 	Norabuena	120005662	702.454.401-51	08280001167			UnB	70910900	Asa Norte	t	student
784	Eder Silva	De Brito	120089238	014.136.871-30	4931138	6195130641	6132536925	SHCES 603 BL.B APTO 401	70655632	BrasÃ­lia	t	student
785	Eliana Cristina 	Batista	1057979	586.134.206-72	MG-5.303.320	85734446		Colina		BrasÃ­lia	t	administrativo
587	Aline	Souza Lima	0548545	717.979.041-91	4040785 DGPCGO	32733356	30371160	SQN 416 bl F apt 308	70879060	Brasilia	t	student
581	Andre Luiz	Galdino	0455695	788.787.721-00	32988873874567 SSP/GO	32733356	32733356	SQN 412 bloco B apt 102	70267020	Brasilia	t	student
454	Adail	De Castro Cavalheiro	01044176	603.168.611-20	27839534 SSP/SP	81317638	38797638	HIGS Quadra 709 conjunto K casa 38	70360711	Brasilia	t	professor
773	Tiago	 de Oliveira Martins	120072351	023.563.361-50	19602499		35854745	Rua 9 módulo 20, casa 15A -CondomÃ­nio Priver - CeilÃ¢ndia Norte		Brasília	t	student
468	Abilio	Lemos Cardoso Junior	0718777	048.555.436-40	M 11465492 SSP/MG	32733356	39631924	SRN 702/703 bl D apt 302	70720640	Brasilia	t	student
455	Bianka	Carneiro Leandro	0652075	994.540.681-72	4002343 DGPC/GO	32733356	00000000	SCLN 408 bl B apt 118	70856500	Brasilia	t	student
463	Janete	Soares de Gamboa	1044168	040.433.564-04	2466656 SSP/PB	99686188	30415005	SHIN CA 2 BLOCO D APTO 326	715035102	Brasilia	t	professor
689	Henrique 	Rennó Zanata	1027603	026.656.781-95	2333941 SSP/DF		95571086	SQB QD 3 Bloco N Apto 103	71009000	Brasília	t	student
421	Luciene 	Pinheiro Lopes	0847798	924.641.571-04	1906836 SSP/DF	32733356	33847099	Quadra 06 conjunti M casa 12	72419060	Brasilia	t	student
766	Alexandre 	Araujo	1055003	008.479.811-42	2054879	6131076481	6133456405	shigs 713 bloco x cs 30	70380724	BrasÃ­lia	t	administrativo
638	Vinicius	Faco	12005590	019.130.751-33	2277277 SSP/DF	81377239	3234687	aosc bl 6 ap 412	70660062	Brasília	t	student
786	Solange Mota	Gomes de Almeida		023.742.631-50	2664671	6185869969	6133061354	Rua 7 casa 17 acamp. Pacheco Fernandes	70804270	Vila Planalto	t	administrativo
473	Theo Allan	Darn Zapata	0843865	311.438.838-88	356882196 SSP/SP	92031617	35368553	SQN 308 bl A apt 508	70910900	Brasilia	t	student
787	Mo	Xiaohuan			morphism			Universidade de Pekin		Pekin	t	visitor
788	Bruna 	Ribeiro		026.337.711-30	2409762	6184948206	6133827710	QI 04 BLOCO H APART 305		BRASÃLIA	t	administrativo
601	Claudiano 	Goulart	1028219	917.565.106-87	6915961 SSP/MG	33072442	7591313670	SQN 410 Bloco O Apto 213	70865150	Brasilia	t	student
641	Joaby	De Souza Juca	120088649	051.650.174-78	99001328777		81348805	SQN 304 Bloco F  apt 106 	70736060	Brasília	t	student
678	Aristóteles 	Soares Benício Júnior	1060571	023.797.471-13	MG11559911	6181508586	6132634937	SQS 407 Bloco I Apto 302	70256090	Brasília	t	professor
618	Mayra 	Camelo Madeira de Moura	1060643	006.895.621-52	2414180 SSPDF	84117404	39644652	QE 32 conjunto J casa 21 Guara II	71065101	Brasilia	t	professor
658	Leandro	Martins Cioletti	1034502	029.588.446-09	M8497172	3194287356	3134095792	Rua Flor de fogo 65 apto 501	31127217	Belo Horizonte 	t	professor
567	Eveline	Pereira dos Santos Resende	0000000	940.952.051-72	1967907 SSP/DF	33072442	33696820	Qd. 10 Conj. J Cs 46	71570100	Paranoa	t	administrativo
778	Addan Tritty Rezende de 	Souza	120072289	025.701.861-12	5210770	6285426458		SCLN 113 Bloco - A - Sobsolo 29		Brasilia	t	student
503	Marcus Vinicius	Araujo Soares	129283	379.197.414-91	459069 SSP/RN	32733356	00000000	Colina UnB bl H apt 304	70910900	Brasilia	t	professor
790	Alex 	De Moura Batista	120149150	073.731.934-80	002689047		8396278913	CLN 405 Boco A Ap 06		Brasí­lia	t	student
746	Hellysson Antonio	Sampaio dos Santos	100128483	996.858.173-91	2038657	6181963613	6136126812	Campus Universitario	70910900	Brasilia	t	student
791	Jurandir	Ceccon		737.072.799-87	52902770	4133613401	4199199080	UFPR		Curitiba	t	visitor
789	Alysson	 Filipe		818.937.871-68				SMPW Qd. 26 Conj. 12 Lote 07		Brasí­lia	t	visitor
403	Liliane	De Almeida Maia	1045407	184.438.181-15	524899 SSP/DF	32733356	38798905	SHIN QL 15 conjunto 06 casa 06	71535265	Brasilia	t	professor
576	Rejane	Sousa	003140	514.975.813-20	1418151ssp-pi	31076481	32731545	q-56 lt-3 bl-b apt-207 	72405560	Gama	t	administrativo
793	Jamer	Insupe Roldan Gonzales	120149460	703.192.331-03	45958926	6131076997	6182030688	CLN 407 Bloco C N25 ASA NORTE BRASÃLIA DF	70855530	BrasÃ­lia - DF	t	student
735	Valdiego	Siqueira Melo	120005727	020.935.591-37	16958241		6182762961	Campus Universitario	70846100	Brasilia	t	student
661	Dimas	Jose Goncalves	1034740	218.529.978-69	33210001-7	32733356	32733356	STN conjunto K bl 1 apt 45 Asa Norte	75250000	Brasilia	t	professor
657	Lucas	Conque Seco Ferreira	1034430	698.592.481-68	1709656 SSP/DF	32733356	32028855	SHIN QL 10 Conj 01 casa 11	71025015	Brasilia	t	professor
655	Kellcio	Oliveira Araújo	1014153	823.963.611-04	3742599 SSP/GO	33072442	30379821	SQN 216 Bloco D Apto. 112	70875040	Brasília	t	professor
\.


ALTER TABLE ONLY disciplinas_mat
    ADD CONSTRAINT mat_pk PRIMARY KEY (codigo);


ALTER TABLE ONLY fonctionnaire
    ADD CONSTRAINT pk_fonctionnaire PRIMARY KEY (coduser);


ALTER TABLE ONLY profs
    ADD CONSTRAINT pk_profs PRIMARY KEY (coduser);


ALTER TABLE ONLY student
    ADD CONSTRAINT student_pkey PRIMARY KEY (matricul);


ALTER TABLE ONLY unix
    ADD CONSTRAINT un_pk PRIMARY KEY (login);


ALTER TABLE ONLY users
    ADD CONSTRAINT us_pk PRIMARY KEY (coduser);


ALTER TABLE ONLY fonctionnaire
    ADD CONSTRAINT fonctionnaire_coduser_fkey FOREIGN KEY (coduser) REFERENCES users(coduser);


ALTER TABLE ONLY profs
    ADD CONSTRAINT profs_coduser_fkey FOREIGN KEY (coduser) REFERENCES users(coduser);


ALTER TABLE ONLY student
    ADD CONSTRAINT student_coduser_fkey FOREIGN KEY (coduser) REFERENCES users(coduser);


ALTER TABLE ONLY unix
    ADD CONSTRAINT un_fk FOREIGN KEY (coduser) REFERENCES users(coduser);


REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO pgsql;
GRANT ALL ON SCHEMA public TO PUBLIC;


REVOKE ALL ON TABLE unix FROM PUBLIC;
REVOKE ALL ON TABLE unix FROM si;
GRANT ALL ON TABLE unix TO si;
GRANT SELECT ON TABLE unix TO samba;
GRANT SELECT ON TABLE unix TO priori;


