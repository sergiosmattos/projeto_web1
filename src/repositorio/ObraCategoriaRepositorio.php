<?php

require_once __DIR__.'/../modelo/ObraCategoria.php';
require_once __DIR__.'/ObraRepositorio.php';
require_once __DIR__.'/CategoriaRepositorio.php';

class ObraCategoriaRepositorio {

    private PDO $pdo;
    private ObraRepositorio $obraRepo;
    private CategoriaRepositorio $categoriaRepo;

    public function __construct($pdo, ObraRepositorio $obraRepo, CategoriaRepositorio $categoriaRepo) {
        $this->pdo = $pdo;
        $this->obraRepo = $obraRepo;
        $this->categoriaRepo = $categoriaRepo;
    }

    public function makeObject(array $atributos) : ObraCategoria {
        
        $obraCategoria = new ObraCategoria(

            $this->obraRepo->findById($atributos['id_obra']),
            $this->categoriaRepo->findById($atributos['id_categoria'])

        );

        return $obraCategoria;

    }

    public function findById(int $idObra, int $idCategoria): ?ObraCategoria {

        $sql = 'select tbObraCategoria.* from tbObraCategoria where id_obra = ? and id_categoria = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $idObra);
        $stmt->bindValue(2, $idCategoria);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $obraCategoria = $atributos ? $this->makeObject($atributos) : null;

        return $obraCategoria;

    }

    public function cadastrar(ObraCategoria $obraCategoria) : void {
        
        $sql = 'insert into tbObraCategoria (id_obra, id_categoria)
        values (?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $obraCategoria->getObra()->getId());
        $stmt->bindValue(2, $obraCategoria->getCategoria()->getId());

        $stmt->execute();

    }

    public function atualizar(ObraCategoria $obraCategoria) : void {
        
        $sql = 'update tbObraCategoria set
        id_obra = :idObra,
        id_categoria = :idCategoria
        where id_obra = :idObra
        and id_categoria = :idCategoria';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue("idObra", $obraCategoria->getObra()->getId());
        $stmt->bindValue("idCategoria", $obraCategoria->getObra()->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbObraCategoria.* from tbObraCategoria';
        
        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayObras = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayObras;

    }

    public function remover(int $idObra, int $idCategoria) : bool {
        
        $sql = 'delete from tbObraCategoria where id_obra = ? and id_categoria = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $idObra);
        $stmt->bindValue(2, $idCategoria);
        
        return $stmt->execute();

    }

}