<?php

class ObraRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    
    private function formarObjeto(array $d): Usuario
    {
        return new Usuario(
            isset($d['id']) ? (int)$d['id'] : null,
            $d['tipoUsuario'] ?? 'User',
            $d['nomeUsuario'] ?? '',
            new DateTime($d['dataNascimentoUsuario'] ?? '1900-01-01'),
            $d['emailUsuario'] ?? '',
            $d['senhaUsuario'] ?? ''
        );
    }

    public function listarObra(): array
    {
        $sql = "SELECT id_obra, nome_obra, descricao_obra FROM tbObra ORDER BY nome_obra";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function findById(int $id): ?Usuario
    {
        $sql = "SELECT id_obra, nome_obra, descricao_obra FROM tbObra WHERE id_usuario = :id";
        $st = $this->pdo->prepare($sql);
        $st->execute(['id' => $id]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function buscarPorNomeObra(string $email): ?Obra
    {
        $st = $this->pdo->prepare("SELECT id_obra,nome_obra,descricao_obra FROM tbObra WHERE nome_obra=? LIMIT 1");
        $st->bindValue(1, $nome);
        $st->execute();
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function salvarObra(Obra $obra)
    {
        $sql = "INSERT INTO tbUsuario (nome_obra, descricao_obra) VALUES (?, ?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $obra->getNome());
        $statement->bindValue(2, $obra->getDescricao());
        $statement->execute();
    }

    public function atualizarObra(Obra $obra): void
    {

        $sql = "UPDATE tbObra SET nome_obra = ?, descricao_obra = ? WHERE id_obra = ?";
        $st = $this->pdo->prepare($sql);
        $st->execute
        (   
            [
                $obra->getNome(),
                $obra->getDescricao(),
                $usuario->getId()
            ]
        );
    }

    public function deletarObra(int $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM tbObra WHERE id_obra=?");
        return $st->execute([$id]);
    }
}