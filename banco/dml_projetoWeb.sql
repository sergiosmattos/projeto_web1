use dbprojetoweb1;

select tbUsuario.*
from tbUsuario;

insert into tbUsuario(nome_usuario, data_nascimento_usuario, email_usuario, senha_usuario, tipo_usuario)
values ('Caronte', '0001-01-01', 'caronte@gmail.com','123456','Admin');