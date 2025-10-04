<?php

class UsuarioRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $params): Usuario
    {
        return new Usuario(
            isset($params['id']) ? (int)$params['id'] : null,
            $params['tipo'] ?? 'User',
            $params['nome'] ?? '',
            new DateTime($params['data_nascimento'] ?? '1900-01-01'),
            $params['email'] ?? '',
            $params['senha'] ?? ''
        );
    }

    public function listarUsuario(): array
    {
        $sql = "SELECT id, tipoUsuario, nomeUsuario, dataNascimentoUsuario, emailUsuario, senhaUsuario FROM tbUsuario ORDER BY emailUsuario";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function findById(int $id): ?Usuario
    {
        $sql = "SELECT id,tipoUsuario,nomeUsuario,dataNascimentoUsuario,emailUsuario,senhaUsuario FROM tbUsuario WHERE id = :id";
        $stm->execute([$id]);
        $d = $stm->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function buscarPorEmailUsuario(string $email): ?Usuario
    {
        $st = $this->pdo->prepare("SELECT id,nomeUsuario,tipoUsuario,emailUsuario,senhaUsuario,dataNascimentoUsuario FROM tbUsuario WHERE emailUsuario=? LIMIT 1");
        $st->bindValue(1, $email);
        $st->execute([$email]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function salvarUsuario(Usuario $usuario)
    {
        $sql = "INSERT INTO tbUsuario (nomeUsuario, tipoUsuario, emailUsuario, senhaUsuario, dataNascimentoUsuario) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $usuario->getNome());
        $statement->bindValue(2, $usuario->getTipo());
        $statement->bindValue(3, $usuario->getEmail());
        $statement->bindValue(4, password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $statement->bindValue(5, $usuario->getDataNascimento()->format('Y-m-d'));
        $statement->execute();
    }

    public function autenticar(string $email, string $senha): bool
    {
        $usuario = $this->buscarPorEmailUsuario($email);
        return $usuario ? password_verify($senha, $usuario->getSenha()) : false;
    }

    public function atualizarUsuario(Usuario $usuario): void
    {
        $senha = $usuario->getSenha();

        if (!preg_match('/^\$2y\$/', $senha)) {
            $senha = password_hash($senha, PASSWORD_DEFAULT);
        }

        $sql = "UPDATE tbUsuario SET email_usuario = ?, senha_usuario = ?, nome_usuario = ?, tipo_usuario = ?, data_nascimento_usuario = ? WHERE id = ?";
        $st = $this->pdo->prepare($sql);
        $st->execute
        (   
            [
                $usuario->getEmail(),
                $senha,
                $usuario->getNome(),
                $usuario->getTipo(),
                $usuario->getDataNascimento()->format('Y-m-d'),
                $usuario->getId()
            ]
        );
    }

    public function deletarUsuario(int $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM usuarios WHERE id=?");
        return $st->execute([$id]);
    }
}