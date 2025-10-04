-- drop database dbProjetoWeb1;

CREATE DATABASE dbProjetoWeb1;
use dbProjetoWeb1;

CREATE TABLE tbUsuario (

	id_usuario INT AUTO_INCREMENT,
    nome_usuario VARCHAR(50) NOT NULL,
    data_nascimento_usuario DATE NOT NULL,
    email_usuario VARCHAR(200) NOT NULL,
    senha_usuario VARCHAR(100) NOT NULL,
    tipo_usuario VARCHAR(15) NOT NULL DEFAULT 'User',
    
    CONSTRAINT pk_tbUsuario PRIMARY KEY (id_usuario)
);

create table tbObra (

	id_obra int auto_increment,
    nome_obra varchar(80),
    descricao_obra varchar(255),
    
    constraint pk_tbObra primary key (id_obra)

);

create table tbProduto (

	id_produto int auto_increment,
    nome_produto varchar(50) not null,
    descricao_produto varchar(255) not null,
    preco_produto decimal not null,
    id_obra int not null,
    
    constraint pk_tbProduto primary key (id_produto),
    constraint fk_tbProduto_tbObra foreign key (id_obra) references tbObra (id_obra)

);

create table tbCategoria (

	id_categoria int auto_increment,
    nome_categoria varchar(50) not null,
    
    constraint pk_tbCategoria primary key (id_categoria)

);

create table tbObraCategoria (

	id_obra int not null,
	id_categoria int not null,

	constraint pk_tbObraCategoria primary key (id_obra, id_categoria),
    constraint fk_tbObraCategoria_tbObra foreign key (id_obra) references tbObra (id_obra),
    constraint fk_tbObraCategoria_tbCategoria foreign key (id_categoria) references tbCategoria (id_categoria)

);

create table tbLeilao (

	id_leilao int auto_increment,
    data_inicio_leilao date not null,
    id_produto int not null,
    
    constraint pk_tbLeilao primary key (id_leilao),
    constraint fk_tbLelao_tbProduto foreign key (id_produto) references tbProduto (id_produto)

);