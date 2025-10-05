<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Obra.php';

class ObraRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Obra {

        $id = $atributos['id'];
        
        $obra = new Obra(

            isset($id) ? (int) $id : null,
            $atributos['nome'],
            $atributos['descricao']

        );

        return $obra;

    }

    public function findById(int $id): ?Obra {

        $sql = 'select tbObra.* from tbObra where id = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);

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
        
        $sql = 'update tbObra
        set nome_obra = ?,
        set descricao_obra = ?
        where id_obra = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $obra->getNome());
        $stmt->bindValue(2, $obra->getDescricao());
        $stmt->bindValue(3, $obra->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbObra.* tbObra limit 1';

        $query = $this->pdo->query(PDO::FETCH_ASSOC);
        $resultadoConsulta = $query->fetchAll();
        $arrayObras = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayObras;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbObra where id_obra = ?';
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();

    }

}