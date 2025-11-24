<?php

require_once __DIR__.'/../conexaoBD.php';
require_once __DIR__.'/../modelo/Usuario.php';
class UsuarioRepositorio {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function makeObject(array $atributos) : Usuario {

        $id = $atributos['id_usuario'] ?? null;

        $dataNascimento = $atributos['data_nascimento_usuario'] ?? null;

        $timezone = new DateTimeZone('UTC');
        
        $usuario = new Usuario(

            isset($id) ? (int) $id : null,
            $atributos['tipo_usuario'] ?? 'User',
            $atributos['nome_usuario'],
            isset($dataNascimento) ? new DateTime($dataNascimento, $timezone) : new DateTime('0000-00-00', $timezone),
            $atributos['email_usuario'],
            $atributos['senha_usuario'],
            $atributos['saldo_usuario'],
            $atributos['imagem_usuario']

        );

        return $usuario;

    }

    public function findById(int $id): ?Usuario {

        $sql = 'select tbUsuario.* from tbUsuario where id_usuario = ? limit 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario = $atributos ? $this->makeObject($atributos) : null;
        
        return $usuario;

    }

    public function findByEmail(string $email) : ?Usuario {
        
        $sql = 'SELECT * FROM tbUsuario WHERE email_usuario = ? LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $atributos = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario = $atributos ? $this->makeObject($atributos) : null;

        return $usuario;

    }

    public function cadastrar(Usuario $usuario) : void {
        
        $sql = 'insert into tbUsuario (tipo_usuario, nome_usuario, email_usuario, senha_usuario, data_nascimento_usuario, saldo_usuario, imagem_usuario) '.
        'values (?, ?, ?, ?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($sql);

        $imagem = $usuario->getImagem();

        if ( $imagem === null || $imagem === '' ) {
            $imagem = 'icon_user_branco.svg';
        }

        $this->bindStmtValues($stmt, $usuario);
        $stmt->bindValue(7, $imagem);

        $stmt->execute();

    }

    public function atualizar(Usuario $usuario) : void {
        
        $sql = 'UPDATE tbUsuario SET 
        tipo_usuario = ?, 
        nome_usuario = ?, 
        email_usuario = ?, 
        senha_usuario = ?, 
        data_nascimento_usuario = ? ,
        saldo_usuario = ?,
        imagem_usuario = ?
        WHERE id_usuario = ?';


        $stmt = $this->pdo->prepare($sql);

        $this->bindStmtValues($stmt, $usuario);

        $imagem = $usuario->getImagem();
        if ( $imagem === null || $imagem === '' ) {
            $stmt->bindValue(7, 'icon_user_branco.svg');
        } else {
            $stmt->bindValue(7, $usuario->getImagem());
        }

        $stmt->bindValue(8, $usuario->getId());
        
        $stmt->execute();

    }

    public function listar() : array {
        
        $sql = 'select tbUsuario.* from tbUsuario';

        $query = $this->pdo->query($sql);

        $resultadoConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayUsuarios = array_map(fn($linhaConsulta) => $this->makeObject($linhaConsulta), $resultadoConsulta);

        return $arrayUsuarios;

    }

    public function remover(int $id) : bool
    {

        $sql = "SELECT imagem_usuario FROM tbUsuario WHERE id_usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagem = $dados['imagem_usuario'] ?? null;


        $sqlDel = "DELETE FROM tbUsuario WHERE id_usuario = ?";
        $stmtDel = $this->pdo->prepare($sqlDel);
        $stmtDel->bindValue(1, $id);
        $resultadoExecult = $stmtDel->execute();

        if ( $resultadoExecult && $stmtDel->rowCount() > 0 && !empty($imagem) ) {

            
            if ($imagem !== 'icon_user_branco.svg') {

                $caminho = DIR_PROJETOWEB . 'uploads/' . $imagem;

                if (is_file($caminho)) {
                    unlink($caminho);
                }
            }
        }

        return $resultadoExecult;
    }

    private function bindStmtValues(PDOStatement $stmt, Usuario $usuario) {

        $stmt->bindValue(1, $usuario->getTipo());
        $stmt->bindValue(2, $usuario->getNome());
        $stmt->bindValue(3, $usuario->getEmail());
        $stmt->bindValue(4, $usuario->getSenha());
        $stmt->bindValue(5, $usuario->getDataNascimento()->format('Y-m-d'));
        $stmt->bindValue(6, $usuario->getSaldo());

    }

    public function autenticarByEmailSenha(string $email, string $senha) : bool {
        
        // $isPasswordOk = $usuarioEncontrado ? $usuarioEncontrado->getSenha() === $senha : false ;
        // //$isPasswordOk = $usuarioEncontrado ? password_verify($usuarioEncontrado->getSenha, $senhaUsuario) === $senha : false ;
        // return $isPasswordOk;

        $usuarioEncontrado = $this->findByEmail($email);
        
        if (!$usuarioEncontrado) {
            return false;
        }

        $senhaUsuario = $usuarioEncontrado->getSenha();

        //$isPasswordOk = password_verify($senha, $senhaUsuario);
        $isPasswordOk = $senhaUsuario === $senha;

        return $isPasswordOk;

    }

    public function contarTotal(): int {
        $sql = "SELECT COUNT(*) as total FROM tbUsuario";
        $stmt = $this->pdo->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }

    public function listarPaginado(int $limite, int $offset, ?string $ordem = null, ?string $direcao = 'ASC'): array {
        
        $colunasPermitidas = ['nome_usuario'];
        
        $sql = 'SELECT tbUsuario.* FROM tbUsuario';
        
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