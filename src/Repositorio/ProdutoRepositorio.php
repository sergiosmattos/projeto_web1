<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Produto.php';
require __DIR__.'/../modelo/Obra.php';

class ProdutoRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Produto {

        $id = $atributos['id'];
        
        $produto = new Produto(

            isset($id) ? (int) $id : null,
            $atributos['nome'],
            $atributos['descricao'],
            $atributos['preco'],
            $atributos['produto$produto']

        );

        return $produto;

    }

    public function findById(int $id): ?Produto {

        $sql = 'select tbProduto.* from tbProduto where id = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $produto = $atributos ? $this->makeObject($atributos) : null;

        return $produto;

    }

    public function cadastrar(Produto $produto) : void {
        
        $sql = 'insert into tbProduto (nome_produto, descricao_produto, preco_produto, id_obra)' .
        'values (?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getDescricao());
        $stmt->bindValue(3, $produto->getPreco());
        $stmt->bindValue(4, $produto->getObra()->getId());

        $stmt->execute();

    }

    public function atualizar(Produto $produto) : void {
        
        $sql = 'update tbProduto '.
        'set nome_produto = ?, '.
        'set descricao_produto = ? '.
        'set preco_produto, '.
        'set = id_obra = ? '.
        'where id_produto = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getDescricao());
        $stmt->bindValue(3, $produto->getPreco());
        $stmt->bindValue(4, $produto->getObra()->getId());
        $stmt->bindValue(5, $produto->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbProduto.* tbProduto limit 1';

        $query = $this->pdo->query(PDO::FETCH_ASSOC);
        $resultadoConsulta = $query->fetchAll();
        $arrayProdutos = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayProdutos;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbProduto where id_produto = ?';
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();

    }

}