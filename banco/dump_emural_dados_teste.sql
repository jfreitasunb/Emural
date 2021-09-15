--
-- PostgreSQL database dump
--

-- Dumped from database version 8.4.0
-- Dumped by pg_dump version 9.0.1
-- Started on 2012-10-05 11:03:41

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

ALTER TABLE ONLY public.turmas DROP CONSTRAINT turmas_tur_cpro_fkey;
ALTER TABLE ONLY public.turmas DROP CONSTRAINT turmas_tur_cdis_fkey;
ALTER TABLE ONLY public.responsaveis DROP CONSTRAINT responsaveis_res_cmon_fkey;
ALTER TABLE ONLY public.responsaveis DROP CONSTRAINT responsaveis_res_cava_fkey;
ALTER TABLE ONLY public.professores DROP CONSTRAINT professores_pro_cpro_fkey;
ALTER TABLE ONLY public.observacoes DROP CONSTRAINT observacoes_obs_ctur_fkey;
ALTER TABLE ONLY public.notas DROP CONSTRAINT notas_not_cava_fkey;
ALTER TABLE ONLY public.notas DROP CONSTRAINT notas_not_calu_fkey;
ALTER TABLE ONLY public.monitores DROP CONSTRAINT monitores_mon_cmon_fkey;
ALTER TABLE ONLY public.log_responsaveis DROP CONSTRAINT log_responsaveis_lre_cres_fkey;
ALTER TABLE ONLY public.composicao_turmas DROP CONSTRAINT composicao_turmas_ctu_ctur_fkey;
ALTER TABLE ONLY public.composicao_turmas DROP CONSTRAINT composicao_turmas_ctu_calu_fkey;
ALTER TABLE ONLY public.codigo_item DROP CONSTRAINT codigo_item_cit_ccod_fkey;
ALTER TABLE ONLY public.avaliacoes DROP CONSTRAINT avaliacoes_ava_ctur_fkey;
ALTER TABLE ONLY public.alunos DROP CONSTRAINT alunos_alu_calu_fkey;
ALTER TABLE ONLY public.acessos DROP CONSTRAINT acessos_ace_cpes_fkey;
DROP INDEX public.ifk_turmaxavaliacoes;
DROP INDEX public.ifk_turmasxobservacoes;
DROP INDEX public.ifk_turmasxcomposicaoturmas;
DROP INDEX public.ifk_responsaveisxlogresponsave;
DROP INDEX public.ifk_professoresxturmas;
DROP INDEX public.ifk_pessoaxmonitor;
DROP INDEX public.ifk_pessoaxacessos;
DROP INDEX public.ifk_pessoasxprofessores;
DROP INDEX public.ifk_pessoasxalunos;
DROP INDEX public.ifk_monitoresxresponsaveis;
DROP INDEX public.ifk_disciplinasxturmas;
DROP INDEX public.ifk_codigosxcodigoitem;
DROP INDEX public.ifk_avaliacoesxresponsaveis;
DROP INDEX public.ifk_avaliacoesxnotas;
DROP INDEX public.ifk_alunosxnotas;
DROP INDEX public.ifk_alunosxcomposicaoturmas;
DROP INDEX public.fk_turmas_obs;
DROP INDEX public.fk_turmas_composicaoturmas;
DROP INDEX public.fk_turmas_avaliacoes;
DROP INDEX public.fk_responsaveis_log_responsaveis;
DROP INDEX public.fk_professores_turmas;
DROP INDEX public.fk_pessoas_professores;
DROP INDEX public.fk_pessoas_alunos;
DROP INDEX public.fk_pessoas_acessos;
DROP INDEX public.fk_pessoa_monitores;
DROP INDEX public.fk_monitores_responsaveis;
DROP INDEX public.fk_disciplinas_turmas;
DROP INDEX public.fk_codigos;
DROP INDEX public.fk_avaliacoes_responsaveis;
DROP INDEX public.fk_avaliacoes_notas;
DROP INDEX public.fk_alunos_notas;
DROP INDEX public.fk_alunos_composicaoturmas;
ALTER TABLE ONLY public.turmas DROP CONSTRAINT turmas_pkey;
ALTER TABLE ONLY public.semestres DROP CONSTRAINT semestres_pkey;
ALTER TABLE ONLY public.responsaveis DROP CONSTRAINT responsaveis_pkey;
ALTER TABLE ONLY public.professores DROP CONSTRAINT professores_pkey;
ALTER TABLE ONLY public.pessoas DROP CONSTRAINT pessoa_pkey;
ALTER TABLE ONLY public.observacoes DROP CONSTRAINT observacoes_pkey;
ALTER TABLE ONLY public.notas DROP CONSTRAINT notas_pkey;
ALTER TABLE ONLY public.monitores DROP CONSTRAINT monitores_pkey;
ALTER TABLE ONLY public.log_responsaveis DROP CONSTRAINT log_responsaveis_pkey;
ALTER TABLE ONLY public.disciplinas DROP CONSTRAINT disciplinas_pkey;
ALTER TABLE ONLY public.composicao_turmas DROP CONSTRAINT composicao_turmas_pkey;
ALTER TABLE ONLY public.codigos DROP CONSTRAINT codigos_pkey;
ALTER TABLE ONLY public.codigo_item DROP CONSTRAINT codigo_item_pkey;
ALTER TABLE ONLY public.avaliacoes DROP CONSTRAINT avaliacoes_pkey;
ALTER TABLE ONLY public.alunos DROP CONSTRAINT alunos_pkey;
ALTER TABLE ONLY public.acessos DROP CONSTRAINT acessos_pkey;
ALTER TABLE public.turmas ALTER COLUMN tur_ctur DROP DEFAULT;
ALTER TABLE public.semestres ALTER COLUMN sem_csem DROP DEFAULT;
ALTER TABLE public.responsaveis ALTER COLUMN res_cres DROP DEFAULT;
ALTER TABLE public.pessoas ALTER COLUMN pes_cpes DROP DEFAULT;
ALTER TABLE public.observacoes ALTER COLUMN obs_cobs DROP DEFAULT;
ALTER TABLE public.log_responsaveis ALTER COLUMN lre_clre DROP DEFAULT;
ALTER TABLE public.disciplinas ALTER COLUMN dis_cdis DROP DEFAULT;
ALTER TABLE public.codigos ALTER COLUMN cod_ccod DROP DEFAULT;
ALTER TABLE public.codigo_item ALTER COLUMN cit_ccit DROP DEFAULT;
ALTER TABLE public.avaliacoes ALTER COLUMN ava_cava DROP DEFAULT;
ALTER TABLE public.acessos ALTER COLUMN ace_cace DROP DEFAULT;
DROP SEQUENCE public.turmas_tur_ctur_seq;
DROP TABLE public.turmas;
DROP SEQUENCE public.semestres_sem_csem_seq;
DROP TABLE public.semestres;
DROP SEQUENCE public.responsaveis_res_cres_seq;
DROP TABLE public.responsaveis;
DROP TABLE public.professores;
DROP SEQUENCE public.pessoa_pes_cpes_seq;
DROP TABLE public.pessoas;
DROP SEQUENCE public.observacoes_obs_cobs_seq;
DROP TABLE public.observacoes;
DROP TABLE public.notas;
DROP TABLE public.monitores;
DROP SEQUENCE public.log_responsaveis_lre_clre_seq;
DROP TABLE public.log_responsaveis;
DROP SEQUENCE public.disciplinas_dis_cdis_seq;
DROP TABLE public.disciplinas;
DROP TABLE public.composicao_turmas;
DROP SEQUENCE public.codigos_cod_ccod_seq;
DROP TABLE public.codigos;
DROP SEQUENCE public.codigo_item_cit_ccit_seq;
DROP TABLE public.codigo_item;
DROP SEQUENCE public.avaliacoes_ava_cava_seq;
DROP TABLE public.avaliacoes;
DROP TABLE public.alunos;
DROP SEQUENCE public.acessos_ace_cace_seq;
DROP TABLE public.acessos;
DROP FUNCTION public.to_ascii(bytea, name);
DROP SCHEMA public;
--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 1948 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET search_path = public, pg_catalog;

--
-- TOC entry 7 (class 1255 OID 26292)
-- Dependencies: 3
-- Name: to_ascii(bytea, name); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION to_ascii(bytea, name) RETURNS text
    LANGUAGE internal IMMUTABLE STRICT
    AS $$to_ascii_encname$$;


ALTER FUNCTION public.to_ascii(bytea, name) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1539 (class 1259 OID 26078)
-- Dependencies: 3
-- Name: acessos; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE acessos (
    ace_cace integer NOT NULL,
    ace_cpes integer NOT NULL,
    ace_ip character varying(40),
    ace_dhor timestamp without time zone
);


ALTER TABLE public.acessos OWNER TO emural;

--
-- TOC entry 1538 (class 1259 OID 26076)
-- Dependencies: 3 1539
-- Name: acessos_ace_cace_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE acessos_ace_cace_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acessos_ace_cace_seq OWNER TO emural;

--
-- TOC entry 1950 (class 0 OID 0)
-- Dependencies: 1538
-- Name: acessos_ace_cace_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE acessos_ace_cace_seq OWNED BY acessos.ace_cace;


--
-- TOC entry 1951 (class 0 OID 0)
-- Dependencies: 1538
-- Name: acessos_ace_cace_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('acessos_ace_cace_seq', 1, false);


--
-- TOC entry 1541 (class 1259 OID 26103)
-- Dependencies: 3
-- Name: alunos; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE alunos (
    alu_calu integer NOT NULL,
    alu_matr character varying(40),
    alu_emai character varying(80),
    alu_rema boolean,
    alu_ocur character varying(20)
);


ALTER TABLE public.alunos OWNER TO emural;

--
-- TOC entry 1547 (class 1259 OID 26201)
-- Dependencies: 3
-- Name: avaliacoes; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE avaliacoes (
    ava_cava integer NOT NULL,
    ava_ctur integer NOT NULL,
    ava_orde smallint,
    ava_tipo character varying(20),
    ava_drea date,
    ava_divu boolean,
    ava_ddiv date,
    ava_nome character varying(50),
    ava_nres character varying(25)
);


ALTER TABLE public.avaliacoes OWNER TO emural;

--
-- TOC entry 1546 (class 1259 OID 26199)
-- Dependencies: 1547 3
-- Name: avaliacoes_ava_cava_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE avaliacoes_ava_cava_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.avaliacoes_ava_cava_seq OWNER TO emural;

--
-- TOC entry 1952 (class 0 OID 0)
-- Dependencies: 1546
-- Name: avaliacoes_ava_cava_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE avaliacoes_ava_cava_seq OWNED BY avaliacoes.ava_cava;


--
-- TOC entry 1953 (class 0 OID 0)
-- Dependencies: 1546
-- Name: avaliacoes_ava_cava_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('avaliacoes_ava_cava_seq', 1, true);


--
-- TOC entry 1551 (class 1259 OID 26269)
-- Dependencies: 3
-- Name: codigo_item; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE codigo_item (
    cit_ccit integer NOT NULL,
    cit_ccod integer NOT NULL,
    cit_dres character varying(10),
    cit_desc character varying(100),
    cit_dre2 character varying(20)
);


ALTER TABLE public.codigo_item OWNER TO emural;

--
-- TOC entry 1550 (class 1259 OID 26267)
-- Dependencies: 1551 3
-- Name: codigo_item_cit_ccit_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE codigo_item_cit_ccit_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.codigo_item_cit_ccit_seq OWNER TO emural;

--
-- TOC entry 1954 (class 0 OID 0)
-- Dependencies: 1550
-- Name: codigo_item_cit_ccit_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE codigo_item_cit_ccit_seq OWNED BY codigo_item.cit_ccit;


--
-- TOC entry 1955 (class 0 OID 0)
-- Dependencies: 1550
-- Name: codigo_item_cit_ccit_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('codigo_item_cit_ccit_seq', 22, true);


--
-- TOC entry 1549 (class 1259 OID 26261)
-- Dependencies: 3
-- Name: codigos; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE codigos (
    cod_ccod integer NOT NULL,
    cod_desc character varying(100),
    cod_visi boolean
);


ALTER TABLE public.codigos OWNER TO emural;

--
-- TOC entry 1548 (class 1259 OID 26259)
-- Dependencies: 3 1549
-- Name: codigos_cod_ccod_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE codigos_cod_ccod_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.codigos_cod_ccod_seq OWNER TO emural;

--
-- TOC entry 1956 (class 0 OID 0)
-- Dependencies: 1548
-- Name: codigos_cod_ccod_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE codigos_cod_ccod_seq OWNED BY codigos.cod_ccod;


--
-- TOC entry 1957 (class 0 OID 0)
-- Dependencies: 1548
-- Name: codigos_cod_ccod_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('codigos_cod_ccod_seq', 1, true);


--
-- TOC entry 1553 (class 1259 OID 26412)
-- Dependencies: 1845 3
-- Name: composicao_turmas; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE composicao_turmas (
    ctu_calu integer NOT NULL,
    ctu_ctur integer NOT NULL,
    ctu_mens character varying(10),
    ctu_medi real,
    ctu_falt integer,
    ctu_stat boolean DEFAULT true,
    ctu_pfal real
);


ALTER TABLE public.composicao_turmas OWNER TO emural;

--
-- TOC entry 1958 (class 0 OID 0)
-- Dependencies: 1553
-- Name: COLUMN composicao_turmas.ctu_mens; Type: COMMENT; Schema: public; Owner: emural
--

COMMENT ON COLUMN composicao_turmas.ctu_mens IS 'Mensao';


--
-- TOC entry 1959 (class 0 OID 0)
-- Dependencies: 1553
-- Name: COLUMN composicao_turmas.ctu_medi; Type: COMMENT; Schema: public; Owner: emural
--

COMMENT ON COLUMN composicao_turmas.ctu_medi IS 'Media';


--
-- TOC entry 1960 (class 0 OID 0)
-- Dependencies: 1553
-- Name: COLUMN composicao_turmas.ctu_falt; Type: COMMENT; Schema: public; Owner: emural
--

COMMENT ON COLUMN composicao_turmas.ctu_falt IS 'Faltas';


--
-- TOC entry 1534 (class 1259 OID 26050)
-- Dependencies: 3
-- Name: disciplinas; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE disciplinas (
    dis_cdis integer NOT NULL,
    dis_desc character varying(40),
    dis_dep character varying(10),
    dis_naul integer,
    dis_ccpd character varying(40),
    dis_cred integer
);


ALTER TABLE public.disciplinas OWNER TO emural;

--
-- TOC entry 1533 (class 1259 OID 26048)
-- Dependencies: 1534 3
-- Name: disciplinas_dis_cdis_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE disciplinas_dis_cdis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.disciplinas_dis_cdis_seq OWNER TO emural;

--
-- TOC entry 1961 (class 0 OID 0)
-- Dependencies: 1533
-- Name: disciplinas_dis_cdis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE disciplinas_dis_cdis_seq OWNED BY disciplinas.dis_cdis;


--
-- TOC entry 1962 (class 0 OID 0)
-- Dependencies: 1533
-- Name: disciplinas_dis_cdis_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('disciplinas_dis_cdis_seq', 2, true);


--
-- TOC entry 1557 (class 1259 OID 26592)
-- Dependencies: 3
-- Name: log_responsaveis; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE log_responsaveis (
    lre_clre integer NOT NULL,
    lre_cres integer NOT NULL,
    lre_desc character varying(100),
    lre_dhor timestamp without time zone
);


ALTER TABLE public.log_responsaveis OWNER TO emural;

--
-- TOC entry 1556 (class 1259 OID 26590)
-- Dependencies: 3 1557
-- Name: log_responsaveis_lre_clre_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE log_responsaveis_lre_clre_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_responsaveis_lre_clre_seq OWNER TO emural;

--
-- TOC entry 1963 (class 0 OID 0)
-- Dependencies: 1556
-- Name: log_responsaveis_lre_clre_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE log_responsaveis_lre_clre_seq OWNED BY log_responsaveis.lre_clre;


--
-- TOC entry 1964 (class 0 OID 0)
-- Dependencies: 1556
-- Name: log_responsaveis_lre_clre_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('log_responsaveis_lre_clre_seq', 1, false);


--
-- TOC entry 1540 (class 1259 OID 26091)
-- Dependencies: 3
-- Name: monitores; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE monitores (
    mon_cmon integer NOT NULL,
    mon_stat boolean,
    mon_cuse character varying(100)
);


ALTER TABLE public.monitores OWNER TO emural;

--
-- TOC entry 1552 (class 1259 OID 26374)
-- Dependencies: 3
-- Name: notas; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE notas (
    not_calu integer NOT NULL,
    not_cava integer NOT NULL,
    not_valo real,
    not_obs character varying(200)
);


ALTER TABLE public.notas OWNER TO emural;

--
-- TOC entry 1965 (class 0 OID 0)
-- Dependencies: 1552
-- Name: COLUMN notas.not_valo; Type: COMMENT; Schema: public; Owner: emural
--

COMMENT ON COLUMN notas.not_valo IS 'Valor da nota';


--
-- TOC entry 1966 (class 0 OID 0)
-- Dependencies: 1552
-- Name: COLUMN notas.not_obs; Type: COMMENT; Schema: public; Owner: emural
--

COMMENT ON COLUMN notas.not_obs IS 'Observacao';


--
-- TOC entry 1545 (class 1259 OID 26183)
-- Dependencies: 3
-- Name: observacoes; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE observacoes (
    obs_cobs integer NOT NULL,
    obs_ctur integer NOT NULL,
    obs_desc text,
    obs_data date,
    obs_vali boolean,
    obs_titu character varying(100)
);


ALTER TABLE public.observacoes OWNER TO emural;

--
-- TOC entry 1544 (class 1259 OID 26181)
-- Dependencies: 3 1545
-- Name: observacoes_obs_cobs_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE observacoes_obs_cobs_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.observacoes_obs_cobs_seq OWNER TO emural;

--
-- TOC entry 1967 (class 0 OID 0)
-- Dependencies: 1544
-- Name: observacoes_obs_cobs_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE observacoes_obs_cobs_seq OWNED BY observacoes.obs_cobs;


--
-- TOC entry 1968 (class 0 OID 0)
-- Dependencies: 1544
-- Name: observacoes_obs_cobs_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('observacoes_obs_cobs_seq', 1, true);


--
-- TOC entry 1536 (class 1259 OID 26058)
-- Dependencies: 3
-- Name: pessoas; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE pessoas (
    pes_cpes integer NOT NULL,
    pes_usua character varying(50),
    pes_senh character varying(100),
    pes_nome character varying(150),
    pes_tipo character varying(10)
);


ALTER TABLE public.pessoas OWNER TO emural;

--
-- TOC entry 1535 (class 1259 OID 26056)
-- Dependencies: 1536 3
-- Name: pessoa_pes_cpes_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE pessoa_pes_cpes_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pessoa_pes_cpes_seq OWNER TO emural;

--
-- TOC entry 1969 (class 0 OID 0)
-- Dependencies: 1535
-- Name: pessoa_pes_cpes_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE pessoa_pes_cpes_seq OWNED BY pessoas.pes_cpes;


--
-- TOC entry 1970 (class 0 OID 0)
-- Dependencies: 1535
-- Name: pessoa_pes_cpes_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('pessoa_pes_cpes_seq', 36, true);


--
-- TOC entry 1537 (class 1259 OID 26064)
-- Dependencies: 3
-- Name: professores; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE professores (
    pro_cpro integer NOT NULL,
    pro_cuse character varying(100) NOT NULL
);


ALTER TABLE public.professores OWNER TO emural;

--
-- TOC entry 1555 (class 1259 OID 26570)
-- Dependencies: 3
-- Name: responsaveis; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE responsaveis (
    res_cres integer NOT NULL,
    res_cmon integer NOT NULL,
    res_cava integer NOT NULL,
    res_auto boolean,
    res_edit boolean,
    res_conf boolean,
    res_vali boolean
);


ALTER TABLE public.responsaveis OWNER TO emural;

--
-- TOC entry 1554 (class 1259 OID 26568)
-- Dependencies: 3 1555
-- Name: responsaveis_res_cres_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE responsaveis_res_cres_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.responsaveis_res_cres_seq OWNER TO emural;

--
-- TOC entry 1971 (class 0 OID 0)
-- Dependencies: 1554
-- Name: responsaveis_res_cres_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE responsaveis_res_cres_seq OWNED BY responsaveis.res_cres;


--
-- TOC entry 1972 (class 0 OID 0)
-- Dependencies: 1554
-- Name: responsaveis_res_cres_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('responsaveis_res_cres_seq', 1, true);


--
-- TOC entry 1559 (class 1259 OID 26610)
-- Dependencies: 3
-- Name: semestres; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE semestres (
    sem_csem integer NOT NULL,
    sem_ano integer,
    sem_seme integer,
    sem_inic date,
    sem_fim date
);


ALTER TABLE public.semestres OWNER TO emural;

--
-- TOC entry 1558 (class 1259 OID 26608)
-- Dependencies: 1559 3
-- Name: semestres_sem_csem_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE semestres_sem_csem_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.semestres_sem_csem_seq OWNER TO emural;

--
-- TOC entry 1973 (class 0 OID 0)
-- Dependencies: 1558
-- Name: semestres_sem_csem_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE semestres_sem_csem_seq OWNED BY semestres.sem_csem;


--
-- TOC entry 1974 (class 0 OID 0)
-- Dependencies: 1558
-- Name: semestres_sem_csem_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('semestres_sem_csem_seq', 5, true);


--
-- TOC entry 1543 (class 1259 OID 26117)
-- Dependencies: 3
-- Name: turmas; Type: TABLE; Schema: public; Owner: emural; Tablespace: 
--

CREATE TABLE turmas (
    tur_ctur integer NOT NULL,
    tur_cpro integer NOT NULL,
    tur_cdis integer NOT NULL,
    tur_peri character varying(10),
    tur_desc character varying(40),
    tur_ano integer,
    tur_seme integer,
    tur_cnot character varying(2000),
    tur_sala character varying(60),
    tur_emed boolean,
    tur_emen boolean
);


ALTER TABLE public.turmas OWNER TO emural;

--
-- TOC entry 1542 (class 1259 OID 26115)
-- Dependencies: 3 1543
-- Name: turmas_tur_ctur_seq; Type: SEQUENCE; Schema: public; Owner: emural
--

CREATE SEQUENCE turmas_tur_ctur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.turmas_tur_ctur_seq OWNER TO emural;

--
-- TOC entry 1975 (class 0 OID 0)
-- Dependencies: 1542
-- Name: turmas_tur_ctur_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: emural
--

ALTER SEQUENCE turmas_tur_ctur_seq OWNED BY turmas.tur_ctur;


--
-- TOC entry 1976 (class 0 OID 0)
-- Dependencies: 1542
-- Name: turmas_tur_ctur_seq; Type: SEQUENCE SET; Schema: public; Owner: emural
--

SELECT pg_catalog.setval('turmas_tur_ctur_seq', 5, true);


--
-- TOC entry 1839 (class 2604 OID 26081)
-- Dependencies: 1538 1539 1539
-- Name: ace_cace; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE acessos ALTER COLUMN ace_cace SET DEFAULT nextval('acessos_ace_cace_seq'::regclass);


--
-- TOC entry 1842 (class 2604 OID 26204)
-- Dependencies: 1546 1547 1547
-- Name: ava_cava; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE avaliacoes ALTER COLUMN ava_cava SET DEFAULT nextval('avaliacoes_ava_cava_seq'::regclass);


--
-- TOC entry 1844 (class 2604 OID 26272)
-- Dependencies: 1550 1551 1551
-- Name: cit_ccit; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE codigo_item ALTER COLUMN cit_ccit SET DEFAULT nextval('codigo_item_cit_ccit_seq'::regclass);


--
-- TOC entry 1843 (class 2604 OID 26264)
-- Dependencies: 1549 1548 1549
-- Name: cod_ccod; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE codigos ALTER COLUMN cod_ccod SET DEFAULT nextval('codigos_cod_ccod_seq'::regclass);


--
-- TOC entry 1837 (class 2604 OID 26053)
-- Dependencies: 1533 1534 1534
-- Name: dis_cdis; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE disciplinas ALTER COLUMN dis_cdis SET DEFAULT nextval('disciplinas_dis_cdis_seq'::regclass);


--
-- TOC entry 1847 (class 2604 OID 26595)
-- Dependencies: 1556 1557 1557
-- Name: lre_clre; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE log_responsaveis ALTER COLUMN lre_clre SET DEFAULT nextval('log_responsaveis_lre_clre_seq'::regclass);


--
-- TOC entry 1841 (class 2604 OID 26186)
-- Dependencies: 1544 1545 1545
-- Name: obs_cobs; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE observacoes ALTER COLUMN obs_cobs SET DEFAULT nextval('observacoes_obs_cobs_seq'::regclass);


--
-- TOC entry 1838 (class 2604 OID 26061)
-- Dependencies: 1536 1535 1536
-- Name: pes_cpes; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE pessoas ALTER COLUMN pes_cpes SET DEFAULT nextval('pessoa_pes_cpes_seq'::regclass);


--
-- TOC entry 1846 (class 2604 OID 26573)
-- Dependencies: 1555 1554 1555
-- Name: res_cres; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE responsaveis ALTER COLUMN res_cres SET DEFAULT nextval('responsaveis_res_cres_seq'::regclass);


--
-- TOC entry 1848 (class 2604 OID 26613)
-- Dependencies: 1558 1559 1559
-- Name: sem_csem; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE semestres ALTER COLUMN sem_csem SET DEFAULT nextval('semestres_sem_csem_seq'::regclass);


--
-- TOC entry 1840 (class 2604 OID 26120)
-- Dependencies: 1543 1542 1543
-- Name: tur_ctur; Type: DEFAULT; Schema: public; Owner: emural
--

ALTER TABLE turmas ALTER COLUMN tur_ctur SET DEFAULT nextval('turmas_tur_ctur_seq'::regclass);


--
-- TOC entry 1929 (class 0 OID 26050)
-- Dependencies: 1534
-- Data for Name: disciplinas; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO disciplinas VALUES (1, 'Calculo I', 'matematica', 40, NULL, 6);
INSERT INTO disciplinas VALUES (2, 'Algebra Linear', 'matematica', 40, NULL, 4);


--
-- TOC entry 1930 (class 0 OID 26058)
-- Dependencies: 1536
-- Data for Name: pessoas; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO pessoas VALUES (1, 'leandro', NULL, 'Leandro', 'professor');
INSERT INTO pessoas VALUES (2, 'joel_guilherme', NULL, 'Joel Guilherme', 'professor');
INSERT INTO pessoas VALUES (3, 'aluno01', NULL, 'Aluno 01', 'aluno');
INSERT INTO pessoas VALUES (4, 'aluno02', NULL, 'Aluno 02', 'aluno');
INSERT INTO pessoas VALUES (5, 'aluno03', NULL, 'Aluno 03', 'aluno');
INSERT INTO pessoas VALUES (6, 'aluno04', NULL, 'Aluno 04', 'aluno');
INSERT INTO pessoas VALUES (7, 'aluno05', NULL, 'Aluno 05', 'aluno');
INSERT INTO pessoas VALUES (8, 'aluno06', NULL, 'Aluno 06', 'aluno');
INSERT INTO pessoas VALUES (9, 'aluno07', NULL, 'Aluno 07', 'aluno');
INSERT INTO pessoas VALUES (10, 'aluno08', NULL, 'Aluno 08', 'aluno');
INSERT INTO pessoas VALUES (11, 'aluno09', NULL, 'Aluno 09', 'aluno');
INSERT INTO pessoas VALUES (12, 'aluno10', NULL, 'Aluno 10', 'aluno');
INSERT INTO pessoas VALUES (13, 'aluno11', NULL, 'Aluno 11', 'aluno');
INSERT INTO pessoas VALUES (14, 'aluno12', NULL, 'Aluno 12', 'aluno');
INSERT INTO pessoas VALUES (15, 'aluno13', NULL, 'Aluno 13', 'aluno');
INSERT INTO pessoas VALUES (16, 'aluno14', NULL, 'Aluno 14', 'aluno');
INSERT INTO pessoas VALUES (17, 'aluno15', NULL, 'Aluno 15', 'aluno');
INSERT INTO pessoas VALUES (18, 'aluno16', NULL, 'Aluno 16', 'aluno');
INSERT INTO pessoas VALUES (19, 'aluno17', NULL, 'Aluno 17', 'aluno');
INSERT INTO pessoas VALUES (20, 'aluno18', NULL, 'Aluno 18', 'aluno');
INSERT INTO pessoas VALUES (21, 'aluno19', NULL, 'Aluno 19', 'aluno');
INSERT INTO pessoas VALUES (22, 'aluno20', NULL, 'Aluno 20', 'aluno');
INSERT INTO pessoas VALUES (23, 'aluno21', NULL, 'Aluno 21', 'aluno');
INSERT INTO pessoas VALUES (24, 'aluno22', NULL, 'Aluno 22', 'aluno');
INSERT INTO pessoas VALUES (25, 'aluno23', NULL, 'Aluno 23', 'aluno');
INSERT INTO pessoas VALUES (26, 'aluno24', NULL, 'Aluno 24', 'aluno');
INSERT INTO pessoas VALUES (27, 'aluno25', NULL, 'Aluno 25', 'aluno');
INSERT INTO pessoas VALUES (28, 'aluno26', NULL, 'Aluno 26', 'aluno');
INSERT INTO pessoas VALUES (29, 'aluno27', NULL, 'Aluno 27', 'aluno');
INSERT INTO pessoas VALUES (30, 'aluno28', NULL, 'Aluno 28', 'aluno');
INSERT INTO pessoas VALUES (31, 'aluno29', NULL, 'Aluno 29', 'aluno');
INSERT INTO pessoas VALUES (32, 'aluno30', NULL, 'Aluno 30', 'aluno');
INSERT INTO pessoas VALUES (33, 'monitor1', NULL, 'Monitor 1', 'monitor');
INSERT INTO pessoas VALUES (34, 'monitor2', NULL, 'Monitor 2', 'monitor');
INSERT INTO pessoas VALUES (35, 'monitor3', NULL, 'Monitor 3', 'monitor');
INSERT INTO pessoas VALUES (36, 'coordenador', 'senha', 'Coordenador', 'coord');


--
-- TOC entry 1934 (class 0 OID 26103)
-- Dependencies: 1541
-- Data for Name: alunos; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO alunos VALUES (3, '201201258963001', 'aluno01@alunos.com', true, NULL);
INSERT INTO alunos VALUES (4, '201201258963002', 'aluno02@alunos.com', true, NULL);
INSERT INTO alunos VALUES (5, '201201258963003', 'aluno03@alunos.com', true, NULL);
INSERT INTO alunos VALUES (6, '201201258963004', 'aluno04@alunos.com', true, NULL);
INSERT INTO alunos VALUES (7, '201201258963005', 'aluno05@alunos.com', true, NULL);
INSERT INTO alunos VALUES (8, '201201258963006', 'aluno06@alunos.com', true, NULL);
INSERT INTO alunos VALUES (9, '201201258963007', 'aluno07@alunos.com', true, NULL);
INSERT INTO alunos VALUES (10, '201201258963008', 'aluno08@alunos.com', true, NULL);
INSERT INTO alunos VALUES (11, '201201258963009', 'aluno09@alunos.com', true, NULL);
INSERT INTO alunos VALUES (12, '201201258963010', 'aluno10@alunos.com', true, NULL);
INSERT INTO alunos VALUES (13, '201201258963011', 'aluno11@alunos.com', true, NULL);
INSERT INTO alunos VALUES (14, '201201258963012', 'aluno12@alunos.com', true, NULL);
INSERT INTO alunos VALUES (15, '201201258963013', 'aluno13@alunos.com', true, NULL);
INSERT INTO alunos VALUES (16, '201201258963014', 'aluno14@alunos.com', true, NULL);
INSERT INTO alunos VALUES (17, '201201258963015', 'aluno15@alunos.com', true, NULL);
INSERT INTO alunos VALUES (18, '201201258963016', 'aluno16@alunos.com', true, NULL);
INSERT INTO alunos VALUES (19, '201201258963017', 'aluno17@alunos.com', true, NULL);
INSERT INTO alunos VALUES (20, '201201258963018', 'aluno18@alunos.com', true, NULL);
INSERT INTO alunos VALUES (21, '201201258963019', 'aluno19@alunos.com', true, NULL);
INSERT INTO alunos VALUES (22, '201201258963020', 'aluno20@alunos.com', true, NULL);
INSERT INTO alunos VALUES (23, '201201258963021', 'aluno21@alunos.com', true, NULL);
INSERT INTO alunos VALUES (24, '201201258963022', 'aluno22@alunos.com', true, NULL);
INSERT INTO alunos VALUES (25, '201201258963023', 'aluno23@alunos.com', true, NULL);
INSERT INTO alunos VALUES (26, '201201258963024', 'aluno24@alunos.com', true, NULL);
INSERT INTO alunos VALUES (27, '201201258963025', 'aluno25@alunos.com', true, NULL);
INSERT INTO alunos VALUES (28, '201201258963026', 'aluno26@alunos.com', true, NULL);
INSERT INTO alunos VALUES (29, '201201258963027', 'aluno27@alunos.com', true, NULL);
INSERT INTO alunos VALUES (30, '201201258963028', 'aluno28@alunos.com', true, NULL);
INSERT INTO alunos VALUES (31, '201201258963029', 'aluno29@alunos.com', true, NULL);
INSERT INTO alunos VALUES (32, '201201258963030', 'aluno30@alunos.com', true, NULL);


--
-- TOC entry 1939 (class 0 OID 26269)
-- Dependencies: 1551
-- Data for Name: codigo_item; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO codigo_item VALUES (3, 1, NULL, 'Teste', 'teste');
INSERT INTO codigo_item VALUES (1, 1, NULL, 'Prova', 'prova');
INSERT INTO codigo_item VALUES (6, 1, NULL, 'Seminário', 'seminário');
INSERT INTO codigo_item VALUES (8, 1, NULL, 'Avaliação', 'avaliação');
INSERT INTO codigo_item VALUES (14, 1, NULL, 'Trabalho', 'trabalho');
INSERT INTO codigo_item VALUES (16, 1, NULL, 'Texto', 'texto');
INSERT INTO codigo_item VALUES (17, 1, NULL, 'Fichamento', 'fichamento');
INSERT INTO codigo_item VALUES (18, 1, NULL, 'Testinho', 'testinho');
INSERT INTO codigo_item VALUES (19, 1, NULL, 'Apresentação', 'apresentação');
INSERT INTO codigo_item VALUES (20, 1, NULL, 'Portifolio', 'portifolio');
INSERT INTO codigo_item VALUES (21, 1, NULL, 'Exercicio', 'exercicio');
INSERT INTO codigo_item VALUES (22, 1, NULL, 'Textinho', 'textinho');


--
-- TOC entry 1938 (class 0 OID 26261)
-- Dependencies: 1549
-- Data for Name: codigos; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO codigos VALUES (1, 'Avaliação tipo', true);


--
-- TOC entry 1941 (class 0 OID 26412)
-- Dependencies: 1553
-- Data for Name: composicao_turmas; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO composicao_turmas VALUES (18, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (19, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (20, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (21, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (22, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (23, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (24, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (25, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (26, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (27, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (8, 5, 'MS', 7.5, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (9, 5, 'MI', 4, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (10, 5, 'MS', 8, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (11, 5, 'MM', 5.5, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (12, 5, 'MS', 8.5, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (13, 5, 'MS', 7, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (14, 5, 'MI', 3.5, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (15, 5, 'MI', 3, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (16, 5, 'MI', 4, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (17, 5, 'MI', 4.5, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (18, 5, 'II', 2, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (19, 5, 'MM', 5.75, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (20, 5, 'MM', 6.8000002, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (21, 5, 'MM', 6.0900002, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (22, 5, 'MI', 4.8000002, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (23, 5, 'MS', 8, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (24, 5, 'MM', 6, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (25, 5, 'MM', 5, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (26, 5, 'MM', 5.75, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (27, 5, 'MM', 6.4000001, 0, true, NULL);
INSERT INTO composicao_turmas VALUES (28, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (29, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (30, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (31, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (32, 3, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (3, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (4, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (5, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (6, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (7, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (8, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (9, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (10, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (11, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (12, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (13, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (14, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (15, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (16, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (17, 1, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (8, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (9, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (10, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (11, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (12, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (13, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (14, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (15, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (16, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (17, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (18, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (19, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (20, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (21, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (22, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (23, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (24, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (25, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (26, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (27, 2, NULL, NULL, NULL, true, NULL);
INSERT INTO composicao_turmas VALUES (3, 4, 'MS', 8.5, 0, true, 0);
INSERT INTO composicao_turmas VALUES (4, 4, 'MI', 4.1300001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (5, 4, 'MM', 5, 0, true, 0);
INSERT INTO composicao_turmas VALUES (6, 4, 'MI', 3.6300001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (7, 4, 'MI', 4.6300001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (8, 4, 'MM', 6.75, 0, true, 0);
INSERT INTO composicao_turmas VALUES (9, 4, 'MM', 5.3800001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (10, 4, 'MI', 4.5, 0, true, 0);
INSERT INTO composicao_turmas VALUES (11, 4, 'MS', 7.6300001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (12, 4, 'MM', 5, 0, true, 0);
INSERT INTO composicao_turmas VALUES (13, 4, 'II', 2.8800001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (14, 4, 'II', 2.75, 0, true, 0);
INSERT INTO composicao_turmas VALUES (15, 4, 'MM', 5.8800001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (16, 4, 'II', 2.6900001, 0, true, 0);
INSERT INTO composicao_turmas VALUES (17, 4, 'MM', 5, 0, true, 0);


--
-- TOC entry 1943 (class 0 OID 26592)
-- Dependencies: 1557
-- Data for Name: log_responsaveis; Type: TABLE DATA; Schema: public; Owner: emural
--



--
-- TOC entry 1933 (class 0 OID 26091)
-- Dependencies: 1540
-- Data for Name: monitores; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO monitores VALUES (33, true, '12345');
INSERT INTO monitores VALUES (34, true, '12346');
INSERT INTO monitores VALUES (35, true, '12347');


--
-- TOC entry 1931 (class 0 OID 26064)
-- Dependencies: 1537
-- Data for Name: professores; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO professores VALUES (1, '1');
INSERT INTO professores VALUES (2, '2');


--
-- TOC entry 1944 (class 0 OID 26610)
-- Dependencies: 1559
-- Data for Name: semestres; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO semestres VALUES (1, 2011, 1, NULL, NULL);
INSERT INTO semestres VALUES (2, 2011, 2, NULL, NULL);
INSERT INTO semestres VALUES (3, 2012, 1, '2012-01-01', '2012-06-30');


--
-- TOC entry 1935 (class 0 OID 26117)
-- Dependencies: 1543
-- Data for Name: turmas; Type: TABLE DATA; Schema: public; Owner: emural
--

INSERT INTO turmas VALUES (1, 1, 1, 'mat', 'A', 2012, 1, NULL, 'CB2', false, true);
INSERT INTO turmas VALUES (2, 1, 2, 'mat', 'A', 2012, 1, NULL, 'CB1', true, true);
INSERT INTO turmas VALUES (3, 2, 1, 'vesp', 'B', 2012, 1, NULL, 'CB1', true, true);
INSERT INTO turmas VALUES (4, 1, 1, 'mat', 'A', 2011, 2, NULL, 'CB2', true, true);
INSERT INTO turmas VALUES (5, 1, 2, 'mat', 'A', 2011, 1, NULL, 'CB1', true, true);


--
-- TOC entry 1858 (class 2606 OID 26083)
-- Dependencies: 1539 1539
-- Name: acessos_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY acessos
    ADD CONSTRAINT acessos_pkey PRIMARY KEY (ace_cace);


--
-- TOC entry 1866 (class 2606 OID 26107)
-- Dependencies: 1541 1541
-- Name: alunos_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY alunos
    ADD CONSTRAINT alunos_pkey PRIMARY KEY (alu_calu);


--
-- TOC entry 1880 (class 2606 OID 26206)
-- Dependencies: 1547 1547
-- Name: avaliacoes_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY avaliacoes
    ADD CONSTRAINT avaliacoes_pkey PRIMARY KEY (ava_cava);


--
-- TOC entry 1886 (class 2606 OID 26274)
-- Dependencies: 1551 1551
-- Name: codigo_item_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY codigo_item
    ADD CONSTRAINT codigo_item_pkey PRIMARY KEY (cit_ccit);


--
-- TOC entry 1884 (class 2606 OID 26266)
-- Dependencies: 1549 1549
-- Name: codigos_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY codigos
    ADD CONSTRAINT codigos_pkey PRIMARY KEY (cod_ccod);


--
-- TOC entry 1896 (class 2606 OID 26416)
-- Dependencies: 1553 1553 1553
-- Name: composicao_turmas_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY composicao_turmas
    ADD CONSTRAINT composicao_turmas_pkey PRIMARY KEY (ctu_ctur, ctu_calu);


--
-- TOC entry 1850 (class 2606 OID 26055)
-- Dependencies: 1534 1534
-- Name: disciplinas_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY disciplinas
    ADD CONSTRAINT disciplinas_pkey PRIMARY KEY (dis_cdis);


--
-- TOC entry 1910 (class 2606 OID 26597)
-- Dependencies: 1557 1557
-- Name: log_responsaveis_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY log_responsaveis
    ADD CONSTRAINT log_responsaveis_pkey PRIMARY KEY (lre_clre);


--
-- TOC entry 1864 (class 2606 OID 26095)
-- Dependencies: 1540 1540
-- Name: monitores_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY monitores
    ADD CONSTRAINT monitores_pkey PRIMARY KEY (mon_cmon);


--
-- TOC entry 1894 (class 2606 OID 26378)
-- Dependencies: 1552 1552 1552
-- Name: notas_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY notas
    ADD CONSTRAINT notas_pkey PRIMARY KEY (not_calu, not_cava);


--
-- TOC entry 1878 (class 2606 OID 26191)
-- Dependencies: 1545 1545
-- Name: observacoes_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY observacoes
    ADD CONSTRAINT observacoes_pkey PRIMARY KEY (obs_cobs);


--
-- TOC entry 1852 (class 2606 OID 26063)
-- Dependencies: 1536 1536
-- Name: pessoa_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT pessoa_pkey PRIMARY KEY (pes_cpes);


--
-- TOC entry 1856 (class 2606 OID 26068)
-- Dependencies: 1537 1537
-- Name: professores_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY professores
    ADD CONSTRAINT professores_pkey PRIMARY KEY (pro_cpro);


--
-- TOC entry 1906 (class 2606 OID 26575)
-- Dependencies: 1555 1555
-- Name: responsaveis_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY responsaveis
    ADD CONSTRAINT responsaveis_pkey PRIMARY KEY (res_cres);


--
-- TOC entry 1912 (class 2606 OID 26615)
-- Dependencies: 1559 1559
-- Name: semestres_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY semestres
    ADD CONSTRAINT semestres_pkey PRIMARY KEY (sem_csem);


--
-- TOC entry 1874 (class 2606 OID 26122)
-- Dependencies: 1543 1543
-- Name: turmas_pkey; Type: CONSTRAINT; Schema: public; Owner: emural; Tablespace: 
--

ALTER TABLE ONLY turmas
    ADD CONSTRAINT turmas_pkey PRIMARY KEY (tur_ctur);


--
-- TOC entry 1897 (class 1259 OID 26428)
-- Dependencies: 1553
-- Name: fk_alunos_composicaoturmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_alunos_composicaoturmas ON composicao_turmas USING btree (ctu_calu);


--
-- TOC entry 1889 (class 1259 OID 26390)
-- Dependencies: 1552
-- Name: fk_alunos_notas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_alunos_notas ON notas USING btree (not_calu);


--
-- TOC entry 1890 (class 1259 OID 26389)
-- Dependencies: 1552
-- Name: fk_avaliacoes_notas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_avaliacoes_notas ON notas USING btree (not_cava);


--
-- TOC entry 1901 (class 1259 OID 26586)
-- Dependencies: 1555
-- Name: fk_avaliacoes_responsaveis; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_avaliacoes_responsaveis ON responsaveis USING btree (res_cava);


--
-- TOC entry 1887 (class 1259 OID 26280)
-- Dependencies: 1551
-- Name: fk_codigos; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_codigos ON codigo_item USING btree (cit_ccod);


--
-- TOC entry 1869 (class 1259 OID 26133)
-- Dependencies: 1543
-- Name: fk_disciplinas_turmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_disciplinas_turmas ON turmas USING btree (tur_cdis);


--
-- TOC entry 1902 (class 1259 OID 26587)
-- Dependencies: 1555
-- Name: fk_monitores_responsaveis; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_monitores_responsaveis ON responsaveis USING btree (res_cmon);


--
-- TOC entry 1861 (class 1259 OID 26101)
-- Dependencies: 1540
-- Name: fk_pessoa_monitores; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_pessoa_monitores ON monitores USING btree (mon_cmon);


--
-- TOC entry 1859 (class 1259 OID 26089)
-- Dependencies: 1539
-- Name: fk_pessoas_acessos; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_pessoas_acessos ON acessos USING btree (ace_cpes);


--
-- TOC entry 1867 (class 1259 OID 26113)
-- Dependencies: 1541
-- Name: fk_pessoas_alunos; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_pessoas_alunos ON alunos USING btree (alu_calu);


--
-- TOC entry 1853 (class 1259 OID 26074)
-- Dependencies: 1537
-- Name: fk_pessoas_professores; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_pessoas_professores ON professores USING btree (pro_cpro);


--
-- TOC entry 1870 (class 1259 OID 26134)
-- Dependencies: 1543
-- Name: fk_professores_turmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_professores_turmas ON turmas USING btree (tur_cpro);


--
-- TOC entry 1907 (class 1259 OID 26603)
-- Dependencies: 1557
-- Name: fk_responsaveis_log_responsaveis; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_responsaveis_log_responsaveis ON log_responsaveis USING btree (lre_cres);


--
-- TOC entry 1881 (class 1259 OID 26212)
-- Dependencies: 1547
-- Name: fk_turmas_avaliacoes; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_turmas_avaliacoes ON avaliacoes USING btree (ava_ctur);


--
-- TOC entry 1898 (class 1259 OID 26427)
-- Dependencies: 1553
-- Name: fk_turmas_composicaoturmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_turmas_composicaoturmas ON composicao_turmas USING btree (ctu_ctur);


--
-- TOC entry 1875 (class 1259 OID 26197)
-- Dependencies: 1545
-- Name: fk_turmas_obs; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX fk_turmas_obs ON observacoes USING btree (obs_ctur);


--
-- TOC entry 1899 (class 1259 OID 26430)
-- Dependencies: 1553
-- Name: ifk_alunosxcomposicaoturmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_alunosxcomposicaoturmas ON composicao_turmas USING btree (ctu_calu);


--
-- TOC entry 1891 (class 1259 OID 26392)
-- Dependencies: 1552
-- Name: ifk_alunosxnotas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_alunosxnotas ON notas USING btree (not_calu);


--
-- TOC entry 1892 (class 1259 OID 26391)
-- Dependencies: 1552
-- Name: ifk_avaliacoesxnotas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_avaliacoesxnotas ON notas USING btree (not_cava);


--
-- TOC entry 1903 (class 1259 OID 26588)
-- Dependencies: 1555
-- Name: ifk_avaliacoesxresponsaveis; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_avaliacoesxresponsaveis ON responsaveis USING btree (res_cava);


--
-- TOC entry 1888 (class 1259 OID 26281)
-- Dependencies: 1551
-- Name: ifk_codigosxcodigoitem; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_codigosxcodigoitem ON codigo_item USING btree (cit_ccod);


--
-- TOC entry 1871 (class 1259 OID 26135)
-- Dependencies: 1543
-- Name: ifk_disciplinasxturmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_disciplinasxturmas ON turmas USING btree (tur_cdis);


--
-- TOC entry 1904 (class 1259 OID 26589)
-- Dependencies: 1555
-- Name: ifk_monitoresxresponsaveis; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_monitoresxresponsaveis ON responsaveis USING btree (res_cmon);


--
-- TOC entry 1868 (class 1259 OID 26114)
-- Dependencies: 1541
-- Name: ifk_pessoasxalunos; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_pessoasxalunos ON alunos USING btree (alu_calu);


--
-- TOC entry 1854 (class 1259 OID 26075)
-- Dependencies: 1537
-- Name: ifk_pessoasxprofessores; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_pessoasxprofessores ON professores USING btree (pro_cpro);


--
-- TOC entry 1860 (class 1259 OID 26090)
-- Dependencies: 1539
-- Name: ifk_pessoaxacessos; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_pessoaxacessos ON acessos USING btree (ace_cpes);


--
-- TOC entry 1862 (class 1259 OID 26102)
-- Dependencies: 1540
-- Name: ifk_pessoaxmonitor; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_pessoaxmonitor ON monitores USING btree (mon_cmon);


--
-- TOC entry 1872 (class 1259 OID 26136)
-- Dependencies: 1543
-- Name: ifk_professoresxturmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_professoresxturmas ON turmas USING btree (tur_cpro);


--
-- TOC entry 1908 (class 1259 OID 26604)
-- Dependencies: 1557
-- Name: ifk_responsaveisxlogresponsave; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_responsaveisxlogresponsave ON log_responsaveis USING btree (lre_cres);


--
-- TOC entry 1900 (class 1259 OID 26429)
-- Dependencies: 1553
-- Name: ifk_turmasxcomposicaoturmas; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_turmasxcomposicaoturmas ON composicao_turmas USING btree (ctu_ctur);


--
-- TOC entry 1876 (class 1259 OID 26198)
-- Dependencies: 1545
-- Name: ifk_turmasxobservacoes; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_turmasxobservacoes ON observacoes USING btree (obs_ctur);


--
-- TOC entry 1882 (class 1259 OID 26213)
-- Dependencies: 1547
-- Name: ifk_turmaxavaliacoes; Type: INDEX; Schema: public; Owner: emural; Tablespace: 
--

CREATE INDEX ifk_turmaxavaliacoes ON avaliacoes USING btree (ava_ctur);


--
-- TOC entry 1914 (class 2606 OID 26084)
-- Dependencies: 1536 1539 1851
-- Name: acessos_ace_cpes_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY acessos
    ADD CONSTRAINT acessos_ace_cpes_fkey FOREIGN KEY (ace_cpes) REFERENCES pessoas(pes_cpes);


--
-- TOC entry 1916 (class 2606 OID 26108)
-- Dependencies: 1541 1851 1536
-- Name: alunos_alu_calu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY alunos
    ADD CONSTRAINT alunos_alu_calu_fkey FOREIGN KEY (alu_calu) REFERENCES pessoas(pes_cpes);


--
-- TOC entry 1920 (class 2606 OID 26207)
-- Dependencies: 1873 1547 1543
-- Name: avaliacoes_ava_ctur_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY avaliacoes
    ADD CONSTRAINT avaliacoes_ava_ctur_fkey FOREIGN KEY (ava_ctur) REFERENCES turmas(tur_ctur);


--
-- TOC entry 1921 (class 2606 OID 26275)
-- Dependencies: 1883 1549 1551
-- Name: codigo_item_cit_ccod_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY codigo_item
    ADD CONSTRAINT codigo_item_cit_ccod_fkey FOREIGN KEY (cit_ccod) REFERENCES codigos(cod_ccod);


--
-- TOC entry 1925 (class 2606 OID 26422)
-- Dependencies: 1541 1553 1865
-- Name: composicao_turmas_ctu_calu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY composicao_turmas
    ADD CONSTRAINT composicao_turmas_ctu_calu_fkey FOREIGN KEY (ctu_calu) REFERENCES alunos(alu_calu);


--
-- TOC entry 1924 (class 2606 OID 26417)
-- Dependencies: 1543 1873 1553
-- Name: composicao_turmas_ctu_ctur_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY composicao_turmas
    ADD CONSTRAINT composicao_turmas_ctu_ctur_fkey FOREIGN KEY (ctu_ctur) REFERENCES turmas(tur_ctur);


--
-- TOC entry 1928 (class 2606 OID 26598)
-- Dependencies: 1557 1905 1555
-- Name: log_responsaveis_lre_cres_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY log_responsaveis
    ADD CONSTRAINT log_responsaveis_lre_cres_fkey FOREIGN KEY (lre_cres) REFERENCES responsaveis(res_cres);


--
-- TOC entry 1915 (class 2606 OID 26096)
-- Dependencies: 1536 1540 1851
-- Name: monitores_mon_cmon_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY monitores
    ADD CONSTRAINT monitores_mon_cmon_fkey FOREIGN KEY (mon_cmon) REFERENCES pessoas(pes_cpes);


--
-- TOC entry 1923 (class 2606 OID 26384)
-- Dependencies: 1541 1865 1552
-- Name: notas_not_calu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY notas
    ADD CONSTRAINT notas_not_calu_fkey FOREIGN KEY (not_calu) REFERENCES alunos(alu_calu);


--
-- TOC entry 1922 (class 2606 OID 26379)
-- Dependencies: 1547 1879 1552
-- Name: notas_not_cava_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY notas
    ADD CONSTRAINT notas_not_cava_fkey FOREIGN KEY (not_cava) REFERENCES avaliacoes(ava_cava);


--
-- TOC entry 1919 (class 2606 OID 26192)
-- Dependencies: 1873 1543 1545
-- Name: observacoes_obs_ctur_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY observacoes
    ADD CONSTRAINT observacoes_obs_ctur_fkey FOREIGN KEY (obs_ctur) REFERENCES turmas(tur_ctur);


--
-- TOC entry 1913 (class 2606 OID 26069)
-- Dependencies: 1851 1536 1537
-- Name: professores_pro_cpro_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY professores
    ADD CONSTRAINT professores_pro_cpro_fkey FOREIGN KEY (pro_cpro) REFERENCES pessoas(pes_cpes);


--
-- TOC entry 1926 (class 2606 OID 26576)
-- Dependencies: 1879 1555 1547
-- Name: responsaveis_res_cava_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY responsaveis
    ADD CONSTRAINT responsaveis_res_cava_fkey FOREIGN KEY (res_cava) REFERENCES avaliacoes(ava_cava);


--
-- TOC entry 1927 (class 2606 OID 26581)
-- Dependencies: 1863 1555 1540
-- Name: responsaveis_res_cmon_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY responsaveis
    ADD CONSTRAINT responsaveis_res_cmon_fkey FOREIGN KEY (res_cmon) REFERENCES monitores(mon_cmon);


--
-- TOC entry 1917 (class 2606 OID 26123)
-- Dependencies: 1849 1534 1543
-- Name: turmas_tur_cdis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY turmas
    ADD CONSTRAINT turmas_tur_cdis_fkey FOREIGN KEY (tur_cdis) REFERENCES disciplinas(dis_cdis);


--
-- TOC entry 1918 (class 2606 OID 26128)
-- Dependencies: 1855 1543 1537
-- Name: turmas_tur_cpro_fkey; Type: FK CONSTRAINT; Schema: public; Owner: emural
--

ALTER TABLE ONLY turmas
    ADD CONSTRAINT turmas_tur_cpro_fkey FOREIGN KEY (tur_cpro) REFERENCES professores(pro_cpro);


--
-- TOC entry 1949 (class 0 OID 0)
-- Dependencies: 3
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2012-10-05 11:03:42

--
-- PostgreSQL database dump complete
--

