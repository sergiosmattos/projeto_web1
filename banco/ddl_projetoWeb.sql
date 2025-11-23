-- drop database dbgeekartifacts;

CREATE DATABASE dbgeekartifacts;
use dbgeekartifacts;

CREATE TABLE tbUsuario (

	id_usuario INT AUTO_INCREMENT,
    nome_usuario VARCHAR(50) NOT NULL,
    data_nascimento_usuario DATE NOT NULL,
    email_usuario VARCHAR(200) NOT NULL,
    senha_usuario VARCHAR(100) NOT NULL,
    tipo_usuario VARCHAR(15) NOT NULL DEFAULT 'User',
    imagem_usuario varchar(255) NOT NULL DEFAULT 'icon_user_branco.svg',
    saldo_usuario double not null default 0,
    
    CONSTRAINT pk_tbUsuario PRIMARY KEY (id_usuario),
    constraint un_EmailUsuario_tbUsuario unique (email_usuario),
    constraint ch_TipoUsuario_tbUsuario check (tipo_usuario in ('User', 'Admin'))
);

create table tbObra (

	id_obra int auto_increment,
    nome_obra varchar(80),
    descricao_obra varchar(255),
    imagem_obra varchar(255) not null DEFAULT 'semImagem.png',
    
    constraint pk_tbObra primary key (id_obra),
    constraint un_NomeObra_tbUsuario unique (nome_obra)

);

create table tbProduto (

	id_produto int auto_increment,
    nome_produto varchar(50) not null,
    descricao_produto varchar(255) not null,
    preco_produto decimal not null,
    quantidade_produto int not null,
    imagem_produto varchar(255) NOT NULL DEFAULT 'semImagem.png',
    id_obra int not null,
    
    constraint pk_tbProduto primary key (id_produto),
    constraint fk_tbProduto_tbObra foreign key (id_obra) references tbObra (id_obra)

);

create table tbCategoria (

	id_categoria int auto_increment,
    nome_categoria varchar(50) not null,
    imagem_categoria varchar(255) NOT NULL DEFAULT 'semImagem.png',
    
    constraint pk_tbCategoria primary key (id_categoria),
    constraint un_NomeCategoria_tbCategoria unique (nome_categoria)

);

create table tbObraCategoria (

	id_obra int not null,
	id_categoria int not null,

	constraint pk_tbObraCategoria primary key (id_obra, id_categoria),
    constraint fk_tbObraCategoria_tbObra foreign key (id_obra) references tbObra (id_obra),
    constraint fk_tbObraCategoria_tbCategoria foreign key (id_categoria) references tbCategoria (id_categoria)

);

create table tbCompra(

	id_compra int auto_increment,
    data_hora_compra datetime not null default current_timestamp,
    unidades_compra int not null,
    valor_total_compra decimal not null,
    id_usuario int not null,
    id_produto int not null,
    
    constraint pk_tbCompra primary key (id_compra),
    constraint fk_tbCompra_tbUsuario foreign key (id_usuario) references tbUsuario(id_usuario),
    constraint fk_tbCompra_tbProduto foreign key (id_produto) references tbProduto (id_produto)
    
);

create table tbLeilao (

	id_leilao int auto_increment,
    data_horario_inicio_leilao date not null,
    lance_inicial_leilao float not null,
    lance_atual_leilao float not null,
    id_produto int not null,
    
    constraint pk_tbLeilao primary key (id_leilao),
    constraint fk_tbLelao_tbProduto foreign key (id_produto) references tbProduto (id_produto)

);

create table tbUsuarioLeilao (

    id_usuario int not null,
	id_leilao int not null,
    valor_lance decimal not null,
    
    constraint pk_tbUsuarioLeilao primary key (id_usuario, id_leilao),
    constraint fk_tbUsuarioLeilao_tbUsuario foreign key (id_usuario) references tbUsuario(id_usuario),
    constraint fk_tbUsuarioLeilao_tbLeilao foreign key (id_leilao) references tbLeilao(id_leilao)

);