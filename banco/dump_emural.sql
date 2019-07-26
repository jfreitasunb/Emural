

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;


CREATE FUNCTION to_ascii(bytea, name) RETURNS text
    LANGUAGE internal IMMUTABLE STRICT
    AS $$to_ascii_encname$$;


ALTER FUNCTION public.to_ascii(bytea, name) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;


CREATE TABLE acessos (
    ace_cace integer NOT NULL,
    ace_cpes integer NOT NULL,
    ace_ip character varying(40),
    ace_dhor timestamp without time zone
);


ALTER TABLE public.acessos OWNER TO emural;


CREATE SEQUENCE acessos_ace_cace_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acessos_ace_cace_seq OWNER TO emural;


ALTER SEQUENCE acessos_ace_cace_seq OWNED BY acessos.ace_cace;



SELECT pg_catalog.setval('acessos_ace_cace_seq', 1, false);



CREATE TABLE alunos (
    alu_calu integer NOT NULL,
    alu_matr character varying(40),
    alu_emai character varying(80),
    alu_rema boolean,
    alu_ocur character varying(20)
);


ALTER TABLE public.alunos OWNER TO emural;


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


CREATE SEQUENCE avaliacoes_ava_cava_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.avaliacoes_ava_cava_seq OWNER TO emural;


ALTER SEQUENCE avaliacoes_ava_cava_seq OWNED BY avaliacoes.ava_cava;



SELECT pg_catalog.setval('avaliacoes_ava_cava_seq', 1, true);



CREATE TABLE codigo_item (
    cit_ccit integer NOT NULL,
    cit_ccod integer NOT NULL,
    cit_dres character varying(10),
    cit_desc character varying(100),
    cit_dre2 character varying(20)
);


ALTER TABLE public.codigo_item OWNER TO emural;


CREATE SEQUENCE codigo_item_cit_ccit_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.codigo_item_cit_ccit_seq OWNER TO emural;


ALTER SEQUENCE codigo_item_cit_ccit_seq OWNED BY codigo_item.cit_ccit;



SELECT pg_catalog.setval('codigo_item_cit_ccit_seq', 1, true);



CREATE TABLE codigos (
    cod_ccod integer NOT NULL,
    cod_desc character varying(100),
    cod_visi boolean
);


ALTER TABLE public.codigos OWNER TO emural;


CREATE SEQUENCE codigos_cod_ccod_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.codigos_cod_ccod_seq OWNER TO emural;


ALTER SEQUENCE codigos_cod_ccod_seq OWNED BY codigos.cod_ccod;



SELECT pg_catalog.setval('codigos_cod_ccod_seq', 1, true);



CREATE TABLE composicao_turmas (
    ctu_calu integer NOT NULL,
    ctu_ctur integer NOT NULL,
    ctu_mens character varying(10),
    ctu_medi real,
    ctu_falt integer,
    ctu_stat boolean DEFAULT true
);


ALTER TABLE public.composicao_turmas OWNER TO emural;


COMMENT ON COLUMN composicao_turmas.ctu_mens IS 'Mensao';



COMMENT ON COLUMN composicao_turmas.ctu_medi IS 'Media';



COMMENT ON COLUMN composicao_turmas.ctu_falt IS 'Faltas';



CREATE TABLE disciplinas (
    dis_cdis integer NOT NULL,
    dis_desc character varying(40),
    dis_dep character varying(10),
    dis_naul integer,
    dis_ccpd character varying(40),
    dis_cred integer
);


ALTER TABLE public.disciplinas OWNER TO emural;


CREATE SEQUENCE disciplinas_dis_cdis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.disciplinas_dis_cdis_seq OWNER TO emural;


ALTER SEQUENCE disciplinas_dis_cdis_seq OWNED BY disciplinas.dis_cdis;



SELECT pg_catalog.setval('disciplinas_dis_cdis_seq', 1, true);



CREATE TABLE log_responsaveis (
    lre_clre integer NOT NULL,
    lre_cres integer NOT NULL,
    lre_desc character varying(100),
    lre_dhor timestamp without time zone
);


ALTER TABLE public.log_responsaveis OWNER TO emural;


CREATE SEQUENCE log_responsaveis_lre_clre_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_responsaveis_lre_clre_seq OWNER TO emural;


ALTER SEQUENCE log_responsaveis_lre_clre_seq OWNED BY log_responsaveis.lre_clre;



SELECT pg_catalog.setval('log_responsaveis_lre_clre_seq', 1, false);



CREATE TABLE monitores (
    mon_cmon integer NOT NULL,
    mon_stat boolean,
    mon_cuse character varying(100)
);


ALTER TABLE public.monitores OWNER TO emural;


CREATE TABLE notas (
    not_calu integer NOT NULL,
    not_cava integer NOT NULL,
    not_valo real,
    not_obs character varying(200)
);


ALTER TABLE public.notas OWNER TO emural;


COMMENT ON COLUMN notas.not_valo IS 'Valor da nota';



COMMENT ON COLUMN notas.not_obs IS 'Observacao';



CREATE TABLE observacoes (
    obs_cobs integer NOT NULL,
    obs_ctur integer NOT NULL,
    obs_desc text,
    obs_data date,
    obs_vali boolean,
    obs_titu character varying(100)
);


ALTER TABLE public.observacoes OWNER TO emural;


CREATE SEQUENCE observacoes_obs_cobs_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.observacoes_obs_cobs_seq OWNER TO emural;


ALTER SEQUENCE observacoes_obs_cobs_seq OWNED BY observacoes.obs_cobs;



SELECT pg_catalog.setval('observacoes_obs_cobs_seq', 1, true);



CREATE TABLE pessoas (
    pes_cpes integer NOT NULL,
    pes_usua character varying(50),
    pes_senh character varying(100),
    pes_nome character varying(150),
    pes_tipo character varying(10)
);


ALTER TABLE public.pessoas OWNER TO emural;


CREATE SEQUENCE pessoa_pes_cpes_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pessoa_pes_cpes_seq OWNER TO emural;


ALTER SEQUENCE pessoa_pes_cpes_seq OWNED BY pessoas.pes_cpes;



SELECT pg_catalog.setval('pessoa_pes_cpes_seq', 1, true);



CREATE TABLE professores (
    pro_cpro integer NOT NULL,
    pro_cuse character varying(100) NOT NULL
);


ALTER TABLE public.professores OWNER TO emural;


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


CREATE SEQUENCE responsaveis_res_cres_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.responsaveis_res_cres_seq OWNER TO emural;


ALTER SEQUENCE responsaveis_res_cres_seq OWNED BY responsaveis.res_cres;



SELECT pg_catalog.setval('responsaveis_res_cres_seq', 1, true);



CREATE TABLE semestres (
    sem_csem integer NOT NULL,
    sem_ano integer,
    sem_seme integer,
    sem_inic date,
    sem_fim date
);


ALTER TABLE public.semestres OWNER TO emural;


CREATE SEQUENCE semestres_sem_csem_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.semestres_sem_csem_seq OWNER TO emural;


ALTER SEQUENCE semestres_sem_csem_seq OWNED BY semestres.sem_csem;



SELECT pg_catalog.setval('semestres_sem_csem_seq', 1, true);



CREATE TABLE turmas (
    tur_ctur integer NOT NULL,
    tur_cpro integer NOT NULL,
    tur_cdis integer NOT NULL,
    tur_peri character varying(10),
    tur_desc character varying(40),
    tur_ano integer,
    tur_seme integer,
    tur_cnot character varying(2000),
    tur_sala character varying(60)
);


ALTER TABLE public.turmas OWNER TO emural;


CREATE SEQUENCE turmas_tur_ctur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.turmas_tur_ctur_seq OWNER TO emural;


ALTER SEQUENCE turmas_tur_ctur_seq OWNED BY turmas.tur_ctur;



SELECT pg_catalog.setval('turmas_tur_ctur_seq', 1, true);



ALTER TABLE acessos ALTER COLUMN ace_cace SET DEFAULT nextval('acessos_ace_cace_seq'::regclass);



ALTER TABLE avaliacoes ALTER COLUMN ava_cava SET DEFAULT nextval('avaliacoes_ava_cava_seq'::regclass);



ALTER TABLE codigo_item ALTER COLUMN cit_ccit SET DEFAULT nextval('codigo_item_cit_ccit_seq'::regclass);



ALTER TABLE codigos ALTER COLUMN cod_ccod SET DEFAULT nextval('codigos_cod_ccod_seq'::regclass);



ALTER TABLE disciplinas ALTER COLUMN dis_cdis SET DEFAULT nextval('disciplinas_dis_cdis_seq'::regclass);



ALTER TABLE log_responsaveis ALTER COLUMN lre_clre SET DEFAULT nextval('log_responsaveis_lre_clre_seq'::regclass);



ALTER TABLE observacoes ALTER COLUMN obs_cobs SET DEFAULT nextval('observacoes_obs_cobs_seq'::regclass);



ALTER TABLE pessoas ALTER COLUMN pes_cpes SET DEFAULT nextval('pessoa_pes_cpes_seq'::regclass);



ALTER TABLE responsaveis ALTER COLUMN res_cres SET DEFAULT nextval('responsaveis_res_cres_seq'::regclass);



ALTER TABLE semestres ALTER COLUMN sem_csem SET DEFAULT nextval('semestres_sem_csem_seq'::regclass);



ALTER TABLE turmas ALTER COLUMN tur_ctur SET DEFAULT nextval('turmas_tur_ctur_seq'::regclass);



ALTER TABLE ONLY acessos
    ADD CONSTRAINT acessos_pkey PRIMARY KEY (ace_cace);



ALTER TABLE ONLY alunos
    ADD CONSTRAINT alunos_pkey PRIMARY KEY (alu_calu);



ALTER TABLE ONLY avaliacoes
    ADD CONSTRAINT avaliacoes_pkey PRIMARY KEY (ava_cava);



ALTER TABLE ONLY codigo_item
    ADD CONSTRAINT codigo_item_pkey PRIMARY KEY (cit_ccit);



ALTER TABLE ONLY codigos
    ADD CONSTRAINT codigos_pkey PRIMARY KEY (cod_ccod);



ALTER TABLE ONLY composicao_turmas
    ADD CONSTRAINT composicao_turmas_pkey PRIMARY KEY (ctu_ctur, ctu_calu);



ALTER TABLE ONLY disciplinas
    ADD CONSTRAINT disciplinas_pkey PRIMARY KEY (dis_cdis);



ALTER TABLE ONLY log_responsaveis
    ADD CONSTRAINT log_responsaveis_pkey PRIMARY KEY (lre_clre);



ALTER TABLE ONLY monitores
    ADD CONSTRAINT monitores_pkey PRIMARY KEY (mon_cmon);



ALTER TABLE ONLY notas
    ADD CONSTRAINT notas_pkey PRIMARY KEY (not_calu, not_cava);



ALTER TABLE ONLY observacoes
    ADD CONSTRAINT observacoes_pkey PRIMARY KEY (obs_cobs);



ALTER TABLE ONLY pessoas
    ADD CONSTRAINT pessoa_pkey PRIMARY KEY (pes_cpes);



ALTER TABLE ONLY professores
    ADD CONSTRAINT professores_pkey PRIMARY KEY (pro_cpro);



ALTER TABLE ONLY responsaveis
    ADD CONSTRAINT responsaveis_pkey PRIMARY KEY (res_cres);



ALTER TABLE ONLY semestres
    ADD CONSTRAINT semestres_pkey PRIMARY KEY (sem_csem);



ALTER TABLE ONLY turmas
    ADD CONSTRAINT turmas_pkey PRIMARY KEY (tur_ctur);



CREATE INDEX fk_alunos_composicaoturmas ON composicao_turmas USING btree (ctu_calu);



CREATE INDEX fk_alunos_notas ON notas USING btree (not_calu);



CREATE INDEX fk_avaliacoes_notas ON notas USING btree (not_cava);



CREATE INDEX fk_avaliacoes_responsaveis ON responsaveis USING btree (res_cava);



CREATE INDEX fk_codigos ON codigo_item USING btree (cit_ccod);



CREATE INDEX fk_disciplinas_turmas ON turmas USING btree (tur_cdis);



CREATE INDEX fk_monitores_responsaveis ON responsaveis USING btree (res_cmon);



CREATE INDEX fk_pessoa_monitores ON monitores USING btree (mon_cmon);



CREATE INDEX fk_pessoas_acessos ON acessos USING btree (ace_cpes);



CREATE INDEX fk_pessoas_alunos ON alunos USING btree (alu_calu);



CREATE INDEX fk_pessoas_professores ON professores USING btree (pro_cpro);



CREATE INDEX fk_professores_turmas ON turmas USING btree (tur_cpro);



CREATE INDEX fk_responsaveis_log_responsaveis ON log_responsaveis USING btree (lre_cres);



CREATE INDEX fk_turmas_avaliacoes ON avaliacoes USING btree (ava_ctur);



CREATE INDEX fk_turmas_composicaoturmas ON composicao_turmas USING btree (ctu_ctur);



CREATE INDEX fk_turmas_obs ON observacoes USING btree (obs_ctur);



CREATE INDEX ifk_alunosxcomposicaoturmas ON composicao_turmas USING btree (ctu_calu);



CREATE INDEX ifk_alunosxnotas ON notas USING btree (not_calu);



CREATE INDEX ifk_avaliacoesxnotas ON notas USING btree (not_cava);



CREATE INDEX ifk_avaliacoesxresponsaveis ON responsaveis USING btree (res_cava);



CREATE INDEX ifk_codigosxcodigoitem ON codigo_item USING btree (cit_ccod);



CREATE INDEX ifk_disciplinasxturmas ON turmas USING btree (tur_cdis);



CREATE INDEX ifk_monitoresxresponsaveis ON responsaveis USING btree (res_cmon);



CREATE INDEX ifk_pessoasxalunos ON alunos USING btree (alu_calu);



CREATE INDEX ifk_pessoasxprofessores ON professores USING btree (pro_cpro);



CREATE INDEX ifk_pessoaxacessos ON acessos USING btree (ace_cpes);



CREATE INDEX ifk_pessoaxmonitor ON monitores USING btree (mon_cmon);



CREATE INDEX ifk_professoresxturmas ON turmas USING btree (tur_cpro);



CREATE INDEX ifk_responsaveisxlogresponsave ON log_responsaveis USING btree (lre_cres);



CREATE INDEX ifk_turmasxcomposicaoturmas ON composicao_turmas USING btree (ctu_ctur);



CREATE INDEX ifk_turmasxobservacoes ON observacoes USING btree (obs_ctur);



CREATE INDEX ifk_turmaxavaliacoes ON avaliacoes USING btree (ava_ctur);



ALTER TABLE ONLY acessos
    ADD CONSTRAINT acessos_ace_cpes_fkey FOREIGN KEY (ace_cpes) REFERENCES pessoas(pes_cpes);



ALTER TABLE ONLY alunos
    ADD CONSTRAINT alunos_alu_calu_fkey FOREIGN KEY (alu_calu) REFERENCES pessoas(pes_cpes);



ALTER TABLE ONLY avaliacoes
    ADD CONSTRAINT avaliacoes_ava_ctur_fkey FOREIGN KEY (ava_ctur) REFERENCES turmas(tur_ctur);



ALTER TABLE ONLY codigo_item
    ADD CONSTRAINT codigo_item_cit_ccod_fkey FOREIGN KEY (cit_ccod) REFERENCES codigos(cod_ccod);



ALTER TABLE ONLY composicao_turmas
    ADD CONSTRAINT composicao_turmas_ctu_calu_fkey FOREIGN KEY (ctu_calu) REFERENCES alunos(alu_calu);



ALTER TABLE ONLY composicao_turmas
    ADD CONSTRAINT composicao_turmas_ctu_ctur_fkey FOREIGN KEY (ctu_ctur) REFERENCES turmas(tur_ctur);



ALTER TABLE ONLY log_responsaveis
    ADD CONSTRAINT log_responsaveis_lre_cres_fkey FOREIGN KEY (lre_cres) REFERENCES responsaveis(res_cres);



ALTER TABLE ONLY monitores
    ADD CONSTRAINT monitores_mon_cmon_fkey FOREIGN KEY (mon_cmon) REFERENCES pessoas(pes_cpes);



ALTER TABLE ONLY notas
    ADD CONSTRAINT notas_not_calu_fkey FOREIGN KEY (not_calu) REFERENCES alunos(alu_calu);



ALTER TABLE ONLY notas
    ADD CONSTRAINT notas_not_cava_fkey FOREIGN KEY (not_cava) REFERENCES avaliacoes(ava_cava);



ALTER TABLE ONLY observacoes
    ADD CONSTRAINT observacoes_obs_ctur_fkey FOREIGN KEY (obs_ctur) REFERENCES turmas(tur_ctur);



ALTER TABLE ONLY professores
    ADD CONSTRAINT professores_pro_cpro_fkey FOREIGN KEY (pro_cpro) REFERENCES pessoas(pes_cpes);



ALTER TABLE ONLY responsaveis
    ADD CONSTRAINT responsaveis_res_cava_fkey FOREIGN KEY (res_cava) REFERENCES avaliacoes(ava_cava);



ALTER TABLE ONLY responsaveis
    ADD CONSTRAINT responsaveis_res_cmon_fkey FOREIGN KEY (res_cmon) REFERENCES monitores(mon_cmon);



ALTER TABLE ONLY turmas
    ADD CONSTRAINT turmas_tur_cdis_fkey FOREIGN KEY (tur_cdis) REFERENCES disciplinas(dis_cdis);



ALTER TABLE ONLY turmas
    ADD CONSTRAINT turmas_tur_cpro_fkey FOREIGN KEY (tur_cpro) REFERENCES professores(pro_cpro);



REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;

INSERT INTO SEMESTRES (sem_ano,sem_seme) values (2012,2);


