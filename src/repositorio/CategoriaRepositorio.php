<?php

require __DIR__.'/../conexaoBD.php';
require __DIR__.'/../modelo/Categoria.php';

class CategoriaRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Categoria {

        $id = $atributos['id_categoria'];
        
        $categoria = new Categoria(

            isset($id) ? (int) $id : null,
            $atributos['nome_categoria'] ?? '',
            $atributos['imagem_categoria'] ?? null

        );

        return $categoria;

    }

    public function findById(int $id): ?Categoria {

        $sql = 'select tbCategoria.* from tbCategoria where id_categoria = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $categoria = $atributos ? $this->makeObject($atributos) : null;

        return $categoria;

    }

    public function cadastrar(Categoria $categoria) : void {
        
        $sql = 'INSERT INTO tbCategoria (nome_categoria, imagem_categoria) ' .
               'VALUES (?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $imagem = $categoria->getImagem();
        if ($imagem === null || $imagem === '') {
            $imagem = 'semImagem.png';
        }
        
        $stmt->bindValue(1, $categoria->getNome());
        $stmt->bindValue(2, $imagem);

        $stmt->execute();

    }

    public function atualizar(Categoria $categoria) : void {
        
        $sql = 'UPDATE tbCategoria SET
                nome_categoria = ?,
                imagem_categoria = ?
                WHERE id_categoria = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $categoria->getNome());
        
        $imagem = $categoria->getImagem();
        if ($imagem === null || $imagem === '') {
            $stmt->bindValue(2, 'semImagem.png');
        } else {
            $stmt->bindValue(2, $categoria->getImagem());
        }
        
        $stmt->bindValue(3, $categoria->getId());

        $stmt->execute();

    }


    public function listar() : array {
        
        $sql = 'select tbCategoria.* from tbCategoria';

        $query = $this->pdo->query($sql);
        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayCategorias = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayCategorias;

    }

    public function remover(int $id) : bool {
        
        $sql = "SELECT imagem_categoria FROM tbCategoria WHERE id_categoria = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagem = $dados['imagem_categoria'] ?? null;

        $sqlDel = 'DELETE FROM tbCategoria WHERE id_categoria = ?';
        $stmtDel = $this->pdo->prepare($sqlDel);
        $stmtDel->bindValue(1, $id, PDO::PARAM_INT);
        $resultadoExecult = $stmtDel->execute();

        if ($resultadoExecult && $stmtDel->rowCount() > 0 && !empty($imagem)) {
            
            if ($imagem !== 'semImagem.png') {
                
                $caminho = DIR_PROJETOWEB . 'uploads/categorias/' . $imagem;

                if (is_file($caminho)) {
                    unlink($caminho);
                }
            }
        }

        return $resultadoExecult;
    }

    public function contarTotal(): int {
        $sql = "SELECT COUNT(*) as total FROM tbCategoria";
        $stmt = $this->pdo->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }

    public function listarPaginado(int $limite, int $offset, ?string $ordem = null, ?string $direcao = 'ASC'): array {
        $colunasPermitidas = ['nome_categoria'];
        
        $sql = 'SELECT tbCategoria.* FROM tbCategoria';
        
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
        $arrayCategorias = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);
        
        return $arrayCategorias;
    }

}