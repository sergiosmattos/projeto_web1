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

        $id = $atributos['id_produto'] ?? null;
        
        $obraRepositorio = new ObraRepositorio($this->pdo);
        $obra = $obraRepositorio->findById($atributos['id_obra']);
        
        $produto = new Produto(
            isset($id) ? (int) $id : null,
            $atributos['nome_produto'] ?? '',
            $atributos['descricao_produto'] ?? '',
            (float) ($atributos['preco_produto'] ?? 0),
            $obra,
            $atributos['imagem_produto'] ?? null
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
        
        $sql = 'INSERT INTO tbProduto (nome_produto, descricao_produto, preco_produto, id_obra, imagem_produto) ' .
               'VALUES (?, ?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);
        
        $imagem = $produto->getImagem();
        if ($imagem === null || $imagem === '') {
            $imagem = 'semImagem.png';
        }

        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getDescricao());
        $stmt->bindValue(3, $produto->getPreco());
        $stmt->bindValue(4, $produto->getObra()->getId());
        $stmt->bindValue(5, $imagem);
        
        $stmt->execute();
    }

    public function atualizar(Produto $produto) : void {
        
        $sql = 'UPDATE tbProduto SET
                nome_produto = ?,
                descricao_produto = ?,
                preco_produto = ?,
                id_obra = ?,
                imagem_produto = ?
                WHERE id_produto = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getDescricao());
        $stmt->bindValue(3, $produto->getPreco());
        $stmt->bindValue(4, $produto->getObra()->getId());
        
        $imagem = $produto->getImagem();
        if ($imagem === null || $imagem === '') {
            $stmt->bindValue(5, 'semImagem.png');
        } else {
            $stmt->bindValue(5, $produto->getImagem());
        }
        
        $stmt->bindValue(6, $produto->getId());

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
            
            if ($imagem !== 'semImagem.png') {
                
                $caminho = DIR_PROJETOWEB . 'uploads/produtos/' . $imagem;

                if (is_file($caminho)) {
                    unlink($caminho);
                }
            }
        }

        return $resultadoExecult;
    }

    public function contarTotal(): int {
        $sql = "SELECT COUNT(*) as total FROM tbProduto";
        $stmt = $this->pdo->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }

    public function listarPaginado(int $limite, int $offset, ?string $ordem = null, ?string $direcao = 'ASC'): array {
        $colunasPermitidas = ['nome_produto', 'preco_produto'];
        
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
}