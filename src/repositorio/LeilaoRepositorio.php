<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Leilao.php';
require __DIR__.'/../modelo/Produto.php';

class LeilaoRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Leilao {

        $id = $atributos['id'];
        
        $obra = new Leilao(

            isset($id) ? (int) $id : null,
            $atributos['dataHorarioInicio'],
            $atributos['lanceInicial'],
            $atributos['lanceAtual'],
            $atributos['produtoLeiloado'],

        );

        return $obra;

    }

    public function findById(int $id): ?Leilao {

        $sql = 'select tbLeilao.* from tbLeilao where id = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $leilao = $atributos ? $this->makeObject($atributos) : null;

        return $leilao;

    }

    public function cadastrar(Leilao $leilao) : void {
        
        $sql = 'insert into tbLeilao (data_horario_inicio_leilao, lance_inicial_leilao, lance_atual_leilao, id_produto)
        values (?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $leilao->getDataHorarioInicio());
        $stmt->bindValue(1, $leilao->getLanceInicial());
        $stmt->bindValue(3, $leilao->getLanceAtual());
        $stmt->bindValue(4, $leilao->getProdutoLeiloado()->getId());

        $stmt->execute();

    }

    public function atualizar(Leilao $leilao) : void {
        
        $sql = 'update tbLeilao set
        data_horario_inicio_leilao = ?, 
        lance_inicial_leilao = ?, 
        lance_atual_leilao = ?, 
        id_produto = ?
        where id_leilao = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $leilao->getDataHorarioInicio());
        $stmt->bindValue(1, $leilao->getLanceInicial());
        $stmt->bindValue(3, $leilao->getLanceAtual());
        $stmt->bindValue(4, $leilao->getProdutoLeiloado()->getId());
        $stmt->bindValue(5, $leilao->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbLeilao.* from tbLeilao';

        $query = $this->pdo->query($sql);
        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayProdutos = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayProdutos;

    }

    public function remover(int $id) : bool {
        
        $sql = 'delete from tbLeilao where id_leilao = ?';
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();

    }

}