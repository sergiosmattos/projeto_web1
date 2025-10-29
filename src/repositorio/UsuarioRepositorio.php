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
            $atributos['tipo_usuario'] ?? 'User',
            $atributos['nome_usuario'] ?? '',
            isset($dataNascimento) ? new DateTime($dataNascimento, $timezone) : new DateTime('0000-00-00', $timezone),
            $atributos['email_usuario'] ?? '',
            $atributos['senha_usuario'] ?? ''

        );

        return $usuario;

    }

    public function findById(int $id): ?Usuario {

        $sql = 'select tbUsuario.* from tbUsuario where id_usuario = ? limit 1';

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
        
        $sql = 'UPDATE tbUsuario SET 
                tipo_usuario = ?, 
                nome_usuario = ?, 
                email_usuario = ?, 
                senha_usuario = ?, 
                data_nascimento_usuario = ? 
            WHERE id_usuario = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $usuario->getTipo());
        $stmt->bindValue(2, $usuario->getNome());
        $stmt->bindValue(3, $usuario->getEmail());
        $stmt->bindValue(4, $usuario->getSenha());
        $stmt->bindValue(5, $usuario->getDataNascimento()->format('Y-m-d'));
        $stmt->bindValue(6, $usuario->getId());

        $stmt->execute();

    }

    public function listar() : array {
        
        $sql = 'select tbUsuario.* from tbUsuario';

        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
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
        
        // $usuarioEncontrado = $this->findByEmail($email);
        // $isPasswordOk = $usuarioEncontrado ? $usuarioEncontrado->getSenha() === $senha : false ;
        // //$isPasswordOk = $usuarioEncontrado ? password_verify($usuarioEncontrado->getSenha, $senhaUsuario) === $senha : false ;
        // return $isPasswordOk;

        $usuarioEncontrado = $this->findByEmail($email);
        
        if (!$usuarioEncontrado) {
            return false;
        }

        $senhaUsuario = $usuarioEncontrado->getSenha();

        //$isPasswordOk = password_verify($senha, $senhaUsuario);
        $isPasswordOk = $senhaUsuario === $senha;

        return $isPasswordOk;

    }

}