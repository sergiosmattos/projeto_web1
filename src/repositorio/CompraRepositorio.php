<?php

require_once __DIR__.'/../conexaoBD.php';
require_once __DIR__.'/../modelo/Compra.php';

class CompraRepositorio {

    private PDO $pdo;

    private UsuarioRepositorio $usuarioRepo;

    private ProdutoRepositorio $leilaoRepo;

    public function __construct($pdo, UsuarioRepositorio $usuarioRepo, ProdutoRepositorio $produtoRepo) {
        
        $this->pdo = $pdo;
        $this->usuarioRepo = $usuarioRepo;
        $this->leilaoRepo = $produtoRepo;

    }

    public function makeObject(array $atributos) : Compra {

        $id = $atributos['id_compra'] ?? null;
        $dataHoraCompra = $atributos['data_hora_compra'] ?? null;

        $timezone = new DateTimeZone("UTC");

        $compra = new Compra (

            isset($id) ? (int) $id : null,
            isset($dataHoraCompra) ? new DateTime($dataHoraCompra, $timezone) : null,
            $atributos['unidades_compra'],
            $atributos['valor_total_compra'],
            $this->usuarioRepo->findById($atributos['id_usuario']),
            $this->leilaoRepo->findById($atributos['id_produto'])

        );

        return $compra;

    }

    public function findById(int $id): ?Compra {

        $sql = 'select tbCompra.* from tbCompra where id_compra = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $categoria = $atributos ? $this->makeObject($atributos) : null;

        return $categoria;

    }

    public function cadastrar(Compra $compra) : void {
        
        $sql = 'insert into tbCompra (unidades_compra, valor_total_compra, id_usuario, id_produto)
        values (?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);
        $this->bindStmtValues($stmt, $compra);

        $stmt->execute();

    }

    public function atualizar(Compra $compra) : void {
        
        $sql = 'update tbCompra set
        unidades_compra = ?,
        valor_total_compra = ?,
        id_obra = ?,
        id_categoria = ?
        where id_compra = ?';

        $stmt = $this->pdo->prepare($sql);

        $this->bindStmtValues($stmt, $compra);
        $stmt->bindValue(5, $compra->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbCompra.* from tbCompra';
        
        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayObras = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayObras;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbCompra where id_compra = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $id);
        
        return $stmt->execute();

    }

    private function bindStmtValues(PDOStatement $stmt, Compra $compra) : void {
        
        $stmt->bindValue(1, $compra->getUnidades());
        $stmt->bindValue(2, $compra->getValorTotal());
        $stmt->bindValue(3, $compra->getUsuario()->getId());
        $stmt->bindValue(4, $compra->getProduto()->getId());

    }

}