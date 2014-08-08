create database freteml;

	use freteml;

	create table usuarios(
	id_usu int UNSIGNED AUTO_INCREMENT  PRIMARY KEY NOT NULL,
	ativo char(1) not null,
	nome_usu varchar(100) not null,
	email_usu varchar(150) not null,
	senha_usu varchar(20) not null,
	dt_criacao_usu datetime not null
	)engine=MYiSAM;

	create table opcoes(
		id_opc int UNSIGNED AUTO_INCREMENT  PRIMARY KEY NOT NULL,
		cep_origem char(9) not null,
		id_usu int not null,
		foreign key(id_usu) references usuarios(id_usu)
	)engine=MYiSAM;
	
	create table produtos(
		id_prod int UNSIGNED AUTO_INCREMENT  PRIMARY KEY NOT NULL,
		cod int null,
		desc text null,
		comprimento double(5,3) null,
		largura double(5,3) null,
		peso double(5,3) null,
		altura double(5,3) null,
		diametro double(5,3) null,
		id_usu int not null,
		foreign key(id_usu) references usuarios(id_usu)
	)engine=MYiSAM;