<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Produto.php';
require_once __DIR__.'/../modelo/Obra.php';
require_once __DIR__.'/ObraRepositorio.php';

class ProdutoRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

   public function makeObject(array $atributos) : Produto {

    $id = $atributos['id_produto'];
    
    $obraRepositorio = new ObraRepositorio($this->pdo);
    $obra = $obraRepositorio->findById($atributos['id_obra']);
    
    $produto = new Produto(
        isset($id) ? (int) $id : null,
        $atributos['nome_produto'],
        $atributos['descricao_produto'],
        (float) $atributos['preco_produto'],
        $obra
    );

    return $produto;
}

    

    public function findById(int $id): ?Produto {

    $sql = 'SELECT * FROM tbProduto WHERE id_produto = ? LIMIT 1';

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
    $produto = $atributos ? $this->makeObject($atributos) : null;

    return $produto;
    }

    public function cadastrar(Produto $produto) : void {
        
        $sql = 'insert into tbProduto (nome_produto, descricao_produto, preco_produto, id_obra)' .
        'values (?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);
        $this->setStmValues($stmt, $produto);

        $stmt->execute();

    }

    public function atualizar(Produto $produto) : void {
        
        $sql = 'update tbProduto set
        nome_produto = ?,
        descricao_produto = ?
        preco_produto = ?,
        id_obra = ?
        where id_produto = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(5, $produto->getId());
        $this->setStmValues($stmt, $produto);

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbProduto.* from tbProduto';

        $query = $this->pdo->query($sql);
        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayProdutos = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayProdutos;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbProduto where id_produto = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        return $stmt->execute();

    }

    private function setStmValues(PDOStatement $stmt, Produto $produto): void {

        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getDescricao());
        $stmt->bindValue(3, $produto->getPreco());
        $stmt->bindValue(4, $produto->getObra()->getId());

    }

}