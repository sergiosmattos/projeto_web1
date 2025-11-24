<?php

require_once __DIR__.'/../conexaoBD.php';
require_once __DIR__.'/../modelo/Obra.php';

class ObraRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Obra {

        $id = $atributos['id_obra'];
        
        $obra = new Obra(

            isset($id) ? (int) $id : null,
            $atributos['nome_obra'],
            $atributos['descricao_obra']

        );

        return $obra;

    }

    public function findById(int $id): ?Obra {

        $sql = 'select tbObra.* from tbObra where id_obra = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $obra = $atributos ? $this->makeObject($atributos) : null;

        return $obra;

    }

    public function cadastrar(Obra $obra) : void {
        
        $sql = 'insert into tbObra (nome_obra, descricao_obra)
        values (?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $obra->getNome());
        $stmt->bindValue(2, $obra->getDescricao());

        $stmt->execute();

    }

    public function atualizar(Obra $obra) : void {
        
        $sql = 'update tbObra set
        nome_obra = ?, 
        descricao_obra = ?
        where id_obra = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $obra->getNome());
        $stmt->bindValue(2, $obra->getDescricao());
        $stmt->bindValue(3, $obra->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbObra.* from tbObra';
        
        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayObras = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayObras;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbObra where id_obra = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();

    }

    public function contarTotal(): int {
        $sql = "SELECT COUNT(*) as total FROM tbObra";
        $stmt = $this->pdo->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }

    public function listarPaginado(int $limite, int $offset, ?string $ordem = null, ?string $direcao = 'ASC'): array {
        
        $colunasPermitidas = ['nome_obra'];
        
        $sql = 'SELECT tbObra.* FROM tbObra';
        
        if ($ordem !== null && in_array(strtolower($ordem), array_map('strtolower', $colunasPermitidas))) {
            $direcao = strtoupper($direcao) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY {$ordem} {$direcao}";
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultadoConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayCategorias = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);
        
        return $arrayCategorias;
    }

}