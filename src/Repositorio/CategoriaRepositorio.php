<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Categoria.php';

class CategoriaRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Categoria {

        $id = $atributos['id'];
        
        $categoria = new Categoria(

            isset($id) ? (int) $id : null,
            $atributos['nome']

        );

        return $categoria;

    }

    public function findById(int $id): ?Categoria {

        $sql = 'select tbCategoria.* from tbCategoria where id = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $categoria = $atributos ? $this->makeObject($atributos) : null;

        return $categoria;

    }

    public function cadastrar(Categoria $categoria) : void {
        
        $sql = 'insert into tbCategoria (nome_categoria)
        values (?)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoria->getNome());

        $stmt->execute();

    }

    public function atualizar(Categoria $categoria) : void {
        
        $sql = 'update tbCategoria where id_categoria = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoria->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbCategoria.* from tbCategoria';

        $query = $this->pdo->query(PDO::FETCH_ASSOC);
        $resultadoConsulta = $query->fetchAll();
        $arrayCategorias = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayCategorias;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbCategoria where id_categoria = ?';
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();

    }

}