<?php

require_once __DIR__.'/../conexaoBD.php';
require_once __DIR__.'/../modelo/Produto.php';
require_once __DIR__.'/ObraRepositorio.php';

class ProdutoRepositorio {

    private PDO $pdo;

    private ObraRepositorio $obraRepo;

    public function __construct($pdo, ObraRepositorio $obraRepo) {
        $this->pdo = $pdo;
        $this->obraRepo = $obraRepo;
    }

    public function makeObject(array $atributos) : Produto {

        $id = $atributos['id_produto'] ?? null;
        
        $produto = new Produto(
            isset($id) ? (int) $id : null,
            $atributos['nome_produto'],
            $atributos['descricao_produto'],
            $atributos['quantidade_produto'],
            $atributos['preco_produto'],
            $this->obraRepo->findById($atributos['id_obra']),
            $atributos['imagem_produto'] ?? null
        );

        return $produto;
    }

    public function findById(int $id): ?Produto {

        $sql = 'select * from tbProduto where id_produto = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $produto = $atributos ? $this->makeObject($atributos) : null;

        return $produto;
    }

    public function cadastrar(Produto $produto) : void {
        
        $sql = 'insert into tbProduto (nome_produto, descricao_produto, quantidade_produto, preco_produto, id_obra, imagem_produto) 
        values (?, ?, ?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);
        
        $imagem = $produto->getImagem();
        if ($imagem === null || $imagem === '') {
            $imagem = 'semImagem.png';
        }

        $this->bindStmtValues($stmt, $produto);
        $stmt->bindValue(6, $imagem);
        
        $stmt->execute();
    }

    public function atualizar(Produto $produto) : void {
        
        $sql = 'update tbProduto set
        nome_produto = ?,
        descricao_produto = ?,
        quantidade_produto = ?,
        preco_produto = ?,
        id_obra = ?,
        imagem_produto = ?
        where id_produto = ?';

        $stmt = $this->pdo->prepare($sql);

        $this->bindStmtValues($stmt, $produto);
        
        $imagem = $produto->getImagem();
        if ($imagem === null || $imagem === '') {
            $stmt->bindValue(6, 'semImagem.png');
        } else {
            $stmt->bindValue(6, $produto->getImagem());
        }
        
        $stmt->bindValue(7, $produto->getId());

        $stmt->execute();
    }

    public function listar() : array {
        
        $sql = 'SELECT tbProduto.* FROM tbProduto';

        $query = $this->pdo->query($sql);
        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayProdutos = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayProdutos;
    }

    public function remover(int $id) : bool {
        
        $sql = "SELECT imagem_produto FROM tbProduto WHERE id_produto = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagem = $dados['imagem_produto'] ?? null;

        $sqlDel = 'DELETE FROM tbProduto WHERE id_produto = ?';
        $stmtDel = $this->pdo->prepare($sqlDel);
        $stmtDel->bindValue(1, $id, PDO::PARAM_INT);
        $resultadoExecult = $stmtDel->execute();


        if ($resultadoExecult && $stmtDel->rowCount() > 0 && !empty($imagem)) {
            
            if ($imagem !== 'sem_imagem.png') {
                
                $caminho = DIR_PROJETOWEB . 'uploads/produtos/' . $imagem;

                if (is_file($caminho)) {
                    unlink($caminho);
                }
            }
        }

        return $resultadoExecult;
    }

    private function bindStmtValues(PDOStatement $stmt, Produto $produto) : void {

        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getDescricao());
        $stmt->bindValue(3, $produto->getQuantidade());
        $stmt->bindValue(4, $produto->getPreco());
        $stmt->bindValue(5, $produto->getObra()->getId());
        
    }

    public function contarTotal(): int {
        $sql = "SELECT COUNT(*) as total FROM tbProduto";
        $stmt = $this->pdo->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }

    public function listarPaginado(int $limite, int $offset, ?string $ordem = null, ?string $direcao = 'ASC'): array {
        $colunasPermitidas = ['nome_produto', 'quantidade_produto','preco_produto'];
        
        $sql = 'SELECT tbProduto.* FROM tbProduto';
        
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
        $arrayProdutos = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);
        
        return $arrayProdutos;
    }

    public function listarDestaque(int $limite = 4): array {
    
        $sql = 'SELECT tbProduto.* FROM tbProduto ORDER BY id_produto DESC LIMIT ?';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultadoConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayProdutos = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);
        
        return $arrayProdutos;
    }
}