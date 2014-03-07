create database freteml;

	use freteml;

	create table usuarios(
	id_usu int UNSIGNED AUTO_INCREMENT  PRIMARY KEY NOT NULL,
	ativo char(1) not null,
	nome_usu varchar(100) not null,
	email_usu varchar(16) not null,
	senha_usu varchar(20) not null,
	dt_criacao_usu datetime not null
	)engine=MYiSAM;