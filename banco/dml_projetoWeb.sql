use dbprojetoweb1;

select tbUsuario.*
from tbUsuario;

select tbObra.*
from tbObra;

insert into tbUsuario(nome_usuario, data_nascimento_usuario, email_usuario, senha_usuario, tipo_usuario)
values ('Caronte', '0001-01-01', 'caronte@gmail.com','123456','Admin');

insert into tbObra(nome_obra, descricao_obra)
values ('Kaguya-Sama', 'Love is war!');

insert into tbObra(nome_obra, descricao_obra)
values ('Hunter X Hunter', 'Caçadores Vorazes!');

insert into tbObra(nome_obra, descricao_obra)
values ('Naruto', 'Ninjas e Chackra.');

insert into tbObra(nome_obra, descricao_obra)
values ('Steven Universe', 'Gemas que cantam');