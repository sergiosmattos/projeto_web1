<?php

class UsuarioRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $d): Usuario
    {
        return new Usuario(
            isset($d['id_usuario']) ? (int)$d['id_usuario'] : null,
            $d['tipo_usuario'] ?? 'User',
            $d['nome_usuario'] ?? '',
            new DateTime($d['data_nascimento_usuario'] ?? '1900-01-01'),
            $d['email_usuario'] ?? '',
            $d['senha_usuario'] ?? ''
        );
    }

    public function listarUsuario(): array
    {
        $sql = "SELECT id_usuario, tipo_usuario, nome_usuario, data_nascimento_usuario, email_usuario, senha_usuario FROM tbUsuario ORDER BY email_usuario";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function findById(int $id): ?Usuario
    {
        $sql = "SELECT id_usuario, tipo_usuario, nome_usuario, data_nascimento_usuario, email_usuario, senha_usuario FROM tbUsuario WHERE id_usuario = :id";
        $st = $this->pdo->prepare($sql);
        $st->execute(['id' => $id]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function buscarPorEmailUsuario(string $email): ?Usuario
    {
        $st = $this->pdo->prepare("SELECT id_usuario, nome_usuario, tipo_usuario, email_usuario, senha_usuario, data_nascimento_usuario FROM tbUsuario WHERE email_usuario=? LIMIT 1");
        $st->bindValue(1, $email);
        $st->execute();
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function salvarUsuario(Usuario $usuario)
    {
        $sql = "INSERT INTO tbUsuario (nome_usuario, tipo_usuario, email_usuario, senha_usuario, data_nascimento_usuario) VALUES (?, ?, ?, ?, ?)";
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

        $sql = "UPDATE tbUsuario SET email_usuario = ?, senha_usuario = ?, nome_usuario = ?, tipo_usuario = ?, data_nascimento_usuario = ? WHERE id_usuario = ?";
        $st = $this->pdo->prepare($sql);
        $st->execute([
            $usuario->getEmail(),
            $senha,
            $usuario->getNome(),
            $usuario->getTipo(),
            $usuario->getDataNascimento()->format('Y-m-d'),
            $usuario->getId()
        ]);
    }

    public function deletarUsuario(int $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM tbUsuario WHERE id_usuario=?");
        return $st->execute([$id]);
    }
}