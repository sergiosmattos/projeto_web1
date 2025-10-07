<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../Modelo/Obra.php';

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
        
        $sql = 'select tbObra.* from tbObra';

        
        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        var_dump($resultadoConsulta);
        $arrayObras = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayObras;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbObra where id_obra = ?';
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();

    }

}