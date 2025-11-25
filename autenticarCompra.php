<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CompraRepositorio.php';
    
    session_start();

    $usuarioRepo = new UsuarioRepositorio($pdo);

    $obraRepo = new ObraRepositorio($pdo);
    $produtoRepo = new ProdutoRepositorio($pdo, $obraRepo);

    $compraRepo = new CompraRepositorio($pdo, $usuarioRepo, $produtoRepo);

    $idProduto = $_POST['id_produto'] ?? null;

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: compra.php?id=' . $idProduto);
        exit;
    }
    $idUsuario = $_POST['id_usuario'] ?? null;
    $precoTotal = $_POST['preco_total'] ?? null;
    $qtdEstoque = $_POST['quantidade_estoque'] ?? null;
    $qtdDesejada = $_POST['quantidade_desejada'] ?? '';

    if ($qtdDesejada == '') {

        header("Location: compra.php?id=". $idProduto . "&erro=campos");
        exit;
        
    }

    try {

        $pdo->beginTransaction();

        $usuario = $usuarioRepo->findById($idUsuario);
        $produto = $produtoRepo->findById($idProduto);

        $saldoUsuario = $usuario->getSaldo();

        if($precoTotal > $saldoUsuario) {

            $pdo->rollBack();
            header("Location: compra.php?id=". $idProduto . "&erro=saldo");
            exit;

        }

        if( $produto->getQuantidade() == 0 ) {

            $pdo->rollBack();
            header("Location: compra.php?id=". $idProduto . "&erro=zerado");
            exit;

        }

        $usuario->setSaldo($saldoUsuario - $precoTotal);
        $usuarioRepo->atualizar($usuario);
        
        $produto->setQuantidade($qtdEstoque - $qtdDesejada);
        $produtoRepo->atualizar($produto);

        $compra = new Compra(null, null, $qtdDesejada, $precoTotal, $usuario, $produto);
        $compraRepo->cadastrar($compra);

        $pdo->commit();

        header("Location: compra.php?id=". $idProduto . "&sucesso=novacompra");
        exit;

    } 
    catch (Throwable $th) {

        $pdo->rollBack();
        header("Location: compra.php?id=". $idProduto . "&erro=desconhecido");
        exit;

    }

?>
