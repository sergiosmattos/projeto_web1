<?php

require_once __DIR__.'/../modelo/obraleilao.php';
require_once __DIR__.'/UsuarioRepositorio.php';
require_once __DIR__.'/LeilaoRepositorio.php';

class UsuarioLeilaoRepositorio {

    private PDO $pdo;
    private UsuarioRepositorio $usuarioRepo;
    private LeilaoRepositorio $leilaoRepo;

    public function __construct($pdo, UsuarioRepositorio $obraRepo, LeilaoRepositorio $leilaoRepo) {

        $this->pdo = $pdo;
        $this->usuarioRepo = $obraRepo;
        $this->leilaoRepo = $leilaoRepo;

    }

    public function makeObject(array $atributos) : UsuarioLeilao {
        
        $usuarioLeilao = new UsuarioLeilao(

            $this->usuarioRepo->findById($atributos['id_usuario']),
            $this->leilaoRepo->findById($atributos['id_leilao']),
            $atributos['valor_lance']

        );

        return $usuarioLeilao;

    }

    public function findById(int $idUsuario, int $idLeilao): ?UsuarioLeilao {

        $sql = 'select tbUsuarioLeilao.* from tbUsuarioLeilao where id_usuario = ? and id_leilao = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $idUsuario);
        $stmt->bindValue(2, $idLeilao);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $obraLeilao = $atributos ? $this->makeObject($atributos) : null;

        return $obraLeilao;

    }

    public function cadastrar(UsuarioLeilao $obraleilao) : void {
        
        $sql = 'insert into tbUsuarioLeilao (id_usuario, id_leilao, valor_lance)
        values (?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $obraleilao->getUsuario()->getId());
        $stmt->bindValue(2, $obraleilao->getLeilao()->getId());
        $stmt->bindValue(3, $obraleilao->getLance());

        $stmt->execute();

    }

    public function atualizar(UsuarioLeilao $obraleilao) : void {
        
        $sql = 'update tbUsuarioLeilao set
        id_usuario = :idUsuario,
        id_leilao = :idLeilao,
        valor_lance = ?,
        where id_usuario = :idUsuario
        and id_leilao = :idLeilao';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue("idUsuario", $obraleilao->getUsuario()->getId());
        $stmt->bindValue("idLeilao", $obraleilao->getLeilao()->getId());
        $stmt->bindValue(1, $obraleilao->getLance());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbUsuarioLeilao.* from tbUsuarioLeilao';
        
        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayobras = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayobras;

    }

    public function remover(int $idobra, int $idleilao) : bool {
        
        $sql = 'delete from tbUsuarioLeilao where id_usuario = ? and id_leilao = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $idobra);
        $stmt->bindValue(2, $idleilao);
        
        return $stmt->execute();

    }

}