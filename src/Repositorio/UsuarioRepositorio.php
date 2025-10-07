<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Usuario.php';
class UsuarioRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Usuario {

        $id = $atributos['id_usuario'] ?? null;

        $dataNascimento = $atributos['data_nascimento_usuario'] ?? null;
        $timezone = new DateTimeZone('UTC');
        
        $usuario = new Usuario(

            isset($id) ? (int) $id : null,
<<<<<<< HEAD
            $atributos['tipo_usuario'] ?? 'User',
            $atributos['nome_usuario'] ?? '',
            isset($dataNascimento) ? new DateTime($dataNascimento, $timezone) : new DateTime('0000-00-00', $timezone),
            $atributos['email_usuario'] ?? '',
            $atributos['senha_usuario'] ?? ''
=======
            $atributos['tipo'] ?? 'User',
            $atributos['nome'],
            $atributos['dataNascimento'] ,
            $atributos['email'],
            $atributos['senha']
>>>>>>> ba71c52a69cd8c99c3182cae63dad75203d14a8a

        );

        return $usuario;

    }

    public function findById(int $id): ?Usuario {

        $sql = 'select tbUsuario.* from tbUsuairo where id_usuario = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario = $atributos ? $this->makeObject($atributos) : null;
        
        return $usuario;

    }

    public function findByEmail(string $email) : ?Usuario {
        
        $sql = 'SELECT * FROM tbUsuario WHERE email_usuario = ? LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario = $atributos ? $this->makeObject($atributos) : null;

        return $usuario;

    }

    public function cadastrar(Usuario $usuario) : void {
        
        $sql = 'insert into tbUsuario (tipo_usuario, nome_usuario, email_usuario, senha_usuario, data_nascimento_usuario) '.
        'values (?, ?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);
        $this->setStmtValues($stmt, $usuario);


        $stmt->execute();

    }

    public function atualizar(Usuario $usuario) : void {
        
        $sql = 'update tbUsuario '.
        'set tipo_usuario = ?, '.
        'set nome_usuario = ?, '.
        'set email_usuario = ?, '.
        'set senha_usuario = ?, '.
        'set data_nascimento_usuario = ?) '.
        'where id_usuario = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(6, $usuario->getId());
        $this->setStmtValues($stmt, $usuario);

        $stmt->execute();

    }

    public function listar() : array {
        
        $sql = 'select tbUsuario.* from tbUsuario';

        $query = $this->pdo->query(PDO::FETCH_ASSOC);
        $resultadoConsulta = $query->fetchAll();
        $arrayUsuarios = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayUsuarios;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbUsuario where id_usuario = ?';
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();

    }

    private function setStmtValues(PDOStatement $stmt, Usuario $usuario) {

        $stmt->bindValue(1, $usuario->getTipo());
        $stmt->bindValue(2, $usuario->getNome());
        $stmt->bindValue(3, $usuario->getEmail());
        $stmt->bindValue(4, $usuario->getSenha());
        $stmt->bindValue(5, $usuario->getDataNascimento()->format('Y-m-d'));

    }

    public function autenticarByEmailSenha(string $email, string $senha) : bool {
        
        $usuarioEncontrado = $this->findByEmail($email);
        $senhaUsuario = $usuarioEncontrado->getSenha();

        // $isPasswordOk = password_verify($senha, $senhaUsuario);
        $isPasswordOk = $senha === $senhaUsuario;

        var_dump($isPasswordOk);

        return $isPasswordOk;

    }

}